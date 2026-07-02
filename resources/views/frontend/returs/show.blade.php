@extends('layouts.app')

@section('title', 'Detail Retur - ' . $retur->retur_number)

@push('styles')
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
/* ─── Retur Detail Premium Theme ─── */
.rd-hero {
    background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    padding: 2.5rem 0 3rem;
    position: relative;
    overflow: hidden;
}
.rd-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -10%;
    width: 400px;
    height: 400px;
    background: radial-gradient(circle, rgba(207,126,126,0.12) 0%, transparent 70%);
    border-radius: 50%;
}
.rd-hero h1 {
    font-family: 'Inter', sans-serif;
    font-size: 1.75rem;
    font-weight: 800;
    color: #fff;
    margin: 0;
    letter-spacing: -0.5px;
}
.rd-hero h1 i { color: #cf7e7e; margin-right: 10px; }
.rd-hero .breadcrumb-text {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.55);
    margin-top: 6px;
}
.rd-hero .breadcrumb-text a { color: #cf7e7e; text-decoration: none; }

.rd-wrapper {
    font-family: 'Inter', sans-serif;
    max-width: 1140px;
    margin: -2rem auto 3rem;
    padding: 0 1rem;
    position: relative;
    z-index: 2;
}

/* ─── Back Button ─── */
.btn-back {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 20px;
    background: #fff;
    color: #374151;
    border: 1.5px solid #e5e7eb;
    border-radius: 12px;
    font-weight: 600;
    font-size: 0.82rem;
    text-decoration: none;
    transition: all 0.15s;
    font-family: 'Inter', sans-serif;
    margin-bottom: 1.25rem;
}
.btn-back:hover { background: #f9fafb; color: #1a1a2e; border-color: #d1d5db; }

/* ─── Status Banner ─── */
.rd-status-banner {
    border-radius: 16px;
    padding: 1.25rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.25rem;
}
.rd-status-banner .status-icon-wrap {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.rd-status-banner .status-icon-wrap i { font-size: 1.25rem; }
.rd-status-banner .status-text h4 { margin: 0 0 2px; font-weight: 800; font-size: 1rem; }
.rd-status-banner .status-text p { margin: 0; font-size: 0.82rem; opacity: 0.8; }

.sb-pending {
    background: linear-gradient(135deg, #fef9c3, #fef3c7);
    border: 1px solid #fde68a;
}
.sb-pending .status-icon-wrap { background: rgba(202,138,4,0.15); }
.sb-pending .status-icon-wrap i { color: #ca8a04; }
.sb-pending .status-text h4 { color: #854d0e; }
.sb-pending .status-text p { color: #92400e; }

.sb-approved {
    background: linear-gradient(135deg, #dcfce7, #d1fae5);
    border: 1px solid #86efac;
}
.sb-approved .status-icon-wrap { background: rgba(22,163,74,0.15); }
.sb-approved .status-icon-wrap i { color: #16a34a; }
.sb-approved .status-text h4 { color: #166534; }
.sb-approved .status-text p { color: #15803d; }

.sb-rejected {
    background: linear-gradient(135deg, #fee2e2, #fecaca);
    border: 1px solid #fca5a5;
}
.sb-rejected .status-icon-wrap { background: rgba(220,38,38,0.15); }
.sb-rejected .status-icon-wrap i { color: #dc2626; }
.sb-rejected .status-text h4 { color: #991b1b; }
.sb-rejected .status-text p { color: #b91c1c; }

.sb-completed {
    background: linear-gradient(135deg, #dbeafe, #bfdbfe);
    border: 1px solid #93c5fd;
}
.sb-completed .status-icon-wrap { background: rgba(37,99,235,0.15); }
.sb-completed .status-icon-wrap i { color: #2563eb; }
.sb-completed .status-text h4 { color: #1e40af; }
.sb-completed .status-text p { color: #1d4ed8; }

.sb-cancelled {
    background: linear-gradient(135deg, #f3f4f6, #e5e7eb);
    border: 1px solid #d1d5db;
}
.sb-cancelled .status-icon-wrap { background: rgba(107,114,128,0.15); }
.sb-cancelled .status-icon-wrap i { color: #6b7280; }
.sb-cancelled .status-text h4 { color: #374151; }
.sb-cancelled .status-text p { color: #6b7280; }

/* ─── Info Card ─── */
.rd-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.04);
    overflow: hidden;
    margin-bottom: 1.25rem;
}
.rd-card-header {
    padding: 1rem 1.25rem;
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    display: flex;
    align-items: center;
    gap: 10px;
}
.rd-card-header i { color: #cf7e7e; font-size: 0.95rem; }
.rd-card-header h5 { margin: 0; font-weight: 700; font-size: 0.95rem; color: #fff; }

.rd-card-header.alt {
    background: linear-gradient(135deg, #cf7e7e, #b76e79);
}
.rd-card-header.alt i { color: #fff; }

.rd-card-header.photo {
    background: linear-gradient(135deg, #0ea5e9, #0284c7);
}
.rd-card-header.photo i { color: #fff; }

.rd-card-body { padding: 1.25rem; }

/* ─── Info Rows ─── */
.info-row {
    display: flex;
    padding: 0.75rem 0;
    border-bottom: 1px solid #f3f4f6;
    gap: 1rem;
    align-items: flex-start;
}
.info-row:last-child { border-bottom: none; }
.info-row .ir-label {
    width: 140px;
    flex-shrink: 0;
    font-size: 0.78rem;
    font-weight: 700;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.04em;
    padding-top: 2px;
}
.info-row .ir-value {
    flex: 1;
    font-size: 0.88rem;
    font-weight: 600;
    color: #374151;
    line-height: 1.5;
}

/* ─── Product Items ─── */
.product-retur-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.9rem 0;
    border-bottom: 1px solid #f3f4f6;
    gap: 1rem;
}
.product-retur-item:last-child { border-bottom: none; }
.pri-info {
    display: flex;
    align-items: center;
    gap: 12px;
    flex: 1;
    min-width: 0;
}
.pri-icon {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, #f5f0ec, #fce4ec);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.pri-icon i { color: #cf7e7e; font-size: 0.85rem; }
.pri-name {
    font-weight: 700;
    font-size: 0.88rem;
    color: #1a1a2e;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}
.pri-qty {
    font-size: 0.78rem;
    color: #9ca3af;
    font-weight: 500;
    white-space: nowrap;
}
.pri-refund {
    font-weight: 800;
    font-size: 0.95rem;
    color: #cf7e7e;
    white-space: nowrap;
}

/* ─── Total Row ─── */
.rd-total-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    background: linear-gradient(135deg, #fdf2f8, #fce4ec);
    border-top: 2px solid #f5f0ec;
}
.rd-total-row .total-label {
    font-weight: 700;
    font-size: 0.85rem;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.rd-total-row .total-value {
    font-weight: 800;
    font-size: 1.15rem;
    color: #b76e79;
}

/* ─── Photo Card ─── */
.rd-photo-body {
    padding: 1.25rem;
    text-align: center;
}
.rd-photo-body img {
    max-height: 320px;
    border-radius: 12px;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    transition: transform 0.3s;
    cursor: zoom-in;
}
.rd-photo-body img:hover { transform: scale(1.03); }

/* ─── Admin Notes ─── */
.admin-note-box {
    background: #fefce8;
    border: 1px solid #fde68a;
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-top: 0.5rem;
}
.admin-note-box .anb-title {
    display: flex;
    align-items: center;
    gap: 6px;
    font-weight: 700;
    font-size: 0.82rem;
    color: #854d0e;
    margin-bottom: 6px;
}
.admin-note-box .anb-text {
    font-size: 0.85rem;
    color: #92400e;
    line-height: 1.6;
}

/* ─── Responsive ─── */
@media (max-width: 768px) {
    .rd-hero h1 { font-size: 1.3rem; }
    .info-row { flex-direction: column; gap: 2px; }
    .info-row .ir-label { width: auto; }
    .product-retur-item { flex-wrap: wrap; }
    .rd-status-banner { flex-direction: column; text-align: center; }
}
</style>
@endpush

@section('content')
@php
    $statusConfig = [
        'pending' => [
            'class' => 'sb-pending',
            'icon' => 'fas fa-clock',
            'title' => 'Menunggu Verifikasi',
            'desc' => 'Pengajuan retur Anda sedang menunggu peninjauan admin'
        ],
        'approved' => [
            'class' => 'sb-approved',
            'icon' => 'fas fa-check-circle',
            'title' => 'Retur Disetujui',
            'desc' => 'Retur Anda telah disetujui, silakan proses pengembalian produk'
        ],
        'rejected' => [
            'class' => 'sb-rejected',
            'icon' => 'fas fa-times-circle',
            'title' => 'Retur Ditolak',
            'desc' => 'Maaf, pengajuan retur Anda tidak disetujui'
        ],
        'completed' => [
            'class' => 'sb-completed',
            'icon' => 'fas fa-check-double',
            'title' => 'Retur Selesai',
            'desc' => 'Proses retur dan pengembalian dana telah selesai'
        ],
        'cancelled' => [
            'class' => 'sb-cancelled',
            'icon' => 'fas fa-ban',
            'title' => 'Retur Dibatalkan',
            'desc' => 'Pengajuan retur telah dibatalkan'
        ],
    ];
    $sc = $statusConfig[$retur->status] ?? $statusConfig['pending'];

    $reasons = [
        'defective' => 'Produk Rusak / Cacat',
        'wrong_item' => 'Produk yang Dikirim Salah',
        'not_as_description' => 'Tidak Sesuai Deskripsi',
        'size_issue' => 'Masalah Ukuran',
        'other' => 'Lainnya'
    ];
@endphp

<!-- Hero Banner -->
<div class="rd-hero">
    <div class="container">
        <h1><i class="fas fa-file-alt"></i> Detail Retur</h1>
        <div class="breadcrumb-text">
            <a href="{{ route('home') }}">Beranda</a> / <a href="{{ route('returs.index') }}">Riwayat Retur</a> / {{ $retur->retur_number }}
        </div>
    </div>
</div>

<div class="rd-wrapper">
    <a href="{{ route('returs.index') }}" class="btn-back">
        <i class="fas fa-arrow-left"></i> Kembali ke Riwayat
    </a>

    <!-- Status Banner -->
    <div class="rd-status-banner {{ $sc['class'] }}">
        <div class="status-icon-wrap">
            <i class="{{ $sc['icon'] }}"></i>
        </div>
        <div class="status-text">
            <h4>{{ $sc['title'] }}</h4>
            <p>{{ $sc['desc'] }}</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Left Column -->
        <div class="col-lg-6">
            <!-- Retur Info Card -->
            <div class="rd-card">
                <div class="rd-card-header">
                    <i class="fas fa-info-circle"></i>
                    <h5>Informasi Retur</h5>
                </div>
                <div class="rd-card-body">
                    <div class="info-row">
                        <div class="ir-label">No. Retur</div>
                        <div class="ir-value" style="font-family: monospace; color: #cf7e7e;">{{ $retur->retur_number }}</div>
                    </div>
                    <div class="info-row">
                        <div class="ir-label">Invoice</div>
                        <div class="ir-value">{{ $retur->transaction->invoice_number }}</div>
                    </div>
                    <div class="info-row">
                        <div class="ir-label">Tgl. Pengajuan</div>
                        <div class="ir-value">{{ $retur->created_at->format('d M Y, H:i') }} WIB</div>
                    </div>
                    <div class="info-row">
                        <div class="ir-label">Alasan</div>
                        <div class="ir-value">{{ $reasons[$retur->reason] ?? $retur->reason }}</div>
                    </div>
                    @if($retur->description)
                    <div class="info-row">
                        <div class="ir-label">Keterangan</div>
                        <div class="ir-value">{{ $retur->description }}</div>
                    </div>
                    @endif
                </div>
            </div>

            @if($retur->admin_notes)
            <div class="admin-note-box">
                <div class="anb-title">
                    <i class="fas fa-comment-dots"></i> Catatan Admin
                </div>
                <div class="anb-text">{{ $retur->admin_notes }}</div>
            </div>
            @endif
        </div>

        <!-- Right Column -->
        <div class="col-lg-6">
            <!-- Products Card -->
            <div class="rd-card">
                <div class="rd-card-header alt">
                    <i class="fas fa-box-open"></i>
                    <h5>Produk yang Diretur</h5>
                </div>
                <div class="rd-card-body" style="padding-bottom:0;">
                    @foreach($retur->items as $item)
                    <div class="product-retur-item">
                        <div class="pri-info">
                            <div class="pri-icon">
                                <i class="fas fa-cube"></i>
                            </div>
                            <div>
                                <div class="pri-name">{{ $item->transactionDetail->product->name }}</div>
                                <div class="pri-qty">{{ $item->quantity }} pcs</div>
                            </div>
                        </div>
                        <div class="pri-refund">Rp {{ number_format($item->refund_amount, 0, ',', '.') }}</div>
                    </div>
                    @endforeach
                </div>
                <div class="rd-total-row">
                    <span class="total-label">Total Refund</span>
                    <span class="total-value">Rp {{ number_format($retur->items->sum('refund_amount'), 0, ',', '.') }}</span>
                </div>
            </div>

            @if($retur->proof_image)
            <!-- Photo Card -->
            <div class="rd-card">
                <div class="rd-card-header photo">
                    <i class="fas fa-camera"></i>
                    <h5>Bukti Foto</h5>
                </div>
                <div class="rd-photo-body">
                    <img src="{{ asset('storage/' . $retur->proof_image) }}" alt="Bukti foto retur" class="img-fluid">
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection