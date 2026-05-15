<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lense extends Model
{
    public function stock(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Inventory\Stock::class);
    }
}
