@extends('layouts.app')
@section('title', 'Kontakt')

@section('content')
    <div class="checkout-layout">
        <div>
            <h1 class="checkout-title">KONTAKT</h1>
            <form method="POST" action="{{ route('kontakt.store') }}" id="kontakt-form">
                @csrf
                <div class="checkout-form">
                    <div class="form-row">
                        <input class="checkout-input" type="text" name="first_name" placeholder="Meno" value="{{ Auth::user()->first_name }}" required/>
                        <input class="checkout-input" type="text" name="last_name" placeholder="Priezvisko" value="{{ Auth::user()->last_name }}" required/>
                    </div>
                    <div class="form-row full">
                        <input class="checkout-input" type="email" name="email" placeholder="e-mail" value="{{ Auth::user()->email }}" required/>
                    </div>
                    <div class="form-row full">
                        <input class="checkout-input" type="tel" name="phone" placeholder="tel. č." value="{{ Auth::user()->phone }}"/>
                    </div>
                </div>
            </form>
        </div>

        <div class="order-summary">
            <p class="order-summary-title">OBSAH OBJEDNÁVKY</p>
            @foreach($cartItems as $item)
                <div class="order-item">
                    <div class="order-item-name">
                        @if($item->product instanceof \App\Models\Glasses)
                            {{ strtoupper($item->product->frame->stock->name) }}
                            <span>Sklá: {{ $item->product->lense->stock->name }}</span>
                        @else
                            {{ strtoupper($item->product->stock->name) }}
                        @endif
                    </div>
                    <span class="order-item-price">{{ number_format($item->getSubtotal(), 2) }}€</span>
                </div>
            @endforeach
            <hr class="order-divider"/>
            <div class="order-total">
                <span class="order-total-label">Súčet</span>
                <span class="order-total-price">{{ number_format($total, 2) }}€</span>
            </div>
            <div class="order-actions">
                <a href="{{ route('kosik') }}" class="btn-order">Späť</a>
                <button type="submit" form="kontakt-form" class="btn-order">Ďalej</button>
            </div>
        </div>
    </div>
@endsection
