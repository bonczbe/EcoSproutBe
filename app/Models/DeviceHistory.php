<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeviceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'water_level',
        'device_id',
        'temperature',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function scopeForUser($query, $user)
    {
        return $query->whereHas('device.users', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        });
    }
}
