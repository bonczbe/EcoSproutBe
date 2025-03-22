<?php

namespace Database\Factories;

use App\Models\Weather;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'average_celsius' => $this->faker->randomFloat(2, -10, 40),
            'uv' => $this->faker->numberBetween(0, 11),
            'rain_chance' => $this->faker->numberBetween(0, 100),
            'snow_chance' => $this->faker->numberBetween(0, 100),
            'expected_maximum_rain' => $this->faker->randomFloat(2, 0, 50),
            'expected_maximum_snow' => $this->faker->randomFloat(2, 0, 50),
            'expected_maximum_rain_tomorrow' => $this->faker->randomFloat(2, 0, 50),
            'expected_maximum_snow_tomorrow' => $this->faker->randomFloat(2, 0, 50),
            'condition' => [
                'text' => $this->faker->word(),
                'icon' => $this->faker->word() . '.png',
            ],
            'astro' => [
                'sunrise' => $this->faker->time(),
                'sunset' => $this->faker->time(),
                'moonrise' => $this->faker->time(),
                'moonset' => $this->faker->time(),
                'moon_phase' => $this->faker->text(),
                'moon_illumination' => $this->faker->numberBetween(0,100),
                'is_moon_up' => $this->faker->boolean(),
                'is_sun_up' => $this->faker->boolean(),
            ],
        ];
    }
}
