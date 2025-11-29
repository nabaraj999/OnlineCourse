<?php

namespace App\Filament\Resources\Suggestions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class SuggestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
Select::make('enrollment_id')
                        ->label('Student Enrollment')
                        ->relationship(
                            name: 'enrollment',
                            titleAttribute: 'full_name', // This shows the student's name!
                            modifyQueryUsing: fn (Builder $query) => $query->where('status', 'approved')
                        )
                        ->searchable(['full_name', 'email', 'phone', 'reference_code'])
                        ->preload()
                        ->required()
                        ->placeholder('Search by name, email, phone or reference code...')
                        ->getOptionLabelFromRecordUsing(fn ($record) => "{$record->full_name} ({$record->reference_code}) - {$record->course->name}")
                        ->helperText('Only approved enrollments can submit suggestions.'),
                TextInput::make('subject')

                    ->required(),
                Textarea::make('message')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),

                Select::make('status')
                    ->options([
                        'pending'   => 'Pending',
                        'reviewed'  => 'Reviewed',
                        'resolved'  => 'Resolved',
                    ])
                    ->default('pending')
                    ->required(),
                DateTimePicker::make('reviewed_at'),
                Textarea::make('admin_reply')
                    ->label('Admin Reply')
                    ->rows(4)
                    ->columnSpanFull(),
            ]);
    }
}
