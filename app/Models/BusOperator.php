<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BusOperator extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'logo',
        'rating',
        'total_reviews',
        'contact_phone',
        'contact_email',
        'address',
        'is_active',
    ];

    protected $casts = [
        'rating' => 'float',
        'total_reviews' => 'integer',
        'is_active' => 'boolean',
    ];

    public function fleets(): HasMany
    {
        return $this->hasMany(BusFleet::class);
    }
}
