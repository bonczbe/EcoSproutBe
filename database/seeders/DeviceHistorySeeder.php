<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeviceHistory;
use App\Models\Device;

class DeviceHistorySeeder extends Seeder
{
    public function run(): void
    {
        $device = Device::first();

        if ($device) {
            DeviceHistory::create([
                'water_level' => 70.5,
                'temperature' => 22.3,
                'device_id' => $device->id,
            ]);
        }

        DeviceHistory::factory(10)->create();
    }
}
