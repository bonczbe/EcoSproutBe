<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CustomerPlant extends Model
{
    protected $fillable = [
        'maximum_moisture',
        'minimum_moisture',
        'dirt_type',
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
        return $this->hasMany(PlantHistory::class);
    }
}
