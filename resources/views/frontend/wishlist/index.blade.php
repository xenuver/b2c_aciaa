@extends('layouts.app')

@section('title', 'Wishlist Saya')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* ─── Wishlist Premium Theme ─── */
.wish-hero {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
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
    background: radial-gradient(circle, rgba(207,126,126,0.15) 0%, transparent 70%);
    border-radius: 50%;
}
.wish-hero h1 {
    font-family: 'Inter', sans-serif;
    font-size: 1.75rem;
    font-weight: 800;
    color: #fff;
    margin: 0;
    letter-spacing: -0.5px;
}
.wish-hero h1 i { color: #cf7e7e; margin-right: 10px; }
.wish-hero .breadcrumb-text {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.55);
    margin-top: 6px;
}
.wish-hero .breadcrumb-text a { color: #cf7e7e; text-decoration: none; }

.wish-wrapper {
    font-family: 'Inter', sans-serif;
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
    color: #cf7e7e;
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
    background: linear-gradient(135deg, #cf7e7e 0%, #b76e79 100%);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.82rem;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    text-align: center;
}
.btn-view-product:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 16px rgba(207,126,126,0.35);
    color: #fff;
}
.btn-view-product i { font-size: 0.9rem; }

/* ─── Personalization Info Banner ─── */
.wish-personalization-info {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    background: linear-gradient(135deg, #fef8f6 0%, #fef0ec 100%);
    border: 1px solid rgba(207,126,126,0.2);
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
    background: linear-gradient(135deg, #cf7e7e, #b76e79);
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
    font-family: 'Inter', sans-serif;
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
.wish-empty-icon i { font-size: 2.5rem; color: #cf7e7e; }
.wish-empty h3 { font-weight: 800; color: #1a1a2e; margin-bottom: 0.5rem; font-family: 'Inter', sans-serif; }
.wish-empty p { color: #9ca3af; font-size: 0.9rem; margin-bottom: 1.5rem; }
.btn-explore {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: linear-gradient(135deg, #cf7e7e, #b76e79);
    color: #fff;
    border-radius: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s;
    font-family: 'Inter', sans-serif;
    box-shadow: 0 4px 16px rgba(207,126,126,0.3);
}
.btn-explore:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(207,126,126,0.4); color: #fff; }

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
    background: linear-gradient(135deg, #cf7e7e, #b76e79);
    border-color: #cf7e7e;
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
    @if(session('success'))
        <div class="wish-alert">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
    @endif


    @if($wishlists->count() > 0)
        <div class="wish-count" id="wishlist-total-count">{{ $wishlists->total() ?? $wishlists->count() }} PRODUK DI WISHLIST</div>

        <div class="row g-3">
            @foreach($wishlists as $wishlist)
            <div class="col-xl-3 col-lg-4 col-md-4 col-6 wish-card-col" id="wishlist-card-{{ $wishlist->id }}">
                <div class="wish-card">
                    <div class="wish-card-img-wrap">
                        <button class="wish-remove-btn" onclick="removeWishlist({{ $wishlist->id }})" title="Hapus dari wishlist">
                            <i class="fas fa-times"></i>
                        </button>

                        @if($wishlist->product->discount_price)
                            @php
                                $discount = round((($wishlist->product->price - $wishlist->product->discount_price) / $wishlist->product->price) * 100);
                            @endphp
                            <div class="wish-discount-badge">-{{ $discount }}%</div>
                        @endif

                        <a href="{{ route('products.show', $wishlist->product->slug ?? $wishlist->product->id) }}">
                            <img src="{{ asset('storage/' . ($wishlist->product->image ?? 'default.jpg')) }}"
                                 alt="{{ $wishlist->product->name }}">
                        </a>
                    </div>

                    <div class="wish-card-body">
                        <a href="{{ route('products.show', $wishlist->product->slug ?? $wishlist->product->id) }}" style="text-decoration:none;">
                            <h6 class="wish-card-name">{{ $wishlist->product->name }}</h6>
                        </a>

                        <div class="wish-card-price-wrap">
                            @if($wishlist->product->discount_price)
                                <span class="wish-card-price">Rp {{ number_format($wishlist->product->discount_price, 0, ',', '.') }}</span>
                                <span class="wish-card-price-old">Rp {{ number_format($wishlist->product->price, 0, ',', '.') }}</span>
                            @else
                                <span class="wish-card-price">Rp {{ number_format($wishlist->product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="wish-card-footer">
                        <a href="{{ route('products.show', $wishlist->product->slug ?? $wishlist->product->id) }}" class="btn-view-product">
                            <i class="fas fa-eye"></i> Lihat Produk
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