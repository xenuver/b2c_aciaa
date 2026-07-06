@extends('layouts.admin')

@section('title', 'Kelola Transaksi')

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
    background: #F9FAFB;
    flex-wrap: wrap; gap: 10px;
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
    background: rgba(249,250,251,1);
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

.badge-pill {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; font-weight: 600;
    padding: 4px 10px; border-radius: 99px; white-space: nowrap;
}
.bp-pending    { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
.bp-processing { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
.bp-shipped    { background: #f0f9ff; color: #0369a1; border: 1px solid #bae6fd; }
.bp-delivered  { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
.bp-cancelled  { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
.bp-paid       { background: #f0fdf4; color: #166534; border: 1px solid #bbf7d0; }
.bp-unpaid     { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
.bp-failed     { background: #fef2f2; color: #991b1b; border: 1px solid #fecaca; }
.bp-expired    { background: #f5f3ff; color: #6d28d9; border: 1px solid #ddd6fe; }

.btn-act {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 600;
    padding: 6px 12px; border-radius: 8px;
    cursor: pointer; text-decoration: none;
    transition: background .15s, color .15s;
    white-space: nowrap; border: 1px solid;
}
.btn-act-view { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
.btn-act-view:hover { background: #dbeafe; border-color: #93c5fd; color: #1e40af; text-decoration: none; }

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
.pm-footer nav > p {
    font-size: 12px; color: var(--primary-light, #F472B6);
    margin: 0; white-space: nowrap;
}
.pm-footer .pagination { margin: 0 !important; padding: 0; display: flex; align-items: center; gap: 4px; list-style: none; }
.pm-footer .page-item .page-link {
    display: flex; align-items: center; justify-content: center;
    height: 32px; min-width: 32px; padding: 0 10px;
    font-size: 12px; font-weight: 500; line-height: 1;
    border-radius: 8px !important; border: 1px solid #e5e7eb;
    color: #374151; background: #fff;
    transition: background .15s; text-decoration: none;
}
.pm-footer .page-item.active .page-link {
    background: linear-gradient(135deg, var(--primary, #DB2777), var(--primary-light, #FBCFE8));
    border-color: transparent; color: #fff;
}
.pm-footer .page-item.disabled .page-link { color: #d1d5db; pointer-events: none; }
.pm-footer .page-item .page-link:hover { background: #f3f4f6; }

.form-select-sm-custom {
    font-size: 12px;
    padding: 5px 8px;
    border-radius: 8px !important;
    border: 1px solid #e5e7eb !important;
    background: #fff !important;
    color: #374151;
    min-width: 110px;
    cursor: pointer;
}
.form-select-sm-custom:focus {
    border-color: var(--primary, #DB2777) !important;
    box-shadow: 0 0 0 3px rgba(219,39,119,0.1) !important;
    outline: none !important;
}
</style>

<div class="pm-page">
    <div class="pm-topbar">
        <div>
            <h1 class="pm-title">Kelola Transaksi</h1>
            <p class="pm-subtitle">Pantau dan kelola semua transaksi pelanggan</p>
        </div>
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

    {{-- Filter Form --}}
    <div class="pm-filter-card">
        <div class="pm-filter-card-header">Filter Transaksi</div>
        <div class="pm-filter-body">
            <form method="GET" action="{{ route('admin.transactions.index') }}" class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Status Pesanan</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
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
                <div class="col-md-3">
                    <div style="display:flex;gap:8px;">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Tabel Transaksi --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <span class="pm-card-title">Daftar Transaksi</span>
        </div>

        <div class="table-responsive">
            <table class="pm-table">
                <thead>
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
                            <span style="font-weight:700;font-family:'Fira Code',monospace;font-size:12px;">
                                {{ $transaction->invoice_number }}
                            </span>
                        </td>
                        <td>
                            <div style="font-weight:600;font-size:13px;">{{ $transaction->recipient_name }}</div>
                            <div style="font-size:11px;color:#9ca3af;">{{ $transaction->user->email ?? '-' }}</div>
                        </td>
                        <td style="white-space:nowrap;font-size:12px;">
                            {{ $transaction->created_at->format('d/m/Y') }}<br>
                            <span style="color:#9ca3af;">{{ $transaction->created_at->format('H:i') }}</span>
                        </td>
                        <td style="font-weight:700;white-space:nowrap;">
                            Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}
                        </td>
                        <td>
                            <form action="{{ route('admin.transactions.update-status', $transaction->id) }}" method="POST" style="margin:0;">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm form-select-sm-custom"
                                        style="width:130px;" onchange="this.form.submit()">
                                    <option value="pending"    {{ $transaction->status == 'pending'    ? 'selected' : '' }}>Pending</option>
                                    <option value="processing" {{ $transaction->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="shipped"    {{ $transaction->status == 'shipped'    ? 'selected' : '' }}>Shipped</option>
                                    <option value="delivered"  {{ $transaction->status == 'delivered'  ? 'selected' : '' }}>Delivered</option>
                                    <option value="cancelled"  {{ $transaction->status == 'cancelled'  ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('admin.transactions.update-payment', $transaction->id) }}" method="POST" style="margin:0;">
                                @csrf
                                @method('PUT')
                                <select name="payment_status" class="form-select form-select-sm form-select-sm-custom"
                                        style="width:110px;" onchange="this.form.submit()">
                                    <option value="unpaid"  {{ $transaction->payment_status == 'unpaid'  ? 'selected' : '' }}>Unpaid</option>
                                    <option value="pending" {{ $transaction->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid"    {{ $transaction->payment_status == 'paid'    ? 'selected' : '' }}>Paid</option>
                                    <option value="failed"  {{ $transaction->payment_status == 'failed'  ? 'selected' : '' }}>Failed</option>
                                    <option value="expired" {{ $transaction->payment_status == 'expired' ? 'selected' : '' }}>Expired</option>
                                </select>
                            </form>
                        </td>
                        <td>
                            @if($transaction->tracking_number)
                                <span class="badge-pill bp-paid">Ada</span>
                                <div style="font-size:11px;color:#9ca3af;margin-top:3px;font-family:'Fira Code',monospace;">
                                    {{ $transaction->tracking_number }}
                                </div>
                            @elseif($transaction->payment_status === 'paid' && in_array($transaction->status, ['processing', 'paid', 'pending']))
                                <span class="badge-pill bp-pending">Belum ada</span>
                            @else
                                <span style="color:#9ca3af;font-size:12px;">—</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="btn-act btn-act-view">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2.5"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>
                                Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pm-footer">
            {{ $transactions->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection
