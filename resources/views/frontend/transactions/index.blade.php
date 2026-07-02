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
    
    <div x-data="transactionFilter()" class="mb-4">
        <div class="row g-2">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="fas fa-search"></i></span>
                    <input type="text" x-model="search" @input.debounce.500ms="fetchData()" class="form-control border-start-0 rounded-end-3 px-0" placeholder="Cari nomor invoice...">
                </div>
            </div>
            <div class="col-md-4">
                <select x-model="status" @change="fetchData()" class="form-select rounded-3">
                    <option value="all">Semua Status</option>
                    <option value="pending">Menunggu Pembayaran</option>
                    <option value="processing">Diproses</option>
                    <option value="shipped">Dikirim</option>
                    <option value="delivered">Selesai</option>
                    <option value="cancelled">Dibatalkan</option>
                </select>
            </div>
            <div class="col-md-2">
                <div x-show="loading" class="d-flex align-items-center h-100" style="display: none;">
                    <div class="spinner-border text-primary spinner-border-sm me-2" role="status"></div>
                    <span class="small text-muted">Memuat...</span>
                </div>
            </div>
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
        search: '',
        status: 'all',
        loading: false,
        
        fetchData(url = '{{ route("transactions.index") }}') {
            this.loading = true;
            
            const urlObj = new URL(url, window.location.origin);
            if (this.search) urlObj.searchParams.set('search', this.search);
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