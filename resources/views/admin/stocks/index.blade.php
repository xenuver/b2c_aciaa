@extends('layouts.admin')

@section('title', 'Kelola Stok')

@section('content')
<style>
*, *::before, *::after { box-sizing: border-box; }
.pm-page { padding: 1.5rem; }
.pm-topbar {
    display: flex; align-items: flex-start;
    justify-content: space-between;
    gap: 12px; flex-wrap: wrap;
    margin-bottom: 1.75rem;
}
.pm-title { font-size: 20px; font-weight: 700; color: var(--text-main, #831843); margin: 0 0 3px; }
.pm-subtitle { font-size: 13px; color: var(--primary-light, #F472B6); margin: 0; }

.btn-tambah {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 20px;
    background: linear-gradient(135deg, var(--primary, #DB2777), var(--cta, #CA8A04));
    color: #fff; font-size: 13px; font-weight: 600;
    border: none; border-radius: 10px; cursor: pointer;
    text-decoration: none;
    transition: background .15s, transform .1s, box-shadow .15s;
    box-shadow: 0 4px 15px rgba(219,39,119,0.3);
    white-space: nowrap;
}
.btn-tambah:hover {
    background: linear-gradient(135deg, var(--cta, #CA8A04), var(--primary, #DB2777));
    transform: translateY(-1px); color: #fff; text-decoration: none;
}

.pm-alert {
    display: flex; align-items: center; gap: 10px;
    background: #f0fdf4; border: 1px solid #bbf7d0;
    border-radius: 10px; padding: 12px 16px;
    font-size: 13px; color: #166534; margin-bottom: 1.5rem;
}
.pm-alert button {
    margin-left: auto; background: none; border: none;
    cursor: pointer; color: #16a34a; font-size: 18px; line-height: 1;
}

.pm-card {
    background: var(--glass-bg, #fff);
    border: 1px solid var(--glass-border, #E5E7EB);
    border-radius: 16px; overflow: hidden;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 15px rgba(219,39,119,0.03);
}
.pm-card-header {
    display: flex; align-items: center; justify-content: space-between;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--glass-border, #E5E7EB);
    background: #F9FAFB; flex-wrap: wrap; gap: 10px;
}
.pm-card-title { font-size: 14px; font-weight: 700; color: var(--text-main, #1F2937); }

.pm-filter-card {
    background: var(--glass-bg, #fff);
    border: 1px solid var(--glass-border, #E5E7EB);
    border-radius: 16px; overflow: hidden;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 15px rgba(219,39,119,0.03);
    margin-bottom: 1.5rem;
}
.pm-filter-card-header {
    padding: 1rem 1.5rem;
    border-bottom: 1px solid var(--glass-border, #E5E7EB);
    font-weight: 700; font-size: 0.85rem;
    color: var(--primary-light, #F472B6);
    text-transform: uppercase; letter-spacing: .04em;
    background: #F9FAFB;
}
.pm-filter-body { padding: 1.25rem 1.5rem; }

.pm-table { width: 100%; border-collapse: collapse; }
.pm-table thead th {
    font-size: 11px; font-weight: 700;
    color: var(--primary-light, #F472B6);
    text-transform: uppercase; letter-spacing: .06em;
    white-space: nowrap; padding: 10px 16px;
    background: #F9FAFB;
    border-bottom: 1px solid var(--glass-border, #E5E7EB);
    text-align: left;
}
.pm-table tbody td {
    padding: 13px 16px;
    border-bottom: 1px solid var(--glass-border, #E5E7EB);
    vertical-align: middle; font-size: 13px; color: #374151;
}
.pm-table tbody tr:last-child td { border-bottom: none; }
.pm-table tbody tr:hover td { background: rgba(244,114,182,0.04); }
.pm-table tbody tr.row-stock-out td { background: rgba(254,242,242,0.5); }
.pm-table tbody tr.row-stock-low td { background: rgba(255,251,235,0.5); }

.badge-pill {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; font-weight: 600;
    padding: 4px 10px; border-radius: 99px; white-space: nowrap;
}
.bp-ok     { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
.bp-low    { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
.bp-out    { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }

.btn-act {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 600;
    padding: 6px 12px; border-radius: 8px;
    cursor: pointer; text-decoration: none;
    transition: background .15s; white-space: nowrap; border: 1px solid;
}
.btn-act-edit { background: #fff; border-color: #e5e7eb; color: #374151; }
.btn-act-edit:hover { background: #f9fafb; border-color: #d1d5db; color: var(--text-main, #1F2937); text-decoration: none; }
.btn-act-hist { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
.btn-act-hist:hover { background: #dbeafe; border-color: #93c5fd; text-decoration: none; }

.pm-footer {
    display: flex; align-items: center;
    padding: .875rem 1.5rem;
    border-top: 1px solid var(--glass-border, #E5E7EB);
    background: #F9FAFB;
}
.pm-footer nav {
    display: flex; align-items: center;
    justify-content: space-between;
    width: 100%; gap: 16px;
}
.pm-footer .pagination { margin: 0 !important; padding: 0; display: flex; align-items: center; gap: 4px; list-style: none; }
.pm-footer .page-item .page-link {
    display: flex; align-items: center; justify-content: center;
    height: 32px; min-width: 32px; padding: 0 10px;
    font-size: 12px; font-weight: 500; border-radius: 8px !important;
    border: 1px solid #e5e7eb; color: #374151; background: #fff;
    transition: background .15s; text-decoration: none;
}
.pm-footer .page-item.active .page-link {
    background: linear-gradient(135deg, var(--primary, #DB2777), var(--primary-light, #FBCFE8));
    border-color: transparent; color: #fff;
}
.pm-footer .page-item.disabled .page-link { color: #d1d5db; pointer-events: none; }
.pm-footer .page-item .page-link:hover { background: #f3f4f6; }
</style>

<div class="pm-page">
    <div class="pm-topbar">
        <div>
            <h1 class="pm-title">Kelola Stok</h1>
            <p class="pm-subtitle">Monitor dan perbarui stok semua produk</p>
        </div>
        <button type="button" class="btn-tambah" data-bs-toggle="modal" data-bs-target="#bulkUpdateModal">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
            </svg>
            Bulk Update Stok
        </button>
    </div>

    @if(session('success'))
    <div class="pm-alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        {{ session('success') }}
        <button onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    {{-- Filter --}}
    <div class="pm-filter-card">
        <div class="pm-filter-card-header">Filter Stok</div>
        <div class="pm-filter-body">
            <form method="GET" action="{{ route('admin.stocks.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Cari Produk</label>
                    <input type="text" name="search" class="form-control" placeholder="Nama atau SKU"
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Kategori</label>
                    <select name="category_id" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
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
                <div class="col-md-4">
                    <div style="display:flex;gap:8px;">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('admin.stocks.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Stok --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <span class="pm-card-title">Daftar Stok Produk</span>
        </div>

        <div class="table-responsive">
            <table class="pm-table">
                <thead>
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
                    <tr class="{{ $product->stock == 0 ? 'row-stock-out' : ($product->stock < 10 ? 'row-stock-low' : '') }}">
                        <td style="font-family:'Fira Code',monospace;font-size:12px;color:#9ca3af;">{{ $product->id }}</td>
                        <td style="font-family:'Fira Code',monospace;font-size:12px;">{{ $product->sku ?? '—' }}</td>
                        <td style="font-weight:600;">{{ $product->name }}</td>
                        <td>
                            <span style="font-size:12px;padding:3px 10px;background:#f3f4f6;border-radius:99px;color:var(--primary-light,#F472B6);">
                                {{ $product->category->name ?? '—' }}
                            </span>
                        </td>
                        <td style="font-weight:600;white-space:nowrap;">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>
                        <td>
                            @if($product->stock == 0)
                                <span class="badge-pill bp-out">Habis</span>
                            @elseif($product->stock < 10)
                                <span class="badge-pill bp-low">{{ $product->stock }} — Menipis</span>
                            @else
                                <span class="badge-pill bp-ok">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td>{{ $product->sold_count ?? 0 }}</td>
                        <td>
                            <div style="display:flex;gap:6px;align-items:center;flex-wrap:wrap;">
                                <a href="{{ route('admin.stocks.edit', $product->id) }}" class="btn-act btn-act-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2.5"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                    Update
                                </a>
                                <a href="{{ route('admin.stocks.history', $product->id) }}" class="btn-act btn-act-hist">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24"
                                         fill="none" stroke="currentColor" stroke-width="2.5"
                                         stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="12 8 12 12 14 14"/>
                                        <path d="M3.05 11a9 9 0 1 0 .5-4.5"/>
                                        <polyline points="3 3 3 7 7 7"/>
                                    </svg>
                                    Riwayat
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pm-footer">
            {{ $products->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

{{-- Modal Bulk Update --}}
<div class="modal fade" id="bulkUpdateModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius:16px;border:1px solid var(--glass-border,#E5E7EB);overflow:hidden;">
            <form action="{{ route('admin.stocks.bulk-update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-header" style="background:#F9FAFB;border-bottom:1px solid var(--glass-border,#E5E7EB);">
                    <h5 class="modal-title" style="font-weight:700;font-size:15px;">Bulk Update Stok</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="text-muted" style="font-size:13px;margin-bottom:1rem;">
                        Update stok untuk produk yang ditampilkan di halaman ini
                    </p>
                    <div class="table-responsive" style="max-height: 400px;">
                        <table class="pm-table">
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
                                        <input type="number" name="products[{{ $loop->index }}][stock]"
                                               class="form-control form-control-sm"
                                               value="{{ $product->stock }}" style="width: 100px;" min="0">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer" style="border-top:1px solid var(--glass-border,#E5E7EB);">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Semua</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
