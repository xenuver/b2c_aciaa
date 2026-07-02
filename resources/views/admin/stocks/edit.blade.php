@extends('layouts.admin')

@section('title', 'Update Stok - ' . $product->name)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Update Stok</h1>
        <a href="{{ route('admin.stocks.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="fw-bold">Nama Produk</label>
                        <p>{{ $product->name }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">SKU</label>
                        <p>{{ $product->sku ?? '-' }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Harga</label>
                        <p>Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="fw-bold">Stok Saat Ini</label>
                        <p>
                            @if($product->stock == 0)
                                <span class="badge bg-danger">Habis</span>
                            @elseif($product->stock < 10)
                                <span class="badge bg-warning">{{ $product->stock }}</span>
                            @else
                                <span class="badge bg-success">{{ $product->stock }}</span>
                            @endif
                        </p>
                    </div>
                    <div class="mb-3">
                        <label class="fw-bold">Total Terjual</label>
                        <p>{{ $product->sold_count ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <hr>

            <form action="{{ route('admin.stocks.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Stok Baru *</label>
                            <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror" 
                                   value="{{ old('stock', $product->stock) }}" required min="0">
                            @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="mb-3">
                            <label class="form-label">Catatan (opsional)</label>
                            <input type="text" name="note" class="form-control" placeholder="Contoh: Restock dari supplier">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.stocks.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Update Stok</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection