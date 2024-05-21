<?php

namespace App\Models;

use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'alias',
        'image',
        'images',
        'store_id',
        'description',
        'overview',
        'tags',
        'waranty',
        'status',
        'category_id',
    ];

    /**
     * Get the product variants for the product
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Get the store that owns the product
     */
    public function retailer()
    {
        return $this->belongsTo(Retailer::class, 'store_id', 'id');
    }

    /**
     * Get the category that owns the product
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
