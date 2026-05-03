@extends('layouts.app')
@section('title', 'Rezervácia')

@section('content')
    <main class="rezervacia-main">
        <h1 class="rezervacia-title">VYBERTE SI TERMÍN</h1>

        <div class="calendar-wrap">
            <div class="week-nav">
                <button class="nav-arrow" id="prev-week">←</button>
                <span class="week-label" id="week-label"></span>
                <button class="nav-arrow" id="next-week">→</button>
            </div>

            <div class="time-grid">
                @foreach(['Po', 'Ut', 'Str', 'Štv', 'Pia'] as $index => $day)
                    <div class="day-col" id="col-{{ $index }}">
                        <div class="day-header">{{ $day }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Skrytý formulár – odošle sa po kliknutí Potvrdiť --}}
        <form method="POST" action="{{ route('rezervacia.store') }}" id="rezervacia-form">
            @csrf
            <input type="hidden" name="date" id="input-date"/>
            <input type="hidden" name="slot" id="input-slot"/>

            <div class="confirm-wrap">
                <button type="submit" class="btn-confirm" id="btn-confirm" disabled>
                    Potvrdiť
                </button>
            </div>
        </form>

        <p class="selected-info" id="selected-info">
            @if(session('success'))
                {{ session('success') }}
            @endif
        </p>

        <div class="confirm-wrap" style="margin-top: 16px;">
            <button type="button" onclick="document.getElementById('phone-popup').style.display='flex'">
                Zavolať sekretárke
            </button>
        </div>

        {{-- Popup --}}
        <div id="phone-popup" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.4);
             justify-content:center; align-items:center; z-index:999;">
            <div style="background:#fff; padding:40px; text-align:center; border-radius:4px; min-width:280px;">
                <p style="font-size:11px; letter-spacing:0.15em; margin-bottom:16px;">SEKRETÁRKA</p>
                <a href="tel:+421900123456" style="font-size:24px; font-weight:600; color:var(--black);
                   text-decoration:none; letter-spacing:0.05em;">
                    +421 900 123 456
                </a>
                <br><br>
                <button type="button" onclick="document.getElementById('phone-popup').style.display='none'"
                        style="font-size:11px; letter-spacing:0.12em; background:none; border:none;
                               cursor:pointer; color:var(--grey-dark); margin-top:8px;">
                    Zavrieť
                </button>
            </div>
        </div>

        {{-- Dostupné sloty z controllera ako JSON pre JS --}}
        <script>
            const AVAILABLE_SLOTS = @json($availableSlots);
        </script>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/rezervacia.js') }}"></script>
@endpush
