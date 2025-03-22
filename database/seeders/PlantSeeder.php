<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plant;

class PlantSeeder extends Seeder
{
    public function run(): void
    {
        Plant::create(['name' => 'Tomato']);
        Plant::create(['name' => 'Cucumber']);
        Plant::create(['name' => 'Lettuce']);

        Plant::factory(10)->create();
    }
}
