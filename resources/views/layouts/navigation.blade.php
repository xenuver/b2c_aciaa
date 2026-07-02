<nav x-data="{ open: false, searchOpen: false }" class="fashion-navbar {{ request()->routeIs('home') ? 'navbar-home-transparent' : 'navbar-solid' }}" id="appNavbar">
    <div class="navbar-container">
        <div class="navbar-main">
            <!-- Logo -->
            <div class="logo-wrapper">
                <a href="{{ route('landing') }}" class="logo-link">
                    <x-application-logo class="logo-icon" />
                    <span class="logo-text">ACIAA</span>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <div class="nav-links">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i data-lucide="home"></i>
                    <span>{{ __('Beranda') }}</span>
                </a>
                
                <a href="{{ route('products.index') }}" class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
                    <i data-lucide="shopping-bag"></i>
                    <span>{{ __('Belanja') }}</span>
                </a>

                <a href="{{ route('vouchers.index') }}" class="nav-link {{ request()->routeIs('vouchers.index') ? 'active' : '' }}">
                    <i data-lucide="ticket"></i>
                    <span>{{ __('Promo & Voucher') }}</span>
                </a>
                
                @auth
                    @if(Auth::user()->role === 'admin')
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i data-lucide="layout-dashboard"></i>
                            <span>{{ __('Dashboard Admin') }}</span>
                        </a>
                    @endif
                @endauth
            </div>

            <!-- Right Section -->
            <div class="navbar-right">

                @auth
                    @if(Auth::user()->role !== 'admin')
                        <a href="{{ route('wishlist.index') }}" class="search-toggle wishlist-nav" title="Wishlist Saya" style="position: relative; text-decoration: none;">
                            <i data-lucide="heart"></i>
                            <span class="nav-badge wishlist-badge" id="wishlistCount">0</span>
                        </a>

                        <a href="{{ route('cart.index') }}" class="search-toggle cart-nav" title="Keranjang Belanja" style="position: relative; text-decoration: none;">
                            <i data-lucide="shopping-cart"></i>
                            <span class="nav-badge cart-badge" id="cartCount">0</span>
                        </a>

                        <!-- Notifications Dropdown -->
                        <div class="user-dropdown" x-data="{ 
                            open: false, 
                            notifications: [], 
                            unreadCount: 0, 
                            loading: false,
                            init() {
                                fetch('{{ route('notifications.unread-count') }}')
                                    .then(res => res.json())
                                    .then(data => {
                                        this.unreadCount = data.unread_count;
                                    });
                            },
                            fetchNotifications() {
                                this.loading = true;
                                fetch('{{ route('notifications.latest') }}')
                                    .then(res => res.json())
                                    .then(data => {
                                        this.notifications = data;
                                        this.loading = false;
                                    })
                                    .catch(() => { this.loading = false; });
                            },
                            markAllAsRead() {
                                fetch('{{ route('notifications.mark-all-read') }}', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json'
                                    }
                                })
                                .then(res => res.json())
                                .then(data => {
                                    if (data.success) {
                                        this.unreadCount = 0;
                                        this.notifications.forEach(n => n.is_read = true);
                                        const badge = document.getElementById('notificationCount');
                                        const mobileBadge = document.getElementById('mobileNotificationCount');
                                        if (badge) badge.style.display = 'none';
                                        if (mobileBadge) mobileBadge.style.display = 'none';
                                    }
                                });
                            }
                        }">
                            <button @click="open = !open; if(open) fetchNotifications()" class="search-toggle" title="Notifikasi" style="position: relative; text-decoration: none;">
                                <i data-lucide="bell"></i>
                                <span class="nav-badge" id="notificationCount" x-show="unreadCount > 0" x-text="unreadCount" style="display: none; background: #ff4444; color: white;"></span>
                            </button>

                            <div class="dropdown-panel notification-panel" x-show="open" @click.away="open = false" x-cloak style="width: 320px; max-height: 420px; overflow: hidden; display: flex; flex-direction: column; right: 0; left: auto;">
                                <div class="d-flex justify-content-between align-items-center p-3 border-bottom" style="background: #fff;">
                                    <span class="fw-bold text-dark" style="font-size: 0.9rem;">Notifikasi</span>
                                    <button x-show="unreadCount > 0" @click="markAllAsRead()" class="btn btn-link p-0 text-decoration-none" style="font-size: 0.75rem; color: #d4a5a5;">Tandai semua dibaca</button>
                                </div>
                                
                                <div class="notification-list" style="overflow-y: auto; max-height: 300px; flex: 1;">
                                    <template x-if="loading">
                                        <div class="text-center p-3 text-muted" style="font-size: 0.85rem;">
                                            <div class="spinner-border spinner-border-sm text-secondary me-2" role="status"></div> Loading...
                                        </div>
                                    </template>
                                    
                                    <template x-if="!loading && notifications.length === 0">
                                        <div class="text-center p-4 text-muted" style="font-size: 0.85rem;">
                                            Tidak ada notifikasi baru
                                        </div>
                                    </template>
                                    
                                    <template x-if="!loading && notifications.length > 0">
                                        <div class="d-flex flex-column">
                                            <template x-for="item in notifications" :key="item.id">
                                                <a :href="'/notifications/' + item.id + '/read-redirect'" class="dropdown-item d-flex flex-column align-items-start border-bottom py-2 px-3 text-wrap" :style="item.is_read ? 'background: white;' : 'background: #fef6f5;'">
                                                    <div class="d-flex w-100 justify-content-between align-items-center mb-1">
                                                        <span class="fw-semibold text-dark" style="font-size: 0.82rem;" x-text="item.title"></span>
                                                        <span class="text-muted" style="font-size: 0.68rem;" x-text="item.time_ago"></span>
                                                    </div>
                                                    <p class="text-muted mb-0 text-truncate-2" style="font-size: 0.75rem; line-height: 1.35; white-space: normal;" x-text="item.message"></p>
                                                </a>
                                            </template>
                                        </div>
                                    </template>
                                </div>
                                
                                <div class="text-center p-2.5 border-top" style="background: #fff;">
                                    <a href="{{ route('notifications.index') }}" class="text-decoration-none fw-semibold" style="font-size: 0.8rem; color: #d4a5a5;">Lihat Semua Notifikasi</a>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth

                @auth
                    <div class="user-dropdown" x-data="{ open: false }">
                        <button @click="open = !open" class="user-trigger">
                            <div class="user-avatar">
                                <i data-lucide="user"></i>
                            </div>
                            <span class="user-name">{{ Auth::user()->name }}</span>
                            <i data-lucide="chevron-down" class="dropdown-icon" :class="{ 'rotate': open }"></i>
                        </button>

                        <div class="dropdown-panel" x-show="open" @click.away="open = false" x-cloak>
                            @if(Auth::user()->role !== 'admin')
                                <a href="{{ route('transactions.index') }}" class="dropdown-item">
                                    <i data-lucide="clock" class="me-2" style="width: 16px; height: 16px;"></i> {{ __('Riwayat Transaksi') }}
                                </a>
                                <a href="{{ route('returs.index') }}" class="dropdown-item">
                                    <i data-lucide="rotate-ccw" class="me-2" style="width: 16px; height: 16px;"></i> {{ __('Retur Saya') }}
                                </a>
                            @endif
                            <a href="{{ route('ratings.index') }}" class="dropdown-item">
                                <i class="fas fa-star me-2 text-warning" style="font-size: 14px; margin-left: 2px;"></i> {{ __('Ulasan Saya') }}
                            </a>
                            <a href="{{ route('profile.edit') }}" class="dropdown-item">
                                <i data-lucide="user"></i> Profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item logout-item">
                                    <i data-lucide="log-out"></i> Log Out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="auth-buttons">
                        <a href="{{ route('login') }}" class="auth-link login-link">Login</a>
                        <a href="{{ route('register') }}" class="auth-link register-link">Daftar</a>
                    </div>
                @endauth

                <!-- Mobile Menu Button (Hamburger) -->
                <button @click="open = !open" class="mobile-menu-btn">
                    <svg x-show="!open" class="hamburger-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="12" x2="21" y2="12"></line>
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="3" y1="18" x2="21" y2="18"></line>
                    </svg>
                    <svg x-show="open" class="close-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>
        </div>



    <!-- Mobile Menu -->
    <div x-show="open" x-cloak class="mobile-menu" @click.away="open = false">
        <div class="mobile-menu-inner">
            <a href="{{ route('home') }}" class="mobile-nav-link" @click="open = false">
                <span>🏠</span> Beranda
            </a>
            <a href="{{ route('products.index') }}" class="mobile-nav-link" @click="open = false">
                <span>🛍️</span> Belanja
            </a>
            
            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link" @click="open = false">
                        <span>📊</span> Dashboard Admin
                    </a>
                @else
                    <a href="{{ route('cart.index') }}" class="mobile-nav-link" @click="open = false">
                        <span>🛒</span> Keranjang
                        <span class="mobile-badge" id="mobileCartCount">0</span>
                    </a>
                    <a href="{{ route('wishlist.index') }}" class="mobile-nav-link" @click="open = false">
                        <span>❤️</span> Wishlist
                        <span class="mobile-badge" id="mobileWishlistCount" style="display: none;">0</span>
                    </a>
                    <a href="{{ route('transactions.index') }}" class="mobile-nav-link" @click="open = false">
                        <span>🕐</span> Riwayat
                    </a>
                    <a href="{{ route('returs.index') }}" class="mobile-nav-link" @click="open = false">
                        <span>↩️</span> Retur
                    </a>
                    <a href="{{ route('notifications.index') }}" class="mobile-nav-link" @click="open = false">
                        <span>🔔</span> Notifikasi
                        <span class="mobile-badge" id="mobileNotificationCount" style="display: none;">0</span>
                    </a>
                @endif
            @endauth

            @auth
                <div class="mobile-divider"></div>
                <div class="mobile-user-header">
                    <div class="mobile-user-avatar">👤</div>
                    <div>
                        <div class="mobile-user-name">{{ Auth::user()->name }}</div>
                        <div class="mobile-user-email">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="mobile-nav-link" @click="open = false">
                    <span>👤</span> Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mobile-nav-link logout-mobile" @click="open = false">
                        <span>🚪</span> Log Out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="mobile-nav-link" @click="open = false">
                    <span>🔐</span> Login
                </a>
                <a href="{{ route('register') }}" class="mobile-nav-link" @click="open = false">
                    <span>📝</span> Register
                </a>
            @endauth
        </div>
    </div>
</nav>

<style>
/* Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* Navbar */
.fashion-navbar {
    position: sticky;
    top: 0;
    z-index: 1000;
    background: white;
    border-bottom: 1px solid #eee;
    font-family: 'Inter', sans-serif;
    transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Home Transparent Navbar Styling */
.fashion-navbar.navbar-home-transparent {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    background: transparent;
    border-bottom: 1px solid rgba(255, 255, 255, 0.15);
}

.fashion-navbar.navbar-home-transparent .navbar-main {
    height: 72px;
    transition: height 0.35s cubic-bezier(0.4, 0, 0.2, 1);
}

.fashion-navbar.navbar-home-transparent.scrolled {
    background: rgba(255, 255, 255, 0.97);
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    box-shadow: 0 2px 20px rgba(0, 0, 0, 0.06);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.fashion-navbar.navbar-home-transparent.scrolled .navbar-main {
    height: 64px;
}

/* Home Page Header Colors Transition */
.fashion-navbar.navbar-home-transparent .logo-text {
    color: #fff;
    transition: color 0.3s ease;
}

.fashion-navbar.navbar-home-transparent.scrolled .logo-text {
    background: linear-gradient(135deg, #1a1a1a, #d4a5a5);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

.fashion-navbar.navbar-home-transparent .logo-icon {
    fill: #fff;
    transition: fill 0.3s ease;
}

.fashion-navbar.navbar-home-transparent.scrolled .logo-icon {
    fill: #1a1a1a;
}

/* Nav Links colors */
.fashion-navbar.navbar-home-transparent .nav-link {
    color: rgba(255, 255, 255, 0.9);
}

.fashion-navbar.navbar-home-transparent .nav-link:hover {
    color: #fff;
    background: rgba(255, 255, 255, 0.15);
}

.fashion-navbar.navbar-home-transparent .nav-link.active {
    color: #fff;
    background: rgba(255, 255, 255, 0.2);
}

.fashion-navbar.navbar-home-transparent.scrolled .nav-link {
    color: #4a4a4a;
}

.fashion-navbar.navbar-home-transparent.scrolled .nav-link:hover {
    color: #d4a5a5;
    background: #fef6f5;
}

.fashion-navbar.navbar-home-transparent.scrolled .nav-link.active {
    color: #d4a5a5;
    background: #fef6f5;
}

/* Right icons & Dropdowns */
.fashion-navbar.navbar-home-transparent .search-toggle svg,
.fashion-navbar.navbar-home-transparent .user-trigger {
    color: rgba(255, 255, 255, 0.9);
}

.fashion-navbar.navbar-home-transparent .search-toggle:hover,
.fashion-navbar.navbar-home-transparent .user-trigger:hover {
    background: rgba(255, 255, 255, 0.15);
}

.fashion-navbar.navbar-home-transparent.scrolled .search-toggle svg,
.fashion-navbar.navbar-home-transparent.scrolled .user-trigger {
    color: #4a4a4a;
}

.fashion-navbar.navbar-home-transparent.scrolled .search-toggle:hover,
.fashion-navbar.navbar-home-transparent.scrolled .user-trigger:hover {
    background: #fef6f5;
}

/* Auth Buttons */
.fashion-navbar.navbar-home-transparent .auth-link.login-link {
    color: rgba(255, 255, 255, 0.9);
}

.fashion-navbar.navbar-home-transparent.scrolled .auth-link.login-link {
    color: #4a4a4a;
}

.fashion-navbar.navbar-home-transparent .auth-link.register-link {
    background: rgba(255, 255, 255, 0.95);
    color: #1a1a1a;
}

.fashion-navbar.navbar-home-transparent.scrolled .auth-link.register-link {
    background: #1a1a1a;
    color: white;
}

/* Mobile Hamburger colors */
.fashion-navbar.navbar-home-transparent .mobile-menu-btn svg {
    color: #fff;
    transition: color 0.3s ease;
}

.fashion-navbar.navbar-home-transparent.scrolled .mobile-menu-btn svg {
    color: #4a4a4a;
}

/* Search container when transparent */
.fashion-navbar.navbar-home-transparent .search-bar-container {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(8px);
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    margin-left: -1rem;
    margin-right: -1rem;
    padding-left: 1rem;
    padding-right: 1rem;
    border-top: none;
}

.navbar-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 1rem;
}

.navbar-main {
    display: flex;
    justify-content: space-between;
    align-items: center;
    height: 64px;
    gap: 1rem;
}

/* Logo */
.logo-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    text-decoration: none;
}

.logo-icon {
    width: 28px;
    height: 28px;
    fill: #1a1a1a;
}

.logo-text {
    font-size: 1.1rem;
    font-weight: 700;
    background: linear-gradient(135deg, #1a1a1a, #d4a5a5);
    -webkit-background-clip: text;
    background-clip: text;
    color: transparent;
}

/* Desktop Nav */
.nav-links {
    display: flex;
    align-items: center;
    gap: 0.25rem;
    flex: 1;
}

.nav-link {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.875rem;
    color: #4a4a4a;
    text-decoration: none;
    font-size: 0.875rem;
    font-weight: 500;
    border-radius: 50px;
    transition: all 0.2s;
}

.nav-link i, .nav-link svg {
    width: 18px;
    height: 18px;
}

.nav-link:hover {
    color: #d4a5a5;
    background: #fef6f5;
}

.nav-link.active {
    color: #d4a5a5;
    background: #fef6f5;
}

/* Badges */
.cart-nav, .wishlist-nav {
    position: relative;
}

.nav-badge {
    position: absolute;
    top: -5px;
    right: -5px;
    background: #ff4444;
    color: white;
    font-size: 0.6rem;
    font-weight: 600;
    padding: 0.15rem 0.4rem;
    border-radius: 50px;
    min-width: 18px;
    display: none;
}

/* Right Section */
.navbar-right {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.search-toggle {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.search-toggle svg {
    width: 20px;
    height: 20px;
    color: #4a4a4a;
}

.search-toggle:hover {
    background: #fef6f5;
}

/* User Dropdown */
.user-dropdown {
    position: relative;
}

.user-trigger {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.5rem 0.875rem;
    background: none;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    font-weight: 500;
    color: #4a4a4a;
}

.user-trigger:hover {
    background: #fef6f5;
}

.user-avatar {
    width: 28px;
    height: 28px;
    background: linear-gradient(135deg, #d4a5a5, #b5838d);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.user-avatar svg {
    width: 14px;
    height: 14px;
    color: white;
}

.user-name {
    font-size: 0.875rem;
}

.dropdown-icon {
    width: 16px;
    height: 16px;
    transition: transform 0.2s;
}

.dropdown-icon.rotate {
    transform: rotate(180deg);
}

.dropdown-panel {
    position: absolute;
    top: 100%;
    right: 0;
    margin-top: 0.5rem;
    width: 200px;
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    overflow: hidden;
    z-index: 1000;
}

.dropdown-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.75rem 1rem;
    color: #4a4a4a;
    text-decoration: none;
    transition: all 0.2s;
    width: 100%;
    background: none;
    border: none;
    cursor: pointer;
    font-size: 0.875rem;
    text-align: left;
}

.dropdown-item svg {
    width: 18px;
    height: 18px;
}

.dropdown-item:hover {
    background: #fef6f5;
    color: #d4a5a5;
}

.logout-item {
    width: 100%;
}

/* Auth Buttons */
.auth-buttons {
    display: flex;
    gap: 0.5rem;
}

.auth-link {
    padding: 0.5rem 1rem;
    text-decoration: none;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 500;
}

.login-link {
    color: #4a4a4a;
}

.register-link {
    background: #1a1a1a;
    color: white;
}

/* Mobile Menu Button - Hamburger */
.mobile-menu-btn {
    display: none;
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.5rem;
    align-items: center;
    justify-content: center;
}

.hamburger-icon, .close-icon {
    width: 24px;
    height: 24px;
    color: #4a4a4a;
}

/* Search Bar */
.search-bar-container {
    padding: 0.75rem 0 1rem;
    border-top: 1px solid #eee;
}

.search-form {
    position: relative;
    max-width: 500px;
    margin: 0 auto;
}

.search-icon {
    position: absolute;
    left: 1rem;
    top: 50%;
    transform: translateY(-50%);
    width: 18px;
    height: 18px;
    color: #999;
}

.search-input {
    width: 100%;
    padding: 0.75rem 6.5rem 0.75rem 2.5rem;
    border: 1px solid #e0e0e0;
    border-radius: 50px;
    font-size: 0.875rem;
    outline: none;
}

.search-input:focus {
    border-color: #d4a5a5;
}

.search-submit {
    position: absolute;
    right: 0.5rem;
    top: 50%;
    transform: translateY(-50%);
    padding: 0.35rem 1rem;
    background: #1a1a1a;
    color: white;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    font-size: 0.75rem;
}

/* Mobile Menu Panel */
.mobile-menu {
    position: fixed;
    top: 64px;
    left: 0;
    right: 0;
    bottom: 0;
    background: white;
    z-index: 999;
    overflow-y: auto;
    padding: 1rem;
}

.mobile-menu-inner {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.mobile-nav-link {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1rem;
    color: #4a4a4a;
    text-decoration: none;
    font-size: 1rem;
    border-radius: 12px;
    transition: all 0.2s;
}

.mobile-nav-link:hover {
    background: #fef6f5;
}

.mobile-badge {
    margin-left: auto;
    background: #ff4444;
    color: white;
    font-size: 0.7rem;
    padding: 0.15rem 0.5rem;
    border-radius: 50px;
}

.mobile-divider {
    height: 1px;
    background: #eee;
    margin: 0.5rem 0;
}

.mobile-user-header {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1rem;
    background: #fef6f5;
    border-radius: 12px;
    margin-top: 0.5rem;
}

.mobile-user-avatar {
    font-size: 2rem;
}

.mobile-user-name {
    font-weight: 600;
    color: #1a1a1a;
}

.mobile-user-email {
    font-size: 0.75rem;
    color: #999;
}

.logout-mobile {
    width: 100%;
    text-align: left;
    background: none;
    border: none;
    cursor: pointer;
}

/* Alpine JS Cloak */
[x-cloak] {
    display: none !important;
}

/* ========== RESPONSIVE (MOBILE & TABLET) ========== */
@media (max-width: 768px) {
    /* Sembunyikan desktop navigation dan beberapa elemen */
    .nav-links {
        display: none;
    }
    
    .search-toggle {
        display: flex;
    }
    
    .user-name {
        display: none;
    }
    
    .auth-buttons {
        display: none;
    }
    
    /* Tampilkan tombol hamburger */
    .mobile-menu-btn {
        display: flex;
    }
}

@media (max-width: 480px) {
    .navbar-container {
        padding: 0 0.75rem;
    }
    
    .logo-text {
        font-size: 0.9rem;
    }
    
    .user-avatar {
        width: 32px;
        height: 32px;
    }
    
    .search-input {
        font-size: 0.8rem;
    }
}

/* Custom Notifications Dropdown styles */
.text-truncate-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;  
    overflow: hidden;
}
.notification-list::-webkit-scrollbar {
    width: 4px;
}
.notification-list::-webkit-scrollbar-track {
    background: #f1f1f1;
}
.notification-list::-webkit-scrollbar-thumb {
    background: #d4a5a5;
    border-radius: 2px;
}
.notification-list::-webkit-scrollbar-thumb:hover {
    background: #b5838d;
}
</style>

<script src="https://unpkg.com/lucide@latest"></script>
<script>
// Inisialisasi setelah halaman load
document.addEventListener('DOMContentLoaded', function() {
    // Lucide icons
    if (typeof lucide !== 'undefined') {
        lucide.createIcons();
    }
    
    // Logika tombol hapus ('X') di pencarian navbar
    const searchInput = document.getElementById('searchInput');
    const clearSearchBtn = document.getElementById('clearSearchBtn');
    
    if (searchInput && clearSearchBtn) {
        searchInput.addEventListener('input', function() {
            if (this.value.length > 0) {
                clearSearchBtn.style.display = 'flex';
            } else {
                clearSearchBtn.style.display = 'none';
            }
        });
        
        clearSearchBtn.addEventListener('click', function() {
            searchInput.value = '';
            clearSearchBtn.style.display = 'none';
            searchInput.focus();
            
            // Jika sedang memfilter pencarian di URL, submit ulang form untuk me-reset pencarian
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('search')) {
                searchInput.closest('form').submit();
            }
        });
    }
    
    @auth
    // Update badge cart
    fetch('{{ route("cart.count") }}')
        .then(res => res.json())
        .then(data => {
            const badge = document.getElementById('cartCount');
            const mobileBadge = document.getElementById('mobileCartCount');
            if (badge && data.count > 0) {
                badge.textContent = data.count;
                badge.style.display = 'inline-flex';
            }
            if (mobileBadge && data.count > 0) {
                mobileBadge.textContent = data.count;
                mobileBadge.style.display = 'inline-block';
            }
        })
        .catch(() => {});
    
    // Update badge wishlist (desktop & mobile)
    fetch('{{ route("wishlist.count") }}')
        .then(res => res.json())
        .then(data => {
            const desktopBadge = document.getElementById('wishlistCount');
            const mobileBadge = document.getElementById('mobileWishlistCount');
            if (desktopBadge && data.count > 0) {
                desktopBadge.textContent = data.count;
                desktopBadge.style.display = 'inline-flex';
            } else if (desktopBadge) {
                desktopBadge.style.display = 'none';
            }
            if (mobileBadge && data.count > 0) {
                mobileBadge.textContent = data.count;
                mobileBadge.style.display = 'inline-block';
            } else if (mobileBadge) {
                mobileBadge.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error fetching wishlist count:', error);
        });

    // Update badge notifications
    fetch('{{ route("notifications.unread-count") }}')
        .then(res => res.json())
        .then(data => {
            const badge = document.getElementById('notificationCount');
            const mobileBadge = document.getElementById('mobileNotificationCount');
            if (badge && data.unread_count > 0) {
                badge.textContent = data.unread_count;
                badge.style.display = 'inline-flex';
            }
            if (mobileBadge && data.unread_count > 0) {
                mobileBadge.textContent = data.unread_count;
                mobileBadge.style.display = 'inline-block';
            }
        })
        .catch(() => {});
    @endauth

    // Scroll aware navbar for home page
    const appNavbar = document.getElementById('appNavbar');
    if (appNavbar && appNavbar.classList.contains('navbar-home-transparent')) {
        function handleAppNavbarScroll() {
            if (window.scrollY > 60) {
                appNavbar.classList.add('scrolled');
            } else {
                appNavbar.classList.remove('scrolled');
            }
        }
        window.addEventListener('scroll', handleAppNavbarScroll, { passive: true });
        handleAppNavbarScroll();
    }
});
</script>