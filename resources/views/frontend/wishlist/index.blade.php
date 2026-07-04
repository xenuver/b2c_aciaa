@extends('layouts.app')

@section('title', 'Wishlist Saya')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* ─── Wishlist Premium Theme ─── */
.wish-hero {
    background: linear-gradient(135deg, #111111 0%, #1a1a1a 50%, #2a2a2a 100%);
    padding: 2.5rem 0 3rem;
    position: relative;
    overflow: hidden;
}
.wish-hero::before {
    content: '';
    position: absolute;
    top: -60%;
    left: -15%;
    width: 450px;
    height: 450px;
    background: radial-gradient(circle, rgba(194,24,91,0.15) 0%, transparent 70%);
    border-radius: 50%;
}
.wish-hero h1 {
    font-family: var(--font-body, 'Montserrat', sans-serif);
    font-size: 1.75rem;
    font-weight: 800;
    color: #fff;
    margin: 0;
    letter-spacing: -0.5px;
}
.wish-hero h1 i { color: var(--color-primary); margin-right: 10px; }
.wish-hero .breadcrumb-text {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.55);
    margin-top: 6px;
}
.wish-hero .breadcrumb-text a { color: var(--color-primary); text-decoration: none; }

.wish-wrapper {
    font-family: var(--font-body, 'Montserrat', sans-serif);
    max-width: 1140px;
    margin: -2rem auto 3rem;
    padding: 0 1rem;
    position: relative;
    z-index: 2;
}
.wish-count {
    font-size: 0.8rem;
    color: #9ca3af;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-bottom: 1rem;
}

/* ─── Product Card ─── */
.wish-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.04);
    overflow: hidden;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    height: 100%;
    display: flex;
    flex-direction: column;
}
.wish-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 16px 40px rgba(0,0,0,0.12);
}

.wish-card-img-wrap {
    position: relative;
    overflow: hidden;
    aspect-ratio: 1 / 1;
}
.wish-card-img-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
}
.wish-card:hover .wish-card-img-wrap img {
    transform: scale(1.08);
}

