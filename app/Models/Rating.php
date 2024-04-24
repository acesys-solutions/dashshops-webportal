<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    protected $table = 'ratings';

    protected $fillable = [
        'user_id',
        'retailer_id',
        'rating',
        'comments',
        'approval_status'
    ];

    /**
     * Get the user that the rating belongs to
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the retailer that the rating belongs to
     *
     * @return BelongsTo
     */
    public function retailer(): BelongsTo
    {
        return $this->belongsTo(Retailer::class);
    }
}
