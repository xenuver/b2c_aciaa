@extends('layouts.app')

@section('title', 'Checkout')

@push('styles')
<style>
    :root{
        --ck-pink: #d4a5a5;
        --ck-pink-2: #b5838d;
        --ck-soft: #fef6f5;
        --ck-dark: #1a1a1a;
    }

    .address-card {
        border: 2px solid #ede6e4;
        border-radius: 14px;
        transition: all 0.25s ease;
        cursor: pointer;
        position: relative;
        background: #ffffff;
    }
    .address-card:hover {
        border-color: var(--ck-pink);
        box-shadow: 0 4px 16px rgba(212,165,165,0.12);
        transform: translateY(-2px);
    }
    .address-card.selected {
        border-color: var(--ck-pink-2);
        background-color: var(--ck-soft);
        box-shadow: 0 4px 16px rgba(181,131,141,0.15);
    }
    .address-card.selected::after {
        content: '\f058';
        font-family: 'Font Awesome 6 Free';
        font-weight: 900;
        color: var(--ck-pink-2);
        position: absolute;
        top: 12px;
        right: 12px;
        font-size: 1.25rem;
    }

    .courier-btn {
        border: 2px solid #ede6e4;
        border-radius: 12px;
        padding: 14px 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.25s ease;
        background: #ffffff;
    }
    .courier-btn:hover {
        border-color: var(--ck-pink);
        background: var(--ck-soft);
    }
    .courier-btn.selected {
        border-color: var(--ck-pink-2);
        background: var(--ck-soft);
        font-weight: bold;
        color: var(--ck-dark);
        box-shadow: 0 3px 12px rgba(181,131,141,0.18);
    }

    .service-card {
        border: 1.5px solid #ede6e4;
        border-radius: 12px;
        padding: 14px 16px;
        margin-bottom: 10px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #ffffff;
    }
    .service-card:hover {
        border-color: var(--ck-pink);
        background: #fefafa;
    }
    .service-card.selected {
        border-color: var(--ck-pink-2);
        background: var(--ck-soft);
        box-shadow: 0 3px 10px rgba(181,131,141,0.12);
    }

    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(255, 255, 255, 0.7);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        border-radius: 14px;
    }

    .badge-primary {
        background: linear-gradient(135deg, var(--ck-pink), var(--ck-pink-2));
        color: white;
    }
    .price-danger {
        color: var(--ck-pink-2);
    }

    /* Card header overrides */
    .card-header.bg-white{
        background: linear-gradient(135deg, rgba(212,165,165,0.08), rgba(254,246,245,0.6)) !important;
    }
    .card-header .text-primary{
        color: var(--ck-pink-2) !important;
    }
    .card-header .text-success{
        color: var(--ck-pink-2) !important;
    }

    /* Summary card */
    .card-header.bg-dark{
        background: linear-gradient(135deg, var(--ck-dark), #2d2d2d) !important;
    }

    /* Checkout button */
    #btnSubmitCheckout{
        background: linear-gradient(135deg, var(--ck-pink) 0%, var(--ck-pink-2) 100%) !important;
        border: none !important;
        border-radius: 12px !important;
        font-weight: 600 !important;
        transition: transform .15s ease, box-shadow .15s ease !important;
    }
    #btnSubmitCheckout:not(:disabled):hover{
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 24px rgba(181,131,141,0.3) !important;
    }
    #btnSubmitCheckout:disabled{
        opacity: 0.5;
    }

    /* Outline primary buttons */
    .btn-outline-primary{
        border-color: var(--ck-pink) !important;
        color: var(--ck-pink-2) !important;
    }
    .btn-outline-primary:hover{
        background: var(--ck-soft) !important;
        border-color: var(--ck-pink-2) !important;
        color: var(--ck-dark) !important;
    }

    /* Modal primary */
    .modal-header.bg-primary{
        background: linear-gradient(135deg, var(--ck-pink), var(--ck-pink-2)) !important;
        border: none !important;
    }
    .btn-primary{
        background: linear-gradient(135deg, var(--ck-pink), var(--ck-pink-2)) !important;
        border: none !important;
    }
    .btn-primary:hover{
        box-shadow: 0 4px 14px rgba(181,131,141,0.3) !important;
    }

    .form-control:focus, .form-select:focus{
        border-color: var(--ck-pink) !important;
        box-shadow: 0 0 0 .25rem rgba(212,165,165,0.2) !important;
    }

    .text-primary{
        color: var(--ck-pink-2) !important;
    }
    .spinner-border.text-primary{
        color: var(--ck-pink-2) !important;
    }
</style>
@endpush

