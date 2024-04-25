<?php

namespace App\Models;

use App\Models\Coupon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class CouponRedeemed extends Model
{
    use HasFactory;
    protected $table = 'coupon_redemption';

    protected $fillable = [
        'coupon_id',
        'user_id',
        'coupon_download_id',
        'redemption_code'
    ];

    /**
     * Get the coupon that owns the coupon redeemed
     *
     * @return BelongsTo
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get the user that owns the coupon redeemed
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
