<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Ads extends Model
{
    use HasFactory;

    protected $table = 'ads';

    protected $fillable = [
        'image',
        'url',
        'total_clicks',
        'start_date',
        'end_date',
        'created_by',
        'modified_by'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime'
    ];

    /**
     * Get the user that created the ad
     */
    public function createdBy(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    /**
     * Get the user that modified the ad
     */
    public function modifiedBy(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'modified_by');
    }

    /**
     * Get all clicks for the ad
     */
    public function clicks()
    {
        return $this->hasMany(AdClick::class, 'ad_id', 'id');
    }
}
