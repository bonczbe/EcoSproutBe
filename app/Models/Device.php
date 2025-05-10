<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Device extends Model
{
    use HasFactory;

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

    public function customer_plants(): HasMany
    {
        return $this->hasMany(CustomerPlant::class, 'device_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'device_user');
    }

    public function scopeForUser($query, $user)
    {
        return $query->whereHas('users', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        });
    }
}
