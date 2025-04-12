<?php

namespace App\Filament\Resources\WeatherResource\Widgets;

use App\Models\Weather;
use Carbon\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Livewire\Attributes\On;

class WeatherTempChart extends ApexChartWidget
{
    protected static ?string $chartId = 'weatherRainChartId';

    protected int|string|array $columnSpan = 'full';

    public array $filters = [];

    protected function getHeading(): string
    {
        return 'Device Temperature Chart ';
    }

    protected function getOptions(): array
    {
        $filters = $this->filters;

        $city = $filters['city'] ?? Weather::first()?->city;
        $interval = $filters['interval'] ?? 'day';
        $dateStart = isset($filters['date_start']) ? Carbon::parse($filters['date_start'])->startOfDay()->toDateTimeString() : now()->startOfDay()->subMonth()->toDateTimeString();
        $dateEnd = isset($filters['date_end']) ? Carbon::parse($filters['date_end'])->endOfDay()->toDateTimeString() : now()->endOfDay()->toDateTimeString();
        $query = Weather::query()
            ->whereBetween('date', [$dateStart, $dateEnd]);

        if ($city) {
            $query->where('city', $city);
        } else {
            $query->where('city', null);
        }

        switch ($interval) {
            case 'week':
                $selectFormat = 'YEARWEEK(date, 1) as date_filtering';
                break;
            case 'month':
                $selectFormat = 'DATE_FORMAT(date, "%Y-%m") as date_filtering';
                break;
            default:
                $selectFormat = 'DATE(date) as date_filtering';
                break;
        }

        $results = $query
            ->selectRaw("{$selectFormat},
                COALESCE(AVG(average_celsius), 0) as avg_temperature_calc,
                COALESCE(AVG(max_celsius), 0) as max_temp_calc,
                COALESCE(AVG(min_celsius), 0) as min_temp_calc,
                COALESCE(AVG(expected_avgtemp_celsius), 0) as expected_avgtemp_celsius_calc,
                COALESCE(AVG(expected_max_celsius), 0) as expected_max_celsius_calc,
                COALESCE(AVG(expected_min_celsius), 0) as expected_min_celsius_calc"
            )
            ->groupBy('date_filtering')
            ->orderBy('date_filtering')
            ->get();

        $dataAvgTemp = $results->pluck('avg_temperature_calc')
            ->map(fn ($value) => round($value, 2))
            ->toArray();
        $dataMaxTemp = $results->pluck('max_temp_calc')
            ->map(fn ($value) => round($value, 2))
            ->toArray();
        $dataMinTemp = $results->pluck('min_temp_calc')
            ->map(fn ($value) => round($value, 2))
            ->toArray();
        $dataExpectedAvgTemp = $results->pluck('expected_avgtemp_celsius_calc')
            ->map(fn ($value) => round($value, 2))
            ->toArray();
        $dataExpectedMaxTemp = $results->pluck('expected_max_celsius_calc')
            ->map(fn ($value) => round($value, 2))
            ->toArray();
        $dataExpectedMinTemp = $results->pluck('expected_min_celsius_calc')
            ->map(fn ($value) => round($value, 2))
            ->toArray();

        $labels = $results->pluck('date_filtering')
            ->map(function ($date) use ($interval) {
                if ($interval === 'week') {
                    return 'Week '.substr($date, -2).' ('.substr($date, 0, 4).')';
                }

                return $date;
            })
            ->toArray();

        array_push($labels, 'next period');
        array_unshift($dataExpectedAvgTemp, $dataAvgTemp[0] ?? 0);
        array_unshift($dataExpectedMaxTemp, $dataMaxTemp[0] ?? 0);
        array_unshift($dataExpectedMinTemp, $dataMinTemp[0] ?? 0);

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
                    'name' => 'Avg (℃)',
                    'data' => $dataAvgTemp,
                ],
                [
                    'name' => 'Max (℃)',
                    'data' => $dataMaxTemp,
                ],
                [
                    'name' => 'Min (℃)',
                    'data' => $dataMinTemp,
                ],
                [
                    'name' => 'Next Avg (℃)',
                    'data' => $dataExpectedAvgTemp,
                ],
                [
                    'name' => 'Next Max (℃)',
                    'data' => $dataExpectedMaxTemp,
                ],
                [
                    'name' => 'Next Min (℃)',
                    'data' => $dataExpectedMinTemp,
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
            'colors' => [
                '#3B82F6',
                '#EF4444',
                '#10B981',
                '#3B82F680',
                '#EF444480',
                '#10B98180',
            ],
            'stroke' => [
                'curve' => 'smooth',
                'width' => [3, 3, 3, 2, 2, 2],
            ],
            'markers' => [
                'size' => [4, 4, 4, 0, 0, 0],
            ],
            'tooltip' => [
                'enabled' => true,
                'shared' => true,
            ],
            'legend' => [
                'position' => 'top',
            ],
        ];
    }

    #[On('changedWeatherFilter')]
    public function setFilters(array $data): void
    {
        $this->filters = $data;
    }
}
