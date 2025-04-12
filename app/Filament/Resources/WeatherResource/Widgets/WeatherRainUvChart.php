<?php

namespace App\Filament\Resources\WeatherResource\Widgets;

use App\Models\Weather;
use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Livewire\Attributes\On;

class WeatherRainUvChart extends ApexChartWidget
{
    protected static ?string $chartId = 'weatherChartId';

    protected int|string|array $columnSpan = 'full';

    public array $filters = [];

    protected function getHeading(): string
    {
        return 'Device Rain and UV Chart ';
    }
    protected function getFormSchema(): array
    {
        return [

            Select::make('type')
            ->options([
                'rain'=>'Rain',
                'snow'=>'Snow',
                'uv'=>'UV',
            ])
            ->default('rain'),

        ];
    }
    protected function getOptions(): array
    {
        $filters = $this->filters;
        $selectedDataType = $this->filterFormData['type'];
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
                COALESCE(AVG(rain_chance), 0) as rain_chance_calc,
                COALESCE(AVG(snow_chance), 0) as snow_chance_calc,
                COALESCE(AVG(uv), 0) as uv_calc,
                COALESCE(AVG(expected_maximum_rain), 0) as expected_maximum_rain_calc,
                COALESCE(AVG(expected_maximum_snow), 0) as expected_maximum_snow_calc,


                COALESCE(AVG(rain_chance_tomorrow), 0) as rain_chance_tomorrow_calc,
                COALESCE(AVG(snow_chance_tomorrow), 0) as snow_chance_tomorrow_calc,
                COALESCE(AVG(expected_maximum_rain_tomorrow), 0) as expected_maximum_rain_tomorrow_calc,
                COALESCE(AVG(uv_tomorrow), 0) as uv_tomorrow_calc,
                COALESCE(AVG(expected_maximum_snow_tomorrow), 0) as expected_maximum_snow_tomorrow_calc"
            )
            ->groupBy('date_filtering')
            ->orderBy('date_filtering')
            ->get();

            $avgRainChance = $results->pluck('rain_chance_calc')
            ->map(fn ($value) => round($value, 2))
            ->toArray();

        $avgSnowChance = $results->pluck('snow_chance_calc')
            ->map(fn ($value) => round($value, 2))
            ->toArray();

        $avgUVIndex = $results->pluck('uv_calc')
            ->map(fn ($value) => round($value, 2))
            ->toArray();

        $maxRainChance = $results->pluck('expected_maximum_rain_calc')
            ->map(fn ($value) => round($value, 2))
            ->toArray();

        $maxSnowChance = $results->pluck('expected_maximum_snow_calc')
            ->map(fn ($value) => round($value, 2))
            ->toArray();




        $expectedRainTomorrow = $results->pluck('rain_chance_tomorrow_calc')
            ->map(fn ($value) => round($value, 2))
            ->toArray();

        $expectedSnowTomorrow = $results->pluck('snow_chance_tomorrow_calc')
            ->map(fn ($value) => round($value, 2))
            ->toArray();

        $expectedUVTomorrow = $results->pluck('uv_tomorrow_calc')
            ->map(fn ($value) => round($value, 2))
            ->toArray();

        $expectedMaxRainTomorrow = $results->pluck('expected_maximum_rain_tomorrow_calc')
            ->map(fn ($value) => round($value, 2))
            ->toArray();

        $expectedMaxSnowTomorrow = $results->pluck('expected_maximum_snow_tomorrow_calc')
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
        array_unshift($expectedRainTomorrow, $avgRainChance[0] ?? 0);
        array_unshift($expectedSnowTomorrow, $avgSnowChance[0] ?? 0);
        array_unshift($expectedUVTomorrow, $avgUVIndex[0] ?? 0);
        array_unshift($expectedMaxRainTomorrow, $maxRainChance[0] ?? 0);
        array_unshift($expectedMaxSnowTomorrow, $maxSnowChance[0] ?? 0);


        $series = [];

        if ($selectedDataType == 'rain') {
            $series[] = [
                'name' => 'Rain Chance (%)',
                'data' => $avgRainChance,
            ];
            $series[] = [
                'name' => 'Max Rain (mm)',
                'data' => $maxRainChance,
            ];
            $series[] = [
                'name' => 'Max Rain Tomorrow (%)',
                'data' => $expectedRainTomorrow,
            ];
            $series[] = [
                'name' => 'Max Rain Tomorrow (mm)',
                'data' => $expectedMaxRainTomorrow,
            ];
        }

        if ($selectedDataType == 'snow') {
            $series[] = [
                'name' => 'Snow Chance (%)',
                'data' => $avgSnowChance,
            ];
            $series[] = [
                'name' => 'Max Snow (mm)',
                'data' => $maxSnowChance,
            ];
            $series[] = [
                'name' => 'Max Snow Tomorrow (%)',
                'data' => $expectedSnowTomorrow,
            ];
            $series[] = [
                'name' => 'Max Snow Tomorrow (mm)',
                'data' => $expectedMaxSnowTomorrow,
            ];
        }

        if ($selectedDataType == 'uv') {
            $series[] = [
                'name' => 'Avg UV Index',
                'data' => $avgUVIndex,
            ];
            $series[] = [
                'name' => 'UV Tomorrow (%)',
                'data' => $expectedUVTomorrow,
            ];
        }


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

        'series' => $series,

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
                '#10B981',
                '#EF4444',
                '#F59E0B',
            ],
            'stroke' => [
                'curve' => 'smooth',
                'width' => [3, 3, 3, 3, 2, 2, 2, 2],
            ],
            'markers' => [
                'size' => [4, 4, 4, 4, 0, 0, 0, 0],
            ],
            'tooltip' => [
                'enabled' => false,
                'shared' => false,
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
