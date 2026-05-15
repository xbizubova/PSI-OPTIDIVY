<?php

namespace App\Models;

interface Product
{
    public function addToCart(Cart $cart, int $qty): void;
    public function getPrice(): float;

    public function getStock(): ?Stock;
}
