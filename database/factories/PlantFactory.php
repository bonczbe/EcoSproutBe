<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Plant;

class PlantFactory extends Factory
{
    protected $model = Plant::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
        ];
    }
}
