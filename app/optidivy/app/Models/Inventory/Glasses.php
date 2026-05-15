<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Glasses extends Model implements \App\Models\Product
{
    protected $fillable = ['frame_id', 'lense_id'];

    public function frame(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Inventory\Frame::class);
    }

    public function lense(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Inventory\Lense::class);
    }

    public function addToCart(\App\Models\Orders\Cart $cart, int $qty = 1): void
    {
        \App\Models\CartItem::updateOrCreate(
            [
                'cart_id'      => $cart->id,
                'product_id'   => $this->id,
                'product_type' => static::class,
            ],
            ['quantity' => $qty]
        );
    }

    public function getPrice(): float
    {
        return $this->frame->stock->getPrice() + $this->lense->stock->getPrice();
    }

    public function getStock(): ?\App\Models\Inventory\Stock
    {
        return null;
    }
}
