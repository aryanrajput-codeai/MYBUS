<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusPoint extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_schedule_id',
        'type',
        'point_name',
        'landmark',
        'point_time',
        'sort_order',
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(BusSchedule::class, 'bus_schedule_id');
    }
}
