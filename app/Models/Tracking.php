<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tracking extends Model
{
    use HasFactory;

    protected $table = 'tracking';

    protected $fillable = [
        'delivery_id',
        'latitude',
        'longitude',
        'city',
        'state',
        'zip',
        'location_log',
    ];

    protected $casts = [
        'location_log' => 'array',
    ];

    /**
     * Get the delivery that owns the tracking.
     */
    public function delivery()
    {
        return $this->belongsTo(Delivery::class);
    }
}
