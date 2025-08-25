<?php

namespace App\Filament\Teacher\Resources\Teachers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([

            TextInput::make('name')
                ->label('Full Name')
                ->required()
                ->maxLength(255)
                ->placeholder('John Doe'),

            TextInput::make('email')
                ->label('Email Address')
                ->email()
                ->required()
                ->maxLength(255)
                ->placeholder('john.doe@example.com')
                ->unique(table: 'teachers', column: 'email', ignoreRecord: true),

            FileUpload::make('logo')
                ->label('Profile Picture')
                ->image()
                ->directory('teacher-profiles')
                ->maxSize(2048)
                ->imageEditor()
                ->imageCropAspectRatio('1:1')
                ->previewable(true)
                ->extraAttributes(['class' => 'bg-white rounded-lg shadow-sm'])
                ->nullable()
                ->hint('Upload a professional headshot (max 2MB).')
                ->dehydrated(true),

            TextInput::make('phone')
                ->label('Phone Number')
                ->tel()
                ->placeholder('+1 (123) 456-7890')
                ->maxLength(20)
                ->nullable(),

            TextInput::make('address')
                ->label('Address')
                ->placeholder('123 Main St, City, Country')
                ->maxLength(255)
                ->nullable(),

            TextInput::make('website')
                ->label('Website')
                ->url()
                ->placeholder('https://example.com')
                ->maxLength(255)
                ->nullable(),

            TextInput::make('subject')
                ->label('Subject Taught')
                ->placeholder('e.g., Graphic Design, Laravel Development')
                ->maxLength(100)
                ->nullable(),

            RichEditor::make('bio')
                ->label('Biography')
                ->placeholder('Tell us about yourself...')
                ->maxLength(2000)
                ->columnSpanFull()
                ->nullable(),

            Textarea::make('experience')
                ->label('Teaching Experience')
                ->placeholder('Describe your teaching experience...')
                ->rows(5)
                ->maxLength(5000)
                ->columnSpanFull()
                ->nullable(),
        ]);
    }
}
