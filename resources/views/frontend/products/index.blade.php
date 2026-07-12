@extends('layouts.app')

@section('title', 'Daftar Produk - Elegant Fashion Store')

@section('content')
<div class="products-page">
    <div class="container my-5">
        <!-- Breadcrumb -->
        <nav class="breadcrumb-nav mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Products</li>
            </ol>
        </nav>

        <!-- Bootstrap 5 Offcanvas Filter (Mobile) + Main Layout -->
        <div x-data="productFilter()">
        <!-- Bootstrap 5 Offcanvas Filter (Mobile) -->
        <div class="offcanvas offcanvas-start" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
            <div class="offcanvas-header" style="border-bottom: 1px solid #eee;">
                <h5 class="offcanvas-title" id="filterOffcanvasLabel" style="font-weight: 600; color: #1a1a1a;">
                    <i data-lucide="sliders-horizontal" style="width:18px;height:18px;margin-right:8px;vertical-align:middle;"></i>
                    Filters
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Tutup filter"></button>
            </div>
            <div class="offcanvas-body" style="padding: 1.25rem;">
                <div class="filter-sidebar" style="box-shadow:none; padding:0; border-radius:0; position:static;">
                    <div class="filter-header" style="margin-bottom:1rem;">
                        <button class="filter-reset" id="resetFiltersOffcanvasBtn">
                            <i data-lucide="rotate-ccw"></i>
                            <span>Reset All</span>
                        </button>
                    </div>

                    <!-- Filter Kategori -->
                    <div class="filter-section">
                        <h4 class="filter-section-title">
                            <i data-lucide="grid"></i>
                            Categories
                        </h4>
                        <div class="category-list">
                            <a href="{{ route('products.index') }}" 
                               class="category-link {{ !request('category') ? 'active' : '' }}"
                               :class="{ 'active': category === '', 'filter-disabled': loading }"
                               :aria-disabled="loading"
                               :tabindex="loading ? -1 : 0"
                               @click.prevent="if (!loading) { category = ''; $dispatch('close-offcanvas') }">
                                <span>All Products</span>
                                <span class="category-count">{{ $allProductsCount ?? 0 }}</span>
                            </a>
                            @foreach($categories as $category)
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                               class="category-link {{ request('category') == $category->slug ? 'active' : '' }}"
                               :class="{ 'active': category === '{{ $category->slug }}', 'filter-disabled': loading }"
                               :aria-disabled="loading"
                               :tabindex="loading ? -1 : 0"
                               @click.prevent="if (!loading) { category = '{{ $category->slug }}'; $dispatch('close-offcanvas') }">
                                <span>{{ $category->name }}</span>
                                <span class="category-count">{{ $category->products_count ?? 0 }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter Harga dengan Slider -->
                    <div class="filter-section">
                        <h4 class="filter-section-title">
                            <i data-lucide="dollar-sign"></i>
                            Price Range
                        </h4>
                        <form method="GET" action="{{ route('products.index') }}" id="priceFilterFormOffcanvas" @submit.prevent="applyPriceFilter()">
                            @foreach(request()->except(['min_price', 'max_price', 'page']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            
                            <div class="price-range-container">
                                <div class="price-inputs">
                                    <div class="price-input-group">
                                        <label>Min</label>
                                        <input type="number" name="min_price" id="minPriceOffcanvas" class="price-input" placeholder="0" value="{{ request('min_price') }}" x-model="minPrice" :disabled="loading">
                                    </div>
                                    <span class="price-separator">—</span>
                                    <div class="price-input-group">
                                        <label>Max</label>
                                        <input type="number" name="max_price" id="maxPriceOffcanvas" class="price-input" placeholder="1.000.000" value="{{ request('max_price') }}" x-model="maxPrice" :disabled="loading">
                                    </div>
                                </div>
                                <div class="price-slider-container">
                                    <div class="price-track"></div>
                                    <div class="price-range" :style="`left: ${(parseInt(minPrice || 0) / 1000000) * 100}%; width: ${((parseInt(maxPrice || 1000000) - parseInt(minPrice || 0)) / 1000000) * 100}%;`"></div>
                                    <input type="range" id="minSliderOffcanvas" min="0" max="1000000" step="10000" x-model="minPrice" :disabled="loading">
                                    <input type="range" id="maxSliderOffcanvas" min="0" max="1000000" step="10000" x-model="maxPrice" :disabled="loading">
                                </div>
                            </div>
                            <button type="submit" class="filter-apply-btn" :disabled="loading" :class="{ 'filter-btn-loading': loading }">
                                <span x-show="!loading">Apply Filter</span>
                                <span x-show="loading" style="display:none;">
                                    <svg class="filter-spinner" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-dasharray="31.4 31.4" style="transform-origin:center;animation:filter-spin 0.8s linear infinite;"/>
                                    </svg>
                                    Loading...
                                </span>
                            </button>
                        </form>
                    </div>

                    <!-- Sorting -->
                    <div class="filter-section">
                        <h4 class="filter-section-title">
                            <i data-lucide="arrow-up-down"></i>
                            Sort By
                        </h4>
                        <div class="sorting-options">
                            <a href="{{ route('products.index', array_merge(request()->except('sort', 'page'), ['sort' => 'terbaru'])) }}" 
                               class="sort-option {{ request('sort') == 'terbaru' || !request('sort') ? 'active' : '' }}"
                               :class="{ 'active': sort === 'terbaru' || sort === '', 'filter-disabled': loading }"
                               :aria-disabled="loading"
                               :tabindex="loading ? -1 : 0"
                               @click.prevent="if (!loading) { sort = 'terbaru'; $dispatch('close-offcanvas') }">
                                <i data-lucide="zap"></i>
                                <span>Newest</span>
                            </a>
                            <a href="{{ route('products.index', array_merge(request()->except('sort', 'page'), ['sort' => 'termurah'])) }}" 
                               class="sort-option {{ request('sort') == 'termurah' ? 'active' : '' }}"
                               :class="{ 'active': sort === 'termurah', 'filter-disabled': loading }"
                               :aria-disabled="loading"
                               :tabindex="loading ? -1 : 0"
                               @click.prevent="if (!loading) { sort = 'termurah'; $dispatch('close-offcanvas') }">
                                <i data-lucide="arrow-up"></i>
                                <span>Price: Low to High</span>
                            </a>
                            <a href="{{ route('products.index', array_merge(request()->except('sort', 'page'), ['sort' => 'termahal'])) }}" 
                               class="sort-option {{ request('sort') == 'termahal' ? 'active' : '' }}"
                               :class="{ 'active': sort === 'termahal', 'filter-disabled': loading }"
                               :aria-disabled="loading"
                               :tabindex="loading ? -1 : 0"
                               @click.prevent="if (!loading) { sort = 'termahal'; $dispatch('close-offcanvas') }">
                                <i data-lucide="arrow-down"></i>
                                <span>Price: High to Low</span>
                            </a>
                        </div>
                    </div>

                    <!-- Active Filters -->
                    @if(request('category') || request('min_price') || request('max_price') || request('sort'))
                    <div class="filter-section active-filters">
                        <h4 class="filter-section-title">
                            <i data-lucide="filter"></i>
                            Active Filters
                        </h4>
                        <div class="active-filters-list">
                            @if(request('category'))
                                <span class="filter-tag">
                                    Category: {{ \App\Models\Category::where('slug', request('category'))->first()->name ?? request('category') }}
                                    <a href="{{ route('products.index', array_merge(request()->except('category', 'page'))) }}" class="remove-filter">×</a>
                                </span>
                            @endif
                            @if(request('min_price') || request('max_price'))
                                <span class="filter-tag">
                                    Price: {{ request('min_price') ? 'Rp ' . number_format(request('min_price'), 0, ',', '.') : '0' }} - {{ request('max_price') ? 'Rp ' . number_format(request('max_price'), 0, ',', '.') : '∞' }}
                                    <a href="{{ route('products.index', array_merge(request()->except(['min_price', 'max_price', 'page']))) }}" class="remove-filter">×</a>
                                </span>
                            @endif
                            @if(request('sort'))
                                <span class="filter-tag">
                                    Sort: {{ request('sort') == 'terbaru' ? 'Newest' : (request('sort') == 'termurah' ? 'Price: Low to High' : 'Price: High to Low') }}
                                    <a href="{{ route('products.index', array_merge(request()->except('sort', 'page'))) }}" class="remove-filter">×</a>
                                </span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- /Offcanvas Filter -->

        <div class="row g-4">
            <!-- Sidebar Filter - Modern & Elegant (hidden on mobile) -->
            <div class="col-lg-3 d-none d-lg-block">
                <div class="filter-sidebar">
                    <div class="filter-header">
                        <h3 class="filter-title">Filters</h3>
                        <button class="filter-reset" id="resetFiltersBtn">
                            <i data-lucide="rotate-ccw"></i>
                            <span>Reset All</span>
                        </button>
                    </div>

                    <!-- Filter Kategori -->
                    <div class="filter-section">
                        <h4 class="filter-section-title">
                            <i data-lucide="grid"></i>
                            Categories
                        </h4>
                        <div class="category-list">
                            <a href="{{ route('products.index') }}" 
                               class="category-link {{ !request('category') ? 'active' : '' }}"
                               :class="{ 'active': category === '', 'filter-disabled': loading }"
                               :aria-disabled="loading"
                               :tabindex="loading ? -1 : 0"
                               @click.prevent="if (!loading) category = ''">
                                <span>All Products</span>
                                <span class="category-count">{{ $allProductsCount ?? 0 }}</span>
                            </a>
                            @foreach($categories as $category)
                            <a href="{{ route('products.index', ['category' => $category->slug]) }}" 
                               class="category-link {{ request('category') == $category->slug ? 'active' : '' }}"
                               :class="{ 'active': category === '{{ $category->slug }}', 'filter-disabled': loading }"
                               :aria-disabled="loading"
                               :tabindex="loading ? -1 : 0"
                               @click.prevent="if (!loading) category = '{{ $category->slug }}'">
                                <span>{{ $category->name }}</span>
                                <span class="category-count">{{ $category->products_count ?? 0 }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Filter Harga dengan Slider -->
                    <div class="filter-section">
                        <h4 class="filter-section-title">
                            <i data-lucide="dollar-sign"></i>
                            Price Range
                        </h4>
                        <form method="GET" action="{{ route('products.index') }}" id="priceFilterForm" @submit.prevent="applyPriceFilter()">
                            @foreach(request()->except(['min_price', 'max_price', 'page']) as $key => $value)
                                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                            @endforeach
                            
                            <div class="price-range-container">
                                <div class="price-inputs">
                                    <div class="price-input-group">
                                        <label>Min</label>
                                        <input type="number" name="min_price" id="minPrice" class="price-input" placeholder="0" value="{{ request('min_price') }}" x-model="minPrice" :disabled="loading">
                                    </div>
                                    <span class="price-separator">—</span>
                                    <div class="price-input-group">
                                        <label>Max</label>
                                        <input type="number" name="max_price" id="maxPrice" class="price-input" placeholder="1.000.000" value="{{ request('max_price') }}" x-model="maxPrice" :disabled="loading">
                                    </div>
                                </div>
                                <div class="price-slider-container">
                                    <div class="price-track"></div>
                                    <div class="price-range" :style="`left: ${(parseInt(minPrice || 0) / 1000000) * 100}%; width: ${((parseInt(maxPrice || 1000000) - parseInt(minPrice || 0)) / 1000000) * 100}%;`"></div>
                                    <input type="range" id="minSlider" min="0" max="1000000" step="10000" x-model="minPrice" :disabled="loading">
                                    <input type="range" id="maxSlider" min="0" max="1000000" step="10000" x-model="maxPrice" :disabled="loading">
                                </div>
                            </div>
                            <button type="submit" class="filter-apply-btn" :disabled="loading" :class="{ 'filter-btn-loading': loading }">
                                <span x-show="!loading">Apply Filter</span>
                                <span x-show="loading" style="display:none;">
                                    <svg class="filter-spinner" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-dasharray="31.4 31.4" style="transform-origin:center;animation:filter-spin 0.8s linear infinite;"/>
                                    </svg>
                                    Loading...
                                </span>
                            </button>
                        </form>
                    </div>

                    <!-- Sorting -->
                    <div class="filter-section">
                        <h4 class="filter-section-title">
                            <i data-lucide="arrow-up-down"></i>
                            Sort By
                        </h4>
                        <div class="sorting-options">
                            <a href="{{ route('products.index', array_merge(request()->except('sort', 'page'), ['sort' => 'terbaru'])) }}" 
                               class="sort-option {{ request('sort') == 'terbaru' || !request('sort') ? 'active' : '' }}"
                               :class="{ 'active': sort === 'terbaru' || sort === '', 'filter-disabled': loading }"
                               :aria-disabled="loading"
                               :tabindex="loading ? -1 : 0"
                               @click.prevent="if (!loading) sort = 'terbaru'">
                                <i data-lucide="zap"></i>
                                <span>Newest</span>
                            </a>
                            <a href="{{ route('products.index', array_merge(request()->except('sort', 'page'), ['sort' => 'termurah'])) }}" 
                               class="sort-option {{ request('sort') == 'termurah' ? 'active' : '' }}"
                               :class="{ 'active': sort === 'termurah', 'filter-disabled': loading }"
                               :aria-disabled="loading"
                               :tabindex="loading ? -1 : 0"
                               @click.prevent="if (!loading) sort = 'termurah'">
                                <i data-lucide="arrow-up"></i>
                                <span>Price: Low to High</span>
                            </a>
                            <a href="{{ route('products.index', array_merge(request()->except('sort', 'page'), ['sort' => 'termahal'])) }}" 
                               class="sort-option {{ request('sort') == 'termahal' ? 'active' : '' }}"
                               :class="{ 'active': sort === 'termahal', 'filter-disabled': loading }"
                               :aria-disabled="loading"
                               :tabindex="loading ? -1 : 0"
                               @click.prevent="if (!loading) sort = 'termahal'">
                                <i data-lucide="arrow-down"></i>
                                <span>Price: High to Low</span>
                            </a>
                        </div>
                    </div>

                    <!-- Active Filters -->
                    @if(request('category') || request('min_price') || request('max_price') || request('sort'))
                    <div class="filter-section active-filters">
                        <h4 class="filter-section-title">
                            <i data-lucide="filter"></i>
                            Active Filters
                        </h4>
                        <div class="active-filters-list">
                            @if(request('category'))
                                <span class="filter-tag">
                                    Category: {{ \App\Models\Category::where('slug', request('category'))->first()->name ?? request('category') }}
                                    <a href="{{ route('products.index', array_merge(request()->except('category', 'page'))) }}" class="remove-filter">×</a>
                                </span>
                            @endif
                            @if(request('min_price') || request('max_price'))
                                <span class="filter-tag">
                                    Price: {{ request('min_price') ? 'Rp ' . number_format(request('min_price'), 0, ',', '.') : '0' }} - {{ request('max_price') ? 'Rp ' . number_format(request('max_price'), 0, ',', '.') : '∞' }}
                                    <a href="{{ route('products.index', array_merge(request()->except(['min_price', 'max_price', 'page']))) }}" class="remove-filter">×</a>
                                </span>
                            @endif
                            @if(request('sort'))
                                <span class="filter-tag">
                                    Sort: {{ request('sort') == 'terbaru' ? 'Newest' : (request('sort') == 'termurah' ? 'Price: Low to High' : 'Price: High to Low') }}
                                    <a href="{{ route('products.index', array_merge(request()->except('sort', 'page'))) }}" class="remove-filter">×</a>
                                </span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Product Grid -->
            <div class="col-lg-9">
                <!-- Products Header -->
                <div class="products-header">
                    <!-- Mobile Filter Toggle Button -->
                    <button class="btn btn-filter-mobile d-block d-lg-none"
                            type="button"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#filterOffcanvas"
                            aria-controls="filterOffcanvas"
                            aria-label="Buka filter produk">
                        <i data-lucide="sliders-horizontal"></i>
                        <span>Filter</span>
                        @if(request('category') || request('min_price') || request('max_price') || request('sort'))
                            <span class="filter-active-dot"></span>
                        @endif
                    </button>

                    <div class="products-count">
                        <i data-lucide="shopping-bag"></i>
                        <span id="productCount">{{ $products->total() }} Products</span>
                    </div>

                    <!-- Search bar dipindah ke global navbar -->

                    <div class="products-view-toggle">
                        <button class="view-btn active" data-view="grid">
                            <i data-lucide="grid"></i>
                        </button>
                        <button class="view-btn" data-view="list">
                            <i data-lucide="list"></i>
                        </button>
                    </div>
                </div>

                <!-- All Products -->
                <div class="all-products-section">
                    <div class="section-header">
                        <h2 class="section-title">All Products</h2>
                        <div class="section-divider"></div>
                    </div>
                    
                    {{-- Skeleton loader: tampil saat AJAX loading --}}
                    <div x-show="loading" x-cloak>
                        <x-skeleton-loader :count="8" />
                    </div>

                    {{-- Product grid: tampil saat tidak loading --}}
                    <div x-show="!loading">
                    <div class="product-grid" id="productGrid">
                        @forelse($products as $product)                        <div class="product-card" data-product-id="{{ $product->id }}">
                            <div class="product-image-wrapper">
                                <img src="{{ url('render-image?path=' . ($product->image ?? 'default.jpg')) }}" alt="{{ $product->name }}" class="product-image">
                                <div class="product-actions">
                                    <button class="action-btn quick-view" data-product="{{ $product->slug }}">
                                        <i data-lucide="eye"></i>
                                    </button>
                                    <button class="action-btn wishlist"
                                        x-data="wishlistToggle({{ $product->isInWishlist() ? 'true' : 'false' }})"
                                        :class="{ 'active': inWishlist }"
                                        @click.prevent="toggle({{ $product->id }})"
                                        :disabled="isProcessing"
                                        type="button">
                                        <i :class="inWishlist ? 'fas fa-heart' : 'far fa-heart'"></i>
                                    </button>
                                </div>
                                @if($product->discount_price)
                                <div class="product-badges">
                                    <span class="badge sale-badge">Sale</span>
                                </div>
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
                        @empty
                        <div class="empty-state">
                            <i data-lucide="package-x"></i>
                            <h3>No Products Found</h3>
                            <p>Try adjusting your filters or check back later for new arrivals.</p>
                            <a href="{{ route('products.index') }}" class="empty-state-btn">Clear Filters</a>
                        </div>
                        @endforelse
                    </div>{{-- end product-grid --}}
                    </div>{{-- end x-show="!loading" --}}
 
                    <!-- Pagination — always rendered so AJAX can update it -->
                    <div class="pagination-wrapper" id="paginationArea" @if(!$products->hasPages()) style="display:none;" @endif>
                        @if($products->hasPages())
                            {{ $products->withQueryString()->links() }}
                        @endif
                    </div>

                <!-- Promo Products Section -->
                @if(isset($promoProducts) && $promoProducts->count() > 0)
                <div class="promo-section mb-5" x-transition>
                    <div class="promo-section-header">
                        <div class="promo-badge">
                            <i data-lucide="flame"></i>
                            <span>Flash Sale</span>
                        </div>
                        <h2 class="promo-section-title">Hot Deals</h2>
                        @if(isset($flashSaleEnd) && \Carbon\Carbon::parse($flashSaleEnd)->isFuture())
                        <div class="promo-timer" id="promoTimer" data-end="{{ \Carbon\Carbon::parse($flashSaleEnd)->toIso8601String() }}">
                            <div class="timer-block">
                                <span class="timer-value" id="promoHours">00</span>
                                <span class="timer-label">Hours</span>
                            </div>
                            <span class="timer-colon">:</span>
                            <div class="timer-block">
                                <span class="timer-value" id="promoMinutes">00</span>
                                <span class="timer-label">Mins</span>
                            </div>
                            <span class="timer-colon">:</span>
                            <div class="timer-block">
                                <span class="timer-value" id="promoSeconds">00</span>
                                <span class="timer-label">Secs</span>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="product-grid" id="promoProductGrid">
                        @foreach($promoProducts as $product)
                        <div class="product-card promo-card" data-product-id="{{ $product->id }}">
                            <div class="product-image-wrapper">
                                <img src="{{ url('render-image?path=' . ($product->image ?? 'default.jpg')) }}" alt="{{ $product->name }}" class="product-image">
                                <div class="product-actions">
                                    <button class="action-btn quick-view" data-product="{{ $product->slug }}">
                                        <i data-lucide="eye"></i>
                                    </button>
                                    <button class="action-btn wishlist"
                                        x-data="wishlistToggle({{ $product->isInWishlist() ? 'true' : 'false' }})"
                                        :class="{ 'active': inWishlist }"
                                        @click.prevent="toggle({{ $product->id }})"
                                        :disabled="isProcessing"
                                        type="button">
                                        <i :class="inWishlist ? 'fas fa-heart' : 'far fa-heart'"></i>
                                    </button>
                                </div>
                                <div class="product-badges">
                                    <span class="badge promo-badge-floating">-{{ rand(20, 50) }}%</span>
                                </div>
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
                @endif

                <!-- Rekomendasi Untuk Anda Section -->
                @if(isset($recommendations) && $recommendations->count() > 0)
                <div class="promo-section mb-5 recommendations-section" x-transition style="background: linear-gradient(135deg, #fef8f6 0%, #fff 100%); border: 1px solid rgba(212, 165, 165, 0.2);">
                    <div class="promo-section-header text-start mb-4" style="text-align: left !important; display: flex; flex-direction: column; align-items: flex-start; gap: 4px;">
                        <div class="promo-badge mb-2" style="background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light)); color: #fff; padding: 0.4rem 1rem; border-radius: 50px; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; gap: 6px;">
                            <i data-lucide="sparkles" style="width: 14px; height: 14px;"></i>
                            <span>Rekomendasi</span>
                        </div>
                        <h2 class="promo-section-title" style="font-size: 1.8rem; font-weight: 600; margin: 0; color: #1a1a1a;">Rekomendasi Untuk Anda</h2>
                        <p class="section-subtitle text-muted" style="margin: 0; font-size: 0.9rem;">{{ $recoSubtitle }}</p>
                    </div>
                    <div class="product-grid" id="recommendationsProductGrid">
                        @foreach($recommendations as $product)
                        <div class="product-card" data-product-id="{{ $product->id }}">
                            <div class="product-image-wrapper">
                                <img src="{{ url('render-image?path=' . ($product->image ?? 'default.jpg')) }}" alt="{{ $product->name }}" class="product-image">
                                <div class="product-actions">
                                    <button class="action-btn quick-view" data-product="{{ $product->slug }}">
                                        <i data-lucide="eye"></i>
                                    </button>
                                    <button class="action-btn wishlist"
                                        x-data="wishlistToggle({{ $product->isInWishlist() ? 'true' : 'false' }})"
                                        :class="{ 'active': inWishlist }"
                                        @click.prevent="toggle({{ $product->id }})"
                                        :disabled="isProcessing"
                                        type="button">
                                        <i :class="inWishlist ? 'fas fa-heart' : 'far fa-heart'"></i>
                                    </button>
                                </div>
                                @if($product->discount_price)
                                <div class="product-badges">
                                    <span class="badge sale-badge">Sale</span>
                                </div>
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
                @endif

                </div>
            </div>
        </div>
        </div>{{-- end x-data="productFilter()" wrapper --}}
    </div>
</div>

<style>
/* Products Page Styles */
.products-page {
    font-family: var(--font-body, 'Montserrat', sans-serif);
    background: #faf8f7;
    min-height: 100vh;
}

/* Breadcrumb */
.breadcrumb-nav {
    padding: 1rem 0;
}

.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.breadcrumb-item a {
    color: #999;
    text-decoration: none;
    transition: color 0.3s;
}

.breadcrumb-item a:hover {
    color: var(--color-primary);
}

.breadcrumb-item.active {
    color: #1a1a1a;
    font-weight: 500;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: #ccc;
}

/* Filter Sidebar */
.filter-sidebar {
    background: #fff;
    border-radius: 20px;
    padding: 1.5rem;
    position: sticky;
    top: 20px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.05);
}

.filter-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #eee;
}

.filter-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0;
    color: #1a1a1a;
}

.filter-reset {
    background: none;
    border: none;
    color: var(--color-primary);
    font-size: 0.8rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 5px;
    transition: all 0.3s;
}

.filter-reset:hover {
    color: var(--color-primary-light);
    transform: translateX(-2px);
}

.filter-reset i {
    width: 16px;
    height: 16px;
}

.filter-section {
    margin-bottom: 2rem;
}

.filter-section-title {
    font-size: 0.9rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 8px;
    color: #666;
}

.filter-section-title i {
    width: 18px;
    height: 18px;
}

/* Category List */
.category-list {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.category-link {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.6rem 1rem;
    color: #666;
    text-decoration: none;
    transition: all 0.3s;
    font-size: 0.9rem;
    border: 1px solid #eee;
    border-radius: 50px;
    background: #fff;
    margin-bottom: 0.3rem;
}

.category-link:hover {
    color: var(--color-primary);
    border-color: rgba(194,24,91,0.2);
    background: var(--color-surface-alt);
    transform: translateY(-2px);
}

.category-link.active {
    color: #fff;
    background: var(--color-primary);
    border-color: var(--color-primary);
    font-weight: 500;
}

.category-link.active .category-count {
    color: rgba(255,255,255,0.8);
}

.category-count {
    color: #999;
    font-size: 0.8rem;
}

/* Price Range */
.price-range-container {
    margin-bottom: 1rem;
}

.price-inputs {
    display: flex;
    gap: 10px;
    margin-bottom: 1rem;
}

.price-input-group {
    flex: 1;
}

.price-input-group label {
    font-size: 0.7rem;
    color: #999;
    margin-bottom: 0.25rem;
    display: block;
}

.price-input {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #e0e0e0;
    border-radius: 10px;
    font-size: 0.8rem;
    outline: none;
    transition: all 0.3s;
}

.price-input:focus {
    border-color: var(--color-primary);
}

.price-separator {
    color: #999;
    font-weight: 600;
    align-self: flex-end;
    margin-bottom: 0.5rem;
}

.price-slider-container {
    position: relative;
    height: 40px;
    margin-top: 20px;
}

.price-track {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 100%;
    height: 3px;
    background: #e0e0e0;
    border-radius: 3px;
}

.price-range {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    height: 3px;
    background: var(--color-primary);
    border-radius: 3px;
}

.price-slider-container input[type="range"] {
    position: absolute;
    width: 100%;
    top: 50%;
    transform: translateY(-50%);
    -webkit-appearance: none;
    background: transparent;
    pointer-events: none;
}

.price-slider-container input[type="range"]::-webkit-slider-thumb {
    -webkit-appearance: none;
    width: 16px;
    height: 16px;
    border-radius: 50%;
    background: var(--color-primary);
    cursor: pointer;
    pointer-events: auto;
    border: 2px solid #fff;
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
}

.price-slider-container input[type="range"]::-webkit-slider-thumb:hover {
    transform: scale(1.2);
}

.filter-apply-btn {
    width: 100%;
    padding: 0.75rem;
    background: #1a1a1a;
    color: #fff;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    transition: all 0.3s;
    font-weight: 500;
    margin-top: 1rem;
}

.filter-apply-btn:hover {
    background: var(--color-primary);
    transform: translateY(-2px);
}

/* Sorting Options */
.sorting-options {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.sort-option {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 0.5rem;
    color: #666;
    text-decoration: none;
    border-radius: 10px;
    transition: all 0.3s;
    font-size: 0.9rem;
}

.sort-option i {
    width: 18px;
    height: 18px;
}

.sort-option:hover {
    background: #f8f8f8;
    color: var(--color-primary);
}

.sort-option.active {
    background: var(--color-surface-alt);
    color: var(--color-primary);
    font-weight: 500;
}

/* Active Filters */
.active-filters-list {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.filter-tag {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: var(--color-surface-alt);
    padding: 0.4rem 0.8rem;
    border-radius: 50px;
    font-size: 0.8rem;
    color: #1a1a1a;
}

.remove-filter {
    color: var(--color-primary);
    text-decoration: none;
    font-size: 1.2rem;
    line-height: 1;
    margin-left: 5px;
}

.remove-filter:hover {
    color: var(--color-primary-light);
}

/* Products Header */
.products-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid #e0e0e0;
    flex-wrap: wrap;
    gap: 12px;
}

/* Mobile Filter Toggle Button */
.btn-filter-mobile {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 0.5rem 1rem;
    background: #1a1a1a;
    color: #fff;
    border: none;
    border-radius: 50px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
    position: relative;
    min-height: 44px;
}

.btn-filter-mobile:hover,
.btn-filter-mobile:focus {
    background: #333;
    color: #fff;
    outline: 2px solid var(--color-primary);
    outline-offset: 2px;
}

.btn-filter-mobile:active {
    transform: scale(0.97);
}

.btn-filter-mobile i {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}

.filter-active-dot {
    display: inline-block;
    width: 8px;
    height: 8px;
    background: var(--color-primary);
    border-radius: 50%;
    margin-left: 2px;
    flex-shrink: 0;
}

.products-count {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #666;
    font-size: 0.9rem;
}

.products-count i {
    width: 20px;
    height: 20px;
}

/* Products Page Search Bar */
.products-search-bar {
    flex: 1;
    max-width: 360px;
    min-width: 200px;
}

.products-search-form {
    width: 100%;
}

.products-search-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    background: #f8f6f5;
    border: 1px solid #e8e0de;
    border-radius: 50px;
    padding: 4px;
    transition: all 0.3s ease;
}

.products-search-wrapper:focus-within {
    background: #fff;
    border-color: var(--color-primary);
    box-shadow: 0 4px 16px rgba(212, 165, 165, 0.15);
}

.products-search-icon {
    position: absolute;
    left: 1rem;
    width: 16px;
    height: 16px;
    color: #999;
    pointer-events: none;
    transition: color 0.3s ease;
}

.products-search-wrapper:focus-within .products-search-icon {
    color: var(--color-primary);
}

.products-search-input {
    width: 100%;
    background: transparent;
    border: none;
    outline: none;
    padding: 0.5rem 5.5rem 0.5rem 2.5rem;
    font-size: 0.85rem;
    color: #1a1a1a;
    font-family: inherit;
}

.products-search-input::placeholder {
    color: #aaa;
}

.clear-products-search-btn {
    position: absolute;
    right: 4.2rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #999;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 0.2rem;
    z-index: 2;
    transition: color 0.2s;
}

.clear-products-search-btn:hover {
    color: var(--color-primary);
}

.clear-products-search-btn i {
    width: 14px;
    height: 14px;
}

.products-search-btn {
    background: #1a1a1a;
    color: #fff;
    border: none;
    border-radius: 50px;
    padding: 0.5rem 1.2rem;
    font-size: 0.8rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.products-search-btn:hover {
    background: var(--color-primary);
}

.products-view-toggle {
    display: flex;
    gap: 10px;
}

.view-btn {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 8px;
    transition: all 0.3s;
}

.view-btn i {
    width: 20px;
    height: 20px;
    color: #999;
}

.view-btn.active i {
    color: var(--color-primary);
}

.view-btn:hover i {
    color: var(--color-primary);
}

/* Promo Section */
.promo-section {
    margin-bottom: 3rem;
    padding: 2rem;
    background: linear-gradient(135deg, #fff5f3 0%, #fff 100%);
    border-radius: 30px;
}

.promo-section-header {
    text-align: center;
    margin-bottom: 2rem;
}

.promo-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: linear-gradient(135deg, #DC2626, #EF4444);
    color: #fff;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 600;
    margin-bottom: 1rem;
}

.promo-badge i {
    width: 16px;
    height: 16px;
}

.promo-section-title {
    font-family: var(--font-heading, 'Cormorant', serif);
    font-size: 2rem;
    font-weight: 400;
    margin-bottom: 1rem;
    color: #1a1a1a;
}

.promo-timer {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
}

.timer-block {
    text-align: center;
    background: #fff;
    padding: 0.75rem 1rem;
    border-radius: 15px;
    min-width: 70px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.timer-value {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--color-primary);
    line-height: 1;
}

.timer-label {
    font-size: 0.7rem;
    text-transform: uppercase;
    color: #999;
    letter-spacing: 1px;
}

.timer-colon {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--color-primary);
}

/* Product Grid */
.product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
    gap: 30px;
}

.product-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    cursor: pointer;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.12);
}

