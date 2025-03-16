<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceHistory extends Model
{
    protected $fillable = [
        'water_level',
        'device_id'
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }
}
