<?php

namespace App\Models;

use App\Models\CouponClicks;
use App\Models\CouponDownloads;
use App\Models\CouponRedeemed;
use App\Models\Retailer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';
    protected $fillable = [
        'image',
        'name',
        'price',
        'category_id',
        'download_limit',
        'retailer_id',
        'retail_price',
        'discount_now_price',
        'discount_percentage',
        'start_date',
        'end_date',
        'qr_code',
        'discount_description',
        'discount_code',
        'offer_type',
        'approval_status',
        'created_by',
        'modified_by'
    ];

    /**
     * Get the user that created the coupon
     *
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user that modified the coupon
     *
     * @return BelongsTo
     */
    public function modifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    /**
     * Get the category that owns the coupon
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the retailer that owns the coupon
     *
     * @return BelongsTo
     */
    public function retailer(): BelongsTo
    {
        return $this->belongsTo(Retailer::class);
    }

    /**
     * Get the coupon click record associated with the coupon
     *
     * @return HasOne
     */
    public function couponClick(): HasOne
    {
        return $this->hasOne(CouponClicks::class);
    }

    /**
     * Get the coupon download record associated with the coupon
     *
     * @return HasOne
     */
    public function couponDownload(): HasOne
    {
        return $this->hasOne(CouponDownloads::class);
    }

    /**
     * Get the coupon redeemed record associated with the coupon
     *
     * @return HasOne
     */
    public function couponRedeemed(): HasOne
    {
        return $this->hasOne(CouponRedeemed::class);
    }
}
