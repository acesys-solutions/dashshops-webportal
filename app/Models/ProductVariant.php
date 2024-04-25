<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variation';

    protected $fillable = [
        'product_id',
        'variant_types',
        'variant_type_values',
        'price',
        'on_sale',
        'sale_price',
        'quantity',
        'low_stock_value',
        'sku',
        'status'
    ];

    /**
     * Get the product that owns the product variant
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the cart that owns the product variant
     */
    public function cart()
    {
        return $this->hasMany(Cart::class, 'product_variation_id', 'id');
    }

    /**
     * Get the product favorite that owns the product variant
     */
    public function productFavorites()
    {
        return $this->hasMany(ProductFavorite::class, 'product_variation_id', 'id');
    }
}
