<?php

namespace App\Filament\Resources\CourseSeos\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CourseSeoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
               Select::make('course_id')
                        ->relationship('course', 'title', fn ($query) => $query->with('teacher'))
                        ->searchable()
                        ->preload()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->disabledOn('edit')
                        ->columnSpanFull(),
                TextInput::make('meta_title')
                        ->label('Meta Title')
                        ->maxLength(70)
                        ->helperText('Recommended: 60–70 characters')
                        ->live(debounce: 500)
                        ->afterStateUpdated(fn ($state, $set, $get) =>
                            $set('og_title', $state ?? $get('course.title'))
                        ),
                Textarea::make('meta_description')
                        ->label('Meta Description')
                        ->rows(3)
                        ->maxLength(160)
                        ->helperText('Recommended: 155–160 characters')
                        ->live(debounce: 500)
                        ->afterStateUpdated(fn ($state, $set, $get) =>
                            $set('og_description', $state ?? Str::limit(strip_tags($get('course.syllabus')), 200))
                        ),
                TagsInput::make('meta_keywords')
                        ->placeholder('Add keyword')
                        ->separator(',')
                        ->suggestions([
                            'laravel course', 'php training', 'web development', 'online certification'
                        ]),
                TextInput::make('og_title')
                    ->default(null),
                TextInput::make('og_description')
                    ->default(null),
               FileUpload::make('og_image')
                        ->image()
                        ->imageEditor()
                        ->disk('public')
                        ->directory('seo/og')
                        ->maxSize(5120)
                        ->helperText('Recommended: 1200x630px'),
                Select::make('og_type')
                        ->options([
                            'website' => 'Website',
                            'article' => 'Article',
                            'product' => 'Product',
                            'course'  => 'Course',
                        ])
                        ->default('course'),
                TextInput::make('twitter_title')
                    ->default(null),
                TextInput::make('twitter_description')
                    ->default(null),
                FileUpload::make('twitter_image')
                    ->image(),
                Select::make('twitter_card')
                        ->options([
                            'summary'             => 'Summary',
                            'summary_large_image' => 'Summary Large Image',
                            'app'                 => 'App',
                            'player'              => 'Player',
                        ])
                        ->default('summary_large_image'),
                TextInput::make('canonical_url')
                            ->prefix(url('/courses/'))
                            ->placeholder('custom-slug')
                            ->helperText('Leave empty for default'),
                Toggle::make('noindex')
                    ->required(),
                Toggle::make('nofollow')
                    ->required(),
                Textarea::make('structured_data')
                    ->default(null)
                    ->columnSpanFull(),
               TextInput::make('seo_h1')
                            ->label('Custom H1 Heading')
                            ->maxLength(100)
                            ->helperText('Overrides default <h1>{{ course.title }}</h1>'),
                Textarea::make('faq_schema')
                    ->default(null)
                    ->columnSpanFull(),
                Textarea::make('breadcrumb_override')
                    ->default(null)
                    ->columnSpanFull(),
            ]);
    }
}
