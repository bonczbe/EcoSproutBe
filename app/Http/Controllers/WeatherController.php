<?php

namespace App\Http\Controllers;

use App\Models\Weather;
use Illuminate\Http\Request;
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
        $response = Http::get('https://api.openweathermap.org/data/2.5/weather', [
            'q' => $location,
            'appid' => env('OPEN_WEATHER', ''),
            'units' => 'metric',
        ]);

        $weatherData = $response->json();
        $maxCelsius = $weatherData['main']['temp_max'];
        $minCelsius = $weatherData['main']['temp_min'];
        $rainy = isset($weatherData['rain']);
        $cloudy = $weatherData['clouds']['all'] > 50;
        $expectedMaximumRain = $rainy ? $weatherData['rain']['1h'] : 0;
    }
}
