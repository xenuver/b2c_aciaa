@extends('layouts.admin')

@section('title', 'Kelola Banner')

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
.pm-alert button {
    margin-left: auto; background: none; border: none;
    cursor: pointer; color: inherit; font-size: 18px; line-height: 1;
}

.pm-card {
    background: #fff; border: 1px solid #e5e7eb;
    border-radius: 14px; overflow: hidden;
    box-shadow: 0 1px 4px rgba(0,0,0,.05);
}
.pm-card-header {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #f3f4f6;
    flex-wrap: wrap; gap: 10px;
}
.pm-card-title { font-size: 14px; font-weight: 700; color: #111827; }

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

.prod-thumb {
    width: 72px; height: 44px; border-radius: 6px;
    object-fit: cover; border: 1px solid #e5e7eb; flex-shrink: 0;
}
.prod-thumb-placeholder {
    width: 72px; height: 44px; border-radius: 6px;
    background: #f3f4f6; border: 1px solid #e5e7eb;
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}

.badge-pill {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; font-weight: 600;
    padding: 3px 9px; border-radius: 99px; white-space: nowrap;
}
.bp-active   { background: #dcfce7; color: #166534; }
.bp-expired  { background: #f3f4f6; color: #6b7280; }
.bp-upcoming { background: #eff6ff; color: #1e40af; }
.bp-inactive { background: #fee2e2; color: #991b1b; }
.dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
.dot-green { background: #16a34a; }
.dot-gray  { background: #6b7280; }
.dot-blue  { background: #2563eb; }
.dot-red   { background: #dc2626; }

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

.empty-state { text-align: center; padding: 3.5rem 1rem; color: #9ca3af; }
.empty-state p { margin: .5rem 0 0; font-size: 14px; }
</style>

<div class="pm-page">
    {{-- Top bar --}}
    <div class="pm-topbar">
        <div>
            <h1 class="pm-title">Kelola Banner</h1>
            <p class="pm-subtitle">Kelola banner promo halaman utama website</p>
        </div>
        <a href="{{ route('admin.banners.create') }}" class="btn-tambah">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2.5"
                 stroke-linecap="round" stroke-linejoin="round">
                <path d="M12 5v14M5 12h14"/>
            </svg>
            Tambah Banner
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

    {{-- Card --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <span class="pm-card-title">Daftar Banner</span>
        </div>

        <div class="table-responsive">
            <table class="pm-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Banner</th>
                        <th>Judul</th>
                        <th>Link Tujuan</th>
                        <th>Urutan</th>
                        <th>Periode Aktif</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($banners as $banner)
                    <tr>
                        <td>{{ $banner->id }}</td>
                        <td>
                            @if($banner->image)
                                <img src="{{ url('render-image?path=' . $banner->image) }}" class="prod-thumb" alt="{{ $banner->title }}">
                            @else
                                <div class="prod-thumb-placeholder">
                                    <i class="far fa-image text-muted" style="font-size:16px;"></i>
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold text-dark">{{ $banner->title }}</td>
                        <td>
                            @if($banner->link)
                                <a href="{{ $banner->link }}" target="_blank" class="text-primary small" style="text-decoration:underline;">
                                    {{ Str::limit($banner->link, 30) }}
                                </a>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>
                        <td class="fw-bold">{{ $banner->order }}</td>
                        <td class="small">
                            @if($banner->start_date || $banner->end_date)
                                <span>{{ $banner->start_date ? date('d/m/Y', strtotime($banner->start_date)) : 'Mulai' }}</span><br>
                                <span class="text-muted">s/d</span><br>
                                <span class="fw-medium">{{ $banner->end_date ? date('d/m/Y', strtotime($banner->end_date)) : 'Selamanya' }}</span>
                            @else
                                <span class="text-success fw-medium">Selamanya</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $isExpired = $banner->end_date && $banner->end_date < date('Y-m-d');
                                $isNotStarted = $banner->start_date && $banner->start_date > date('Y-m-d');
                            @endphp
                            @if($banner->is_active && !$isExpired && !$isNotStarted)
                                <span class="badge-pill bp-active">
                                    <span class="dot dot-green"></span> Aktif
                                </span>
                            @elseif($isExpired)
                                <span class="badge-pill bp-expired">
                                    <span class="dot dot-gray"></span> Expired
                                </span>
                            @elseif($isNotStarted)
                                <span class="badge-pill bp-upcoming">
                                    <span class="dot dot-blue"></span> Scheduled
                                </span>
                            @else
                                <span class="badge-pill bp-inactive">
                                    <span class="dot dot-red"></span> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;align-items:center">
                                <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn-act btn-act-edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12"
                                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                         stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.banners.destroy', $banner->id) }}"
                                      method="POST" style="margin:0;display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-act btn-act-del"
                                        onclick="return confirm('Yakin ingin menghapus banner ini?')">
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
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="far fa-images fa-2x mb-2 text-muted"></i>
                                <p>Belum ada banner tersedia.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pm-footer">
            {{ $banners->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection