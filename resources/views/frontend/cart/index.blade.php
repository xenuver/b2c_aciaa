@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* ─── Cart Premium Theme ─── */
.cart-hero {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    padding: 2.5rem 0 3rem;
    position: relative;
    overflow: hidden;
}
.cart-hero::before {
    content: '';
    position: absolute;
    top: -60%;
    right: -20%;
    width: 500px;
    height: 500px;
    background: radial-gradient(circle, rgba(207,126,126,0.15) 0%, transparent 70%);
    border-radius: 50%;
}
.cart-hero h1 {
    font-family: 'Inter', sans-serif;
    font-size: 1.75rem;
    font-weight: 800;
    color: #fff;
    margin: 0;
    letter-spacing: -0.5px;
}
.cart-hero h1 i { color: #cf7e7e; margin-right: 10px; }
.cart-hero .breadcrumb-text {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.55);
    margin-top: 6px;
}
.cart-hero .breadcrumb-text a { color: #cf7e7e; text-decoration: none; }

.cart-wrapper {
    font-family: 'Inter', sans-serif;
    max-width: 1140px;
    margin: -2rem auto 3rem;
    padding: 0 1rem;
    position: relative;
    z-index: 2;
}

/* ─── Cart Item Card ─── */
.cart-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.04);
    overflow: hidden;
    margin-bottom: 1.25rem;
    transition: transform 0.2s, box-shadow 0.2s;
}
.cart-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
}

.cart-item {
    display: flex;
    align-items: center;
    gap: 1.25rem;
    padding: 1.25rem;
}
.cart-item-img {
    width: 100px;
    height: 100px;
    border-radius: 12px;
    object-fit: cover;
    border: 2px solid #f5f0ec;
    flex-shrink: 0;
}
.cart-item-info { flex: 1; min-width: 0; }
.cart-item-name {
    font-weight: 700;
    font-size: 0.95rem;
    color: #1a1a2e;
    margin: 0 0 4px;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.cart-item-price {
    font-weight: 800;
    font-size: 1.05rem;
    color: #cf7e7e;
}

/* ─── Quantity Stepper ─── */
.qty-stepper {
    display: inline-flex;
    align-items: center;
    background: #f8f5f2;
    border-radius: 10px;
    overflow: hidden;
    border: 1px solid #ebe6e1;
}
.qty-stepper .qty-btn {
    width: 36px;
    height: 36px;
    border: none;
    background: transparent;
    font-size: 1.1rem;
    font-weight: 700;
    color: #1a1a2e;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: background 0.15s;
}
.qty-stepper .qty-btn:hover { background: #ebe6e1; }
.qty-stepper .qty-val {
    width: 44px;
    height: 36px;
    border: none;
    background: #fff;
    text-align: center;
    font-weight: 700;
    font-size: 0.9rem;
    color: #1a1a2e;
    outline: none;
    border-left: 1px solid #ebe6e1;
    border-right: 1px solid #ebe6e1;
    -moz-appearance: textfield;
}
.qty-stepper .qty-val::-webkit-inner-spin-button,
.qty-stepper .qty-val::-webkit-outer-spin-button { -webkit-appearance: none; margin: 0; }

.cart-item-subtotal {
    text-align: right;
    min-width: 130px;
}
.cart-item-subtotal .label { font-size: 0.72rem; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.05em; font-weight: 600; }
.cart-item-subtotal .value { font-weight: 800; font-size: 1.1rem; color: #1a1a2e; }

.btn-remove {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    border: 1px solid #fee2e2;
    background: #fff5f5;
    color: #dc2626;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.15s;
    flex-shrink: 0;
}
.btn-remove:hover { background: #fecaca; border-color: #fca5a5; }

/* ─── Summary Card ─── */
.summary-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.04);
    padding: 1.5rem;
    position: sticky;
    top: 100px;
}
.summary-title {
    font-weight: 800;
    font-size: 1rem;
    color: #1a1a2e;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 8px;
}
.summary-title i { color: #cf7e7e; }

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 0.6rem 0;
    font-size: 0.88rem;
    color: #6b7280;
}
.summary-row.total {
    border-top: 2px solid #f5f0ec;
    margin-top: 0.5rem;
    padding-top: 1rem;
    font-weight: 800;
    font-size: 1.1rem;
    color: #1a1a2e;
}
.summary-row.total .summary-val { color: #cf7e7e; }

.btn-checkout {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    width: 100%;
    padding: 14px 24px;
    background: linear-gradient(135deg, #cf7e7e 0%, #b76e79 100%);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.95rem;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    margin-top: 1.25rem;
    box-shadow: 0 4px 16px rgba(207,126,126,0.3);
}
.btn-checkout:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(207,126,126,0.4);
    color: #fff;
}
.btn-continue {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
    width: 100%;
    padding: 12px 24px;
    background: transparent;
    color: #6b7280;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.85rem;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    transition: all 0.15s;
    text-decoration: none;
    margin-top: 0.75rem;
}
.btn-continue:hover { background: #f9fafb; color: #374151; }

/* ─── Empty State ─── */
.cart-empty {
    text-align: center;
    padding: 4rem 2rem;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
}
.cart-empty-icon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f5f0ec, #fce4ec);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}
.cart-empty-icon i { font-size: 2.5rem; color: #cf7e7e; }
.cart-empty h3 { font-weight: 800; color: #1a1a2e; margin-bottom: 0.5rem; }
.cart-empty p { color: #9ca3af; font-size: 0.9rem; margin-bottom: 1.5rem; }
.btn-shop-now {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: linear-gradient(135deg, #cf7e7e, #b76e79);
    color: #fff;
    border-radius: 12px;
    font-weight: 700;
    text-decoration: none;
    transition: all 0.2s;
    box-shadow: 0 4px 16px rgba(207,126,126,0.3);
}
.btn-shop-now:hover { transform: translateY(-2px); box-shadow: 0 8px 24px rgba(207,126,126,0.4); color: #fff; }

/* ─── Alert ─── */
.cart-alert {
    display: flex;
    align-items: center;
    gap: 10px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 0.85rem;
    color: #166534;
    font-weight: 500;
    margin-bottom: 1.25rem;
    animation: slideDown 0.3s ease;
}
.cart-alert i { color: #16a34a; }
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ─── Responsive ─── */
@media (max-width: 768px) {
    .cart-item { flex-wrap: wrap; gap: 0.75rem; }
    .cart-item-img { width: 70px; height: 70px; }
    .cart-item-subtotal { text-align: left; min-width: auto; }
    .summary-card { position: static; }
    .cart-hero h1 { font-size: 1.4rem; }
}
</style>
@endpush

@section('content')
<!-- Hero Banner -->
<div class="cart-hero">
    <div class="container">
        <h1><i class="fas fa-shopping-bag"></i> Keranjang Belanja</h1>
        <div class="breadcrumb-text">
            <a href="{{ route('home') }}">Beranda</a> / Keranjang
        </div>
    </div>
</div>

<div class="cart-wrapper" x-data="cartManager()">


    @if($cartItems->count() > 0)
        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div style="font-size:0.8rem; color:#9ca3af; font-weight:600; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:0.75rem; font-family:'Inter',sans-serif;">
                    {{ $cartItems->count() }} PRODUK DI KERANJANG
                </div>

                @foreach($cartItems as $item)
                <div class="cart-card" id="cart-item-{{ $item->id }}">
                    <div class="cart-item">
                        <img src="{{ asset('storage/' . ($item->product->image ?? 'default.jpg')) }}"
                             alt="{{ $item->product->name }}"
                             class="cart-item-img">

                        <div class="cart-item-info">
                            <a href="{{ route('products.show', $item->product->slug ?? $item->product->id) }}" style="text-decoration:none;">
                                <p class="cart-item-name">{{ $item->product->name }}</p>
                            </a>
                            <div class="cart-item-price">Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                        </div>

                        <div class="d-flex align-items-center gap-3">
                            <div class="qty-stepper">
                                <button type="button" class="qty-btn" @click="updateQty({{ $item->id }}, -1)" :disabled="isUpdating" aria-label="Kurangi kuantitas {{ $item->product->name }}">−</button>
                                <input type="number" value="{{ $item->quantity }}" min="1" class="qty-val" id="qty{{ $item->id }}" @change="changeQty({{ $item->id }}, $event.target.value)" :disabled="isUpdating" aria-label="Kuantitas {{ $item->product->name }}">
                                <button type="button" class="qty-btn" @click="updateQty({{ $item->id }}, 1)" :disabled="isUpdating" aria-label="Tambah kuantitas {{ $item->product->name }}">+</button>
                            </div>
                        </div>

                        <div class="cart-item-subtotal d-none d-md-block">
                            <div class="label">Subtotal</div>
                            <div class="value" id="subtotal{{ $item->id }}">Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}</div>
                        </div>

                        <div x-data="{ confirming: false }" class="d-flex align-items-center" style="min-width: 120px; justify-content: flex-end;">
                            <button x-show="!confirming" @click="confirming = true" type="button" class="btn-remove" title="Hapus" aria-label="Hapus {{ $item->product->name }} dari keranjang">
                                <i class="fas fa-trash-alt" style="font-size:0.85rem;"></i>
                            </button>
                            <div x-show="confirming" style="display:none;" class="d-flex align-items-center gap-1">
                                <span style="font-size: 0.75rem; color: #dc2626; margin-right: 4px;">Hapus?</span>
                                <button type="button" @click="removeItem({{ $item->id }})" class="btn btn-sm btn-danger" style="padding: 2px 6px; font-size:0.75rem; border-radius: 6px;">Ya</button>
                                <button type="button" @click="confirming = false" class="btn btn-sm btn-light" style="padding: 2px 6px; font-size:0.75rem; border-radius: 6px;">Batal</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Summary Sidebar -->
            <div class="col-lg-4">
                <div class="summary-card">
                    <div class="summary-title">
                        <i class="fas fa-receipt"></i> Ringkasan Pesanan
                    </div>

                    <div class="summary-row">
                        <span>Subtotal ({{ $cartItems->count() }} produk)</span>
                        <span id="cart-total-top">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-row">
                        <span>Estimasi Ongkir</span>
                        <span style="color:#16a34a; font-weight:600;">Dihitung saat checkout</span>
                    </div>

                    <div class="summary-row total">
                        <span>Total</span>
                        <span class="summary-val" id="cart-total">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('checkout.index') }}" class="btn-checkout">
                        <i class="fas fa-lock"></i> Lanjut ke Pembayaran
                    </a>
                    <a href="{{ route('products.index') }}" class="btn-continue">
                        <i class="fas fa-arrow-left"></i> Lanjut Belanja
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="cart-empty">
            <div class="cart-empty-icon">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <h3>Keranjang Anda Masih Kosong</h3>
            <p>Yuk, mulai belanja dan temukan produk favorit kamu!</p>
            <a href="{{ route('products.index') }}" class="btn-shop-now">
                <i class="fas fa-store"></i> Mulai Belanja
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script>
function cartManager() {
    return {
        isUpdating: false,
        updateQty(id, delta) {
            if (this.isUpdating) return;
            const input = document.getElementById('qty' + id);
            let val = parseInt(input.value) || 1;
            val += delta;
            if (val < 1) val = 1;
            input.value = val;
            
            this.sendUpdate(id, val);
        },
        changeQty(id, val) {
            let quantity = parseInt(val) || 1;
            if (quantity < 1) quantity = 1;
            document.getElementById('qty' + id).value = quantity;
            this.sendUpdate(id, quantity);
        },
        sendUpdate(id, quantity) {
            this.isUpdating = true;
            axios.put(`/cart/${id}/ajax`, { quantity: quantity })
                .then(res => {
                    if(res.data.success) {
                        document.getElementById('subtotal' + id).innerText = 'Rp ' + this.formatNumber(res.data.subtotal);
                        document.getElementById('cart-total').innerText = 'Rp ' + this.formatNumber(res.data.cart_total);
                        document.getElementById('cart-total-top').innerText = 'Rp ' + this.formatNumber(res.data.cart_total);
                        window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', message: res.data.message } }));
                        window.dispatchEvent(new CustomEvent('cart-updated', { detail: res.data.cart_count }));
                    }
                })
                .catch(err => {
                    window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', message: 'Gagal memperbarui keranjang' } }));
                })
                .finally(() => {
                    this.isUpdating = false;
                });
        },
        removeItem(id) {
            if(this.isUpdating) return;
            this.isUpdating = true;
            axios.delete(`/cart/${id}/ajax`)
                .then(res => {
                    if(res.data.success) {
                        document.getElementById('cart-item-' + id).remove();
                        document.getElementById('cart-total').innerText = 'Rp ' + this.formatNumber(res.data.cart_total);
                        document.getElementById('cart-total-top').innerText = 'Rp ' + this.formatNumber(res.data.cart_total);
                        window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', message: res.data.message } }));
                        window.dispatchEvent(new CustomEvent('cart-updated', { detail: res.data.cart_count }));
                        
                        if(res.data.cart_count == 0) {
                            window.location.reload();
                        }
                    }
                })
                .catch(err => {
                    window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', message: 'Gagal menghapus produk' } }));
                })
                .finally(() => {
                    this.isUpdating = false;
                });
        },
        formatNumber(num) {
            return new Intl.NumberFormat('id-ID').format(num);
        }
    }
}
</script>
@endpush