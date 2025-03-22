<?php

namespace App\Filament\Resources\CustomerPlantResource\Pages;

use App\Filament\Resources\CustomerPlantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCustomerPlant extends EditRecord
{
    protected static string $resource = CustomerPlantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
