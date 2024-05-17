<?php

namespace App\Models;

use App\Models\Delivery;
use App\Models\RejectedDelivery;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleOrder extends Model
{
    use HasFactory;

    protected $table = 'sale_orders';

    protected $fillable = [
        'order_number',
        'user_id',
        'is_store_pickup',
        'driver_id',
        'driver_location',
        'status',
        'service_charge',
        'total_discount',
        'total_cost',
        'total_time',
        'total_duration',
        'delivery_fee',
        'proposed_route',
        'driver_location',
        'address',
        'city',
        'state',
    ];

    protected $casts = [
        'is_store_pickup' => 'boolean',
        'proposed_route' => 'array',
        'driver_location' => 'array',
    ];

    /**
     * Get the user that placed the sale order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user that placed the sale order.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * Get the deliveries for the driver.
     */
    public function sales()
    {
        return $this->hasMany(Sale::class,"order_id");
    }

}
