@extends('layouts.admin')

@section('title', 'Kelola Transaksi')

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
    .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
</style>
@endsection

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Kelola Transaksi</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.transactions.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">Status Pesanan</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Dari Tanggal</label>
                    <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Sampai Tanggal</label>
                    <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i> Filter
                    </button>
                    <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
                        <i class="fas fa-sync"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Transaksi -->
    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>Invoice</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status Pesanan</th>
                        <th>Status Pembayaran</th>
                        <th>Resi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td>
                            <strong>{{ $transaction->invoice_number }}</strong>
                        </td>
                        <td>
                            {{ $transaction->recipient_name }}<br>
                            <small class="text-muted">{{ $transaction->user->email ?? '-' }}</small>
                        </td>
                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        <td>Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('admin.transactions.update-status', $transaction->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm" style="width: 130px;" onchange="this.form.submit()">
                                    <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $transaction->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped" {{ $transaction->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered" {{ $transaction->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled" {{ $transaction->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.transactions.update-payment', $transaction->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PUT')
                                <select name="payment_status" class="form-select form-select-sm" style="width: 110px;" onchange="this.form.submit()">
                                    <option value="unpaid" {{ $transaction->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                    <option value="pending" {{ $transaction->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid" {{ $transaction->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                    <option value="failed" {{ $transaction->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                    <option value="expired" {{ $transaction->payment_status == 'expired' ? 'selected' : '' }}>Expired</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            @if($transaction->tracking_number)
                                <span class="badge bg-success">Ada</span>
                                <br><small class="text-muted">{{ $transaction->tracking_number }}</small>
                            @elseif($transaction->payment_status === 'paid' && in_array($transaction->status, ['processing', 'paid', 'pending']))
                                <span class="badge bg-warning text-dark">Belum ada</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-center">
                {{ $transactions->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection