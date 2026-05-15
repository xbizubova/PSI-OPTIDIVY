<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Glasses extends Model implements Product
{
    protected $fillable = ['frame_id', 'lense_id'];

    public function frame(): BelongsTo
    {
        return $this->belongsTo(Frame::class);
    }

    public function lense(): BelongsTo
    {
        return $this->belongsTo(Lense::class);
    }

    public function addToCart(Cart $cart, int $qty = 1): void
    {
        CartItem::updateOrCreate(
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

    public function getStock(): ?Stock
    {
        return null;
    }
}
