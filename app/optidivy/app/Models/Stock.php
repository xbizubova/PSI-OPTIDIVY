<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $fillable = [
        'name', 'description', 'price', 'discount',
        'quantity', 'min_quantity', 'product_type', 'product_id', 'product_type_model'
    ];

    public function getPrice(): float
    {
        return $this->price * (1 - $this->discount / 100);
    }

    public function getLowStock(): array
    {
        return Stock::where('quantity', '<=', DB::raw('min_quantity'))->get()->toArray();
    }

// Polymorfný vzťah – buď Glasses alebo ContactLenses
    public function product(): MorphTo
    {
        return $this->morphTo(__FUNCTION__, 'product_type_model', 'product_id');
    }
}
