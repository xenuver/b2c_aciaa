@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container my-5">
    <div class="row">
        <!-- Gambar Produk -->
        <div class="col-md-6">
            <img src="{{ url('media/' . ($product->image ?? 'default.jpg')) }}" 
                 class="img-fluid rounded shadow" 
                 alt="{{ $product->name }}">
        </div>

        <!-- Detail Produk -->
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            
            <!-- Rating -->
            <div class="mb-2">
                @for($i = 1; $i <= 5; $i++)
                    @if($i <= floor($averageRating))
                        <i class="fas fa-star text-warning"></i>
                    @elseif($i - 0.5 <= $averageRating)
                        <i class="fas fa-star-half-alt text-warning"></i>
                    @else
                        <i class="far fa-star text-warning"></i>
                    @endif
                @endfor
                <span class="text-muted ms-2">({{ $reviews->count() }} ulasan)</span>
            </div>

            <!-- Harga -->
            <div class="mb-3">
                @if($product->discount_price)
                    <span class="text-muted text-decoration-line-through fs-5">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </span>
                    <span class="text-danger fw-bold fs-3 ms-2">
                        Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                    </span>
                @else
                    <span class="fw-bold fs-3">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @endif
            </div>

            <!-- Stok -->
            <div class="mb-3">
                <span class="badge bg-{{ $product->stock > 0 ? 'success' : 'danger' }}">
                    {{ $product->stock > 0 ? 'Stok: ' . $product->stock : 'Stok Habis' }}
                </span>
            </div>

            <!-- Deskripsi -->
            <div class="mb-3">
                <h5>Deskripsi Produk</h5>
                <p>{{ $product->description }}</p>
            </div>

            <!-- SKU -->
            <div class="mb-3 text-muted small">
                SKU: {{ $product->sku ?? '-' }}
            </div>

            <!-- Tombol Aksi -->
            <div class="d-flex gap-2 flex-wrap">
                @if($product->stock > 0)
                    <!-- Tombol Add to Cart -->
                    <form action="{{ route('cart.add') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-shopping-cart"></i> Keranjang
                        </button>
                    </form>

                    <!-- Tombol Wishlist -->
                    <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="{{ $product->isInWishlist() ? 'fas' : 'far' }} fa-heart"></i>
                            {{ $product->isInWishlist() ? 'Hapus dari Wishlist' : 'Wishlist' }}
                        </button>
                    </form>
                @else
                    <button class="btn btn-secondary" disabled>Stok Habis</button>
                @endif
            </div>
        </div>
    </div>

    <!-- Rekomendasi Produk Terkait -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h4 class="mb-3">Produk Rekomendasi</h4>
            <div class="row">
                @foreach($relatedProducts as $related)
                <div class="col-md-3 col-6 mb-3">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ url('media/' . ($related->image ?? 'default.jpg')) }}" 
                             class="card-img-top" alt="{{ $related->name }}" 
                             style="height: 150px; object-fit: cover;">
                        <div class="card-body p-2">
                            <h6 class="card-title small">{{ Str::limit($related->name, 35) }}</h6>
                            <span class="fw-bold">
                                Rp {{ number_format($related->discount_price ?? $related->price, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="card-footer bg-white border-0 p-2">
                            <a href="{{ route('products.show', $related->slug) }}" class="btn btn-outline-primary btn-sm w-100">
                                Lihat
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Ulasan / Testimoni -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4>Ulasan Pelanggan</h4>
                
                @auth
                    @php
                        $userRating = App\Models\Rating::where('user_id', Auth::id())
                            ->where('product_id', $product->id)->first();
                        $canReview = !$userRating && \App\Models\Transaction::where('user_id', Auth::id())
                            ->where('status', 'delivered')
                            ->whereHas('details', function($q) use ($product) {
                                $q->where('product_id', $product->id);
                            })->exists();
                    @endphp
                    
                    @if($canReview)
                        <a href="{{ route('ratings.create', $product->id) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-star"></i> Beri Ulasan
                        </a>
                    @endif
                    
                    @if($userRating)
                        <a href="{{ route('ratings.edit', $userRating->id) }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-edit"></i> Edit Ulasan
                        </a>
                    @endif
                @endauth
            </div>

            @forelse($reviews as $review)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>{{ $review->user->name }}</strong>
                            <div class="mb-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-warning {{ $i <= $review->rating ? '' : 'opacity-25' }}" style="font-size: 0.8rem;"></i>
                                @endfor
                            </div>
                            <p class="mb-1">{{ $review->review }}</p>
                            <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="alert alert-info">
                Belum ada ulasan untuk produk ini. Jadilah yang pertama!
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection