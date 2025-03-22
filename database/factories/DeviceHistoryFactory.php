<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\DeviceHistory;
use App\Models\Device;

class DeviceHistoryFactory extends Factory
{
    protected $model = DeviceHistory::class;

    public function definition(): array
    {
        return [
            'device_id' => Device::factory(),
            'water_level' => $this->faker->randomFloat(2, 0, 100),
            'temperature' => $this->faker->randomFloat(2, -10, 50),
        ];
    }
}
