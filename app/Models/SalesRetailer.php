<?php

namespace App\Models;

use App\Models\Retailer;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SalesRetailer extends Model
{
    use HasFactory;

    protected $table = 'sales_retailers';

    protected $fillable = [
        'sales_user_id',
        'retailer_id'
    ];

    /**
     * Get the user that the sales retailer belongs to
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sales_user_id');
    }

    /**
     * Get the retailer that the sales retailer belongs to
     *
     * @return BelongsTo
     */
    public function retailer(): BelongsTo
    {
        return $this->belongsTo(Retailer::class);
    }
}
