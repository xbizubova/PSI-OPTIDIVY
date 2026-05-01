<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Stock extends Model
{
    protected $fillable = [
        'name', 'discontinued', 'description', 'price', 'discount',
        'quantity', 'min_quantity', 'product_type'
    ];

    public function getPrice(): float
    {
        return $this->price * (1 - $this->discount / 100);
    }

    public function getLowStock(): array
    {
        return Stock::whereColumn('quantity', '<=', 'min_quantity')->get()->toArray();
    }

    public function lense(): HasOne
    {
        return $this->hasOne(Lense::class);
    }

    public function frame(): HasOne
    {
        return $this->hasOne(Frame::class);
    }

    public function contactLense(): HasOne
    {
        return $this->hasOne(ContactLenses::class);
    }
}
