<?php

namespace App\Models;

use App\Models\Delivery;
use App\Models\RejectedDelivery;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';

    protected $fillable = [
        'user_id',
        'approval_status',
        'available',
        'driver_licence',
        'car_reg_details',
        'acceptance_rating',
        'bank_details',
        'hourly_delivery_rate',
        'current_location',
    ];

    protected $casts = [
        'available' => 'boolean',
        'driver_licence' => 'array',
        'car_reg_details' => 'array',
        'acceptance_rating' => 'array',
        'bank_details' => 'array',
        'current_location' => 'array',
    ];

    /**
     * Get the user that owns the driver.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the deliveries for the driver.
     */
    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }

    /**
     * Get the rejected deliveries for the driver.
     */
    public function rejectedDeliveries()
    {
        return $this->hasMany(RejectedDelivery::class);
    }
}
