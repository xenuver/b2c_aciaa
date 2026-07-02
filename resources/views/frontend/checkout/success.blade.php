@extends('layouts.app')

@section('title', 'Pesanan Berhasil')

@push('styles')
<style>
    :root{
        --ck-pink: #d4a5a5;
        --ck-pink-2: #b5838d;
        --ck-soft: #fef6f5;
        --ck-dark: #1a1a1a;
    }

    .success-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 8px 30px rgba(212,165,165,0.15);
        background: #ffffff;
        overflow: hidden;
    }

    .btn-pink {
        background: linear-gradient(135deg, var(--ck-pink), var(--ck-pink-2));
        color: white;
        font-weight: 600;
        border-radius: 50px;
        padding: 12px 28px;
        transition: all 0.2s ease;
        text-decoration: none;
        border: none;
        display: inline-block;
    }

    .btn-pink:hover {
        box-shadow: 0 4px 12px rgba(181,131,141,0.25);
        color: white;
        transform: translateY(-1px);
    }

    .btn-outline-pink {
        border: 2px solid var(--ck-pink);
        color: var(--ck-pink-2);
        font-weight: 600;
        padding: 10px 26px;
        border-radius: 50px;
        transition: all 0.2s ease;
        background: transparent;
        text-decoration: none;
        display: inline-block;
    }

    .btn-outline-pink:hover {
        background: var(--ck-soft);
        color: var(--ck-dark);
        border-color: var(--ck-pink-2);
    }

    .success-icon-wrapper {
        position: relative;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-bottom: 24px;
    }

    .bg-pink-subtle {
        background-color: var(--ck-soft);
    }
</style>
@endpush

@section('content')
<div class="container my-5" style="max-width: 650px;">
    <div class="card success-card text-center">
        <div class="card-body py-5 px-4 px-sm-5">
            @php
                $paymentBadge = match($transaction->payment_status) {
                    'paid' => 'bg-success text-white',
                    'pending' => 'bg-warning text-dark',
                    'failed', 'expired' => 'bg-danger text-white',
                    default => 'bg-secondary text-white',
                };
            @endphp

            @if($transaction->payment_status === 'paid')
                <div class="success-icon-wrapper bg-success-subtle text-success">
                    <i class="fas fa-check-circle" style="font-size: 80px;"></i>
                </div>
                <h2 class="fw-bold text-gray-800">Pembayaran Berhasil!</h2>
            @elseif($transaction->payment_status === 'pending')
                <div class="success-icon-wrapper bg-warning-subtle text-warning">
                    <i class="fas fa-clock" style="font-size: 80px;"></i>
                </div>
                <h2 class="fw-bold text-gray-800">Menunggu Pembayaran</h2>
            @else
                <div class="success-icon-wrapper bg-pink-subtle" style="color: var(--ck-pink-2);">
                    <i class="fas fa-receipt" style="font-size: 80px;"></i>
                </div>
                <h2 class="fw-bold text-gray-800">Pesanan Dibuat</h2>
            @endif

            <p class="text-muted mt-2">Terima kasih telah berbelanja di <strong>ACIAA Store</strong>.</p>
            
            <div class="alert mt-4 text-start border-0 rounded-4 p-4" style="background-color: var(--ck-soft); border: 1px solid rgba(212,165,165,0.2) !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="fw-bold text-gray-700">Invoice: {{ $transaction->invoice_number }}</span>
                    <span class="badge {{ $paymentBadge }} px-3 py-1.5 rounded-pill">{{ ucfirst($transaction->payment_status) }}</span>
                </div>
                
                <div class="border-top pt-3">
                    <span class="text-muted small">Total Pembayaran</span>
                    <h3 class="fw-bold mb-0 mt-1" style="color: var(--ck-pink-2);">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</h3>
                </div>

                @if($transaction->payment_method)
                    <div class="mt-2 text-muted small">
                        <i class="fas fa-credit-card me-1"></i> Metode Pembayaran: {{ strtoupper($transaction->payment_method) }}
                    </div>
                @endif
                @if($transaction->paid_at)
                    <div class="mt-1 text-muted small">
                        <i class="far fa-calendar-check me-1"></i> Waktu Pembayaran: {{ $transaction->paid_at->format('d/m/Y H:i') }}
                    </div>
                @endif
            </div>
            
            @if($transaction->payment_status === 'unpaid' && $transaction->snap_token)
                <div class="my-4 p-3 border rounded-4 bg-white shadow-sm" style="border-color: var(--ck-pink) !important;">
                    <p class="fw-bold mb-2">Selesaikan Pembayaran Anda</p>
                    <button id="btnPayNow" class="btn-pink w-100 py-2.5 fs-6 shadow-sm">
                        <i class="fas fa-credit-card me-2"></i>Bayar Sekarang / Lanjutkan Pembayaran
                    </button>
                    @if($transaction->snap_url)
                        <div class="mt-2">
                            <a href="{{ $transaction->snap_url }}" target="_blank" class="text-muted small text-decoration-underline">
                                Masalah dengan popup? Bayar di tab baru <i class="fas fa-external-link-alt ms-1" style="font-size: 0.8em;"></i>
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            @if($transaction->payment_status === 'unpaid')
                <p class="mt-4 text-muted small">
                    Pembayaran belum selesai. Anda dapat melanjutkan pembayaran nanti dari halaman 
                    <a href="{{ route('transactions.show', $transaction->id) }}" class="fw-bold" style="color: var(--ck-pink-2); text-decoration: underline;">detail transaksi</a>.
                </p>
            @elseif($transaction->payment_status === 'pending')
                <p class="mt-4 text-muted small">
                    Pembayaran Anda sedang diproses. Status akan diperbarui otomatis setelah konfirmasi dari Midtrans.
                </p>
            @else
                <p class="mt-4 text-muted small">
                    Pesanan Anda akan segera diproses. Pantau status pengiriman di halaman 
                    <a href="{{ route('transactions.show', $transaction->id) }}" class="fw-bold" style="color: var(--ck-pink-2); text-decoration: underline;">detail transaksi</a>.
                </p>
            @endif
            
            <div class="mt-5 d-flex flex-column flex-sm-row justify-content-center gap-3">
                <a href="{{ route('home') }}" class="btn-pink">Kembali ke Beranda</a>
                <a href="{{ route('transactions.index') }}" class="btn-outline-pink">Lihat Transaksi</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if($transaction->status === 'pending' && in_array($transaction->payment_status, ['unpaid', 'pending']) && $transaction->snap_token)
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    document.getElementById('btnPayNow')?.addEventListener('click', function () {
        window.snap.pay('{{ $transaction->snap_token }}', {
            onSuccess: function (result) {
                window.location.reload();
            },
            onPending: function (result) {
                window.location.reload();
            },
            onError: function (result) {
                alert('Pembayaran gagal. Silakan coba lagi.');
            },
            onClose: function () {
                // Do nothing
            }
        });
    });
</script>
@endif
@endpush

