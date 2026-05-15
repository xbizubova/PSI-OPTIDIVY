<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_CLAIMED = 'claimed';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_DELAYED = 'delayed';

    protected $fillable = [
        'customer_id', 'status',
        'first_name', 'last_name', 'email', 'phone',
        'delivery', 'street', 'city', 'country',
        'payment',
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotal(): float
    {
        return $this->items->sum('subtotal');
    }

    public function hasCriticalMaterial(): bool
    {
        $this->loadMissing('items.product');

        return $this->items->contains(function (OrderItem $item) {
            $product = $item->product;

            if ($product instanceof Glasses) {
                $product->loadMissing('frame.stock', 'lense.stock');

                return $product->frame?->stock?->stockState() === Stock::STATE_CRITICAL
                    || $product->lense?->stock?->stockState() === Stock::STATE_CRITICAL;
            }

            if ($product instanceof Frame || $product instanceof Lense || $product instanceof ContactLenses) {
                $product->loadMissing('stock');

                return $product->stock?->stockState() === Stock::STATE_CRITICAL;
            }

            return false;
        });
    }

    public function refreshDelayStatus(): void
    {
        if ($this->status === self::STATUS_COMPLETED) {
            return;
        }

        if ($this->hasCriticalMaterial()) {
            $this->update(['status' => self::STATUS_DELAYED]);
            return;
        }

        if ($this->status === self::STATUS_DELAYED) {
            $this->update(['status' => self::STATUS_PENDING]);
        }
    }

    public static function refreshDelayStatuses(): void
    {
        static::with('items.product')
            ->whereIn('status', [self::STATUS_PENDING, self::STATUS_CLAIMED, self::STATUS_DELAYED])
            ->get()
            ->each
            ->refreshDelayStatus();
    }
}
