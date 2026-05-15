<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ContactLenses extends Model implements \App\Models\Inventory\Product
{
    protected $fillable = ['stock_id', 'wear_period'];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Inventory\Stock::class);
    }

    public function getPrice(): float
    {
        return $this->stock->getPrice();
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

    public function getStock(): \App\Models\Inventory\Stock
    {
        return $this->stock;
    }
}