/* Remove Button */
.wish-remove-btn {
    position: absolute;
    top: 10px;
    right: 10px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: rgba(255,255,255,0.92);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    z-index: 3;
    transition: all 0.2s;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
.wish-remove-btn i { color: #dc2626; font-size: 0.85rem; transition: transform 0.2s; }
.wish-remove-btn:hover {
    background: #fee2e2;
    transform: scale(1.1);
}
.wish-remove-btn:hover i { transform: rotate(90deg); }

/* Discount Badge */
.wish-discount-badge {
    position: absolute;
    top: 10px;
    left: 10px;
    background: linear-gradient(135deg, #dc2626, #ef4444);
    color: #fff;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 4px 10px;
    border-radius: 20px;
    z-index: 3;
    letter-spacing: 0.02em;
}

/* Card Body */
.wish-card-body {
    padding: 1rem 1.1rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.wish-card-name {
    font-weight: 700;
    font-size: 0.88rem;
    color: #1a1a2e;
    margin: 0 0 8px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    line-height: 1.4;
}
.wish-card-price-wrap {
    margin-top: auto;
    display: flex;
    align-items: baseline;
    gap: 8px;
    flex-wrap: wrap;
}
.wish-card-price {
    font-weight: 800;
    font-size: 1.05rem;
    color: var(--color-primary);
}
.wish-card-price-old {
    font-size: 0.8rem;
    color: #9ca3af;
    text-decoration: line-through;
}

/* Card Footer */
.wish-card-footer {
    padding: 0 1.1rem 1.1rem;
}
.btn-view-product {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 10px 16px;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.82rem;
    font-family: var(--font-body, 'Montserrat', sans-serif);
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    text-align: center;
}
.btn-view-product:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(194,24,91,0.35);
    color: #fff;
}
.btn-view-product i { font-size: 0.9rem; }

/* ─── Personalization Info Banner ─── */
.wish-personalization-info {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    background: linear-gradient(135deg, #fef8f6 0%, #fef0ec 100%);
    border: 1px solid rgba(194,24,91,0.2);
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    margin-bottom: 1.5rem;
    animation: slideDown 0.4s ease;
}
.wish-personalization-icon {
    width: 44px;
    height: 44px;
    min-width: 44px;
    border-radius: 12px;
    background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light));
    display: flex;
    align-items: center;
    justify-content: center;
}
.wish-personalization-icon i {
    color: #fff;
    font-size: 1.1rem;
}
.wish-personalization-text strong {
    display: block;
    font-size: 0.9rem;
    color: #1a1a2e;
    margin-bottom: 4px;
    font-family: var(--font-body, 'Montserrat', sans-serif);
}
.wish-personalization-text p {
    font-size: 0.8rem;
    color: #6b7280;
    margin: 0;
    line-height: 1.5;
}

/* ─── Empty State ─── */
.wish-empty {
    text-align: center;
    padding: 4rem 2rem;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
}
.wish-empty-icon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f5f0ec, #fce4ec);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}
.wish-empty-icon i { font-size: 2.5rem; color: var(--color-primary); }
.wish-empty h3 { font-weight: 800; color: #1a1a2e; margin-bottom: 0.5rem; font-family: var(--font-body, 'Montserrat', sans-serif); }
.wish-empty p { color: #9ca3af; font-size: 0.9rem; margin-bottom: 1.5rem; }
.btn-explore {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light));
    color: #fff;
    border-radius: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s;
    font-family: var(--font-body, 'Montserrat', sans-serif);
    box-shadow: 0 4px 16px rgba(194,24,91,0.3);
}
.btn-explore:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(194,24,91,0.4); color: #fff; }

/* ─── Alert ─── */
.wish-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 0.85rem;
    color: #166534;
    font-weight: 500;
    margin-bottom: 1.25rem;
    animation: slideDown 0.3s ease;
}
.wish-alert i { color: #16a34a; }
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ─── Pagination ─── */
.wish-pagination .pagination {
    gap: 4px;
    margin: 0;
}
.wish-pagination .page-link {
    border-radius: 10px !important;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 8px 14px;
    border: 1px solid #e5e7eb;
    color: #374151;
}
.wish-pagination .page-item.active .page-link {
    background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light));
    border-color: var(--color-primary);
    color: #fff;
}

/* ─── Card Column Transition ─── */
.wish-card-col {
    transition: opacity 0.4s ease, transform 0.4s ease;
}
.wish-card-col.removing {
    opacity: 0;
    transform: scale(0.85) translateY(10px);
}
</style>
@endpush

@section('content')
<!-- Hero Banner -->
<div class="wish-hero">
    <div class="container">
        <h1><i class="fas fa-heart"></i> Wishlist Saya</h1>
        <div class="breadcrumb-text">
            <a href="{{ route('home') }}">Beranda</a> / Wishlist
        </div>
    </div>
</div>

