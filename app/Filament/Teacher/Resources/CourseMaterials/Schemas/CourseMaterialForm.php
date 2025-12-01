<?php

namespace App\Filament\Teacher\Resources\CourseMaterials\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;

class CourseMaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->label('Course')
                    ->relationship(
                        name: 'course',
                        titleAttribute: 'title',

                    )
                    ->searchable()
                    ->preload()
                    ->required()
                    ->reactive(),
                TextInput::make('uploaded_by')
                    ->label('Uploaded By (Teacher ID)')
                    ->numeric()
                    ->default(null),
                Select::make('type')
                    ->options([
                        'ppt' => 'Ppt',
                        'pdf' => 'Pdf',
                        'video' => 'Video',
                        'image' => 'Image',
                        'assignment' => 'Assignment',
                        'note' => 'Note',
                        'link' => 'Link',
                        'other' => 'Other',
                    ])
                    ->default('other')
                    ->required()
                    ->reactive(),
                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),
                Textarea::make('description')
                    ->label('Description (Optional)')
                    ->rows(3)
                    ->columnSpanFull(),
                FileUpload::make('file_path')
                    ->label('Upload File')
                    ->directory('course-materials')
                    ->disk('public')
                    ->acceptedFileTypes([
                        'application/pdf',
                        'application/vnd.ms-powerpoint',
                        'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                        'video/mp4',
                        'video/quicktime',
                        'image/jpeg',
                        'image/png',
                        'image/webp',
                    ])
                    ->maxSize(902400) // 100MB
                    ->downloadable()
                    ->openable()
                    ->preserveFilenames()
                    ->nullable()
                    ->hint('PDF, PPT, Video, Image supported'),
                TextInput::make('external_url')
                    ->label('External Link')
                    ->url()
                    ->prefix('https://')
                    ->placeholder('https://youtube.com/watch?v=...')
                    ->nullable()
                    ->hint('Use this instead of uploading a file'),
                DatePicker::make('resource_date')
                    ->label('Date of Class/Session')
                    ->displayFormat('d F Y')
                    ->nullable(),
                TextInput::make('sort_order')
                    ->label('Sort Order')
                    ->numeric()
                    ->minValue(0)
                    ->default(0)
                    ->helperText('Higher number = appears lower'),
                Toggle::make('is_published')
                    ->label('Publish to Students')
                    ->helperText('Uncheck to hide from students')
                    ->default(true)
                    ->inline(false),
            ]);
    }
}
