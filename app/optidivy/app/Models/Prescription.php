<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Prescription extends Model
{
    protected $fillable = [
        'customer_id',
        'od_ostrost',
        'sphere_right',
        'cylinder',
        'axis',
        'pupil_distance',
        'os_ostrost',
        'sphere_left',
        'os_cylinder',
        'os_axis',
        'os_pupil_distance',
        'lens_type',
    ];
    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
