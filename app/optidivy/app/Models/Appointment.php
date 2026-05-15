<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'customer_id', 'optometrist_id', 'date', 'slot', 'booked'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function optometrist(): BelongsTo
    {
        return $this->belongsTo(User::class, 'optometrist_id');
    }
}
