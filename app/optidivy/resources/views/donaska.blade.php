@extends('layouts.app')
@section('title', 'Donáška')

@section('content')
    <div class="checkout-layout">
        <div>
            <h1 class="checkout-title">Donáška</h1>

            <form method="POST" action="{{ route('donaska.store') }}" id="donaska-form">
                @csrf
                <div class="radio-options">
                    <label class="radio-option selected" id="opt-predajna">
                        <input type="radio" name="donaska" value="predajna" checked/>
                        <div class="radio-dot"></div>
                        <span class="radio-option-label">Na predajňu</span>
                        <span class="radio-option-price">0.00€</span>
                    </label>

                    <label class="radio-option" id="opt-adresa">
                        <input type="radio" name="donaska" value="adresa"/>
                        <div class="radio-dot"></div>
                        <span class="radio-option-label">Na adresu</span>
                        <span class="radio-option-price">2.99€</span>
                    </label>
                </div>

                <div class="checkout-form" id="address-fields" style="display:none; margin-top:24px;">
                    <div class="form-row">
                        <input class="checkout-input" type="text" name="street" placeholder="Adresa" value="{{ Auth::user()->street }}"/>
                        <input class="checkout-input" type="text" name="city" placeholder="Mesto" value="{{ Auth::user()->city }}"/>
                    </div>
                    <div class="form-row">
                        <input class="checkout-input" type="text" name="country" placeholder="Krajina" value="{{ Auth::user()->country }}"/>
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
                <a href="{{ route('kontakt') }}" class="btn-order">Späť</a>
                <button type="submit" form="donaska-form" class="btn-order">Ďalej</button>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.radio-option').forEach(opt => {
            opt.addEventListener('click', () => {
                document.querySelectorAll('.radio-option').forEach(o => o.classList.remove('selected'));
                opt.classList.add('selected');
                opt.querySelector('input').checked = true;
                const isAdresa = opt.querySelector('input').value === 'adresa';
                document.getElementById('address-fields').style.display = isAdresa ? 'flex' : 'none';

                document.querySelectorAll('#address-fields input').forEach(input => {
                    input.required = isAdresa;
                });
            });
        });
    </script>
@endsection
