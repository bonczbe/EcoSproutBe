<?php

namespace Database\Factories;

use App\Models\CustomerPlant;
use App\Models\Device;
use App\Models\Plant;
use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerPlantFactory extends Factory
{
    protected $model = CustomerPlant::class;

    public function definition(): array
    {
        return [
            'maximum_moisture' => $this->faker->randomFloat(2, 0, 100),
            'minimum_moisture' => $this->faker->randomFloat(2, 0, 100),
            'dirt_type' => $this->faker->randomElement(['sandy', 'loamy', 'clay', 'mid']),
            'device_id' => Device::factory(),
            'plant_id' => Plant::factory(),
        ];
    }
}
