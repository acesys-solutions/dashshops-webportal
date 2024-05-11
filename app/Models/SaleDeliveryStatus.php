<?php

namespace App\Models;

use App\Models\Delivery;
use App\Models\RejectedDelivery;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class SaleDeliveryStatus extends Model
{
    use HasFactory;

    protected $table = 'sale_delivery_status';

    protected $fillable = [
        'sale_id',
        'status',
        'message',
    ];

    protected $casts = [
       
    ];

    /**
     * Get the user that owns the driver.
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class, "sale_id");
    }

    /**
     * Get the deliveries for the driver.
     */
    public function deliveries()
    {
        return $this->hasMany(Delivery::class);
    }
}
