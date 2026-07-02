@extends('layouts.admin')

@section('title', 'Kelola Stok')

@section('styles')
<style>
    .pagination {
        margin-bottom: 0;
        gap: 5px;
    }
    .page-link {
        border-radius: 8px !important;
        color: #2c3e50;
        padding: 8px 14px;
    }
    .page-item.active .page-link {
        background-color: #2c3e50;
        border-color: #2c3e50;
        color: white;
    }
    .stock-low {
        background-color: #fff3cd !important;
    }
    .stock-out {
        background-color: #f8d7da !important;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Kelola Stok</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#bulkUpdateModal">
            <i class="fas fa-edit"></i> Bulk Update Stok
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.stocks.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Cari Produk</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama atau SKU" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Filter Stok</label>
                    <select name="low_stock" class="form-select">
                        <option value="">Semua</option>
                        <option value="1" {{ request('low_stock') ? 'selected' : '' }}>Stok Menipis (&lt;10)</option>
                        <option value="out" {{ request('out_of_stock') ? 'selected' : '' }}>Stok Habis (0)</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.stocks.index') }}" class="btn btn-secondary">
                        <i class="fas fa-sync"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Stok -->
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th width="50">ID</th>
                        <th>SKU</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok Saat Ini</th>
                        <th>Terjual</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                    <tr class="@if($product->stock == 0) stock-out @elseif($product->stock < 10) stock-low @endif">
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->sku ?? '-' }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            @if($product->stock == 0)
                                <span class="badge bg-danger">Habis</span>
                            @elseif($product->stock < 10)
                                <span class="badge bg-warning">{{ $product->stock }}</span>
                            @else
                                <span class="badge bg-success">{{ $product->stock }}</span>
                            @endif
                         </td>
                        <td>{{ $product->sold_count ?? 0 }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.stocks.edit', $product->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i> Update
                                </a>
                                <a href="{{ route('admin.stocks.history', $product->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-history"></i> Riwayat
                                </a>
                            </div>
                         </td>
                     </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Bulk Update -->
<div class="modal fade" id="bulkUpdateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form action="{{ route('admin.stocks.bulk-update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Bulk Update Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted">Update stok untuk produk yang ditampilkan di halaman ini</p>
                    <div class="table-responsive" style="max-height: 400px;">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Stok Saat Ini</th>
                                    <th>Stok Baru</th>
                                 </tr>
                            </thead>
                            <tbody>
                                @foreach($products as $product)
                                 <tr>
                                     <td>{{ $product->name }}</td>
                                     <td>{{ $product->stock }}</td>
                                     <td>
                                        <input type="hidden" name="products[{{ $loop->index }}][id]" value="{{ $product->id }}">
                                        <input type="number" name="products[{{ $loop->index }}][stock]" class="form-control form-control-sm" value="{{ $product->stock }}" style="width: 100px;">
                                     </td>
                                 </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Semua</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection