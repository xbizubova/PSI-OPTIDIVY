<!DOCTYPE html>
<html lang="sk">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>OPTIDIVY – @yield('title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;600&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

<header id="site-header">
    <a href="{{ url('/') }}" class="logo">OPTIDIVY</a>
    <div class="header-actions">
        @auth
            <span>{{ Auth::user()->first_name }}</span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">LOG OUT</button>
            </form>
        @else
            <a href="{{ route('login') }}">LOG IN</a>
        @endauth

        <a href="{{ route('kosik') }}" class="cart-link">
            <svg class="cart-icon" viewBox="0 0 24 24" stroke-width="1.5">
                <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/>
                <line x1="3" y1="6" x2="21" y2="6"/>
                <path d="M16 10a4 4 0 01-8 0"/>
            </svg>
            @auth
                @php($cartCount = Auth::user()->cart?->items()->sum('quantity') ?? 0)
                @if($cartCount > 0)
                    <span class="cart-badge">{{ $cartCount }}</span>
                @endif
            @endauth
        </a>
    </div>
</header>

@if(session('error'))
    <div class="flash flash-error">{{ session('error') }}</div>
@endif

@yield('content')

<footer>
    <div class="footer-top">
        <div class="footer-brand">
            <span class="logo-footer">OPTIDIVY</span>
            <p>Not just selling glasses, we create a new world for you!</p>
            <a href="#" class="insta">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <rect x="2" y="2" width="20" height="20" rx="5" ry="5"/>
                    <circle cx="12" cy="12" r="4"/>
                    <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                </svg>
                Instagram
            </a>
        </div>
        <div class="footer-links">
            <div class="footer-col">
                <h4>Categories</h4>
                <ul>
                    <li><a href="#">glasses</a></li>
                    <li><a href="#">Sale</a></li>
                    <li><a href="#">News</a></li>
                    <li><a href="#">Other sortiment</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Learn more</h4>
                <ul>
                    <li><a href="#">Delivery</a></li>
                    <li><a href="#">Payment</a></li>
                    <li><a href="#">Customer stories</a></li>
                    <li><a href="#">Best practices</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>OPTIDIVY</h4>
                <ul>
                    <li><a href="#">Contact</a></li>
                    <li><a href="#">Support</a></li>
                    <li><a href="#">Join us</a></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <span>© {{ date('Y') }} OPTIDIVY. Všetky práva vyhradené.</span>
        <span>Trnava, Slovakia</span>
    </div>
</footer>

@stack('scripts')
@if(session('no_prescription'))
    <div class="modal-overlay">
        <div class="modal-box">
            <p>Nemáte predpis! Zarezervujte si vyšetrenie u nášho optometristu.</p>
            <a href="{{ route('rezervacia') }}" class="btn-add-cart">Rezervovať vyšetrenie</a>
            <button onclick="this.closest('.modal-overlay').style.display='none'" class="btn-add-cart">Zavrieť</button>
        </div>
    </div>
@endif
</body>
</html>
