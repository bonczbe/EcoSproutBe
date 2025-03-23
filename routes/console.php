<?php

use App\Console\Commands\GetLocationWeather;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;


Schedule::command(GetLocationWeather::class)->at('0:01');
