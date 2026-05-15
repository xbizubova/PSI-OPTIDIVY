<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class CartItem extends Model
{
    protected $fillable = ['cart_id', 'product_id', 'product_type', 'quantity'];

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
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
