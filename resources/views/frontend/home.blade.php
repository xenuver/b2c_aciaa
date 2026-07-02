@extends('layouts.app')

@section('title', 'Beranda - Aciaa Fashion Store')

@section('content')
<div class="fashion-store">
    
    {{-- Hero Carousel Section - Premium & Bold --}}
    <div class="custom-carousel" id="customBannerCarousel">
        <div class="carousel-inner-custom">
            @if($banners->count() > 0)
                @foreach($banners as $key => $banner)
                <div class="carousel-item-custom {{ $key == 0 ? 'active' : '' }}">
                    <div class="carousel-bg-custom" style="background-image: url('{{ asset('storage/' . $banner->image) }}');"></div>
                    <div class="carousel-overlay-custom"></div>
                    <div class="container carousel-container-custom">
                        <div class="carousel-content-custom">
                            <span class="carousel-subtitle-custom">{{ $banner->subtitle ?? 'Premium Women\'s Fashion' }}</span>
                            <h1 class="carousel-title-custom">{!! nl2br(e($banner->title ?? 'Elevate Your\nEveryday Style')) !!}</h1>
                            <p class="carousel-desc-custom">{{ $banner->description ?? 'Temukan kombinasi sempurna kenyamanan dan gaya modern terbaik dari Aciaa.' }}</p>
                            
                            <!-- Search Bar in Hero -->
                            <form action="{{ route('products.index') }}" method="GET" class="hero-search-form">
                                <div class="hero-search-wrapper">
                                    <i data-lucide="search" class="hero-search-icon"></i>
                                    <input type="text" name="search" class="hero-search-input" placeholder="Cari produk impianmu...">
                                    <button type="submit" class="hero-search-btn">Cari</button>
                                </div>
                            </form>

                            <div class="mt-4">
                                <a href="{{ $banner->link ?? route('products.index') }}" class="hero-btn">Shop Now →</a>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                {{-- Fallback static banner --}}
                <div class="carousel-item-custom active">
                    <div class="carousel-bg-custom" style="background-image: url('{{ asset('images/landing_hero.png') }}');"></div>
                    <div class="carousel-overlay-custom"></div>
                    <div class="container carousel-container-custom">
                        <div class="carousel-content-custom">
                            <span class="carousel-subtitle-custom">WELCOME TO ACIAA</span>
                            <h1 class="carousel-title-custom">Elevate Your<br>Everyday Style</h1>
                            <p class="carousel-desc-custom">Temukan kombinasi sempurna kenyamanan dan gaya modern terbaik kami.</p>
                            
                            <!-- Search Bar in Hero -->
                            <form action="{{ route('products.index') }}" method="GET" class="hero-search-form">
                                <div class="hero-search-wrapper">
                                    <i data-lucide="search" class="hero-search-icon"></i>
                                    <input type="text" name="search" class="hero-search-input" placeholder="Cari produk impianmu...">
                                    <button type="submit" class="hero-search-btn">Cari</button>
                                </div>
                            </form>

                            <div class="mt-4">
                                <a href="{{ route('products.index') }}" class="hero-btn">Shop Now →</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        @if($banners->count() > 1)
            <!-- Controls -->
            <button class="carousel-ctrl-prev" aria-label="Previous Slide">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="carousel-ctrl-next" aria-label="Next Slide">
                <i class="fas fa-chevron-right"></i>
            </button>
            
            <!-- Indicators -->
            <div class="carousel-dots-custom">
                @foreach($banners as $key => $banner)
                <button class="carousel-dot-custom {{ $key == 0 ? 'active' : '' }}" data-slide-to="{{ $key }}" aria-label="Slide {{ $key + 1 }}"></button>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Featured Banner --}}
    <div class="featured-banner">
        <div class="container">
            <div class="featured-grid">
                <div class="featured-item">
                    <i class="fas fa-truck-fast"></i>
                    <h4>Free Shipping</h4>
                    <p>On orders over Rp 500K</p>
                </div>
                <div class="featured-item">
                    <i class="fas fa-rotate-right"></i>
                    <h4>Easy Returns</h4>
                    <p>30 days return policy</p>
                </div>
                <div class="featured-item">
                    <i class="fas fa-shield-heart"></i>
                    <h4>Secure Payment</h4>
                    <p>100% secure transactions</p>
                </div>
                <div class="featured-item">
                    <i class="fas fa-gift"></i>
                    <h4>Member Rewards</h4>
                    <p>Exclusive discounts</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Kategori dengan desain modern --}}
    <div class="section-container">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Shop by Category</span>
                <h2 class="section-title">Discover Your Style</h2>
                <div class="section-divider"></div>
                <p class="section-subtitle">Explore our curated collections for every occasion</p>
            </div>
            <div class="category-grid">
                @foreach($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="category-card">
                    <div class="category-card-inner">
                        <div class="category-icon">
                            <i class="fas {{ $category->icon ?? 'fa-tag' }}"></i>
                        </div>
                        <h3 class="category-name">{{ $category->name }}</h3>
                        <span class="category-shop">Shop Now →</span>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ========== BANNER PROMO PRODUK (CAROUSEL VERTICAL / POSTER) ========== --}}
    <div class="promo-products-banner">
        <div class="container">
            <div class="promo-banner-header">
                <span class="promo-banner-tag">✨ Special Offer</span>
                <h2 class="promo-banner-title">Flash Sale <span class="flash-icon">🔥</span></h2>
                <p class="promo-banner-desc">Dapatkan produk terbaik dengan harga spesial sebelum waktu habis!</p>
                
                <!-- Countdown Timer -->
                <div class="countdown-timer" id="homepageCountdownTimer">
                    <div class="timer-item">
                        <span class="timer-number" id="homeHours">00</span>
                        <span class="timer-label">Jam</span>
                    </div>
                    <span class="timer-sep">:</span>
                    <div class="timer-item">
                        <span class="timer-number" id="homeMinutes">00</span>
                        <span class="timer-label">Menit</span>
                    </div>
                    <span class="timer-sep">:</span>
                    <div class="timer-item">
                        <span class="timer-number" id="homeSeconds">00</span>
                        <span class="timer-label">Detik</span>
                    </div>
                </div>
            </div>
            
            <!-- Carousel / Slider untuk produk promo -->
            <div class="promo-slider-container">
                <div class="promo-slider" id="promoSlider">
                    <div class="promo-slider-wrapper" id="promoSliderWrapper">
                        @foreach($promoProducts as $index => $product)
                        <div class="promo-slide" data-product-id="{{ $product->id }}" data-product-slug="{{ $product->slug }}">
                            <div class="promo-slide-inner">
                                <div class="promo-slide-image">
                                    <img src="{{ asset('storage/' . ($product->image ?? 'default.jpg')) }}" alt="{{ $product->name }}">
                                    <span class="promo-slide-discount">-{{ $product->discount_price ? round((1 - $product->discount_price/$product->price) * 100) : rand(20, 50) }}%</span>
                                    <div class="promo-slide-overlay"></div>
                                </div>
                                <div class="promo-slide-info">
                                    <h3 class="promo-slide-title">{{ Str::limit($product->name, 35) }}</h3>
                                    <div class="promo-slide-price">
                                        <span class="promo-slide-original">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                        <span class="promo-slide-sale">Rp {{ number_format($product->discount_price ?? $product->price * 0.7, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="promo-slide-buttons">
                                        <button class="promo-slide-buy" data-product-id="{{ $product->id }}" data-product-slug="{{ $product->slug }}">
                                            <i class="fas fa-bolt"></i> Beli Sekarang
                                        </button>
                                        <button class="promo-slide-detail" data-product-slug="{{ $product->slug }}">
                                            <i class="fas fa-eye"></i> Detail
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <button class="promo-slider-prev" id="promoSliderPrev">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="promo-slider-next" id="promoSliderNext">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            
            <!-- Dots indicator -->
            <div class="promo-slider-dots" id="promoSliderDots"></div>
        </div>
    </div>

    {{-- Produk Terbaru --}}
    <div class="section-container">
        <div class="container">
            <div class="section-header">
                <span class="section-tag">Just Arrived</span>
                <h2 class="section-title">New Collection</h2>
                <div class="section-divider"></div>
                <p class="section-subtitle">Be the first to shop our latest arrivals</p>
            </div>
            <div class="product-grid">
                @foreach($newProducts as $product)
                <div class="product-card" data-product-id="{{ $product->id }}">
                    <div class="product-image-wrapper">
                        <img src="{{ asset('storage/' . ($product->image ?? 'default.jpg')) }}" alt="{{ $product->name }}" class="product-image">
                        <div class="product-actions">
                            <button class="action-btn quick-view" data-product="{{ $product->slug }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn wishlist-toggle-btn" data-product-id="{{ $product->id }}">
                                <i class="{{ $product->isInWishlist() ? 'fas' : 'far' }} fa-heart"></i>
                            </button>
                        </div>
                        <span class="product-badge new">New</span>
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">{{ Str::limit($product->name, 40) }}</h3>
                        <div class="product-price">
                            @if($product->discount_price)
                                <span class="price-original">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="price-sale">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            @else
                                <span class="price-current">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <a href="{{ route('products.show', $product->slug) }}" class="product-link">View Details →</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- ========== SECTION REKOMENDASI UNTUK ANDA ========== --}}
    @if($recommendations->count() > 0)
    <div class="section-container reco-section">
        <div class="container">
            <div class="section-header">
                
                <h2 class="section-title">{{ $recommendationTitle }}</h2>
                <div class="section-divider reco-divider"></div>
                <p class="section-subtitle">
                    @if($recommendationSubtitle === 'Personalized')
                        Berdasarkan minat dan wishlist Anda
                    @else
                        Produk terlaris yang disukai banyak pembeli
                    @endif
                </p>
            </div>
            <div class="product-grid reco-grid">
                @foreach($recommendations as $product)
                <div class="product-card reco-card" data-product-id="{{ $product->id }}">
                    <div class="product-image-wrapper">
                        <img src="{{ asset('storage/' . ($product->image ?? 'default.jpg')) }}" alt="{{ $product->name }}" class="product-image">
                        <div class="product-actions">
                            <button class="action-btn quick-view" data-product="{{ $product->slug }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="action-btn wishlist-toggle-btn" data-product-id="{{ $product->id }}">
                                <i class="{{ $product->isInWishlist() ? 'fas' : 'far' }} fa-heart"></i>
                            </button>
                        </div>
                        @if($product->discount_price)
                            <span class="product-badge promo">-{{ round((1 - $product->discount_price/$product->price) * 100) }}%</span>
                        @elseif($recommendationSubtitle === 'Personalized')
                            <span class="product-badge reco-badge">
                                <i class="fas fa-heart"></i> Untuk Anda
                            </span>
                        @endif
                    </div>
                    <div class="product-info">
                        <h3 class="product-title">{{ Str::limit($product->name, 40) }}</h3>
                        <div class="product-price">
                            @if($product->discount_price)
                                <span class="price-original">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="price-sale">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            @else
                                <span class="price-current">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <a href="{{ route('products.show', $product->slug) }}" class="product-link">View Details →</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- Newsletter Section --}}
    <div class="newsletter-section">
        <div class="container">
            <div class="newsletter-content">
                <h2 class="newsletter-title">Join Our Fashion Community</h2>
                <p class="newsletter-desc">Subscribe to get exclusive offers, style tips, and 10% off your first order</p>
                <form class="newsletter-form" id="newsletterForm">
                    <input type="email" placeholder="Enter your email address" required>
                    <button type="submit">Subscribe →</button>
                </form>
                <p class="newsletter-note">No spam. Unsubscribe anytime.</p>
            </div>
        </div>
    </div>
