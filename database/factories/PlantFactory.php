<?php

namespace Database\Factories;

use App\Models\Plant;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlantFactory extends Factory
{
    protected $model = Plant::class;

    public function definition(): array
    {
        return [
            'name_en' => $this->faker->word(),
            'name_hu' => $this->faker->word(),
            'name_botanical' => $this->faker->words(2, true),
            'other_names' => json_encode([$this->faker->word(), $this->faker->word()]),
            'default_image' => json_encode(['url' => 'images/default.jpg']),
            'species_epithet' => $this->faker->word(),
            'genus' => $this->faker->word(),
            'plant_type_id' => 2,
        ];
    }
}
