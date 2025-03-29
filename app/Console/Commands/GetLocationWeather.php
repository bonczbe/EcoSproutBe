<?php

namespace App\Console\Commands;

use App\Services\WeatherService;
use Illuminate\Console\Command;

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
