@extends('layouts.app')

@section('title', 'Ulasan Saya')

@section('content')
<style>
    :root {
        --pd-pink: #d4a5a5;
        --pd-pink-2: #b5838d;
        --pd-soft: #fef6f5;
        --pd-dark: #111111;
        --pd-border: #ede6e4;
        --pd-success: #38a169;
        --pd-warning: #eab308;
        --pd-shadow-soft: 0 10px 30px rgba(212, 165, 165, 0.08);
        --pd-shadow-hover: 0 15px 40px rgba(212, 165, 165, 0.15);
    }

    .rating-page-container {
        font-family: 'Poppins', 'Inter', sans-serif;
        color: var(--pd-dark);
    }

    .rating-card {
        border: 1px solid var(--pd-border);
        border-radius: 20px;
        background: #ffffff;
        box-shadow: var(--pd-shadow-soft);
        transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        overflow: hidden;
    }

    .rating-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--pd-shadow-hover);
        border-color: var(--pd-pink);
    }

    .product-img {
        width: 90px;
        height: 90px;
        object-fit: cover;
        border-radius: 12px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05);
    }

    .status-badge {
        font-size: 0.72rem;
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 50px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }

    .status-approved {
        background: #f0fff4;
        color: var(--pd-success);
        border: 1px solid rgba(56, 161, 105, 0.2);
    }

    .status-moderation {
        background: #fffbeb;
        color: var(--pd-warning);
        border: 1px solid rgba(234, 179, 8, 0.2);
    }

    .stars-display i {
        color: #fbbf24;
        font-size: 0.85rem;
    }

    .btn-action-edit {
        background: var(--pd-soft);
        color: var(--pd-pink-2);
        border: 1px solid rgba(181, 131, 141, 0.2);
        font-weight: 600;
        font-size: 0.8rem;
        padding: 8px 16px;
        border-radius: 50px;
        transition: all 0.2s;
    }
    .btn-action-edit:hover {
        background: var(--pd-pink-2);
        color: #ffffff;
    }

    .btn-action-del {
        background: #fff5f5;
        color: #e53e3e;
        border: 1px solid rgba(229, 62, 62, 0.2);
        font-weight: 600;
        font-size: 0.8rem;
        padding: 8px 16px;
        border-radius: 50px;
        transition: all 0.2s;
    }
    .btn-action-del:hover {
        background: #e53e3e;
        color: #ffffff;
    }

    .btn-action-view {
        background: #111111;
        color: #ffffff;
        border: none;
        font-weight: 600;
        font-size: 0.8rem;
        padding: 8px 16px;
        border-radius: 50px;
        transition: all 0.2s;
    }
    .btn-action-view:hover {
        background: #2a2a2a;
        color: #ffffff;
    }

    .admin-reply-box {
        background: #f8fafc;
        border-left: 3px solid var(--pd-pink-2);
        border-radius: 6px;
        padding: 12px 16px;
        margin-top: 14px;
        font-size: 0.82rem;
    }

    .reply-title {
        font-weight: 700;
        color: #475569;
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .reply-body {
        color: #334155;
        font-style: italic;
    }

    .empty-state {
        text-align: center;
        padding: 5rem 2rem;
        border: 2px dashed var(--pd-border);
        border-radius: 24px;
        background: #ffffff;
        box-shadow: var(--pd-shadow-soft);
    }
</style>

<div class="container my-5 rating-page-container">
    {{-- Header --}}
    <div class="row mb-5">
        <div class="col-12 text-center text-md-start">
            <span class="text-uppercase text-muted fw-bold small tracking-wider" style="letter-spacing: 1px;">Riwayat Aktivitas</span>
            <h2 class="fw-extrabold text-dark m-0 mt-1">Ulasan Saya</h2>
            <p class="text-muted mb-0">Kelola dan lihat ulasan yang telah Anda berikan untuk produk kami</p>
        </div>
    </div>



    @if($ratings->count() > 0)
        <div class="row g-4">
            @foreach($ratings as $rating)
            <div class="col-lg-6">
                <div class="card rating-card p-4 h-100 d-flex flex-column justify-content-between">
                    <div>
                        {{-- Card Header: Product & Image --}}
                        <div class="d-flex gap-3 pb-3 border-bottom mb-3 flex-wrap flex-sm-nowrap">
                            <img src="{{ asset('storage/' . ($rating->product->image ?? 'default.jpg')) }}" 
                                 class="product-img" alt="{{ $rating->product->name }}">
                            <div class="flex-grow-1 text-start">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-1">
                                    <h6 class="fw-bold mb-0 text-dark text-truncate-2" style="font-size: 1rem; max-width: 80%;">{{ $rating->product->name }}</h6>
                                    @if($rating->is_approved)
                                        <span class="status-badge status-approved">
                                            <i class="fas fa-check-circle"></i> Publik
                                        </span>
                                    @else
                                        <span class="status-badge status-moderation">
                                            <i class="fas fa-clock"></i> Moderasi
                                        </span>
                                    @endif
                                </div>
                                <div class="stars-display mb-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="{{ $i <= $rating->rating ? 'fas' : 'far' }} fa-star"></i>
                                    @endfor
                                    <span class="text-muted small ms-1" style="font-size: 0.75rem;">({{ $rating->created_at->diffForHumans() }})</span>
                                </div>
                                <div style="font-size: 0.8rem; color: #6b7280;">
                                    Invoice: <strong class="text-dark">{{ $rating->transaction->invoice_number ?? '-' }}</strong>
                                </div>
                            </div>
                        </div>

                        {{-- Card Content: Review text --}}
                        <div class="text-start">
                            <p class="mb-3 text-dark-gray" style="font-size: 0.88rem; line-height: 1.6; word-break: break-word;">{{ $rating->review }}</p>

                            {{-- Review Uploaded Images --}}
                            @if($rating->images && count($rating->images) > 0)
                            <div class="d-flex gap-2 mb-3">
                                @foreach($rating->images as $img)
                                <a href="{{ asset('storage/' . $img) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $img) }}" alt="Foto ulasan {{ $rating->product->name }}" style="width: 55px; height: 55px; object-fit: cover; border-radius: 8px; border: 1px solid var(--pd-border);">
                                </a>
                                @endforeach
                            </div>
                            @endif

                            {{-- Admin Reply if exists --}}
                            @if($rating->admin_reply)
                            <div class="admin-reply-box">
                                <div class="reply-title">
                                    <i class="fas fa-reply text-muted"></i> Balasan Penjual:
                                </div>
                                <div class="reply-body">
                                    "{{ $rating->admin_reply }}"
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>

                    {{-- Actions Row --}}
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top gap-2 flex-wrap">
                        <a href="{{ route('products.show', $rating->product->slug) }}" class="btn-action-view text-decoration-none">
                            <i class="far fa-eye me-1"></i> Detail Produk
                        </a>
                        <div class="d-flex gap-2">
                            <a href="{{ route('ratings.edit', $rating->id) }}" class="btn-action-edit text-decoration-none">
                                <i class="far fa-edit me-1"></i> Edit
                            </a>
                            <form action="{{ route('ratings.destroy', $rating->id) }}" method="POST" style="margin:0;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-del" onclick="return confirm('Apakah Anda yakin ingin menghapus ulasan ini secara permanen?')">
                                    <i class="far fa-trash-alt me-1"></i> Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="d-flex justify-content-center mt-5">
            {{ $ratings->links('pagination::bootstrap-5') }}
        </div>
    @else
        {{-- Empty State --}}
        <div class="empty-state">
            <div class="mb-4">
                <i class="far fa-comment-alt fa-4x text-muted" style="opacity: 0.3;"></i>
            </div>
            <h4 class="fw-bold text-dark mb-2">Belum Ada Ulasan</h4>
            <p class="text-muted small mb-4 px-lg-5">Anda belum memberikan ulasan atau rating untuk produk apa pun. Bagikan pengalaman berbelanja Anda setelah menerima pesanan!</p>
            <a href="{{ route('products.index') }}" class="btn btn-primary px-4 py-2.5 rounded-pill" style="background: linear-gradient(135deg, var(--pd-pink), var(--pd-pink-2)); border: none; font-weight: 700;">
                <i class="fas fa-shopping-bag me-2"></i> Belanja Sekarang
            </a>
        </div>
    @endif
</div>
@endsection