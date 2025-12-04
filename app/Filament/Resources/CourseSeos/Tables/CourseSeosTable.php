<?php

namespace App\Filament\Resources\CourseSeos\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CourseSeosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course.title')
                    ->label('Course')
                    ->searchable()
                    ->sortable()
                    ->weight('semibold')
                    ->description(fn ($record) => $record->course?->teacher?->name)
                    ->limit(40),

                TextColumn::make('meta_title')
                    ->label('Meta Title')
                    ->searchable()
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->meta_title)
                    ->color(fn ($state) => strlen($state) > 70 ? 'danger' : 'success')
                    ->icon(fn ($state) => strlen($state) > 70 ? 'heroicon-o-exclamation-triangle' : 'heroicon-o-check-circle'),

                TextColumn::make('meta_description')
                    ->label('Meta Desc.')
                    ->limit(60)
                    ->tooltip(fn ($record) => $record->meta_description)
                    ->color(fn ($state) => $state && strlen($state) > 160 ? 'danger' : 'gray'),

                ImageColumn::make('og_image')
                    ->label('OG Image')
                    ->size(40)
                    ->rounded()
                    ->defaultImageUrl(asset('images/placeholder-og.png')),

                TextColumn::make('og_title')
                    ->label('OG Title')
                    ->limit(50)
                    ->tooltip(fn ($record) => $record->og_title)
                    ->searchable(),
                
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
