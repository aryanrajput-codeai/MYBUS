<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BusSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_fleet_id',
        'bus_route_id',
        'departure_time',
        'arrival_time',
        'duration',
        'base_fare',
        'sleeper_fare',
        'seater_fare',
        'is_active',
    ];

    protected $casts = [
        'base_fare' => 'float',
        'sleeper_fare' => 'float',
        'seater_fare' => 'float',
        'is_active' => 'boolean',
    ];

    public function fleet(): BelongsTo
    {
        return $this->belongsTo(BusFleet::class, 'bus_fleet_id');
    }

    public function route(): BelongsTo
    {
        return $this->belongsTo(BusRoute::class, 'bus_route_id');
    }

    public function points(): HasMany
    {
        return $this->hasMany(BusPoint::class)->orderBy('sort_order');
    }

    public function boardingPoints(): HasMany
    {
        return $this->hasMany(BusPoint::class)->where('type', 'boarding')->orderBy('sort_order');
    }

    public function droppingPoints(): HasMany
    {
        return $this->hasMany(BusPoint::class)->where('type', 'dropping')->orderBy('sort_order');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(BusSeatBooking::class);
    }
}
