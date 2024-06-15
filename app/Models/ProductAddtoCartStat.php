<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductAddtoCartStat extends Model
{
    use HasFactory;
    protected $table = 'product_addtocarts';

    protected $fillable = [
        'product_id',
        'clicks',
        'city',
        'state'
    ];

    /**
     * Get the coupon that the click belongs to
     *
     * @return BelongsTo
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
