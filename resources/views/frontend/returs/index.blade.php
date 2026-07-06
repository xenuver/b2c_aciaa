@extends('layouts.app')

@section('title', 'Riwayat Retur')

@push('styles')
<style>
/* ─── Retur History Premium Theme ─── */
.rh-hero {
    background: linear-gradient(135deg, #111111 0%, #1a1a1a 50%, #2a2a2a 100%);
    padding: 2.5rem 0 3rem;
    position: relative;
    overflow: hidden;
}
.rh-hero::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -15%;
    width: 420px;
    height: 420px;
    background: radial-gradient(circle, rgba(194,24,91,0.15) 0%, transparent 70%);
    border-radius: 50%;
}
.rh-hero h1 {
    font-family: 'Montserrat', sans-serif;
    font-size: 1.75rem;
    font-weight: 800;
    color: #fff;
    margin: 0;
    letter-spacing: -0.5px;
}
.rh-hero h1 i { color: var(--color-primary); margin-right: 10px; }
.rh-hero .breadcrumb-text {
    font-size: 0.85rem;
    color: rgba(255,255,255,0.55);
    margin-top: 6px;
}
.rh-hero .breadcrumb-text a { color: var(--color-primary); text-decoration: none; }

.rh-wrapper {
    font-family: 'Montserrat', sans-serif;
    max-width: 1140px;
    margin: -2rem auto 3rem;
    padding: 0 1rem;
    position: relative;
    z-index: 2;
}

/* ─── Top Actions ─── */
.rh-topbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.25rem;
    flex-wrap: wrap;
    gap: 10px;
}
.rh-count {
    font-size: 0.8rem;
    color: #9ca3af;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}
.btn-ajukan {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 10px 22px;
    background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light));
    color: #fff;
    border: none;
    border-radius: 12px;
    font-weight: 700;
    font-size: 0.85rem;
    font-family: 'Montserrat', sans-serif;
    cursor: pointer;
    transition: all 0.2s;
    text-decoration: none;
    box-shadow: 0 4px 16px rgba(194,24,91,0.3);
}
.btn-ajukan:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(194,24,91,0.4);
    color: #fff;
}

/* ─── Alert ─── */
.rh-alert {
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
.rh-alert i { color: #16a34a; }
@keyframes slideDown {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ─── Retur Cards ─── */
.retur-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
    border: 1px solid rgba(0,0,0,0.04);
    overflow: hidden;
    margin-bottom: 1rem;
    transition: all 0.2s;
}
.retur-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
}

.retur-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f3f4f6;
    flex-wrap: wrap;
    gap: 8px;
}
.retur-card-number {
    display: flex;
    align-items: center;
    gap: 10px;
}
.retur-card-number .rn-icon {
    width: 36px;
    height: 36px;
    border-radius: 10px;
    background: linear-gradient(135deg, #f5f0ec, #fce4ec);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}
.retur-card-number .rn-icon i { color: var(--color-primary); font-size: 0.9rem; }
.retur-card-number .rn-info h6 {
    margin: 0;
    font-weight: 700;
    font-size: 0.9rem;
    color: #1a1a2e;
}
.retur-card-number .rn-info span {
    font-size: 0.75rem;
    color: #9ca3af;
}

/* Status Badges */
.status-pill {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 5px 14px;
    border-radius: 99px;
    font-size: 0.72rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.04em;
}
.status-pill .dot {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    flex-shrink: 0;
}
.sp-pending  { background: #fef9c3; color: #854d0e; }
.sp-pending .dot { background: #ca8a04; }
.sp-approved { background: #dcfce7; color: #166534; }
.sp-approved .dot { background: #16a34a; }
.sp-rejected { background: #fee2e2; color: #991b1b; }
.sp-rejected .dot { background: #dc2626; }
.sp-completed { background: #dbeafe; color: #1e40af; }
.sp-completed .dot { background: #2563eb; }
.sp-cancelled { background: #f3f4f6; color: #6b7280; }
.sp-cancelled .dot { background: #9ca3af; }

.retur-card-body {
    padding: 1rem 1.25rem;
    display: flex;
    align-items: center;
    gap: 2rem;
    flex-wrap: wrap;
}
.retur-detail-item {
    display: flex;
    flex-direction: column;
    gap: 2px;
}
.retur-detail-item .rd-label {
    font-size: 0.68rem;
    font-weight: 600;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.06em;
}
.retur-detail-item .rd-value {
    font-size: 0.85rem;
    font-weight: 600;
    color: #374151;
}

.retur-card-footer {
    padding: 0.75rem 1.25rem;
    border-top: 1px solid #f3f4f6;
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 8px;
}

/* ─── Action Buttons ─── */
.btn-retur-detail {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 18px;
    background: linear-gradient(135deg, #1a1a2e, #16213e);
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.78rem;
    text-decoration: none;
    transition: all 0.2s;
    cursor: pointer;
}
.btn-retur-detail:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(26,26,46,0.25);
    color: #fff;
}
.btn-retur-cancel {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 18px;
    background: #fff;
    color: #dc2626;
    border: 1.5px solid #fecaca;
    border-radius: 10px;
    font-weight: 600;
    font-size: 0.78rem;
    text-decoration: none;
    transition: all 0.15s;
    cursor: pointer;
    font-family: 'Montserrat', sans-serif;
}
.btn-retur-cancel:hover {
    background: #fef2f2;
    border-color: #fca5a5;
}

/* ─── Empty State ─── */
.rh-empty {
    text-align: center;
    padding: 4rem 2rem;
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.06);
}
.rh-empty-icon {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    background: linear-gradient(135deg, #f5f0ec, #fce4ec);
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
}
.rh-empty-icon i { font-size: 2.5rem; color: var(--color-primary); }
.rh-empty h3 { font-weight: 800; color: #1a1a2e; margin-bottom: 0.5rem; font-family: 'Montserrat', sans-serif; }
.rh-empty p { color: #9ca3af; font-size: 0.9rem; margin-bottom: 1.5rem; }

/* ─── Pagination ─── */
.rh-pagination .pagination {
    gap: 4px;
    margin: 0;
}
.rh-pagination .page-link {
    border-radius: 10px !important;
    font-size: 0.82rem;
    font-weight: 600;
    padding: 8px 14px;
    border: 1px solid #e5e7eb;
    color: #374151;
}
.rh-pagination .page-item.active .page-link {
    background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light));
    border-color: var(--color-primary);
    color: #fff;
}

/* ─── Responsive ─── */
@media (max-width: 768px) {
    .rh-hero h1 { font-size: 1.4rem; }
    .retur-card-body { gap: 1rem; }
    .retur-card-footer { justify-content: stretch; flex-direction: column; }
    .retur-card-footer > * { width: 100%; justify-content: center; }
}
</style>
@endpush

@section('content')
<!-- Hero Banner -->
<div class="mb-4 rounded-4 px-4 py-5 mx-3 mx-md-0" style="background: linear-gradient(135deg, #111111 0%, #1a1a1a 50%, #2a2a2a 100%); position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
    <div style="position: absolute; top: -50px; right: -50px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(194,24,91,0.2) 0%, transparent 70%); border-radius: 50%;"></div>
    <h1 class="text-white mb-2 position-relative" style="font-family: var(--font-heading, 'Cormorant', serif); font-size: 2.2rem;"><i class="fas fa-exchange-alt me-3" style="color: var(--color-primary);"></i>Riwayat Retur</h1>
    <p class="text-white-50 mb-0 position-relative" style="font-size: 0.95rem;">Kelola dan pantau semua pengajuan retur Anda</p>
</div>

<div class="container my-4" style="max-width: 900px;">


    <div class="rh-topbar">
        <div class="rh-count">
            {{ $returs->total() ?? $returs->count() }} PENGAJUAN RETUR
        </div>
        <a href="{{ route('returs.create') }}" class="btn-ajukan">
            <i class="fas fa-plus"></i> Ajukan Retur Baru
        </a>
    </div>

    @if($returs->count() > 0)
        @php
            $reasons = [
                'defective' => 'Produk Rusak',
                'wrong_item' => 'Produk Salah',
                'not_as_description' => 'Tidak Sesuai Deskripsi',
                'size_issue' => 'Masalah Ukuran',
                'other' => 'Lainnya'
            ];
            $statusMap = [
                'pending' => 'sp-pending',
                'approved' => 'sp-approved',
                'rejected' => 'sp-rejected',
                'completed' => 'sp-completed',
                'cancelled' => 'sp-cancelled',
            ];
            $statusLabels = [
                'pending' => 'Menunggu',
                'approved' => 'Disetujui',
                'rejected' => 'Ditolak',
                'completed' => 'Selesai',
                'cancelled' => 'Dibatalkan',
            ];
        @endphp

        @foreach($returs as $retur)
        <div class="retur-card">
            <div class="retur-card-header">
                <div class="retur-card-number">
                    <div class="rn-icon">
                        <i class="fas fa-exchange-alt"></i>
                    </div>
                    <div class="rn-info">
                        <h6>{{ $retur->retur_number }}</h6>
                        <span>{{ $retur->created_at->format('d M Y, H:i') }}</span>
                    </div>
                </div>
                <span class="status-pill {{ $statusMap[$retur->status] ?? 'sp-pending' }}">
                    <span class="dot"></span>
                    {{ $statusLabels[$retur->status] ?? ucfirst($retur->status) }}
                </span>
            </div>

            <div class="retur-card-body">
                <div class="retur-detail-item">
                    <span class="rd-label">Invoice</span>
                    <span class="rd-value">{{ $retur->transaction->invoice_number }}</span>
                </div>
                <div class="retur-detail-item">
                    <span class="rd-label">Alasan</span>
                    <span class="rd-value">{{ $reasons[$retur->reason] ?? $retur->reason }}</span>
                </div>
                <div class="retur-detail-item">
                    <span class="rd-label">Tanggal</span>
                    <span class="rd-value">{{ $retur->created_at->format('d/m/Y') }}</span>
                </div>
            </div>

            <div class="retur-card-footer">
                @if($retur->status == 'pending')
                    <form action="{{ route('returs.cancel', $retur->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn-retur-cancel" onclick="return confirm('Batalkan pengajuan retur ini?')">
                            <i class="fas fa-times"></i> Batalkan
                        </button>
                    </form>
                @endif
                <a href="{{ route('returs.show', $retur->id) }}" class="btn-retur-detail">
                    <i class="fas fa-eye"></i> Lihat Detail
                </a>
            </div>
        </div>
        @endforeach

        <div class="rh-pagination mt-3 d-flex justify-content-center">
            {{ $returs->links() }}
        </div>
    @else
        <div class="rh-empty">
            <div class="rh-empty-icon">
                <i class="fas fa-box-open"></i>
            </div>
            <h3>Belum Ada Pengajuan Retur</h3>
            <p>Anda belum pernah mengajukan retur produk</p>
            <a href="{{ route('returs.create') }}" class="btn-ajukan">
                <i class="fas fa-plus"></i> Ajukan Retur
            </a>
        </div>
    @endif
</div>
@endsection