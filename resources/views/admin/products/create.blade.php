@extends('layouts.admin')

@section('title', 'Tambah Produk')

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
    border-radius: 16px;
    overflow: hidden;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 15px rgba(219,39,119,0.03);
}
.pm-form-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--glass-border, #E5E7EB);
    font-weight: 700;
    font-size: 0.9rem;
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
.btn-tambah:active { transform: translateY(0); }
</style>

<div class="pm-page">
    <div class="pm-topbar">
        <div>
            <h1 class="pm-title">Tambah Produk</h1>
            <p class="pm-subtitle">Isi data produk baru untuk ditambahkan ke toko</p>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>

    <div class="pm-form-card">
        <div class="pm-form-card-header">
            Informasi Produk
        </div>
        <div class="pm-form-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Produk *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name') }}" required placeholder="Masukkan nama produk">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Kategori *</label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">Pilih Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga Normal *</label>
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror"
                                   value="{{ old('price') }}" required placeholder="Contoh: 50000">
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Harga Diskon <span class="text-muted fw-normal">(Opsional)</span></label>
                            <input type="number" name="discount_price" class="form-control @error('discount_price') is-invalid @enderror"
                                   value="{{ old('discount_price') }}" placeholder="Kosongkan jika tidak ada diskon">
                            @error('discount_price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Stok *</label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                                   value="{{ old('stock') }}" required placeholder="Jumlah stok awal" min="0">
                            @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Gambar Produk</label>
                            <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Status Produk</label>
                            <div class="form-check mb-2">
                                <input type="checkbox" name="is_promo" value="1" id="is_promo"
                                       class="form-check-input" {{ old('is_promo') ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_promo">Tandai sebagai Produk Promo</label>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" name="is_active" value="1" id="is_active"
                                       class="form-check-input" {{ old('is_active', 1) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Produk Aktif (tampil di toko)</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="mb-4">
                            <label class="form-label">Deskripsi Produk *</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                      rows="5" required placeholder="Tuliskan deskripsi produk...">{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-2" style="border-top: 1px solid var(--glass-border, #E5E7EB);">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn-tambah">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
