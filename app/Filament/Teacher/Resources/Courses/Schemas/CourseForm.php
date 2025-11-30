<?php

namespace App\Filament\Teacher\Resources\Courses\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TimePicker;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('teacher_id')
                    ->required()
                    ->numeric(),
                TextInput::make('company_id')
                    ->required()
                    ->numeric(),
                TextInput::make('discount_percentage')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                DatePicker::make('discount_valid_from'),
                DatePicker::make('discount_valid_to'),
                DatePicker::make('start_date')
                    ->required(),
                DatePicker::make('end_date'),
                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('$'),
                TextInput::make('total_seats')
                    ->required()
                    ->numeric(),
                TextInput::make('enrolled_seats')
                    ->required()
                    ->numeric()
                    ->default(0),
                TimePicker::make('daily_time'),
                Textarea::make('syllabus')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('photo')
                    ->default(null),
                Select::make('active_status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                    ->default('inactive')
                    ->required(),
                TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('slug')
                    ->required(),
            ]);
    }
}
