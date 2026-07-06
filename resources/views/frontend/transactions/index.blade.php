@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@push('styles')
<style>
    :root{
        --ck-pink: var(--color-primary);
        --ck-pink-2: var(--color-primary-light);
        --ck-soft: var(--color-surface-alt);
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
        border: 1px dashed var(--color-primary);
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
    
    .nav-pills .nav-link {
        color: #718096;
        border: 1px solid #ede6e4;
        white-space: nowrap;
        font-size: 0.9rem;
        transition: all 0.2s;
    }
    .nav-pills .nav-link.active {
        background: var(--color-primary);
        color: white;
        border-color: var(--color-primary);
        box-shadow: 0 4px 12px rgba(194, 24, 91, 0.2);
    }
    .nav-pills .nav-link:hover:not(.active) {
        background: var(--color-surface-alt);
        color: var(--color-primary);
    }
</style>
@endpush

@section('content')
<div class="container my-4" style="max-width: 900px;">
    <!-- Hero Banner -->
    <div class="mb-4 rounded-4 px-4 py-5" style="background: linear-gradient(135deg, #111111 0%, #1a1a1a 50%, #2a2a2a 100%); position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <div style="position: absolute; top: -50px; right: -50px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(194,24,91,0.2) 0%, transparent 70%); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -30px; left: 10%; width: 150px; height: 150px; background: radial-gradient(circle, rgba(233,30,140,0.1) 0%, transparent 70%); border-radius: 50%;"></div>
        <h1 class="text-white mb-2 position-relative" style="font-family: var(--font-heading, 'Cormorant', serif); font-size: 2.2rem;"><i class="fas fa-history me-3" style="color: var(--color-primary);"></i>Riwayat Transaksi</h1>
        <p class="text-white-50 mb-0 position-relative" style="font-size: 0.95rem;">Lacak, kelola, dan pantau semua pesanan Anda</p>
    </div>
    
    <div x-data="transactionFilter()" class="mb-4">
        <div class="row g-3 align-items-center mb-3">
            <div class="col-12">
                <div x-show="loading" x-cloak class="d-inline-flex align-items-center">
                    <div class="spinner-border text-primary spinner-border-sm me-2" role="status"></div>
                    <span class="small text-muted">Memuat...</span>
                </div>
            </div>
        </div>

        <div class="nav-pills-wrapper overflow-auto pb-2" style="scrollbar-width: none;">
            <ul class="nav nav-pills flex-nowrap" style="gap: 8px;">
                <li class="nav-item"><a href="#" class="nav-link rounded-pill px-4" :class="status === 'all' ? 'active' : ''" @click.prevent="status = 'all'; fetchData()">Semua</a></li>
                <li class="nav-item"><a href="#" class="nav-link rounded-pill px-4" :class="status === 'pending' ? 'active' : ''" @click.prevent="status = 'pending'; fetchData()">Menunggu Pembayaran</a></li>
                <li class="nav-item"><a href="#" class="nav-link rounded-pill px-4" :class="status === 'processing' ? 'active' : ''" @click.prevent="status = 'processing'; fetchData()">Diproses</a></li>
                <li class="nav-item"><a href="#" class="nav-link rounded-pill px-4" :class="status === 'shipped' ? 'active' : ''" @click.prevent="status = 'shipped'; fetchData()">Dikirim</a></li>
                <li class="nav-item"><a href="#" class="nav-link rounded-pill px-4" :class="status === 'delivered' ? 'active' : ''" @click.prevent="status = 'delivered'; fetchData()">Selesai</a></li>
                <li class="nav-item"><a href="#" class="nav-link rounded-pill px-4" :class="status === 'cancelled' ? 'active' : ''" @click.prevent="status = 'cancelled'; fetchData()">Dibatalkan</a></li>
            </ul>
        </div>
    </div>
    <div id="transactionsContainer" style="position: relative;">
        @include('frontend.transactions.partials.list')
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('transactionFilter', () => ({
        status: 'all',
        loading: false,
        
        fetchData(url = '{{ route("transactions.index") }}') {
            this.loading = true;
            
            const urlObj = new URL(url, window.location.origin);
            if (this.status !== 'all') urlObj.searchParams.set('status', this.status);
            
            axios.get(urlObj.toString(), {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                document.getElementById('transactionsContainer').innerHTML = response.data;
                this.setupPagination();
            })
            .catch(error => {
                console.error('Error fetching transactions:', error);
            })
            .finally(() => {
                this.loading = false;
            });
        },
        
        setupPagination() {
            const container = document.getElementById('transactionsContainer');
            if (!container) return;
            const links = container.querySelectorAll('.ajax-pagination a');
            links.forEach(link => {
                link.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.fetchData(link.href);
                });
            });
        },
        
        init() {
            this.setupPagination();
        }
    }));
});
</script>
@endpush