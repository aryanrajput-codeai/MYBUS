<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BusRoute extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_city',
        'destination_city',
        'distance_km',
        'estimated_duration',
        'is_popular',
    ];

    protected $casts = [
        'distance_km' => 'integer',
        'is_popular' => 'boolean',
    ];

    public function schedules(): HasMany
    {
        return $this->hasMany(BusSchedule::class);
    }
}
