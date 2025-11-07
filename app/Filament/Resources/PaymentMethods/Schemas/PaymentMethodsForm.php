<?php

namespace App\Filament\Resources\PaymentMethods\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Illuminate\Support\Str;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class PaymentMethodsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('method_name')
                    ->required()
                    ->maxLength(100)
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, $set) => $set('slug', Str::slug($state))),
                TextInput::make('slug')
                    ->disabled()
                    ->dehydrated()
                    ->unique(ignoreRecord: true)
                    ->maxLength(100),
                Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull()
                    ->hint('Optional internal notes'),
                TextInput::make('account_holder')
                    ->required()
                    ->maxLength(100),
                TextInput::make('account_number')
                    ->required()
                    ->label('Account Number / Mobile / ID')
                    ->maxLength(50),
                FileUpload::make('qr_code')
                    ->image()
                    ->disk('public')
                    ->directory('qr')
                    ->preserveFilenames()
                    ->maxSize(5120)
                    ->imagePreviewHeight('250')
                    ->label('QR Code')
                    ->helperText('Upload PNG/JPG → stored in public/storage/qr/'),
                RichEditor::make('instructions')
                    ->toolbarButtons([
                        ['bold', 'italic', 'underline', 'strike', 'subscript', 'superscript', 'link'],
                        ['h2', 'h3', 'alignStart', 'alignCenter', 'alignEnd'],
                        ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                        ['table', 'attachFiles'], // The `customBlocks` and `mergeTags` tools are also added here if those features are used.
                        ['undo', 'redo'],
                    ])
                    ->columnSpanFull()
                    ->hint('Use [[amount]] to show dynamic price')
                    ->placeholder('Enter payment steps...'),
                Toggle::make('active')
                    ->default(true)
                    ->inline(false),
                TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Lower = appears first in dropdown'),
            ]);
    }
}
