<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PlantHistory;
use App\Models\CustomerPlant;

class PlantHistoryFactory extends Factory
{
    protected $model = PlantHistory::class;

    public function definition(): array
    {
        return [
            'customer_plant_id' => CustomerPlant::factory(),
            'moisture_level' => $this->faker->randomFloat(2, 0, 100),
        ];
    }
}
