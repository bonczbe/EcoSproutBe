<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Device;

class DeviceSeeder extends Seeder
{
    public function run(): void
    {
        Device::create([
            'name' => 'Smart Irrigation Sensor',
            'city' => 'New York',
            'location' => 'Greenhouse 1',
            'is_inside' => true,
            'is_on' => true,
        ]);

        Device::factory(10)->create();
    }
}
