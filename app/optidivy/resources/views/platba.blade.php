@extends('layouts.app')
@section('title', 'Platba')

@section('content')
    <div class="checkout-layout">
        <div>
            <h1 class="checkout-title">Platba</h1>

            <form method="POST" action="{{ route('platba.store') }}" id="platba-form">
                @csrf
                <div class="radio-options">
                    <label class="radio-option selected" id="opt-karta">
                        <input type="radio" name="platba" value="karta" checked/>
                        <div class="radio-dot"></div>
                        <span class="radio-option-label">Karta</span>
                    </label>

                    @if($donaska === 'predajna')
                        <label class="radio-option" id="opt-hotovost">
                            <input type="radio" name="platba" value="hotovost"/>
                            <div class="radio-dot"></div>
                            <span class="radio-option-label">Hotovosť (iba pri donáške na predajni)</span>
                        </label>
                    @endif
                </div>

                <div class="checkout-form" id="card-fields" style="margin-top:24px;">
                    <div class="form-row full">
                        <input class="checkout-input" type="text" name="card_number" placeholder="Číslo karty" maxlength="19"/>
                    </div>
                    <div class="form-row">
                        <input class="checkout-input" type="text" name="card_expiry" placeholder="Expirácia" maxlength="5"/>
                        <input class="checkout-input" type="text" name="card_cvc" placeholder="CVC" maxlength="4"/>
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
            <div class="order-actions single">
                <a href="{{ route('donaska') }}" class="btn-order">Späť</a>
                <button type="submit" form="platba-form" class="btn-order primary">Objednať</button>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('.radio-option').forEach(opt => {
            opt.addEventListener('click', () => {
                document.querySelectorAll('.radio-option').forEach(o => o.classList.remove('selected'));
                opt.classList.add('selected');
                opt.querySelector('input').checked = true;
                const isKarta = opt.querySelector('input').value === 'karta';
                document.getElementById('card-fields').style.display = isKarta ? 'flex' : 'none';

                document.querySelectorAll('#card-fields input').forEach(input => {
                    input.required = isKarta;
                });
            });
        });
        document.getElementById('platba-form').addEventListener('submit', function(e) {
            const isKarta = document.querySelector('input[name="platba"]:checked').value === 'karta';
            if (isKarta) {
                const fields = document.querySelectorAll('#card-fields input');
                for (const field of fields) {
                    if (!field.value.trim()) {
                        e.preventDefault();
                        field.reportValidity();
                        return;
                    }
                }
            }
        });
    </script>
@endsection
