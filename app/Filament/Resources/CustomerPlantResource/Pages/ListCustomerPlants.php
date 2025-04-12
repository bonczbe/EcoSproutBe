<?php

namespace App\Filament\Resources\CustomerPlantResource\Pages;

use App\Filament\Resources\CustomerPlantResource;
use App\Filament\Resources\CustomerPlantResource\Widgets\CustomerPlantFilters;
use App\Filament\Resources\CustomerPlantResource\Widgets\WaterChart;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCustomerPlants extends ListRecords
{
    protected static string $resource = CustomerPlantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            CustomerPlantFilters::class,
            WaterChart::class,
        ];
    }
}
