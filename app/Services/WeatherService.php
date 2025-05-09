<?php

namespace App\Services;

use App\DTOs\WeatherDTO;
use App\Repositories\DeviceRepository;
use App\Repositories\WeatherRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WeatherService
{
    protected DeviceRepository $deviceRepository;

    protected WeatherRepository $weatherRepository;

    public function __construct(DeviceRepository $deviceRepository, WeatherRepository $weatherRepository)
    {
        $this->deviceRepository = $deviceRepository;
        $this->weatherRepository = $weatherRepository;
    }

    public function fetchAndStoreWeatherForAllDevices()
    {
        $cities = $this->deviceRepository->getAllCityNames();
        Log::info('Got cities: '.implode(', ', $cities));

        $weatherData = [];
        foreach ($cities as $city) {
            Log::info("Fetching weather for {$city}");
            $weather = $this->getWeather($city);
            if ($weather) {
                $weatherData[] = $weather;
            }
        }

        Log::info('Upserting weather data...');
        $this->weatherRepository->upsertWeatherData($weatherData);
    }

    private function getWeather(string $city): ?array
    {
        $city = strtolower($city);
        $cacheKey = "weather_{$city}_".Carbon::today()->toDateString();
        $weatherData = Cache::get($cacheKey);

        if (! $weatherData) {
            $weatherData = $this->fetchWeatherData($city);
            if ($weatherData) {
                Cache::put($cacheKey, $weatherData, now()->addDay());
            }
        }

        return $weatherData;
    }

    private function fetchWeatherData(string $city): ?array
    {
        $response = Http::get('https://api.weatherapi.com/v1/forecast.json', [
            'key' => env('WEATHERAPI_COM'),
            'q' => $city,
            'days' => 2,
            'aqi' => 'no',
            'alerts' => 'no',
        ]);

        try {
            $data = $response->json();

            return WeatherDTO::fromApiResponse($data, $city);
        } catch (\Exception $e) {
            Log::error("Error fetching weather for {$city}: ".$e->getMessage());

            return null;
        }
    }

    public function getWeatherByFilters($data): array
    {
        $startDate = $data['startDate'];
        $endDate = $data['endDate'] ?? '9999-12-30';

        return $this->weatherRepository->getWeatherByFilters($data['city'], $startDate, $endDate);
    }
}
