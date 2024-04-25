<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LoginToken extends Model
{
    use HasFactory;

    protected $table = 'login_tokens';

    protected $fillable = [
        'user_id',
        'token',
        'device_token',
        'device_type'
    ];

    /**
     * Get the user that owns the login token
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
