<?php

namespace App\Filament\Resources\CustomerPlantResource\Widgets;

use App\Models\PlantHistory;
use Carbon\Carbon;
use Leandrocfe\FilamentApexCharts\Widgets\ApexChartWidget;
use Livewire\Attributes\On;

class WaterChart extends ApexChartWidget
{
    protected static ?string $chartId = 'weatherChartId';

    protected int|string|array $columnSpan = 'full';

    public array $filters = [];

    protected function getHeading(): string
    {
        return 'Weather Temperature Forecast';
    }

    protected function getOptions(): array
    {
        $filters = $this->filters;

        $plant_id = $filters['plant_id'] ?? false;
        $interval = $filters['interval'] ?? '5 minutes';
        $dateStart = isset($filters['date_start']) ? Carbon::parse($filters['date_start'])->startOfDay()->toDateTimeString() : now()->startOfDay()->subMonth()->toDateTimeString();
        $dateEnd = isset($filters['date_end']) ? Carbon::parse($filters['date_end'])->endOfDay()->toDateTimeString() : now()->endOfDay()->toDateTimeString();
        $query = PlantHistory::query()
            ->whereBetween('created_at', [$dateStart, $dateEnd]);

        if ($plant_id) {
            $query->where('customer_plant_id', $plant_id);
        } else {
            $query->where('customer_plant_id', null);
        }

        switch ($interval) {
            case '5 minutes':
                $groupFormat = '%Y-%m-%d %H:%i';
                $selectFormat = 'DATE_FORMAT(created_at, "'.$groupFormat.'") as date_filtering';
                break;
            case 'hour':
                $groupFormat = '%Y-%m-%d %H:00';
                $selectFormat = 'DATE_FORMAT(created_at, "'.$groupFormat.'") as date_filtering';
                break;
            case 'week':
                $selectFormat = 'YEARWEEK(created_at, 1) as date_filtering';
                break;
            case 'month':
                $selectFormat = 'DATE_FORMAT(created_at, "%Y-%m") as date_filtering';
                break;
            default:
                $selectFormat = 'DATE(created_at) as date_filtering';
                break;
        }

        $results = $query
            ->selectRaw("{$selectFormat},
                COALESCE(AVG(moisture_level), 0) as moisture_level_calc"
            )
            ->groupBy('date_filtering')
            ->orderBy('date_filtering')
            ->get();

        $dataAvgTemp = $results->pluck('moisture_level_calc')
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
                    'name' => 'Avg %)',
                    'data' => $dataAvgTemp,
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
                    'text' => 'Moisture (%)',
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
