<?php

namespace App\Filament\Resources\Companies\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section as ComponentsSection;
use Filament\Schemas\Schema;
use League\CommonMark\Extension\Table\TableSection;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                ComponentsSection::make('Basic Information')
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Enter company name'),
                        Textarea::make('description')
                            ->default(null)
                            ->maxLength(1000)
                            ->placeholder('Describe your company')
                            ->columnSpanFull(),
                        Select::make('company_type')
                            ->options([
                                'private' => 'Private',
                                'public' => 'Public',
                                'non_profit' => 'Non-Profit',
                                'government' => 'Government',
                                'startup' => 'Startup',
                            ])
                            ->default(null)
                            ->searchable(),
                        DatePicker::make('founded_date')
                            ->maxDate(now())
                            ->displayFormat('Y-m-d'),
                    ])
                    ->collapsible(),

                ComponentsSection::make('Contact Information')
                    ->schema([
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->default(null)
                            ->maxLength(255)
                            ->placeholder('company@example.com'),
                        TextInput::make('phone_number')
                            ->tel()
                            ->default(null)
                            ->maxLength(20)
                            ->placeholder('+1234567890'),
                        TextInput::make('website_url')
                            ->default(null)
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://www.example.com'),
                        Textarea::make('address')
                            ->default(null)
                            ->maxLength(500)
                            ->placeholder('Enter full address')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),

                ComponentsSection::make('Branding')
                    ->schema([
                        FileUpload::make('logo')
                            ->image()
                            ->default(null)
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/svg+xml'])
                            ->maxSize(2048)
                            ->directory('company-logos'),
                        FileUpload::make('background_image')
                            ->image()
                            ->default(null)
                            ->acceptedFileTypes(['image/png', 'image/jpeg'])
                            ->maxSize(4096)
                            ->directory('company-backgrounds'),
                        FileUpload::make('favicon')
                            ->image()
                            ->default(null)
                            ->acceptedFileTypes(['image/x-icon', 'image/png'])
                            ->maxSize(512)
                            ->directory('company-favicons'),
                    ])
                    ->collapsible(),

                ComponentsSection::make('Social Media')
                    ->schema([
                        TextInput::make('facebook_url')
                            ->default(null)
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://facebook.com/company'),
                        TextInput::make('instagram_url')
                            ->default(null)
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://instagram.com/company'),
                        TextInput::make('youtube_url')
                            ->default(null)
                            ->url()
                            ->maxLength(255)
                            ->placeholder('https://youtube.com/company'),
                        TextInput::make('twitter_handle')
                            ->default(null)
                            ->maxLength(15)
                            ->placeholder('@company'),
                    ])
                    ->collapsible(),

                ComponentsSection::make('Business Details')
                    ->schema([
                        TextInput::make('registration_number')
                            ->default(null)
                            ->maxLength(50)
                            ->placeholder('Enter registration number'),
                        TextInput::make('pan_number')
                            ->default(null)
                            ->maxLength(50)
                            ->placeholder('Enter PAN number'),
                        TextInput::make('employee_count')
                            ->numeric()
                            ->default(null)
                            ->minValue(0)
                            ->placeholder('Number of employees'),
                    ])
                    ->collapsible(),

                ComponentsSection::make('Communication Channels')
                    ->schema([
                        TextInput::make('whatsapp_number')
                            ->default(null)
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('+1234567890'),
                        TextInput::make('viber_number')
                            ->default(null)
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('+1234567890'),
                        TextInput::make('telegram_handle')
                            ->default(null)
                            ->maxLength(32)
                            ->placeholder('@company'),
                    ])
                    ->collapsible(),

                ComponentsSection::make('Operating Status')
                    ->schema([
                        Toggle::make('is_active')
                            ->label('Active Status')
                            ->default(true)
                            ->helperText('Toggle to indicate if the company is currently active'),
                        Textarea::make('operating_hours')
                            ->default(null)
                            ->maxLength(500)
                            ->placeholder('e.g., Mon-Fri: 9AM-5PM')
                            ->columnSpanFull(),
                    ])
                    ->collapsible(),
            ]);
    }
}
