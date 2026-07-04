@extends('layouts.landing')

@section('title', 'Welcome to Aciaa - Modern & Elegant Women\'s Fashion')

@section('content')
<div class="landing-page">
    
    {{-- Hero Carousel Section - Premium & Bold --}}
    <div class="custom-carousel" id="customBannerCarousel">
        <div class="carousel-inner-custom">
            @if($banners->count() > 0)
                @foreach($banners as $key => $banner)
                <div class="carousel-item-custom {{ $key == 0 ? 'active' : '' }}">
                    <div class="carousel-bg-custom" style="background-image: url('{{ url('render-image?path=' . $banner->image) }}');"></div>
                    <div class="carousel-overlay-custom"></div>
                    <div class="container carousel-container-custom">
                        <div class="carousel-content-custom">
                            <span class="carousel-subtitle-custom">{{ $banner->subtitle ?? 'Premium Women\'s Fashion' }}</span>
                            <h1 class="carousel-title-custom">{!! nl2br(e($banner->title ?? "Define Your Elegance,\nEmbrace Your Style")) !!}</h1>
                            <p class="carousel-desc-custom">{{ $banner->description ?? 'Curated contemporary boutique apparel for the modern, confident woman.' }}</p>
                            
                            <div class="carousel-actions-custom">
                                <a href="{{ $banner->link ?? route('home') }}" class="btn-primary-custom">Explore Shop <i class="fas fa-shopping-bag ms-2"></i></a>
                                <a href="{{ route('vouchers.index') }}" class="btn-secondary-custom">View Promos <i class="fas fa-arrow-right ms-2"></i></a>
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
                            <span class="carousel-subtitle-custom">Premium Women's Fashion</span>
                            <h1 class="carousel-title-custom">Define Your Elegance,<br>Embrace Your Style</h1>
                            <p class="carousel-desc-custom">Curated contemporary boutique apparel for the modern, confident woman.</p>
                            
                            <div class="carousel-actions-custom">
                                <a href="{{ route('home') }}" class="btn-primary-custom">Explore Shop <i class="fas fa-shopping-bag ms-2"></i></a>
                                <a href="{{ route('vouchers.index') }}" class="btn-secondary-custom">View Promos <i class="fas fa-arrow-right ms-2"></i></a>
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

    {{-- Brand Manifesto Section --}}
    <div class="brand-manifesto">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-5 mb-5 mb-lg-0">
                    <div class="manifesto-image-wrapper">
                        <img src="{{ asset('images/manifesto.jpg') }}" onerror="this.src='{{ url('render-image?path=default.jpg') }}'" alt="Elegant Style" class="img-fluid manifesto-single-img">
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1">
                    <div class="manifesto-text-wrapper">
                        <span class="manifesto-tag">Our Philosophy</span>
                        <h2 class="manifesto-title">Designed for the contemporary woman</h2>
                        <div class="manifesto-divider"></div>
                        <p class="manifesto-desc">At Aciaa, we believe that fashion is a silent language of self-expression. Our pieces are thoughtfully crafted to combine timeless sophistication with everyday versatility, ensuring you feel confident, empowered, and effortlessly chic.</p>
                        <p class="manifesto-desc-sub">Discover garments that celebrate clean lines, premium tailoring, and contemporary silhouettes designed to complement your lifestyle.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Shop by Category Section --}}
    <div class="landing-categories">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-tag">Curated Collections</span>
                <h2 class="section-title">Shop by Category</h2>
                <div class="section-divider-center"></div>
                <p class="section-subtitle">Find the perfect pieces for every chapter of your day</p>
            </div>
            
            <div class="category-minimal-grid">
                @forelse($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="category-minimal-card">
                    <span class="cat-num">{{ sprintf('%02d', $loop->iteration) }}</span>
                    <span class="cat-name">{{ $category->name }}</span>
                    <span class="cat-count">({{ $category->products_count ?? 0 }} items)</span>
                    <span class="cat-arrow">→</span>
                </a>
                @empty
                <div class="text-center w-100 py-4">
                    <p class="text-muted">No categories available at the moment.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Featured Products Section --}}
    <div class="featured-products">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-tag">Must Have Pieces</span>
                <h2 class="section-title">Featured Collection</h2>
                <div class="section-divider-center"></div>
                <p class="section-subtitle">Koleksi terlaris kami yang dikurasi khusus untuk menyempurnakan gaya harian Anda.</p>
            </div>
            
            <div class="products-grid mt-5">
                @forelse($featuredProducts as $product)
                <div class="landing-product-card">
                    <div class="product-img-wrapper">
                        <img src="{{ url('render-image?path=' . ($product->image ?? 'default.jpg')) }}" alt="{{ $product->name }}" class="product-img">
                        <div class="product-hover-overlay">
                            <a href="{{ route('products.show', $product->slug) }}" class="btn-product-detail">View Details</a>
                        </div>
                        @if($product->discount_price)
                            <span class="product-discount-badge">-{{ round((1 - $product->discount_price/$product->price) * 100) }}%</span>
                        @endif
                    </div>
                    <div class="product-meta">
                        <span class="product-category-name">{{ $product->category->name ?? 'Collection' }}</span>
                        <h3 class="product-name-link"><a href="{{ route('products.show', $product->slug) }}">{{ Str::limit($product->name, 40) }}</a></h3>
                        <div class="product-price-box">
                            @if($product->discount_price)
                                <span class="price-old">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="price-new">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            @else
                                <span class="price-current">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center w-100 py-4">
                    <p class="text-muted">No products available at the moment.</p>
                </div>
                @endforelse
            </div>
            
            <div class="text-center mt-5">
                <a href="{{ route('home') }}" class="btn-primary-custom">Explore Full Shop <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>

    {{-- Testimonials Section --}}
    <div class="landing-testimonials">
        <div class="container">
            <div class="section-header text-center mb-5">
                <span class="section-tag text-center">Client Voices</span>
                <i class="fas fa-quote-left quote-large-icon my-2 d-block mx-auto"></i>
            </div>
            
            <div id="testimonialCarousel" class="carousel slide testimonial-single-wrapper text-center mx-auto" data-bs-ride="carousel" data-bs-interval="4000">
                <div class="carousel-inner">
                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <blockquote class="testimonial-quote">
                            "Bahan pakaian dari Aciaa benar-benar premium, jahitan yang sangat rapi, serta potongan yang modern. Pakaiannya sangat menunjang penampilan profesional saya sehari-hari."
                        </blockquote>
                        <div class="testimonial-author-info mt-4">
                            <span class="author-name">— Gev</span>
                            <span class="author-title">Creative Director & Customer</span>
                        </div>
                    </div>
                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <blockquote class="testimonial-quote">
                            "Saya sangat menyukai desain minimalis dan elegan dari setiap koleksi. Sangat nyaman dipakai seharian tanpa membuat gerah. Definitely my go-to store!"
                        </blockquote>
                        <div class="testimonial-author-info mt-4">
                            <span class="author-name">— Sarah M.</span>
                            <span class="author-title">Entrepreneur</span>
                        </div>
                    </div>
                    <!-- Slide 3 -->
                    <div class="carousel-item">
                        <blockquote class="testimonial-quote">
                            "Pelayanan yang cepat dan packaging yang mewah. Setiap membuka paket dari Aciaa selalu memberikan pengalaman yang menyenangkan. Kualitas tak pernah mengecewakan."
                        </blockquote>
                        <div class="testimonial-author-info mt-4">
                            <span class="author-name">— Dian P.</span>
                            <span class="author-title">Fashion Enthusiast</span>
                        </div>
                    </div>
                </div>
                
                <!-- Controls for Carousel -->
                <button class="carousel-control-prev d-none d-md-flex" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev" style="width: 50px; left: -50px;">
                    <i class="fas fa-chevron-left text-dark fs-4"></i>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next d-none d-md-flex" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next" style="width: 50px; right: -50px;">
                    <i class="fas fa-chevron-right text-dark fs-4"></i>
                    <span class="visually-hidden">Next</span>
                </button>
                
                <!-- Indicators for Carousel -->
                <div class="carousel-indicators" style="position: static; margin-top: 2rem;">
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active bg-dark" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1" class="bg-dark" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="2" class="bg-dark" aria-label="Slide 3"></button>
                </div>
            </div>
        </div>
    </div>

    {{-- Editorial / Lookbook Grid --}}
    <div class="editorial-lookbook">
        <div class="container">
            <div class="section-header text-center mb-5">
                <span class="section-tag">The Editorial</span>
                <h2 class="section-title">Chic Styles, Beautiful Fits</h2>
                <div class="section-divider-center"></div>
            </div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="lookbook-banner-card">
                        <img src="{{ asset('images/lookbook1.jpg') }}" onerror="this.src='{{ url('render-image?path=default.jpg') }}'" alt="Lookbook 1" class="lookbook-img">
                        <div class="lookbook-overlay"></div>
                        <div class="lookbook-content">
                            <span class="lookbook-tag">Minimalist Silhouette</span>
                            <h3 class="lookbook-title">Urban Chic Essentials</h3>
                            <a href="{{ route('home') }}" class="lookbook-link">Shop The Look</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="lookbook-banner-card">
                        <img src="{{ asset('images/lookbook2.jpg') }}" onerror="this.src='{{ url('render-image?path=default.jpg') }}'" alt="Lookbook 2" class="lookbook-img">
                        <div class="lookbook-overlay"></div>
                        <div class="lookbook-content">
                            <span class="lookbook-tag">Urban Essentials</span>
                            <h3 class="lookbook-title">Effortless Sophistication</h3>
                            <a href="{{ route('home') }}" class="lookbook-link">Shop The Look</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Value Props Bar --}}
    <div class="landing-value-props">
        <div class="container">
            <div class="value-props-line-grid">
                <div class="value-prop-item">
                    <span class="prop-icon"><i class="fas fa-truck"></i></span>
                    <span class="prop-text">Free Shipping Over Rp 500.000</span>
                </div>
                <div class="value-prop-item">
                    <span class="prop-icon"><i class="fas fa-rotate"></i></span>
                    <span class="prop-text">30-Days Return & Exchange</span>
                </div>
                <div class="value-prop-item">
                    <span class="prop-icon"><i class="fas fa-shield-halved"></i></span>
                    <span class="prop-text">100% Secure Checkout</span>
                </div>
                <div class="value-prop-item">
                    <span class="prop-icon"><i class="fas fa-award"></i></span>
                    <span class="prop-text">Premium Quality Fabric</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Newsletter Subscription Section --}}
    <div class="landing-newsletter">
        <div class="container">
            <div class="newsletter-minimal-wrapper text-center">
                <span class="newsletter-tag">Stay Connected</span>
                <h2 class="newsletter-title">Subscribe to the Aciaa Club</h2>
                <p class="newsletter-desc">Be the first to hear about new collection drops, private sales, and receive 10% off your first purchase.</p>
                
                <form class="newsletter-form-minimal" id="landingNewsletterForm">
                    <div class="newsletter-input-group-minimal">
                        <input type="email" placeholder="Enter your email address" required class="newsletter-input-minimal">
                        <button type="submit" class="newsletter-btn-minimal">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
