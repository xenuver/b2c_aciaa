@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@push('styles')
<style>
    :root{
        --ck-pink: #d4a5a5;
        --ck-pink-2: #b5838d;
        --ck-soft: #fef6f5;
        --ck-dark: #1a1a1a;
    }

    .order-item-card {
        border: 1px solid #ede6e4;
        border-radius: 16px;
        background: #ffffff;
        transition: all 0.25s ease;
        margin-bottom: 20px;
        overflow: hidden;
    }
    
    .order-item-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(212,165,165,0.15);
        border-color: var(--ck-pink);
    }

    .order-card-header {
        background: var(--ck-soft);
        padding: 14px 20px;
        border-bottom: 1px solid rgba(212, 165, 165, 0.2);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
    }

    .order-invoice {
        font-weight: 700;
        color: var(--ck-dark);
        font-size: 0.95rem;
    }

    .order-date {
        color: #718096;
        font-size: 0.85rem;
    }

    .order-status-badge {
        font-weight: 600;
        font-size: 0.75rem;
        padding: 5px 12px;
        border-radius: 50px;
    }

    .order-body {
        padding: 20px;
    }

    .order-product-img {
        width: 70px;
        height: 70px;
        object-fit: cover;
        border-radius: 12px;
        border: 1px solid #f0f0f0;
    }

    .order-product-name {
        font-weight: 700;
        color: var(--ck-dark);
        font-size: 0.95rem;
        margin-bottom: 4px;
    }

    .order-footer {
        padding: 14px 20px;
        background: #ffffff;
        border-top: 1px dashed #ede6e4;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .order-total-label {
        font-size: 0.8rem;
        color: #718096;
        margin-bottom: 2px;
    }

    .order-total-price {
        font-weight: 800;
        font-size: 1.15rem;
        color: var(--ck-pink-2);
    }

    .btn-detail {
        background: linear-gradient(135deg, var(--ck-pink), var(--ck-pink-2));
        color: white;
        font-weight: 600;
        border-radius: 50px;
        padding: 8px 20px;
        font-size: 0.85rem;
        transition: all 0.2s ease;
        text-decoration: none;
        border: none;
    }

    .btn-detail:hover {
        box-shadow: 0 4px 12px rgba(181, 131, 141, 0.25);
        color: white;
        transform: translateY(-1px);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 20px;
        border: 1px dashed #d4a5a5;
    }

    .btn-shop {
        background: var(--ck-dark);
        color: white;
        font-weight: 600;
        padding: 12px 28px;
        border-radius: 50px;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-block;
        margin-top: 15px;
    }
    .btn-shop:hover {
        background: #2d2d2d;
        color: white;
        transform: translateY(-1px);
    }
    
    .pagination {
        gap: 6px;
    }
    
    .pagination .page-link {
        border: 1px solid #ede6e4;
        color: var(--ck-dark);
        border-radius: 8px;
        padding: 8px 16px;
    }
    
    .pagination .page-item.active .page-link {
        background: var(--ck-pink-2);
        border-color: var(--ck-pink-2);
        color: white;
    }
    
    .pagination .page-link:hover {
        background: var(--ck-soft);
        color: var(--ck-pink-2);
    }
</style>
@endpush

