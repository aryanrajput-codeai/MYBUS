<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusSeatLayout extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_fleet_id',
        'deck',
        'row_num',
        'col_num',
        'seat_number',
        'seat_type',
        'is_ladies_quota',
    ];

    protected $casts = [
        'row_num' => 'integer',
        'col_num' => 'integer',
        'is_ladies_quota' => 'boolean',
    ];

    public function fleet(): BelongsTo
    {
        return $this->belongsTo(BusFleet::class, 'bus_fleet_id');
    }
}