/* CSS Styles for the Landing Page */
.landing-page {
    font-family: 'Poppins', 'Inter', sans-serif;
    color: #1a1a1a;
    background-color: #fff;
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
    background-position: center 20%;
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

.carousel-actions-custom {
    display: flex;
    gap: 1.25rem;
}

.btn-primary-custom {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 1rem 2.25rem;
    min-height: 44px;
    background: linear-gradient(135deg, #d4a5a5 0%, #b5838d 100%);
    color: white !important;
    text-decoration: none;
    font-weight: 500;
    border-radius: 50px;
    box-shadow: 0 10px 25px rgba(212, 165, 165, 0.4);
    transition: all 0.3s ease;
    border: none;
}

.btn-primary-custom:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 30px rgba(212, 165, 165, 0.6);
    background: linear-gradient(135deg, #b5838d 0%, #9c6673 100%);
}

.btn-secondary-custom {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 1rem 2.25rem;
    min-height: 44px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    color: white !important;
    text-decoration: none;
    font-weight: 500;
    border-radius: 50px;
    border: 1px solid rgba(255, 255, 255, 0.35);
    transition: all 0.3s ease;
}

.btn-secondary-custom:hover {
    background: white;
    color: #1a1a1a !important;
    transform: translateY(-3px);
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
    .carousel-actions-custom {
        justify-content: center;
        flex-direction: column;
        gap: 0.75rem;
    }
    .carousel-ctrl-prev,
    .carousel-ctrl-next {
        display: none;
    }
}

@media (max-width: 480px) {
    .carousel-title-custom {
        font-size: 1.8rem;
    }
    .carousel-desc-custom {
        font-size: 0.95rem;
        margin-bottom: 1.5rem;
    }
    .btn-primary-custom, .btn-secondary-custom {
        font-size: 14px;
        padding: 0.75rem 1.5rem;
        width: 100%;
        min-height: 44px;
    }
    .manifesto-title {
        font-size: 2rem;
    }
    .section-title {
        font-size: 1.8rem;
    }
    .testimonial-quote {
        font-size: 1.25rem;
    }
}

/* Brand Manifesto */
.brand-manifesto {
    padding: 80px 0;
    background-color: #fef6f5;
}
.manifesto-image-wrapper {
    max-width: 100%;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(212, 165, 165, 0.1);
}
.manifesto-single-img {
    width: 100%;
    height: auto;
    object-fit: cover;
}
.manifesto-text-wrapper {
    max-width: 500px;
}
.manifesto-tag {
    font-size: 0.8rem;
    letter-spacing: 2px;
    font-weight: 600;
    color: #d4a5a5;
    text-transform: uppercase;
    display: inline-block;
    margin-bottom: 0.5rem;
}
.manifesto-title {
    font-size: 2.6rem;
    font-weight: 300;
    color: #1a1a1a;
    line-height: 1.25;
}
.manifesto-divider {
    width: 50px;
    height: 2px;
    background: #d4a5a5;
    margin: 1.5rem 0;
}
.manifesto-desc {
    color: #555;
    font-size: 1.05rem;
    line-height: 1.7;
    margin-bottom: 1.25rem;
}
.manifesto-desc-sub {
    color: #888;
    font-size: 0.95rem;
    line-height: 1.6;
}

/* Curated Categories Minimal */
.landing-categories {
    padding: 80px 0;
    background: #fff;
}
.category-minimal-grid {
    margin-top: 50px;
    display: flex;
    flex-direction: column;
}
.category-minimal-card {
    display: flex;
    align-items: center;
    padding: 24px 0;
    border-bottom: 1px solid rgba(212, 165, 165, 0.25);
    text-decoration: none;
    color: #1a1a1a;
    transition: all 0.3s ease;
}
.category-minimal-card:first-child {
    border-top: 1px solid rgba(212, 165, 165, 0.25);
}
.cat-num {
    font-size: 0.9rem;
    font-weight: 500;
    color: #d4a5a5;
    width: 60px;
}
.cat-name {
    font-size: 1.4rem;
    font-weight: 400;
    flex-grow: 1;
    transition: transform 0.3s ease, color 0.3s ease;
}
.cat-count {
    font-size: 0.9rem;
    color: #888;
    margin-right: 40px;
}
.cat-arrow {
    font-size: 1.2rem;
    color: #ccc;
    transition: transform 0.3s ease, color 0.3s ease;
}
.category-minimal-card:hover .cat-name {
    color: #d4a5a5;
    transform: translateX(10px);
}
.category-minimal-card:hover .cat-arrow {
    color: #d4a5a5;
    transform: translateX(5px);
}

/* Featured Products */
.featured-products {
    padding: 80px 0;
    background-color: #fff;
}
.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 30px;
}
.landing-product-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    border: 1px solid rgba(212, 165, 165, 0.12);
}
.landing-product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(212, 165, 165, 0.1);
    border-color: rgba(212, 165, 165, 0.3);
}
.product-img-wrapper {
    position: relative;
    padding-top: 130%; /* 4:5 aspect ratio */
    overflow: hidden;
    background-color: #fcf9f9;
}
.product-img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.landing-product-card:hover .product-img {
    transform: scale(1.06);
}
.product-hover-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: all 0.4s ease;
}
.landing-product-card:hover .product-hover-overlay {
    opacity: 1;
}
.btn-product-detail {
    padding: 0.75rem 1.75rem;
    background: #fff;
    color: #1a1a1a;
    text-decoration: none;
    font-size: 0.88rem;
    font-weight: 600;
    border-radius: 50px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    transform: translateY(15px);
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.landing-product-card:hover .btn-product-detail {
    transform: translateY(0);
}
.btn-product-detail:hover {
    background: #d4a5a5;
    color: #fff;
}
.product-discount-badge {
    position: absolute;
    top: 15px;
    left: 15px;
    background: #e74c3c;
    color: #fff;
    padding: 0.35rem 0.85rem;
    font-size: 0.75rem;
    font-weight: 700;
    border-radius: 50px;
    box-shadow: 0 4px 10px rgba(231, 76, 60, 0.2);
}
.product-meta {
    padding: 20px;
}
.product-category-name {
    display: block;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    color: #d4a5a5;
    margin-bottom: 8px;
    letter-spacing: 1px;
}
.product-name-link {
    font-size: 1.05rem;
    font-weight: 500;
    line-height: 1.4;
    margin-bottom: 12px;
}
.product-name-link a {
    color: #1a1a1a;
    text-decoration: none;
    transition: color 0.2s ease;
}
.product-name-link a:hover {
    color: #d4a5a5;
}
.product-price-box {
    display: flex;
    align-items: center;
    gap: 10px;
}
.price-old {
    font-size: 0.9rem;
    text-decoration: line-through;
    color: #aaa;
}
.price-new {
    font-size: 1.1rem;
    font-weight: 700;
    color: #e74c3c;
}
.price-current {
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a1a;
}

/* Testimonials Single Quote */
.landing-testimonials {
    padding: 80px 0;
    background-color: #fef6f5;
}
.testimonial-single-wrapper {
    max-width: 800px;
    margin: 0 auto;
}
.quote-large-icon {
    font-size: 3rem;
    color: #d4a5a5;
    opacity: 0.6;
}
.testimonial-quote {
    font-size: 1.8rem;
    font-weight: 300;
    line-height: 1.6;
    color: #1a1a1a;
    font-style: italic;
}
.testimonial-author-info {
    display: flex;
    flex-direction: column;
    gap: 4px;
}
.author-name {
    font-size: 1.1rem;
    font-weight: 600;
    color: #1a1a1a;
}
.author-title {
    font-size: 0.85rem;
    color: #777;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Editorial Lookbook Dual Column */
.editorial-lookbook {
    padding: 80px 0;
    background: #fff;
}
.lookbook-banner-card {
    position: relative;
    height: 500px;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0,0,0,0.03);
}
.lookbook-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}
.lookbook-banner-card:hover .lookbook-img {
    transform: scale(1.05);
}
.lookbook-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.1) 60%, transparent 100%);
    z-index: 1;
}
.lookbook-content {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 40px;
    z-index: 2;
}
.lookbook-tag {
    font-size: 0.75rem;
    letter-spacing: 2px;
    color: #d4a5a5;
    font-weight: 600;
    text-transform: uppercase;
    display: inline-block;
    margin-bottom: 0.5rem;
}
.lookbook-title {
    font-size: 2rem;
    color: #fff;
    font-weight: 300;
    margin-bottom: 1rem;
    line-height: 1.2;
}
.lookbook-link {
    color: #fff;
    text-decoration: none;
    font-size: 0.95rem;
    font-weight: 500;
    border-bottom: 1px solid rgba(255,255,255,0.4);
    padding-bottom: 2px;
    transition: all 0.3s ease;
}
.lookbook-link:hover {
    color: #d4a5a5;
    border-color: #d4a5a5;
}

