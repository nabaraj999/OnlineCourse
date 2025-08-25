<?php

namespace App\Filament\Teacher\Resources\Teachers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TeachersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([


                TextColumn::make('name')
                    ->label('Full Name')
                    ->formatStateUsing(fn($state) => '<span class="font-semibold text-gray-800">' . $state . '</span>')
                    ->html(),
                TextColumn::make('email')
                    ->label('Email Address')
                    ->icon('heroicon-o-envelope')
                    ->copyable()
                    ->copyMessage('Email copied!')
                    ->extraAttributes(['class' => 'text-indigo-600']),
                TextColumn::make('subject')
                    ->label('Subject')
                    ->badge()
                    ->color('primary'),

                TextColumn::make('account_status')
                    ->label(' Status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'active' => 'success',
                        'inactive' => 'danger',
                        default => 'gray',
                    }),
            ])

            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),

            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
