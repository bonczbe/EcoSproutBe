<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PlantHistory;
use App\Models\CustomerPlant;

class PlantHistorySeeder extends Seeder
{
    public function run(): void
    {
        $customerPlant = CustomerPlant::first();

        if ($customerPlant) {
            PlantHistory::create([
                'moisture_level' => 45.6,
                'customer_plant_id' => $customerPlant->id,
            ]);
        }

        PlantHistory::factory(10)->create();
    }
}
