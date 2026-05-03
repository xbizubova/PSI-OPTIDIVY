@extends('layouts.app')
@section('title', 'Objednávka #{{ str_pad($order->id, 3, "0", STR_PAD_LEFT) }}')

@section('content')
    <main style="padding: 56px;">
        <h2 class="section-title">OBJEDNÁVKA #{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</h2>

        @if(session('success'))
            <p style="color:green; font-size:12px; margin-bottom:20px;">{{ session('success') }}</p>
        @endif

        <div class="checkout-layout">
            <div>
                <form method="POST" action="{{ route('technik.status', $order->id) }}" style="margin-bottom: 32px;">
                    @csrf
                    @method('PATCH')
                    <div class="radio-options">
                        @foreach(['pending', 'claimed', 'completed'] as $status)
                            <label class="radio-option {{ $order->status === $status ? 'selected' : '' }}">
                                <input type="radio" name="status" value="{{ $status }}"
                                    {{ $order->status === $status ? 'checked' : '' }}/>
                                <div class="radio-dot"></div>
                                <span class="radio-option-label">{{ strtoupper($status) }}</span>
                            </label>
                        @endforeach
                    </div>
                    <button type="submit" class="btn-add-cart" style="margin-top: 16px;">Zmeniť stav</button>
                </form>

                <h3 style="font-size: 11px; letter-spacing: 0.2em; margin-bottom: 16px;">POTREBNÉ MATERIÁLY</h3>
                @foreach($order->items as $item)
                    <div style="margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid var(--grey-light);">
                        @if($item->product instanceof \App\Models\Glasses)
                            <p class="cart-item-name">{{ strtoupper($item->product->frame->stock->name) }}</p>
                            <p class="cart-item-sub" style="margin-bottom: 12px;">Sklá: {{ $item->product->lense->stock->name }}</p>
                            <div style="display:flex; gap: 12px;">
                                <form method="POST" action="{{ route('technik.consume.one', [$order->id, $item->product->frame->stock->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn-add-cart" style="font-size:10px; padding: 6px 12px;">
                                        Spotrebovať rám ({{ $item->product->frame->stock->quantity }} ks)
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('technik.consume.one', [$order->id, $item->product->lense->stock->id]) }}">
                                    @csrf
                                    <button type="submit" class="btn-add-cart" style="font-size:10px; padding: 6px 12px;">
                                        Spotrebovať sklá ({{ $item->product->lense->stock->quantity }} ks)
                                    </button>
                                </form>
                            </div>
                        @else
                            <p class="cart-item-name">{{ strtoupper($item->product->stock->name) }}</p>
                            <form method="POST" action="{{ route('technik.consume.one', [$order->id, $item->product->stock->id]) }}" style="margin-top: 8px;">
                                @csrf
                                <button type="submit" class="btn-add-cart" style="font-size:10px; padding: 6px 12px;">
                                    Spotrebovať ({{ $item->product->stock->quantity }} ks)
                                </button>
                            </form>
                        @endif
                        <p class="cart-item-sub" style="margin-top: 8px;">
                            Množstvo v objednávke: {{ $item->quantity }} ks |
                            Cena: {{ number_format($item->subtotal, 2) }}€
                        </p>
                    </div>
                @endforeach

                <form method="POST" action="{{ route('technik.consume', $order->id) }}" style="margin-top: 32px;">
                    @csrf
                    <button type="submit" class="btn-add-cart">OBJEDNÁVKA HOTOVÁ</button>
                </form>
            </div>

            {{-- Right column --}}
            <div class="order-summary">
                <p class="order-summary-title">ZÁKAZNÍK</p>
                <div class="order-item">
                    <div class="order-item-name">{{ $order->first_name }} {{ $order->last_name }}</div>
                </div>
                <div class="order-item">
                    <div class="order-item-name">{{ $order->email }}</div>
                </div>
                @if($order->phone)
                    <div class="order-item">
                        <div class="order-item-name">{{ $order->phone }}</div>
                    </div>
                @endif
                <hr class="order-divider"/>
                <p class="order-summary-title">PREDPIS</p>
                <div class="order-item">
                    <div class="order-item-name">
                        Pravé oko: SPH {{ $prescription->sphere_right }} CYL {{ $prescription->cylinder }} AX {{ $prescription->axis }}
                    </div>
                </div>
                <div class="order-item">
                    <div class="order-item-name">
                        Ľavé oko: SPH {{ $prescription->sphere_left }} CYL {{ $prescription->os_cylinder }} AX {{ $prescription->os_axis }}
                    </div>
                </div>
                <div class="order-item">
                    <div class="order-item-name">PD: {{ $prescription->pupil_distance }}</div>
                </div>
                <hr class="order-divider"/>
                <p class="order-summary-title">DORUČENIE</p>
                <div class="order-item">
                    <div class="order-item-name">{{ strtoupper($order->delivery) }}</div>
                </div>
                @if($order->delivery === 'adresa')
                    <div class="order-item">
                        <div class="order-item-name">{{ $order->street }}, {{ $order->city }}, {{ $order->country }}</div>
                    </div>
                @endif
                <hr class="order-divider"/>
                <div class="order-total">
                    <span class="order-total-label">Celkom</span>
                    <span class="order-total-price">{{ number_format($order->getTotal(), 2) }}€</span>
                </div>
                <a href="{{ route('technik') }}" class="btn-order" style="margin-top: 24px; display:block; text-align:center;">Späť</a>
            </div>
        </div>
    </main>

    <script>
        document.querySelectorAll('.radio-option').forEach(opt => {
            opt.addEventListener('click', () => {
                document.querySelectorAll('.radio-option').forEach(o => o.classList.remove('selected'));
                opt.classList.add('selected');
                opt.querySelector('input').checked = true;
            });
        });
    </script>
@endsection