.product-image-wrapper {
    position: relative;
    overflow: hidden;
    aspect-ratio: 1/1;
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
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #fff;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
}

.action-btn i {
    width: 18px;
    height: 18px;
}

.action-btn:hover {
    background: var(--color-primary);
    color: #fff;
    transform: scale(1.1);
}

.action-btn:hover i {
    color: #fff;
}

.product-badges {
    position: absolute;
    top: 15px;
    left: 15px;
}

.badge {
    display: inline-block;
    padding: 0.3rem 0.8rem;
    border-radius: 50px;
    font-size: 0.7rem;
    font-weight: 600;
}

.promo-badge-floating {
    background: linear-gradient(135deg, #DC2626, #EF4444);
    color: #fff;
}

.sale-badge {
    background: #1a1a1a;
    color: #fff;
}

.product-info {
    padding: 1.2rem;
    text-align: center;
}

.product-title {
    font-size: 0.9rem;
    font-weight: 500;
    margin-bottom: 0.5rem;
    color: #1a1a1a;
    line-height: 1.4;
}

.product-price {
    margin: 0.5rem 0;
}

.price-original {
    font-size: 0.75rem;
    color: #999;
    text-decoration: line-through;
    margin-right: 8px;
}

.price-sale, .price-current {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--color-primary);
}

.product-link {
    display: inline-block;
    margin-top: 0.5rem;
    font-size: 0.8rem;
    color: #1a1a1a;
    text-decoration: none;
    border-bottom: 1px solid var(--color-primary);
    transition: all 0.3s ease;
}

.product-link:hover {
    color: var(--color-primary);
    letter-spacing: 1px;
}

/* Section Header */
.all-products-section {
    margin-top: 2rem;
}

.section-header {
    text-align: center;
    margin-bottom: 2rem;
}

.section-title {
    font-family: var(--font-heading, 'Cormorant', serif);
    font-size: 2rem;
    font-weight: 400;
    margin-bottom: 0.5rem;
    color: #1a1a1a;
}

.section-divider {
    width: 60px;
    height: 2px;
    background: linear-gradient(90deg, var(--color-primary), var(--color-primary-light));
    margin: 0.5rem auto 0;
}

/* Empty State */
.empty-state {
    text-align: center;
    padding: 4rem 2rem;
}

.empty-state i {
    width: 80px;
    height: 80px;
    color: var(--color-primary);
    margin-bottom: 1rem;
}

.empty-state h3 {
    font-size: 1.5rem;
    font-weight: 400;
    margin-bottom: 0.5rem;
    color: #666;
}

.empty-state p {
    color: #999;
    margin-bottom: 1.5rem;
}

.empty-state-btn {
    display: inline-block;
    padding: 0.75rem 2rem;
    background: #1a1a1a;
    color: #fff;
    text-decoration: none;
    border-radius: 50px;
    transition: all 0.3s;
}

.empty-state-btn:hover {
    background: var(--color-primary);
    transform: translateY(-2px);
}

/* Pagination */
.pagination-wrapper {
    margin-top: 3rem;
    display: flex;
    justify-content: center;
}

.pagination-wrapper nav {
    display: inline-block;
}

.pagination-wrapper .pagination {
    display: flex;
    gap: 10px;
    list-style: none;
    padding: 0;
}

.pagination-wrapper .page-item .page-link {
    padding: 0.6rem 1rem;
    border: none;
    color: #666;
    border-radius: 10px;
    transition: all 0.3s;
    text-decoration: none;
}

.pagination-wrapper .page-item.active .page-link {
    background: var(--color-primary);
    color: #fff;
}

.pagination-wrapper .page-item .page-link:hover {
    background: #f8f8f8;
    color: var(--color-primary);
}

/* List View */
.product-grid.list-view {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.product-grid.list-view .product-card {
    display: flex;
    flex-direction: row;
    max-height: 200px;
}

.product-grid.list-view .product-image-wrapper {
    width: 200px;
    aspect-ratio: auto;
}

.product-grid.list-view .product-info {
    flex: 1;
    text-align: left;
}

/* Responsive */
@media (max-width: 992px) {
    .filter-sidebar {
        position: static;
        margin-bottom: 2rem;
    }
    
    .product-grid {
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 20px;
    }
    
    .products-header {
        flex-direction: column;
        align-items: stretch;
    }
    
    .products-search-bar {
        max-width: 100%;
        order: -1;
    }
    
    .products-count {
        justify-content: center;
    }
    
    .products-view-toggle {
        justify-content: center;
    }
}

@media (max-width: 768px) {
    .product-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }
    
    .promo-section {
        padding: 1rem;
    }
    
    .timer-block {
        min-width: 50px;
        padding: 0.5rem;
    }
    
    .timer-value {
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .product-grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 10px;
    }
    
    .product-card {
        margin-bottom: 0;
    }
    
    .product-info {
        padding: 0.75rem 0.5rem;
    }
    
    .product-title {
        font-size: 0.85rem;
    }
    
    .price-current, .price-sale {
        font-size: 0.9rem;
    }
}

