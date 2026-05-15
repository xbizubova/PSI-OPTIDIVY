<?php

namespace App\Models\Appointments;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    protected $fillable = [
        'customer_id', 'optometrist_id', 'date', 'slot', 'booked'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Users\User::class, 'customer_id');
    }

    public function optometrist(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Users\User::class, 'optometrist_id');
    }
}
