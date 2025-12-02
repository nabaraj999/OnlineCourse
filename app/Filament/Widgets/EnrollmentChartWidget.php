<?php

namespace App\Filament\Widgets;

use App\Models\Enrollment;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class EnrollmentChartWidget extends ChartWidget
{
    // ✅ CORRECT: Non-static (this is what Filament v3 expects)
    protected ?string $heading = 'Daily Enrollments (Last 30 Days)';

    // Optional: full width on dashboard
    protected int | string | array $columnSpan = 'full';

    // Optional: order on dashboard
    protected static ?int $sort = 4;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        $days = collect();
        for ($i = 29; $i >= 0; $i--) {
            $days->push(Carbon::today()->subDays($i));
        }

        $counts = $days->map(fn ($date) => Enrollment::whereDate('enrolled_at', $date)->count());

        return [
            'datasets' => [
                [
                    'label' => 'Enrollments',
                    'data' => $counts->toArray(),
                    'backgroundColor' => '#10b981',
                    'borderColor' => '#059669',
                    'borderWidth' => 1,
                    'borderRadius' => 8,
                    'borderSkipped' => false,
                ],
            ],
            'labels' => $days->map(fn ($date) => $date->format('M j'))->toArray(),
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => ['display' => false],
            ],
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => ['stepSize' => 1],
                ],
            ],
        ];
    }

    // Optional: auto-refresh every 5 minutes
    protected function getPollingInterval(): ?string
    {
        return '5m';
    }
}
