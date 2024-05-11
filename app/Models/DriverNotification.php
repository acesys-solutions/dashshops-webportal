<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DriverNotification extends Model
{
    use HasFactory;

    protected $table = 'driver_notifications';

    protected $fillable = [
        'driver_id',
        'title',
        'source_id',
        'type',
        'has_read',
        'trash',
        'content',
    ];

    /**
     * Get the user that owns the notification
     *
     * @return BelongsTo
     */
    public function driver(): BelongsTo
    {
        return $this->belongsTo(Driver::class);
    }
}
