@extends('layouts.admin')

@section('title', 'Manajemen Produk')

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
.pm-title { font-size: 20px; font-weight: 700; color: #111827; margin: 0 0 3px; }
.pm-subtitle { font-size: 13px; color: #6b7280; margin: 0; }

.btn-tambah {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 20px;
    background: #16a34a;
    color: #fff;
    font-size: 13px; font-weight: 600;
    border: none; border-radius: 10px;
    cursor: pointer; text-decoration: none;
    transition: background .15s, transform .1s, box-shadow .15s;
    box-shadow: 0 1px 3px rgba(22,163,74,.35), 0 4px 12px rgba(22,163,74,.2);
    white-space: nowrap;
}
.btn-tambah:hover {
    background: #15803d;
    box-shadow: 0 2px 6px rgba(22,163,74,.4), 0 6px 16px rgba(22,163,74,.25);
    transform: translateY(-1px);
    color: #fff; text-decoration: none;
}
.btn-tambah:active { transform: translateY(0); }
.btn-tambah svg { flex-shrink: 0; }

.pm-alert {
    display: flex; align-items: center; gap: 10px;
    background: #f0fdf4; border: 1px solid #bbf7d0;
    border-radius: 10px; padding: 12px 16px;
    font-size: 13px; color: #166534;
    margin-bottom: 1.5rem;
}
.pm-alert button {
    margin-left: auto; background: none; border: none;
    cursor: pointer; color: #16a34a; font-size: 18px; line-height: 1;
}

.pm-stats { display: grid; grid-template-columns: repeat(4,1fr); gap: 12px; margin-bottom: 1.5rem; }
@media(max-width:768px){ .pm-stats { grid-template-columns: repeat(2,1fr); } }

.stat-card {
    background: #fff; border: 1px solid #e5e7eb;
    border-radius: 12px; padding: 1.1rem 1.25rem;
    transition: box-shadow .2s;
}
.stat-card:hover { box-shadow: 0 4px 12px rgba(0,0,0,.07); }
.stat-top { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 10px; }
.stat-icon {
    width: 36px; height: 36px; border-radius: 9px;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.stat-icon-blue  { background: #eff6ff; color: #2563eb; }
.stat-icon-green { background: #f0fdf4; color: #16a34a; }
.stat-icon-amber { background: #fffbeb; color: #d97706; }
.stat-icon-red   { background: #fef2f2; color: #dc2626; }
.stat-label { font-size: 12px; color: #6b7280; font-weight: 500; text-transform: uppercase; letter-spacing: .04em; margin-bottom: 4px; }
.stat-val { font-size: 28px; font-weight: 700; color: #111827; line-height: 1; margin-bottom: 6px; }
.stat-badge {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; font-weight: 500; padding: 3px 8px; border-radius: 99px;
}
.sb-green { background: #dcfce7; color: #166534; }
.sb-amber { background: #fef3c7; color: #92400e; }
.sb-red   { background: #fee2e2; color: #991b1b; }
.sb-blue  { background: #dbeafe; color: #1e40af; }

.pm-card {
    background: #fff; border: 1px solid #e5e7eb;
    border-radius: 14px; overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
}
.pm-card-header {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f3f4f6;
    flex-wrap: wrap; gap: 10px;
}
.pm-card-title { font-size: 14px; font-weight: 700; color: #111827; }

.pm-filters { display: flex; align-items: center; gap: 8px; flex-wrap: wrap; }
.search-wrap { position: relative; display: flex; align-items: center; }
.search-wrap svg {
    position: absolute; left: 10px;
    pointer-events: none; color: #9ca3af;
    width: 15px; height: 15px;
}
.search-input {
    padding: 7px 12px 7px 32px;
    font-size: 13px; color: #374151;
    border: 1px solid #e5e7eb;
    border-radius: 9px; background: #f9fafb;
    width: 210px; outline: none;
    transition: border-color .15s, background .15s;
}
.search-input:focus { border-color: #6ee7b7; background: #fff; box-shadow: 0 0 0 3px rgba(22,163,74,.1); }
.pm-select {
    padding: 7px 28px 7px 10px;
    font-size: 13px; color: #374151;
    border: 1px solid #e5e7eb; border-radius: 9px;
    background: #f9fafb url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 8px center;
    appearance: none; outline: none; cursor: pointer;
    transition: border-color .15s;
}
.pm-select:focus { border-color: #6ee7b7; background-color: #fff; box-shadow: 0 0 0 3px rgba(22,163,74,.1); }

.pm-table { width: 100%; border-collapse: collapse; }
.pm-table thead th {
    font-size: 11px; font-weight: 700; color: #6b7280;
    text-transform: uppercase; letter-spacing: .06em;
    white-space: nowrap; padding: 10px 16px;
    background: #f9fafb; border-bottom: 1px solid #f3f4f6;
    text-align: left;
}
.pm-table tbody td {
    padding: 13px 16px; border-bottom: 1px solid #f3f4f6;
    vertical-align: middle; font-size: 13px; color: #374151;
}
.pm-table tbody tr:last-child td { border-bottom: none; }
.pm-table tbody tr:hover td { background: #fafafa; }

.prod-thumb {
    width: 44px; height: 44px; border-radius: 9px;
    object-fit: cover; border: 1px solid #e5e7eb; flex-shrink: 0;
}
.prod-thumb-placeholder {
    width: 44px; height: 44px; border-radius: 9px;
    background: #f3f4f6; border: 1px solid #e5e7eb;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.prod-name { font-weight: 600; color: #111827; font-size: 13px; line-height: 1.3; }
.prod-id   { font-size: 11px; color: #9ca3af; margin-top: 2px; }

.price-original { font-size: 11px; color: #9ca3af; text-decoration: line-through; line-height: 1.5; }
.price-discount { font-size: 13px; font-weight: 700; color: #dc2626; }
.price-normal   { font-size: 13px; font-weight: 600; color: #111827; }

.stock-ok  { font-weight: 600; color: #16a34a; }
.stock-low { font-weight: 700; color: #dc2626; }
.stock-warn-text { font-size: 10px; color: #dc2626; margin-top: 1px; }

.badge-pill {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; font-weight: 600;
    padding: 3px 9px; border-radius: 99px; white-space: nowrap;
}
.bp-active   { background: #dcfce7; color: #166534; }
.bp-inactive { background: #fee2e2; color: #991b1b; }
.bp-promo    { background: #fef3c7; color: #92400e; }
.dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.dot-green { background: #16a34a; }
.dot-red   { background: #dc2626; }

.cat-pill {
    font-size: 12px; padding: 3px 10px;
    background: #f3f4f6; border-radius: 99px;
    color: #6b7280; white-space: nowrap;
}

.btn-act {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 600;
    padding: 6px 12px; border-radius: 8px;
    cursor: pointer; text-decoration: none;
    transition: background .15s, color .15s;
    white-space: nowrap; border: 1px solid;
}
.btn-act-edit { background: #fff; border-color: #e5e7eb; color: #374151; }
.btn-act-edit:hover { background: #f9fafb; border-color: #d1d5db; color: #111827; text-decoration: none; }
.btn-act-del  { background: #fff0f0; border-color: #fecaca; color: #dc2626; }
.btn-act-del:hover { background: #fee2e2; border-color: #fca5a5; }

/* ── Footer ── */
.pm-footer {
    display: flex;
    align-items: center;
    padding: .875rem 1.25rem;
    border-top: 1px solid #f3f4f6;
    min-height: 56px;
}
.pm-footer nav {
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    gap: 16px;
}
.pm-footer nav > p {
    font-size: 12px;
    color: #6b7280;
    margin: 0;
    white-space: nowrap;
    line-height: 1;
}
.pm-footer nav > p strong {
    color: #374151;
    font-weight: 600;
}
.pm-footer .pagination {
    margin: 0 !important;
    padding: 0;
    display: flex;
    align-items: center;
    gap: 4px;
    list-style: none;
}
.pm-footer .page-item { display: flex; align-items: center; }
.pm-footer .page-item .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 32px;
    min-width: 32px;
    padding: 0 10px;
    font-size: 12px;
    font-weight: 500;
    line-height: 1;
    border-radius: 8px !important;
    border: 1px solid #e5e7eb;
    color: #374151;
    background: #fff;
    transition: background .15s;
    text-decoration: none;
}
.pm-footer .page-item.active .page-link {
    background: #16a34a;
    border-color: #16a34a;
    color: #fff;
}
.pm-footer .page-item.disabled .page-link {
    color: #d1d5db;
    pointer-events: none;
}
.pm-footer .page-item .page-link:hover {
    background: #f3f4f6;
}

.empty-state { text-align: center; padding: 3.5rem 1rem; color: #9ca3af; }
.empty-state p { margin: .5rem 0 0; font-size: 14px; }
</style>

<div class="pm-page">

    {{-- Top bar --}}
    <div class="pm-topbar">
        <div>
            <h1 class="pm-title">Manajemen Produk</h1>
            <p class="pm-subtitle">Kelola semua produk toko Anda</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn-tambah">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2.5"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Tambah Produk
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="pm-alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        {{ session('success') }}
        <button onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    {{-- Stat cards --}}
    <div class="pm-stats">
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Total Produk</div>
                    <div class="stat-val">{{ $products->total() }}</div>
                </div>
                <div class="stat-icon stat-icon-blue">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                    </svg>
                </div>
            </div>
            <span class="stat-badge sb-blue">Semua kategori</span>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Produk Aktif</div>
                    <div class="stat-val">{{ $products->getCollection()->where('is_active', true)->count() }}</div>
                </div>
                <div class="stat-icon stat-icon-green">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                </div>
            </div>
            <span class="stat-badge sb-green">
                <span class="dot dot-green"></span> Aktif
            </span>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Sedang Promo</div>
                    <div class="stat-val">{{ $products->getCollection()->where('is_promo', true)->count() }}</div>
                </div>
                <div class="stat-icon stat-icon-amber">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                        <line x1="7" y1="7" x2="7.01" y2="7"/>
                    </svg>
                </div>
            </div>
            <span class="stat-badge sb-amber">Diskon aktif</span>
        </div>
        <div class="stat-card">
            <div class="stat-top">
                <div>
                    <div class="stat-label">Stok Menipis</div>
                    <div class="stat-val">{{ $products->getCollection()->where('stock', '<', 10)->count() }}</div>
                </div>
                <div class="stat-icon stat-icon-red">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                        <line x1="12" y1="9" x2="12" y2="13"/>
                        <line x1="12" y1="17" x2="12.01" y2="17"/>
                    </svg>
                </div>
            </div>
            <span class="stat-badge sb-red">
                <span class="dot dot-red"></span> Perlu restock
            </span>
        </div>
    </div>

    {{-- Table card --}}
    <div class="pm-card">

        {{-- Card header --}}
        <div class="pm-card-header">
            <span class="pm-card-title">Daftar Produk</span>
            <div class="pm-filters">
                <div class="search-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" class="search-input" placeholder="Cari produk...">
                </div>
                <select class="pm-select">
                    <option value="">Semua Kategori</option>
                </select>
                <select class="pm-select">
                    <option value="">Semua Status</option>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                    <option value="promo">Promo</option>
                </select>
            </div>
        </div>

        {{-- Table --}}
        <div class="table-responsive">
            <table class="pm-table">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                    <tr>
                        {{-- Produk --}}
                        <td>
                            <div style="display:flex;align-items:center;gap:12px">
                                @if($product->image)
                                    <img src="{{ url('render-image?path=' . $product->image) }}"
                                         class="prod-thumb" alt="{{ $product->name }}">
                                @else
                                    <div class="prod-thumb-placeholder">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                             viewBox="0 0 24 24" fill="none" stroke="#d1d5db"
                                             stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <rect x="3" y="3" width="18" height="18" rx="2"/>
                                            <circle cx="8.5" cy="8.5" r="1.5"/>
                                            <polyline points="21 15 16 10 5 21"/>
                                        </svg>
                                    </div>
                                @endif
                                <div>
                                    <div class="prod-name">{{ $product->name }}</div>
                                    <div class="prod-id">#PRD-{{ str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</div>
                                </div>
                            </div>
                        </td>

                        {{-- Kategori --}}
                        <td><span class="cat-pill">{{ $product->category->name ?? '-' }}</span></td>

                        {{-- Harga --}}
                        <td>
                            @if($product->discount_price)
                                <div class="price-original">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                <div class="price-discount">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</div>
                            @else
                                <div class="price-normal">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                            @endif
                        </td>

                        {{-- Stok --}}
                        <td>
                            <span class="{{ $product->stock < 10 ? 'stock-low' : 'stock-ok' }}">
                                {{ $product->stock }}
                            </span>
                            @if($product->stock < 10)
                                <div class="stock-warn-text">Stok menipis</div>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td>
                            <div style="display:flex;flex-wrap:wrap;gap:4px;align-items:center">
                                @if($product->is_active)
                                    <span class="badge-pill bp-active">
                                        <span class="dot dot-green"></span> Aktif
                                    </span>
                                @else
                                    <span class="badge-pill bp-inactive">
                                        <span class="dot dot-red"></span> Nonaktif
                                    </span>
                                @endif
                                @if($product->is_promo)
                                    <span class="badge-pill bp-promo">Promo</span>
                                @endif
                            </div>
                        </td>

                        {{-- Aksi --}}
                        <td>
                            <div style="display:flex;gap:6px;align-items:center">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-act btn-act-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}"
                                      method="POST" style="margin:0;display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-act btn-act-del"
                                        onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                            <path d="M10 11v6M14 11v6"/>
                                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"
                                     viewBox="0 0 24 24" fill="none" stroke="#d1d5db"
                                     stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                                </svg>
                                <p>Belum ada produk tersedia.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer — cukup render links(), teks "Showing..." sudah ada di dalam <nav> Bootstrap --}}
        <div class="pm-footer">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>

    </div>
</div>
@endsection