<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetailersPayout extends Model
{
    use HasFactory;

    protected $table = 'retailers_payouts';

    protected $fillable = [
        'sale_id',
        'retailer_id',
        'amount',
        'status',
    ];
}
