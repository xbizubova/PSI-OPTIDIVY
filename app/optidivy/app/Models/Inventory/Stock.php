<?php

namespace App\Models\Inventory;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Stock extends Model
{
    public const STATE_OK = 'ok';
    public const STATE_LOW = 'low';
    public const STATE_CRITICAL = 'critical';

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

    public function stockState(): string
    {
        if ($this->quantity <= ($this->min_quantity / 2)) {
            return self::STATE_CRITICAL;
        }

        if ($this->quantity <= $this->min_quantity) {
            return self::STATE_LOW;
        }

        return self::STATE_OK;
    }

    public function stockStateLabel(): string
    {
        return match ($this->stockState()) {
            self::STATE_CRITICAL => 'Critical',
            self::STATE_LOW => 'Low',
            default => 'OK',
        };
    }

    public function mockReorderQuantity(): int
    {
        $targetQuantity = max($this->min_quantity * 3, 10);

        return max($targetQuantity - $this->quantity, $this->min_quantity, 1);
    }

    public function lense(): HasOne
    {
        return $this->hasOne(\App\Models\Inventory\Lense::class);
    }

    public function frame(): HasOne
    {
        return $this->hasOne(\App\Models\Inventory\Frame::class);
    }

    public function contactLense(): HasOne
    {
        return $this->hasOne(\App\Models\Inventory\ContactLenses::class);
    }
}
