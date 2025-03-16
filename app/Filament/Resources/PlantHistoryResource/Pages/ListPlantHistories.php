<?php

namespace App\Filament\Resources\PlantHistoryResource\Pages;

use App\Filament\Resources\PlantHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlantHistories extends ListRecords
{
    protected static string $resource = PlantHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
