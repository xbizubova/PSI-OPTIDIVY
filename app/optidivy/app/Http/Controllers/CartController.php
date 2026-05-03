<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Stock;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = Cart::firstOrCreate(['customer_id' => auth()->id()]);
        $cartItems = $cart->items()->with([
            'product' => function($query) {},
        ])->get()->each(function($item) {
            if ($item->product instanceof \App\Models\Glasses) {
                $item->product->load('frame.stock', 'lense.stock');
            }
        });
        $total = $cart->getTotal();

        return view('kosik', compact('cartItems', 'total'));
    }

    public function add(Stock $stock)
    {
        if (auth()->user()->prescription === null) {
            return back()->with('no_prescription', true);
        }

        $cart = $this->currentCart();

        $product = $stock->contactLense ?? $stock->lense ?? $stock->frame;

        abort_unless($product instanceof \App\Models\Product, 404);

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->where('product_type', get_class($product))
            ->first();

        $current = $item?->quantity ?? 0;

        if ($current + 1 > $stock->quantity) {
            return back()->with('error', 'Na sklade je už len ' . $stock->quantity . ' ks.');
        }

        $product->addToCart($cart);

        return redirect()->route('kosik');
    }

    public function update(Request $request, CartItem $item)
    {
        $this->authorizeItem($item);

        $request->validate(['action' => ['required', 'in:inc,dec']]);

        if ($request->action === 'inc') {
            $stock = $item->product->getStock();

            if ($stock !== null && $item->quantity + 1 > $stock->quantity) {
                return back()->with('error', 'Na sklade je už len ' . $stock->quantity . ' ks.');
            }

            $item->increment('quantity');
        } else {
            if ($item->quantity <= 1) {
                $item->delete();
            } else {
                $item->decrement('quantity');
            }
        }

        return redirect()->route('kosik');
    }

    public function destroy(CartItem $item)
    {
        $this->authorizeItem($item);
        $item->delete();

        return redirect()->route('kosik');
    }

    private function currentCart(): Cart
    {
        return Cart::firstOrCreate(['customer_id' => auth()->id()]);
    }

    private function authorizeItem(CartItem $item): void
    {
        abort_unless($item->cart->customer_id === auth()->id(), 403);
    }
}
