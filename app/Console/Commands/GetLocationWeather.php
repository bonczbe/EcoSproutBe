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
        $deviceLocations = Device::all()->pluck('city');
        Log::info('Got cities: ' . $deviceLocations);

        $locationsWeather=[];

        foreach ($deviceLocations as $key=>$deviceLocation) {
            Log::info('Started fetching weather for ' . $deviceLocation);
            $locationsWeather[$key]=$this->getWeather($deviceLocation);
            Log::info('Finished fetching weather for ' . $deviceLocation);
        }
        Log::info('Start to upsert cities weather: ' . $deviceLocations);

        Weather::upsert($locationsWeather,['city','date']);
    }

    private function getWeather(string $location){

        $location = strtolower($location);
        $today = Carbon::now()->toDateString();

        $cacheKey = "weather_{$location}_{$today}";
        $callCountKey = 'weather_api_call_count';

        $callCount = Cache::get($callCountKey,0);

        $weatherData = Cache::get($cacheKey,false);

        if ($callCount >= 800000) {
            Log::error('API call limit exceeded for this month');
            return;
        }

        if (!$weatherData||$weatherData['date']!=Carbon::today()->format('Y-m-d')) {

                $response = Http::get('https://api.weatherapi.com/v1/forecast.json', [
                    'key' => env("WEATHERAPI_COM",null),
                    'q' => $location,
                    'days' => 2,
                    'aqi' => 'no',
                    'alerts' => 'no',
                ]);

                Cache::increment($callCountKey);


                $weatherData = $response->json();


                $date= isset($weatherData['forecast']['forecastday'][0]['date'])
                ? Carbon::parse($weatherData['forecast']['forecastday'][0]['date'])->toDateString()
                : Carbon::create(1000, 1, 1)->toDateString();
                $maxCelsius = $weatherData['forecast']['forecastday'][0]['day']['maxtemp_c']??-1000;
                $minCelsius = $weatherData['forecast']['forecastday'][0]['day']['mintemp_c']??-1000;
                $averageCelsius = $weatherData['forecast']['forecastday'][0]['day']['avgtemp_c']??-1000;
                $uv = $weatherData['forecast']['forecastday'][0]['day']['uv']??-1000;
                $rain_chance = $weatherData['forecast']['forecastday'][0]['day']['daily_chance_of_rain']??-1000;
                $snow_chance = $weatherData['forecast']['forecastday'][0]['day']['daily_chance_of_snow']??-1000;
                $expected_maximum_rain = $weatherData['forecast']['forecastday'][0]['day']['totalprecip_mm']??-1000;
                $expected_maximum_snow = $weatherData['forecast']['forecastday'][0]['day']['totalsnow_cm']??-1000;
                $expected_maximum_rain_tomorrow = $weatherData['forecast']['forecastday'][1]['day']['totalprecip_mm']??-1000;
                $expected_maximum_snow_tomorrow = $weatherData['forecast']['forecastday'][1]['day']['totalsnow_cm']??-1000;
                $condition = $weatherData['forecast']['forecastday'][0]['day']['condition'];
                $astro = $weatherData['forecast']['forecastday'][0]['astro'] ;

                $weatherData = [
                    'city'=> $location,
                    'date'=> $date,
                    'max_celsius' => $maxCelsius,
                    'min_celsius' => $minCelsius,
                    'average_celsius' => $averageCelsius,
                    'uv' => $uv,
                    'rain_chance' => $rain_chance,
                    'snow_chance' => $snow_chance,
                    'expected_maximum_rain' => $expected_maximum_rain,
                    'expected_maximum_snow' => $expected_maximum_snow,
                    'expected_maximum_snow_tomorrow' => $expected_maximum_snow_tomorrow,
                    'expected_maximum_rain_tomorrow' => $expected_maximum_rain_tomorrow,
                    'condition' => json_encode($condition),
                    'astro' => json_encode($astro),

                ];
                Cache::put($cacheKey, $weatherData, now()->addDay());

        }
        return $weatherData;
    }
}
