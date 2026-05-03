@extends('layouts.app')
@section('title', 'Objednávky')

@section('content')
    <main style="padding: 56px;">
        <h2 class="section-title">VÝBER OBJEDNÁVKY</h2>
        <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px 32px;">
            @forelse($orders as $order)
                <a href="{{ route('technik.show', $order->id) }}" class="product-card" style="text-decoration:none;">
                    <div class="product-img-wrap"></div>
                    <p class="product-name">OBJEDNÁVKA #{{ str_pad($order->id, 3, '0', STR_PAD_LEFT) }}</p>
                    <p class="product-price" style="font-size:11px;">
                        {{ strtoupper($order->status) }} — {{ $order->first_name }} {{ $order->last_name }}
                    </p>
                </a>
            @empty
                <p>Žiadne objednávky.</p>
            @endforelse
        </div>

        <div style="margin-top: 40px;">
            {{ $orders->links() }}
        </div>
    </main>
@endsection
