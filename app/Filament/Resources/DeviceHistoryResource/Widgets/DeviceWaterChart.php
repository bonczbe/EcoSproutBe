<?php

namespace App\Filament\Resources\DeviceHistoryResource\Widgets;

use App\Models\Device;
use App\Models\DeviceHistory;
use Carbon\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Livewire\Attributes\On;

class DeviceWaterChart extends ApexChartWidget
{
    protected static ?string $chartId = 'deviceWaterChart';

    public array $filters = [];

    protected function getHeading(): string
    {
        return 'Device Water Chart';
    }

    protected function getOptions(): array
    {
        $filters = $this->filters;

        $deviceId = $filters['name'] ?? Device::first()?->id;
        $interval = $filters['interval'] ?? 'day';
        $dateStart = isset($filters['date_start']) ? Carbon::parse($filters['date_start'])->startOfDay()->toDateTimeString() : now()->startOfDay()->subMonth()->toDateTimeString();
        $dateEnd = isset($filters['date_end']) ? Carbon::parse($filters['date_end'])->endOfDay()->toDateTimeString() : now()->endOfDay()->toDateTimeString();

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
            ->selectRaw("$selectFormat, AVG(water_level) as avg_water_level")
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $data = $results->pluck('avg_water_level')
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
                    'text' => 'Date/Time',
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
            'colors' => ['#3b82f6'],
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
    public function setFilters(?array $data): void
    {
        $this->filters = $data;
    }
}
