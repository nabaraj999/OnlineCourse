<?php

namespace App\Filament\Resources\Teachers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // personal information can't change by admin
                TextInput::make('name')
                    ->required()
                    ->disabled(),

                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->disabled()
                    ->required(),
                FileUpload::make('logo')
                ->disabled()
                    ->default(null),
                TextInput::make('phone')
                ->disabled()
                    ->tel()
                    ->default(null),
                TextInput::make('address')
                ->disabled()
                    ->default(null),
                TextInput::make('subject')
                ->disabled()
                    ->default(null),
                TextInput::make('bio')
                   ->disabled()
                    ->default(null),
                TextInput::make('website')
                ->disabled()
                    ->default(null),
                Textarea::make('experience')
                ->disabled()
                    ->default(null)
                    ->columnSpanFull(),

               Select::make('account_status')
                  ->options([
                    'active' => 'Active',
                    'inactive' => 'Inactive',

                ])
            ]);
    }
}
