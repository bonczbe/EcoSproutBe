<?php

namespace App\Filament\Resources\WeatherResource\Pages;

use App\Filament\Resources\WeatherResource;
use Filament\Resources\Pages\CreateRecord;

class CreateWeather extends CreateRecord
{
    protected static string $resource = WeatherResource::class;
}