/* Wishlist Active State */
.action-btn.wishlist.active {
    background: #fce4ec;
}

.action-btn.wishlist.active svg {
    fill: var(--color-primary) !important;
    stroke: var(--color-primary) !important;
}

/* ===== Loading State: Filter Disabled ===== */
[x-cloak] { display: none !important; }

.filter-disabled {
    opacity: 0.45;
    cursor: not-allowed !important;
    pointer-events: none;
}

.filter-apply-btn:disabled,
.products-search-btn:disabled {
    opacity: 0.55;
    cursor: not-allowed;
    transform: none !important;
}

.filter-apply-btn:disabled:hover {
    background: #1a1a1a;
    transform: none;
}

.filter-btn-loading {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.filter-spinner {
    width: 16px;
    height: 16px;
    flex-shrink: 0;
}

@keyframes filter-spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.price-input:disabled,
.price-slider-container input[type="range"]:disabled {
    opacity: 0.45;
    cursor: not-allowed;
}

.products-search-input:disabled {
    opacity: 0.55;
    cursor: not-allowed;
}

.input-loading {
    background-color: #f5f5f5 !important;
}

/* Login Required Modal Style */
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
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
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
    transition: color 0.3s;
}

.login-modal-close:hover {
    color: #000;
}

.login-modal-icon {
    display: flex;
    justify-content: center;
    margin-bottom: 1.5rem;
}

