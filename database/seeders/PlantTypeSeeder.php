<?php

namespace Database\Seeders;

use App\Models\PlantType;
use Illuminate\Database\Seeder;

class PlantTypeSeeder extends Seeder
{
    public function run(): void
    {
        $plantTypes = [
            [
                'type' => 'Custom',
                'min_soil_moisture' => -100,
                'max_soil_moisture' => -100,
            ],
            [
                'type' => 'Xerophytes',
                'min_soil_moisture' => 5,
                'max_soil_moisture' => 20,
            ],
            [
                'type' => 'Dry-Mesophytes',
                'min_soil_moisture' => 10,
                'max_soil_moisture' => 30,
            ],
            [
                'type' => 'Mesophytes',
                'min_soil_moisture' => 20,
                'max_soil_moisture' => 50,
            ],
            [
                'type' => 'Hydro-Mesophytes',
                'min_soil_moisture' => 40,
                'max_soil_moisture' => 80,
            ],
            [
                'type' => 'Hydrophytes',
                'min_soil_moisture' => 80,
                'max_soil_moisture' => 100,
            ],
        ];

        PlantType::insert($plantTypes);
    }
}
