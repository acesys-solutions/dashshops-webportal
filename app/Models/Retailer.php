<?php

namespace App\Models;

use App\Models\Favorite;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Retailer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $table = 'retailers';

    protected $fillable = [
        'business_name',
        'business_address',
        'business_description',
        'firstname',
        'lastname',
        'phone_number',
        'email',
        'type_of_business',
        'business_hours_open',
        'business_hours_close',
        'city',
        'state',
        'zip_code',
        'web_url',
        'banner_image',
        'password',
        'longitude',
        'latitude',
        'island',
        'approval_status',
        'approved_at',
        'from_mobile',
        'created_by',
        'modified_by'
    ];

    /**
     * Get the category that the retailer belongs to
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'type_of_business');
    }

    /**
     * Get the coupons that belong to the retailer
     *
     * @return HasMany
     */
    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }

    /**
     * Get the user that created the retailer
     *
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user that modified the retailer
     *
     * @return BelongsTo
     */
    public function modifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'modified_by');
    }

    /**
     * Get the favorites for the retailer
     *
     * @return HasMany
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }

    /**
     * Get the products for the retailer
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get the ratings for the retailer
     *
     * @return HasMany
     */
    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Get the sales retailers for the retailer
     *
     * @return HasMany
     */
    public function salesRetailers(): HasMany
    {
        return $this->hasMany(SalesRetailer::class);
    }
}
