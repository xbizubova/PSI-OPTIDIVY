@extends('layouts.app')
@section('title', 'Manager')

@php
    $typeLabels = [
        'frame' => 'Rámy',
        'lense' => 'Sklá',
        'contact_lense' => 'Kontaktné šošovky',
    ];
@endphp

@section('content')
    <main class="manager-shop">
        <h1 class="manager-logo">OPTIDIVY</h1>

        <form method="GET" action="{{ route('manager') }}" class="manager-search">
            <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="11" cy="11" r="7"></circle>
                <path d="m16.2 16.2 4 4"></path>
            </svg>
            <input type="search" name="search" value="{{ request('search') }}" placeholder="SEARCH"/>
            @foreach((array) request('type', []) as $type)
                <input type="hidden" name="type[]" value="{{ $type }}"/>
            @endforeach
            @foreach((array) request('stock', []) as $stock)
                <input type="hidden" name="stock[]" value="{{ $stock }}"/>
            @endforeach
            @foreach((array) request('price', []) as $price)
                <input type="hidden" name="price[]" value="{{ $price }}"/>
            @endforeach
        </form>

        <div class="manager-inventory">
            <aside class="manager-filters">
                <form method="GET" action="{{ route('manager') }}">
                    <input type="hidden" name="search" value="{{ request('search') }}"/>

                    <details class="filter-box" open>
                        <summary>Typ materiálu</summary>
                        <label><input type="checkbox" name="type[]" value="frame" @checked(in_array('frame', (array) request('type', [])))> Rámy</label>
                        <label><input type="checkbox" name="type[]" value="lense" @checked(in_array('lense', (array) request('type', [])))> Sklá</label>
                        <label><input type="checkbox" name="type[]" value="contact_lense" @checked(in_array('contact_lense', (array) request('type', [])))> Kontaktné šošovky</label>
                    </details>

                    <details class="filter-box" open>
                        <summary>Sklad</summary>
                        <label><input type="checkbox" name="stock[]" value="low" @checked(in_array('low', (array) request('stock', [])))> Nízke zásoby</label>
                        <label><input type="checkbox" name="stock[]" value="available" @checked(in_array('available', (array) request('stock', [])))> Dostupné</label>
                        <label><input type="checkbox" name="stock[]" value="discontinued" @checked(in_array('discontinued', (array) request('stock', [])))> Vyradené</label>
                    </details>

                    <details class="filter-box" open>
                        <summary>Cena</summary>
                        <label><input type="checkbox" name="price[]" value="under_30" @checked(in_array('under_30', (array) request('price', [])))> Do 30 €</label>
                        <label><input type="checkbox" name="price[]" value="30_50" @checked(in_array('30_50', (array) request('price', [])))> 30 - 50 €</label>
                        <label><input type="checkbox" name="price[]" value="over_50" @checked(in_array('over_50', (array) request('price', [])))> Nad 50 €</label>
                        <label><input type="checkbox" name="price[]" value="discounted" @checked(in_array('discounted', (array) request('price', [])))> Zľava</label>
                    </details>

                    <button type="submit" class="manager-filter-submit">Filtrovať</button>
                </form>
            </aside>

            <section class="manager-products">
                @forelse($stocks as $stock)
                    <article class="manager-product">
                        <div class="manager-product-image"></div>
                        <h2>{{ $typeLabels[$stock->product_type] ?? 'Materiál' }}</h2>
                        <p>{{ $stock->name }}</p>
                        <p>počet: {{ $stock->quantity }}</p>
                        <button type="button">DOOBJEDNAŤ</button>
                    </article>
                @empty
                    <p class="manager-no-results">Nenašli sa žiadne skladové položky.</p>
                @endforelse
            </section>
        </div>

        @if($stocks->hasPages())
            <nav class="manager-pagination" aria-label="Stránkovanie">
                @if($stocks->onFirstPage())
                    <span class="pagination-arrow">‹</span>
                @else
                    <a href="{{ $stocks->previousPageUrl() }}" class="pagination-arrow">‹</a>
                @endif

                @foreach($stocks->getUrlRange(1, $stocks->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="{{ $stocks->currentPage() === $page ? 'active' : '' }}">{{ $page }}</a>
                @endforeach

                @if($stocks->hasMorePages())
                    <a href="{{ $stocks->nextPageUrl() }}" class="pagination-arrow">›</a>
                @else
                    <span class="pagination-arrow">›</span>
                @endif
            </nav>
        @endif
    </main>
@endsection
