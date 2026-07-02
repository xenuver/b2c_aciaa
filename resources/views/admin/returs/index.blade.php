@extends('layouts.admin')

@section('title', 'Kelola Retur')

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
.bp-pending   { background: #fffbeb; color: #d97706; }
.bp-approved  { background: #eff6ff; color: #1e40af; }
.bp-completed { background: #dcfce7; color: #166534; }
.bp-rejected  { background: #fee2e2; color: #991b1b; }
.dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.dot-amber { background: #d97706; }
.dot-blue  { background: #2563eb; }
.dot-green { background: #16a34a; }
.dot-red   { background: #dc2626; }

.btn-act {
    display: inline-flex; align-items: center; gap: 5px;
    font-size: 12px; font-weight: 600;
    padding: 6px 12px; border-radius: 8px;
    cursor: pointer; text-decoration: none;
    transition: background .15s, color .15s;
    white-space: nowrap; border: 1px solid;
}
.btn-act-process { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
.btn-act-process:hover { background: #dbeafe; }

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

.empty-state { text-align: center; padding: 3.5rem 1rem; color: #9ca3af; }
.empty-state p { margin: .5rem 0 0; font-size: 14px; }
</style>

<div class="pm-page">
    {{-- Top bar --}}
    <div class="pm-topbar">
        <div>
            <h1 class="pm-title">Kelola Pengajuan Retur</h1>
            <p class="pm-subtitle">Kelola pengembalian barang dan dana pelanggan</p>
        </div>
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
                    @foreach($statuses as $status)
                        <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <a href="{{ route('admin.returs.index') }}" class="btn-secondary-custom">
                <i class="fas fa-sync me-1"></i> Reset
            </a>
        </form>
    </div>

    {{-- Card --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <span class="pm-card-title">Daftar Retur</span>
        </div>

        <div class="table-responsive">
            <table class="pm-table">
                <thead>
                    <tr>
                        <th>No. Retur</th>
                        <th>Pelanggan</th>
                        <th>Invoice</th>
                        <th>Alasan Retur</th>
                        <th>Tanggal Pengajuan</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($returs as $retur)
                    <tr>
                        <td><code class="fw-bold">{{ $retur->retur_number }}</code></td>
                        <td>
                            <div class="fw-semibold text-dark">{{ $retur->user->name ?? '-' }}</div>
                            <div class="text-muted small">{{ $retur->user->email ?? '-' }}</div>
                        </td>
                        <td><code>{{ $retur->transaction->invoice_number }}</code></td>
                        <td class="text-gray-800">{{ ucfirst($retur->reason) }}</td>
                        <td class="small">{{ $retur->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            @if($retur->status === 'pending')
                                <span class="badge-pill bp-pending">
                                    <span class="dot dot-amber"></span> Pending
                                </span>
                            @elseif($retur->status === 'approved')
                                <span class="badge-pill bp-approved">
                                    <span class="dot dot-blue"></span> Disetujui
                                </span>
                            @elseif($retur->status === 'completed')
                                <span class="badge-pill bp-completed">
                                    <span class="dot dot-green"></span> Selesai
                                </span>
                            @elseif($retur->status === 'rejected')
                                <span class="badge-pill bp-rejected">
                                    <span class="dot dot-red"></span> Ditolak
                                </span>
                            @else
                                <span class="badge-pill bg-light text-dark">
                                    {{ ucfirst($retur->status) }}
                                </span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.returs.show', $retur->id) }}" class="btn-act btn-act-process">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                Proses
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <i class="fas fa-undo fa-2x mb-2 text-muted"></i>
                                <p>Belum ada pengajuan retur.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pm-footer">
            {{ $returs->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection