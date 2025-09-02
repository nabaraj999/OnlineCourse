<?php

namespace App\Filament\Resources\Courses\Schemas;

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
                    ->label('Course Title')
                    ->required()
                    ->maxLength(100)
                    ->placeholder('Enter the course title')
                    ->columnSpan(2)
                    ->helperText('Maximum 100 characters')
                    ->autofocus()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        $set('slug', str()->slug($state));
                    }),
                Select::make('teacher_id')
                    ->label('Teacher')
                    ->relationship('teacher', 'name')
                    ->required()
                    ->searchable()
                    ->placeholder('Select a teacher'),
                Select::make('company_id')
                    ->label('Company')
                    ->relationship('company', 'name')
                    ->required()
                    ->searchable()
                    ->placeholder('Select a company'),
                TextInput::make('discount_percentage')
                    ->label('Discount (%)')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->minValue(0)
                    ->maxValue(100)
                    ->step(0.1)
                    ->suffix('%')
                    ->placeholder('Enter discount percentage'),
                DatePicker::make('discount_valid_from')
                    ->label('Discount Valid From')
                    ->nullable(),
                DatePicker::make('discount_valid_to')
                    ->label('Discount Valid To')
                    ->nullable(),
                DatePicker::make('start_date')
                    ->label('Course Start Date')
                    ->required()
                    ->displayFormat('d M Y'),
                DatePicker::make('end_date')
                    ->label('Course End Date')
                    ->required()
                    ->displayFormat('d M Y'),
                TextInput::make('price')
                    ->label('Price (NPR)')
                    ->required()
                    ->numeric()
                    ->prefix('NPR ')
                    ->step(0.01)
                    ->placeholder('Enter price in NPR')
                    ->rules(['regex:/^\d{1,10}(\.\d{1,2})?$/']),
                TextInput::make('total_seats')
                    ->label('Total Seats')
                    ->required()
                    ->numeric()
                    ->minValue(1)
                    ->placeholder('Enter total available seats'),
                TextInput::make('enrolled_seats')
                    ->label('Enrolled Seats')
                    ->required()
                    ->numeric()
                    ->default(0)
                    ->maxValue(fn($get) => $get('total_seats'))
                    ->placeholder('Enter enrolled seats'),

                TimePicker::make('daily_time')
                    ->label('Daily Time')
                    ->nullable()
                    ->seconds(false)
                    ->displayFormat('h:i A'),

            RichEditor::make('syllabus')
    ->label('Syllabus')
    ->nullable()
    ->columnSpanFull()
    ->placeholder('Describe the course syllabus')
    ->helperText('Provide a detailed overview of the course content')
    ->extraAttributes(['style' => 'min-height: 200px;']),
                FileUpload::make('photo')
                    ->label('Course Photo')
                    ->nullable()
                    ->directory('company-logos')
                    ->disk('public')
                    ->preserveFilenames()
                        ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml'])
                    ->image()
                    ->maxSize(2048) // 2MB max
                    ->helperText('Upload an image (max 2MB). Recommended size: 800x600px.')
                    ->columnSpan(2),
                Select::make('active_status')
                    ->label('Status')
                    ->options(['active' => 'Active', 'inactive' => 'Inactive'])
                    ->default('inactive')
                    ->required()
                    ->columnSpan(1),
                TextInput::make('rating')
                    ->label('Rating')
                    ->required()
                    ->numeric()
                    ->default(0.0)
                    ->minValue(0)
                    ->maxValue(10)
                    ->step(0.1)
                    ->suffix('/10')
                    ->placeholder('Enter course rating'),
                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(100)

                    ->helperText('Automatically generated from title'),
            ]);
    }
}
