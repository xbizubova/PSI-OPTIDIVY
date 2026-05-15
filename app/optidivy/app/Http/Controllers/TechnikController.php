<?php

namespace App\Http\Controllers;

use App\Models\Orders\Order;
use App\Models\Orders\OrderItem;
use App\Models\Inventory\Stock;
use Illuminate\Http\Request;


class TechnikController extends Controller
{
    public function index()
    {
        $orders = Order::whereIn('status', ['pending', 'claimed'])
            ->orderBy('created_at', 'asc')
            ->paginate(6);
        return view('technik', compact('orders'));
    }

    public function show(Order $order)
    {
        $order->load(['items.product']);
        $order->items->each(function($item) {
            if ($item->product instanceof \App\Models\Inventory\Glasses) {
                $item->product->load('frame.stock', 'lense.stock');
            } elseif ($item->product instanceof \App\Models\Inventory\ContactLenses) {
                $item->product->load('stock');
            }
        });
        $prescription = \App\Models\Prescription::where('customer_id', $order->customer_id)->first();
        return view('orderdetail', compact('order', 'prescription'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,claimed,completed,cancelled',
        ]);
        $order->update(['status' => $request->status]);
        return back()->with('success', 'Stav objednávky bol zmenený.');
    }

    public function completeOrder(Order $order)
    {
        $order->update(['status' => 'completed']);
        return redirect()->route('technik')->with('success', 'Objednávka bola dokončená.');
    }

    public function consumeOne(Order $order, Stock $stock)
    {
        if ($stock->quantity <= 0) {
            return back()->with('error', 'Žiadny tovar na sklade.');
        }
        $stock->decrement('quantity');
        return back()->with('success', 'Materiál bol spotrebovaný.');
    }
}
