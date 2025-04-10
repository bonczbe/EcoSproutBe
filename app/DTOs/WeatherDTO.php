<?php

namespace App\DTOs;

use Carbon\Carbon;

class WeatherDTO
{
    public static function fromApiResponse(array $data, string $city): array
    {
        $timezone = $data['location']['tz_id'] ?? 'Europe/Budapest';
        $date = Carbon::now($timezone)->toDateString();

        return [
            'city' => $city,
            'date' => $date,
            'time_zone' => $timezone,
            'max_celsius' => $data['forecast']['forecastday'][0]['day']['maxtemp_c'] ?? null,
            'min_celsius' => $data['forecast']['forecastday'][0]['day']['mintemp_c'] ?? null,
            'average_celsius' => $data['forecast']['forecastday'][0]['day']['avgtemp_c'] ?? null,
            'uv' => $data['forecast']['forecastday'][0]['day']['uv'] ?? null,
            'rain_chance' => $data['forecast']['forecastday'][0]['day']['daily_chance_of_rain'] ?? null,
            'snow_chance' => $data['forecast']['forecastday'][0]['day']['daily_chance_of_snow'] ?? null,
            'expected_maximum_rain' => $data['forecast']['forecastday'][0]['day']['totalprecip_mm'] ?? null,
            'expected_maximum_snow' => $data['forecast']['forecastday'][0]['day']['totalsnow_cm'] ?? null,
            'expected_max_celsius' => $data['forecast']['forecastday'][0]['day']['maxtemp_c'] ?? null,
            'expected_min_celsius' => $data['forecast']['forecastday'][0]['day']['mintemp_c'] ?? null,
            'expected_avgtemp_celsius' => $data['forecast']['forecastday'][0]['day']['avgtemp_c'] ?? null,
            'condition' => json_encode($data['forecast']['forecastday'][0]['day']['condition'] ?? []),
            'astro' => json_encode($data['forecast']['forecastday'][0]['astro'] ?? []),
        ];
    }
}
