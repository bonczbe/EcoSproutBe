<?php

namespace App\Filament\Resources\DeviceHistoryResource\Widgets;

use App\Models\Device;
use App\Models\DeviceHistory;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;

class DeviceTemperatureChart extends ApexChartWidget
{
    protected static ?string $chartId = 'deviceTemperatureChart';

    protected function getHeading(): string
    {
        $deviceId = $this->filterFormData['name'] ?? null;

        if ($deviceId) {
            $device = Device::find($deviceId);
            return 'Device Temperature Chart - ' . ($device?->name ?? 'Unknown Device');
        }

        return 'Device Temperature Chart - No Device Selected';
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('name')
                ->label('Device')
                ->nullable(false)
                ->options(Device::all()->pluck('name', 'id'))
                ->default(Device::first()->id),

            Select::make('interval')
                ->label('Interval')
                ->nullable(false)
                ->options([
                    '5 minutes' => 'Every 5 Minutes',
                    'hour' => 'Hourly',
                    'day' => 'Daily',
                    'week' => 'Weekly',
                    'month' => 'Monthly',
                ])
                ->default('day'),

            DatePicker::make('date_start')
                ->label('Start Date')
                ->default(now()->subMonth()->toDateString()),

            DatePicker::make('date_end')
                ->label('End Date')
                ->default(now()->toDateString()),
        ];
    }

    protected function getOptions(): array
    {
        $deviceId = $this->filterFormData['name'];
        $interval = $this->filterFormData['interval'] ?? 'day';
        $dateStart = $this->filterFormData['date_start'] ?? now()->subMonth()->toDateString();
        $dateEnd = $this->filterFormData['date_end'] ?? now()->toDateString();

        $query = DeviceHistory::query()
            ->whereBetween('created_at', [$dateStart, $dateEnd])
            ->where('device_id', $deviceId);

        switch ($interval) {
            case '5 minutes':
                $groupFormat = '%Y-%m-%d %H:%i';
                $selectFormat = 'DATE_FORMAT(created_at, "' . $groupFormat . '") as date';
                break;
            case 'hour':
                $groupFormat = '%Y-%m-%d %H:00';
                $selectFormat = 'DATE_FORMAT(created_at, "' . $groupFormat . '") as date';
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
                    return 'Week ' . substr($date, -2) . ' (' . substr($date, 0, 4) . ')';
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
}
