<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Weather;

class WeatherFactory extends Factory
{
    protected $model = Weather::class;

    public function definition(): array
    {
        return [
            'city' => $this->faker->city(),
            'date' => $this->faker->date(),
            'max_celsius' => $this->faker->randomFloat(2, -10, 40),
            'min_celsius' => $this->faker->randomFloat(2, -10, 40),
            'cloudy' => $this->faker->boolean(),
            'rainy' => $this->faker->boolean(),
            'expected_maximum_rain' => $this->faker->randomFloat(2, 0, 50),
        ];
    }
}