</div>

<style>
/* Reset & Base */
.fashion-store {
    font-family: 'Poppins', 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    overflow-x: hidden;
}

/* ========== PREMIUM CUSTOM CAROUSEL ========== */
.custom-carousel {
    position: relative;
    height: 90vh;
    min-height: 650px;
    width: 100%;
    overflow: hidden;
    background-color: #000;
}

.carousel-inner-custom {
    position: relative;
    width: 100%;
    height: 100%;
}

.carousel-item-custom {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1), visibility 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 1;
}

.carousel-item-custom.active {
    opacity: 1;
    visibility: visible;
    z-index: 2;
}

.carousel-bg-custom {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    transform: scale(1.08);
    transition: transform 8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.carousel-item-custom.active .carousel-bg-custom {
    transform: scale(1);
}

.carousel-overlay-custom {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.2) 100%);
}

.carousel-container-custom {
    position: relative;
    height: 100%;
    display: flex;
    align-items: center;
    z-index: 3;
}

.carousel-content-custom {
    max-width: 650px;
    color: #fff;
    opacity: 0;
    transform: translateY(30px);
    transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94), opacity 0.8s ease;
}

.carousel-item-custom.active .carousel-content-custom {
    opacity: 1;
    transform: translateY(0);
    transition-delay: 0.2s;
}

