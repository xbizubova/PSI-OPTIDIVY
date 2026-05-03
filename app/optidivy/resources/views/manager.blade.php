@extends('layouts.app')
@section('title', 'Manager')

@php
    $typeLabels = [
        'frame' => 'R&aacute;my',
        'lense' => 'Skl&aacute;',
        'contact_lense' => 'Kontaktn&eacute; &scaron;o&scaron;ovky',
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

        <section class="manager-scan" aria-label="Stock scan">
            <div class="manager-scan-item state-ok">
                <span>OK</span>
                <strong>{{ $scan['ok'] }}</strong>
            </div>
            <div class="manager-scan-item state-low">
                <span>Low</span>
                <strong>{{ $scan['low'] }}</strong>
            </div>
            <div class="manager-scan-item state-critical">
                <span>Critical</span>
                <strong>{{ $scan['critical'] }}</strong>
            </div>
        </section>

        <div class="manager-inventory">
            <aside class="manager-filters">
                <form method="GET" action="{{ route('manager') }}">
                    <input type="hidden" name="search" value="{{ request('search') }}"/>

                    <details class="filter-box" open>
                        <summary>Typ materi&aacute;lu</summary>
                        <label><input type="checkbox" name="type[]" value="frame" @checked(in_array('frame', (array) request('type', [])))> R&aacute;my</label>
                        <label><input type="checkbox" name="type[]" value="lense" @checked(in_array('lense', (array) request('type', [])))> Skl&aacute;</label>
                        <label><input type="checkbox" name="type[]" value="contact_lense" @checked(in_array('contact_lense', (array) request('type', [])))> Kontaktn&eacute; &scaron;o&scaron;ovky</label>
                    </details>

                    <details class="filter-box" open>
                        <summary>Sklad</summary>
                        <label><input type="checkbox" name="stock[]" value="ok" @checked(in_array('ok', (array) request('stock', [])))> OK</label>
                        <label><input type="checkbox" name="stock[]" value="low" @checked(in_array('low', (array) request('stock', [])))> Low</label>
                        <label><input type="checkbox" name="stock[]" value="critical" @checked(in_array('critical', (array) request('stock', [])))> Critical</label>
                        <label><input type="checkbox" name="stock[]" value="discontinued" @checked(in_array('discontinued', (array) request('stock', [])))> Vyraden&eacute;</label>
                    </details>

                    <details class="filter-box" open>
                        <summary>Cena</summary>
                        <label><input type="checkbox" name="price[]" value="under_30" @checked(in_array('under_30', (array) request('price', [])))> Do 30 &euro;</label>
                        <label><input type="checkbox" name="price[]" value="30_50" @checked(in_array('30_50', (array) request('price', [])))> 30 - 50 &euro;</label>
                        <label><input type="checkbox" name="price[]" value="over_50" @checked(in_array('over_50', (array) request('price', [])))> Nad 50 &euro;</label>
                        <label><input type="checkbox" name="price[]" value="discounted" @checked(in_array('discounted', (array) request('price', [])))> Z&#318;ava</label>
                    </details>

                    <button type="submit" class="manager-filter-submit">Filtrova&#357;</button>
                </form>
            </aside>

            <section class="manager-products">
                @forelse($stocks as $stock)
                    <article class="manager-product">
                        <div class="manager-product-image"></div>
                        <h2>{!! $typeLabels[$stock->product_type] ?? 'Materi&aacute;l' !!}</h2>
                        <p>{{ $stock->name }}</p>
                        <p>po&#269;et: {{ $stock->quantity }}</p>
                        <span class="manager-stock-state state-{{ $stock->stockState() }}">
                            {{ $stock->stockStateLabel() }}
                        </span>
                        <form method="POST" action="{{ route('manager.stocks.order', $stock) }}" class="manager-order-form">
                            @csrf
                            <button type="submit">DOOBJEDNA&#356;</button>
                        </form>
                    </article>
                @empty
                    <p class="manager-no-results">Nena&scaron;li sa &#382;iadne skladov&eacute; polo&#382;ky.</p>
                @endforelse
            </section>
        </div>

        @if($stocks->hasPages())
            <nav class="manager-pagination" aria-label="Strankovanie">
                @if($stocks->onFirstPage())
                    <span class="pagination-arrow">&lsaquo;</span>
                @else
                    <a href="{{ $stocks->previousPageUrl() }}" class="pagination-arrow">&lsaquo;</a>
                @endif

                @foreach($stocks->getUrlRange(1, $stocks->lastPage()) as $page => $url)
                    <a href="{{ $url }}" class="{{ $stocks->currentPage() === $page ? 'active' : '' }}">{{ $page }}</a>
                @endforeach

                @if($stocks->hasMorePages())
                    <a href="{{ $stocks->nextPageUrl() }}" class="pagination-arrow">&rsaquo;</a>
                @else
                    <span class="pagination-arrow">&rsaquo;</span>
                @endif
            </nav>
        @endif
    </main>
@endsection
