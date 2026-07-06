@extends('layouts.admin')

@section('title', 'Kelola Pengguna')

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
.pm-title { font-size: 20px; font-weight: 700; color: var(--text-main, #831843); margin: 0 0 3px; }
.pm-subtitle { font-size: 13px; color: var(--primary-light, #F472B6); margin: 0; }

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
 backdrop-filter: blur(10px); background: var(--glass-bg, rgba(255, 255, 255, 0.7)); border-color: var(--glass-border, rgba(255, 255, 255, 0.4)); box-shadow: 0 4px 15px rgba(219, 39, 119, 0.03); }
.pm-card-header {
    display: flex; align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid var(--glass-border, rgba(255, 255, 255, 0.4));
    flex-wrap: wrap; gap: 10px;
}
.pm-card-title { font-size: 14px; font-weight: 700; color: var(--text-main, #831843); }

.pm-filters { display: flex; align-items: center; gap: 12px; flex-wrap: wrap; padding: 1.25rem; background: #fff; border: 1px solid #e5e7eb; border-radius: 14px; margin-bottom: 1.5rem; }
.pm-filter-group { display: flex; flex-direction: column; gap: 4px; }
.pm-filter-label { font-size: 11px; font-weight: 600; color: #4b5563; text-transform: uppercase; }
.search-input {
    padding: 7px 12px 7px 32px;
    font-size: 13px; color: #374151;
    border: 1px solid #e5e7eb;
    border-radius: 9px; background: rgba(255, 255, 255, 0.3); backdrop-filter: blur(5px);
    width: 200px; outline: none;
    transition: border-color .15s, background .15s;
}
.search-input:focus { border-color: #6ee7b7; background: #fff; box-shadow: 0 0 0 3px rgba(22,163,74,.1); }
.search-wrap { position: relative; display: flex; align-items: center; }
.search-wrap svg {
    position: absolute; left: 10px;
    pointer-events: none; color: #9ca3af;
    width: 15px; height: 15px;
}
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


.pm-table { width: 100%; border-collapse: collapse; }
.pm-table thead th {
    font-size: 11px; font-weight: 700; color: var(--primary-light, #F472B6);
    text-transform: uppercase; letter-spacing: .06em;
    white-space: nowrap; padding: 10px 16px;
    background: rgba(255, 255, 255, 0.3); backdrop-filter: blur(5px); border-bottom: 1px solid var(--glass-border, rgba(255, 255, 255, 0.4));
    text-align: left;
}
.pm-table tbody td {
    padding: 13px 16px; border-bottom: 1px solid var(--glass-border, rgba(255, 255, 255, 0.4));
    vertical-align: middle; font-size: 13px; color: #374151;
}
.pm-table tbody tr:last-child td { border-bottom: none; }
.pm-table tbody tr:hover td { background: rgba(244, 114, 182, 0.05); }

.user-avatar {
    width: 38px; height: 38px; border-radius: 50%;
    object-fit: cover; border: 1px solid #e5e7eb; flex-shrink: 0;
}
.avatar-placeholder {
    width: 38px; height: 38px; border-radius: 50%;
    background: linear-gradient(135deg, #d4a5a5, #b5838d);
    color: white; display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 14px; flex-shrink: 0;
}

.badge-pill {
    display: inline-flex; align-items: center; gap: 4px;
    font-size: 11px; font-weight: 600;
    padding: 3px 9px; border-radius: 99px; white-space: nowrap;
}
.bp-active   { background: #dcfce7; color: #166534; }
.bp-inactive { background: #fee2e2; color: #991b1b; }
.dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
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
.btn-act-edit { background: #fff; border-color: #e5e7eb; color: #374151; }
.btn-act-edit:hover { background: rgba(255, 255, 255, 0.3); backdrop-filter: blur(5px); border-color: #d1d5db; color: var(--text-main, #831843); text-decoration: none; }
.btn-act-info { background: #eff6ff; border-color: #bfdbfe; color: #1d4ed8; }
.btn-act-info:hover { background: #dbeafe; }
.btn-act-warn { background: #fffbeb; border-color: #fde68a; color: #d97706; }
.btn-act-warn:hover { background: #fef3c7; }
.btn-act-green { background: #f0fdf4; border-color: #bbf7d0; color: #16a34a; }
.btn-act-green:hover { background: #dcfce7; }
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
            <h1 class="pm-title">Kelola Pengguna</h1>
            <p class="pm-subtitle">Kelola dan pantau data pengguna terdaftar</p>
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

    {{-- Filter Form --}}
    <div class="pm-filters">
        <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex align-items-end gap-3 flex-wrap m-0">
            <div class="pm-filter-group">
                <span class="pm-filter-label">Cari Pengguna</span>
                <div class="search-wrap">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                         fill="none" stroke="currentColor" stroke-width="2"
                         stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"/>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="search" class="search-input" placeholder="Nama atau Email" value="{{ request('search') }}">
                </div>
            </div>
            
            <div class="pm-filter-group">
                <span class="pm-filter-label">Status Verifikasi</span>
                <select name="verified" class="pm-select">
                    <option value="">Semua</option>
                    <option value="verified" {{ request('verified') == 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                    <option value="unverified" {{ request('verified') == 'unverified' ? 'selected' : '' }}>Belum Verifikasi</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Filter
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-sync"></i> Reset
                </a>
            </div>
        </form>
    </div>

    {{-- Card --}}
    <div class="pm-card">
        <div class="pm-card-header">
            <span class="pm-card-title">Daftar Pengguna</span>
        </div>

        <div class="table-responsive">
            <table class="pm-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Avatar</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Nomor Telepon</th>
                        <th>Tanggal Terdaftar</th>
                        <th>Status Akun</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>
                            @if($user->avatar)
                                <img src="{{ url('render-image?path=' . $user->avatar) }}" class="user-avatar" alt="{{ $user->name }}">
                            @else
                                <div class="avatar-placeholder">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                        </td>
                        <td class="fw-semibold text-dark">{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td class="small">{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            @if($user->email_verified_at)
                                <span class="badge-pill bp-active">
                                    <span class="dot dot-green"></span> Aktif
                                </span>
                            @else
                                <span class="badge-pill bp-inactive">
                                    <span class="dot dot-red"></span> Nonaktif
                                </span>
                            @endif
                        </td>
                        <td>
                            <div style="display:flex;gap:6px;align-items:center">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="btn-act btn-act-info">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn-act btn-act-edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                @if($user->email_verified_at)
                                    <form action="{{ route('admin.users.update-status', $user->id) }}" method="POST" style="margin:0;display:inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="is_active" value="0">
                                        <button type="submit" class="btn-act btn-act-warn" onclick="return confirm('Nonaktifkan user ini?')">
                                            <i class="fas fa-ban"></i> Blokir
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.users.update-status', $user->id) }}" method="POST" style="margin:0;display:inline">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="is_active" value="1">
                                        <button type="submit" class="btn-act btn-act-green" onclick="return confirm('Aktifkan user ini?')">
                                            <i class="fas fa-check"></i> Aktifkan
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="margin:0;display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-act btn-act-del" onclick="return confirm('Yakin hapus user ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-users fa-2x mb-2 text-muted"></i>
                                <p>Belum ada pengguna terdaftar.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pm-footer">
            {{ $users->appends(request()->query())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>
@endsection