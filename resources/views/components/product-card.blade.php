@props(['product'])

{{--
    Komponen Product Card Terpadu
    ==============================
    Penggunaan: <x-product-card :product="$product" />

    Menerima instance Model Product dengan relasi:
      - $product->category          (relasi category)
      - $product->image             (path gambar di storage)
      - $product->name
      - $product->slug
      - $product->price
      - $product->discount_price    (nullable)
      - $product->ratings_avg_rating (dari withAvg eager load) atau $product->average_rating
      - $product->isInWishlist()    (method pada model)

    Wishlist toggle menggunakan Axios POST ke /wishlist/ajax (diimplementasi di Fase 5).
    Sebelum Fase 5, tombol wishlist gracefully fallback ke redirect login jika belum auth.
--}}

@php
    $avgRating   = $product->ratings_avg_rating ?? $product->average_rating ?? 0;
    $avgRating   = round((float) $avgRating, 1);
    $fullStars   = floor($avgRating);
    $halfStar    = ($avgRating - $fullStars) >= 0.5;
    $emptyStars  = 5 - $fullStars - ($halfStar ? 1 : 0);
    $categoryName = $product->category->name ?? '';
    $isWishlisted = $product->isInWishlist();
    $discountPct  = ($product->discount_price && $product->price > 0)
                    ? round((1 - $product->discount_price / $product->price) * 100)
                    : 0;
@endphp

<div
    class="product-card"
    data-product-id="{{ $product->id }}"
    x-data="wishlistToggle({{ $isWishlisted ? 'true' : 'false' }})"
>
    {{-- Gambar Produk --}}
    <div class="product-image-wrapper">
        <a href="{{ route('products.show', $product->slug) }}" class="d-block" aria-label="Lihat detail {{ $product->name }}">
            <img
                src="{{ url('media/' . ($product->image ?? 'default.jpg')) }}"
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

            {{-- Wishlist Toggle --}}
            @php $productNameEscaped = addslashes($product->name); @endphp
            <button
                class="action-btn wishlist"
                :class="{ 'active': inWishlist }"
                @click.prevent="toggle({{ $product->id }})"
                :aria-label="inWishlist ? 'Hapus {{ $productNameEscaped }} dari wishlist' : 'Tambah {{ $productNameEscaped }} ke wishlist'"
                :disabled="isProcessing"
                type="button"
                data-product="{{ $product->id }}"
            >
                <i :class="inWishlist ? 'fas fa-heart' : 'far fa-heart'"></i>
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
            <span class="product-category">{{ $categoryName }}</span>
        @endif

        {{-- Nama Produk --}}
        <h3 class="product-title">
            <a href="{{ route('products.show', $product->slug) }}" class="product-title-link" aria-label="{{ $product->name }}">
                {{ Str::limit($product->name, 40) }}
            </a>
        </h3>

        {{-- Rating Bintang --}}
        @if($avgRating > 0)
            <div class="product-rating" aria-label="Rating {{ $avgRating }} dari 5 bintang">
                @for($i = 0; $i < $fullStars; $i++)
                    <i class="fas fa-star rating-star"></i>
                @endfor
                @if($halfStar)
                    <i class="fas fa-star-half-alt rating-star"></i>
                @endif
                @for($i = 0; $i < $emptyStars; $i++)
                    <i class="far fa-star rating-star rating-star--empty"></i>
                @endfor
                <span class="rating-value">{{ number_format($avgRating, 1) }}</span>
            </div>
        @else
            <div class="product-rating product-rating--empty" aria-label="Belum ada rating">
                @for($i = 0; $i < 5; $i++)
                    <i class="far fa-star rating-star rating-star--empty"></i>
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
        <a href="{{ route('products.show', $product->slug) }}" class="product-link" aria-label="Lihat detail produk {{ $product->name }}">
            View Details →
        </a>
    </div>
</div>

<style>
/* =============================================
   Product Card Terpadu — product-card.blade.php
   Menggunakan palet warna toko: #d4a5a5 / #b5838d / #1a1a1a
   ============================================= */

/* Kategori label kecil di atas nama */
.product-category {
    display: block;
    font-size: 0.7rem;
    font-weight: 500;
    letter-spacing: 1px;
    text-transform: uppercase;
    color: #b5838d;
    margin-bottom: 0.25rem;
}

/* Nama produk sebagai link */
.product-title-link {
    color: inherit;
    text-decoration: none;
    transition: color 0.2s;
}

.product-title-link:hover {
    color: #d4a5a5;
}

/* Rating bintang */
.product-rating {
    display: flex;
    align-items: center;
    gap: 2px;
    margin-bottom: 0.4rem;
}

.rating-star {
    font-size: 0.75rem;
    color: #f4b942;
}

.rating-star--empty {
    color: #d0d0d0;
}

.rating-value {
    font-size: 0.75rem;
    color: #888;
    margin-left: 4px;
    line-height: 1;
}

/* Empty rating row - occupy same height to keep card consistent */
.product-rating--empty {
    opacity: 0.35;
}

/* Wishlist button loading state */
.action-btn.wishlist[disabled] {
    opacity: 0.6;
    cursor: not-allowed;
}

/* Ensure heart icon fills correctly */
.action-btn.wishlist.active i,
.action-btn.wishlist.active .fas {
    color: #e74c3c;
}

/* Prevent layout shift from category + rating lines */
.product-info {
    display: flex;
    flex-direction: column;
}
</style>
