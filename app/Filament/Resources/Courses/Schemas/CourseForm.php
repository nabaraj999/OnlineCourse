<?php

namespace App\Filament\Resources\Courses\Schemas;

use App\Models\Teacher;
use App\Models\Company;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
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
                    ->required()
                    ->maxLength(100)
                    ->placeholder('Enter course title')
                    ->helperText('Maximum 100 characters'),

                Select::make('teacher_id')
                    ->relationship('teacher', 'name') // Assumes Teacher model has a 'name' column
                    ->required()
                    ->searchable()
                    ->preload()
                    ->helperText('Select the course teacher'),

                Select::make('company_id')
                    ->relationship('company', 'name') // Assumes Company model has a 'name' column
                    ->required()
                    ->searchable()
                    ->preload()
                    ->helperText('Select the associated company'),

                Select::make('discount_id')
                    ->relationship('discount', 'value') // Assumes Discount model has a 'value' column
                    ->nullable()
                    ->searchable()
                    ->preload()
                    ->helperText('Select a discount (optional)'),

                DatePicker::make('start_date')
                    ->required()
                    ->maxDate(now()->addYear())
                    ->displayFormat('Y-m-d')
                    ->helperText('Select the course start date'),

                DatePicker::make('end_date')
                    ->maxDate(now()->addYears(2))
                    ->displayFormat('Y-m-d')
                    ->helperText('Optional end date for the course'),

                TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(99999.99)
                    ->prefix('$')
                    ->helperText('Enter the course price (max $99,999.99)'),

                TextInput::make('total_seats')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->maxValue(1000)
                    ->helperText('Total available seats (max 1000)'),

                TextInput::make('enrolled_seats')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(fn ($get) => $get('total_seats') ?? 1000)
                    ->default(0)
                    ->helperText('Number of enrolled students (cannot exceed total seats)'),

                TimePicker::make('daily_time')
                    ->helperText('Set the daily schedule time (optional)'),

                RichEditor::make('syllabus')
                    ->nullable()
                    ->maxLength(10000)
                    ->columnSpanFull()
                    ->helperText('Enter the course syllabus (max 10,000 characters)'),

                FileUpload::make('photo')
                    ->nullable()
                    ->image()
                    ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml'])
                    ->maxSize(2048)
                    ->directory('course-photos')
                     ->disk('public')
                    ->helperText('Upload a course photo (max 2MB, PNG/JPEG/SVG)'),

                Select::make('active_status')
                    ->options(['active' => 'Active', 'no' => 'No'])
                    ->default('active')
                    ->required()
                    ->helperText('Set the course status'),

                TextInput::make('rating')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(10)
                    ->default(0.0)
                    ->step(0.1)
                    ->helperText('Enter rating between 0.0 and 10.0'),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(100)
                    ->unique(ignoreRecord: true)
                    ->helperText('Unique URL slug for the course (max 100 characters)'),
            ]);
    }
}
