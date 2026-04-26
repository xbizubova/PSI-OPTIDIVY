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

        {{-- Dostupné sloty z controllera ako JSON pre JS --}}
        <script>
            const AVAILABLE_SLOTS = @json($availableSlots);
        </script>
    </main>
@endsection

@push('scripts')
    <script src="{{ asset('js/rezervacia.js') }}"></script>
@endpush
