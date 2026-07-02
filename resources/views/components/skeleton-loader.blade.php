@props(['count' => 8])

{{-- Skeleton Loader untuk Grid Produk --}}
{{-- Penggunaan: <x-skeleton-loader :count="8" /> --}}

<style>
@keyframes skeleton-shimmer {
    0% { background-position: -400px 0; }
    100% { background-position: 400px 0; }
}

.skeleton-card {
    background: #fff;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.04);
}

.skeleton-block {
    background: linear-gradient(
        90deg,
        #f9e8e8 0%,
        #f0d0d0 25%,
        #f9e8e8 50%,
        #f0d0d0 75%,
        #f9e8e8 100%
    );
    background-size: 800px 100%;
    animation: skeleton-shimmer 1.6s ease-in-out infinite;
    border-radius: 6px;
}

.skeleton-image {
    width: 100%;
    aspect-ratio: 1 / 1;
    border-radius: 0;
}

.skeleton-info {
    padding: 1.2rem;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.6rem;
}

.skeleton-title {
    height: 14px;
    width: 75%;
}

.skeleton-title-short {
    height: 14px;
    width: 55%;
}

.skeleton-price {
    height: 16px;
    width: 45%;
    background: linear-gradient(
        90deg,
        #f4d0d0 0%,
        #e8b8b8 25%,
        #f4d0d0 50%,
        #e8b8b8 75%,
        #f4d0d0 100%
    );
    background-size: 800px 100%;
    animation: skeleton-shimmer 1.6s ease-in-out infinite;
    border-radius: 6px;
}

.skeleton-btn {
    height: 12px;
    width: 38%;
    margin-top: 0.2rem;
}
</style>

<div class="product-grid" aria-busy="true" aria-label="Memuat produk...">
    @for ($i = 0; $i < $count; $i++)
    <div class="skeleton-card" role="status" aria-label="Memuat...">
        {{-- Image placeholder --}}
        <div class="skeleton-block skeleton-image"></div>

        {{-- Info placeholder --}}
        <div class="skeleton-info">
            <div class="skeleton-block skeleton-title"></div>
            <div class="skeleton-block skeleton-title-short"></div>
            <div class="skeleton-price"></div>
            <div class="skeleton-block skeleton-btn"></div>
        </div>
    </div>
    @endfor
</div>
