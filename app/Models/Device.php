<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    protected $fillable = [
        'name',
        'location',
        'is_on'
    ];

    public function plants(): HasMany
    {
        return $this->hasMany(Plant::class);
    }

    public function histories(): HasMany
    {
        return $this->hasMany(DeviceHistory::class);
    }
}
