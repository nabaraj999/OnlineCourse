<?php

namespace App\Filament\Resources\Courses\Tables;

use Faker\Core\File;
use FFI;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                 TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    // limit
                    ->limit(20)
                    ->weight('bold'),

                TextColumn::make('teacher.name')
                    ->searchable()
                    ->sortable()
                    ->default('Unassigned')
                    ->toggleable(),
                TextColumn::make('price')
                    ->money('NPR')
                    ->sortable(),

                ImageColumn::make('photo')
                    ->searchable(),
                TextColumn::make('rating')
                    ->numeric()

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
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
