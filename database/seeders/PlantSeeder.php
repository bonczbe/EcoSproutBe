<?php

namespace Database\Seeders;

use App\Models\Plant;
use Illuminate\Database\Seeder;

class PlantSeeder extends Seeder
{
    public function run(): void
    {
        $plants = [
            [
                'name_en' => 'Rose',
                'name_hu' => 'Rózsa',
                'name_botanical' => 'Rosa indica',
                'other_names' => json_encode(['Garden rose']),
                'default_image' => json_encode(['url' => 'images/rose.jpg']),
                'species_epithet' => 'indica',
                'genus' => 'Rosa',
                'plant_type_id' => 2,
            ],
            [
                'name_en' => 'Orchid',
                'name_hu' => 'Orchidea',
                'name_botanical' => 'Phalaenopsis amabilis',
                'other_names' => json_encode(['Moth orchid']),
                'default_image' => json_encode(['url' => 'images/orchid.jpg']),
                'species_epithet' => 'amabilis',
                'genus' => 'Phalaenopsis',
                'plant_type_id' => 2,
            ],
            [
                'name_en' => 'Tulip',
                'name_hu' => 'Tulipán',
                'name_botanical' => 'Tulipa gesneriana',
                'other_names' => json_encode(['Garden tulip']),
                'default_image' => json_encode(['url' => 'images/tulip.jpg']),
                'species_epithet' => 'gesneriana',
                'genus' => 'Tulipa',
                'plant_type_id' => 2,
            ],
            [
                'name_en' => 'Lavender',
                'name_hu' => 'Levendula',
                'name_botanical' => 'Lavandula angustifolia',
                'other_names' => json_encode(['English lavender']),
                'default_image' => json_encode(['url' => 'images/lavender.jpg']),
                'species_epithet' => 'angustifolia',
                'genus' => 'Lavandula',
                'plant_type_id' => 2,
            ],
            [
                'name_en' => 'Sunflower',
                'name_hu' => 'Napraforgó',
                'name_botanical' => 'Helianthus annuus',
                'other_names' => json_encode(['Common sunflower']),
                'default_image' => json_encode(['url' => 'images/sunflower.jpg']),
                'species_epithet' => 'annuus',
                'genus' => 'Helianthus',
                'plant_type_id' => 2,
            ],
            [
                'name_en' => 'Daffodil',
                'name_hu' => 'Nárcisz',
                'name_botanical' => 'Narcissus pseudonarcissus',
                'other_names' => json_encode(['Wild daffodil']),
                'default_image' => json_encode(['url' => 'images/daffodil.jpg']),
                'species_epithet' => 'pseudonarcissus',
                'genus' => 'Narcissus',
                'plant_type_id' => 2,
            ],
        ];

        foreach ($plants as $plant) {
            Plant::create($plant);
        }

        // Plant::factory(10)->create();
    }
}
