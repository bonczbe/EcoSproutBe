<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    protected $fillable = [
        'date',
        'max_celsius',
        'min_celsius',
        'cloudy',
        'rainy',
        'expected_maximum_rain',
        'city',
    ];

    protected $casts = [
        'cloudy' => 'boolean',
        'rainy' => 'boolean',
        'date' => 'date',
    ];
}
