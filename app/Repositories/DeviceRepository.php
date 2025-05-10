<?php

namespace App\Repositories;

use App\Models\Device;
use App\Models\DeviceHistory;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DeviceRepository
{
    public function getAllCityNames(): array
    {
        return Device::all()->pluck('city')->toArray();
    }

    public function getAllWithHistoriesForUser($user): Collection
    {
        return Device::with('histories')
            ->forUser($user)->get();
    }

    public function getHistoryStartDateForUser($user): ?string
    {
        return DeviceHistory::forUser($user)->orderBy('created_at')
            ->limit(1)
            ->value('created_at');
    }

    public function getDeviceHistoriesByDate($startDate, $endDate, $device,$user): array
    {
        return DeviceHistory::query()
        ->forUser($user)
            ->where('device_id', $device)
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->get()
            ->toArray();
    }

    public function getDevicesHistoriesByDate($startDate, $endDate,$user): array
    {
        return DeviceHistory::select([
            DB::raw('updated_at'),
            DB::raw('AVG(water_level) as water_level'),
            DB::raw('AVG(temperature) as temperature'),
        ])->forUser($user)
            ->whereBetween('updated_at', [$startDate, $endDate])
            ->groupBy('updated_at')
            ->orderBy('updated_at')
            ->get()
            ->toArray();
    }
}
