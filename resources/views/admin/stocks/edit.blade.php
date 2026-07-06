@extends('layouts.admin')

@section('title', 'Update Stok - ' . $product->name)

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
.pm-form-card {
    background: var(--glass-bg, #fff);
    border: 1px solid var(--glass-border, #E5E7EB);
    border-radius: 16px; overflow: hidden;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 15px rgba(219,39,119,0.03);
    margin-bottom: 1.5rem;
}
.pm-form-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--glass-border, #E5E7EB);
    font-weight: 700; font-size: 0.9rem;
    color: var(--text-main, #1F2937);
    background: #F9FAFB;
}
.pm-form-body { padding: 1.5rem; }
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
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(219,39,119,0.4);
    color: #fff; text-decoration: none;
}
.pm-meta-label {
    font-size: 11px; font-weight: 700;
    color: var(--primary-light, #F472B6);
    text-transform: uppercase; letter-spacing: .04em;
    margin-bottom: 4px;
}
.pm-meta-value {
    font-size: 14px; font-weight: 600;
    color: var(--text-main, #1F2937);
}
.stock-badge-ok       { display:inline-flex;align-items:center;padding:4px 12px;border-radius:99px;font-size:12px;font-weight:700;background:#f0fdf4;color:#166534;border:1px solid #bbf7d0; }
.stock-badge-low      { display:inline-flex;align-items:center;padding:4px 12px;border-radius:99px;font-size:12px;font-weight:700;background:#fffbeb;color:#d97706;border:1px solid #fde68a; }
.stock-badge-out      { display:inline-flex;align-items:center;padding:4px 12px;border-radius:99px;font-size:12px;font-weight:700;background:#fef2f2;color:#991b1b;border:1px solid #fecaca; }
.pm-divider { border: none; border-top: 1px solid var(--glass-border, #E5E7EB); margin: 1.5rem 0; }
</style>

<div class="pm-page">
    <div class="pm-topbar">
        <div>
            <h1 class="pm-title">Update Stok</h1>
            <p class="pm-subtitle">Perbarui stok produk: <strong>{{ $product->name }}</strong></p>
        </div>
        <a href="{{ route('admin.stocks.index') }}" class="btn btn-secondary">
            ← Kembali ke Kelola Stok
        </a>
    </div>

    {{-- Info Produk --}}
    <div class="pm-form-card">
        <div class="pm-form-card-header">Informasi Produk</div>
        <div class="pm-form-body">
            <div class="row g-4">
                <div class="col-md-3">
                    <div class="pm-meta-label">Nama Produk</div>
                    <div class="pm-meta-value">{{ $product->name }}</div>
                </div>
                <div class="col-md-2">
                    <div class="pm-meta-label">SKU</div>
                    <div class="pm-meta-value">{{ $product->sku ?? '—' }}</div>
                </div>
                <div class="col-md-3">
                    <div class="pm-meta-label">Harga</div>
                    <div class="pm-meta-value">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                </div>
                <div class="col-md-2">
                    <div class="pm-meta-label">Stok Saat Ini</div>
                    <div class="pm-meta-value">
                        @if($product->stock == 0)
                            <span class="stock-badge-out">Habis (0)</span>
                        @elseif($product->stock < 10)
                            <span class="stock-badge-low">{{ $product->stock }} — Menipis</span>
                        @else
                            <span class="stock-badge-ok">{{ $product->stock }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="pm-meta-label">Total Terjual</div>
                    <div class="pm-meta-value">{{ $product->sold_count ?? 0 }} pcs</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Form Update Stok --}}
    <div class="pm-form-card">
        <div class="pm-form-card-header">Form Update Stok</div>
        <div class="pm-form-body">
            <form action="{{ route('admin.stocks.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Stok Baru *</label>
                        <input type="number" name="stock"
                               class="form-control @error('stock') is-invalid @enderror"
                               value="{{ old('stock', $product->stock) }}" required min="0"
                               placeholder="Masukkan jumlah stok baru">
                        @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">Catatan <span class="text-muted fw-normal">(opsional)</span></label>
                        <input type="text" name="note" class="form-control"
                               placeholder="Contoh: Restock dari supplier ABC tanggal {{ now()->format('d/m/Y') }}">
                    </div>
                </div>

                <hr class="pm-divider">

                <div class="d-flex justify-content-between align-items-center">
                    <a href="{{ route('admin.stocks.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn-tambah">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Update Stok
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
