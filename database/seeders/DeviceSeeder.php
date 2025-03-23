<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Seeder;

class DeviceSeeder extends Seeder
{
    public function run(): void
    {
        Device::create([
            'name' => 'Smart Irrigation Sensor',
            'city' => 'Budapest',
            'location' => 'Greenhouse 1',
            'is_inside' => true,
            'is_on' => true,
        ]);

        Device::factory(10)->create();
    }
}
