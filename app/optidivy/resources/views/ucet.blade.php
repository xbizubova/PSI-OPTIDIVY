@extends('layouts.app')
@section('title', 'Môj Účet')

@section('content')

    {{-- ── ACCOUNT SECTION ── --}}
    <div class="account-wrapper">

        {{-- Sidebar – rezervácie --}}
        <aside class="account-sidebar">
            <p class="sidebar-label">MOJE REZERVÁCIE</p>

            @forelse($appointments as $appointment)
                <div class="reservation-item">
                    <p>
                        Vyšetrenie Zraku<br>
                        {{ \Carbon\Carbon::parse($appointment->date)->format('d.m.Y') }}
                        {{ \App\Http\Controllers\RezervaciaController::SLOTS[$appointment->slot] }}
                    </p>
                </div>
            @empty
                <p style="font-size:12px; color:var(--grey-dark);">
                    Žiadne rezervácie.
                </p>
            @endforelse

            <a href="{{ route('rezervacia') }}"
               style="display:inline-block; margin-top:24px; font-size:11px;
              letter-spacing:0.12em; color:var(--black); text-decoration:none;
              border-bottom:1px solid var(--grey-mid);">
                + Nová rezervácia
            </a>
        </aside>

        {{-- Main – formulár --}}
        <div class="account-main">
            <h1 class="account-title">Môj Účet</h1>

            @if(session('success'))
                <p style="color:green; font-size:12px; margin-bottom:20px;">
                    {{ session('success') }}
                </p>
            @endif

            <form method="POST" action="{{ route('ucet.update') }}">
                @csrf
                @method('PATCH')

                <div class="account-form">

                    <div class="form-field">
                        <label>Meno</label>
                        <input type="text" name="first_name"
                               value="{{ old('first_name', $user->first_name) }}"/>
                        @error('first_name')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label>Ulica a číslo domu</label>
                        <input type="text" name="street"
                               value="{{ old('street', $user->street ?? '') }}"/>
                    </div>

                    <div class="form-field">
                        <label>Priezvisko</label>
                        <input type="text" name="last_name"
                               value="{{ old('last_name', $user->last_name) }}"/>
                        @error('last_name')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label>Mesto</label>
                        <input type="text" name="city"
                               value="{{ old('city', $user->city ?? '') }}"/>
                    </div>

                    <div class="form-field">
                        <label>Email</label>
                        <input type="email" name="email"
                               value="{{ old('email', $user->email) }}"/>
                        @error('email')
                        <span class="field-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-field">
                        <label>Štát</label>
                        <input type="text" name="country"
                               value="{{ old('country', $user->country ?? '') }}"/>
                    </div>

                    <div class="form-field tel">
                        <label>Tel. číslo</label>
                        <input type="tel" name="phone"
                               value="{{ old('phone', $user->phone ?? '') }}"/>
                    </div>

                    <div class="form-field btn-field">
                        <button type="submit" class="btn-zmenit">Zmeniť informácie</button>
                    </div>

                </div>
            </form>
        </div>

    </div>

    {{-- ── NAPOSLEDY OBJEDNANÉ ── --}}
    <section class="recent-section">
        <h2 class="recent-title">Naposledy objednané</h2>
        <div class="recent-grid">
            @forelse($recentOrders as $order)
                <div class="recent-card">
                    <div class="recent-img"></div>
                    <p class="recent-name">OBJEDNAVKA #{{ $order->id }}</p>
                    <span class="account-order-status status-{{ $order->status }}">
                        @if($order->status === 'delayed')
                            oneskoren&eacute;
                        @elseif($order->status === 'claimed')
                            prevzat&eacute;
                        @elseif($order->status === 'completed')
                            dokon&#269;en&eacute;
                        @else
                            &#269;ak&aacute;
                        @endif
                    </span>
                    <p class="account-order-items">
                        {{ $order->items->count() }} polo&#382;iek
                    </p>
                </div>
            @empty
                <p style="font-size:13px; color:var(--grey-dark);">
                    Zatiaľ žiadne objednávky.
                </p>
            @endforelse
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        const header = document.getElementById('site-header');
        window.addEventListener('scroll', () => {
            header.classList.toggle('scrolled', window.scrollY > 10);
        });
    </script>
@endpush
