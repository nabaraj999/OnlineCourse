<?php

namespace App\Filament\Resources\Certificates\Schemas;

use App\Models\Certificate;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class CertificateForm
{
    public static function configure(Schema $schema): Schema
    {
       return $schema
            ->schema([
                // ──────────────────────────────
                // Student & Course Selection
                // ──────────────────────────────
               Section::make('Student Enrollment')
                    ->description('Select an approved enrollment to issue a certificate')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Select::make('enrollment_id')
                            ->label('Student')
                            ->relationship(
                                name: 'enrollment',
                                titleAttribute: 'full_name',
                                modifyQueryUsing: fn (Builder $query) => $query
                                    ->where('status', 'approved')
                                    ->with(['course'])
                            )
                            ->getOptionLabelFromRecordUsing(fn ($record) =>
                                "{$record->full_name} – {$record->course->title} ({$record->email})"
                            )
                            ->searchable(['full_name', 'email', 'phone'])
                            ->preload()
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $enrollment = \App\Models\Enrollment::find($state);
                                    $set('course_id', $enrollment?->course_id);
                                } else {
                                    $set('course_id', null);
                                }
                            }),

                        TextInput::make('course_id')
                            ->label('Course')
                            ->disabled()
                            ->dehydrated()
                            ->formatStateUsing(fn ($state) =>
                                $state ? \App\Models\Course::find($state)?->title ?? '—' : '—'
                            ),
                    ])
                    ->columns(1),

                // ──────────────────────────────
                // Certificate Details
                // ──────────────────────────────
                Section::make('Certificate Details')
                    ->icon('heroicon-o-document-check')
                    ->schema([
                        Toggle::make('is_issued')
                            ->label('Certificate Issued')
                            ->reactive()
                            ->default(false)
                            ->helperText('Turn on to issue the certificate'),

                        DateTimePicker::make('issued_at')
                            ->label('Issued Date')
                            ->visible(fn (callable $get) => $get('is_issued'))
                            ->required(fn (callable $get) => $get('is_issued'))
                            ->default(now())
                            ->maxDate(now()),

                        DateTimePicker::make('completed_at')
                            ->label('Course Completion Date')
                            ->default(now())
                            ->required(),

                        TextInput::make('certificate_number')
                            ->label('Certificate Number')
                            ->unique(table:Certificate::class, ignoreRecord: true)
                            ->maxLength(50)
                            ->placeholder('Auto-generated on save (e.g., CERT-2025-000123)')
                            ->helperText('Leave empty to auto-generate a unique number')
                            ->disabled(fn (callable $get) => $get('is_issued') == false),
                    ])
                    ->columns(2),
            ]);
    }
}
