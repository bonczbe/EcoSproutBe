<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlantType extends Model
{
    use HasFactory;

    protected $table = 'plant_types';

    protected $fillable = [
        'type',
        'min_soil_moisture',
        'max_soil_moisture',
    ];

    public function customerPlants()
    {
        return $this->belongsToMany(CustomerPlant::class, 'customer_plant_plant_type');
    }
}
