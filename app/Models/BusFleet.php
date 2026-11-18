<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BusFleet extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_operator_id',
        'bus_number',
        'bus_name',
        'bus_type',
        'deck_type',
        'total_seats',
        'amenities',
        'is_active',
    ];

    protected $casts = [
        'amenities' => 'array',
        'total_seats' => 'integer',
        'is_active' => 'boolean',
    ];

    public function operator(): BelongsTo
    {
        return $this->belongsTo(BusOperator::class, 'bus_operator_id');
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(BusSchedule::class);
    }

    public function seatLayouts(): HasMany
    {
        return $this->hasMany(BusSeatLayout::class)->orderBy('row_num')->orderBy('col_num');
    }
}
