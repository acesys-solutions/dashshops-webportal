<?php

namespace App\Models;

use App\Models\Retailer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sale extends Model
{
    use HasFactory;

    protected $table = 'sales';

    protected $fillable = [
        'user_id',
        'order_ref',
        'product_variation_id',
        'retailer_id',
        'business_name',
        'product_name',
        'product_image',
        'quantity',
        'unit_cost',
        'address',
        'city',
        'state',
        'variation_name',
        'status',
        'shipping_cost'
    ];

    /**
     * Get the user that the sales retailer belongs to
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the retailer that the sales retailer belongs to
     *
     * @return BelongsTo
     */
    public function retailer(): BelongsTo
    {
        return $this->belongsTo(Retailer::class,'retailer_id');
    }
}
