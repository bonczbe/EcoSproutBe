<?php

use App\Console\Commands\GetLocationWeather;
use App\Console\Commands\GetPlants;
use Illuminate\Support\Facades\Schedule;

Schedule::command(GetLocationWeather::class)->at('0:01');
Schedule::command(GetPlants::class)->at('0:02');
