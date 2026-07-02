@extends('layouts.app')

@section('title', 'Ajukan Retur')

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* ─── Retur Form Premium Theme ─── */
.retur-hero {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    padding: 2.5rem 0 3rem;
    position: relative;
    overflow: hidden;
}
.retur-hero::before {
    content: '';
    position: absolute;
    bottom: -40%;
    right: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(207,126,126,0.12) 0%, transparent 70%);
    border-radius: 50%;
}
.retur-hero h1 {
    font-family: 'Inter', sans-serif;
    font-size: 1.75rem;
    font-weight: 800;
    color: #fff;
    margin: 0;
    letter-spacing: -0.5px;
}
.retur-hero h1 i { color: #cf7e7e; margin-right: 10px; }
.retur-hero .breadcrumb-text {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.55);
    margin-top: 6px;
}
.retur-hero .breadcrumb-text a { color: #cf7e7e; text-decoration: none; }

.retur-wrapper {
    font-family: 'Inter', sans-serif;
    max-width: 1140px;
    margin: -2rem auto 3rem;
    padding: 0 1rem;
    position: relative;
    z-index: 2;
}

/* ─── Alert Styles ─── */
.retur-alert-danger {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    background: #fef2f2;
    border: 1px solid #fecaca;
    border-radius: 12px;
    padding: 14px 16px;
    font-size: 0.85rem;
    color: #991b1b;
    margin-bottom: 1.25rem;
    animation: slideDown 0.3s ease;
}
.retur-alert-danger i { color: #dc2626; margin-top: 2px; flex-shrink: 0; }
.retur-alert-danger ul { margin: 0; padding-left: 1rem; }
.retur-alert-danger li { margin-bottom: 2px; }

/* ─── Form Card ─── */
.retur-form-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.04);
    overflow: hidden;
}
.retur-form-header {
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%);
    display: flex;
    align-items: center;
    gap: 10px;
}
.retur-form-header i { color: #cf7e7e; font-size: 1.1rem; }
.retur-form-header h5 {
    margin: 0;
    font-weight: 700;
    font-size: 1rem;
    color: #fff;
}
.retur-form-body { padding: 1.5rem; }

/* ─── Form Elements ─── */
.rf-label {
    display: block;
    font-size: 0.82rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 6px;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.rf-label .required { color: #cf7e7e; }
.rf-select,
.rf-input,
.rf-textarea {
    width: 100%;
    padding: 10px 14px;
    border: 1.5px solid #e5e7eb;
    border-radius: 10px;
    font-size: 0.88rem;
    font-family: 'Inter', sans-serif;
    color: #374151;
    background: #fafafa;
    transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    outline: none;
}
.rf-select:focus,
.rf-input:focus,
.rf-textarea:focus {
    border-color: #cf7e7e;
    box-shadow: 0 0 0 3px rgba(207,126,126,0.1);
    background: #fff;
}
.rf-textarea { resize: vertical; min-height: 80px; }
.rf-hint {
    font-size: 0.75rem;
    color: #9ca3af;
    margin-top: 4px;
}

/* ─── Product Checkbox Cards ─── */
.product-check-card {
    background: #fafafa;
    border: 1.5px solid #e5e7eb;
    border-radius: 12px;
    padding: 14px;
    margin-bottom: 10px;
    transition: all 0.2s;
    cursor: pointer;
}
.product-check-card:hover { border-color: #d1d5db; background: #f5f0ec; }
.product-check-card.active {
    border-color: #cf7e7e;
    background: #fdf2f2;
    box-shadow: 0 0 0 3px rgba(207,126,126,0.1);
}

.product-check-card .form-check {
    display: flex;
    align-items: center;
    gap: 12px;
    margin: 0;
    padding: 0;
}
.product-check-card .form-check-input {
    width: 18px;
    height: 18px;
    margin: 0;
    border: 2px solid #d1d5db;
    flex-shrink: 0;
    cursor: pointer;
}
.product-check-card .form-check-input:checked {
    background-color: #cf7e7e;
    border-color: #cf7e7e;
}
.product-check-card .form-check-label {
    cursor: pointer;
    flex: 1;
}
.product-check-card .product-name {
    font-weight: 700;
    font-size: 0.88rem;
    color: #1a1a2e;
    margin: 0;
}
.product-check-card .product-price {
    font-size: 0.8rem;
    color: #cf7e7e;
    font-weight: 600;
    margin-top: 2px;
}

.qty-input-wrap {
    margin-top: 10px;
    margin-left: 30px;
    display: none;
}
.qty-input-wrap.show { display: block; }
.qty-input-wrap label {
    font-size: 0.75rem;
    color: #6b7280;
    font-weight: 600;
    margin-bottom: 4px;
    display: block;
}
.qty-input-wrap input {
    width: 90px;
    padding: 6px 10px;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-size: 0.85rem;
    font-family: 'Inter', sans-serif;
    text-align: center;
    outline: none;
    transition: border-color 0.2s;
}
.qty-input-wrap input:focus { border-color: #cf7e7e; }

/* ─── File Upload ─── */
.file-upload-zone {
    border: 2px dashed #d1d5db;
    border-radius: 12px;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all 0.2s;
    background: #fafafa;
    position: relative;
}
.file-upload-zone:hover {
    border-color: #cf7e7e;
    background: #fdf8f8;
}
.file-upload-zone i { font-size: 1.5rem; color: #cf7e7e; margin-bottom: 8px; display: block; }
.file-upload-zone .upload-text { font-size: 0.85rem; color: #6b7280; font-weight: 500; }
.file-upload-zone .upload-hint { font-size: 0.75rem; color: #9ca3af; margin-top: 4px; }
.file-upload-zone input[type="file"] {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    opacity: 0;
    cursor: pointer;
}

/* ─── Info Notice ─── */
.retur-notice {
    background: #f0f9ff;
    border: 1px solid #bae6fd;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-top: 1.25rem;
}
.retur-notice .notice-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-weight: 700;
    font-size: 0.85rem;
    color: #0369a1;
    margin-bottom: 8px;
}
.retur-notice ul {
    margin: 0;
    padding-left: 1.25rem;
}
.retur-notice li {
    font-size: 0.82rem;
    color: #374151;
    margin-bottom: 4px;
    line-height: 1.5;
}

/* ─── Guide Card (Sidebar) ─── */
.retur-guide-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.04);
    overflow: hidden;
    position: sticky;
    top: 100px;
}
.retur-guide-header {
    padding: 1.25rem 1.5rem;
    background: linear-gradient(135deg, #cf7e7e 0%, #b76e79 100%);
    display: flex;
    align-items: center;
    gap: 10px;
}
.retur-guide-header i { color: #fff; font-size: 1rem; }
.retur-guide-header h5 { margin: 0; font-weight: 700; font-size: 1rem; color: #fff; }
.retur-guide-body { padding: 1.5rem; }
.retur-guide-body h6 {
    font-weight: 800;
    font-size: 0.85rem;
    color: #1a1a2e;
    margin: 0 0 10px;
    display: flex;
    align-items: center;
    gap: 6px;
}
.retur-guide-body h6 i { color: #cf7e7e; font-size: 0.8rem; }
.retur-guide-body ul, .retur-guide-body ol {
    padding-left: 1.25rem;
    margin: 0 0 1.25rem;
}
.retur-guide-body li {
    font-size: 0.82rem;
    color: #6b7280;
    margin-bottom: 6px;
    line-height: 1.5;
}

/* ─── Step Indicators ─── */
.retur-steps {
    display: flex;
    flex-direction: column;
    gap: 0;
}
.retur-step {
    display: flex;
    gap: 12px;
    position: relative;
}
.retur-step:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 13px;
    top: 28px;
    bottom: -8px;
    width: 2px;
    background: #e5e7eb;
}
.step-num {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: linear-gradient(135deg, #cf7e7e, #b76e79);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.72rem;
    font-weight: 800;
    flex-shrink: 0;
}
.step-text {
    padding-bottom: 16px;
    font-size: 0.82rem;
    color: #374151;
    line-height: 1.5;
    padding-top: 4px;
}

/* ─── Buttons ─── */
.btn-submit-retur {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 28px;
    background: linear-gradient(135deg, #cf7e7e, #b76e79);
    color: #fff;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.88rem;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    transition: all 0.2s;
    box-shadow: 0 4px 16px rgba(207,126,126,0.3);
}
.btn-submit-retur:hover { transform: translateY(-1px); box-shadow: 0 8px 24px rgba(207,126,126,0.4); }
.btn-cancel-retur {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 12px 24px;
    background: transparent;
    color: #6b7280;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.88rem;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
    transition: all 0.15s;
    text-decoration: none;
}
.btn-cancel-retur:hover { background: #f9fafb; color: #374151; }

@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>
@endpush

@section('content')
<!-- Hero Banner -->
<div class="retur-hero">
    <div class="container">
        <h1><i class="fas fa-exchange-alt"></i> Form Pengajuan Retur</h1>
        <div class="breadcrumb-text">
            <a href="{{ route('home') }}">Beranda</a> / <a href="{{ route('returs.index') }}">Riwayat Retur</a> / Ajukan Retur
        </div>
    </div>
</div>

<div class="retur-wrapper">


    @if($errors->any())
        <div class="retur-alert-danger">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="row g-4">
        <!-- Main Form -->
        <div class="col-lg-8">
            <div class="retur-form-card">
                <div class="retur-form-header">
                    <i class="fas fa-clipboard-list"></i>
                    <h5>Informasi Retur</h5>
                </div>
                <div class="retur-form-body">
                    <form action="{{ route('returs.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <!-- Hidden input untuk transaction_id -->
                        <input type="hidden" name="transaction_id" id="transaction_id_hidden" value="{{ $selectedTransaction->id ?? '' }}">

                        <div class="mb-4">
                            <label class="rf-label">Pilih Transaksi <span class="required">*</span></label>
                            <select name="transaction_id_display" id="transaction_id" class="rf-select" required>
                                <option value="">── Pilih Transaksi ──</option>
                                @foreach($transactions as $transaction)
                                    <option value="{{ $transaction->id }}" {{ $selectedTransaction && $selectedTransaction->id == $transaction->id ? 'selected' : '' }}>
                                        {{ $transaction->invoice_number }} — {{ $transaction->created_at->format('d/m/Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div id="items-section" style="{{ $selectedTransaction ? 'display:block' : 'display:none' }}">
                            <div class="mb-4">
                                <label class="rf-label">Produk yang Diretur <span class="required">*</span></label>
                                <div id="items-list">
                                    @if($selectedTransaction)
                                        @foreach($items as $item)
                                        <div class="product-check-card" onclick="toggleCheckCard(this)">
                                            <div class="form-check">
                                                <input type="checkbox"
                                                    name="selected_products[]"
                                                    value="{{ $item->id }}"
                                                    class="form-check-input product-checkbox">
                                                <label class="form-check-label">
                                                    <p class="product-name">{{ $item->product->name }}</p>
                                                    <p class="product-price">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                                </label>
                                            </div>
                                            <div class="qty-input-wrap">
                                                <label>Jumlah retur (maks {{ $item->quantity }}):</label>
                                                <input type="number"
                                                    name="quantities[{{ $item->id }}]"
                                                    class="product-qty"
                                                    min="1"
                                                    max="{{ $item->quantity }}"
                                                    value="1"
                                                    disabled>
                                            </div>
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Hidden container untuk data yang akan dikirim -->
                        <div id="selected-items-container"></div>

                        <div class="mb-4">
                            <label class="rf-label">Alasan Retur <span class="required">*</span></label>
                            <select name="reason" class="rf-select" required>
                                <option value="">── Pilih Alasan ──</option>
                                <option value="defective">🔧 Produk Rusak / Cacat</option>
                                <option value="wrong_item">📦 Produk yang Dikirim Salah</option>
                                <option value="not_as_description">📋 Tidak Sesuai Deskripsi</option>
                                <option value="size_issue">📏 Masalah Ukuran</option>
                                <option value="other">💬 Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="rf-label">Deskripsi / Keterangan</label>
                            <textarea name="description" class="rf-textarea" rows="3" placeholder="Jelaskan detail kendala produk Anda..."></textarea>
                        </div>

                        <div class="mb-4">
                            <label class="rf-label">Foto Bukti <span class="required">*</span></label>
                            <div class="file-upload-zone">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <div class="upload-text">Klik atau drag & drop foto ke sini</div>
                                <div class="upload-hint">Format: JPG, PNG, WEBP — Maks. 2MB</div>
                                <input type="file" name="proof_image" accept="image/*" id="proofImageInput" required>
                            </div>
                            <div id="filePreview" style="display:none; margin-top:10px;">
                                <div style="display:flex; align-items:center; gap:8px; background:#f0fdf4; border:1px solid #bbf7d0; border-radius:8px; padding:8px 12px; font-size:0.82rem; color:#166534;">
                                    <i class="fas fa-check-circle"></i>
                                    <span id="fileName"></span>
                                </div>
                            </div>
                        </div>

                        <div class="retur-notice">
                            <div class="notice-title">
                                <i class="fas fa-info-circle"></i>
                                Catatan Penting
                            </div>
                            <ul>
                                <li>Pengajuan retur hanya untuk transaksi dengan status <strong>"Delivered"</strong></li>
                                <li>Retur akan diproses dalam maksimal <strong>1x24 jam</strong></li>
                                <li>Biaya pengiriman akan ditanggung oleh penjual jika produk cacat/salah</li>
                            </ul>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3" style="border-top: 1px solid #f3f4f6;">
                            <a href="{{ route('returs.index') }}" class="btn-cancel-retur">
                                <i class="fas fa-arrow-left"></i> Batal
                            </a>
                            <button type="submit" class="btn-submit-retur">
                                <i class="fas fa-paper-plane"></i> Ajukan Retur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Guide Sidebar -->
        <div class="col-lg-4">
            <div class="retur-guide-card">
                <div class="retur-guide-header">
                    <i class="fas fa-book-open"></i>
                    <h5>Panduan Retur</h5>
                </div>
                <div class="retur-guide-body">
                    <h6><i class="fas fa-check-circle"></i> Syarat Retur</h6>
                    <ul>
                        <li>Produk diretur maksimal <strong>7 hari</strong> setelah diterima</li>
                        <li>Produk belum pernah dipakai</li>
                        <li>Label/tag produk masih terpasang</li>
                        <li>Kemasan produk masih utuh</li>
                    </ul>

                    <h6><i class="fas fa-route"></i> Proses Retur</h6>
                    <div class="retur-steps">
                        <div class="retur-step">
                            <div class="step-num">1</div>
                            <div class="step-text">Ajukan retur melalui form ini</div>
                        </div>
                        <div class="retur-step">
                            <div class="step-num">2</div>
                            <div class="step-text">Admin memverifikasi (1x24 jam)</div>
                        </div>
                        <div class="retur-step">
                            <div class="step-num">3</div>
                            <div class="step-text">Retur disetujui atau ditolak</div>
                        </div>
                        <div class="retur-step">
                            <div class="step-num">4</div>
                            <div class="step-text">Pengembalian dana diproses</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Transaction select handler
    document.getElementById('transaction_id').addEventListener('change', function() {
        const transactionId = this.value;
        if (transactionId) {
            window.location.href = "{{ route('returs.create') }}/" + transactionId;
        }
    });

    // Product checkbox toggle
    function toggleCheckCard(card) {
        const checkbox = card.querySelector('.product-checkbox');
        // Don't toggle if the click was on the checkbox itself
        if (event.target === checkbox) return;
        checkbox.checked = !checkbox.checked;
        checkbox.dispatchEvent(new Event('change'));
    }

    document.querySelectorAll('.product-checkbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const card = this.closest('.product-check-card');
            const qtyWrap = card.querySelector('.qty-input-wrap');
            const qtyInput = card.querySelector('.product-qty');

            if (this.checked) {
                card.classList.add('active');
                qtyWrap.classList.add('show');
                qtyInput.disabled = false;
            } else {
                card.classList.remove('active');
                qtyWrap.classList.remove('show');
                qtyInput.disabled = true;
            }
        });
    });

    // File upload preview
    document.getElementById('proofImageInput').addEventListener('change', function() {
        const preview = document.getElementById('filePreview');
        const nameEl = document.getElementById('fileName');
        if (this.files.length > 0) {
            nameEl.textContent = this.files[0].name;
            preview.style.display = 'block';
        } else {
            preview.style.display = 'none';
        }
    });
</script>
@endpush