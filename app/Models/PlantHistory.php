<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlantHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'moisture_level',
    ];

    public function customerPlant(): BelongsTo
    {
        return $this->belongsTo(CustomerPlant::class, 'customer_plant_id');
    }
}
