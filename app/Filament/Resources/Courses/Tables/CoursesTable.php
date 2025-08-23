<?php

namespace App\Filament\Resources\Courses\Tables;

use App\Models\Teacher;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class CoursesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(20)
                    ->weight('bold'),


                TextColumn::make('teacher.name')
                    ->label('Teacher')
                    ->searchable()
                    ->sortable()
                    ->default('Unassigned')
                    ->toggleable(),

                TextColumn::make('discount.value')
                    ->label('Discount %')
                    ->searchable()
                    ->sortable()
                    ->suffix('%')
                    ->default(0)
                    ->toggleable()
                    ->color(fn ($record) => $record->discount && $record->discount->discount_percent > 0 ? 'warning' : 'gray'),

                ImageColumn::make('photo')
                    ->defaultImageUrl(url('path/to/default-course.png'))
                    ->size(50)
                    ->toggleable(),


                TextColumn::make('rating')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn ($state) => $state >= 7 ? 'success' : ($state >= 4 ? 'warning' : 'danger'))
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('updated_at')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('active_status')
                    ->options([
                        'active' => 'Active',
                        'no' => 'Inactive',
                    ]),
                Filter::make('upcoming')
                    ->query(fn ($query) => $query->where('start_date', '>=', now()))
                    ->label('Upcoming Courses'),
            ])
            ->recordActions([
                ViewAction::make(),

                EditAction::make(),
                DeleteAction::make(), // Changed to DeleteBulkAction for consistency
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),

                ]),
            ])
            ->defaultSort('start_date', 'desc')
            ->paginated([10, 25, 50])
            ->persistFiltersInSession();
    }
}
