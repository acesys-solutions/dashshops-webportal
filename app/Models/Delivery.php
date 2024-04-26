<?php

namespace App\Models;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    use HasFactory;

    protected $table = 'deliveries';

    protected $fillable = [
        'sales_id',
        'driver_id',
        'delivery_fee',
        'picked_at',
        'delivered_at',
    ];

    protected $casts = [
        'picked_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    /**
     * Get the driver that owns the delivery.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Get the tracking for the delivery.
     */
    public function tracking()
    {
        return $this->hasOne(Tracking::class);
    }

    /**
     * Get the rating for the delivery.
     */
    public function rating()
    {
        return $this->hasOne(DriverRating::class);
    }
}
