<?php

namespace App\DTOs;

use Carbon\Carbon;

class WeatherDTO
{
    public static function fromApiResponse(array $data, string $city): array
    {
        $timezone = $data['location']['tz_id'] ?? 'Europe/Budapest';
        $date = Carbon::now($timezone)->toDateString();

        $normalize = function ($value) {
            return abs($value) <= 0.01 ? 0 : $value;
        };

        return [
        'city' => $city,
        'date' => $date,
        'time_zone' => $timezone,
        'max_celsius' => $normalize($data['forecast']['forecastday'][0]['day']['maxtemp_c'] ?? null),
        'min_celsius' => $normalize($data['forecast']['forecastday'][0]['day']['mintemp_c'] ?? null),
        'average_celsius' => $normalize($data['forecast']['forecastday'][0]['day']['avgtemp_c'] ?? null),
        'uv' => $normalize($data['forecast']['forecastday'][0]['day']['uv'] ?? null),
        'uv_tomorrow' => $normalize($data['forecast']['forecastday'][1]['day']['uv'] ?? null),
        'rain_chance' => $normalize($data['forecast']['forecastday'][0]['day']['daily_chance_of_rain'] ?? null),
        'snow_chance' => $normalize($data['forecast']['forecastday'][0]['day']['daily_chance_of_snow'] ?? null),
        'expected_maximum_rain' => $normalize($data['forecast']['forecastday'][0]['day']['totalprecip_mm'] ?? null),
        'expected_maximum_snow' => $normalize($data['forecast']['forecastday'][0]['day']['totalsnow_cm'] ?? null),
        'expected_max_celsius' => $normalize($data['forecast']['forecastday'][1]['day']['maxtemp_c'] ?? null),
        'expected_min_celsius' => $normalize($data['forecast']['forecastday'][1]['day']['mintemp_c'] ?? null),
        'expected_avgtemp_celsius' => $normalize($data['forecast']['forecastday'][1]['day']['avgtemp_c'] ?? null),
        'expected_maximum_snow_tomorrow' => $normalize($data['forecast']['forecastday'][1]['day']['totalprecip_mm'] ?? null),
        'expected_maximum_rain_tomorrow' => $normalize($data['forecast']['forecastday'][1]['day']['totalprecip_mm'] ?? null),
        'rain_chance_tomorrow' => $normalize($data['forecast']['forecastday'][1]['day']['daily_chance_of_rain'] ?? null),
        'snow_chance_tomorrow' => $normalize($data['forecast']['forecastday'][1]['day']['daily_chance_of_snow'] ?? null),
        'condition' => json_encode($data['forecast']['forecastday'][0]['day']['condition'] ?? []),
        'astro' => json_encode($data['forecast']['forecastday'][0]['astro'] ?? []),
    ];
    }

}
