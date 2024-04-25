<?php

namespace App\Models;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CouponClicks extends Model
{
    use HasFactory;
    protected $table = 'coupons_clicks';

    protected $fillable = [
        'coupon_id',
        'clicks',
        'city',
        'state'
    ];

    /**
     * Get the coupon that the click belongs to
     *
     * @return BelongsTo
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }
}
