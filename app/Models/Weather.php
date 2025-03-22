<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Weather extends Model
{
    use HasFactory;

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
        'expected_maximum_rain' => 'decimal:2',
    ];
}
