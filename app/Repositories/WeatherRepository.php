<?php

namespace App\Repositories;

use App\Models\Weather;
use Illuminate\Support\Collection;

class WeatherRepository
{
    public function upsertWeatherData(array $weatherData)
    {
        Weather::upsert($weatherData, ['city', 'date']);
    }

    public function getWeatherFilters(): Collection
    {
        return Weather::query()
            ->select('city', 'time_zone', 'date')
            ->get();
    }
}
