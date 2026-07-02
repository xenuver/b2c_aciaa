@extends('layouts.admin')

@section('title', 'Penggunaan Voucher - ' . $voucher->code)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Penggunaan Voucher: {{ $voucher->code }}</h1>
        <a href="{{ route('admin.vouchers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="card mb-3">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <strong>Nama:</strong> {{ $voucher->name }}
                </div>
                <div class="col-md-3">
                    <strong>Diskon:</strong>
                    @if($voucher->type == 'percentage')
                        {{ $voucher->value }}%
                    @else
                        Rp {{ number_format($voucher->value, 0, ',', '.') }}
                    @endif
                </div>
                <div class="col-md-3">
                    <strong>Penggunaan:</strong>
                    {{ $voucher->used_count }} / 
                    @if($voucher->max_usage) {{ $voucher->max_usage }} @else ∞ @endif
                </div>
                <div class="col-md-3">
                    <strong>Status:</strong>
                    @if($voucher->is_active && $voucher->expiry_date >= date('Y-m-d'))
                        <span class="badge bg-success">Aktif</span>
                    @else
                        <span class="badge bg-danger">Tidak Aktif</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Customer</th>
                        <th>Invoice</th>
                        <th>Total Belanja</th>
                        <th>Diskon</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($usages as $usage)
                    <tr>
                        <td>{{ $usage->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $usage->user->name ?? '-' }}<br>
                            <small>{{ $usage->user->email ?? '-' }}</small>
                        </td>
                        <td>{{ $usage->transaction->invoice_number ?? '-' }}</td>
                        <td>Rp {{ number_format($usage->transaction->subtotal ?? 0, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($usage->discount_amount, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada penggunaan voucher</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {{ $usages->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection