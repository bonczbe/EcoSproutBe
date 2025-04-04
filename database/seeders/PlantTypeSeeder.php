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
                'type' => 'Xerophytes',
                'type_hu' => 'Szárazságtűrő növények',
                'min_soil_moisture' => 5,
                'max_soil_moisture' => 20,
            ],
            [
                'type' => 'Dry-Mesophytes',
                'type_hu' => 'Szárazságtűrő mezofiták',
                'min_soil_moisture' => 10,
                'max_soil_moisture' => 30,
            ],
            [
                'type' => 'Mesophytes',
                'type_hu' => 'Közepes vízigényű növények',
                'min_soil_moisture' => 20,
                'max_soil_moisture' => 50,
            ],
            [
                'type' => 'Hydro-Mesophytes',
                'type_hu' => 'Nedves környezetet kedvelő növények',
                'min_soil_moisture' => 40,
                'max_soil_moisture' => 80,
            ],
            [
                'type' => 'Hydrophytes',
                'type_hu' => 'Vízinövények',
                'min_soil_moisture' => 80,
                'max_soil_moisture' => 100,
            ],
        ];

        PlantType::insert($plantTypes);
    }
}
