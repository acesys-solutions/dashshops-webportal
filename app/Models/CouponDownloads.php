<?php

namespace App\Models;

use App\Models\Coupon;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CouponDownloads extends Model
{
    use HasFactory;
    protected $table = 'coupons_download';

    protected $fillable = [
        'user_id',
        'coupon_id',
        'coupon_code',
        'downloads'
    ];

    /**
     * Get the user that owns the coupon download
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the coupon that owns the coupon download
     *
     * @return BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
