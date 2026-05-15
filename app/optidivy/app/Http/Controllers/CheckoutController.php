<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Orders\Cart;
use App\Models\Orders\Order;
use App\Models\Orders\OrderItem;
use App\Models\Inventory\Glasses;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function storeKontakt(Request $request)
    {
        session([
            'checkout_first_name' => $request->first_name,
            'checkout_last_name'  => $request->last_name,
            'checkout_email'      => $request->email,
            'checkout_phone'      => $request->phone,
        ]);

        return redirect()->route('donaska');
    }

    public function storeDonaska(Request $request)
    {
        session([
            'checkout_donaska' => $request->donaska,
            'checkout_street'  => $request->street,
            'checkout_city'    => $request->city,
            'checkout_country' => $request->country,
        ]);

        return redirect()->route('platba');
    }

    public function storePlatba(Request $request)
    {
        $cart = Cart::firstOrCreate(['customer_id' => auth()->id()]);
        $cartItems = $cart->items()->with([
            'product' => function($query) {},
        ])->get()->each(function($item) {
            if ($item->product instanceof \App\Models\Inventory\Glasses) {
                $item->product->load('frame.stock', 'lense.stock');
            }
        });

        DB::transaction(function() use ($cart, $cartItems, $request) {
            $order = Order::create([
                'customer_id' => auth()->id(),
                'status'      => 'pending',
                'first_name'  => session('checkout_first_name'),
                'last_name'   => session('checkout_last_name'),
                'email'       => session('checkout_email'),
                'phone'       => session('checkout_phone'),
                'delivery'    => session('checkout_donaska'),
                'street'      => session('checkout_street'),
                'city'        => session('checkout_city'),
                'country'     => session('checkout_country'),
                'payment'     => $request->platba,
            ]);

            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $item->product_id,
                    'product_type' => $item->product_type,
                    'quantity'     => $item->quantity,
                    'subtotal'     => $item->getSubtotal(),
                ]);
            }

            $cart->items()->delete();
        });

        Order::refreshDelayStatuses();

        session()->forget([
            'checkout_first_name',
            'checkout_last_name',
            'checkout_email',
            'checkout_phone',
            'checkout_donaska',
            'checkout_street',
            'checkout_city',
            'checkout_country',
        ]);

        return redirect()->route('home')->with('success', 'Objednávka bola úspešne odoslaná!');
    }
}
