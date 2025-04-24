<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_en',
        'name_hu',
        'name_botanical',
        'family',
        'family_hu',
        'default_image',
        'species_epithet',
        'genus',
        'plant_type_id',
    ];

    protected $casts = [
        'default_image' => 'json',
    ];

    public function customer_plants(): HasMany
    {
        return $this->hasMany(CustomerPlant::class);
    }

    public function plantType()
    {
        return $this->belongsTo(PlantType::class);
    }
}
