<?php

namespace App\Models;

use App\Models\Retailer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Favorite extends Model
{
    use HasFactory;

    protected $table = 'favorites';

    protected $fillable = [
        'user_id',
        'retailer_id'
    ];

    /**
     * Get the user that owns the favorite
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the retailer that owns the favorite
     *
     * @return BelongsTo
     */
    public function retailer(): BelongsTo
    {
        return $this->belongsTo(Retailer::class);
    }
}
