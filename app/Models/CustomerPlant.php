<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerPlant extends Model
{
    use HasFactory;

    protected $fillable = [
        'maximum_moisture', // TODO: Delete in the future
        'minimum_moisture', // TODO: Delete in the future
        'pot_size',
        'name',
        'plant_img',
        'dirt_type',
        'device_id',
        'plant_id',
        'plant_type_id',
        'pin_number',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }

    public function plantType()
    {
        return $this->belongsTo(PlantType::class);
    }

    public function latestHistory()
    {
        return $this->hasOne(PlantHistory::class, 'customer_plant_id')->latestOfMany();
    }

    public function histories(): HasMany
    {
        return $this->hasMany(PlantHistory::class, 'customer_plant_id');
    }

    public function scopeForUser($query, $user)
    {
        return $query->whereHas('device.users', function ($q) use ($user) {
            $q->where('users.id', $user->id);
        });
    }
}
