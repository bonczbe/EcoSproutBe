<?php

namespace App\Filament\Resources\DeviceHistoryResource\Widgets;

use App\Models\Device;
use App\Models\DeviceHistory;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Livewire\Attributes\On;

class DeviceTemperatureChart extends ApexChartWidget
{

    protected static ?string $chartId = 'deviceTemperatureChart';

    public array $filters = [];

    protected function getHeading(): string
    {
        return 'Device Temperature Chart ';
    }

    protected function getOptions(): array
    {
        $filters = $this->filters;


        $deviceId = $filters['name'] ?? Device::first()?->id;
        $interval = $filters['interval'] ?? 'day';
        $dateStart = $filters['date_start'] ?? now()->subMonth()->toDateString();
        $dateEnd = $filters['date_end'] ?? now()->toDateString();

        $query = DeviceHistory::query()
            ->whereBetween('created_at', [$dateStart, $dateEnd]);

        if ($deviceId) {
            $query->where('device_id', $deviceId);
        } else {
            $query->where('id', -1);
        }

        switch ($interval) {
            case '5 minutes':
                $groupFormat = '%Y-%m-%d %H:%i';
                $selectFormat = 'DATE_FORMAT(created_at, "'.$groupFormat.'") as date';
                break;
            case 'hour':
                $groupFormat = '%Y-%m-%d %H:00';
                $selectFormat = 'DATE_FORMAT(created_at, "'.$groupFormat.'") as date';
                break;
            case 'week':
                $selectFormat = 'YEARWEEK(created_at, 1) as date';
                break;
            case 'month':
                $selectFormat = 'DATE_FORMAT(created_at, "%Y-%m") as date';
                break;
            default:
                $selectFormat = 'DATE(created_at) as date';
                break;
        }

        $results = $query
            ->selectRaw("$selectFormat, AVG(temperature) as avg_temperature")
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $data = $results->pluck('avg_temperature')
            ->map(fn ($value) => round($value, 2))
            ->toArray();

        $labels = $results->pluck('date')
            ->map(function ($date) use ($interval) {
                if ($interval === 'week') {
                    return 'Week '.substr($date, -2).' ('.substr($date, 0, 4).')';
                }

                return $date;
            })
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
                    'name' => 'Average Temperature (℃)',
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
                    'text' => 'Date/Time',
                ],
            ],
            'yaxis' => [
                'title' => [
                    'text' => 'Temperature (℃)',
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

    #[On('changedDeviceHistoryFilter')]
    public function setFilters(array $data): void
    {
        $this->filters = $data;
    }
}
