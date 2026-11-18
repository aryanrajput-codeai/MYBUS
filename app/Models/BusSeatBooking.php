<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusSeatBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'bus_schedule_id',
        'customer_id',
        'pnr_number',
        'travel_date',
        'seat_number',
        'deck',
        'seat_type',
        'passenger_name',
        'passenger_age',
        'passenger_gender',
        'contact_phone',
        'contact_email',
        'boarding_point',
        'dropping_point',
        'seat_fare',
        'gst_amount',
        'total_fare',
        'status',
        'payment_status',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'passenger_age' => 'integer',
        'seat_fare' => 'float',
        'gst_amount' => 'float',
        'total_fare' => 'float',
    ];

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(BusSchedule::class, 'bus_schedule_id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
