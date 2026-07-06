<nav x-data="{ open: false, searchOpen: false }" @close-mobile-search.window="searchOpen = false" class="fashion-navbar {{ (request()->routeIs('home') || request()->routeIs('landing')) ? 'navbar-home-transparent' : 'navbar-solid' }}" id="appNavbar">
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

            <!-- Live Search Bar -->
            <div x-data="{
                    query: '',
                    results: [],
                    open: false,
                    loading: false,
                    search() {
                        if (this.query.length < 2) {
                            this.results = [];
                            this.open = false;
                            return;
                        }
                        this.loading = true;
                        axios.get('/api/search/live', { params: { q: this.query } })
                            .then(response => {
                                this.results = response.data.products || [];
                                this.open = true;
                            })
                            .catch(() => {
                                this.results = [];
                            })
                            .finally(() => {
                                this.loading = false;
                            });
                    },
                    close() {
                        this.open = false;
                        this.results = [];
                    },
                    goToFullSearch() {
                        if (this.query.trim().length > 0) {
                            window.location.href = '/products?search=' + encodeURIComponent(this.query);
                        }
                    },
                    formatPrice(price) {
                        return 'Rp ' + parseInt(price).toLocaleString('id-ID');
                    }
                }"
                @click.outside="close()"
                class="navbar-live-search">

                <div class="live-search-input-wrapper">
                    <!-- Search icon -->
                    <svg class="live-search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                    </svg>

                    <input
                        type="text"
                        x-model="query"
                        @input.debounce.300ms="search()"
                        @keydown.enter.prevent="goToFullSearch()"
                        @keydown.escape="close()"
                        @focus="query.length >= 2 && search()"
                        placeholder="Cari produk..."
                        class="live-search-input"
                        aria-label="Cari produk"
                        autocomplete="off"
                    />

                    <!-- Loading spinner -->
                    <div x-show="loading" class="live-search-spinner" x-cloak>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="spin-icon"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                    </div>

                    <!-- Clear button -->
                    <button
                        x-show="query.length > 0 && !loading"
                        @click="query = ''; close();"
                        class="live-search-clear"
                        type="button"
                        aria-label="Hapus pencarian"
                        x-cloak>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>

                <!-- Dropdown Results -->
                <div x-show="open && results.length > 0" x-cloak class="live-search-dropdown" @click.stop>
                    <template x-for="product in results" :key="product.id">
                        <a :href="product.url" class="live-search-result-item">
                            <img :src="product.image" :alt="product.name" class="live-search-result-img"
                                 onerror="this.src='/images/default.jpg'">
                            <div class="live-search-result-info">
                                <p class="live-search-result-name" x-text="product.name"></p>
                                <span class="live-search-result-price" x-text="product.discount_price ? formatPrice(product.discount_price) : formatPrice(product.price)"></span>
                            </div>
                        </a>
                    </template>
                    <a href="#" @click.prevent="goToFullSearch()" class="live-search-view-all">
                        Lihat semua hasil untuk "<span x-text="query"></span>"
                    </a>
                </div>

                <!-- Empty State -->
                <div x-show="open && query.length >= 2 && results.length === 0 && !loading" x-cloak class="live-search-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#ccc;"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    <span>Produk tidak ditemukan</span>
                </div>
            </div>

            <!-- Right Section -->
            <div class="navbar-right">

                @if(!Auth::check() || Auth::user()->role !== 'admin')
                    <a href="{{ route('wishlist.index') }}" class="search-toggle wishlist-nav" title="Wishlist Saya" style="position: relative; text-decoration: none;">
                        <i data-lucide="heart"></i>
                        @auth
                            <span class="nav-badge wishlist-badge" id="wishlistCount">0</span>
                        @endauth
                    </a>

                    <a href="{{ route('cart.index') }}" class="search-toggle cart-nav" title="Keranjang Belanja" style="position: relative; text-decoration: none;">
                        <i data-lucide="shopping-cart"></i>
                        @auth
                            <span class="nav-badge cart-badge" id="cartCount">0</span>
                        @endauth
                    </a>

                    @auth
                        <!-- Notifications Dropdown -->
                        <div class="user-dropdown" x-data="{ 
                            open: false, 
                            notifications: [], 
                            unreadCount: {{ isset($unreadCount) ? $unreadCount : 0 }}, 
                            loading: false,
                            init() {
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
                                    <button x-show="unreadCount > 0" @click="markAllAsRead()" class="btn btn-link p-0 text-decoration-none" style="font-size: 0.75rem; color: var(--color-primary);">Tandai semua dibaca</button>
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
                                                <a :href="'/notifications/' + item.id + '/read-redirect'" class="dropdown-item d-flex flex-column align-items-start border-bottom py-2 px-3 text-wrap" :style="item.is_read ? 'background: white;' : 'background: var(--color-surface-alt);'">
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
                                    <a href="{{ route('notifications.index') }}" class="text-decoration-none fw-semibold" style="font-size: 0.8rem; color: var(--color-primary);">Lihat Semua Notifikasi</a>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('notifications.index') }}" class="search-toggle" title="Notifikasi" style="position: relative; text-decoration: none;">
                            <i data-lucide="bell"></i>
                        </a>
                    @endauth
                @endif

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

                <!-- Mobile Search Toggle Button (only visible on mobile) -->
                <button @click="searchOpen = !searchOpen; if(searchOpen) $nextTick(() => { const el = document.querySelector('[x-ref=mobileSearchInput]'); if(el) el.focus(); })" 
                        class="mobile-search-btn search-toggle" 
                        type="button"
                        aria-label="Cari produk"
                        :aria-expanded="searchOpen">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                    </svg>
                </button>

                <!-- Mobile Menu Button (Hamburger) -->
                <button @click="open = !open" class="mobile-menu-btn" aria-label="Buka menu navigasi">
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

        <!-- Mobile Full-Width Search Bar (only visible on mobile when toggled) -->
        <div x-show="searchOpen"
             x-cloak
             x-transition
             class="mobile-search-bar-wrapper"
             x-data="{
                 query: '',
                 results: [],
                 open: false,
                 loading: false,
                 search() {
                     if (this.query.length < 2) {
                         this.results = [];
                         this.open = false;
                         return;
                     }
                     this.loading = true;
                     axios.get('/api/search/live', { params: { q: this.query } })
                         .then(response => {
                             this.results = response.data.products || [];
                             this.open = true;
                         })
                         .catch(() => {
                             this.results = [];
                         })
                         .finally(() => {
                             this.loading = false;
                         });
                 },
                 close() {
                     this.open = false;
                     this.results = [];
                 },
                 goToFullSearch() {
                     if (this.query.trim().length > 0) {
                         window.location.href = '/products?search=' + encodeURIComponent(this.query);
                     }
                 },
                 formatPrice(price) {
                     return 'Rp ' + parseInt(price).toLocaleString('id-ID');
                 }
             }"
             @click.outside="close()">

            <div class="mobile-search-inner">
                <div class="live-search-input-wrapper" style="width: 100%;">
                    <!-- Search icon -->
                    <svg class="live-search-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/>
                    </svg>

                    <input
                        type="text"
                        x-model="query"
                        @input.debounce.300ms="search()"
                        @keydown.enter.prevent="goToFullSearch()"
                        @keydown.escape="close(); $dispatch('close-mobile-search')"
                        @focus="query.length >= 2 && search()"
                        x-ref="mobileSearchInput"
                        placeholder="Cari produk..."
                        class="live-search-input"
                        aria-label="Cari produk di mobile"
                        autocomplete="off"
                        style="border-radius: 12px;"
                    />

                    <!-- Loading spinner -->
                    <div x-show="loading" class="live-search-spinner" x-cloak>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="spin-icon"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg>
                    </div>

                    <!-- Clear button -->
                    <button
                        x-show="query.length > 0 && !loading"
                        @click="query = ''; close();"
                        class="live-search-clear"
                        type="button"
                        aria-label="Hapus pencarian"
                        x-cloak>
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    </button>
                </div>

                <!-- Dropdown Results (mobile) -->
                <div x-show="open && results.length > 0" x-cloak class="live-search-dropdown mobile-search-dropdown" @click.stop>
                    <template x-for="product in results" :key="product.id">
                        <a :href="product.url" class="live-search-result-item">
                            <img :src="product.image" :alt="product.name" class="live-search-result-img"
                                 onerror="this.src='/images/default.jpg'">
                            <div class="live-search-result-info">
                                <p class="live-search-result-name" x-text="product.name"></p>
                                <span class="live-search-result-price" x-text="product.discount_price ? formatPrice(product.discount_price) : formatPrice(product.price)"></span>
                            </div>
                        </a>
                    </template>
                    <a href="#" @click.prevent="goToFullSearch()" class="live-search-view-all">
                        Lihat semua hasil untuk "<span x-text="query"></span>"
                    </a>
                </div>

                <!-- Empty State (mobile) -->
                <div x-show="open && query.length >= 2 && results.length === 0 && !loading" x-cloak class="live-search-empty mobile-search-empty">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#ccc;"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                    <span>Produk tidak ditemukan</span>
                </div>
            </div>
        </div>

    <!-- Mobile Menu -->
    <div x-show="open" x-transition.duration.300ms x-cloak class="mobile-menu" @click.away="open = false">
        <div class="mobile-menu-inner">
            <a href="{{ route('home') }}" class="mobile-nav-link" @click="open = false">
                <i data-lucide="home"></i> Beranda
            </a>
            <a href="{{ route('products.index') }}" class="mobile-nav-link" @click="open = false">
                <i data-lucide="shopping-bag"></i> Belanja
            </a>
            
            @if(!Auth::check() || Auth::user()->role !== 'admin')
                <a href="{{ route('cart.index') }}" class="mobile-nav-link" @click="open = false">
                    <i data-lucide="shopping-cart"></i> Keranjang
                    @auth
                        <span class="mobile-badge" id="mobileCartCount">0</span>
                    @endauth
                </a>
                <a href="{{ route('wishlist.index') }}" class="mobile-nav-link" @click="open = false">
                    <i data-lucide="heart"></i> Wishlist
                    @auth
                        <span class="mobile-badge" id="mobileWishlistCount" style="display: none;">0</span>
                    @endauth
                </a>
                @auth
                    <a href="{{ route('transactions.index') }}" class="mobile-nav-link" @click="open = false">
                        <i data-lucide="clock"></i> Riwayat
                    </a>
                    <a href="{{ route('returs.index') }}" class="mobile-nav-link" @click="open = false">
                        <i data-lucide="rotate-ccw"></i> Retur
                    </a>
                    <a href="{{ route('notifications.index') }}" class="mobile-nav-link" @click="open = false">
                        <i data-lucide="bell"></i> Notifikasi
                        <span class="mobile-badge" id="mobileNotificationCount" style="{{ (isset($unreadCount) && $unreadCount > 0) ? '' : 'display: none;' }}">{{ $unreadCount ?? 0 }}</span>
                    </a>
                @else
                    <a href="{{ route('notifications.index') }}" class="mobile-nav-link" @click="open = false">
                        <i data-lucide="bell"></i> Notifikasi
                    </a>
                @endauth
            @endif

            @auth
                @if(Auth::user()->role === 'admin')
                    <a href="{{ route('admin.dashboard') }}" class="mobile-nav-link" @click="open = false">
                        <i data-lucide="layout-dashboard"></i> Dashboard Admin
                    </a>
                @endif
            @endauth

            @auth
                <div class="mobile-divider"></div>
                <div class="mobile-user-header">
                    <div class="mobile-user-avatar"><i data-lucide="user" style="width: 28px; height: 28px;"></i></div>
                    <div>
                        <div class="mobile-user-name">{{ Auth::user()->name }}</div>
                        <div class="mobile-user-email">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="mobile-nav-link" @click="open = false">
                    <i data-lucide="user"></i> Profile
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="mobile-nav-link logout-mobile" @click="open = false">
                        <i data-lucide="log-out"></i> Log Out
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="mobile-nav-link" @click="open = false">
                    <i data-lucide="log-in"></i> Login
                </a>
                <a href="{{ route('register') }}" class="mobile-nav-link" @click="open = false">
                    <i data-lucide="user-plus"></i> Register
                </a>
            @endauth
        </div>
    </div>
</nav>



<script src="https://unpkg.com/lucide@latest"></script>
<script>
// Inisialisasi setelah halaman load
document.addEventListener('DOMContentLoaded', function() {
    // Init Lucide icons
    function initLucide() {
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    }
    initLucide();
    
    // Re-init after Alpine is done
    document.addEventListener('alpine:initialized', function() {
        initLucide();
    });
    
    // Also re-init on any Alpine component mount
    document.addEventListener('alpine:init', function() {
        setTimeout(initLucide, 100);
    });
    
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

    // Re-init Lucide whenever Alpine components update
    setInterval(function() {
        if (typeof lucide !== 'undefined' && document.querySelector('[data-lucide]')) {
            lucide.createIcons();
        }
    }, 500);

});
</script>

<script>
    // Scroll aware navbar for all pages
    (function() {
        const navbar = document.getElementById('appNavbar');
        if (navbar) {
            function handleScroll() {
                if (window.scrollY > 50) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
            }
            window.addEventListener('scroll', handleScroll, { passive: true });
            // Jalankan sekali saat load
            handleScroll();
        }
    })();
</script>