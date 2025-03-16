<?php

namespace App\Filament\Resources\WeatherResource\Pages;

use App\Filament\Resources\WeatherResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWeather extends EditRecord
{
    protected static string $resource = WeatherResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
