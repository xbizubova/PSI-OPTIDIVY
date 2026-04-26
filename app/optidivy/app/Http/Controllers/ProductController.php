<?php

namespace App\Http\Controllers;

use App\Models\Stock;

class ProductController extends Controller
{
    public function index()
    {
        $products = Stock::latest()->take(4)->get();
        return view('index', compact('products'));
    }

    public function kategoria(string $kategoria)
    {
        $products = Stock::where('product_type', $kategoria)->get();
        return view('index', compact('products'));
    }
}
