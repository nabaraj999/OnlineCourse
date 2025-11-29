<?php

namespace App\Filament\Resources\Suggestions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SuggestionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('enrollment.full_name')
                    ->label('Student')
                    ->searchable(['enrollment.full_name', 'enrollment.email', 'enrollment.reference_code'])
                    ->sortable()
                    ->weight('medium')
                    ->icon('heroicon-o-user')
                    ->formatStateUsing(fn ($record) => $record->enrollment?->full_name ?? '—')
                    ->description(fn ($record) => $record->enrollment?->reference_code)
                    ->extraAttributes(['class' => 'font-medium']),
                TextColumn::make('enrollment.course.name')
                    ->label('Course')
                    ->badge()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: false),
                    TextColumn::make('subject')
                    ->label('Subject')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->subject)
                    ->searchable()
                    ->sortable()
                    ->weight('semibold'),
                TextColumn::make('status'),
                TextColumn::make('reviewed_at')
                    ->dateTime()
                    ->sortable(),
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
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
