<?php

namespace Database\Seeders;

use App\Models\Plant;
use Illuminate\Database\Seeder;

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