.carousel-subtitle-custom {
    display: inline-block;
    font-size: 0.85rem;
    letter-spacing: 3px;
    text-transform: uppercase;
    color: #fff;
    background: rgba(212, 165, 165, 0.35);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    padding: 0.5rem 1.25rem;
    border-radius: 50px;
    margin-bottom: 1.5rem;
    font-weight: 500;
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.carousel-title-custom {
    font-size: 4rem;
    font-weight: 300;
    line-height: 1.15;
    color: #fff;
    margin-bottom: 1.5rem;
    text-shadow: 2px 2px 8px rgba(0,0,0,0.15);
}

.carousel-desc-custom {
    font-size: 1.2rem;
    color: #fff;
    opacity: 0.95;
    margin-bottom: 2.5rem;
    font-weight: 300;
}

/* Hero Search Bar Styles */
.hero-search-form {
    max-width: 500px;
    margin-bottom: 2rem;
}

.hero-search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.25);
    border-radius: 50px;
    padding: 6px;
    transition: all 0.3s ease;
    box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.1);
}

.hero-search-wrapper:focus-within {
    background: rgba(255, 255, 255, 0.95);
    border-color: #d4a5a5;
    box-shadow: 0 10px 30px rgba(212, 165, 165, 0.3);
}

.hero-search-icon {
    position: absolute;
    left: 1.25rem;
    color: #fff;
    width: 20px;
    height: 20px;
    pointer-events: none;
    transition: color 0.3s ease;
}

.hero-search-wrapper:focus-within .hero-search-icon {
    color: #d4a5a5;
}

.hero-search-input {
    width: 100%;
    background: transparent;
    border: none;
    outline: none;
    padding: 0.75rem 1rem 0.75rem 3rem;
    color: #fff;
    font-size: 0.95rem;
    font-family: inherit;
}

.hero-search-wrapper:focus-within .hero-search-input {
    color: #1a1a1a;
}

.hero-search-input::placeholder {
    color: rgba(255, 255, 255, 0.8);
    transition: color 0.3s ease;
}

.hero-search-wrapper:focus-within .hero-search-input::placeholder {
    color: #999;
}

.hero-search-btn {
    background: #fff;
    color: #1a1a1a;
    border: none;
    border-radius: 50px;
    padding: 0.75rem 1.75rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
    font-size: 0.9rem;
}

.hero-search-wrapper:focus-within .hero-search-btn {
    background: #1a1a1a;
    color: #fff;
}

.hero-search-btn:hover {
    transform: scale(1.02);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.hero-btn {
    display: inline-block;
    padding: 1rem 2.5rem;
    background: #fff;
    color: #1a1a1a;
    text-decoration: none;
    font-weight: 500;
    border-radius: 50px;
    transition: all 0.3s ease;
    letter-spacing: 1px;
}

.hero-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    color: #d4a5a5;
}

/* Controls style */
.carousel-ctrl-prev,
.carousel-ctrl-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    color: #fff;
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 10;
    transition: all 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.carousel-ctrl-prev { left: 30px; }
.carousel-ctrl-next { right: 30px; }

.carousel-ctrl-prev:hover,
.carousel-ctrl-next:hover {
    background: #fff;
    color: #1a1a1a;
    transform: translateY(-50%) scale(1.08);
}

/* Indicators dots style */
.carousel-dots-custom {
    position: absolute;
    bottom: 30px;
    left: 50%;
    transform: translateX(-50%);
    display: flex;
    gap: 10px;
    z-index: 10;
}

.carousel-dot-custom {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.4);
    border: none;
    cursor: pointer;
    transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.carousel-dot-custom.active {
    background: #fff;
    width: 30px;
    border-radius: 10px;
}

@media (max-width: 992px) {
    .carousel-title-custom {
        font-size: 3rem;
    }
    .custom-carousel {
        height: 70vh;
        min-height: 500px;
    }
}

@media (max-width: 768px) {
    .custom-carousel {
        height: 80vh;
        min-height: 480px;
    }
    .carousel-content-custom {
        text-align: center;
        padding: 0 15px;
    }
    .carousel-title-custom {
        font-size: 2.2rem;
    }
    .carousel-desc-custom {
        font-size: 1rem;
        margin-bottom: 2rem;
    }
    .carousel-ctrl-prev,
    .carousel-ctrl-next {
        display: none;
    }
}

