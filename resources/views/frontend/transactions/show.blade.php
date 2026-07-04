@extends('layouts.app')

@section('title', 'Detail Transaksi - ' . $transaction->invoice_number)

@push('styles')
<style>
    :root{
        --ck-pink: #d4a5a5;
        --ck-pink-2: #b5838d;
        --ck-soft: #fef6f5;
        --ck-dark: #1a1a1a;
    }

    .order-card {
        border: none;
        border-radius: 16px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        overflow: hidden;
        margin-bottom: 24px;
        background: #ffffff;
    }
    
    .order-card-header {
        background: linear-gradient(135deg, rgba(212,165,165,0.08), rgba(254,246,245,0.4));
        border-bottom: 1px solid rgba(212,165,165,0.15);
        padding: 18px 24px;
    }

    .order-card-header.dark {
        background: linear-gradient(135deg, var(--ck-dark), #2d2d2d);
        color: white;
        border-bottom: none;
    }
    
    .order-card-title {
        margin: 0;
        font-weight: 700;
        font-size: 1.1rem;
        color: var(--ck-dark);
    }
    
    .order-card-header.dark .order-card-title {
        color: white;
    }

    /* Stepper Styling */
    .stepper-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
        padding: 20px 0;
    }
    .stepper-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        z-index: 2;
        width: 120px;
    }
    .step-icon {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #f8f9fa;
        border: 2px solid #ede6e4;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #a0aec0;
        font-size: 18px;
        transition: all 0.25s ease;
    }
    .step-label {
        font-size: 11px;
        font-weight: 700;
        color: #718096;
        margin-top: 10px;
        text-align: center;
        line-height: 1.3;
    }
    .stepper-line {
        flex: 1;
        height: 3px;
        background: #ede6e4;
        margin: 0 -35px;
        margin-bottom: 25px; /* aligns with icons */
        z-index: 1;
        transition: all 0.25s ease;
    }
    
    /* Active State */
    .stepper-step.active .step-icon {
        border-color: var(--ck-pink-2);
        color: var(--ck-pink-2);
        background: var(--ck-soft);
        box-shadow: 0 0 0 5px rgba(181, 131, 141, 0.15);
    }
    .stepper-step.active .step-label {
        color: var(--ck-pink-2);
    }
    
    /* Completed State */
    .stepper-step.completed .step-icon {
        border-color: var(--ck-pink-2);
        background: linear-gradient(135deg, var(--ck-pink), var(--ck-pink-2));
        color: white;
    }
    .stepper-step.completed .step-label {
        color: var(--ck-dark);
    }
    .stepper-line.active {
        background: var(--ck-pink);
    }

    .table-totals th, .table-totals td {
        padding: 8px 12px;
        border: none;
    }

    .btn-pink {
        background: linear-gradient(135deg, var(--ck-pink), var(--ck-pink-2));
        border: none;
        color: white;
        font-weight: 600;
        padding: 10px 22px;
        border-radius: 50px;
        transition: all 0.2s ease;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-pink:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(181, 131, 141, 0.25);
        color: white;
    }

    .btn-outline-pink {
        border: 2px solid var(--ck-pink);
        color: var(--ck-pink-2);
        font-weight: 600;
        padding: 8px 20px;
        border-radius: 50px;
        transition: all 0.2s ease;
        background: transparent;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    
    .btn-outline-pink:hover {
        background: var(--ck-soft);
        color: var(--ck-dark);
        border-color: var(--ck-pink-2);
    }

    .status-badge {
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    @media(max-width: 768px) {
        .stepper-wrapper {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
            padding-left: 20px;
        }
        .stepper-step {
            flex-direction: row;
            width: 100%;
            gap: 16px;
            align-items: center;
        }
        .step-label {
            margin-top: 0;
            text-align: left;
        }
        .stepper-line {
            width: 3px;
            height: 30px;
            margin: -8px 0 -8px 22px;
            flex: none;
        }
    }
</style>
@endpush

@section('content')
<div class="container my-5">
    <!-- Header Page -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3">
        <div>
            <h2 class="fw-bold text-gray-800 mb-1">Detail Transaksi</h2>
            <p class="text-muted mb-0">Invoice: <strong class="text-dark">{{ $transaction->invoice_number }}</strong></p>
        </div>
        <a href="{{ route('transactions.index') }}" class="btn-outline-pink">
            <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
        </a>
    </div>

    @php
        $isCancelled = $transaction->status === 'cancelled';
        
        $step1_active = true;
        $step1_completed = !$isCancelled;
        
        $step2_completed = in_array($transaction->payment_status, ['paid']) || in_array($transaction->status, ['processing', 'shipped', 'delivered']);
        $step2_active = !$step2_completed && $transaction->payment_status === 'pending';
        
        $step3_completed = in_array($transaction->status, ['processing', 'shipped', 'delivered']);
        $step3_active = !$step3_completed && $transaction->status === 'pending' && $transaction->payment_status === 'paid';
        
        $step4_completed = in_array($transaction->status, ['shipped', 'delivered']);
        $step4_active = !$step4_completed && $transaction->status === 'processing';
        
        $step5_completed = $transaction->status === 'delivered';
        $step5_active = !$step5_completed && $transaction->status === 'shipped';
        
        // Lines active states
        $line1_active = $step2_completed || $step2_active;
        $line2_active = $step3_completed || $step3_active;
        $line3_active = $step4_completed || $step4_active;
        $line4_active = $step5_completed || $step5_active;
    @endphp

    <!-- Stepper Status Pengiriman / Pesanan -->
    <div class="card order-card p-4 mb-4">
        @if($isCancelled)
            <div class="text-center py-4">
                <div class="bg-danger-subtle text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                    <i class="fas fa-times-circle fa-2x"></i>
                </div>
                <h4 class="fw-bold text-danger mb-1">Transaksi Dibatalkan</h4>
                <p class="text-muted mb-0">Pesanan ini telah dibatalkan.</p>
            </div>
        @else
            <div class="stepper-wrapper">
                <div class="stepper-step {{ $step1_active ? 'active' : '' }} {{ $step1_completed ? 'completed' : '' }}">
                    <div class="step-icon"><i class="fas fa-receipt"></i></div>
                    <div class="step-label">Pesanan<br>Dibuat</div>
                </div>
                <div class="stepper-line {{ $line1_active ? 'active' : '' }}"></div>
                
                <div class="stepper-step {{ $step2_active ? 'active' : '' }} {{ $step2_completed ? 'completed' : '' }}">
                    <div class="step-icon"><i class="fas fa-wallet"></i></div>
                    <div class="step-label">Pembayaran<br>Lunas</div>
                </div>
                <div class="stepper-line {{ $line2_active ? 'active' : '' }}"></div>
                
                <div class="stepper-step {{ $step3_active ? 'active' : '' }} {{ $step3_completed ? 'completed' : '' }}">
                    <div class="step-icon"><i class="fas fa-box-open"></i></div>
                    <div class="step-label">Sedang<br>Diproses</div>
                </div>
                <div class="stepper-line {{ $line3_active ? 'active' : '' }}"></div>
                
                <div class="stepper-step {{ $step4_active ? 'active' : '' }} {{ $step4_completed ? 'completed' : '' }}">
                    <div class="step-icon"><i class="fas fa-truck"></i></div>
                    <div class="step-label">Dalam<br>Pengiriman</div>
                </div>
                <div class="stepper-line {{ $line4_active ? 'active' : '' }}"></div>
                
                <div class="stepper-step {{ $step5_active ? 'active' : '' }} {{ $step5_completed ? 'completed' : '' }}">
                    <div class="step-icon"><i class="fas fa-check-double"></i></div>
                    <div class="step-label">Pesanan<br>Selesai</div>
                </div>
            </div>
        @endif
    </div>

    <div class="row">
        <!-- Kolom Kiri: Informasi Transaksi -->
        <div class="col-lg-6">
            @if($transaction->status === 'pending' && in_array($transaction->payment_status, ['unpaid', 'pending']) && !$transaction->isPaymentExpired())
                <!-- Selesaikan Pembayaran Card -->
                <div class="card order-card border-0 shadow-sm mb-4" style="border: 1px solid rgba(181, 131, 141, 0.25) !important;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="rounded-circle d-flex align-items-center justify-content-center bg-warning-subtle text-warning" style="width: 50px; height: 50px; flex-shrink: 0;">
                                <i class="fas fa-hourglass-half fa-lg"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-1" style="color: var(--ck-dark);">Selesaikan Pembayaran</h5>
                                <p class="text-muted small mb-0">Silakan lakukan pembayaran sebelum batas waktu habis.</p>
                            </div>
                        </div>
                        
                        <!-- Timer Countdown -->
                        @if($transaction->payment_expired_at)
                            <div class="p-3 rounded-3 mb-3 text-center" style="background-color: var(--ck-soft); border: 1px solid rgba(212,165,165,0.2);">
                                <span class="text-muted small d-block mb-1">Sisa Waktu Pembayaran</span>
                                <h4 class="fw-extrabold mb-1" id="countdownTimer" style="color: var(--ck-pink-2); font-family: monospace; font-weight: 800;">00:00:00</h4>
                                <span class="text-muted small">Batas Waktu: {{ $transaction->payment_expired_at->format('d/m/Y H:i') }} WIB</span>
                            </div>
                        @endif
                        
                        <!-- Actions -->
                        <div class="d-grid gap-2">
                            <button id="btnPayNow" class="btn-pink py-2.5 fs-6 shadow-sm justify-content-center">
                                <i class="fas fa-credit-card"></i> Lanjutkan Pembayaran
                            </button>
                            @if($transaction->snap_url)
                                <a href="{{ $transaction->snap_url }}" target="_blank" class="btn btn-outline-pink py-2 justify-content-center" style="font-size: 0.9rem;">
                                    <i class="fas fa-external-link-alt"></i> Bayar di Tab Baru
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Informasi Pesanan -->
            <div class="card order-card">
                <div class="order-card-header">
                    <h5 class="order-card-title"><i class="fas fa-info-circle text-primary me-2"></i>Informasi Pesanan</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm mb-0">
                        <tr>
                            <td class="text-muted py-2" width="40%">No. Invoice</td>
                            <td class="fw-bold py-2">{{ $transaction->invoice_number }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted py-2">Tanggal Transaksi</td>
                            <td class="py-2">{{ $transaction->created_at->format('d F Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="text-muted py-2">Status Pesanan</td>
                            <td class="py-2">
                                @php
                                    $statusBadgeColor = match($transaction->status) {
                                        'pending' => 'bg-warning text-dark',
                                        'processing' => 'bg-info text-dark',
                                        'shipped' => 'bg-primary text-white',
                                        'delivered' => 'bg-success text-white',
                                        'cancelled' => 'bg-danger text-white',
                                        default => 'bg-secondary text-white',
                                    };
                                @endphp
                                <span class="badge {{ $statusBadgeColor }} status-badge">{{ ucfirst($transaction->status) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted py-2">Status Pembayaran</td>
                            <td class="py-2">
                                @php
                                    $paymentBadgeColor = match($transaction->payment_status) {
                                        'unpaid' => 'bg-danger-subtle text-danger border border-danger',
                                        'pending' => 'bg-warning-subtle text-warning border border-warning',
                                        'paid' => 'bg-success-subtle text-success border border-success',
                                        'failed' => 'bg-danger-subtle text-danger border border-danger',
                                        'expired' => 'bg-secondary-subtle text-secondary border border-secondary',
                                        default => 'bg-secondary-subtle text-secondary',
                                    };
                                @endphp
                                <span class="badge {{ $paymentBadgeColor }} px-3 py-2 rounded-pill fw-semibold">{{ ucfirst($transaction->payment_status) }}</span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
            <!-- Informasi Pengiriman -->
            <div class="card order-card">
                <div class="order-card-header" style="background: linear-gradient(135deg, rgba(181,131,141,0.08), rgba(254,246,245,0.4));">
                    <h5 class="order-card-title" style="color: var(--ck-pink-2);"><i class="fas fa-shipping-fast me-2"></i>Informasi Pengiriman</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="fw-bold mb-1">{{ $transaction->recipient_name }}</h6>
                        <p class="text-muted small mb-2"><i class="fas fa-phone me-1"></i>{{ $transaction->recipient_phone }}</p>
                        <div class="p-3 bg-light rounded-3 small text-gray-700">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>{{ $transaction->shipping_address }}
                        </div>
                    </div>
                    
                    <div class="row g-2 pt-2 border-top">
                        <div class="col-6">
                            <span class="text-muted small">Kurir</span>
                            <p class="fw-bold mb-0 text-dark">{{ strtoupper($transaction->shipping_courier ?? '-') }}</p>
                        </div>
                        <div class="col-6">
                            <span class="text-muted small">Layanan</span>
                            <p class="fw-bold mb-0 text-dark">{{ $transaction->shipping_service ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Nomor Resi -->
                    <div class="mt-4 pt-3 border-top">
                        <h6 class="fw-bold mb-2">Lacak Pengiriman</h6>
                        @if($transaction->tracking_number)
                            <div class="p-3 border rounded-3 bg-white" style="border-color: var(--ck-pink) !important;">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="text-muted small">Nomor Resi / AWB</span>
                                    <span class="badge bg-success-subtle text-success py-1 px-2.5 rounded">Aktif</span>
                                </div>
                                <p class="mb-3"><strong class="fs-5 text-dark">{{ $transaction->tracking_number }}</strong></p>
                                
                                @if($transaction->shipped_at)
                                    <p class="text-muted small mb-3"><i class="far fa-clock me-1"></i>Diserahkan ke kurir: {{ $transaction->shipped_at->format('d/m/Y H:i') }}</p>
                                @endif
                                
                                @if($transaction->resolved_tracking_url)
                                    <a href="{{ $transaction->resolved_tracking_url }}" target="_blank" rel="noopener" class="btn-pink w-100 justify-content-center">
                                        <i class="fas fa-search-location"></i> Lacak Paket ({{ strtoupper($transaction->shipping_courier) }})
                                    </a>
                                @endif
                            </div>
                        @else
                            <div class="alert alert-warning py-3 mb-0 small rounded-3 border-0">
                                <i class="fas fa-info-circle me-2"></i>
                                Nomor resi pengiriman akan muncul di sini setelah paket dikirim oleh penjual (biasanya 1–2 hari kerja setelah pembayaran lunas).
                            </div>
                        @endif
                    </div>

                    @if($transaction->notes)
                        <div class="mt-3 p-3 bg-light rounded-3 small">
                            <strong>Catatan Pembeli:</strong> {{ $transaction->notes }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Kolom Kanan: Detail Produk Belanja -->
        <div class="col-lg-6">
            <!-- Ringkasan Produk -->
            <div class="card order-card">
                <div class="order-card-header dark">
                    <h5 class="order-card-title"><i class="fas fa-shopping-bag me-2"></i>Daftar Produk</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="ps-4">Produk</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Harga</th>
                                    <th class="text-end pe-4">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction->details as $detail)
                                <tr>
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center gap-3 py-2">
                                            @if($detail->product && $detail->product->image)
                                                <img src="{{ url('media/' . $detail->product->image) }}" 
                                                     style="width: 55px; height: 55px; object-fit: cover; border-radius: 10px;" 
                                                     alt="{{ $detail->product->name }}">
                                            @else
                                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 55px; height: 55px;">
                                                    <i class="fas fa-image text-muted"></i>
                                                </div>
                                            @endif
                                            <div>
                                                <h6 class="fw-bold mb-1 small text-dark">{{ $detail->product->name ?? 'Produk Dihapus' }}</h6>
                                                <span class="text-muted small">SKU: {{ $detail->product->sku ?? '-' }}</span>
                                                
                                                <!-- Tombol Review / Ulasan -->
                                                @if($transaction->status == 'delivered')
                                                    <div class="mt-2">
                                                        @php
                                                            $existingRating = App\Models\Rating::where('user_id', Auth::id())
                                                                ->where('product_id', $detail->product_id)
                                                                ->where('transaction_id', $transaction->id)
                                                                ->first();
                                                        @endphp
                                                        @if($existingRating)
                                                            <a href="{{ route('ratings.edit', $existingRating->id) }}" class="btn btn-sm btn-outline-warning rounded-pill py-0.5 px-2.5" style="font-size: 0.75rem;">
                                                                <i class="fas fa-edit me-1"></i> Edit Ulasan
                                                            </a>
                                                        @else
                                                            <a href="{{ route('ratings.create', [$detail->product_id, 'transaction_id' => $transaction->id]) }}" class="btn btn-sm btn-pink rounded-pill py-0.5 px-2.5" style="font-size: 0.75rem;">
                                                                <i class="fas fa-star me-1"></i> Beri Ulasan
                                                            </a>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center fw-semibold text-gray-800">{{ $detail->quantity }}</td>
                                    <td class="text-end text-muted small">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                    <td class="text-end fw-bold pe-4 text-dark">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- Rincian Biaya -->
                    <div class="p-4 bg-light border-top">
                        <table class="table table-borderless table-sm mb-0 table-totals small">
                            <tr>
                                <td class="text-muted">Subtotal Produk</td>
                                <td class="text-end fw-semibold text-dark">Rp {{ number_format($transaction->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Ongkos Kirim ({{ strtoupper($transaction->shipping_courier ?? '-') }})</td>
                                <td class="text-end fw-semibold text-dark">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</td>
                            </tr>
                            @if($transaction->discount_amount > 0)
                            <tr>
                                <td class="text-muted">Diskon Voucher</td>
                                <td class="text-end fw-semibold text-success">-Rp {{ number_format($transaction->discount_amount, 0, ',', '.') }}</td>
                            </tr>
                            @endif
                            <tr class="border-top">
                                <td class="pt-3 fs-6 fw-bold text-dark">Total Pembayaran</td>
                                <td class="pt-3 text-end text-danger fs-5 fw-bold">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@if($transaction->status === 'pending' && in_array($transaction->payment_status, ['unpaid', 'pending']) && !$transaction->isPaymentExpired())
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    (function () {
        // Countdown Timer Logic
        let remainingSeconds = {{ $remainingSeconds }};
        const timerElement = document.getElementById('countdownTimer');
        
        function updateTimer() {
            if (remainingSeconds <= 0) {
                if (timerElement) {
                    timerElement.innerHTML = "WAKTU HABIS";
                    timerElement.style.color = '#e53e3e';
                }
                setTimeout(() => {
                    window.location.reload();
                }, 2000);
                return;
            }
            
            const hours = Math.floor(remainingSeconds / 3600);
            const minutes = Math.floor((remainingSeconds % 3600) / 60);
            const seconds = remainingSeconds % 60;
            
            const pad = (num) => String(num).padStart(2, '0');
            
            if (timerElement) {
                timerElement.innerHTML = `${pad(hours)}:${pad(minutes)}:${pad(seconds)}`;
            }
            
            remainingSeconds--;
            setTimeout(updateTimer, 1000);
        }
        
        if (timerElement && remainingSeconds > 0) {
            updateTimer();
        }
        
        // Midtrans Snap Modal Trigger Logic
        const snapToken = '{{ $transaction->snap_token }}';
        
        function triggerPayment() {
            if (!snapToken) return;
            
            window.snap.pay(snapToken, {
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
                    // Do nothing, user can click to retry
                }
            });
        }
        
        document.getElementById('btnPayNow')?.addEventListener('click', function (e) {
            e.preventDefault();
            triggerPayment();
        });
        
        // Auto trigger payment if URL has pay=1 or pay=true query param
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('pay') === '1' || urlParams.get('pay') === 'true') {
            // Remove the pay parameter from URL without reloading to keep URL clean
            const cleanUrl = window.location.pathname;
            window.history.replaceState({}, document.title, cleanUrl);
            
            // Wait slightly for page rendering before showing modal
            setTimeout(triggerPayment, 600);
        }
    })();
</script>
@endif
@endpush