<div class="wish-wrapper">



    @if($wishlists->count() > 0)
        <div class="wish-count" id="wishlist-total-count">{{ $wishlists->total() ?? $wishlists->count() }} PRODUK DI WISHLIST</div>

        <div class="row g-3">
            @foreach($wishlists as $wishlist)
            @php
                $product = $wishlist->product;
                $avgRating = $product->ratings_avg_rating ?? $product->average_rating ?? 0;
                $avgRating = round((float) $avgRating, 1);
                $fullStars = floor($avgRating);
                $halfStar = ($avgRating - $fullStars) >= 0.5;
                $emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0);
                $categoryName = $product->category->name ?? '';
                $discountPct = ($product->discount_price && $product->price > 0)
                                ? round((1 - $product->discount_price / $product->price) * 100)
                                : 0;
            @endphp
            <div class="col-xl-3 col-lg-4 col-md-4 col-6 wish-card-col" id="wishlist-card-{{ $wishlist->id }}">
                <div class="product-card" data-product-id="{{ $product->id }}">
                    {{-- Gambar Produk --}}
                    <div class="product-image-wrapper">
                        <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="d-block" aria-label="Lihat detail {{ $product->name }}">
                            <img
                                src="{{ url('render-image?path=' . ($product->image ?? 'default.jpg')) }}"
                                alt="{{ $product->name }}"
                                class="product-image"
                                onerror="this.onerror=null; this.src='{{ asset('images/placeholder-product.png') }}';"
                                loading="lazy"
                            >
                        </a>

                        {{-- Overlay Actions --}}
                        <div class="product-actions">
                            {{-- Quick View --}}
                            <button
                                class="action-btn quick-view"
                                data-product="{{ $product->slug }}"
                                aria-label="Lihat cepat {{ $product->name }}"
                                type="button"
                            >
                                <i data-lucide="eye"></i>
                            </button>

                            {{-- Remove Wishlist --}}
                            <button
                                class="action-btn wishlist active"
                                onclick="removeWishlist({{ $wishlist->id }})"
                                title="Hapus dari wishlist"
                                type="button"
                                style="color: #e74c3c;"
                            >
                                <i class="fas fa-times"></i>
                            </button>
                        </div>

                        {{-- Badges --}}
                        @if($product->discount_price && $discountPct > 0)
                            <div class="product-badges">
                                <span class="badge sale-badge">-{{ $discountPct }}%</span>
                            </div>
                        @endif

                        @if($product->stock <= 0)
                            <div class="product-badges" style="top: auto; bottom: 10px;">
                                <span class="badge" style="background: #6c757d; color:#fff; font-size:0.7rem;">Habis</span>
                            </div>
                        @endif
                    </div>

                    {{-- Info Produk --}}
                    <div class="product-info">
                        {{-- Kategori --}}
                        @if($categoryName)
                            <span class="product-category" style="display: block; font-size: 0.7rem; font-weight: 500; letter-spacing: 1px; text-transform: uppercase; color: var(--color-primary-light); margin-bottom: 0.25rem;">{{ $categoryName }}</span>
                        @endif

                        {{-- Nama Produk --}}
                        <h3 class="product-title">
                            <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="product-title-link" style="color: inherit; text-decoration: none; transition: color 0.2s;" aria-label="{{ $product->name }}">
                                {{ Str::limit($product->name, 40) }}
                            </a>
                        </h3>

                        {{-- Rating Bintang --}}
                        @if($avgRating > 0)
                            <div class="product-rating" aria-label="Rating {{ $avgRating }} dari 5 bintang" style="display: flex; align-items: center; gap: 2px; margin-bottom: 0.4rem;">
                                @for($i = 0; $i < $fullStars; $i++)
                                    <i class="fas fa-star rating-star" style="font-size: 0.75rem; color: #f4b942;"></i>
                                @endfor
                                @if($halfStar)
                                    <i class="fas fa-star-half-alt rating-star" style="font-size: 0.75rem; color: #f4b942;"></i>
                                @endif
                                @for($i = 0; $i < $emptyStars; $i++)
                                    <i class="far fa-star rating-star rating-star--empty" style="font-size: 0.75rem; color: #d0d0d0;"></i>
                                @endfor
                                <span class="rating-value" style="font-size: 0.75rem; color: #888; margin-left: 4px; line-height: 1;">{{ number_format($avgRating, 1) }}</span>
                            </div>
                        @else
                            <div class="product-rating product-rating--empty" aria-label="Belum ada rating" style="display: flex; align-items: center; gap: 2px; margin-bottom: 0.4rem; opacity: 0.35;">
                                @for($i = 0; $i < 5; $i++)
                                    <i class="far fa-star rating-star rating-star--empty" style="font-size: 0.75rem; color: #d0d0d0;"></i>
                                @endfor
                            </div>
                        @endif

                        {{-- Harga --}}
                        <div class="product-price">
                            @if($product->discount_price)
                                <span class="price-original">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="price-sale">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            @else
                                <span class="price-current">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>

                        {{-- Link Detail --}}
                        <a href="{{ route('products.show', $product->slug ?? $product->id) }}" class="product-link" aria-label="Lihat detail produk {{ $product->name }}">
                            View Details →
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="wish-pagination mt-4 d-flex justify-content-center">
            {{ $wishlists->links() }}
        </div>
    @else
        <div class="wish-empty">
            <div class="wish-empty-icon">
                <i class="fas fa-heart"></i>
            </div>
            <h3>Wishlist Anda Masih Kosong</h3>
            <p>Simpan produk favorit kamu untuk mendapatkan rekomendasi personal di beranda!</p>
            <a href="{{ route('products.index') }}" class="btn-explore">
                <i class="fas fa-compass"></i> Jelajahi Produk
            </a>
        </div>
    @endif