.login-modal-content h3 {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
    font-weight: 600;
    color: #1a1a1a;
}

.login-modal-content p {
    color: #666;
    font-size: 0.9rem;
    margin-bottom: 1.5rem;
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
    font-size: 0.9rem;
    transition: all 0.3s;
}

.login-btn {
    background: #1a1a1a;
    color: white;
}

.login-btn:hover {
    background: var(--color-primary);
    color: white;
}

.register-btn {
    background: #f0f0f0;
    color: #1a1a1a;
}

.register-btn:hover {
    background: var(--color-primary);
    color: white;
}

.login-modal-note {
    font-size: 0.75rem;
    color: #999;
    margin: 0;
}
</style>

<script>
// productFilter() Alpine.js component — Task 3.4
// $watch on all 5 filter properties with 400ms debounce → Axios GET /products/ajax
function productFilter() {
    return {
        search: '{{ request("search", "") }}',
        category: '{{ request("category", "") }}',
        minPrice: '{{ request("min_price", "0") }}',
        maxPrice: '{{ request("max_price", "1000000") }}',
        sort: '{{ request("sort", "terbaru") }}',
        loading: false,

        get isSearching() {
            const hasSearch = this.search.trim() !== '';
            const hasCategory = this.category !== '';
            const hasMin = this.minPrice !== '' && parseInt(this.minPrice) > 0;
            const hasMax = this.maxPrice !== '' && parseInt(this.maxPrice) < 1000000;
            return hasSearch || hasCategory || hasMin || hasMax;
        },

        // Debounce timer handle (shared across all watches)
        _debounceTimer: null,

        init() {
            // Watch each filter property independently — each triggers a debounced fetch
            this.$watch('search',   () => this._debouncedFetch());
            this.$watch('category', () => this._debouncedFetch());
            this.$watch('minPrice', () => this._debouncedFetch());
            this.$watch('maxPrice', () => this._debouncedFetch());
            this.$watch('sort',     () => this._debouncedFetch());

            // Expose clearFilters to global scope so injected empty-state button can call it
            window._clearProductFilters = () => this.clearFilters();
            window._alpine_setMinPrice = (val) => { this.minPrice = String(val); };
            window._alpine_setMaxPrice = (val) => { this.maxPrice = String(val); };
        },

        _debouncedFetch() {
            clearTimeout(this._debounceTimer);
            this._debounceTimer = setTimeout(() => {
                this.fetchProducts();
            }, 400);
        },

        clearFilters() {
            this.search    = '';
            this.category  = '';
            this.minPrice  = '0';
            this.maxPrice  = '1000000';
            this.sort      = 'terbaru';
        },

        applyPriceFilter() {
            const minEl = document.getElementById('minPrice') ?? document.getElementById('minPriceOffcanvas');
            const maxEl = document.getElementById('maxPrice') ?? document.getElementById('maxPriceOffcanvas');
            if (minEl) this.minPrice = minEl.value;
            if (maxEl) this.maxPrice = maxEl.value;
            this._debouncedFetch();
        },

        fetchProducts() {
            this.loading = true;

            axios.get('/products/ajax', {
                params: {
                    search:    this.search,
                    category:  this.category,
                    min_price: this.minPrice == '0' ? '' : this.minPrice,
                    max_price: this.maxPrice == '1000000' ? '' : this.maxPrice,
                    sort:      this.sort,
                    page:      1,
                }
            })
            .then(response => {
                const data = response.data;

                // Inject rendered product cards into #productGrid
                const productGrid = document.getElementById('productGrid');
                if (productGrid) {
                    if (data.total === 0) {
                        // Show friendly empty state when no results found
                        productGrid.innerHTML = `
                            <div class="empty-state" style="grid-column: 1 / -1; width: 100%;">
                                <i class="fas fa-search-minus" style="font-size: 3rem; color: #ccc; margin-bottom: 15px;"></i>
                                <h3>Produk tidak ditemukan</h3>
                                <p>Coba ubah kata kunci pencarian atau hapus filter yang aktif.</p>
                                <button
                                    type="button"
                                    class="empty-state-btn"
                                    style="border: none; cursor: pointer;"
                                    onclick="window._clearProductFilters && window._clearProductFilters()">
                                    Clear Filters
                                </button>
                            </div>
                        `;
                    } else {
                        productGrid.innerHTML = data.html;
                    }
                }

                // Update product count text in #productCount
                const productCount = document.getElementById('productCount');
                if (productCount) {
                    productCount.textContent = data.total + ' Products';
                }

                // Update or hide #paginationArea
                const paginationArea = document.getElementById('paginationArea');
                if (paginationArea) {
                    if (data.pagination) {
                        paginationArea.innerHTML = data.pagination;
                        paginationArea.style.display = '';
                    } else {
                        paginationArea.innerHTML = '';
                        paginationArea.style.display = 'none';
                    }
                }

                // Re-initialize Lucide icons for newly injected HTML
                if (typeof lucide !== 'undefined') {
                    lucide.createIcons();
                }
            })
            .catch(error => {
                console.error('productFilter fetchProducts error:', error);
            })
            .finally(() => {
                this.loading = false;
            });
        },
    };
}
</script>
<script>
(function() {
    // Initialize Lucide icons
    lucide.createIcons();
    
    // Products Search Clear Button Logic
    const productsSearchInput = document.getElementById('productsSearchInput');
    const clearProductsSearchBtn = document.getElementById('clearProductsSearchBtn');
    
    if (productsSearchInput && clearProductsSearchBtn) {
        productsSearchInput.addEventListener('input', function() {
            clearProductsSearchBtn.style.display = this.value.length > 0 ? 'flex' : 'none';
        });
        
        clearProductsSearchBtn.addEventListener('click', function() {
            productsSearchInput.value = '';
            clearProductsSearchBtn.style.display = 'none';
            productsSearchInput.focus();
            
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('search')) {
                const searchForm = productsSearchInput.closest('form');
                if (searchForm.hasAttribute('action')) {
                    searchForm.submit();
                } else {
                    // It's AJAX, let Alpine handle it because we just cleared the input and it's x-modeled
                }
            }
        });
    }
    // Removed vanilla JS Price Range Slider logic because Alpine.js handles it perfectly via x-model and :style
    
    // Make sure window function doesn't crash if called
    window._alpine_setMinPrice = window._alpine_setMinPrice || function(){};
    window._alpine_setMaxPrice = window._alpine_setMaxPrice || function(){};
    
    // Reset Filters
    const resetBtn = document.getElementById('resetFiltersBtn');
    if (resetBtn) {
        resetBtn.addEventListener('click', function() {
            if (window._clearProductFilters) {
                window._clearProductFilters();
            } else {
                window.location.href = '{{ route("products.index") }}';
            }
        });
    }
    
    // Promo Countdown Timer (24 hours)
    function startPromoTimer() {
        const targetTime = new Date().getTime() + (24 * 60 * 60 * 1000);
        
        function updateTimer() {
            const now = new Date().getTime();
            const distance = targetTime - now;
            
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            const promoHours = document.getElementById('promoHours');
            const promoMinutes = document.getElementById('promoMinutes');
            const promoSeconds = document.getElementById('promoSeconds');
            
            if (promoHours) promoHours.textContent = String(hours).padStart(2, '0');
            if (promoMinutes) promoMinutes.textContent = String(minutes).padStart(2, '0');
            if (promoSeconds) promoSeconds.textContent = String(seconds).padStart(2, '0');
            
            if (distance < 0) {
                clearInterval(timerInterval);
                if (promoHours) promoHours.textContent = '00';
                if (promoMinutes) promoMinutes.textContent = '00';
                if (promoSeconds) promoSeconds.textContent = '00';
            }
        }
        
        updateTimer();
        const timerInterval = setInterval(updateTimer, 1000);
    }
    
    if (document.getElementById('promoTimer')) {
        startPromoTimer();
    }
    
    // Quick View Modal (Event Delegation)
    document.addEventListener('click', function(e) {
        const btn = e.target.closest('.quick-view');
        if (!btn) return;
        
        e.preventDefault();
        e.stopPropagation();
        const productSlug = btn.getAttribute('data-product');
        
        const modal = document.createElement('div');
        modal.className = 'custom-modal';
        modal.innerHTML = `
            <div class="custom-modal-content">
                <span class="custom-modal-close">&times;</span>
                <div class="modal-body">
                    <div class="modal-loading">
                        <i data-lucide="loader-circle" class="spin"></i>
                        <p>Loading product details...</p>
                    </div>
                </div>
            </div>
        `;
        document.body.appendChild(modal);
        lucide.createIcons();
        
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
        
        modal.onclick = (event) => {
            if (event.target === modal) {
                closeBtn.click();
            }
        };
        
        setTimeout(() => {
            const modalBody = modal.querySelector('.modal-body');
            modalBody.innerHTML = `
                <i data-lucide="sparkles" style="width: 48px; height: 48px; color: var(--color-primary); margin-bottom: 1rem;"></i>
                <h3 style="margin-bottom: 0.5rem;">Quick View</h3>
                <p style="color: #666; margin-bottom: 1.5rem;">Product details will appear here.<br>Click "View Details" for complete information.</p>
                <a href="/products/${productSlug}" class="modal-view-btn">View Full Details →</a>
            `;
            lucide.createIcons();
        }, 500);
    });
    
    // ========== SHOW LOGIN MODAL ==========
    function showLoginModal(productId) {
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
                    <i data-lucide="heart" style="width: 48px; height: 48px; color: var(--color-primary);"></i>
                </div>
                <h3>Login Dibutuhkan</h3>
                <p>Silakan login atau daftar untuk menyimpan produk ke wishlist favorit Anda.</p>
                <div class="login-modal-buttons">
                    <a href="{{ route('login') }}" class="login-modal-btn login-btn">Login</a>
                    <a href="{{ route('register') }}" class="login-modal-btn register-btn">Daftar</a>
                </div>
                <p class="login-modal-note">Halaman akan otomatis dialihkan kembali setelah login</p>
            </div>
        `;
        document.body.appendChild(modal);
        lucide.createIcons();
        
        // Store redirect URL
        localStorage.setItem('redirect_after_login', window.location.pathname + window.location.search);
        
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


    
    // View toggle (Grid/List)
    const viewBtns = document.querySelectorAll('.view-btn');
    const productGrid = document.getElementById('productGrid');
    
    viewBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            const view = btn.getAttribute('data-view');
            viewBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            if (productGrid) {
                if (view === 'list') {
                    productGrid.classList.add('list-view');
                } else {
                    productGrid.classList.remove('list-view');
                }
            }
        });
    });
    
    // Intersection Observer for fade-in
    const fadeElements = document.querySelectorAll('.product-card');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }, index * 50);
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });
    
    fadeElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
    
    // Add custom modal styles
    const style = document.createElement('style');
    style.textContent = `
        .custom-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(10px);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .custom-modal-content {
            background: #fff;
            border-radius: 30px;
            padding: 40px;
            max-width: 500px;
            width: 90%;
            position: relative;
            transform: scale(0.9);
            transition: transform 0.3s ease;
        }
        
        .custom-modal-close {
            position: absolute;
            top: 20px;
            right: 25px;
            font-size: 2rem;
            cursor: pointer;
            color: #999;
            transition: color 0.3s;
        }
        
        .custom-modal-close:hover {
            color: #000;
        }
        
        .modal-body {
            text-align: center;
        }
        
        .modal-loading {
            text-align: center;
        }
        
        .spin {
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        .modal-view-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 28px;
            background: #1a1a1a;
            color: #fff;
            text-decoration: none;
            border-radius: 50px;
            transition: all 0.3s;
        }
        
        .modal-view-btn:hover {
            background: var(--color-primary);
            transform: translateY(-2px);
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
        
        @media (max-width: 768px) {
            .custom-toast {
                white-space: normal;
                text-align: center;
                max-width: 90%;
                font-size: 0.8rem;
            }
        }
    `;
    document.head.appendChild(style);

    // Offcanvas Reset Filters button
    const resetOffcanvasBtn = document.getElementById('resetFiltersOffcanvasBtn');
    if (resetOffcanvasBtn) {
        resetOffcanvasBtn.addEventListener('click', function() {
            if (window._clearProductFilters) {
                window._clearProductFilters();
            } else {
                window.location.href = '{{ route("products.index") }}';
            }
        });
    }

    // Close offcanvas when a category/sort link inside it fires the 'close-offcanvas' event
    // (dispatched via Alpine.js @click.prevent="... $dispatch('close-offcanvas')")
    document.addEventListener('close-offcanvas', function() {
        const offcanvasEl = document.getElementById('filterOffcanvas');
        if (offcanvasEl && typeof bootstrap !== 'undefined') {
            const bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvasEl);
            if (bsOffcanvas) {
                bsOffcanvas.hide();
            }
        }
    });

    // Removed offcanvas vanilla JS Price Range Slider logic because Alpine.js handles it via x-model
})();
</script>
@endsection