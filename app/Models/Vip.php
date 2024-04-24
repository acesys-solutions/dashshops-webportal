<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Vip extends Model
{
    use HasFactory;

    protected $table = 'vips';

    protected $fillable = [
        'user_id',
        'expiry_date'
    ];

    /**
     * Get the user that the vip belongs to
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
