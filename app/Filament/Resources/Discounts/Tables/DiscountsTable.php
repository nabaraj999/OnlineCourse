<?php

namespace App\Filament\Resources\Discounts\Tables;

use App\Models\Course;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Log;

class DiscountsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold')
                    ->tooltip('Click to copy discount code'),

                TextColumn::make('course.title')
                    ->label('Course')
                    ->limit(20)
                    ->searchable()
                    ->sortable()
                    ->default('Global')
                    ->toggleable(),

                TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'percentage' => 'info',
                        'fixed' => 'warning',
                        default => function () use ($state) {
                            Log::warning('Unhandled discount type: ' . $state);
                            return 'gray';
                        },
                    })
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('value')
                    ->numeric()
                    ->sortable()
                    ->prefix(fn ($record) => $record->type === 'percentage' ? '%' : '$')
                    ->color(fn ($record) => $record->type === 'percentage' && $record->value >= 50 ? 'danger' : 'success')
                    ->toggleable(),

                TextColumn::make('start_date')
                    ->date('Y-m-d')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('end_date')
                    ->date('Y-m-d')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                IconColumn::make('is_active')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger')
                    ->sortable()
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
                SelectFilter::make('is_active')
                    ->options([
                        '1' => 'Active',
                        '0' => 'Inactive',
                    ]),
                Filter::make('active_now')
                    ->query(fn ($query) => $query->where('start_date', '<=', now())
                        ->where(function ($query) {
                            $query->where('end_date', '>=', now())->orWhereNull('end_date');
                        }))
                    ->label('Currently Active'),
            ])
            ->recordActions([
                EditAction::make(),
                ViewAction::make(),
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