</div>

<form id="removeForm" method="POST" style="display: none;">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function removeWishlist(id) {
    if (!confirm('Hapus produk dari wishlist?')) return;

    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content
        || document.querySelector('input[name="_token"]')?.value;

    fetch('/wishlist/' + id, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(res => res.json())
    .then(data => {
        // 1. Fade out the card
        const card = document.getElementById('wishlist-card-' + id);
        if (card) {
            card.classList.add('removing');
            setTimeout(() => card.remove(), 450);
        }

        // 2. Update total count text
        const countEl = document.getElementById('wishlist-total-count');
        if (countEl) {
            if (data.count > 0) {
                countEl.textContent = data.count + ' PRODUK DI WISHLIST';
            } else {
                countEl.textContent = '0 PRODUK DI WISHLIST';
            }
        }

        // 3. Update navbar badges
        const desktopBadge = document.getElementById('wishlistCount');
        const mobileBadge = document.getElementById('mobileWishlistCount');
        [desktopBadge, mobileBadge].forEach(badge => {
            if (badge) {
                if (data.count > 0) {
                    badge.textContent = data.count;
                    badge.style.display = 'inline-flex';
                } else {
                    badge.style.display = 'none';
                }
            }
        });

        // 4. Show toast notification
        const existingAlerts = document.querySelectorAll('.wish-alert');
        existingAlerts.forEach(a => a.remove());

        const alertHtml = `<div class="wish-alert">
            <i class="fas fa-check-circle"></i>
            ${data.message || 'Produk dihapus dari wishlist'}
        </div>`;
        const wrapper = document.querySelector('.wish-wrapper');
        if (wrapper) {
            wrapper.insertAdjacentHTML('afterbegin', alertHtml);
            setTimeout(() => {
                const alert = wrapper.querySelector('.wish-alert');
                if (alert) alert.remove();
            }, 3000);
        }

        // 5. If no items left, show empty state after animation completes
        if (data.count === 0) {
            setTimeout(() => {
                const gridRow = document.querySelector('.wish-wrapper .row.g-3');
                const pagination = document.querySelector('.wish-pagination');
                if (countEl) countEl.remove();
                if (gridRow) gridRow.remove();
                if (pagination) pagination.remove();

                const emptyHtml = `
                <div class="wish-empty" style="opacity:0;transform:translateY(15px);transition:opacity 0.5s ease,transform 0.5s ease;">
                    <div class="wish-empty-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <h3>Wishlist Anda Masih Kosong</h3>
                    <p>Simpan produk favorit kamu untuk mendapatkan rekomendasi personal di beranda!</p>
                    <a href="{{ route('products.index') }}" class="btn-explore">
                        <i class="fas fa-compass"></i> Jelajahi Produk
                    </a>
                </div>`;

                if (wrapper) {
                    wrapper.insertAdjacentHTML('beforeend', emptyHtml);
                    const emptyEl = wrapper.querySelector('.wish-empty');
                    setTimeout(() => {
                        if (emptyEl) {
                            emptyEl.style.opacity = '1';
                            emptyEl.style.transform = 'translateY(0)';
                        }
                    }, 50);
                }
            }, 500);
        }
    })
    .catch(err => {
        console.error('Error removing wishlist:', err);
        // Fallback to form submit
        const form = document.getElementById('removeForm');
        form.action = '/wishlist/' + id;
        form.submit();
    });
}
</script>
@endpush