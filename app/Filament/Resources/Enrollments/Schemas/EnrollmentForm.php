<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class EnrollmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               Select::make('course_id')
                            ->relationship('course', 'title', fn ($query) => $query->where('active_status', 'active'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn ($state, $set) => $set('amount_paid', optional(\App\Models\Course::find($state))?->discounted_price_npr ?? 0)),
                Select::make('payment_method_id')
                            ->relationship('paymentMethod', 'method_name')
                            ->searchable()
                            ->preload()
                            ->required(),
                TextInput::make('full_name')
                            ->required()
                            ->maxLength(255),

                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255),
                TextInput::make('phone')
                            ->tel()
                            ->telRegex('/^[+]*[(]?[0-9]{1,4}[)]?[-\s\.\/0-9]*$/')
                            ->required(),

                        TextInput::make('reference_code')
                            ->label('Transaction Reference')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50),
                FileUpload::make('screenshot_path')
                        ->label('Payment Screenshot')
                        ->image()
                        ->disk('public')
                        ->directory('enrollments/screenshots')
                        ->visibility('public')
                        ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg'])
                        ->maxSize(5120) // 5MB
                        ->imagePreviewHeight('250')
                        ->required()
                        ->helperText('Upload clear screenshot of payment transaction.'),
               TextInput::make('amount_paid')
                            ->label('Amount Paid (NPR)')
                            ->numeric()
                            ->prefix('NPR')
                            ->required()
                            ->helperText(fn ($get) => $get('course_id')
                                ? 'Course price: NPR ' . (\App\Models\Course::find($get('course_id'))?->discounted_price_npr ?? 0)
                                : 'Select course first'),

                        Select::make('status')
                            ->options([
                                'pending'   => 'Pending',
                                'approved'  => 'Approved',
                                'rejected'  => 'Rejected',
                            ])
                            ->default('pending')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, $record, $set) {
                                if ($state === 'approved' && $record && !$record->wasRecentlyCreated) {
                                    // Auto-increment seats when approved
                                    DB::transaction(function () use ($record) {
                                        $course = $record->course;
                                        $course->lockForUpdate();
                                        if ($course->total_seats > $course->enrolled_seats) {
                                            $course->increment('enrolled_seats');
                                        }
                                    });
                                }
                            }),

                        DateTimePicker::make('enrolled_at')
                            ->default(now())
                            ->required(),

                            TextInput::make('plain_password')
                            ->label('Password (Visible)')
                            ->dehydrated(false)
                            ->readOnly()
                            ->placeholder(fn ($record) => $record?->plain_password ?? 'Will be generated on save'),

                            TextInput::make('password')
                        ->password()
                        ->hidden()
                        ->dehydrated(fn ($state, $record) => filled($state) || !$record?->exists)
                        ->default(fn () => Hash::make(Str::upper(Str::random(8)))),
            ]);
    }
}
