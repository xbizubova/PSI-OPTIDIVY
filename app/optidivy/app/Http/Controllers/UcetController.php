<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UcetController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $appointments = $user->appointments()
            ->where('booked', true)
            ->orderBy('date')
            ->get();

        $recentOrders = $user->orders()
            ->with('items.product')
            ->latest()
            ->take(5)
            ->get()
            ->flatMap(fn($order) => $order->items)
            ->take(5);

        return view('ucet', compact('user', 'appointments', 'recentOrders'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name'  => ['required', 'string', 'max:255'],
            'email'      => ['required', 'email', 'unique:users,email,' . Auth::id()],
            'phone'      => ['nullable', 'string', 'max:20'],
            'street'     => ['nullable', 'string', 'max:255'],
            'city'       => ['nullable', 'string', 'max:255'],
            'country'    => ['nullable', 'string', 'max:255'],
        ]);

        Auth::user()->update($request->only([
            'first_name', 'last_name', 'email',
            'phone', 'street', 'city', 'country',
        ]));

        return redirect()->route('ucet')
            ->with('success', '✓ Informácie boli aktualizované.');
    }
}
