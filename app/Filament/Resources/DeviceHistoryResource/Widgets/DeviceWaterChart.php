<?php

namespace App\Filament\Resources\DeviceHistoryResource\Widgets;

use App\Models\Device;
use App\Models\DeviceHistory;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class DeviceWaterChart extends ApexChartWidget
{
    protected static ?string $chartId = 'deviceWaterChart';

    protected function getHeading(): string
    {
        $deviceId = $this->filterFormData['name'] ?? null;

        if ($deviceId) {
            $device = Device::find($deviceId);

            return 'Device Water Chart - '.($device?->name ?? 'Unknown Device');
        }

        return 'Device Water Chart - no specified';
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('name')
                ->options(
                    Device::all()
                        ->pluck('name', 'id')
                )
                ->default(Device::first()->id),
            DatePicker::make('date_start')
                ->default(now()->subMonth()->toDateString()),
            DatePicker::make('date_end')
                ->default(now()->toDateString()),
        ];
    }

    protected function getOptions(): array
    {
        $deviceId = $this->filterFormData['name'];
        $dateStart = $this->filterFormData['date_start'] ?? now()->subMonth()->toDateString();
        $dateEnd = $this->filterFormData['date_end'] ?? now()->toDateString();

        $query = DeviceHistory::query()
            ->whereBetween('created_at', [$dateStart, $dateEnd]);

        if ($deviceId) {
            $query->where('device_id', $deviceId);
        } else {
            $query->where('id', -1);
        }

        $results = $query
            ->selectRaw('DATE(created_at) as date, SUM(water_level) as total_water_level')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $data = $results->pluck('total_water_level')
            ->map(fn ($value) => round($value, 2))
            ->toArray();

        $labels = $results->pluck('date')
            ->map(fn ($date) => Carbon::parse($date)->format('Y-m-d'))
            ->toArray();

        return [
            'chart' => [
                'type' => 'line',
                'height' => 300,
                'toolbar' => [
                    'show' => true,
                ],
                'zoom' => [
                    'enabled' => true,
                ],
            ],
            'series' => [
                [
                    'name' => 'Water Level (%)',
                    'data' => $data,
                ],
            ],
            'xaxis' => [
                'categories' => $labels,
                'labels' => [
                    'rotate' => -45,
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
                'title' => [
                    'text' => 'Date',
                ],
            ],
            'yaxis' => [
                'title' => [
                    'text' => 'Water Level (%)',
                ],
                'labels' => [
                    'style' => [
                        'fontFamily' => 'inherit',
                    ],
                ],
                'min' => 0,
            ],
            'colors' => ['#f59e0b'],
            'stroke' => [
                'curve' => 'smooth',
            ],
            'tooltip' => [
                'enabled' => true,
            ],
            'legend' => [
                'position' => 'top',
            ],
        ];
    }
}