/* Value Props Simple Row */
.landing-value-props {
    padding: 60px 0;
    background-color: #fef6f5;
    border-top: 1px solid rgba(212, 165, 165, 0.15);
    border-bottom: 1px solid rgba(212, 165, 165, 0.15);
}
.value-props-line-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
}
.value-prop-item {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 12px;
}
.prop-icon {
    font-size: 1.2rem;
    color: #d4a5a5;
}
.prop-text {
    font-size: 0.9rem;
    font-weight: 500;
    color: #4a4a4a;
}

/* Newsletter Subscription Minimal */
.landing-newsletter {
    padding: 100px 0;
    background: #fff;
}
.newsletter-minimal-wrapper {
    max-width: 600px;
    margin: 0 auto;
}
.newsletter-tag {
    font-size: 0.8rem;
    letter-spacing: 3px;
    color: #d4a5a5;
    font-weight: 600;
    display: inline-block;
    margin-bottom: 0.75rem;
    text-transform: uppercase;
}
.newsletter-title {
    font-size: 2.5rem;
    font-weight: 300;
    margin-bottom: 1rem;
    color: #1a1a1a;
}
.newsletter-desc {
    color: #666;
    font-size: 1rem;
    line-height: 1.6;
    margin-bottom: 2.5rem;
}
.newsletter-form-minimal {
    max-width: 500px;
    margin: 0 auto;
}
.newsletter-input-group-minimal {
    display: flex;
    border-bottom: 2px solid #1a1a1a;
    padding-bottom: 6px;
}
.newsletter-input-minimal {
    flex-grow: 1;
    border: none;
    outline: none;
    font-size: 1rem;
    padding: 0.5rem 1rem;
    background: transparent;
}
.newsletter-btn-minimal {
    background: transparent;
    border: none;
    font-size: 1rem;
    font-weight: 600;
    color: #1a1a1a;
    cursor: pointer;
    transition: color 0.3s ease;
    padding: 0 1rem;
}
.newsletter-btn-minimal:hover {
    color: #d4a5a5;
}

