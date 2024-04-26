<?php

namespace App\Models;

use App\Models\Delivery;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriverRating extends Model
{
    use HasFactory;

    protected $table = 'driver_ratings';

    protected $fillable = [
        'delivery_id',
        'rating',
    ];

    /**
     * Get the delivery that owns the rating.
     */
    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }
}