/* Promo Products Banner - Carousel Slider */
.promo-products-banner {
    padding: 80px 0;
    background: linear-gradient(135deg, #fff5f5 0%, #ffe8e8 100%);
    position: relative;
    overflow: hidden;
}

.promo-banner-header {
    text-align: center;
    margin-bottom: 40px;
}

.promo-banner-tag {
    display: inline-block;
    background: #d4a5a5;
    color: white;
    padding: 0.3rem 1.5rem;
    border-radius: 50px;
    font-size: 0.8rem;
    letter-spacing: 2px;
    margin-bottom: 1rem;
}

.promo-banner-title {
    font-size: 2.2rem;
    font-weight: 600;
    color: #1a1a1a;
    margin-bottom: 0.5rem;
}

.promo-banner-desc {
    color: #666;
    font-size: 0.95rem;
}

/* Slider Styles */
.promo-slider-container {
    position: relative;
    max-width: 1200px;
    margin: 0 auto;
    overflow: hidden;
    padding: 0 40px;
}

.promo-slider {
    overflow: hidden;
    border-radius: 20px;
}

.promo-slider-wrapper {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

.promo-slide {
    flex: 0 0 33.333%;
    padding: 0 15px;
    box-sizing: border-box;
    cursor: pointer;
}

.promo-slide-inner {
    background: white;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.promo-slide-inner:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.promo-slide-image {
    position: relative;
    height: 280px;
    overflow: hidden;
}

.promo-slide-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
}

.promo-slide-inner:hover .promo-slide-image img {
    transform: scale(1.08);
}

.promo-slide-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    height: 50%;
    background: linear-gradient(to top, rgba(0,0,0,0.4), transparent);
}

.promo-slide-discount {
    position: absolute;
    top: 15px;
    right: 15px;
    background: #ff4444;
    color: white;
    padding: 5px 12px;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 2;
}

.promo-slide-info {
    padding: 20px;
    text-align: center;
}

.promo-slide-title {
    font-size: 1rem;
    font-weight: 500;
    margin-bottom: 8px;
    color: #1a1a1a;
}

.promo-slide-price {
    margin-bottom: 15px;
}

.promo-slide-original {
    font-size: 0.75rem;
    color: #999;
    text-decoration: line-through;
    margin-right: 8px;
}

.promo-slide-sale {
    font-size: 1.1rem;
    font-weight: 700;
    color: #d4a5a5;
}

.promo-slide-buttons {
    display: flex;
    gap: 10px;
    justify-content: center;
}

.promo-slide-buy {
    padding: 8px 20px;
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    color: white;
    border: none;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.promo-slide-buy:hover {
    background: linear-gradient(135deg, #d4a5a5 0%, #b5838d 100%);
    transform: scale(1.02);
}

.promo-slide-detail {
    padding: 8px 20px;
    background: #f0f0f0;
    color: #333;
    border: none;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.promo-slide-detail:hover {
    background: #d4a5a5;
    color: white;
}

/* Slider Navigation Buttons */
.promo-slider-prev,
.promo-slider-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 40px;
    height: 40px;
    background: white;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    z-index: 10;
}

.promo-slider-prev {
    left: 0;
}

.promo-slider-next {
    right: 0;
}

.promo-slider-prev:hover,
.promo-slider-next:hover {
    background: #d4a5a5;
    color: white;
    transform: translateY(-50%) scale(1.1);
}

/* Slider Dots */
.promo-slider-dots {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 30px;
}

.promo-slider-dot {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #ccc;
    cursor: pointer;
    transition: all 0.3s ease;
}

.promo-slider-dot.active {
    width: 25px;
    border-radius: 10px;
    background: #d4a5a5;
}

/* Section Styles */
.section-container {
    padding: 80px 0;
}

.section-header {
    text-align: center;
    margin-bottom: 60px;
}

.section-tag {
    display: inline-block;
    font-size: 0.8rem;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #d4a5a5;
    margin-bottom: 1rem;
}

.section-title {
    font-size: 2.8rem;
    font-weight: 300;
    margin-bottom: 1rem;
    color: #1a1a1a;
}

.section-divider {
    width: 60px;
    height: 2px;
    background: linear-gradient(90deg, #d4a5a5, #b5838d);
    margin: 1.5rem auto;
}

.section-subtitle {
    color: #666;
    font-size: 1rem;
}

/* Category Grid */
.category-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
    margin-top: 40px;
}

.category-card {
    text-decoration: none;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
}

.category-card-inner {
    background: #fff;
    padding: 40px 20px;
    text-align: center;
    border-radius: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
    transition: all 0.3s ease;
    border: 1px solid rgba(0,0,0,0.05);
}

.category-card:hover .category-card-inner {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    border-color: #d4a5a5;
}

.category-icon i {
    font-size: 3rem;
    color: #d4a5a5;
    transition: all 0.3s ease;
}

.category-card:hover .category-icon i {
    transform: scale(1.1);
    color: #b5838d;
}

.category-name {
    font-size: 1.1rem;
    font-weight: 500;
    margin: 1rem 0;
    color: #1a1a1a;
}

.category-shop {
    font-size: 0.8rem;
    color: #d4a5a5;
    opacity: 0;
    transform: translateY(10px);
    transition: all 0.3s ease;
}

.category-card:hover .category-shop {
    opacity: 1;
    transform: translateY(0);
}

/* Promo Banner */
.promo-banner {
    position: relative;
    background: url('https://images.unsplash.com/photo-1445205170230-053b83016050?w=1600') center/cover fixed;
    height: 400px;
    display: flex;
    align-items: center;
    text-align: center;
}

.promo-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, rgba(0,0,0,0.7), rgba(0,0,0,0.5));
}

.promo-content {
    position: relative;
    z-index: 2;
    color: #fff;
}

.promo-badge {
    display: inline-block;
    background: #d4a5a5;
    padding: 0.5rem 1.5rem;
    border-radius: 50px;
    font-size: 0.8rem;
    letter-spacing: 2px;
    margin-bottom: 1.5rem;
}

.promo-title {
    font-size: 3.5rem;
    font-weight: 300;
    margin-bottom: 1rem;
}

.promo-desc {
    font-size: 1rem;
    opacity: 0.9;
    margin-bottom: 2rem;
}

.promo-btn {
    display: inline-block;
    padding: 1rem 2.5rem;
    background: #fff;
    color: #1a1a1a;
    text-decoration: none;
    border-radius: 50px;
    transition: all 0.3s ease;
    font-weight: 500;
}

.promo-btn:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    background: #d4a5a5;
    color: #fff;
}

