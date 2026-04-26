@extends('layouts.app')
@section('title', 'Domov')

@section('content')
    <section class="search-section">
        <div class="search-bar">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" placeholder="SEARCH"/>
        </div>
    </section>

    <div class="shop-layout">
        <aside>
            <p class="menu-label">MENU</p>
            <nav>
                <ul>
                    <li><a href="{{ route('produkty', 'okuliare') }}">OKULIARE</a></li>
                    <li><a href="{{ route('produkty', 'sosovky') }}">KONTAKTNÉ ŠOŠOVKY</a></li>
                    <li><a href="{{ route('rezervacia') }}">REZERVÁCIA VYŠETRENIA</a></li>
                </ul>
            </nav>
        </aside>

        <div class="content">
            <h2 class="section-title">NOVÝ TOVAR</h2>
            <div class="product-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <div class="product-img-wrap">
                            {{-- <img src="{{ asset('images/' . $product->image) }}" alt="{{ $product->name }}"> --}}
                        </div>
                        <p class="product-name">{{ strtoupper($product->name) }}</p>
                        <p class="product-price">€ {{ number_format($product->getPrice(), 2) }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
