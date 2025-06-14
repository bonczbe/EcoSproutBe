<?php

namespace Database\Seeders;

use App\Models\CustomerPlant;
use App\Models\Device;
use App\Models\Plant;
use Illuminate\Database\Seeder;

class CustomerPlantSeeder extends Seeder
{
    public function run(): void
    {
        $device = Device::first();
        $plant = Plant::first();

        if ($device && $plant) {
            CustomerPlant::create([
                'dirt_type' => 'mid',
                'device_id' => $device->id,
                'plant_id' => $plant->id,
            ]);
        }

        CustomerPlant::factory(10)->create();
    }
}
