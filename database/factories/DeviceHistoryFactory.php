<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\DeviceHistory;
use Illuminate\Database\Eloquent\Factories\Factory;

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