@section('content')
<div class="container my-5" style="max-width: 800px;">
    <h2 class="mb-4 fw-bold text-gray-800"><i class="fas fa-history text-primary me-2"></i>Riwayat Transaksi</h2>
    
    @if($transactions->count() > 0)
        <div class="transaction-list">
            @foreach($transactions as $transaction)
                <div class="order-item-card">
                    <!-- Card Header -->
                    <div class="order-card-header">
                        <div class="d-flex align-items-center gap-2">
                            <span class="order-invoice">{{ $transaction->invoice_number }}</span>
                            <span class="text-muted d-none d-sm-inline">•</span>
                            <span class="order-date"><i class="far fa-calendar-alt me-1"></i>{{ $transaction->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        
                        <div>
                            @php
                                $statusBadgeColor = match($transaction->status) {
                                    'pending' => 'bg-warning text-dark',
                                    'processing' => 'bg-info text-dark',
                                    'shipped' => 'bg-primary text-white',
                                    'delivered' => 'bg-success text-white',
                                    'cancelled' => 'bg-danger text-white',
                                    default => 'bg-secondary text-white',
                                };
                                $paymentBadgeColor = match($transaction->payment_status) {
                                    'unpaid' => 'bg-danger-subtle text-danger border border-danger',
                                    'pending' => 'bg-warning-subtle text-warning border border-warning',
                                    'paid' => 'bg-success-subtle text-success border border-success',
                                    'failed' => 'bg-danger-subtle text-danger border border-danger',
                                    'expired' => 'bg-secondary-subtle text-secondary border border-secondary',
                                    default => 'bg-secondary-subtle text-secondary',
                                };
                            @endphp
                            <span class="badge {{ $statusBadgeColor }} order-status-badge me-1">{{ ucfirst($transaction->status) }}</span>
                            <span class="badge {{ $paymentBadgeColor }} px-2.5 py-1.5 rounded-pill" style="font-size: 0.7rem; font-weight:600;">{{ ucfirst($transaction->payment_status) }}</span>
                        </div>
                    </div>
                    
                    <!-- Card Body -->
                    <div class="order-body">
                        @php
                            $firstDetail = $transaction->details->first();
                            $extraProductsCount = $transaction->details->count() - 1;
                        @endphp
                        
                        @if($firstDetail)
                            <div class="d-flex align-items-center gap-3">
                                @if($firstDetail->product && $firstDetail->product->image)
                                    <img src="{{ asset('storage/' . $firstDetail->product->image) }}" class="order-product-img" alt="{{ $firstDetail->product->name }}">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                                        <i class="fas fa-image text-muted"></i>
                                    </div>
                                @endif
                                
                                <div class="flex-grow-1">
                                    <h6 class="order-product-name">{{ $firstDetail->product->name ?? 'Produk Dihapus' }}</h6>
                                    <p class="text-muted small mb-0">{{ $firstDetail->quantity }} barang x Rp {{ number_format($firstDetail->price, 0, ',', '.') }}</p>
                                    
                                    @if($extraProductsCount > 0)
                                        <p class="text-muted small mb-0 mt-1 fw-medium"><i class="fas fa-plus-circle me-1"></i>+{{ $extraProductsCount }} produk lainnya</p>
                                    @endif
                                </div>
                            </div>
                        @else
                            <p class="text-muted mb-0 small">Detail produk tidak tersedia.</p>
                        @endif
                    </div>
                    
                    <!-- Card Footer -->
                    <div class="order-footer">
                        <div>
                            <div class="order-total-label">Total Belanja</div>
                            <div class="order-total-price">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            @if($transaction->status === 'pending' && in_array($transaction->payment_status, ['unpaid', 'pending']) && !$transaction->isPaymentExpired())
                                <a href="{{ route('transactions.show', $transaction->id) }}?pay=1" class="btn-detail py-2 px-3">
                                    <i class="fas fa-credit-card me-1"></i> Lanjutkan Pembayaran
                                </a>
                                <a href="{{ route('transactions.show', $transaction->id) }}" class="btn-outline-pink py-1.5 px-3" style="font-size: 0.85rem;">
                                    Detail
                                </a>
                            @else
                                <a href="{{ route('transactions.show', $transaction->id) }}" class="btn-detail">
                                    Lihat Detail Pesanan
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            
            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $transactions->links() }}
            </div>
        </div>
    @else
        <div class="empty-state">
            <i class="fas fa-receipt fa-4x mb-3 text-muted" style="color: var(--ck-pink) !important; opacity: 0.5;"></i>
            <h4 class="fw-bold mb-2">Belum Ada Transaksi</h4>
            <p class="text-muted small">Anda belum melakukan transaksi belanja apapun di ACIAA.</p>
            <a href="{{ route('products.index') }}" class="btn-shop">
                Mulai Belanja Sekarang
            </a>
        </div>
    @endif
</div>
@endsection