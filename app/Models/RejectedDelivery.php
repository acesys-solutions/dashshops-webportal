<?php

namespace App\Models;

use App\Models\Driver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class RejectedDelivery extends Model
{
    use HasFactory;

    protected $table = 'rejected_deliveries';

    protected $fillable = [
        'driver_id',
        'sales_id',
    ];

    /**
     * Get the driver that owns the rejected delivery.
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
    /**
     * Get the sale order that the sales belongs to
     *
     * @return BelongsTo
     */
    public function sale_order(): BelongsTo
    {
        return $this->belongsTo(SaleOrder::class, 'sales_id');
    }
}
