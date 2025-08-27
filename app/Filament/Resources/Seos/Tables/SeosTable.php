<?php

namespace App\Filament\Resources\Seos\Tables;

use Filament\Actions\BulkActionGroup as ActionsBulkActionGroup;
use Filament\Actions\DeleteBulkAction as ActionsDeleteBulkAction;
use Filament\Actions\EditAction as ActionsEditAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;

class SeosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Split::make([
                    Stack::make([
                        TextColumn::make('title')
                            ->label('SEO Title')
                            ->searchable()
                            ->sortable()
                            ->limit(50)
                            ->tooltip(fn ($record): string => $record->title)
                            ->weight('bold'),
                        TextColumn::make('description')
                            ->label('Meta Description')
                            ->searchable()
                            ->limit(100)
                            ->color('gray')
                            ->tooltip(fn ($record): string => $record->description),
                    ]),
                    Stack::make([
                        TextColumn::make('entity_type')
                            ->label('Entity Type')
                            ->searchable()
                            ->sortable()
                            ->badge()
                            ->color('primary'),
                        TextColumn::make('keywords')
                            ->label('Keywords')
                            ->searchable()
                            ->limit(30)
                            ->tooltip(fn ($record): string => $record->keywords),
                    ]),
                    Stack::make([
                        TextColumn::make('slug')
                            ->label('URL Slug')
                            ->searchable()
                            ->sortable()
                            ->prefix('/')
                            ->copyable()
                            ->copyMessage('Slug copied to clipboard!'),
                        TextColumn::make('sitemap_priority')
                            ->label('Priority')
                            ->numeric()
                            ->sortable()
                            ->formatStateUsing(fn ($state): string => number_format($state, 1))
                            ->badge()
                            ->color(fn ($state): string => $state >= 0.8 ? 'success' : ($state >= 0.5 ? 'warning' : 'danger')),
                    ]),
                    Stack::make([
                        IconColumn::make('noindex')
                            ->label('Noindex')
                            ->boolean()
                            ->trueIcon('heroicon-o-x-circle')
                            ->falseIcon('heroicon-o-check-circle')
                            ->trueColor('danger')
                            ->falseColor('success'),
                        IconColumn::make('nofollow')
                            ->label('Nofollow')
                            ->boolean()
                            ->trueIcon('heroicon-o-x-circle')
                            ->falseIcon('heroicon-o-check-circle')
                            ->trueColor('danger')
                            ->falseColor('success'),
                    ]),
                ])->from('md'),
            ])
            ->filters([
                // Add filters if needed, e.g., for entity_type or noindex
            ])
            ->recordActions([
                ActionsEditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil')
                    ->color('primary'),
            ])
            ->toolbarActions([
                ActionsBulkActionGroup::make([
                    ActionsDeleteBulkAction::make()
                        ->label('Delete Selected')
                        ->icon('heroicon-o-trash')
                        ->color('danger'),
                ]),
            ])
            ->defaultSort('sitemap_priority', 'desc')
            ->paginated([10, 25, 50])
            ->defaultPaginationPageOption(10);
    }
}
