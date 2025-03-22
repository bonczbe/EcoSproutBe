<?php

namespace Database\Seeders;

use App\Models\Weather;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class WeatherSeeder extends Seeder
{
    public function run(): void
    {
        Weather::create([
            'city' => 'New York',
            'date' => Carbon::today(),
            'max_celsius' => 28.5,
            'min_celsius' => 18.3,
            'cloudy' => true,
            'rainy' => false,
            'expected_maximum_rain' => 0.0,
        ]);

        Weather::factory(10)->create();
    }
}
