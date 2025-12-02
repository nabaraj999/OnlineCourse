<?php

namespace App\Filament\Exports;

use App\Models\Enrollment;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;
use Illuminate\Support\Number;

class EnrollmentExporter extends Exporter
{
    protected static ?string $model = Enrollment::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('course.title'),
            ExportColumn::make('paymentMethod.id'),
            ExportColumn::make('full_name'),
            ExportColumn::make('email'),
            ExportColumn::make('phone'),
            ExportColumn::make('reference_code'),
            ExportColumn::make('screenshot_path'),
            ExportColumn::make('screenshot_url'),
            ExportColumn::make('amount_paid'),
            ExportColumn::make('status'),
            ExportColumn::make('enrolled_at'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your enrollment export has completed and ' . Number::format($export->successful_rows) . ' ' . str('row')->plural($export->successful_rows) . ' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to export.';
        }

        return $body;
    }
}
