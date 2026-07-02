@extends('layouts.admin')

@section('title', 'Tambah Voucher')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Tambah Voucher</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.vouchers.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Kode Voucher *</label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" 
                                   value="{{ old('code') }}" required placeholder="Contoh: DISKON10">
                            <small class="text-muted">Akan otomatis diubah menjadi huruf besar</small>
                            @error('code')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nama Voucher *</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required placeholder="Contoh: Diskon 10%">
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tipe Diskon *</label>
                            <select name="type" class="form-control @error('type') is-invalid @enderror" required id="voucherType">
                                <option value="percentage" {{ old('type') == 'percentage' ? 'selected' : '' }}>Persentase (%)</option>
                                <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Nominal Tetap (Rp)</option>
                                <option value="free_shipping" {{ old('type') == 'free_shipping' ? 'selected' : '' }}>Gratis Ongkir</option>
                            </select>
                            @error('type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nilai Diskon *</label>
                            <input type="number" name="value" class="form-control @error('value') is-invalid @enderror" 
                                   value="{{ old('value') }}" required min="0">
                            @error('value')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Minimal Belanja</label>
                            <input type="number" name="min_purchase" class="form-control @error('min_purchase') is-invalid @enderror" 
                                   value="{{ old('min_purchase', 0) }}" min="0">
                            <small class="text-muted">Kosongkan atau 0 jika tidak ada minimal</small>
                            @error('min_purchase')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Minimal Jumlah Produk</label>
                            <input type="number" name="min_qty" class="form-control @error('min_qty') is-invalid @enderror" 
                                   value="{{ old('min_qty', 0) }}" min="0">
                            <small class="text-muted">Kosongkan atau 0 jika tidak ada minimal jumlah produk</small>
                            @error('min_qty')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Maksimal Diskon (opsional)</label>
                            <input type="number" name="max_discount" class="form-control" value="{{ old('max_discount') }}" min="0">
                            <small class="text-muted">Khusus tipe persentase</small>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Maksimal Penggunaan</label>
                            <input type="number" name="max_usage" class="form-control" value="{{ old('max_usage') }}" min="1">
                            <small class="text-muted">Kosongkan jika tidak ada batas</small>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Mulai</label>
                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label class="form-label">Tanggal Berakhir *</label>
                            <input type="date" name="expiry_date" class="form-control @error('expiry_date') is-invalid @enderror" 
                                   value="{{ old('expiry_date') }}" required>
                            @error('expiry_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Tipe Penerima *</label>
                            <select name="user_type" class="form-control @error('user_type') is-invalid @enderror" required id="userType">
                                <option value="general" {{ old('user_type', 'general') == 'general' ? 'selected' : '' }}>Voucher Umum (Semua Pengguna)</option>
                                <option value="active_user" {{ old('user_type') == 'active_user' ? 'selected' : '' }}>Voucher Pengguna Aktif</option>
                            </select>
                            <small class="text-muted">Tentukan siapa yang dapat menggunakan voucher ini</small>
                            @error('user_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6" id="minCompletedOrdersGroup" style="{{ old('user_type') == 'active_user' ? '' : 'display:none;' }}">
                        <div class="mb-3">
                            <label class="form-label">Minimal Jumlah Pesanan Selesai *</label>
                            <input type="number" name="min_completed_orders" class="form-control @error('min_completed_orders') is-invalid @enderror" 
                                   value="{{ old('min_completed_orders', 1) }}" min="0">
                            <small class="text-muted">Jumlah minimal pesanan berstatus <strong>Selesai</strong> yang harus dimiliki pengguna</small>
                            @error('min_completed_orders')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" name="is_active" value="1" class="form-check-input" {{ old('is_active', 1) ? 'checked' : '' }}>
                        <label class="form-check-label">Aktif</label>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const userTypeSelect = document.getElementById('userType');
    const minCompletedGroup = document.getElementById('minCompletedOrdersGroup');

    function toggleMinCompletedOrders() {
        if (userTypeSelect.value === 'active_user') {
            minCompletedGroup.style.display = '';
        } else {
            minCompletedGroup.style.display = 'none';
        }
    }

    userTypeSelect.addEventListener('change', toggleMinCompletedOrders);
    toggleMinCompletedOrders();
});
</script>
@endsection