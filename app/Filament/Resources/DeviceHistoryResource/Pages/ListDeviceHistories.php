<?php

namespace App\Filament\Resources\DeviceHistoryResource\Pages;

use App\Filament\Resources\DeviceHistoryResource;
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
}
