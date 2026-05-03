@extends('layouts.app')
@section('title', 'Košík')

@section('content')
    <div class="checkout-layout">
        <div>
            <h1 class="checkout-title">KOŠÍK</h1>
            <div class="cart-items">
                @forelse($cartItems as $item)
                    <div class="cart-item">
                        <div class="cart-item-img"></div>
                        <div class="cart-item-info">
                            @if($item->product instanceof \App\Models\Glasses)
                                <p class="cart-item-name">{{ strtoupper($item->product->frame->stock->name) }}</p>
                                <p class="cart-item-sub">Sklá: {{ $item->product->lense->stock->name }}</p>
                            @else
                                <p class="cart-item-name">{{ strtoupper($item->product->stock->name) }}</p>
                            @endif
                            <form method="POST" action="{{ route('kosik.update', $item->id) }}">
                                @csrf @method('PATCH')
                                <div class="qty-control">
                                    <button type="submit" name="action" value="dec" class="qty-btn">−</button>
                                    <span class="qty-val">{{ $item->quantity }}</span>
                                    <button type="submit" name="action" value="inc" class="qty-btn">+</button>
                                </div>
                            </form>
                        </div>
                        <span class="cart-item-price">{{ number_format($item->getSubtotal(), 2) }}€</span>
                    </div>
                @empty
                    <p>Košík je prázdny.</p>
                @endforelse
            </div>
        </div>

        <div class="order-summary">
            <p class="order-summary-title">Súčet</p>
            <p class="order-total-price">{{ number_format($total, 2) }}€</p>
            <hr class="order-divider"/>
            <a href="{{ route('kontakt') }}" class="btn-order primary">Zaplatiť</a>
            <a href="{{ url('/') }}" class="btn-order" style="text-align:center; margin-top:8px;">
                späť do obchodu
            </a>
        </div>
    </div>
@endsection
