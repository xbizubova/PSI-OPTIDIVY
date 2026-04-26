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
        $cart = $this->currentCart();
        $cartItems = $cart->items()->with('product')->get();
        $total = $cart->getTotal();

        return view('kosik', compact('cartItems', 'total'));
    }

    public function add(Stock $stock)
    {
        $cart = $this->currentCart();

        $item = $cart->items()->where('product_id', $stock->id)->first();
        $current = $item?->quantity ?? 0;

        if ($current + 1 > $stock->quantity) {
            return back()->with('error', 'Na sklade je už len ' . $stock->quantity . ' ks tohto produktu.');
        }

        if ($item) {
            $item->increment('quantity');
        } else {
            $cart->items()->create([
                'product_id' => $stock->id,
                'quantity'   => 1,
            ]);
        }

        return redirect()->route('kosik');
    }

    public function update(Request $request, CartItem $item)
    {
        $this->authorizeItem($item);

        $request->validate(['action' => ['required', 'in:inc,dec']]);

        if ($request->action === 'inc') {
            if ($item->quantity + 1 > $item->product->quantity) {
                return back()->with('error', 'Na sklade je už len ' . $item->product->quantity . ' ks tohto produktu.');
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
