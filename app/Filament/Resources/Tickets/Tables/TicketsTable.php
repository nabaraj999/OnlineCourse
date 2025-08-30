<?php

namespace App\Filament\Resources\Tickets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TicketsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                   ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn (string $state): string => ucwords($state))
                    ->color('primary')
                    ->icon('heroicon-o-user')
                    ->weight('bold'),
                TextColumn::make('email')
                  ->label('Email Address')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Email copied to clipboard!')
                    ->copyMessageDuration(1500)
                    ->icon('heroicon-o-envelope')
                    ->color('info')
                    ->formatStateUsing(fn (string $state): string => strtolower($state)),
                TextColumn::make('phone')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Phone number copied!')
                    ->copyMessageDuration(1500)
                    ->icon('heroicon-o-phone')
                    ->color('success'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
