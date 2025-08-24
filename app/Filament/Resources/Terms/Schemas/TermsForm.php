<?php
namespace App\Filament\Resources\Terms\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TermsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(100)
                    ->label('Title'),
                Toggle::make('active')
                    ->required()
                    ->default(false)
                    ->label('Active'),
                RichEditor::make('description')
                    ->required()
                    ->maxLength(1000)
                    ->label('Description')
                    ->columnSpanFull(), // Makes it full-width
            ]);
    }
}
