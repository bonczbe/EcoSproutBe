<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CustomerPlant;
use App\Models\Device;
use App\Models\Plant;

class CustomerPlantSeeder extends Seeder
{
    public function run(): void
    {
        $device = Device::first();
        $plant = Plant::first();

        if ($device && $plant) {
            CustomerPlant::create([
                'maximum_moisture' => 80,
                'minimum_moisture' => 40,
                'dirt_type' => 'mid',
                'device_id' => $device->id,
                'plant_id' => $plant->id,
            ]);
        }

        CustomerPlant::factory(10)->create();
    }
}
