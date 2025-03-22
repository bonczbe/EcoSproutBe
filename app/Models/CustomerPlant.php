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
        'maximum_moisture',
        'minimum_moisture',
        'dirt_type',
        'device_id',
        'plant_id',
    ];

    public function device(): BelongsTo
    {
        return $this->belongsTo(Device::class);
    }

    public function plant(): BelongsTo
    {
        return $this->belongsTo(Plant::class);
    }
    public function histories(): HasMany
    {
        return $this->hasMany(PlantHistory::class, 'customer_plant_id');
    }
}
