<?php

namespace App\Repositories;

use App\Models\Weather;

class WeatherRepository
{
    public function upsertWeatherData(array $weatherData)
    {
        Weather::upsert($weatherData, ['city', 'date']);
    }
}
