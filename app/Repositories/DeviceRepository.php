<?php

namespace App\Repositories;

use App\Models\Device;
use App\Models\DeviceHistory;
use Illuminate\Support\Collection;

class DeviceRepository
{
    public function getAllCityNames(): array
    {
        return Device::all()->pluck('city')->toArray();
    }

    public function getAllWithHistories(): Collection
    {
        return Device::with('histories')->get();
    }

    public function getHistoryStartDate(): ?string
    {
        return DeviceHistory::orderBy('created_at')
            ->limit(1)
            ->value('created_at');
    }
}