@section('content')
<div class="container my-5">
    <h2 class="mb-4 fw-bold text-gray-800"><i class="fas fa-shopping-cart text-primary me-2"></i>Checkout</h2>
    

    
    <div class="row">
        <div class="col-md-7">
            <!-- 1. Alamat Pengiriman -->
            <div class="card shadow-sm border-0 mb-4 rounded-4 position-relative" id="addressSection">
                <div class="card-header bg-white border-bottom py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-map-marker-alt text-primary me-2"></i>Alamat Pengiriman</h5>
                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                        <i class="fas fa-plus me-1"></i> Tambah Alamat
                    </button>
                </div>
                <div class="card-body">
                    <div id="addressList" class="row g-3">
                        @forelse($addresses as $address)
                            <div class="col-12">
                                <div class="address-card p-3 {{ $address->is_default ? 'selected' : '' }}"
                                     data-address-id="{{ $address->id }}"
                                     data-city-id="{{ $address->city_id }}"
                                     data-subdistrict-id="{{ $address->subdistrict_id ?? '' }}"
                                     data-label="{{ $address->label }}"
                                     data-recipient-name="{{ $address->recipient_name }}"
                                     data-phone="{{ $address->phone }}"
                                     data-address="{{ $address->address }}"
                                     data-province-id="{{ $address->province_id }}"
                                     data-postal-code="{{ $address->postal_code ?? '' }}"
                                     data-is-default="{{ $address->is_default ? 1 : 0 }}"
                                     onclick="selectAddress(this)">
                                    <button type="button"
                                            class="btn btn-link text-dark p-0 position-absolute"
                                            style="top: 10px; right: 42px;"
                                            onclick="event.stopPropagation(); openEditAddress(this)"
                                            aria-label="Edit alamat">
                                        <i class="fas fa-pen"></i>
                                    </button>
                                    <button type="button"
                                            class="btn btn-link text-danger p-0 position-absolute"
                                            style="top: 10px; right: 12px;"
                                            onclick="event.stopPropagation(); deleteAddress({{ $address->id }})"
                                            aria-label="Hapus alamat">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <div class="d-flex align-items-center mb-2">
                                        <span class="badge badge-primary me-2 px-2 py-1 rounded">{{ $address->label }}</span>
                                        @if($address->is_default)
                                            <span class="badge bg-success px-2 py-1 rounded">Utama</span>
                                        @endif
                                    </div>
                                    <h6 class="fw-bold mb-1">{{ $address->recipient_name }}</h6>
                                    <p class="text-muted small mb-1"><i class="fas fa-phone me-1"></i>{{ $address->phone }}</p>
                                    <p class="small mb-0 text-gray-700">
                                        {{ $address->address }}, Kec. {{ $address->district ?? '' }}, {{ $address->city }}, {{ $address->province }} - {{ $address->postal_code }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-4 text-muted" id="emptyAddressMsg">
                                <i class="fas fa-map-marked-alt fa-3x mb-3 text-gray-300"></i>
                                <p class="mb-0">Belum ada alamat pengiriman terdaftar.</p>
                                <p class="small">Silakan tambah alamat pengiriman baru untuk melanjutkan.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- 2. Pilihan Kurir -->
            <div class="card shadow-sm border-0 mb-4 rounded-4" id="courierSection" style="opacity: 0.5; pointer-events: none;">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-truck text-success me-2"></i>Pilihan Kurir</h5>
                </div>
                <div class="card-body">
                    <p class="text-muted small mb-3">Silakan pilih kurir pengiriman yang diinginkan:</p>
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="courier-btn" data-courier="jne" onclick="selectCourier(this)">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/9/9d/JNE_Express_logo.svg" alt="JNE" class="img-fluid mb-2" style="height: 30px; object-fit: contain;">
                                <div class="small">JNE Express</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="courier-btn" data-courier="pos" onclick="selectCourier(this)">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/0/02/POS_Indonesia_2016.svg" alt="POS" class="img-fluid mb-2" style="height: 30px; object-fit: contain;">
                                <div class="small">POS Indonesia</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="courier-btn" data-courier="tiki" onclick="selectCourier(this)">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/a/ae/Tiki_logo.svg" alt="TIKI" class="img-fluid mb-2" style="height: 30px; object-fit: contain;">
                                <div class="small">TIKI</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Pilihan Layanan -->
            <div class="card shadow-sm border-0 mb-4 rounded-4 position-relative d-none" id="serviceSection">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-tags text-indigo-600 me-2"></i>Layanan Pengiriman</h5>
                </div>
                <div class="card-body">
                    <div id="serviceList"></div>
                </div>
                <div class="loading-overlay d-none" id="serviceLoading">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-5">
            <div class="card shadow-sm border-0 rounded-4 sticky-top" style="top: 24px;">
                <div class="card-header bg-dark text-white py-3 rounded-top-4">
                    <h5 class="mb-0 fw-bold"><i class="fas fa-clipboard-list me-2"></i>Ringkasan Belanja</h5>
                </div>
                <div class="card-body">
                    @foreach($cartItems as $item)
                    <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                        @if($item->product->image)
                            <img src="{{ url('media/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;">
                        @else
                            <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                                <i class="fas fa-image text-muted"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <h6 class="mb-0 fw-bold text-gray-800">{{ $item->product->name }}</h6>
                            <span class="text-muted small">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                        </div>
                        <div class="text-end">
                            <span class="fw-bold">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span>
                        </div>
                    </div>
                    @endforeach
                    
                    <form action="{{ route('checkout.process') }}" method="POST" id="checkoutForm">
                        @csrf
                        
                        <!-- Hidden inputs -->
                        <input type="hidden" name="address_id" id="inputAddressId" value="{{ $addresses->firstWhere('is_default', true)->id ?? '' }}">
                        <input type="hidden" name="shipping_courier" id="inputCourier" required>
                        <input type="hidden" name="shipping_service" id="inputService" required>
                        <input type="hidden" name="shipping_cost" id="inputCost" required>
                        <input type="hidden" name="shipping_etd" id="inputEtd" required>

                        <!-- Klaim Voucher via Kode -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted"><i class="fas fa-ticket-alt text-primary me-1"></i>Klaim & Gunakan Voucher</label>
                            <div class="input-group">
                                <input type="text" id="inputVoucherCode" class="form-control rounded-start-3" placeholder="Masukkan kode voucher..." style="text-transform: uppercase;">
                                <button type="button" class="btn btn-primary rounded-end-3 px-4" id="btnClaimVoucher" onclick="claimVoucher()">
                                    <i class="fas fa-tag me-1"></i> Klaim
                                </button>
                            </div>
                            <div id="claimSuccessMsg" class="alert alert-success py-2 px-3 mt-2 rounded-3 small d-none"></div>
                            <div id="claimErrorMsg" class="alert alert-danger py-2 px-3 mt-2 rounded-3 small d-none"></div>
                        </div>

                        <!-- Pilihan Voucher -->
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <label class="form-label small fw-bold text-muted mb-0"><i class="fas fa-percentage text-primary me-1"></i>Pilih Voucher</label>
                                <button type="button" class="btn btn-link btn-sm text-primary p-0 text-decoration-none fw-semibold small" data-bs-toggle="collapse" data-bs-target="#availableVouchersList">
                                    <i class="fas fa-ticket-alt me-1"></i> Lihat Voucher Tersedia
                                </button>
                            </div>
                            <select id="selectVoucher" name="voucher_id" class="form-select rounded-3" onchange="calculateVoucherDiscount()">
                                <option value="" data-discount-type="" data-discount-value="0" data-min-purchase="0" data-min-qty="0" data-max-discount="0">-- Pilih Voucher --</option>
                                @foreach($vouchers as $userVoucher)
                                    @php $v = $userVoucher->voucher; @endphp
                                    <option value="{{ $v->id }}" 
                                            data-discount-type="{{ $v->type }}" 
                                            data-discount-value="{{ $v->value }}"
                                            data-min-purchase="{{ $v->min_purchase }}"
                                            data-min-qty="{{ $v->min_qty ?? 0 }}"
                                            data-max-discount="{{ $v->max_discount ?? 0 }}">
                                        @if($v->type === 'free_shipping')
                                            🚚 {{ $v->name }} (Gratis Ongkir)
                                        @else
                                            {{ $v->name }} (Min. Rp {{ number_format($v->min_purchase, 0, ',', '.') }})
                                        @endif
                                    </option>
                                @endforeach
                            </select>

                            <!-- Collapse List Voucher Tersedia -->
                            <div class="collapse mt-2 border rounded-3 bg-light p-3" id="availableVouchersList">
                                <h6 class="fw-bold mb-2 small text-dark"><i class="fas fa-gift text-primary me-1"></i>Voucher yang Bisa Digunakan:</h6>
                                <div class="d-flex flex-column gap-2" style="max-height: 200px; overflow-y: auto;">
                                    @php
                                        $userCompletedOrdersCount = Auth::check() ? Auth::user()->getCompletedOrdersCount() : 0;
                                    @endphp
                                    @forelse($activeVouchers as $av)
                                        @php
                                            $isAlreadyClaimed = $vouchers->contains(function($uv) use ($av) {
                                                return $uv->voucher_id == $av->id;
                                            });
                                            $isEligible = true;
                                            if ($av->user_type === 'active_user' && $userCompletedOrdersCount < $av->min_completed_orders) {
                                                $isEligible = false;
                                            }
                                        @endphp
                                        <div class="p-2 border bg-white rounded-3 d-flex justify-content-between align-items-center shadow-sm" style="{{ !$isEligible ? 'opacity: 0.75;' : '' }}">
                                            <div class="flex-grow-1 me-2">
                                                <div class="fw-bold small text-dark" style="font-size: 12px;">{{ $av->name }}</div>
                                                <div class="text-muted" style="font-size: 10px;">
                                                    Kode: <code class="fw-bold text-danger">{{ $av->code }}</code>
                                                    @if($av->min_purchase > 0)
                                                        | Min. Belanja: Rp {{ number_format($av->min_purchase, 0, ',', '.') }}
                                                    @endif
                                                    @if($av->min_qty > 0)
                                                        | Min. Qty: {{ $av->min_qty }}
                                                    @endif
                                                    @if($av->user_type === 'active_user')
                                                        | <span class="text-warning fw-bold"><i class="fas fa-star text-warning"></i> Khusus Pengguna Aktif (Min. {{ $av->min_completed_orders }} Selesai)</span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div>
                                                @if(!$isEligible)
                                                    <button type="button" class="btn btn-sm btn-secondary px-3 py-1 rounded-pill small fw-bold" style="font-size: 11px; opacity: 0.7;" disabled title="Syarat: Minimal {{ $av->min_completed_orders }} pesanan selesai">
                                                        Klaim
                                                    </button>
                                                @elseif($isAlreadyClaimed)
                                                    <button type="button" class="btn btn-sm btn-success px-3 py-1 rounded-pill small fw-bold" style="font-size: 11px;" onclick="selectVoucherById({{ $av->id }})">
                                                        Gunakan
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-sm btn-outline-primary px-3 py-1 rounded-pill small fw-bold" style="font-size: 11px;" onclick="claimAndUseVoucher('{{ $av->code }}')">
                                                        Klaim
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center text-muted small py-2" style="font-size: 11px;">Tidak ada voucher aktif tersedia saat ini.</div>
                                    @endforelse
                                </div>
                            </div>

                            <div id="voucherDiscountRow" class="alert alert-success py-2 px-3 mt-2 rounded-3 small d-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span><i class="fas fa-check-circle me-1"></i> Voucher diterapkan!</span>
                                    <strong id="appliedVoucherDiscountText">-Rp 0</strong>
                                </div>
                            </div>
                            <div id="voucherErrorMsg" class="alert alert-danger py-2 px-3 mt-2 rounded-3 small d-none"></div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label small fw-bold text-muted">Catatan Pesanan (opsional)</label>
                            <textarea name="notes" class="form-control rounded-3" rows="2" placeholder="Contoh: Titipkan di satpam, dll">{{ old('notes') }}</textarea>
                        </div>
                        
                        <table class="table table-borderless table-sm mb-4">
                            <tr>
                                <td class="text-muted">Subtotal ({{ $cartItems->count() }} produk)</td>
                                <td class="text-end fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                            <tr id="tableVoucherDiscountRow" class="d-none">
                                <td class="text-muted text-success">Diskon Voucher</td>
                                <td class="text-end fw-bold text-success" id="summaryVoucherDiscount">-Rp 0</td>
                            </tr>
                            <tr>
                                <td class="text-muted">Ongkos Kirim</td>
                                <td class="text-end fw-bold text-success" id="summaryShippingCost">Pilih Alamat & Kurir</td>
                            </tr>
                            <tr class="border-top">
                                <td class="text-muted pt-3 fs-5">Total Pembayaran</td>
                                <td class="text-end fw-bold pt-3 fs-4 price-danger" id="summaryTotalPayment">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                            </tr>
                        </table>
                        
                        <button type="submit" class="btn btn-success btn-lg w-100 py-3 rounded-3 fw-bold shadow" id="btnSubmitCheckout" disabled>
                            <i class="fas fa-credit-card me-1"></i> Bayar Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Alamat -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header bg-primary text-white py-3 rounded-top-4">
                <h5 class="modal-title fw-bold" id="addAddressModalLabel"><i class="fas fa-map-marker-alt me-2"></i>Tambah Alamat Pengiriman Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 position-relative">
                <div class="loading-overlay d-none" id="modalLoading">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
                
                <form id="addAddressForm" x-data="addressValidator">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Label Alamat *</label>
                            <input type="text" name="label" class="form-control rounded-3" placeholder="Contoh: Rumah, Kantor, Kos" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Nama Penerima *</label>
                            <input type="text" name="recipient_name" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Nomor Telepon *</label>
                            <input type="text" name="phone" x-model="phone" class="form-control rounded-3" placeholder="Contoh: 08123456789" required>
                            <div class="text-danger small mt-1" x-show="phoneError" x-text="phoneError" style="display: none;"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Kode Pos</label>
                            <input type="text" name="postal_code" id="postalCode" class="form-control rounded-3" placeholder="Masukkan Kode Pos">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Provinsi *</label>
                            <select id="selectProvince" name="province_id" class="form-select rounded-3" required>
                                <option value="" disabled selected>Pilih Provinsi</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Kota/Kabupaten * <i class="fas fa-spinner fa-spin ms-1 text-primary d-none" id="citySpinner"></i></label>
                            <select id="selectCity" name="city_id" class="form-select rounded-3" required disabled>
                                <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Kecamatan <i class="fas fa-spinner fa-spin ms-1 text-primary d-none" id="subdistrictSpinner"></i></label>
                            <select id="selectSubdistrict" name="subdistrict_id" class="form-select rounded-3" disabled>
                                <option value="" disabled selected>Pilih Kecamatan</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted">Alamat Lengkap *</label>
                            <textarea name="address" x-model="address" class="form-control rounded-3" rows="3" placeholder="Masukkan detail jalan, RT/RW, nomor rumah, atau patokan" required></textarea>
                            <div class="text-danger small mt-1" x-show="addressError" x-text="addressError" style="display: none;"></div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="is_default" value="1" id="isDefaultCheck" checked>
                                <label class="form-check-label small" for="isDefaultCheck">
                                    Jadikan alamat utama (default)
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div id="addressFormError" class="alert alert-danger d-none mt-3 small"></div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-light rounded-pill px-4 me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">Simpan Alamat</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Alamat -->
<div class="modal fade" id="editAddressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow">
            <div class="modal-header bg-dark text-white py-3 rounded-top-4">
                <h5 class="modal-title fw-bold"><i class="fas fa-pen me-2"></i>Edit Alamat</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 position-relative">
                <div class="loading-overlay d-none" id="editModalLoading">
                    <div class="spinner-border text-light" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <form id="editAddressForm" x-data="addressValidator">
                    <input type="hidden" id="editAddressId">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Label Alamat *</label>
                            <input type="text" id="editLabel" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Nama Penerima *</label>
                            <input type="text" id="editRecipientName" class="form-control rounded-3" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Nomor Telepon *</label>
                            <input type="text" id="editPhone" x-model="phone" class="form-control rounded-3" required>
                            <div class="text-danger small mt-1" x-show="phoneError" x-text="phoneError" style="display: none;"></div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Kode Pos</label>
                            <input type="text" id="editPostalCode" class="form-control rounded-3">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Provinsi *</label>
                            <select id="editProvince" class="form-select rounded-3" required>
                                <option value="" disabled selected>Pilih Provinsi</option>
                                @foreach($provinces as $province)
                                    <option value="{{ $province->id }}">{{ $province->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Kota/Kabupaten * <i class="fas fa-spinner fa-spin ms-1 text-primary d-none" id="editCitySpinner"></i></label>
                            <select id="editCity" class="form-select rounded-3" required disabled>
                                <option value="" disabled selected>Pilih Kota/Kabupaten</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold small text-muted">Kecamatan <i class="fas fa-spinner fa-spin ms-1 text-primary d-none" id="editSubdistrictSpinner"></i></label>
                            <select id="editSubdistrict" class="form-select rounded-3" disabled>
                                <option value="" disabled selected>Pilih Kecamatan</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted">Alamat Lengkap *</label>
                            <textarea id="editAddressText" x-model="address" class="form-control rounded-3" rows="3" required></textarea>
                            <div class="text-danger small mt-1" x-show="addressError" x-text="addressError" style="display: none;"></div>
                        </div>

                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="editIsDefault" value="1">
                                <label class="form-check-label small" for="editIsDefault">
                                    Jadikan alamat utama (default)
                                </label>
                            </div>
                        </div>
                    </div>

                    <div id="editAddressFormError" class="alert alert-danger d-none mt-3 small"></div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-light rounded-pill px-4 me-2" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-dark rounded-pill px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@include('partials.midtrans-snap')

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('addressValidator', () => ({
            phone: '',
            address: '',
            
            get phoneError() {
                if (!this.phone) return '';
                if (!/^(08|62|\+62)/.test(this.phone)) {
                    return 'Nomor telepon harus diawali dengan 08, 62, atau +62';
                }
                const digits = this.phone.replace(/\D/g, '');
                if (digits.length < 10 || digits.length > 15) {
                    return 'Nomor telepon harus terdiri dari 10-15 digit';
                }
                return '';
            },
            
            get addressError() {
                if (!this.address) return '';
                if (this.address.length < 10) {
                    return 'Alamat harus minimal 10 karakter';
                }
                return '';
            }
        }));
    });

    let selectedAddressId = null;
    let selectedCityId = null;
    let selectedSubdistrictId = null;
    let selectedCourier = null;
    let citiesFetchController = null;
    let citiesFetchToken = 0;
    let subdistrictsFetchController = null;
    let subdistrictsFetchToken = 0;
    const subtotal = {{ $subtotal }};
    const productWeight = {{ $totalWeight }};

    document.addEventListener('DOMContentLoaded', function () {
        // Initialize default address if exists
        const defaultCard = document.querySelector('.address-card.selected');
        if (defaultCard) {
            selectedAddressId = defaultCard.getAttribute('data-address-id');
            selectedCityId = defaultCard.getAttribute('data-city-id');
            selectedSubdistrictId = defaultCard.getAttribute('data-subdistrict-id') || null;
            document.getElementById('inputAddressId').value = selectedAddressId;
            enableCourierSection();
        }

        // Province → City cascade
        document.getElementById('selectProvince').addEventListener('change', function() {
            const provinceId = this.value;
            const selectCity = document.getElementById('selectCity');
            const selectSubdistrict = document.getElementById('selectSubdistrict');
            
            selectCity.innerHTML = '<option value="" disabled selected>Pilih Kota/Kabupaten</option>';
            selectCity.disabled = true;
            selectSubdistrict.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';
            selectSubdistrict.disabled = true;
            
            if (!provinceId) return;

            if (citiesFetchController) {
                citiesFetchController.abort();
            }
            citiesFetchController = new AbortController();
            const fetchToken = ++citiesFetchToken;

            const isEdit = this.id === 'editProvince';
            const spinnerId = isEdit ? 'editCitySpinner' : 'citySpinner';
            document.getElementById(spinnerId).classList.remove('d-none');
            
            fetch(`/api/cities/${provinceId}`, { signal: citiesFetchController.signal })
                .then(res => res.json())
                .then(cities => {
                    if (fetchToken !== citiesFetchToken) return;

                    cities.forEach(city => {
                        const opt = document.createElement('option');
                        opt.value = city.id;
                        opt.textContent = `${city.type} ${city.name}`;
                        opt.setAttribute('data-postal-code', city.postal_code || '');
                        selectCity.appendChild(opt);
                    });
                    selectCity.disabled = false;
                })
                .catch(err => {
                    if (err.name === 'AbortError') return;
                    console.error(err);
                    alert('Gagal mengambil data kota/kabupaten');
                })
                .finally(() => {
                    if (fetchToken === citiesFetchToken) {
                        document.getElementById(spinnerId).classList.add('d-none');
                    }
                });
        });

        // City → Subdistrict cascade
        document.getElementById('selectCity').addEventListener('change', function() {
            const cityId = this.value;
            const selectSubdistrict = document.getElementById('selectSubdistrict');
            const postalCodeInput = document.getElementById('postalCode');
            
            const selectedOpt = this.options[this.selectedIndex];
            const pCode = selectedOpt.getAttribute('data-postal-code');
            if (pCode) postalCodeInput.value = pCode;

            selectSubdistrict.innerHTML = '<option value="" disabled selected>Memuat kecamatan...</option>';
            selectSubdistrict.disabled = true;

            if (!cityId) return;

            if (subdistrictsFetchController) {
                subdistrictsFetchController.abort();
            }
            subdistrictsFetchController = new AbortController();
            const fetchToken = ++subdistrictsFetchToken;

            const isEdit = this.id === 'editCity';
            const spinnerId = isEdit ? 'editSubdistrictSpinner' : 'subdistrictSpinner';
            document.getElementById(spinnerId).classList.remove('d-none');

            fetch(`/api/subdistricts/${cityId}`, { signal: subdistrictsFetchController.signal })
                .then(res => res.json())
                .then(subdistricts => {
                    if (fetchToken !== subdistrictsFetchToken) return;

                    selectSubdistrict.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';

                    if (subdistricts.length > 0) {
                        subdistricts.forEach(sub => {
                            const opt = document.createElement('option');
                            opt.value = sub.id;
                            opt.textContent = sub.name;
                            selectSubdistrict.appendChild(opt);
                        });
                        selectSubdistrict.disabled = false;
                    } else {
                        const opt = document.createElement('option');
                        opt.value = '';
                        opt.textContent = 'Tidak ada kecamatan terdaftar';
                        selectSubdistrict.appendChild(opt);
                    }
                })
                .catch(err => {
                    if (err.name === 'AbortError') return;
                    console.error(err);
                    alert('Gagal mengambil data kecamatan');
                })
                .finally(() => {
                    if (fetchToken === subdistrictsFetchToken) {
                        document.getElementById(spinnerId).classList.add('d-none');
                    }
                });
        });

        // Add Address Form
        document.getElementById('addAddressForm').addEventListener('submit', function (e) {
            e.preventDefault();

            const provinceId = document.getElementById('selectProvince').value;
            const cityId = document.getElementById('selectCity').value;
            const subdistrictId = document.getElementById('selectSubdistrict').value;

            if (!provinceId || !cityId) {
                document.getElementById('addressFormError').textContent = 'Provinsi dan kota/kabupaten wajib dipilih.';
                document.getElementById('addressFormError').classList.remove('d-none');
                return;
            }

            const data = {
                label: this.querySelector('[name="label"]').value,
                recipient_name: this.querySelector('[name="recipient_name"]').value,
                phone: this.querySelector('[name="phone"]').value,
                address: this.querySelector('[name="address"]').value,
                province_id: provinceId,
                city_id: cityId,
                postal_code: this.querySelector('[name="postal_code"]').value,
                is_default: this.querySelector('[name="is_default"]').checked ? 1 : 0,
            };

            if (subdistrictId) {
                data.subdistrict_id = subdistrictId;
            }
            
            const errorDiv = document.getElementById('addressFormError');
            errorDiv.classList.add('d-none');
            document.getElementById('modalLoading').classList.remove('d-none');

            fetch('/api/addresses', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(async res => {
                const body = await res.json();
                if (!res.ok) {
                    throw body;
                }
                return body;
            })
            .then(res => {
                if (res.success) {
                    const modalEl = document.getElementById('addAddressModal');
                    bootstrap.Modal.getInstance(modalEl).hide();
                    this.reset();
                    document.getElementById('selectCity').disabled = true;
                    document.getElementById('selectSubdistrict').disabled = true;
                    appendAddressCard(res.address);
                } else {
                    errorDiv.textContent = res.message || 'Gagal menyimpan alamat';
                    errorDiv.classList.remove('d-none');
                }
            })
            .catch(err => {
                console.error(err);
                errorDiv.textContent = err.message || 'Terjadi kesalahan sistem, silakan coba lagi.';
                errorDiv.classList.remove('d-none');
            })
            .finally(() => {
                document.getElementById('modalLoading').classList.add('d-none');
            });
        });
    });

    function selectAddress(element) {
        document.querySelectorAll('.address-card').forEach(card => card.classList.remove('selected'));
        element.classList.add('selected');

        selectedAddressId = element.getAttribute('data-address-id');
        selectedCityId = element.getAttribute('data-city-id');
        selectedSubdistrictId = element.getAttribute('data-subdistrict-id') || null;
        document.getElementById('inputAddressId').value = selectedAddressId;

        resetCourierSection();
        enableCourierSection();
    }

    function enableCourierSection() {
        const section = document.getElementById('courierSection');
        section.style.opacity = '1';
        section.style.pointerEvents = 'auto';
    }

    function resetCourierSection() {
        document.querySelectorAll('.courier-btn').forEach(btn => btn.classList.remove('selected'));
        selectedCourier = null;
        document.getElementById('inputCourier').value = '';

        document.getElementById('serviceSection').classList.add('d-none');
        document.getElementById('serviceList').innerHTML = '';

        document.getElementById('inputService').value = '';
        document.getElementById('inputCost').value = '';
        document.getElementById('inputEtd').value = '';
        document.getElementById('summaryShippingCost').textContent = 'Pilih Alamat & Kurir';
        document.getElementById('summaryShippingCost').className = 'text-end fw-bold text-success';
        calculateVoucherDiscount();
        document.getElementById('btnSubmitCheckout').disabled = true;
    }

    function selectCourier(element) {
        if (!selectedCityId) {
            alert('Silakan pilih alamat pengiriman terlebih dahulu');
            return;
        }

        document.querySelectorAll('.courier-btn').forEach(btn => btn.classList.remove('selected'));
        element.classList.add('selected');
        selectedCourier = element.getAttribute('data-courier');
        document.getElementById('inputCourier').value = selectedCourier;

        fetchShippingCost();
    }

    function fetchShippingCost() {
        const serviceSection = document.getElementById('serviceSection');
        const serviceList = document.getElementById('serviceList');
        const loading = document.getElementById('serviceLoading');

        serviceSection.classList.remove('d-none');
        serviceList.innerHTML = '';
        loading.classList.remove('d-none');

        document.getElementById('btnSubmitCheckout').disabled = true;
        document.getElementById('summaryShippingCost').innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Menghitung Ongkir...';
        
        fetch('/api/shipping-cost', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                destination_city_id: selectedCityId,
                destination_subdistrict_id: selectedSubdistrictId || undefined,
                courier: selectedCourier,
                weight: productWeight
            })
        })
        .then(async res => {
            const body = await res.json();
            if (!res.ok) {
                throw body;
            }
            return body;
        })
        .then(res => {
            if (res.success && res.costs.length > 0) {
                res.costs.forEach(item => {
                    const card = document.createElement('div');
                    card.className = 'service-card d-flex justify-content-between align-items-center';
                    card.setAttribute('data-service', item.service);
                    card.setAttribute('data-cost', item.cost);
                    card.setAttribute('data-etd', item.etd);
                    
                    card.innerHTML = `
                        <div>
                            <span class="fw-bold text-gray-800">${item.description || item.service}</span>
                            <div class="small text-muted">Kode: ${item.service}</div>
                            <div class="small text-muted mt-1"><i class="far fa-clock me-1"></i>Estimasi: ${item.etd || '1-3'}</div>
                        </div>
                        <div class="text-end">
                            <span class="fw-bold text-danger">${formatRupiah(item.cost)}</span>
                        </div>
                    `;
                    card.onclick = function() { selectService(this); };
                    serviceList.appendChild(card);
                });
                
                document.getElementById('summaryShippingCost').textContent = 'Pilih Layanan';
                document.getElementById('summaryShippingCost').className = 'text-end fw-bold text-primary';
            } else {
                serviceList.innerHTML = `
                    <div class="alert alert-warning py-2 mb-0 small">
                        <i class="fas fa-exclamation-triangle me-1"></i> ${res.message || 'Tidak ada layanan pengiriman tersedia untuk kurir ini.'}
                    </div>`;
                document.getElementById('summaryShippingCost').textContent = 'Tidak Tersedia';
                document.getElementById('summaryShippingCost').className = 'text-end fw-bold text-danger';
            }
        })
        .catch(err => {
            console.error(err);
            serviceList.innerHTML = `
                <div class="alert alert-danger py-2 mb-0 small">
                    <i class="fas fa-times-circle me-1"></i> ${err.message || 'Gagal memuat tarif ongkir. Silakan coba kurir lain.'}
                </div>`;
            document.getElementById('summaryShippingCost').textContent = 'Eror Hitung';
            document.getElementById('summaryShippingCost').className = 'text-end fw-bold text-danger';
        })
        .finally(() => {
            loading.classList.add('d-none');
        });
    }

    function selectService(element) {
        document.querySelectorAll('.service-card').forEach(card => card.classList.remove('selected'));
        element.classList.add('selected');

        const service = element.getAttribute('data-service');
        const cost = parseInt(element.getAttribute('data-cost'));
        const etd = element.getAttribute('data-etd');

        document.getElementById('inputService').value = service;
        document.getElementById('inputCost').value = cost;
        document.getElementById('inputEtd').value = etd;

        document.getElementById('summaryShippingCost').textContent = formatRupiah(cost);
        document.getElementById('summaryShippingCost').className = 'text-end fw-bold text-success';
        calculateVoucherDiscount();

        document.getElementById('btnSubmitCheckout').disabled = false;
    }

    let discountAmount = 0;

    function calculateVoucherDiscount() {
        const select = document.getElementById('selectVoucher');
        if (!select) return;
        
        const option = select.options[select.selectedIndex];
        const type = option.getAttribute('data-discount-type');
        const value = parseFloat(option.getAttribute('data-discount-value') || 0);
        const minPurchase = parseFloat(option.getAttribute('data-min-purchase') || 0);
        const minQty = parseInt(option.getAttribute('data-min-qty') || 0);
        const maxDiscount = parseFloat(option.getAttribute('data-max-discount') || 0);
        
        const errorMsg = document.getElementById('voucherErrorMsg');
        const discountRow = document.getElementById('voucherDiscountRow');
        const tableRow = document.getElementById('tableVoucherDiscountRow');
        const summaryDiscount = document.getElementById('summaryVoucherDiscount');
        const appliedText = document.getElementById('appliedVoucherDiscountText');
        
        errorMsg.classList.add('d-none');
        discountRow.classList.add('d-none');
        tableRow.classList.add('d-none');
        discountAmount = 0;
        
        if (!option.value) {
            updateTotals();
            return;
        }
        
        if (subtotal < minPurchase) {
            errorMsg.textContent = `Minimal belanja untuk menggunakan voucher ini adalah Rp ${formatNumber(minPurchase)}`;
            errorMsg.classList.remove('d-none');
            select.value = '';
            updateTotals();
            return;
        }
        
        const totalQty = {{ $totalQty }};
        if (minQty > 0 && totalQty < minQty) {
            errorMsg.textContent = `Minimal pembelian ${minQty} produk untuk menggunakan voucher ini.`;
            errorMsg.classList.remove('d-none');
            select.value = '';
            updateTotals();
            return;
        }
        
        if (type === 'percentage') {
            discountAmount = subtotal * (value / 100);
            if (maxDiscount > 0 && discountAmount > maxDiscount) {
                discountAmount = maxDiscount;
            }
        } else if (type === 'fixed') {
            discountAmount = value;
        } else if (type === 'free_shipping') {
            const shippingCost = parseInt(document.getElementById('inputCost').value || 0);
            discountAmount = shippingCost;
            if (maxDiscount > 0 && discountAmount > maxDiscount) {
                discountAmount = maxDiscount;
            }
        }
        
        const currentShippingCost = parseInt(document.getElementById('inputCost').value || 0);
        if (discountAmount > (subtotal + currentShippingCost)) {
            discountAmount = subtotal + currentShippingCost;
        }
        
        if (discountAmount > 0) {
            appliedText.textContent = `-Rp ${formatNumber(discountAmount)}`;
            summaryDiscount.textContent = `-Rp ${formatNumber(discountAmount)}`;
            discountRow.classList.remove('d-none');
            tableRow.classList.remove('d-none');
        }
        
        updateTotals();
    }

    function claimVoucher() {
        const codeInput = document.getElementById('inputVoucherCode');
        const code = codeInput.value.trim().toUpperCase();
        
        const successMsg = document.getElementById('claimSuccessMsg');
        const errorMsg = document.getElementById('claimErrorMsg');
        const btnClaim = document.getElementById('btnClaimVoucher');
        
        successMsg.classList.add('d-none');
        errorMsg.classList.add('d-none');
        
        if (!code) {
            errorMsg.textContent = 'Silakan masukkan kode voucher.';
            errorMsg.classList.remove('d-none');
            return;
        }
        
        btnClaim.disabled = true;
        btnClaim.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>';
        
        fetch('{{ route("checkout.claim-voucher") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            body: JSON.stringify({ code: code })
        })
        .then(async res => {
            const body = await res.json();
            if (!res.ok) {
                throw body;
            }
            return body;
        })
        .then(res => {
            if (res.success) {
                successMsg.textContent = res.message;
                successMsg.classList.remove('d-none');
                codeInput.value = '';
                
                // Add to dropdown if not exists
                const select = document.getElementById('selectVoucher');
                let exists = false;
                for (let i = 0; i < select.options.length; i++) {
                    if (select.options[i].value == res.voucher.id) {
                        exists = true;
                        break;
                    }
                }
                
                if (!exists) {
                    const opt = document.createElement('option');
                    opt.value = res.voucher.id;
                    opt.setAttribute('data-discount-type', res.voucher.type);
                    opt.setAttribute('data-discount-value', res.voucher.value);
                    opt.setAttribute('data-min-purchase', res.voucher.min_purchase);
                    opt.setAttribute('data-min-qty', res.voucher.min_qty || 0);
                    opt.setAttribute('data-max-discount', res.voucher.max_discount || 0);
                    
                    if (res.voucher.type === 'free_shipping') {
                        opt.textContent = `🚚 ${res.voucher.name} (Gratis Ongkir)`;
                    } else {
                        opt.textContent = `${res.voucher.name} (Min. Rp ${formatNumber(res.voucher.min_purchase)})`;
                    }
                    select.appendChild(opt);
                }
                
                select.value = res.voucher.id;
                calculateVoucherDiscount();
            } else {
                errorMsg.textContent = res.message || 'Gagal mengklaim voucher.';
                errorMsg.classList.remove('d-none');
            }
        })
        .catch(err => {
            console.error(err);
            errorMsg.textContent = err.message || 'Gagal mengklaim voucher. Kode tidak valid atau sudah digunakan.';
            errorMsg.classList.remove('d-none');
        })
        .finally(() => {
            btnClaim.disabled = false;
            btnClaim.innerHTML = '<i class="fas fa-tag me-1"></i> Klaim';
        });
    }

    function selectVoucherById(voucherId) {
        const select = document.getElementById('selectVoucher');
        if (select) {
            select.value = voucherId;
            calculateVoucherDiscount();
            
            // Scroll to dropdown and highlight
            select.scrollIntoView({ behavior: 'smooth', block: 'center' });
            select.classList.add('is-valid');
            setTimeout(() => select.classList.remove('is-valid'), 2000);
        }
    }

    function claimAndUseVoucher(code) {
        const codeInput = document.getElementById('inputVoucherCode');
        if (codeInput) {
            codeInput.value = code;
            claimVoucher();
        }
    }
    
    function updateTotals() {
        const costInput = document.getElementById('inputCost');
        const cost = parseInt(costInput && costInput.value ? costInput.value : 0);
        const total = subtotal + cost - discountAmount;
        document.getElementById('summaryTotalPayment').textContent = formatRupiah(total >= 0 ? total : 0);
    }
    
    function formatNumber(num) {
        return new Intl.NumberFormat('id-ID').format(num);
    }

    function appendAddressCard(address) {
        const addressList = document.getElementById('addressList');
        const emptyMsg = document.getElementById('emptyAddressMsg');
        if (emptyMsg) emptyMsg.remove();

        const col = document.createElement('div');
        col.className = 'col-12';
        col.innerHTML = `
            <div class="address-card p-3"
                 data-address-id="${address.id}"
                 data-city-id="${address.city_id}"
                 data-subdistrict-id="${address.subdistrict_id || ''}"
                 data-label="${escapeHtml(address.label || '')}"
                 data-recipient-name="${escapeHtml(address.recipient_name || '')}"
                 data-phone="${escapeHtml(address.phone || '')}"
                 data-address="${escapeHtml(address.address || '')}"
                 data-province-id="${address.province_id || ''}"
                 data-postal-code="${escapeHtml(address.postal_code || '')}"
                 data-is-default="${address.is_default ? 1 : 0}"
                 onclick="selectAddress(this)">
                <button type="button"
                        class="btn btn-link text-dark p-0 position-absolute"
                        style="top: 10px; right: 42px;"
                        onclick="event.stopPropagation(); openEditAddress(this)"
                        aria-label="Edit alamat">
                    <i class="fas fa-pen"></i>
                </button>
                <button type="button"
                        class="btn btn-link text-danger p-0 position-absolute"
                        style="top: 10px; right: 12px;"
                        onclick="event.stopPropagation(); deleteAddress(${address.id})"
                        aria-label="Hapus alamat">
                    <i class="fas fa-trash"></i>
                </button>
                <div class="d-flex align-items-center mb-2">
                    <span class="badge badge-primary me-2 px-2 py-1 rounded">${address.label}</span>
                    ${address.is_default ? '<span class="badge bg-success px-2 py-1 rounded">Utama</span>' : ''}
                </div>
                <h6 class="fw-bold mb-1">${address.recipient_name}</h6>
                <p class="text-muted small mb-1"><i class="fas fa-phone me-1"></i>${address.phone}</p>
                <p class="small mb-0 text-gray-700">
                    ${address.address}, Kec. ${address.district || ''}, ${address.city}, ${address.province} - ${address.postal_code || ''}
                </p>
            </div>
        `;

        if (address.is_default) {
            addressList.insertBefore(col, addressList.firstChild);
            selectAddress(col.querySelector('.address-card'));
        } else {
            addressList.appendChild(col);
        }
    }

    function escapeHtml(str) {
        return String(str ?? '')
            .replaceAll('&', '&amp;')
            .replaceAll('<', '&lt;')
            .replaceAll('>', '&gt;')
            .replaceAll('"', '&quot;')
            .replaceAll("'", '&#039;');
    }

    function openEditAddress(btnEl) {
        const card = btnEl?.closest('.address-card');
        if (!card) return;

        document.getElementById('editAddressFormError').classList.add('d-none');

        document.getElementById('editAddressId').value = card.getAttribute('data-address-id');
        document.getElementById('editLabel').value = card.getAttribute('data-label') || '';
        document.getElementById('editRecipientName').value = card.getAttribute('data-recipient-name') || '';
        document.getElementById('editPhone').value = card.getAttribute('data-phone') || '';
        document.getElementById('editAddressText').value = card.getAttribute('data-address') || '';
        document.getElementById('editPostalCode').value = card.getAttribute('data-postal-code') || '';
        document.getElementById('editIsDefault').checked = (card.getAttribute('data-is-default') === '1');

        const provinceId = card.getAttribute('data-province-id') || '';
        const cityId = card.getAttribute('data-city-id') || '';
        const subdistrictId = card.getAttribute('data-subdistrict-id') || '';

        const provEl = document.getElementById('editProvince');
        const cityEl = document.getElementById('editCity');
        const subEl = document.getElementById('editSubdistrict');

        provEl.value = provinceId;
        cityEl.innerHTML = '<option value="" disabled selected>Pilih Kota/Kabupaten</option>';
        cityEl.disabled = true;
        subEl.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';
        subEl.disabled = true;

        new bootstrap.Modal(document.getElementById('editAddressModal')).show();

        if (!provinceId) return;

        document.getElementById('editModalLoading').classList.remove('d-none');
        fetch(`/api/cities/${provinceId}`)
            .then(res => res.json())
            .then(cities => {
                cities.forEach(city => {
                    const opt = document.createElement('option');
                    opt.value = city.id;
                    opt.textContent = `${city.type} ${city.name}`;
                    opt.setAttribute('data-postal-code', city.postal_code || '');
                    cityEl.appendChild(opt);
                });
                cityEl.disabled = false;
                if (cityId) cityEl.value = cityId;
                return cityId ? fetch(`/api/subdistricts/${cityId}`) : null;
            })
            .then(res => res ? res.json() : [])
            .then(subdistricts => {
                if (!cityId) return;
                subEl.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';
                if (Array.isArray(subdistricts) && subdistricts.length > 0) {
                    subdistricts.forEach(sub => {
                        const opt = document.createElement('option');
                        opt.value = sub.id;
                        opt.textContent = sub.name;
                        subEl.appendChild(opt);
                    });
                    subEl.disabled = false;
                    if (subdistrictId) subEl.value = subdistrictId;
                }
            })
            .catch(err => {
                console.error(err);
                const e = document.getElementById('editAddressFormError');
                e.textContent = 'Gagal memuat data lokasi untuk edit.';
                e.classList.remove('d-none');
            })
            .finally(() => document.getElementById('editModalLoading').classList.add('d-none'));
    }

    // Edit form submit + cascade
    document.getElementById('editProvince')?.addEventListener('change', function() {
        const provinceId = this.value;
        const cityEl = document.getElementById('editCity');
        const subEl = document.getElementById('editSubdistrict');
        cityEl.innerHTML = '<option value="" disabled selected>Pilih Kota/Kabupaten</option>';
        cityEl.disabled = true;
        subEl.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';
        subEl.disabled = true;
        if (!provinceId) return;

        document.getElementById('editModalLoading').classList.remove('d-none');
        fetch(`/api/cities/${provinceId}`)
            .then(res => res.json())
            .then(cities => {
                cities.forEach(city => {
                    const opt = document.createElement('option');
                    opt.value = city.id;
                    opt.textContent = `${city.type} ${city.name}`;
                    opt.setAttribute('data-postal-code', city.postal_code || '');
                    cityEl.appendChild(opt);
                });
                cityEl.disabled = false;
            })
            .finally(() => document.getElementById('editModalLoading').classList.add('d-none'));
    });

    document.getElementById('editCity')?.addEventListener('change', function() {
        const cityId = this.value;
        const subEl = document.getElementById('editSubdistrict');
        const postalEl = document.getElementById('editPostalCode');
        const selectedOpt = this.options[this.selectedIndex];
        const pCode = selectedOpt?.getAttribute('data-postal-code');
        if (pCode) postalEl.value = pCode;

        subEl.innerHTML = '<option value="" disabled selected>Memuat kecamatan...</option>';
        subEl.disabled = true;
        if (!cityId) return;

        document.getElementById('editModalLoading').classList.remove('d-none');
        fetch(`/api/subdistricts/${cityId}`)
            .then(res => res.json())
            .then(subdistricts => {
                subEl.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';
                if (subdistricts.length > 0) {
                    subdistricts.forEach(sub => {
                        const opt = document.createElement('option');
                        opt.value = sub.id;
                        opt.textContent = sub.name;
                        subEl.appendChild(opt);
                    });
                    subEl.disabled = false;
                }
            })
            .finally(() => document.getElementById('editModalLoading').classList.add('d-none'));
    });

    document.getElementById('editAddressForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const id = document.getElementById('editAddressId').value;
        const provinceId = document.getElementById('editProvince').value;
        const cityId = document.getElementById('editCity').value;
        const subdistrictId = document.getElementById('editSubdistrict').value;

        const payload = {
            label: document.getElementById('editLabel').value,
            recipient_name: document.getElementById('editRecipientName').value,
            phone: document.getElementById('editPhone').value,
            address: document.getElementById('editAddressText').value,
            province_id: provinceId,
            city_id: cityId,
            postal_code: document.getElementById('editPostalCode').value,
            is_default: document.getElementById('editIsDefault').checked ? 1 : 0,
        };
        if (subdistrictId) payload.subdistrict_id = subdistrictId;

        const errEl = document.getElementById('editAddressFormError');
        errEl.classList.add('d-none');

        document.getElementById('editModalLoading').classList.remove('d-none');
        fetch(`/api/addresses/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            },
            body: JSON.stringify(payload),
        })
        .then(async res => {
            const body = await res.json();
            if (!res.ok) throw body;
            return body;
        })
        .then(res => {
            if (!res.success) throw res;

            const updated = res.address;
            const card = document.querySelector(`.address-card[data-address-id="${updated.id}"]`);
            if (card) {
                card.setAttribute('data-label', updated.label || '');
                card.setAttribute('data-recipient-name', updated.recipient_name || '');
                card.setAttribute('data-phone', updated.phone || '');
                card.setAttribute('data-address', updated.address || '');
                card.setAttribute('data-province-id', updated.province_id || '');
                card.setAttribute('data-city-id', updated.city_id || '');
                card.setAttribute('data-subdistrict-id', updated.subdistrict_id || '');
                card.setAttribute('data-postal-code', updated.postal_code || '');
                card.setAttribute('data-is-default', updated.is_default ? 1 : 0);

                // update tampilan ringkas (label, recipient, telp, alamat)
                card.querySelector('.badge.badge-primary')?.replaceWith((() => {
                    const s = document.createElement('span');
                    s.className = 'badge badge-primary me-2 px-2 py-1 rounded';
                    s.textContent = updated.label || 'Alamat';
                    return s;
                })());

                card.querySelector('h6') && (card.querySelector('h6').textContent = updated.recipient_name || '');
                const phoneP = card.querySelector('p.text-muted.small');
                if (phoneP) phoneP.innerHTML = `<i class="fas fa-phone me-1"></i>${updated.phone || ''}`;
                const addrP = card.querySelector('p.small');
                if (addrP) addrP.textContent = `${updated.address}, Kec. ${updated.district || ''}, ${updated.city}, ${updated.province} - ${updated.postal_code || ''}`;
            }

            bootstrap.Modal.getInstance(document.getElementById('editAddressModal'))?.hide();
        })
        .catch(err => {
            errEl.textContent = err.message || 'Gagal memperbarui alamat.';
            errEl.classList.remove('d-none');
        })
        .finally(() => document.getElementById('editModalLoading').classList.add('d-none'));
    });

    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            minimumFractionDigits: 0,
            maximumFractionDigits: 0
        }).format(number);
    }

    function deleteAddress(addressId) {
        if (!confirm('Hapus alamat ini?')) return;

        fetch(`/api/addresses/${addressId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
            }
        })
        .then(async res => {
            const body = await res.json();
            if (!res.ok) throw body;
            return body;
        })
        .then(() => {
            const card = document.querySelector(`.address-card[data-address-id="${addressId}"]`);
            if (card) {
                const wasSelected = card.classList.contains('selected');
                card.closest('.col-12')?.remove();
                if (wasSelected) {
                    selectedAddressId = null;
                    selectedCityId = null;
                    selectedSubdistrictId = null;
                    document.getElementById('inputAddressId').value = '';
                    resetCourierSection();
                    document.getElementById('courierSection').style.opacity = '0.5';
                    document.getElementById('courierSection').style.pointerEvents = 'none';
                }
            }
            if (!document.querySelector('.address-card')) {
                document.getElementById('addressList').innerHTML = `
                    <div class="col-12 text-center py-4 text-muted" id="emptyAddressMsg">
                        <i class="fas fa-map-marked-alt fa-3x mb-3 text-gray-300"></i>
                        <p class="mb-0">Belum ada alamat pengiriman terdaftar.</p>
                        <p class="small">Silakan tambah alamat pengiriman baru untuk melanjutkan.</p>
                    </div>`;
            }
        })
        .catch(err => {
            alert(err.message || 'Gagal menghapus alamat.');
        });
    }
</script>
@endpush