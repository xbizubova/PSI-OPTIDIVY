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
        $map = [
            'okuliare' => 'glasses',
            'sosovky'  => 'contact_lenses',
        ];

        abort_unless(isset($map[$kategoria]), 404);

        $products = Stock::where('product_type', $map[$kategoria])->get();
        return view('index', compact('products'));
    }
}
