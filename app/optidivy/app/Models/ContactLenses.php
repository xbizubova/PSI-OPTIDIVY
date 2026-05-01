<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ContactLenses extends Model implements Product
{
    protected $fillable = ['stock_id', 'wear_period'];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function getPrice(): float
    {
        return $this->stock->getPrice();
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

    public function getStock(): Stock
    {
        return $this->stock;
    }
}
