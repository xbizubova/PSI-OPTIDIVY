<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = ['customer_id'];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Users\User::class, 'customer_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(\App\Models\Orders\CartItem::class);
    }

    public function getTotal(): float
    {
        return $this->items->sum(fn($item) => $item->getSubtotal());
    }
}
