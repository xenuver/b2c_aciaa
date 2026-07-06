@extends('layouts.admin')

@section('title', 'Edit User - ' . $user->name)

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
.pm-form-card {
    background: var(--glass-bg, #fff);
    border: 1px solid var(--glass-border, #E5E7EB);
    border-radius: 16px; overflow: hidden;
    backdrop-filter: blur(10px);
    box-shadow: 0 4px 15px rgba(219,39,119,0.03);
}
.pm-form-card-header {
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--glass-border, #E5E7EB);
    font-weight: 700; font-size: 0.9rem;
    color: var(--text-main, #1F2937);
    background: #F9FAFB;
}
.pm-form-body { padding: 1.5rem; }
.btn-tambah {
    display: inline-flex; align-items: center; gap: 8px;
    padding: 10px 20px;
    background: linear-gradient(135deg, var(--primary, #DB2777), var(--cta, #CA8A04));
    color: #fff; font-size: 13px; font-weight: 600;
    border: none; border-radius: 10px; cursor: pointer;
    text-decoration: none;
    transition: background .15s, transform .1s, box-shadow .15s;
    box-shadow: 0 4px 15px rgba(219,39,119,0.3);
    white-space: nowrap;
}
.btn-tambah:hover {
    background: linear-gradient(135deg, var(--cta, #CA8A04), var(--primary, #DB2777));
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(219,39,119,0.4);
    color: #fff; text-decoration: none;
}
.pm-info-note {
    display: flex; align-items: flex-start; gap: 10px;
    background: #eff6ff; border: 1px solid #bfdbfe;
    border-radius: 10px; padding: 12px 16px;
    font-size: 13px; color: #1e40af;
    margin-bottom: 1.5rem;
}
</style>

<div class="pm-page">
    <div class="pm-topbar">
        <div>
            <h1 class="pm-title">Edit User</h1>
            <p class="pm-subtitle">Perbarui data pengguna: <strong>{{ $user->name }}</strong></p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>

    <div class="pm-info-note">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
             fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
             style="flex-shrink:0;margin-top:1px;">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        <span><strong>Catatan:</strong> Password tidak dapat diubah melalui halaman ini. User dapat mengubah password melalui halaman profil mereka.</span>
    </div>

    <div class="pm-form-card">
        <div class="pm-form-card-header">
            Data Pengguna
        </div>
        <div class="pm-form-body">
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap *</label>
                            <input type="text" name="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name', $user->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email', $user->email) }}" required>
                            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-4">
                            <label class="form-label">Nomor Telepon</label>
                            <input type="text" name="phone" class="form-control"
                                   value="{{ old('phone', $user->phone) }}"
                                   placeholder="Contoh: 08123456789">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-2" style="border-top: 1px solid var(--glass-border, #E5E7EB);">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn-tambah">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24"
                             fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/>
                            <polyline points="17 21 17 13 7 13 7 21"/>
                            <polyline points="7 3 7 8 15 8"/>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
