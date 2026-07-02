@extends('layouts.app')

@section('title', 'Klaim Voucher Diskon')

@section('content')
<style>
    :root {
        --vc-pink: #d4a5a5;
        --vc-pink-2: #b5838d;
        --vc-soft-pink: #fef6f5;
        --vc-dark: #1a1a1a;
        --vc-gray: #718096;
        --vc-light-gray: #f7fafc;
    }

    .vouchers-hero {
        background: linear-gradient(135deg, rgba(212,165,165,0.15) 0%, rgba(254,246,245,0.7) 100%);
        padding: 60px 0;
        text-align: center;
        border-bottom: 1px solid rgba(212,165,165,0.2);
        margin-bottom: 40px;
    }

    .vouchers-hero h1 {
        font-weight: 800;
        color: var(--vc-dark);
        letter-spacing: -1px;
    }

    .vouchers-hero p {
        color: var(--vc-gray);
        font-size: 1.1rem;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Ticket Card System */
    .ticket-card {
        background: #ffffff;
        border-radius: 18px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04);
        display: flex;
        overflow: hidden;
        margin-bottom: 24px;
        position: relative;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(0,0,0,0.05);
        height: 180px;
    }

    .ticket-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(212, 165, 165, 0.2);
        border-color: rgba(212, 165, 165, 0.4);
    }

    /* Left Side of Ticket (Discount Value) */
    .ticket-left {
        background: linear-gradient(135deg, var(--vc-pink) 0%, var(--vc-pink-2) 100%);
        color: #ffffff;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 170px;
        position: relative;
        padding: 20px;
        text-align: center;
        flex-shrink: 0;
    }

    .ticket-left::before, .ticket-left::after {
        content: '';
        position: absolute;
        right: -8px;
        width: 16px;
        height: 16px;
        background: var(--vc-light-gray);
        border-radius: 50%;
        z-index: 3;
    }

    .ticket-left::before { top: -8px; }
    .ticket-left::after { bottom: -8px; }

    .ticket-value {
        font-size: 2.2rem;
        font-weight: 800;
        line-height: 1;
        margin-bottom: 5px;
    }

    .ticket-value span {
        font-size: 1.2rem;
        font-weight: 600;
    }

    .ticket-type {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 2px;
        font-weight: 700;
        opacity: 0.9;
        background: rgba(255, 255, 255, 0.2);
        padding: 3px 12px;
        border-radius: 50px;
    }

    /* Dashed Border Divider */
    .ticket-divider {
        width: 0;
        border-left: 2px dashed #ede6e4;
        position: relative;
        height: 100%;
        z-index: 2;
        background: #fff;
    }

    /* Right Side of Ticket (Content & Action) */
    .ticket-right {
        flex-grow: 1;
        padding: 24px 28px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background: #ffffff;
    }

    .ticket-title {
        font-weight: 700;
        font-size: 1.15rem;
        color: var(--vc-dark);
        margin-bottom: 4px;
    }

    .ticket-desc {
        font-size: 0.85rem;
        color: var(--vc-gray);
        margin-bottom: 8px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .ticket-meta {
        font-size: 0.75rem;
        color: #90a4ae;
        display: flex;
        flex-wrap: wrap;
        gap: 12px;
        align-items: center;
    }

    .ticket-meta span {
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .ticket-action {
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-top: 1px solid #f1f5f9;
        padding-top: 14px;
        margin-top: 10px;
    }

    .ticket-code {
        font-family: 'Courier New', Courier, monospace;
        font-weight: 700;
        font-size: 0.9rem;
        background: var(--vc-soft-pink);
        color: var(--vc-pink-2);
        padding: 4px 10px;
        border: 1px dashed rgba(181, 131, 141, 0.4);
        border-radius: 6px;
    }

    .btn-claim {
        background: linear-gradient(135deg, var(--vc-pink) 0%, var(--vc-pink-2) 100%);
        color: #ffffff !important;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 8px 18px;
        border-radius: 50px;
        border: none;
        transition: all 0.25s ease;
        box-shadow: 0 4px 10px rgba(181, 131, 141, 0.3);
        cursor: pointer;
    }

    .btn-claim:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(181, 131, 141, 0.45);
    }

    .btn-claim:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
    }

    .btn-claimed {
        background: #e2e8f0;
        color: #64748b !important;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 8px 18px;
        border-radius: 50px;
        border: none;
        cursor: not-allowed;
    }

    .btn-use {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff !important;
        font-weight: 600;
        font-size: 0.85rem;
        padding: 8px 18px;
        border-radius: 50px;
        border: none;
        text-decoration: none;
        display: inline-block;
        text-align: center;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
        transition: all 0.25s ease;
    }

    .btn-use:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 15px rgba(16, 185, 129, 0.45);
        color: #ffffff !important;
        text-decoration: none;
    }

    .badge-active-user {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 0.65rem;
        font-weight: 700;
        padding: 3px 8px;
        border-radius: 50px;
        background: #fef3c7;
        color: #92400e;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Toast Notification */
    .voucher-toast {
        position: fixed;
        top: 24px;
        right: 24px;
        z-index: 9999;
        min-width: 320px;
        max-width: 420px;
        padding: 16px 20px;
        border-radius: 14px;
        box-shadow: 0 12px 40px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 12px;
        font-size: 0.9rem;
        font-weight: 600;
        transform: translateX(120%);
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .voucher-toast.show {
        transform: translateX(0);
        opacity: 1;
    }

    .voucher-toast.toast-success {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        color: #166534;
    }

    .voucher-toast.toast-error {
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #991b1b;
    }

    .voucher-toast .toast-icon {
        font-size: 1.3rem;
        flex-shrink: 0;
    }

    .voucher-toast .toast-close {
        margin-left: auto;
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        color: inherit;
        opacity: 0.6;
        padding: 0;
        line-height: 1;
    }

    .voucher-toast .toast-close:hover {
        opacity: 1;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .ticket-card {
            flex-direction: column;
            height: auto;
        }
        .ticket-left {
            width: 100%;
            height: 120px;
        }
        .ticket-left::before, .ticket-left::after {
            display: none;
        }
        .ticket-divider {
            width: 100%;
            height: 0;
            border-left: none;
            border-top: 2px dashed #ede6e4;
        }
        .ticket-right {
            padding: 20px;
        }
        .voucher-toast {
            min-width: auto;
            left: 16px;
            right: 16px;
        }
    }
</style>

<!-- Toast Container -->
<div id="voucherToast" class="voucher-toast"></div>

<div class="vouchers-hero">
    <div class="container">
        <h1 class="display-5 fw-bold mb-2">🏷️ Voucher & Promo Aciaa</h1>
        <p class="lead">Klaim berbagai voucher belanja menarik di bawah ini untuk mendapatkan potongan harga spesial pada pesanan Anda!</p>
    </div>
</div>

<div class="container mb-5" style="background-color: var(--vc-light-gray); padding: 20px; border-radius: 24px;">
    <div class="row">
        @forelse($vouchers as $voucher)
            @php
                $isClaimed = in_array($voucher->code, $claimedVoucherCodes);
                $isQuotaFull = $voucher->max_usage !== null && $voucher->used_count >= $voucher->max_usage;
                $isActiveUser = $voucher->user_type === 'active_user';
            @endphp
            <div class="col-lg-6">
                <div class="ticket-card">
                    <!-- Ticket Left (Discount Display) -->
                    <div class="ticket-left">
                        @if($voucher->type == 'percentage')
                            <div class="ticket-value">{{ number_format($voucher->value, 0) }}<span>%</span></div>
                            <div class="ticket-type">Diskon</div>
                        @elseif($voucher->type == 'free_shipping')
                            <div class="ticket-value" style="font-size: 2.2rem;"><i class="fas fa-truck"></i></div>
                            <div class="ticket-type">Gratis Ongkir</div>
                        @else
                            <div class="ticket-value" style="font-size: 1.6rem;">Rp {{ number_format($voucher->value / 1000, 0) }}<span>k</span></div>
                            <div class="ticket-type">Diskon</div>
                        @endif
                    </div>
                    
                    <!-- Ticket Divider -->
                    <div class="ticket-divider"></div>
                    
                    <!-- Ticket Right (Details & Actions) -->
                    <div class="ticket-right">
                        <div>
                            <h3 class="ticket-title">
                                {{ $voucher->name }}
                                @if($isActiveUser)
                                    <span class="badge-active-user">
                                        <i class="fas fa-star" style="font-size: 8px;"></i>
                                        Min. {{ $voucher->min_completed_orders }} Pesanan Selesai
                                    </span>
                                @endif
                            </h3>
                            <p class="ticket-desc">{{ $voucher->description ?? 'Gunakan voucher ini untuk potongan belanja spesial Anda.' }}</p>
                            
                            <div class="ticket-meta">
                                <span><i class="far fa-calendar-alt"></i> S/d {{ date('d M Y', strtotime($voucher->expiry_date)) }}</span>
                                <span><i class="fas fa-shopping-bag"></i> Min. Rp {{ number_format($voucher->min_purchase, 0, ',', '.') }}</span>
                                @if($voucher->min_qty > 0)
                                    <span><i class="fas fa-box"></i> Min. Qty: {{ $voucher->min_qty }}</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="ticket-action">
                            <span class="ticket-code">{{ $voucher->code }}</span>
                            
                            <div id="voucher-action-{{ $voucher->id }}">
                                @auth
                                    @if($isClaimed)
                                        <a href="{{ route('cart.index') }}" class="btn-use">
                                            Gunakan
                                        </a>
                                    @elseif($isQuotaFull)
                                        <button class="btn-claimed" disabled>
                                            Kuota Habis
                                        </button>
                                    @else
                                        <button type="button" class="btn-claim" onclick="claimVoucher({{ $voucher->id }}, this)">
                                            Klaim Voucher
                                        </button>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn-claim text-center d-inline-block">
                                        Login untuk Klaim
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                    <i class="fas fa-ticket-alt fa-4x mb-3 text-muted opacity-40"></i>
                    <h4 class="fw-bold text-dark">Belum Ada Voucher Tersedia</h4>
                    <p class="text-muted">Nantikan voucher belanja diskon menarik dari kami segera!</p>
                </div>
            </div>
        @endforelse
    </div>
</div>

<script>
function showToast(message, type = 'success') {
    const toast = document.getElementById('voucherToast');
    const icon = type === 'success' ? '✅' : '❌';
    
    toast.className = 'voucher-toast toast-' + type;
    toast.innerHTML = `
        <span class="toast-icon">${icon}</span>
        <span>${message}</span>
        <button class="toast-close" onclick="this.parentElement.classList.remove('show')">&times;</button>
    `;
    
    // Trigger reflow for animation
    void toast.offsetWidth;
    toast.classList.add('show');
    
    setTimeout(function() {
        toast.classList.remove('show');
    }, 4000);
}

function claimVoucher(voucherId, btn) {
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Mengklaim...';

    fetch("{{ url('/vouchers/claim') }}/" + voucherId, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(function(response) {
        return response.json().then(function(data) {
            return { ok: response.ok, data: data };
        });
    })
    .then(function(result) {
        if (result.ok && result.data.success) {
            showToast(result.data.message, 'success');
            
            // Replace button with "Gunakan" link
            const container = document.getElementById('voucher-action-' + voucherId);
            container.innerHTML = '<a href="{{ route("cart.index") }}" class="btn-use">Gunakan</a>';
        } else {
            showToast(result.data.message || 'Gagal mengklaim voucher.', 'error');
            btn.disabled = false;
            btn.innerHTML = 'Klaim Voucher';
        }
    })
    .catch(function(error) {
        showToast('Terjadi kesalahan jaringan. Silakan coba lagi.', 'error');
        btn.disabled = false;
        btn.innerHTML = 'Klaim Voucher';
    });
}
</script>
@endsection

