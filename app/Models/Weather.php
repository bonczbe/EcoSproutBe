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
        'uv_tomorrow',
        'rain_chance',
        'snow_chance',
        'rain_chance_tomorrow',
        'snow_chance_tomorrow',
        'expected_maximum_rain',
        'expected_maximum_snow',
        'expected_maximum_rain_tomorrow',
        'expected_maximum_snow_tomorrow',
        'condition',
        'astro',
        'city',
        'expected_max_celsius',
        'expected_min_celsius',
        'expected_avgtemp_celsius',
    ];

    protected $casts = [
        'date' => 'date',
        'expected_maximum_rain' => 'decimal:5',
        'expected_maximum_snow' => 'decimal:5',
        'rain_chance' => 'integer',
        'snow_chance' => 'integer',
        'rain_chance_tomorrow' => 'integer',
        'snow_chance_tomorrow' => 'integer',
        'expected_maximum_rain_tomorrow' => 'decimal:5',
        'expected_maximum_snow_tomorrow' => 'decimal:5',
        'condition' => 'array',
        'astro' => 'array',
        'uv' => 'integer',
    ];

    public function getDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    }
}
