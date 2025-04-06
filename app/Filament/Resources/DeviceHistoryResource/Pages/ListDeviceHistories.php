<?php

namespace App\Filament\Resources\DeviceHistoryResource\Pages;

use App\Filament\Resources\DeviceHistoryResource;
use App\Filament\Resources\DeviceHistoryResource\Widgets\DeviceTemperatureChart;
use App\Filament\Resources\DeviceHistoryResource\Widgets\DeviceWaterChart;
use App\Filament\Resources\DeviceHistoryResource\Widgets\Filters;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDeviceHistories extends ListRecords
{
    protected static string $resource = DeviceHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Filters::class,
            DeviceWaterChart::class,
            DeviceTemperatureChart::class,
        ];
    }
}
