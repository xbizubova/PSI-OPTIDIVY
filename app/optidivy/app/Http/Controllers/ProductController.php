<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use App\Models\Frame;
use App\Models\Lense;
use App\Models\Glasses;
use App\Models\Cart;
use App\Http\Controllers\CartController;
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
            'okuliare' => 'frame',
            'sosovky'  => 'contact_lense',
            'skla' => 'lense',
        ];

        abort_unless(isset($map[$kategoria]), 404);

        $products = Stock::where('product_type', $map[$kategoria])->get();
        return view('index', compact('products', 'kategoria'));
    }

    public function selectFrame(Frame $frame)
    {
        session(['selected_frame_id' => $frame->id]);
        return redirect()->route('produkty', 'skla');
    }

    public function makeGlasses(Lense $lense)
    {
        $frameId = session('selected_frame_id');
        abort_unless($frameId, 404);

        $glasses = Glasses::firstOrCreate([
            'frame_id' => $frameId,
            'lense_id' => $lense->id,
        ]);

        $cart = Cart::firstOrCreate(['customer_id' => auth()->id()]);
        $glasses->addToCart($cart);

        session()->forget('selected_frame_id');

        return redirect()->route('kosik');
    }
}
