<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Device;

class DeviceFactory extends Factory
{
    protected $model = Device::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'city' => $this->faker->city(),
            'location' => $this->faker->streetAddress(),
            'is_inside' => $this->faker->boolean(),
            'is_on' => $this->faker->boolean(),
        ];
    }
}
