<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    use HasFactory;

    protected $table = 'payment_details';

    protected $fillable = [
        'token',
        'user_id',
        'last4',
        'card_type',
        'exp_month',
        'exp_year',
        'ccv',
        'fullname',
        'email',
        'phone',
        'is_default'
    ];

    
    /**
     * Get the user that clicked the ad
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
