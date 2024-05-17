<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Ads;
use App\Models\Coupon;
use App\Models\Favorite;
use App\Models\LoginToken;
use App\Models\Notification;
use App\Models\ProductFavorite;
use App\Models\SalesRetailer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'business_name',
        'business_address',
        'firstname',
        'lastname',
        'photo',
        'city',
        'state',
        'zip_code',
        'email',
        'phone_number',
        'password',
        'user_type',
        'user_status',
        'email_verified_at',
        'remember_token',
        'admin',
        'is_vip',
        'approved_at',
        'retailer_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Get all ads created by user
     */
    public function createdAds(): HasMany
    {
        return $this->hasMany(Ads::class, 'created_by');
    }

    /**
     * Get all ads modified by user
     */
    public function modifiedAds(): HasMany
    {
        return $this->hasMany(Ads::class, 'modified_by');
    }

    /**
     * Get all coupons created by user
     */
    public function createdCoupons(): HasMany
    {
        return $this->hasMany(Coupon::class, 'created_by');
    }

    /**
     * Get all coupons modified by user
     */
    public function modifiedCoupons(): HasMany
    {
        return $this->hasMany(Coupon::class, 'modified_by');
    }

    /**
     * Get all retailers created by user
     */
    public function createdRetailers(): HasMany
    {
        return $this->hasMany(Retailer::class, 'created_by');
    }

    /**
     * Get all retailers modified by user
     */
    public function modifiedRetailers(): HasMany
    {
        return $this->hasMany(Retailer::class, 'modified_by');
    }

    /**
     * Get the coupon download record associated with the user
     */
    public function couponDownload(): HasOne
    {
        return $this->hasOne(CouponDownloads::class);
    }

    /**
     * Get the coupon redeemed record associated with the user
     */
    public function couponRedeemed(): HasOne
    {
        return $this->hasOne(CouponRedeemed::class);
    }

    /**
     * Get the coupon redeemed record associated with the user
     */
    public function retailer(): HasOne
    {
        return $this->hasOne(Retailer::class);
    }

    /**
     * Get the favorites for the user
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get the ad clicks for the user
     */
    public function adClicks(): HasMany
    {
        return $this->hasMany(AdClick::class);
    }

    /**
     * Get the app settings for the user
     */
    public function appSettings(): HasOne
    {
        return $this->hasOne(AppSetting::class);
    }

    /**
     * Get the carts for the user
     */
    public function cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the login tokens for the user
     */
    public function loginTokens(): HasMany
    {
        return $this->hasMany(LoginToken::class);
    }

    /**
     * Get the notifications for the user
     */
    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get the user's product favorites
     */
    public function productFavorites(): HasMany
    {
        return $this->hasMany(ProductFavorite::class);
    }

    /**
     * Get the user's ratings
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get the user's sales retailers
     */
    public function salesRetailers(): HasMany
    {
        return $this->hasMany(SalesRetailer::class, 'sales_user_id');
    }

    /**
     * Get the user's vip status
     */
    public function vip(): HasOne
    {
        return $this->hasOne(Vip::class);
    }

    /**
     * Get the driver record associated with the user
     */
    public function driver(): HasOne
    {
        return $this->hasOne(Driver::class);
    }
}