/* ========== RESPONSIVE DESIGN ========== */
@media (max-width: 992px) {
    .testimonial-quote {
        font-size: 1.5rem;
    }
    .newsletter-title {
        font-size: 2.0rem;
    }
}

@media (max-width: 768px) {
    .brand-manifesto,
    .landing-categories,
    .editorial-lookbook,
    .landing-newsletter,
    .featured-products,
    .landing-testimonials {
        padding: 60px 0;
    }
    
    .manifesto-title {
        font-size: 2rem;
    }
    
    .cat-name {
        font-size: 1.15rem;
    }
    
    .cat-count {
        margin-right: 15px;
    }
    
    .lookbook-banner-card {
        height: 380px;
    }
    
    .testimonial-quote {
        font-size: 1.25rem;
    }
    
    .value-props-line-grid {
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elegant toast or popup for newsletter subscription
    const newsletterForm = document.getElementById('landingNewsletterForm');
    if (newsletterForm) {
        newsletterForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const emailInput = this.querySelector('.newsletter-input-minimal');
            const userEmail = emailInput.value;
            
            // Simulative success action
            alert('Terima kasih! Email ' + userEmail + ' telah terdaftar. Diskon 10% Anda akan dikirimkan lewat email.');
            emailInput.value = '';
        });
    }

    // Initialize custom carousel
    initCustomCarousel('customBannerCarousel');
});

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
</script>
@endsection
