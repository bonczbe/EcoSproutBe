<?php

namespace App\Filament\Resources\WeatherResource\Pages;

use App\Filament\Resources\WeatherResource;
use App\Filament\Resources\WeatherResource\Widgets\WeatherChart;
use App\Filament\Resources\WeatherResource\Widgets\WeatherFilters;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWeather extends ListRecords
{
    protected static string $resource = WeatherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            WeatherFilters::class,
            WeatherChart::class,
        ];
    }
}
