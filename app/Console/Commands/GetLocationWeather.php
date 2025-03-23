<?php

namespace App\Console\Commands;

use App\Models\Device;
use App\Models\Weather;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetLocationWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-location-weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch all the locations and call the weather api for them';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $deviceLocations = Device::all()->pluck('city')->toArray();
        Log::info('Got cities: '.implode(', ', $deviceLocations));

        $locationsWeather = [];

        foreach ($deviceLocations as $deviceLocation) {
            Log::info("Started fetching weather for {$deviceLocation}");
            $locationsWeather[] = $this->getWeather($deviceLocation);
            Log::info("Finished fetching weather for {$deviceLocation}");
        }

        Log::info('Start upserting cities weather...');
        Weather::upsert($locationsWeather, ['city', 'date']);
    }

    /**
     * Get weather data for a specific location.
     *
     * @return array|null
     */
    private function getWeather(string $location)
    {

        $location = strtolower($location);

        $callCountKey = 'weather_api_call_count';

        $callCount = Cache::get($callCountKey, 0);

        if ($callCount >= 800000) {
            Log::error('API call limit exceeded for this month');

            return;
        }

        $lastWeather = Weather::where('city', $location)
            ->orderBy('date', 'desc')
            ->first();

        $today = null;
        $weatherData = [];
        $cacheKey = '';

        if ($lastWeather) {
            $today = Carbon::now($lastWeather->time_zone)->toDateString();

            $cacheKey = "weather_{$location}_{$today}";

            $weatherData = Cache::get($cacheKey, []);
        }

        if (empty($weatherData) || $weatherData['date'] != Carbon::today($lastWeather->time_zone)->format('Y-m-d')) {

            $weatherData = $this->fetchWeatherData($location);

            Cache::increment($callCountKey);

            $today = Carbon::now($weatherData['time_zone'])->toDateString();

            $cacheKey = "weather_{$location}_{$today}";
            Cache::put($cacheKey, $weatherData, now()->addDay());

        }

        return $weatherData;
    }

    /**
     * Fetch fresh weather data from the API.
     *
     * @param  string  $location
     */
    private function fetchWeatherData($location): ?array
    {

        $response = Http::get('https://api.weatherapi.com/v1/forecast.json', [
            'key' => env('WEATHERAPI_COM', null),
            'q' => $location,
            'days' => 2,
            'aqi' => 'no',
            'alerts' => 'no',
        ]);
        try {

            $weatherData = $response->json();

            $weatherData = [
                'city' => $location,
                'date' => $this->parseWeatherDate($weatherData['forecast']['forecastday'][0]['date']),
                'time_zone' => $weatherData['location']['tz_id'] ?? 'Europe/Budapest',
                'max_celsius' => $weatherData['forecast']['forecastday'][0]['day']['maxtemp_c'] ?? -1000,
                'min_celsius' => $weatherData['forecast']['forecastday'][0]['day']['mintemp_c'] ?? -1000,
                'average_celsius' => $weatherData['forecast']['forecastday'][0]['day']['avgtemp_c'] ?? -1000,
                'uv' => $weatherData['forecast']['forecastday'][0]['day']['uv'] ?? -1000,
                'rain_chance' => $weatherData['forecast']['forecastday'][0]['day']['daily_chance_of_rain'] ?? -1000,
                'snow_chance' => $weatherData['forecast']['forecastday'][0]['day']['daily_chance_of_snow'] ?? -1000,
                'expected_maximum_rain' => $weatherData['forecast']['forecastday'][0]['day']['totalprecip_mm'] ?? -1000,
                'expected_maximum_snow' => $weatherData['forecast']['forecastday'][0]['day']['totalsnow_cm'] ?? -1000,
                'expected_maximum_rain_tomorrow' => $weatherData['forecast']['forecastday'][1]['day']['totalprecip_mm'] ?? -1000,
                'expected_maximum_snow_tomorrow' => $weatherData['forecast']['forecastday'][1]['day']['totalsnow_cm'] ?? -1000,
                'condition' => json_encode($weatherData['forecast']['forecastday'][0]['day']['condition'] ?? []),
                'astro' => json_encode($weatherData['forecast']['forecastday'][0]['astro'] ?? []),
            ];

            return $weatherData;
        } catch (\Exception $e) {
            Log::error('Something went wrong while fetching data from api message:'.$e->getMessage());

            return null;
        }

    }

    /**
     * Parse the weather date string and return it.
     */
    private function parseWeatherDate(string $dateString): string
    {
        return Carbon::parse($dateString)->toDateString() ?? Carbon::create(1000, 1, 1)->toDateString();
    }
}
