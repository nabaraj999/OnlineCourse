<?php

namespace App\Filament\Resources\Seos\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class SeoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('entity_type')
                    ->label('Entity Type')
                    ->required()
                    ->placeholder('e.g., article, page, product')
                    ->hint('Specify the type of content.'),
                TextInput::make('title')
                    ->label('SEO Title')
                    ->required()
                    ->maxLength(60)
                    ->placeholder('Enter the SEO title')
                    ->hint('Max 60 characters for optimal SEO.'),
                Textarea::make('description')
                    ->label('Meta Description')
                    ->required()
                    ->maxLength(160)
                    ->placeholder('Enter a brief description of the page')
                    ->hint('Max 160 characters.')
                    ->columnSpanFull(),
                TextInput::make('keywords')
                    ->label('Keywords')
                    ->required()
                    ->placeholder('e.g., seo, marketing, web')
                    ->hint('Comma-separated keywords.'),
                TextInput::make('slug')
                    ->label('URL Slug')
                    ->required()
                    ->placeholder('e.g., my-page-title')
                    ->hint('Unique URL-friendly identifier.'),
                TextInput::make('canonical_url')
                    ->default(null),
                TextInput::make('og_title')
                    ->label('Open Graph Title')
                    ->placeholder('Enter the Open Graph title')
                    ->hint('Title for social media shares.'),
                Textarea::make('og_description')
                    ->label('Open Graph Description')
                    ->placeholder('Enter the Open Graph description')
                    ->hint('Description for social media shares.')
                    ->columnSpanFull(),
                FileUpload::make('og_image')
                    ->label('Open Graph Image')
                    ->image()
                    ->hint('Recommended size: 1200x630px.'),
                TextInput::make('twitter_card')
                    ->label('Twitter Card Type')
                    ->placeholder('e.g., summary, summary_large_image')
                    ->hint('Specify Twitter card type.'),
                TextInput::make('twitter_title')
                    ->label('Twitter Title')
                    ->placeholder('Enter the Twitter title')
                    ->hint('Title for Twitter shares.'),
                Textarea::make('twitter_description')
                    ->label('Twitter Description')
                    ->placeholder('Enter the Twitter description')
                    ->hint('Description for Twitter shares.')
                    ->columnSpanFull(),
                FileUpload::make('twitter_image')
                    ->label('Twitter Image')
                    ->image()
                    ->hint('Recommended size: 1200x675px.'),
                Toggle::make('noindex')
                    ->label('Noindex')
                                    ->required()
                                    ->hint('Prevent search engine indexing.'),
                Toggle::make('nofollow')
                    ->label('Nofollow')
                    ->required()
                    ->hint('Prevent search engines from following links.'),
                TextInput::make('robots_txt_directives')
                     ->label('Robots.txt Directives')
                                ->placeholder('e.g., Disallow: /private/')
                                ->hint('Custom robots.txt instructions.')
                                ->columnSpanFull(),
                TextInput::make('sitemap_priority')
                    ->label('Sitemap Priority')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(1)
                                    ->default(0.5)
                                    ->placeholder('e.g., 0.5')
                                    ->hint('Value between 0.0 and 1.0.'),
                DateTimePicker::make('last_modified'),
                Textarea::make('schema_markup')
                     ->label('Schema Markup')
                            ->placeholder('Enter JSON-LD schema markup')
                            ->hint('Structured data for search engines.')
                            ->columnSpanFull(),
                TextInput::make('alt_text')
                    ->default(null),
                TextInput::make('hreflang')
                    ->label('Hreflang')
                                    ->placeholder('e.g., en-us')
                                    ->hint('Language and region code.'),
            ]);
    }
}
