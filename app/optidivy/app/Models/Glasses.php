<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Glasses extends Model
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

    public function stock(): MorphOne
    {
        return $this->morphOne(Stock::class, 'product', 'product_type_model', 'product_id');
    }

    public function addToCart(Cart $cart, int $qty = 1): void
    {
        CartItem::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $this->stock->id],
            ['quantity' => DB::raw("quantity + $qty")]
        );
    }

    public function getPrice(): float
    {
        return $this->stock->getPrice();
    }
}
