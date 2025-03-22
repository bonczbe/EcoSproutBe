<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    protected $fillable = [
        'name',
        'location',
        'is_on',
        'is_inside',
        'city',
    ];
    protected $casts = [
        'is_on' => 'boolean',
        'is_inside' => 'boolean',
    ];

    public function histories(): HasMany
    {
        return $this->hasMany(DeviceHistory::class);
    }
    public function customerplants(): HasMany
    {
        return $this->hasMany(CustomerPlant::class);
    }
}
