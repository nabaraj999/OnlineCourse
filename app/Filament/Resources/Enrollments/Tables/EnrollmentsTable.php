<?php

namespace App\Filament\Resources\Enrollments\Tables;

use App\Filament\Exports\EnrollmentExporter;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EnrollmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('full_name')
                    ->searchable()
                    ->sortable()
                    ->limit(10)
                    ->weight('medium'),

                TextColumn::make('phone')
                    ->searchable()
                    ->icon('heroicon-m-phone'),

                TextColumn::make('reference_code')
                    ->label('Ref Code')
                    ->searchable()
                    ->copyable()
                    ->copyMessage('Copied!'),

                TextColumn::make('amount_paid')
                    ->label('Paid')
                    ->money('NPR')
                    ->sortable(),

                // Status with beautiful badge
                TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'pending'   => 'warning',
                        'approved'  => 'success',
                        'rejected'  => 'danger',
                        default     => 'gray',
                    })
                    ->icon(fn(string $state): string => match ($state) {
                        'pending'   => 'heroicon-o-clock',
                        'approved'  => 'heroicon-o-check-circle',
                        'rejected'  => 'heroicon-o-x-circle',
                        default     => 'heroicon-o-question-mark-circle',
                    })
                    ->sortable()
                    ->searchable(),
                TextColumn::make('enrolled_at')
                    ->dateTime('d M Y, h:i A')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ->headerActions([
                ExportAction::make()->exporter(EnrollmentExporter::class),
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
