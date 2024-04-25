<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdClick extends Model
{
    use HasFactory;

    protected $table = 'ad_clicks';

    protected $fillable = [
        'ad_id',
        'user_id',
        'latitude',
        'longitude',
        'city',
        'state',
        'country'
    ];

    /**
     * Get the ad that was clicked
     */
    public function ad()
    {
        return $this->belongsTo(Ads::class, 'ad_id', 'id');
    }

    /**
     * Get the user that clicked the ad
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
