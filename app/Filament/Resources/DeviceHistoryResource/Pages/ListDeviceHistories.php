<?php

namespace App\Filament\Resources\DeviceHistoryResource\Pages;

use App\Filament\Resources\DeviceHistoryResource;
use App\Filament\Resources\DeviceHistoryResource\Widgets\DeviceHistoryFilters;
use App\Filament\Resources\DeviceHistoryResource\Widgets\DeviceTemperatureChart;
use App\Filament\Resources\DeviceHistoryResource\Widgets\DeviceWaterChart;
use Filament\Actions;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Resources\Pages\ListRecords;

class ListDeviceHistories extends ListRecords
{
    use HasFiltersForm;

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
            DeviceHistoryFilters::class,
            DeviceWaterChart::class,
            DeviceTemperatureChart::class,
        ];
    }
}
