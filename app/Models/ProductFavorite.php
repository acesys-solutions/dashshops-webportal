<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductFavorite extends Model
{
    use HasFactory;

    protected $table = 'product_favorites';

    protected $fillable = [
        'user_id',
        'product_variation_id',
        'expired_at',
    ];

    /**
     * Get the user that owns the product favorite
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product variant that owns the product favorite
     *
     * @return BelongsTo
     */
    public function productVariant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class);
    }
}