/* Countdown Timer */
.countdown-timer {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

.timer-item {
    text-align: center;
    background: #fff;
    padding: 15px 20px;
    border-radius: 15px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    min-width: 80px;
}

.timer-number {
    display: block;
    font-size: 2rem;
    font-weight: 600;
    color: #d4a5a5;
    line-height: 1;
}

.timer-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #666;
    margin-top: 5px;
}

.timer-sep {
    font-size: 2rem;
    font-weight: 600;
    color: #d4a5a5;
    align-self: center;
}

/* Product Grid */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
    gap: 40px;
    margin-top: 20px;
}

.product-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    cursor: pointer;
}

.product-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12);
}

.product-image-wrapper {
    position: relative;
    overflow: hidden;
    aspect-ratio: 3/4;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.6s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-actions {
    position: absolute;
    top: 15px;
    right: 15px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    opacity: 0;
    transform: translateX(20px);
    transition: all 0.3s ease;
}

.product-card:hover .product-actions {
    opacity: 1;
    transform: translateX(0);
}

.action-btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: #fff;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.action-btn:hover {
    background: #d4a5a5;
    color: #fff;
    transform: scale(1.1);
}

.product-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    padding: 0.3rem 1rem;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 600;
    letter-spacing: 1px;
}

.product-badge.promo {
    background: #ff4444;
    color: #fff;
}

.product-badge.new {
    background: #1a1a1a;
    color: #fff;
}

.product-info {
    padding: 1.5rem;
    text-align: center;
}

.product-title {
    font-size: 0.95rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: #1a1a1a;
    line-height: 1.4;
}

.product-price {
    margin: 0.5rem 0;
}

.price-original {
    font-size: 0.8rem;
    color: #999;
    text-decoration: line-through;
    margin-right: 8px;
}

.price-sale, .price-current {
    font-size: 1rem;
    font-weight: 600;
    color: #d4a5a5;
}

.product-link {
    display: inline-block;
    margin-top: 0.5rem;
    font-size: 0.8rem;
    color: #1a1a1a;
    text-decoration: none;
    border-bottom: 1px solid #d4a5a5;
    transition: all 0.3s ease;
}

.product-link:hover {
    color: #d4a5a5;
    letter-spacing: 1px;
}

/* Featured Banner */
.featured-banner {
    background: #f9f6f5;
    padding: 60px 0;
    margin: 40px 0;
}

.featured-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 30px;
    text-align: center;
}

.featured-item i {
    font-size: 2.5rem;
    color: #d4a5a5;
    margin-bottom: 1rem;
}

.featured-item h4 {
    font-size: 1rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.featured-item p {
    font-size: 0.8rem;
    color: #666;
}

/* Newsletter Section */
.newsletter-section {
    background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
    padding: 80px 0;
    text-align: center;
}

.newsletter-content {
    max-width: 600px;
    margin: 0 auto;
}

.newsletter-title {
    font-size: 2rem;
    font-weight: 300;
    color: #fff;
    margin-bottom: 1rem;
}

.newsletter-desc {
    color: rgba(255,255,255,0.7);
    margin-bottom: 2rem;
}

.newsletter-form {
    display: flex;
    gap: 10px;
    margin-bottom: 1rem;
}

.newsletter-form input {
    flex: 1;
    padding: 1rem;
    border: none;
    border-radius: 50px;
    font-size: 1rem;
    outline: none;
}

.newsletter-form button {
    padding: 1rem 2rem;
    background: #d4a5a5;
    color: #fff;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s ease;
    font-weight: 500;
}

.newsletter-form button:hover {
    background: #b5838d;
    transform: translateY(-2px);
}

.newsletter-note {
    font-size: 0.7rem;
    color: rgba(255,255,255,0.5);
}

.bg-light-pink {
    background: #fef6f5;
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 1024px) {
    .promo-slide {
        flex: 0 0 50%;
    }
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2rem;
    }
    
    .section-title {
        font-size: 1.8rem;
    }
    
    .category-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .product-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
    }
    
    .countdown-timer {
        gap: 10px;
    }
    
    .timer-item {
        padding: 10px 15px;
        min-width: 60px;
    }
    
    .timer-number {
        font-size: 1.2rem;
    }
    
    .newsletter-form {
        flex-direction: column;
    }
    
    .featured-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .promo-products-banner {
        padding: 60px 0;
    }
    
    .promo-banner-title {
        font-size: 1.5rem;
    }
    
    .promo-slider-container {
        padding: 0 20px;
    }
    
    .promo-slide {
        flex: 0 0 100%;
    }
    
    .promo-slide-image {
        height: 220px;
    }
}

