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
        'status',
        'service_charge',
        'total_discount',
        'total_cost',
        'delivery_fee',
        'proposed_route',
    ];

    protected $casts = [
        'is_store_pickup' => 'boolean',
        'proposed_routes' => 'array',
    ];

    /**
     * Get the user that placed the sale order.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the deliveries for the driver.
     */
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

}
