<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverToken extends Model
{
    use HasFactory;

    protected $table = 'driver_tokens';

    protected $fillable = [
        'driver_id',
        'token',
        'device_token',
        'device_type'
    ];

    /**
     * Get the user that owns the login token
     *
     * @return BelongsTo
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
