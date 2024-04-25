<?php

namespace App\Models;

use App\Models\Coupon;
use App\Models\Retailer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'badge',
        'banner_image'
    ];

    /**
     * Get the retailers that belong to the category
     *
     * @return HasMany
     */
    public function retailers(): HasMany
    {
        return $this->hasMany(Retailer::class);
    }

    /**
     * Get the coupons that belong to the category
     *
     * @return HasMany
     */
    public function coupons(): HasMany
    {
        return $this->hasMany(Coupon::class);
    }


    /**
     * Get the products that belong to the category
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
