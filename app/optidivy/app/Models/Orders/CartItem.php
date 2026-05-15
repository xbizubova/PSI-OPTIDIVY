<?php

namespace App\Models\Orders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'product_id', 'product_type', 'quantity'];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Orders\Cart::class);
    }

    public function product(): MorphTo
    {
        return $this->morphTo();
    }

    public function getSubtotal(): float
    {
        return $this->product->getPrice() * $this->quantity;
    }
}
