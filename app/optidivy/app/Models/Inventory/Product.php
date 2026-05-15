<?php

namespace App\Models\Inventory;
interface Product
{
    public function addToCart(\App\Models\Cart $cart, int $qty): void;
    public function getPrice(): float;

    public function getStock(): ?\App\Models\Stock;
}