/* ========== RECOMMENDATION SECTION ========== */
.reco-section {
    background: linear-gradient(180deg, #fef8f6 0%, #fff5f2 40%, #fef0ec 100%);
    position: relative;
    overflow: hidden;
}

.reco-section::before {
    content: '';
    position: absolute;
    top: -100px;
    right: -100px;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(212, 165, 165, 0.1) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}

.reco-section::after {
    content: '';
    position: absolute;
    bottom: -80px;
    left: -80px;
    width: 250px;
    height: 250px;
    background: radial-gradient(circle, rgba(181, 131, 141, 0.08) 0%, transparent 70%);
    border-radius: 50%;
    pointer-events: none;
}

.reco-tag {
    background: linear-gradient(135deg, #d4a5a5 0%, #b5838d 100%);
    color: #fff !important;
    padding: 0.4rem 1.25rem;
    border-radius: 50px;
    font-size: 0.75rem;
    letter-spacing: 1.5px;
}

.reco-tag i {
    margin-right: 4px;
}

.reco-divider {
    background: linear-gradient(90deg, #d4a5a5, #e8b4b8, #d4a5a5) !important;
    width: 80px !important;
    animation: shimmerDivider 3s ease-in-out infinite;
}

@keyframes shimmerDivider {
    0%, 100% { opacity: 0.7; width: 60px; }
    50% { opacity: 1; width: 80px; }
}

.reco-badge {
    background: linear-gradient(135deg, #d4a5a5 0%, #b5838d 100%) !important;
    color: #fff !important;
    font-size: 0.65rem !important;
    letter-spacing: 0.5px;
}

.reco-badge i {
    font-size: 0.55rem;
    margin-right: 3px;
}

.reco-card {
    border: 1px solid rgba(212, 165, 165, 0.12);
}

.reco-card:hover {
    border-color: rgba(212, 165, 165, 0.3);
}

/* Wishlist Toggle Button Active State */
.wishlist-toggle-btn .fa-heart.fas {
    color: #d4a5a5;
}

.wishlist-toggle-btn:hover {
    background: #fce4ec !important;
}

.wishlist-toggle-btn.is-wishlisted {
    background: #fce4ec;
}

.wishlist-toggle-btn.is-wishlisted .fa-heart {
    color: #d4a5a5;
}
</style>

<script>
(function() {
    // ========== PROMO SLIDER CAROUSEL ==========
    const sliderWrapper = document.getElementById('promoSliderWrapper');
    const slides = document.querySelectorAll('.promo-slide');
    const prevBtn = document.getElementById('promoSliderPrev');
    const nextBtn = document.getElementById('promoSliderNext');
    const dotsContainer = document.getElementById('promoSliderDots');
    
    let currentIndex = 0;
    let slidesPerView = 3;
    let totalSlides = slides.length;
    let autoPlayInterval;
    
    // Update slidesPerView based on screen width
    function updateSlidesPerView() {
        if (window.innerWidth <= 768) {
            slidesPerView = 1;
        } else if (window.innerWidth <= 1024) {
            slidesPerView = 2;
        } else {
            slidesPerView = 3;
        }
        updateSlider();
        createDots();
    }
    
    // Update slider position
    function updateSlider() {
        const slideWidth = slides[0]?.offsetWidth || 0;
        const offset = -currentIndex * slideWidth;
        if (sliderWrapper) {
            sliderWrapper.style.transform = `translateX(${offset}px)`;
        }
        updateDots();
    }
    
    // Create dots indicator
    function createDots() {
        if (!dotsContainer) return;
        const totalDots = Math.ceil(totalSlides / slidesPerView);
        dotsContainer.innerHTML = '';
        for (let i = 0; i < totalDots; i++) {
            const dot = document.createElement('div');
            dot.classList.add('promo-slider-dot');
            if (i === Math.floor(currentIndex / slidesPerView)) {
                dot.classList.add('active');
            }
            dot.addEventListener('click', () => {
                currentIndex = i * slidesPerView;
                if (currentIndex > totalSlides - slidesPerView) {
                    currentIndex = totalSlides - slidesPerView;
                }
                if (currentIndex < 0) currentIndex = 0;
                updateSlider();
                resetAutoPlay();
            });
            dotsContainer.appendChild(dot);
        }
    }
    
    // Update dots active state
    function updateDots() {
        const dots = document.querySelectorAll('.promo-slider-dot');
        const activeDotIndex = Math.floor(currentIndex / slidesPerView);
        dots.forEach((dot, idx) => {
            if (idx === activeDotIndex) {
                dot.classList.add('active');
            } else {
                dot.classList.remove('active');
            }
        });
    }
    
    // Next slide
    function nextSlide() {
        if (currentIndex + slidesPerView < totalSlides) {
            currentIndex += slidesPerView;
        } else {
            currentIndex = 0;
        }
        updateSlider();
        resetAutoPlay();
    }
    
    // Previous slide
    function prevSlide() {
        if (currentIndex - slidesPerView >= 0) {
            currentIndex -= slidesPerView;
        } else {
            currentIndex = totalSlides - slidesPerView;
            if (currentIndex < 0) currentIndex = 0;
        }
        updateSlider();
        resetAutoPlay();
    }
    
    // Auto play
    function startAutoPlay() {
        autoPlayInterval = setInterval(() => {
            nextSlide();
        }, 5000);
    }
    
    function resetAutoPlay() {
        if (autoPlayInterval) {
            clearInterval(autoPlayInterval);
        }
        startAutoPlay();
    }
    
    // Event listeners
    if (prevBtn) prevBtn.addEventListener('click', prevSlide);
    if (nextBtn) nextBtn.addEventListener('click', nextSlide);
    
    // Update on window resize
    let resizeTimeout;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(() => {
            updateSlidesPerView();
        }, 200);
    });
    
    // Initialize
    updateSlidesPerView();
    startAutoPlay();
    
    // Pause auto play on hover
    const sliderContainer = document.querySelector('.promo-slider-container');
    if (sliderContainer) {
        sliderContainer.addEventListener('mouseenter', () => {
            if (autoPlayInterval) clearInterval(autoPlayInterval);
        });
        sliderContainer.addEventListener('mouseleave', () => {
            startAutoPlay();
        });
    }
    
    // ========== HANDLE CLICK ON SLIDE ==========
    document.querySelectorAll('.promo-slide').forEach(slide => {
        slide.addEventListener('click', (e) => {
            // Don't trigger if clicking on buttons
            if (e.target.closest('.promo-slide-buy') || e.target.closest('.promo-slide-detail')) {
                return;
            }
            const productSlug = slide.dataset.productSlug;
            if (productSlug) {
                window.location.href = `/products/${productSlug}`;
            }
        });
    });
    
    // ========== BUY BUTTON HANDLER ==========
    document.querySelectorAll('.promo-slide-buy').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const productId = btn.dataset.productId;
            const productSlug = btn.dataset.productSlug;
            
            // Check if user is logged in
            fetch('/check-auth')
                .then(res => res.json())
                .then(data => {
                    if (data.logged_in) {
                        window.location.href = `/checkout/direct/${productId}`;
                    } else {
                        showLoginModal(productSlug, productId);
                    }
                })
                .catch(() => {
                    showLoginModal(productSlug, productId);
                });
        });
    });
    
    // ========== DETAIL BUTTON HANDLER ==========
    document.querySelectorAll('.promo-slide-detail').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const productSlug = btn.dataset.productSlug;
            if (productSlug) {
                window.location.href = `/products/${productSlug}`;
            }
        });
    });
    
    // ========== SHOW LOGIN MODAL ==========
    function showLoginModal(productSlug, productId) {
        // Remove existing modal
        const existingModal = document.getElementById('loginRequiredModal');
        if (existingModal) existingModal.remove();
        
        const modal = document.createElement('div');
        modal.id = 'loginRequiredModal';
        modal.className = 'login-required-modal';
        modal.innerHTML = `
            <div class="login-modal-overlay"></div>
            <div class="login-modal-content">
                <button class="login-modal-close">&times;</button>
                <div class="login-modal-icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Login Required</h3>
                <p>Please login or register to continue with your purchase</p>
                <div class="login-modal-buttons">
                    <a href="{{ route('login') }}" class="login-modal-btn login-btn">Login</a>
                    <a href="{{ route('register') }}" class="login-modal-btn register-btn">Register</a>
                </div>
                <p class="login-modal-note">You'll be redirected back after login</p>
            </div>
        `;
        document.body.appendChild(modal);
        
        // Store redirect URL
        localStorage.setItem('redirect_after_login', `/checkout/direct/${productId}`);
        
        // Animate in
        setTimeout(() => {
            modal.style.opacity = '1';
            modal.querySelector('.login-modal-content').style.transform = 'scale(1)';
        }, 10);
        
        // Close modal
        const closeBtn = modal.querySelector('.login-modal-close');
        const overlay = modal.querySelector('.login-modal-overlay');
        const closeModal = () => {
            modal.style.opacity = '0';
            modal.querySelector('.login-modal-content').style.transform = 'scale(0.9)';
            setTimeout(() => modal.remove(), 300);
        };
        closeBtn.addEventListener('click', closeModal);
        overlay.addEventListener('click', closeModal);
    }
    
    // ========== COUNTDOWN TIMER ==========
    function startCountdown() {
        const targetTime = new Date().getTime() + (24 * 60 * 60 * 1000);
        
        function updateTimer() {
            const now = new Date().getTime();
            const distance = targetTime - now;
            
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            const homeHours = document.getElementById('homeHours');
            const homeMinutes = document.getElementById('homeMinutes');
            const homeSeconds = document.getElementById('homeSeconds');
            
            if (homeHours) homeHours.textContent = String(hours).padStart(2, '0');
            if (homeMinutes) homeMinutes.textContent = String(minutes).padStart(2, '0');
            if (homeSeconds) homeSeconds.textContent = String(seconds).padStart(2, '0');
            
            if (distance < 0) {
                clearInterval(timerInterval);
                if (homeHours) homeHours.textContent = '00';
                if (homeMinutes) homeMinutes.textContent = '00';
                if (homeSeconds) homeSeconds.textContent = '00';
            }
        }
        
        updateTimer();
        const timerInterval = setInterval(updateTimer, 1000);
    }
    
    if (document.getElementById('homepageCountdownTimer') || document.getElementById('countdownTimer')) {
        startCountdown();
    }
    
    // ========== QUICK VIEW ==========
    const quickViewBtns = document.querySelectorAll('.quick-view');
    quickViewBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const productSlug = btn.getAttribute('data-product');
            
            const modal = document.createElement('div');
            modal.className = 'custom-modal';
            modal.innerHTML = `
                <div class="custom-modal-content">
                    <span class="custom-modal-close">&times;</span>
                    <div class="modal-body">
                        <i class="fas fa-spinner fa-spin"></i>
                        <p>Loading product details...</p>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
            
            setTimeout(() => {
                modal.style.opacity = '1';
                modal.querySelector('.custom-modal-content').style.transform = 'scale(1)';
            }, 10);
            
            const closeBtn = modal.querySelector('.custom-modal-close');
            closeBtn.onclick = () => {
                modal.style.opacity = '0';
                modal.querySelector('.custom-modal-content').style.transform = 'scale(0.9)';
                setTimeout(() => modal.remove(), 300);
            };
            
            modal.onclick = (e) => {
                if (e.target === modal) {
                    closeBtn.click();
                }
            };
            
            setTimeout(() => {
                modal.querySelector('.modal-body').innerHTML = `
                    <h3>Quick View</h3>
                    <p>Product details will appear here. <br>Click "View Details" for complete information.</p>
                    <a href="/products/${productSlug}" class="modal-view-btn">View Full Details →</a>
                `;
            }, 800);
        });
    });
    
    // ========== WISHLIST TOGGLE (AJAX) ==========
    document.querySelectorAll('.wishlist-toggle-btn').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const productId = btn.dataset.productId;
            if (!productId) return;

            // Check if user is logged in first
            fetch('/check-auth')
                .then(res => res.json())
                .then(data => {
                    if (!data.logged_in) {
                        showLoginModal(null, productId);
                        return;
                    }

                    // Toggle wishlist via AJAX
                    fetch(`/wishlist/toggle/${productId}`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(result => {
                        const icon = btn.querySelector('i');
                        if (result.status === 'added') {
                            icon.classList.remove('far');
                            icon.classList.add('fas');
                            btn.classList.add('is-wishlisted');
                        } else {
                            icon.classList.remove('fas');
                            icon.classList.add('far');
                            btn.classList.remove('is-wishlisted');
                        }

                        // Animate button
                        btn.style.transform = 'scale(1.3)';
                        setTimeout(() => { btn.style.transform = 'scale(1)'; }, 250);

                        // Show toast
                        const toast = document.createElement('div');
                        toast.className = 'custom-toast';
                        toast.innerHTML = result.status === 'added'
                            ? '❤️ Ditambahkan ke Wishlist!'
                            : '💔 Dihapus dari Wishlist';
                        document.body.appendChild(toast);
                        setTimeout(() => {
                            toast.style.opacity = '0';
                            setTimeout(() => toast.remove(), 300);
                        }, 2000);

                        // Update wishlist count badge in navbar if exists
                        const wishCountEl = document.querySelector('.wishlist-count');
                        if (wishCountEl && result.count !== undefined) {
                            wishCountEl.textContent = result.count;
                        }
                    })
                    .catch(err => {
                        console.error('Wishlist toggle error:', err);
                    });
                })
                .catch(() => {
                    showLoginModal(null, productId);
                });
        });
    });
    
    // ========== INTERSECTION OBSERVER ==========
    const fadeElements = document.querySelectorAll('.product-card, .category-card, .featured-item, .promo-slide');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 100);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });
    
    fadeElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
    
    // ========== NEWSLETTER ==========
    const newsletterForm = document.getElementById('newsletterForm');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', (e) => {
            e.preventDefault();
            const email = newsletterForm.querySelector('input[type="email"]').value;
            
            const submitBtn = newsletterForm.querySelector('button');
            const originalText = submitBtn.textContent;
            submitBtn.textContent = 'Subscribing...';
            submitBtn.disabled = true;
            
            setTimeout(() => {
                submitBtn.textContent = 'Subscribed! ✓';
                setTimeout(() => {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                    newsletterForm.reset();
                }, 2000);
            }, 1000);
        });
    }
    
    // ========== PARALLAX ==========
    window.addEventListener('scroll', () => {
        const activeBg = document.querySelector('.carousel-item-custom.active .carousel-bg-custom');
        if (activeBg && window.scrollY < window.innerHeight) {
            const scrolled = window.scrollY;
            activeBg.style.transform = `scale(1) translateY(${scrolled * 0.1}px)`;
        }
    });

    // Initialize custom carousel
    initCustomCarousel('customBannerCarousel');
    
    // Reusable Custom Carousel Implementation
    function initCustomCarousel(carouselId) {
        const carousel = document.getElementById(carouselId);
        if (!carousel) return;

        const items = carousel.querySelectorAll('.carousel-item-custom');
        const dots = carousel.querySelectorAll('.carousel-dot-custom');
        const prevBtn = carousel.querySelector('.carousel-ctrl-prev');
        const nextBtn = carousel.querySelector('.carousel-ctrl-next');
        
        if (items.length <= 1) return;
        
        let currentIndex = 0;
        let slideInterval;
        const intervalTime = 5000; // 5 seconds

        function showSlide(index) {
            items[currentIndex].classList.remove('active');
            if (dots[currentIndex]) dots[currentIndex].classList.remove('active');

            currentIndex = (index + items.length) % items.length;

            items[currentIndex].classList.add('active');
            if (dots[currentIndex]) dots[currentIndex].classList.add('active');
        }

        function nextSlide() {
            showSlide(currentIndex + 1);
        }

        function prevSlide() {
            showSlide(currentIndex - 1);
        }

        function startAutoSlide() {
            clearInterval(slideInterval);
            slideInterval = setInterval(nextSlide, intervalTime);
        }

        function stopAutoSlide() {
            clearInterval(slideInterval);
        }

        if (prevBtn) {
            prevBtn.addEventListener('click', () => {
                prevSlide();
                startAutoSlide();
            });
        }

        if (nextBtn) {
            nextBtn.addEventListener('click', () => {
                nextSlide();
                startAutoSlide();
            });
        }

        dots.forEach((dot, idx) => {
            dot.addEventListener('click', () => {
                showSlide(idx);
                startAutoSlide();
            });
        });

        // Touch Support (Swipe)
        let startX = 0;
        let endX = 0;
        const threshold = 50;

        carousel.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            stopAutoSlide();
        }, { passive: true });

        carousel.addEventListener('touchmove', (e) => {
            endX = e.touches[0].clientX;
        }, { passive: true });

        carousel.addEventListener('touchend', () => {
            const diffX = startX - endX;
            if (Math.abs(diffX) > threshold) {
                if (diffX > 0) {
                    nextSlide();
                } else {
                    prevSlide();
                }
            }
            startAutoSlide();
        });

        // Pause on Hover
        carousel.addEventListener('mouseenter', stopAutoSlide);
        carousel.addEventListener('mouseleave', startAutoSlide);

        startAutoSlide();
    }
    
    // ========== ADD MODAL STYLES ==========
    const modalStyle = document.createElement('style');
    modalStyle.textContent = `
        .custom-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(10px);
            z-index: 10001;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .custom-modal-content {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            width: 90%;
            position: relative;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }
        
        .custom-modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 2rem;
            cursor: pointer;
            color: #999;
        }
        
        .custom-modal-close:hover {
            color: #000;
        }
        
        .modal-body {
            text-align: center;
        }
        
        .modal-view-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #1a1a1a;
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
        }
        
        .modal-view-btn:hover {
            background: #d4a5a5;
        }
        
        .custom-toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            background: #1a1a1a;
            color: #fff;
            padding: 12px 24px;
            border-radius: 50px;
            font-size: 0.9rem;
            z-index: 10000;
            animation: slideUp 0.3s ease;
            white-space: nowrap;
        }
        
        .login-required-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 10002;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .login-modal-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            backdrop-filter: blur(5px);
        }
        
        .login-modal-content {
            position: relative;
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 400px;
            width: 90%;
            text-align: center;
            transform: scale(0.9);
            transition: transform 0.3s ease;
            z-index: 2;
        }
        
        .login-modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 1.5rem;
            background: none;
            border: none;
            cursor: pointer;
            color: #999;
        }
        
        .login-modal-icon i {
            font-size: 3rem;
            color: #d4a5a5;
            margin-bottom: 1rem;
        }
        
        .login-modal-content h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
        }
        
        .login-modal-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-bottom: 1rem;
        }
        
        .login-modal-btn {
            padding: 10px 25px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
        }
        
        .login-btn {
            background: #1a1a1a;
            color: white;
        }
        
        .login-btn:hover {
            background: #d4a5a5;
        }
        
        .register-btn {
            background: #f0f0f0;
            color: #1a1a1a;
        }
        
        .register-btn:hover {
            background: #d4a5a5;
            color: white;
        }
        
        .login-modal-note {
            font-size: 0.7rem;
            color: #999;
        }
        
        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateX(-50%) translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateX(-50%) translateY(0);
            }
        }
    `;
    document.head.appendChild(modalStyle);
})();
</script>
@endsection