<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DriversPayout extends Model
{
    use HasFactory;

    protected $table = 'drivers_payouts';

    protected $fillable = [
        'sale_id',
        'driver_id',
        'amount',
        'status',
    ];
}
