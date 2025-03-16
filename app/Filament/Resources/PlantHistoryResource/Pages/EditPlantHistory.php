<?php

namespace App\Filament\Resources\PlantHistoryResource\Pages;

use App\Filament\Resources\PlantHistoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlantHistory extends EditRecord
{
    protected static string $resource = PlantHistoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
