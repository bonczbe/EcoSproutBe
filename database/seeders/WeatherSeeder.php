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
            'average_celsius' => 23.4,
            'uv' => 6,
            'rain_chance' => 40,
            'snow_chance' => 0,
            'expected_maximum_rain' => 5.2,
            'expected_maximum_snow' => 0.0,
            'expected_maximum_rain_tomorrow' => 1,  // 1 = Yes, 0 = No
            'expected_maximum_snow_tomorrow' => 0,  // 1 = Yes, 0 = No
            'condition' => ['text' => 'Clear', 'icon' => 'clear_icon.png'],
            'astro' => ['sunrise' => '06:00', 'sunset' => '18:00'],
        ]);

        Weather::factory(10)->create();
    }
}
