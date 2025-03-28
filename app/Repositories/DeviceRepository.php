<?php

namespace App\Repositories;

use App\Models\Device;

class DeviceRepository
{
    public function getAllCityNames(): array
    {
        return Device::all()->pluck('city')->toArray();
    }
}
