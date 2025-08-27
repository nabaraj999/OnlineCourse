<?php

namespace App\Filament\Resources\Seos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Schemas\Components\View;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SeosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                    TextColumn::make('entity_type')
                            ->label('Entity Type')
                            ->searchable()
                            ->sortable()
                            ->badge()
                            ->color('primary'),
                TextColumn::make('title')
                    ->label('SEO Title')
                    ->searchable()
                    ->sortable()
                    ->limit(50)
                    ->tooltip(fn ($record): string => $record->title)
                            ->weight('bold'),

                TextColumn::make('sitemap_priority')
                   ->label('Priority')
                            ->numeric()
                            ->sortable()
                            ->formatStateUsing(fn ($state): string => number_format($state, 1))
                            ->badge()
                            ->color(fn ($state): string => $state >= 0.8 ? 'success' : ($state >= 0.5 ? 'warning' : 'danger')),

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
                EditAction::make(),
                DeleteAction::make(),

               EditAction::make()
                   ->label('Edit')
                   ->icon('heroicon-o-pencil')
                   ->color('primary'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->icon('heroicon-o-trash')
                        ->color('danger'),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
            
    }
}
