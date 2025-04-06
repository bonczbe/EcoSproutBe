<?php

namespace App\Filament\Resources\DeviceHistoryResource\Widgets;

use App\Models\DeviceHistory;
use Filament\Widgets\ChartWidget;

class DeviceWaterChart extends ChartWidget
{
    protected static ?string $heading = 'Device Water Level';

    protected function getFilters(): ?array
    {
        return [
            'today' => 'Today',
            'week' => 'Last week',
            'month' => 'Last month',
            'year' => 'This year',
        ];
    }

    protected function getData(): array
    {
        $query = DeviceHistory::query();

        $filter = $this->filter;

        match ($filter) {
            'today' => $query->whereDate('created_at', now()),
            'week' => $query->whereBetween('created_at', [now()->subWeek(), now()]),
            'month' => $query->whereBetween('created_at', [now()->subMonth(), now()]),
            'year' => $query->whereBetween('created_at', [now()->subYear(), now()]),
            default => null,
        };

        $results = $query->orderBy('created_at')->get();

        return [
            'datasets' => [
                [
                    'label' => 'Water Level',
                    'data' => $results->pluck('water_level')->toArray(),
                ],
            ],
            'labels' => $results->pluck('created_at')->map(fn ($date) => $date->format('M d H:i'))->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'title' => [
                        'display' => true,
                        'text' => 'Water Level (%)',
                    ],
                ],
                'x' => [
                    'title' => [
                        'display' => true,
                        'text' => 'Date',
                    ],
                ],
            ],
            'plugins' => [
                'legend' => [
                    'display' => true,
                    'position' => 'top',
                ],
                'tooltip' => [
                    'enabled' => true,
                    'mode' => 'index',
                    'intersect' => false,
                ],
            ],
            'interaction' => [
                'mode' => 'nearest',
                'axis' => 'x',
                'intersect' => false,
            ],
        ];
    }
}
