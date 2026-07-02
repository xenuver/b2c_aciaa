<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="ACIAA — Curated contemporary fashion untuk wanita modern. Temukan koleksi pakaian elegan, stylish, dan berkualitas tinggi.">

    <title>@yield('title', 'ACIAA — Premium Women\'s Fashion')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700|playfair-display:400,400i,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')
</head>
<body style="font-family: 'Poppins', 'Inter', system-ui, sans-serif; margin: 0; padding: 0;">

    {{-- ========== LANDING TRANSPARENT NAVBAR ========== --}}
    <nav class="landing-navbar" id="landingNavbar">
        <div class="landing-nav-container">
            {{-- Logo --}}
            <a href="{{ route('landing') }}" class="landing-nav-logo">
                <div class="landing-logo-icon">
                    <img src="{{ asset('images/aciaa_logo.png') }}" alt="Aciaa Logo" style="width: 100%; height: 100%; object-fit: contain;">
                </div>
                <span class="landing-logo-text">ACIAA</span>
            </a>

            {{-- Desktop Nav Links --}}
            <div class="landing-nav-links" id="landingNavLinks">
                <a href="{{ route('landing') }}" class="landing-nav-link active">Beranda</a>
                <a href="{{ route('home') }}" class="landing-nav-link">Belanja</a>
                <a href="{{ route('vouchers.index') }}" class="landing-nav-link">Promo & Voucher</a>
            </div>

            {{-- Right Section --}}
            <div class="landing-nav-right">
                @auth
                    <div class="landing-user-section">
                        <a href="{{ route('home') }}" class="landing-nav-btn-outline">
                            <i class="fas fa-shopping-bag"></i> Shop Now
                        </a>
                        <a href="{{ route('profile.edit') }}" class="landing-nav-user">
                            <div class="landing-user-avatar">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        </a>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="landing-nav-link">Login</a>
                    <a href="{{ route('register') }}" class="landing-nav-btn-solid">Daftar</a>
                @endauth

                {{-- Mobile Hamburger --}}
                <button class="landing-hamburger" id="landingHamburger" aria-label="Toggle Menu">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div class="landing-mobile-menu" id="landingMobileMenu">
            <a href="{{ route('landing') }}" class="landing-mobile-link">🏠 Home</a>
            <a href="{{ route('home') }}" class="landing-mobile-link">🛍️ Shop</a>
            <a href="{{ route('vouchers.index') }}" class="landing-mobile-link">🏷️ Promo & Voucher</a>
            <div class="landing-mobile-divider"></div>
            @auth
                <a href="{{ route('cart.index') }}" class="landing-mobile-link">🛒 Keranjang</a>
                <a href="{{ route('profile.edit') }}" class="landing-mobile-link">👤 {{ Auth::user()->name }}</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="landing-mobile-link landing-mobile-logout">🚪 Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="landing-mobile-link">🔐 Login</a>
                <a href="{{ route('register') }}" class="landing-mobile-link">📝 Daftar</a>
            @endauth
        </div>
    </nav>

    {{-- Page Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('partials.footer')

    {{-- WhatsApp Button --}}
    @include('components.whatsapp-button')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    @stack('scripts')

    {{-- Landing Navbar Script --}}
    <script>
    (function() {
        const navbar = document.getElementById('landingNavbar');
        const hamburger = document.getElementById('landingHamburger');
        const mobileMenu = document.getElementById('landingMobileMenu');
        let isMenuOpen = false;

        // Scroll-aware navbar
        function handleScroll() {
            if (window.scrollY > 60) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        }

        window.addEventListener('scroll', handleScroll, { passive: true });
        handleScroll(); // Initial check

        // Mobile hamburger toggle
        hamburger.addEventListener('click', function() {
            isMenuOpen = !isMenuOpen;
            hamburger.classList.toggle('active', isMenuOpen);
            mobileMenu.classList.toggle('open', isMenuOpen);
            
            // Prevent body scroll when menu is open
            document.body.style.overflow = isMenuOpen ? 'hidden' : '';
        });

        // Close mobile menu on link click
        document.querySelectorAll('.landing-mobile-link').forEach(link => {
            link.addEventListener('click', () => {
                isMenuOpen = false;
                hamburger.classList.remove('active');
                mobileMenu.classList.remove('open');
                document.body.style.overflow = '';
            });
        });
    })();
    </script>

    <style>
    /* ========== LANDING TRANSPARENT NAVBAR ========== */
    .landing-navbar {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1000;
        padding: 0 2rem;
        height: 72px;
        display: flex;
        align-items: center;
        transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        background: transparent;
    }

    .landing-navbar.scrolled {
        background: rgba(255, 255, 255, 0.97);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.06);
        height: 64px;
    }

    .landing-nav-container {
        max-width: 1400px;
        width: 100%;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* Logo */
    .landing-nav-logo {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
    }

    .landing-logo-icon {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        background: linear-gradient(135deg, #d4a5a5 0%, #b5838d 100%);
        font-weight: 700;
        font-size: 1rem;
        flex-shrink: 0;
    }

    .landing-logo-text {
        font-size: 1.2rem;
        font-weight: 700;
        color: #fff;
        letter-spacing: 1px;
        transition: color 0.3s ease;
    }

    .landing-navbar.scrolled .landing-logo-text {
        background: linear-gradient(135deg, #1a1a1a, #d4a5a5);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
    }

    /* Nav Links */
    .landing-nav-links {
        display: flex;
        align-items: center;
        gap: 0.25rem;
    }

    .landing-nav-link {
        padding: 0.5rem 1rem;
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        border-radius: 50px;
        transition: all 0.25s ease;
        letter-spacing: 0.3px;
    }

    .landing-nav-link:hover {
        color: #fff;
        background: rgba(255, 255, 255, 0.15);
    }

    .landing-nav-link.active {
        color: #fff;
        background: rgba(255, 255, 255, 0.2);
    }

    .landing-navbar.scrolled .landing-nav-link {
        color: #4a4a4a;
    }

    .landing-navbar.scrolled .landing-nav-link:hover {
        color: #d4a5a5;
        background: #fef6f5;
    }

    .landing-navbar.scrolled .landing-nav-link.active {
        color: #d4a5a5;
        background: #fef6f5;
    }

    /* Right Section */
    .landing-nav-right {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .landing-nav-btn-solid {
        padding: 0.55rem 1.5rem;
        background: rgba(255, 255, 255, 0.95);
        color: #1a1a1a;
        text-decoration: none;
        font-size: 0.88rem;
        font-weight: 600;
        border-radius: 50px;
        transition: all 0.3s ease;
    }

    .landing-nav-btn-solid:hover {
        background: #d4a5a5;
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(212, 165, 165, 0.4);
    }

    .landing-navbar.scrolled .landing-nav-btn-solid {
        background: #1a1a1a;
        color: #fff;
    }

    .landing-navbar.scrolled .landing-nav-btn-solid:hover {
        background: #d4a5a5;
    }

    /* Outline Button */
    .landing-nav-btn-outline {
        padding: 0.5rem 1.25rem;
        background: transparent;
        color: #fff;
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 500;
        border-radius: 50px;
        border: 1px solid rgba(255, 255, 255, 0.4);
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .landing-nav-btn-outline:hover {
        background: rgba(255, 255, 255, 0.15);
        color: #fff;
        border-color: rgba(255, 255, 255, 0.6);
    }

    .landing-navbar.scrolled .landing-nav-btn-outline {
        color: #1a1a1a;
        border-color: #ddd;
    }

    .landing-navbar.scrolled .landing-nav-btn-outline:hover {
        background: #fef6f5;
        border-color: #d4a5a5;
        color: #d4a5a5;
    }

    /* User Avatar */
    .landing-user-section {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .landing-nav-user {
        text-decoration: none;
    }

    .landing-user-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: linear-gradient(135deg, #d4a5a5, #b5838d);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 600;
        font-size: 0.85rem;
        transition: transform 0.2s ease;
    }

    .landing-nav-user:hover .landing-user-avatar {
        transform: scale(1.08);
    }

    /* Hamburger */
    .landing-hamburger {
        display: none;
        flex-direction: column;
        justify-content: center;
        gap: 5px;
        width: 32px;
        height: 32px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 4px;
    }

    .landing-hamburger span {
        display: block;
        width: 100%;
        height: 2px;
        background: #fff;
        border-radius: 2px;
        transition: all 0.3s ease;
    }

    .landing-navbar.scrolled .landing-hamburger span {
        background: #1a1a1a;
    }

    .landing-hamburger.active span:nth-child(1) {
        transform: rotate(45deg) translate(5px, 5px);
    }

    .landing-hamburger.active span:nth-child(2) {
        opacity: 0;
    }

    .landing-hamburger.active span:nth-child(3) {
        transform: rotate(-45deg) translate(5px, -5px);
    }

    /* Mobile Menu */
    .landing-mobile-menu {
        display: none;
        position: fixed;
        top: 64px;
        left: 0;
        right: 0;
        bottom: 0;
        background: #fff;
        padding: 1.5rem;
        flex-direction: column;
        gap: 0.5rem;
        overflow-y: auto;
        transform: translateY(-10px);
        opacity: 0;
        transition: all 0.3s ease;
        z-index: 999;
    }

    .landing-mobile-menu.open {
        display: flex;
        transform: translateY(0);
        opacity: 1;
    }

    .landing-mobile-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.875rem 1rem;
        color: #4a4a4a;
        text-decoration: none;
        font-size: 1rem;
        border-radius: 12px;
        transition: all 0.2s;
        background: none;
        border: none;
        cursor: pointer;
        width: 100%;
        text-align: left;
        font-family: inherit;
    }

    .landing-mobile-link:hover {
        background: #fef6f5;
        color: #d4a5a5;
    }

    .landing-mobile-divider {
        height: 1px;
        background: #eee;
        margin: 0.5rem 0;
    }

    .landing-mobile-logout {
        color: #e74c3c;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .landing-navbar {
            padding: 0 1rem;
            height: 64px;
        }

        .landing-nav-links {
            display: none;
        }

        .landing-nav-right .landing-nav-link,
        .landing-nav-btn-solid,
        .landing-nav-btn-outline {
            display: none;
        }

        .landing-hamburger {
            display: flex;
        }

        .landing-user-section .landing-nav-btn-outline {
            display: none;
        }

        .landing-user-section .landing-nav-user {
            display: block;
        }
    }
    </style>

    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const redirectUrl = localStorage.getItem('redirect_after_login');
            if (redirectUrl) {
                localStorage.removeItem('redirect_after_login');
                window.location.href = redirectUrl;
            }
        });
    </script>
    @endauth
</body>
</html>
