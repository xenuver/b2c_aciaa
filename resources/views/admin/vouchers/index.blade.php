@extends('layouts.admin')

@section('title', 'Kelola Voucher')

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
.pm-title { font-size: 20px; font-weight: 700; color: #111827; margin: 0 0 3px; }
.pm-subtitle { font-size: 13px; color: #6b7280; margin: 0; }

.btn-tambah {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 20px;
    background: #16a34a;
    color: #fff;
    font-size: 13px; font-weight: 600;
    border: none; border-radius: 10px;
    cursor: pointer; text-decoration: none;
    transition: background .15s, transform .1s, box-shadow .15s;
    box-shadow: 0 1px 3px rgba(22,163,74,.35), 0 4px 12px rgba(22,163,74,.2);
    white-space: nowrap;
}
.btn-tambah:hover {
    background: #15803d;
    box-shadow: 0 2px 6px rgba(22,163,74,.4), 0 6px 16px rgba(22,163,74,.25);
    transform: translateY(-1px);
    color: #fff; text-decoration: none;
}
.btn-tambah:active { transform: translateY(0); }
.btn-tambah svg { flex-shrink: 0; }

.pm-alert {
    display: flex; align-items: center; gap: 10px;
    background: #f0fdf4; border: 1px solid #bbf7d0;
    border-radius: 10px; padding: 12px 16px;
    font-size: 13px; color: #166534;
    margin-bottom: 1.5rem;
}
.pm-alert-danger {
    background: #fef2f2; border: 1px solid #fee2e2;
    color: #991b1b;
}
.pm-alert button {
    margin-left: auto; background: none; border: none;
    cursor: pointer; color: inherit; font-size: 18px; line-height: 1;
}

.pm-card {
    background: #fff; border: 1px solid #e5e7eb;
    border-radius: 14px; overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
    margin-bottom: 1.5rem;
}
.pm-card-header {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f3f4f6;
    flex-wrap: wrap; gap: 10px;
}
.pm-card-title { font-size: 14px; font-weight: 700; color: #111827; }

.pm-filters { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; padding: 1.25rem; background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; margin-bottom: 1.5rem; }
.pm-filter-group { display: flex; flex-direction: column; gap: 4px; }
.pm-filter-label { font-size: 11px; font-weight: 600; color: #4b5563; text-transform: uppercase; }
.pm-select {
    padding: 7px 28px 7px 10px;
    font-size: 13px; color: #374151;
    border: 1px solid #e5e7eb; border-radius: 9px;
    background: #f9fafb url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E") no-repeat right 8px center;
    appearance: none; outline: none; cursor: pointer;
    transition: border-color .15s;
    min-width: 150px;
}
.pm-select:focus { border-color: #6ee7b7; background-color: #fff; box-shadow: 0 0 0 3px rgba(22,163,74,.1); }

.btn-secondary-custom {
    display: inline-flex; align-items: center;
    padding: 7px 16px; background: #fff; border: 1px solid #d1d5db;
    border-radius: 9px; font-size: 13px; font-weight: 600; color: #374151;
    cursor: pointer; text-decoration: none; transition: background .15s;
}
.btn-secondary-custom:hover { background: #f9fafb; color: #111827; text-decoration: none; }

.pm-table { width: 100%; border-collapse: collapse; }
.pm-table thead th {
    font-size: 11px; font-weight: 700; color: #6b7280;
    text-transform: uppercase; letter-spacing: .06em;
    white-space: nowrap; padding: 10px 16px;
    background: #f9fafb; border-bottom: 1px solid #f3f4f6;
    text-align: left;
}
.pm-table tbody td {
    padding: 13px 16px; border-bottom: 1px solid #f3f4f6;
    vertical-align: middle; font-size: 13px; color: #374151;
}
.pm-table tbody tr:last-child td { border-bottom: none; }
.pm-table tbody tr:hover td { background: #fafafa; }

.badge-pill {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; font-weight: 600;
    padding: 3px 9px; border-radius: 99px; white-space: nowrap;
}
.bp-active   { background: #dcfce7; color: #166534; }
.bp-expired  { background: #fee2e2; color: #991b1b; }
.bp-inactive { background: #f3f4f6; color: #6b7280; }
.dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.dot-green { background: #16a34a; }
.dot-red   { background: #dc2626; }
.dot-gray  { background: #9ca3af; }

.btn-act {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 600;
    padding: 6px 12px; border-radius: 8px;
    cursor: pointer; text-decoration: none;
    transition: background .15s, color .15s;
    white-space: nowrap; border: 1px solid;
}
.btn-act-edit { background: #fff; border-color: #e5e7eb; color: #374151; }
.btn-act-edit:hover { background: #f9fafb; border-color: #d1d5db; color: #111827; text-decoration: none; }
.btn-act-info { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
.btn-act-info:hover { background: #dbeafe; }
.btn-act-del  { background: #fff0f0; border-color: #fecaca; color: #dc2626; }
.btn-act-del:hover { background: #fee2e2; border-color: #fca5a5; }

.pm-footer {
    display: flex;
    align-items: center;
    padding: .875rem 1.25rem;
    border-top: 1px solid #f3f4f6;
    min-height: 56px;
}
.pm-footer .pagination {
    margin: 0 !important;
    padding: 0;
    display: flex;
    align-items: center;
    gap: 4px;
    list-style: none;
}
.pm-footer .page-item .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    height: 32px;
    min-width: 32px;
    padding: 0 10px;
    font-size: 12px;
    font-weight: 500;
    line-height: 1;
    border-radius: 8px !important;
    border: 1px solid #e5e7eb;
    color: #374151;
    background: #fff;
    transition: background .15s;
    text-decoration: none;
}
.pm-footer .page-item.active .page-link {
    background: #16a34a;
    border-color: #16a34a;
    color: #fff;
}
.pm-footer .page-item.disabled .page-link {
    color: #d1d5db;
    pointer-events: none;
}
.pm-footer .page-item .page-link:hover {
    background: #f3f4f6;
}

.expired-row {
    background-color: #fafafa !important;
    opacity: 0.8;
}

.empty-state { text-align: center; padding: 3.5rem 1rem; color: #9ca3af; }
.empty-state p { margin: .5rem 0 0; font-size: 14px; }
</style>

<div class="pm-page">
    {{-- Top bar --}}
    <div class="pm-topbar">
        <div>
            <h1 class="pm-title">Kelola Voucher</h1>
            <p class="pm-subtitle">Kelola kode diskon & voucher belanja pelanggan</p>
        </div>
        <a href="{{ route('admin.vouchers.create') }}" class="btn-tambah">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2.5"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Tambah Voucher
        </a>
    </div>

    {{-- Alert --}}
    @if(session('success'))
    <div class="pm-alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round">
            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
            <polyline points="22 4 12 14.01 9 11.01"/>
        </svg>
        {{ session('success') }}
        <button onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    @if(session('error'))
    <div class="pm-alert pm-alert-danger">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2"
             stroke-linecap="round" stroke-linejoin="round">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        {{ session('error') }}
        <button onclick="this.parentElement.remove()">×</button>
    </div>
    @endif

    {{-- Filter --}}
    <div class="pm-filters">
        <form method="GET" class="d-flex align-items-end gap-3 flex-wrap m-0">
            <div class="pm-filter-group">
                <span class="pm-filter-label">Filter Status</span>
                <select name="status" class="pm-select" onchange="this.form.submit()">
                    <option value="">Semua</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>
            <a href="{{ route('admin.vouchers.index') }}" class="btn-secondary-custom">
                <i class="fas fa-sync me-1"></i> Reset
            </a>
        </form>
    </div>

    {{-- Card --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <span class="pm-card-title">Daftar Voucher</span>
        </div>

        <div class="table-responsive">
            <table class="pm-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Kode</th>
                        <th>Nama Voucher</th>
                        <th>Nominal Diskon</th>
                        <th>Min. Belanja</th>
                        <th>Min. Qty</th>
                        <th>Maks. Potongan</th>
                        <th>Kuota Terpakai</th>
                        <th>Penerima</th>
                        <th>Masa Berlaku</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vouchers as $voucher)
                    @php
                        $isExpired = $voucher->expiry_date < date('Y-m-d');
                    @endphp
                    <tr class="@if($isExpired) expired-row @endif">
                        <td>{{ $voucher->id }}</td>
                        <td><code class="fw-bold px-2 py-1 bg-light text-danger rounded border border-danger-subtle">{{ $voucher->code }}</code></td>
                        <td class="fw-semibold text-dark">{{ $voucher->name }}</td>
                        <td>
                            @if($voucher->type == 'percentage')
                                <span class="fw-bold text-success">{{ $voucher->value }}%</span>
                            @elseif($voucher->type == 'free_shipping')
                                <span class="badge bg-info text-white"><i class="fas fa-truck me-1"></i>Gratis Ongkir</span>
                            @else
                                <span class="fw-bold">Rp {{ number_format($voucher->value, 0, ',', '.') }}</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($voucher->min_purchase, 0, ',', '.') }}</td>
                        <td>
                            @if($voucher->min_qty > 0)
                                <span class="fw-medium">{{ $voucher->min_qty }} produk</span>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($voucher->max_discount)
                                Rp {{ number_format($voucher->max_discount, 0, ',', '.') }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td class="small">
                            {{ $voucher->used_count }} / 
                            @if($voucher->max_usage)
                                <span class="fw-medium text-dark">{{ $voucher->max_usage }}</span>
                            @else
                                <span class="text-muted">∞</span>
                            @endif
                        </td>
                        <td>
                            @if($voucher->user_type === 'active_user')
                                <span class="badge-pill" style="background:#fef3c7;color:#92400e;">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                    Aktif (Min. {{ $voucher->min_completed_orders }} Selesai)
                                </span>
                            @else
                                <span class="text-muted small">Semua</span>
                            @endif
                        </td>
                        <td class="small font-monospace">{{ date('d/m/Y', strtotime($voucher->expiry_date)) }}</td>
                        <td>
                            @if(!$voucher->is_active)
                                <span class="badge-pill bp-inactive">
                                    <span class="dot dot-gray"></span> Nonaktif
                                </span>
                            @elseif($isExpired)
                                <span class="badge-pill bp-expired">
                                    <span class="dot dot-red"></span> Kadaluarsa
                                </span>
                            @else
                                <span class="badge-pill bp-active">
                                    <span class="dot dot-green"></span> Aktif
                                </span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;align-items:center">
                                <a href="{{ route('admin.vouchers.edit', $voucher->id) }}" class="btn-act btn-act-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                    Edit
                                </a>
                                <a href="{{ route('admin.vouchers.usage', $voucher->id) }}" class="btn-act btn-act-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg>
                                    Laporan
                                </a>
                                <form action="{{ route('admin.vouchers.destroy', $voucher->id) }}"
                                      method="POST" style="margin:0;display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-act btn-act-del"
                                        onclick="return confirm('Yakin ingin menghapus voucher ini?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                             stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                            <path d="M10 11v6M14 11v6"/>
                                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="12">
                            <div class="empty-state">
                                <i class="fas fa-ticket-alt fa-2x mb-2 text-muted"></i>
                                <p>Belum ada voucher tersedia.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pm-footer">
            {{ $vouchers->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection