<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WeatherService;

class GetLocationWeather extends Command
{
    protected $signature = 'app:get-location-weather';
    protected $description = 'Fetch all the locations and call the weather API for them';

    protected WeatherService $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        parent::__construct();
        $this->weatherService = $weatherService;
    }

    public function handle()
    {
        $this->weatherService->fetchAndStoreWeatherForAllDevices();
    }
}
