<?php

namespace App\Http\Controllers;

use App\Models\Weather;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Weather $weather)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Weather $weather)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Weather $weather)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Weather $weather)
    {
        //
    }

    public function getWeather(string $location)
    {
        $cacheKey = "weather_{$location}";
        $callCountKey = 'weather_api_call_count';

        $callCount = Cache::get($callCountKey,0);

        $weatherData = Cache::get($cacheKey,false);

        if ($callCount >= 800000) {
            return response()->json(['error' => 'API call limit exceeded for this month'], 429);
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


                $date= $weatherData['forecast']['forecastday'][0]['date'];
                $maxCelsius = $weatherData['forecast']['forecastday'][0]['day']['maxtemp_c'];
                $minCelsius = $weatherData['forecast']['forecastday'][0]['day']['mintemp_c'];
                $averageCelsius = $weatherData['forecast']['forecastday'][0]['day']['avgtemp_c'];
                $uv = $weatherData['forecast']['forecastday'][0]['day']['uv'];
                $rain_chance = $weatherData['forecast']['forecastday'][0]['day']['daily_chance_of_rain'];
                $snow_chance = $weatherData['forecast']['forecastday'][0]['day']['daily_chance_of_snow'];
                $expected_maximum_rain = $weatherData['forecast']['forecastday'][0]['day']['totalprecip_mm'];
                $expected_maximum_snow = $weatherData['forecast']['forecastday'][0]['day']['totalsnow_cm'];
                $expected_maximum_rain_tomorrow = $weatherData['forecast']['forecastday'][1]['day']['totalprecip_mm'];
                $expected_maximum_snow_tomorrow = $weatherData['forecast']['forecastday'][1]['day']['totalsnow_cm'];
                $condition = $weatherData['forecast']['forecastday'][0]['day']['condition'];
                $astro = $weatherData['forecast']['forecastday'][0]['astro'];

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
                    'condition' => $condition,
                    'astro' => $astro,

                ];
                Cache::put($cacheKey, $weatherData, now()->addDay());

        }
        return $weatherData;
    }
}
