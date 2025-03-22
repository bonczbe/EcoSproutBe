<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plant extends Model
{

    protected $fillable = [
        'name',
    ];

    public function customerplants(): HasMany
    {
        return $this->hasMany(CustomerPlant::class);
    }
}
