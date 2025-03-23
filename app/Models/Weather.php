<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'time_zone',
        'max_celsius',
        'min_celsius',
        'average_celsius',
        'totalprecip_mm',
        'uv',
        'rain_chance',
        'snow_chance',
        'expected_maximum_rain',
        'expected_maximum_snow',
        'expected_maximum_rain_tomorrow',
        'expected_maximum_snow_tomorrow',
        'condition',
        'astro',
        'city',
    ];

    protected $casts = [
        'date' => 'date',
        'expected_maximum_rain' => 'decimal:2',
        'expected_maximum_snow' => 'decimal:2',
        'rain_chance' => 'integer',
        'snow_chance' => 'integer',
        'expected_maximum_rain_tomorrow' => 'decimal:2',
        'expected_maximum_snow_tomorrow' => 'decimal:2',
        'condition' => 'array',
        'astro' => 'array',
        'uv' => 'integer',
    ];
}
