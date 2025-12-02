<?php

namespace App\Filament\Widgets;

use App\Models\Ticket;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class TicketStatsWidget extends ChartWidget
{
    protected ?string $heading = 'Tickets This Week (Last 7 Days)';

    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 5;

    protected function getType(): string
    {
        return 'pie';
    }

    protected function getData(): array
    {
        // Generate last 7 days with day names
        $days = collect();
        $labels = [];
        $counts = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dayName = $date->format('D'); // Mon, Tue, etc.
            $formatted = $date->format('M j') . " ($dayName)";

            $labels[] = $formatted;
            $count = Ticket::whereDate('created_at', $date)->count();
            $counts[] = $count;
        }

        // Beautiful colors (Tailwind-inspired)
        $colors = [
            '#f59e0b', // amber-500
            '#10b981', // emerald-500
            '#3b82f6', // blue-500
            '#8b5cf6', // violet-500
            '#ef4444', // red-500
            '#06b6d4', // cyan-500
            '#f97316', // orange-500
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Tickets',
                    'data' => $counts,
                    'backgroundColor' => $colors,
                    'borderColor' => '#1f2937',
                    'borderWidth' => 2,
                    'hoverOffset' => 20,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getOptions(): array
    {
        return [
            'plugins' => [
                'legend' => [
                    'position' => 'right',
                    'labels' => [
                        'padding' => 20,
                        'usePointStyle' => true,
                        'pointStyle' => 'circle',
                    ],
                ],
                'tooltip' => [
                    'callbacks' => [
                        'label' => fn($tooltipItem) =>
                            $tooltipItem->label . ': ' . $tooltipItem->formattedValue . ' ticket' .
                            ($tooltipItem->formattedValue == 1 ? '' : 's')
                    ],
                ],
            ],
            'animation' => [
                'animateRotate' => true,
                'duration' => 2000,
            ],
        ];
    }

    // Optional: refresh every 10 minutes
    protected function getPollingInterval(): ?string
    {
        return '10m';
    }
}
