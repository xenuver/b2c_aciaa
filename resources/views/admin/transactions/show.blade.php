@extends('layouts.admin')

@section('title', 'Detail Transaksi - ' . $transaction->invoice_number)

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Detail Transaksi</h1>
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show">{{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <!-- Informasi Pesanan -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Informasi Pesanan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <tr>
                            <th width="35%">Invoice</th>
                            <td>{{ $transaction->invoice_number }}</td>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <td>{{ $transaction->created_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        <tr>
                            <th>Customer</th>
                            <td>{{ $transaction->user->name }} ({{ $transaction->user->email }})</td>
                        </tr>
                        <tr>
                            <th>Status Pesanan</th>
                            <td>
                                <form action="{{ route('admin.transactions.update-status', $transaction->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select form-select-sm" style="width: 150px;" onchange="this.form.submit()">
                                        <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="processing" {{ $transaction->status == 'processing' ? 'selected' : '' }}>Processing</option>
                                        <option value="shipped" {{ $transaction->status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                        <option value="delivered" {{ $transaction->status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                        <option value="cancelled" {{ $transaction->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <th>Status Pembayaran</th>
                            <td>
                                <form action="{{ route('admin.transactions.update-payment', $transaction->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <select name="payment_status" class="form-select form-select-sm" style="width: 130px;" onchange="this.form.submit()">
                                        <option value="unpaid" {{ $transaction->payment_status == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                                        <option value="pending" {{ $transaction->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ $transaction->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="failed" {{ $transaction->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                        <option value="expired" {{ $transaction->payment_status == 'expired' ? 'selected' : '' }}>Expired</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <th>Midtrans Order ID</th>
                            <td><code>{{ $transaction->midtrans_order_id ?? '-' }}</code></td>
                        </tr>
                        <tr>
                            <th>Midtrans Transaction ID</th>
                            <td><code>{{ $transaction->midtrans_transaction_id ?? '-' }}</code></td>
                        </tr>
                        <tr>
                            <th>Metode Pembayaran</th>
                            <td>{{ $transaction->payment_method ? strtoupper($transaction->payment_method) : '-' }}</td>
                        </tr>
                        @if($transaction->paid_at)
                        <tr>
                            <th>Waktu Bayar</th>
                            <td>{{ $transaction->paid_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        @endif
                        <tr>
                            <th>Sumber Status Bayar</th>
                            <td>
                                <span class="badge bg-info text-dark">Midtrans (otomatis via webhook)</span>
                                <small class="text-muted d-block mt-1">Webhook: <code>{{ config('midtrans.notification_url') }}</code></small>
                            </td>
                        </tr>
                        @if($transaction->shipped_at)
                        <tr>
                            <th>Waktu Dikirim</th>
                            <td>{{ $transaction->shipped_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        @endif
                        @if($transaction->delivered_at)
                        <tr>
                            <th>Waktu Diterima</th>
                            <td>{{ $transaction->delivered_at->format('d/m/Y H:i:s') }}</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>
            
            <!-- Informasi Pengiriman -->
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <p>
                        <strong>{{ $transaction->recipient_name }}</strong><br>
                        {{ $transaction->recipient_phone }}<br>
                        {{ $transaction->shipping_address }}
                    </p>
                    <hr>
                    <p>
                        <strong>Kurir:</strong> {{ strtoupper($transaction->shipping_courier ?? '-') }}<br>
                        <strong>Layanan:</strong> {{ $transaction->shipping_service ?? '-' }}<br>
                        <strong>Estimasi:</strong> {{ $transaction->shipping_etd ?? '-' }}
                    </p>

                    <hr>
                    <h6 class="fw-bold mb-3"><i class="fas fa-barcode me-1"></i> Nomor Resi Pengiriman</h6>

                    @if($transaction->tracking_number)
                        <div class="alert alert-success py-2 mb-3">
                            <strong>Resi saat ini:</strong> <code>{{ $transaction->tracking_number }}</code>
                            @if($transaction->resolved_tracking_url)
                                <br><a href="{{ $transaction->resolved_tracking_url }}" target="_blank" rel="noopener" class="small">Buka halaman lacak kurir</a>
                            @endif
                        </div>
                    @else
                        <p class="text-muted small mb-2">
                            Input resi setelah paket diserahkan ke counter kurir. Email notifikasi akan dikirim ke
                            <strong>{{ $transaction->user->email ?? 'email pelanggan' }}</strong> (email akun aktif).
                        </p>
                    @endif

                    @if($transaction->payment_status === 'paid')
                        <form action="{{ route('admin.transactions.update-tracking', $transaction->id) }}" method="POST" class="row g-2 align-items-end">
                            @csrf
                            @method('PUT')
                            <div class="col-md-8">
                                <label class="form-label small mb-1">Nomor resi / AWB</label>
                                <input type="text" name="tracking_number" class="form-control"
                                       value="{{ old('tracking_number', $transaction->tracking_number) }}"
                                       placeholder="Contoh: JP1234567890" required>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-1"></i>
                                    {{ $transaction->tracking_number ? 'Update Resi' : 'Simpan & Kirim Email' }}
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="alert alert-warning py-2 mb-0 small">
                            Menunggu pembayaran lunas sebelum resi dapat diinput.
                        </div>
                    @endif

                    @if($transaction->notes)
                        <hr>
                        <p><strong>Catatan:</strong> {{ $transaction->notes }}</p>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Detail Produk -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Detail Produk</h5>
                </div>
                <div class="card-body p-0">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Produk</th>
                                <th>Qty</th>
                                <th>Harga</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction->details as $detail)
                            <tr>
                                <td>{{ $detail->product->name }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-active">
                            <tr>
                                <th colspan="3" class="text-end">Subtotal</th>
                                <th>Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Ongkos Kirim</th>
                                <th>Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</th>
                            </tr>
                            <tr>
                                <th colspan="3" class="text-end">Diskon</th>
                                <th>Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</th>
                            </tr>
                            <tr class="table-primary">
                                <th colspan="3" class="text-end">Grand Total</th>
                                <th class="fw-bold">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection