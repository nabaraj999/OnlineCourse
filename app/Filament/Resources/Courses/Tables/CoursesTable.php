<?php

namespace App\Filament\Resources\Courses\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Course Title')
                    ->searchable()
                    ->limit(20)
                    ->sortable(),


                TextColumn::make('price')
                    ->label('Price (NPR)')
                    ->money('npr')
                    ->sortable(),

                TextColumn::make('enrolled_seats')
                    ->label('Enrolled Seats')
                    ->numeric()
                    ->sortable(),

                TextColumn::make('active_status')
                    ->label('Status')
                    ->sortable(),
                TextColumn::make('rating')
                    ->label('Rating')
                    ->numeric()
                    ->sortable()
                    ->suffix('/10'),
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
