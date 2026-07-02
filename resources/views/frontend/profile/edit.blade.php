@extends('layouts.app')

@section('title', 'Profile')

@push('styles')
<style>
    :root{
        --pink: #d4a5a5;
        --pink-2:#b5838d;
        --soft:#fef6f5;
        --dark:#1a1a1a;
        --muted:#6b7280;
    }

    .profile-page{
        background: linear-gradient(135deg, #ffffff 0%, var(--soft) 55%, #ffffff 100%);
        padding: 40px 0 80px;
        min-height: calc(100vh - 64px);
        font-family: 'Poppins','Inter',system-ui,-apple-system,'Segoe UI',sans-serif;
    }

    .profile-hero{
        background: radial-gradient(1200px 300px at 20% 0%, rgba(212,165,165,0.28) 0%, rgba(212,165,165,0) 60%),
                    radial-gradient(900px 300px at 90% 10%, rgba(181,131,141,0.20) 0%, rgba(181,131,141,0) 55%),
                    #fff;
        border: 1px solid rgba(0,0,0,0.06);
        border-radius: 24px;
        box-shadow: 0 15px 40px rgba(0,0,0,0.06);
        overflow: hidden;
    }

    .profile-hero-inner{
        padding: 24px;
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .profile-avatar{
        width: 64px;
        height: 64px;
        border-radius: 18px;
        display:flex;
        align-items:center;
        justify-content:center;
        color: #fff;
        background: linear-gradient(135deg, var(--pink) 0%, var(--pink-2) 100%);
        font-weight: 700;
        letter-spacing: .5px;
        box-shadow: 0 10px 25px rgba(212,165,165,0.35);
        flex: 0 0 auto;
    }

    .profile-hero h1{
        font-size: 1.25rem;
        margin: 0;
        color: var(--dark);
        font-weight: 700;
    }
    .profile-hero p{
        margin: 2px 0 0;
        color: var(--muted);
        font-size: .9rem;
    }

    .stat-row{
        padding: 0 24px 18px;
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 12px;
    }

    .stat-card{
        background: rgba(255,255,255,0.9);
        border: 1px solid rgba(0,0,0,0.06);
        border-radius: 18px;
        padding: 14px 16px;
    }
    .stat-label{ color: var(--muted); font-size: .78rem; margin: 0; }
    .stat-value{ color: var(--dark); font-size: 1.1rem; font-weight: 700; margin: 2px 0 0; }

    .section-card{
        border: 0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 12px 30px rgba(0,0,0,0.06);
        background: #fff;
    }

    .section-head{
        padding: 16px 18px;
        background: linear-gradient(135deg, rgba(212,165,165,0.18), rgba(254,246,245,1));
        border-bottom: 1px solid rgba(0,0,0,0.06);
        display:flex;
        align-items:center;
        justify-content: space-between;
        gap: 10px;
    }

    .section-title{
        margin: 0;
        font-weight: 800;
        color: var(--dark);
        font-size: 1rem;
        display:flex;
        align-items:center;
        gap: 10px;
    }

    .badge-soft{
        background: rgba(212,165,165,0.18);
        color: var(--dark);
        border: 1px solid rgba(212,165,165,0.35);
        border-radius: 999px;
        padding: 6px 10px;
        font-size: .75rem;
        font-weight: 600;
    }

    .btn-pink{
        background: linear-gradient(135deg, var(--dark) 0%, #2d2d2d 100%);
        border: 0;
        color: #fff;
        border-radius: 999px;
        padding: 10px 16px;
        font-weight: 600;
        transition: transform .15s ease, box-shadow .15s ease, background .2s ease;
        box-shadow: 0 10px 20px rgba(0,0,0,0.12);
    }
    .btn-pink:hover{
        background: linear-gradient(135deg, var(--pink) 0%, var(--pink-2) 100%);
        transform: translateY(-1px);
        box-shadow: 0 14px 28px rgba(212,165,165,0.25);
        color: #fff;
    }

    .btn-outline-pink{
        border-radius: 999px;
        padding: 10px 16px;
        font-weight: 600;
        border: 1px solid rgba(212,165,165,0.65);
        background: #fff;
        color: var(--dark);
        transition: all .15s ease;
    }
    .btn-outline-pink:hover{
        background: var(--soft);
        border-color: var(--pink);
        color: var(--dark);
    }

    .form-control:focus, .form-select:focus{
        border-color: rgba(212,165,165,0.9);
        box-shadow: 0 0 0 .25rem rgba(212,165,165,0.25);
    }

    .address-card{
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: 18px;
        padding: 14px 16px;
        background: #fff;
        transition: transform .15s ease, box-shadow .15s ease, border-color .15s ease;
        position: relative;
    }
    .address-card:hover{
        transform: translateY(-2px);
        box-shadow: 0 16px 30px rgba(0,0,0,0.08);
        border-color: rgba(212,165,165,0.55);
    }
    .address-pill{
        display:inline-flex;
        align-items:center;
        gap: 8px;
        border-radius: 999px;
        padding: 5px 10px;
        font-size: .75rem;
        font-weight: 700;
        border: 1px solid rgba(0,0,0,0.08);
        background: #fff;
    }
    .address-pill.default{
        border-color: rgba(16,185,129,0.35);
        background: rgba(16,185,129,0.08);
    }
    .address-pill .dot{
        width: 8px; height: 8px; border-radius: 50%;
        background: var(--pink);
    }
    .address-pill.default .dot{ background: #10b981; }

    .muted{ color: var(--muted); }
    .small-2{ font-size: .85rem; }

    @media (max-width: 768px){
        .stat-row{ grid-template-columns: 1fr; }
        .profile-hero-inner{ padding: 18px; }
        .profile-avatar{ width: 56px; height: 56px; border-radius: 16px; }
    }
</style>
@endpush

@section('content')
<div class="profile-page">
    <div class="container">


        <div class="profile-hero mb-4">
            <div class="profile-hero-inner">
                <div class="profile-avatar">
                    {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                </div>
                <div class="flex-grow-1">
                    <h1>{{ $user->name }}</h1>
                    <p>{{ $user->email }} @if($user->phone)<span class="mx-2">•</span>{{ $user->phone }}@endif</p>
                </div>
                <span class="badge-soft d-none d-md-inline-flex">
                    <i class="fas fa-user me-2"></i> Konsumen
                </span>
            </div>
            <div class="stat-row">
                <div class="stat-card">
                    <p class="stat-label">Total Pesanan</p>
                    <p class="stat-value">{{ $stats['total_orders'] ?? 0 }}</p>
                </div>
                <div class="stat-card">
                    <p class="stat-label">Pesanan Selesai</p>
                    <p class="stat-value">{{ $stats['completed_orders'] ?? 0 }}</p>
                </div>
                <div class="stat-card">
                    <p class="stat-label">Total Belanja</p>
                    <p class="stat-value">Rp {{ number_format($stats['total_spent'] ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="section-card">
                    <div class="section-head">
                        <h3 class="section-title">
                            <i class="fas fa-id-card" style="color: var(--pink)"></i>
                            Informasi Akun
                        </h3>
                        <span class="badge-soft">Akun</span>
                    </div>
                    <div class="p-4">
                        <form method="POST" action="{{ route('profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nama</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                                       class="form-control rounded-4 @error('name') is-invalid @enderror" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                                       class="form-control rounded-4 @error('email') is-invalid @enderror" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">No. HP</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                                       placeholder="Contoh: 08xxxxxxxxxx"
                                       class="form-control rounded-4 @error('phone') is-invalid @enderror">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text muted">Nomor ini dipakai untuk pengiriman dan konfirmasi.</div>
                            </div>

                            <button type="submit" class="btn btn-pink w-100">
                                <i class="fas fa-save me-2"></i> Simpan Perubahan
                            </button>
                        </form>
                    </div>
                </div>

                <div class="section-card mt-4">
                    <div class="section-head">
                        <h3 class="section-title">
                            <i class="fas fa-key" style="color: var(--pink)"></i>
                            Ubah Password
                        </h3>
                        <span class="badge-soft">Keamanan</span>
                    </div>
                    <div class="p-4">
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password Saat Ini</label>
                                <input type="password" name="current_password"
                                       class="form-control rounded-4 @if($errors->updatePassword->has('current_password')) is-invalid @endif"
                                       autocomplete="current-password">
                                @if($errors->updatePassword->has('current_password'))
                                    <div class="invalid-feedback">{{ $errors->updatePassword->first('current_password') }}</div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Password Baru</label>
                                <input type="password" name="password"
                                       class="form-control rounded-4 @if($errors->updatePassword->has('password')) is-invalid @endif"
                                       autocomplete="new-password">
                                @if($errors->updatePassword->has('password'))
                                    <div class="invalid-feedback">{{ $errors->updatePassword->first('password') }}</div>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation"
                                       class="form-control rounded-4 @if($errors->updatePassword->has('password_confirmation')) is-invalid @endif"
                                       autocomplete="new-password">
                                @if($errors->updatePassword->has('password_confirmation'))
                                    <div class="invalid-feedback">{{ $errors->updatePassword->first('password_confirmation') }}</div>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-outline-pink w-100">
                                <i class="fas fa-shield-alt me-2"></i> Update Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="section-card">
                    <div class="section-head">
                        <h3 class="section-title">
                            <i class="fas fa-map-marker-alt" style="color: var(--pink)"></i>
                            Alamat Tersimpan
                        </h3>
                        <button type="button" class="btn btn-pink" data-bs-toggle="modal" data-bs-target="#addAddressModal">
                            <i class="fas fa-plus me-2"></i> Tambah
                        </button>
                    </div>
                    <div class="p-4">
                        <div id="addressList" class="vstack gap-3">
                            @forelse($addresses as $address)
                                <div class="address-card"
                                     data-address-id="{{ $address->id }}"
                                     data-label="{{ $address->label }}"
                                     data-recipient-name="{{ $address->recipient_name }}"
                                     data-phone="{{ $address->phone }}"
                                     data-address="{{ $address->address }}"
                                     data-province-id="{{ $address->province_id }}"
                                     data-city-id="{{ $address->city_id }}"
                                     data-subdistrict-id="{{ $address->subdistrict_id ?? '' }}"
                                     data-postal-code="{{ $address->postal_code ?? '' }}"
                                     data-is-default="{{ $address->is_default ? 1 : 0 }}">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="address-pill {{ $address->is_default ? 'default' : '' }}">
                                                <span class="dot"></span>
                                                {{ $address->label }}
                                                @if($address->is_default)
                                                    <span class="ms-1">• Utama</span>
                                                @endif
                                            </span>
                                        </div>
                                        <div class="d-flex align-items-center gap-3">
                                            <button type="button" class="btn btn-sm btn-link text-dark p-0"
                                                    onclick="openEditAddress(this)">
                                                <i class="fas fa-pen"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-link text-danger p-0"
                                                    onclick="deleteAddress({{ $address->id }})">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="fw-bold">{{ $address->recipient_name }}</div>
                                    <div class="muted small-2"><i class="fas fa-phone me-2"></i>{{ $address->phone }}</div>
                                    <div class="mt-2 small-2">
                                        {{ $address->address }},
                                        @if($address->district) Kec. {{ $address->district }}, @endif
                                        {{ $address->city }}, {{ $address->province }}
                                        @if($address->postal_code) - {{ $address->postal_code }} @endif
                                    </div>
                                </div>
                            @empty
                                <div class="text-center p-4 rounded-4" style="background: var(--soft); border: 1px dashed rgba(212,165,165,0.65);">
                                    <div class="mb-2" style="font-size: 2rem; color: var(--pink);">
                                        <i class="fas fa-map-marked-alt"></i>
                                    </div>
                                    <div class="fw-bold text-dark">Belum ada alamat</div>
                                    <div class="muted small-2">Tambah alamat supaya checkout lebih cepat.</div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <div class="section-card mt-4">
                    <div class="section-head">
                        <h3 class="section-title">
                            <i class="fas fa-exclamation-triangle" style="color: #ef4444"></i>
                            Hapus Akun
                        </h3>
                        <span class="badge-soft">Danger</span>
                    </div>
                    <div class="p-4">
                        <div class="muted small-2 mb-3">
                            Jika akun dihapus, semua data akan hilang permanen. Pastikan kamu sudah yakin.
                        </div>

                        <button type="button" class="btn btn-outline-danger w-100 rounded-pill py-2 fw-semibold"
                                data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                            <i class="fas fa-user-slash me-2"></i> Hapus Akun
                        </button>

                        @if($errors->userDeletion->isNotEmpty())
                            <div class="alert alert-danger rounded-4 border-0 shadow-sm mt-3 mb-0">
                                <i class="fas fa-times-circle me-2"></i> Password salah atau belum diisi.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Add Address -->
<div class="modal fade" id="addAddressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            <div class="modal-header" style="background: linear-gradient(135deg, rgba(212,165,165,0.18), rgba(254,246,245,1));">
                <h5 class="modal-title fw-bold"><i class="fas fa-plus me-2" style="color: var(--pink)"></i>Tambah Alamat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-danger d-none rounded-4" id="addressFormError"></div>

                <form id="addAddressForm">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Label</label>
                            <input type="text" name="label" class="form-control rounded-4" placeholder="Rumah/Kantor" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Nama Penerima</label>
                            <input type="text" name="recipient_name" class="form-control rounded-4" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">No. HP</label>
                            <input type="text" name="phone" class="form-control rounded-4" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Alamat Lengkap</label>
                            <textarea name="address" class="form-control rounded-4" rows="2" required></textarea>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Provinsi</label>
                            <select id="selectProvince" class="form-select rounded-4" required>
                                <option value="" selected disabled>Pilih Provinsi</option>
                                @foreach($provinces as $prov)
                                    <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kota/Kabupaten</label>
                            <select id="selectCity" class="form-select rounded-4" disabled required>
                                <option value="" selected disabled>Pilih Kota/Kabupaten</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kecamatan (opsional)</label>
                            <select id="selectSubdistrict" class="form-select rounded-4" disabled>
                                <option value="" selected disabled>Pilih Kecamatan</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kode Pos (opsional)</label>
                            <input type="text" name="postal_code" id="postalCode" class="form-control rounded-4" maxlength="10">
                        </div>
                        <div class="col-md-8 d-flex align-items-end">
                            <div class="form-check ms-md-2">
                                <input class="form-check-input" type="checkbox" id="isDefault" name="is_default" value="1">
                                <label class="form-check-label fw-semibold" for="isDefault">
                                    Jadikan alamat utama
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-pink rounded-pill px-4 flex-grow-1">
                            <i class="fas fa-save me-2"></i>Simpan Alamat
                        </button>
                    </div>
                </form>

                <div class="d-none mt-3 text-center" id="modalLoading">
                    <div class="spinner-border" role="status" style="color: var(--pink)">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Edit Address -->
<div class="modal fade" id="editAddressModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            <div class="modal-header" style="background: linear-gradient(135deg, rgba(212,165,165,0.18), rgba(254,246,245,1));">
                <h5 class="modal-title fw-bold"><i class="fas fa-pen me-2" style="color: var(--pink)"></i>Edit Alamat</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="alert alert-danger d-none rounded-4" id="editAddressFormError"></div>

                <form id="editAddressForm">
                    <input type="hidden" id="editAddressId">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Label</label>
                            <input type="text" name="label" id="editLabel" class="form-control rounded-4" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Nama Penerima</label>
                            <input type="text" name="recipient_name" id="editRecipientName" class="form-control rounded-4" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">No. HP</label>
                            <input type="text" name="phone" id="editPhone" class="form-control rounded-4" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Alamat Lengkap</label>
                            <textarea name="address" id="editAddressText" class="form-control rounded-4" rows="2" required></textarea>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Provinsi</label>
                            <select id="editProvince" class="form-select rounded-4" required>
                                <option value="" selected disabled>Pilih Provinsi</option>
                                @foreach($provinces as $prov)
                                    <option value="{{ $prov->id }}">{{ $prov->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kota/Kabupaten</label>
                            <select id="editCity" class="form-select rounded-4" disabled required>
                                <option value="" selected disabled>Pilih Kota/Kabupaten</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kecamatan (opsional)</label>
                            <select id="editSubdistrict" class="form-select rounded-4" disabled>
                                <option value="" selected disabled>Pilih Kecamatan</option>
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Kode Pos (opsional)</label>
                            <input type="text" name="postal_code" id="editPostalCode" class="form-control rounded-4" maxlength="10">
                        </div>
                        <div class="col-md-8 d-flex align-items-end">
                            <div class="form-check ms-md-2">
                                <input class="form-check-input" type="checkbox" id="editIsDefault" name="is_default" value="1">
                                <label class="form-check-label fw-semibold" for="editIsDefault">
                                    Jadikan alamat utama
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-pink rounded-pill px-4 flex-grow-1">
                            <i class="fas fa-save me-2"></i>Simpan Perubahan
                        </button>
                    </div>
                </form>

                <div class="d-none mt-3 text-center" id="editModalLoading">
                    <div class="spinner-border" role="status" style="color: var(--pink)">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Delete Account -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 rounded-4 overflow-hidden">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title fw-bold"><i class="fas fa-user-slash me-2"></i>Konfirmasi Hapus Akun</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('profile.destroy') }}">
                @csrf
                @method('DELETE')
                <div class="modal-body p-4">
                    <div class="mb-3 muted">
                        Masukkan password untuk menghapus akun secara permanen.
                    </div>
                    <input type="password" name="password"
                           class="form-control rounded-4 @if($errors->userDeletion->has('password')) is-invalid @endif"
                           placeholder="Password">
                    @if($errors->userDeletion->has('password'))
                        <div class="invalid-feedback">{{ $errors->userDeletion->first('password') }}</div>
                    @endif
                </div>
                <div class="modal-footer p-3">
                    <button type="button" class="btn btn-outline-secondary rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-semibold">
                        Hapus Permanen
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let citiesFetchController = null;
    let citiesFetchToken = 0;
    let subdistrictsFetchController = null;
    let subdistrictsFetchToken = 0;

    document.addEventListener('DOMContentLoaded', function () {
        const provinceEl = document.getElementById('selectProvince');
        const cityEl = document.getElementById('selectCity');
        const subdistrictEl = document.getElementById('selectSubdistrict');
        const postalCodeInput = document.getElementById('postalCode');

        provinceEl?.addEventListener('change', function() {
            const provinceId = this.value;
            cityEl.innerHTML = '<option value="" disabled selected>Pilih Kota/Kabupaten</option>';
            cityEl.disabled = true;
            subdistrictEl.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';
            subdistrictEl.disabled = true;

            if (!provinceId) return;

            if (citiesFetchController) citiesFetchController.abort();
            citiesFetchController = new AbortController();
            const fetchToken = ++citiesFetchToken;

            document.getElementById('modalLoading')?.classList.remove('d-none');

            fetch(`/api/cities/${provinceId}`, { signal: citiesFetchController.signal })
                .then(res => res.json())
                .then(cities => {
                    if (fetchToken !== citiesFetchToken) return;
                    cities.forEach(city => {
                        const opt = document.createElement('option');
                        opt.value = city.id;
                        opt.textContent = `${city.type} ${city.name}`;
                        opt.setAttribute('data-postal-code', city.postal_code || '');
                        cityEl.appendChild(opt);
                    });
                    cityEl.disabled = false;
                })
                .catch(err => {
                    if (err.name === 'AbortError') return;
                    console.error(err);
                    showAddressError('Gagal mengambil data kota/kabupaten.');
                })
                .finally(() => {
                    if (fetchToken === citiesFetchToken) {
                        document.getElementById('modalLoading')?.classList.add('d-none');
                    }
                });
        });

        cityEl?.addEventListener('change', function() {
            const cityId = this.value;
            const selectedOpt = this.options[this.selectedIndex];
            const pCode = selectedOpt?.getAttribute('data-postal-code');
            if (pCode) postalCodeInput.value = pCode;

            subdistrictEl.innerHTML = '<option value="" disabled selected>Memuat kecamatan...</option>';
            subdistrictEl.disabled = true;

            if (!cityId) return;

            if (subdistrictsFetchController) subdistrictsFetchController.abort();
            subdistrictsFetchController = new AbortController();
            const fetchToken = ++subdistrictsFetchToken;

            document.getElementById('modalLoading')?.classList.remove('d-none');

            fetch(`/api/subdistricts/${cityId}`, { signal: subdistrictsFetchController.signal })
                .then(res => res.json())
                .then(subdistricts => {
                    if (fetchToken !== subdistrictsFetchToken) return;
                    subdistrictEl.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';
                    if (subdistricts.length > 0) {
                        subdistricts.forEach(sub => {
                            const opt = document.createElement('option');
                            opt.value = sub.id;
                            opt.textContent = sub.name;
                            subdistrictEl.appendChild(opt);
                        });
                        subdistrictEl.disabled = false;
                    } else {
                        const opt = document.createElement('option');
                        opt.value = '';
                        opt.textContent = 'Tidak ada kecamatan terdaftar';
                        subdistrictEl.appendChild(opt);
                    }
                })
                .catch(err => {
                    if (err.name === 'AbortError') return;
                    console.error(err);
                    showAddressError('Gagal mengambil data kecamatan.');
                })
                .finally(() => {
                    if (fetchToken === subdistrictsFetchToken) {
                        document.getElementById('modalLoading')?.classList.add('d-none');
                    }
                });
        });

        document.getElementById('addAddressForm')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const provinceId = provinceEl.value;
            const cityId = cityEl.value;
            const subdistrictId = subdistrictEl.value;

            if (!provinceId || !cityId) {
                showAddressError('Provinsi dan kota/kabupaten wajib dipilih.');
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
            if (subdistrictId) data.subdistrict_id = subdistrictId;

            clearAddressError();
            document.getElementById('modalLoading')?.classList.remove('d-none');

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
                if (!res.ok) throw body;
                return body;
            })
            .then(res => {
                if (!res.success) {
                    showAddressError(res.message || 'Gagal menyimpan alamat.');
                    return;
                }

                const modalEl = document.getElementById('addAddressModal');
                bootstrap.Modal.getInstance(modalEl)?.hide();

                this.reset();
                cityEl.disabled = true;
                subdistrictEl.disabled = true;

                appendAddressCard(res.address);
            })
            .catch(err => {
                console.error(err);
                showAddressError(err.message || 'Terjadi kesalahan sistem, silakan coba lagi.');
            })
            .finally(() => {
                document.getElementById('modalLoading')?.classList.add('d-none');
            });
        });

        // ===== Edit Address: Province → City cascade
        const editProvinceEl = document.getElementById('editProvince');
        const editCityEl = document.getElementById('editCity');
        const editSubdistrictEl = document.getElementById('editSubdistrict');
        const editPostalEl = document.getElementById('editPostalCode');

        editProvinceEl?.addEventListener('change', function () {
            const provinceId = this.value;
            editCityEl.innerHTML = '<option value="" disabled selected>Pilih Kota/Kabupaten</option>';
            editCityEl.disabled = true;
            editSubdistrictEl.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';
            editSubdistrictEl.disabled = true;
            if (!provinceId) return;

            document.getElementById('editModalLoading')?.classList.remove('d-none');
            fetch(`/api/cities/${provinceId}`)
                .then(res => res.json())
                .then(cities => {
                    cities.forEach(city => {
                        const opt = document.createElement('option');
                        opt.value = city.id;
                        opt.textContent = `${city.type} ${city.name}`;
                        opt.setAttribute('data-postal-code', city.postal_code || '');
                        editCityEl.appendChild(opt);
                    });
                    editCityEl.disabled = false;
                })
                .catch(err => {
                    console.error(err);
                    showEditAddressError('Gagal mengambil data kota/kabupaten.');
                })
                .finally(() => document.getElementById('editModalLoading')?.classList.add('d-none'));
        });

        editCityEl?.addEventListener('change', function () {
            const cityId = this.value;
            const selectedOpt = this.options[this.selectedIndex];
            const pCode = selectedOpt?.getAttribute('data-postal-code');
            if (pCode) editPostalEl.value = pCode;

            editSubdistrictEl.innerHTML = '<option value="" disabled selected>Memuat kecamatan...</option>';
            editSubdistrictEl.disabled = true;
            if (!cityId) return;

            document.getElementById('editModalLoading')?.classList.remove('d-none');
            fetch(`/api/subdistricts/${cityId}`)
                .then(res => res.json())
                .then(subdistricts => {
                    editSubdistrictEl.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';
                    if (subdistricts.length > 0) {
                        subdistricts.forEach(sub => {
                            const opt = document.createElement('option');
                            opt.value = sub.id;
                            opt.textContent = sub.name;
                            editSubdistrictEl.appendChild(opt);
                        });
                        editSubdistrictEl.disabled = false;
                    } else {
                        const opt = document.createElement('option');
                        opt.value = '';
                        opt.textContent = 'Tidak ada kecamatan terdaftar';
                        editSubdistrictEl.appendChild(opt);
                    }
                })
                .catch(err => {
                    console.error(err);
                    showEditAddressError('Gagal mengambil data kecamatan.');
                })
                .finally(() => document.getElementById('editModalLoading')?.classList.add('d-none'));
        });

        document.getElementById('editAddressForm')?.addEventListener('submit', function (e) {
            e.preventDefault();

            const id = document.getElementById('editAddressId').value;
            const provinceId = editProvinceEl.value;
            const cityId = editCityEl.value;
            const subdistrictId = editSubdistrictEl.value;

            if (!id || !provinceId || !cityId) {
                showEditAddressError('Provinsi dan kota/kabupaten wajib dipilih.');
                return;
            }

            const data = {
                label: document.getElementById('editLabel').value,
                recipient_name: document.getElementById('editRecipientName').value,
                phone: document.getElementById('editPhone').value,
                address: document.getElementById('editAddressText').value,
                province_id: provinceId,
                city_id: cityId,
                postal_code: document.getElementById('editPostalCode').value,
                is_default: document.getElementById('editIsDefault').checked ? 1 : 0,
            };
            if (subdistrictId) data.subdistrict_id = subdistrictId;

            clearEditAddressError();
            document.getElementById('editModalLoading')?.classList.remove('d-none');

            fetch(`/api/addresses/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(async res => {
                const body = await res.json();
                if (!res.ok) throw body;
                return body;
            })
            .then(res => {
                if (!res.success) {
                    showEditAddressError(res.message || 'Gagal memperbarui alamat.');
                    return;
                }

                bootstrap.Modal.getInstance(document.getElementById('editAddressModal'))?.hide();
                updateAddressCard(res.address);
            })
            .catch(err => {
                console.error(err);
                showEditAddressError(err.message || 'Terjadi kesalahan sistem, silakan coba lagi.');
            })
            .finally(() => document.getElementById('editModalLoading')?.classList.add('d-none'));
        });

        @if($errors->userDeletion->isNotEmpty())
            const delModal = document.getElementById('deleteAccountModal');
            if (delModal) new bootstrap.Modal(delModal).show();
        @endif
    });

    function clearAddressError() {
        const el = document.getElementById('addressFormError');
        if (!el) return;
        el.classList.add('d-none');
        el.textContent = '';
    }

    function showAddressError(message) {
        const el = document.getElementById('addressFormError');
        if (!el) return;
        el.textContent = message;
        el.classList.remove('d-none');
    }

    function appendAddressCard(address) {
        const list = document.getElementById('addressList');
        if (!list) return;

        const wrapper = document.createElement('div');
        wrapper.className = 'address-card';
        wrapper.setAttribute('data-address-id', address.id);
        wrapper.setAttribute('data-label', address.label || '');
        wrapper.setAttribute('data-recipient-name', address.recipient_name || '');
        wrapper.setAttribute('data-phone', address.phone || '');
        wrapper.setAttribute('data-address', address.address || '');
        wrapper.setAttribute('data-province-id', address.province_id || '');
        wrapper.setAttribute('data-city-id', address.city_id || '');
        wrapper.setAttribute('data-subdistrict-id', address.subdistrict_id || '');
        wrapper.setAttribute('data-postal-code', address.postal_code || '');
        wrapper.setAttribute('data-is-default', address.is_default ? 1 : 0);

        const isDefault = !!address.is_default;
        wrapper.innerHTML = `
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="address-pill ${isDefault ? 'default' : ''}">
                        <span class="dot"></span>
                        ${escapeHtml(address.label || 'Alamat')}
                        ${isDefault ? '<span class="ms-1">• Utama</span>' : ''}
                    </span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button type="button" class="btn btn-sm btn-link text-dark p-0" onclick="openEditAddress(this)">
                        <i class="fas fa-pen"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="deleteAddress(${address.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="fw-bold">${escapeHtml(address.recipient_name || '')}</div>
            <div class="muted small-2"><i class="fas fa-phone me-2"></i>${escapeHtml(address.phone || '')}</div>
            <div class="mt-2 small-2">
                ${escapeHtml(address.address || '')},
                ${address.district ? `Kec. ${escapeHtml(address.district)}, ` : ''}
                ${escapeHtml(address.city || '')}, ${escapeHtml(address.province || '')}
                ${address.postal_code ? ` - ${escapeHtml(address.postal_code)}` : ''}
            </div>
        `;

        if (isDefault) {
            list.prepend(wrapper);
        } else {
            list.appendChild(wrapper);
        }
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
            card?.remove();
        })
        .catch(err => {
            console.error(err);
            alert(err.message || 'Gagal menghapus alamat.');
        });
    }

    function clearEditAddressError() {
        const el = document.getElementById('editAddressFormError');
        if (!el) return;
        el.classList.add('d-none');
        el.textContent = '';
    }

    function showEditAddressError(message) {
        const el = document.getElementById('editAddressFormError');
        if (!el) return;
        el.textContent = message;
        el.classList.remove('d-none');
    }

    function openEditAddress(buttonEl) {
        const card = buttonEl?.closest('.address-card');
        if (!card) return;

        clearEditAddressError();

        const id = card.getAttribute('data-address-id');
        document.getElementById('editAddressId').value = id;
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

        const modal = new bootstrap.Modal(document.getElementById('editAddressModal'));
        modal.show();

        if (!provinceId) return;

        document.getElementById('editModalLoading')?.classList.remove('d-none');
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
                } else {
                    const opt = document.createElement('option');
                    opt.value = '';
                    opt.textContent = 'Tidak ada kecamatan terdaftar';
                    subEl.appendChild(opt);
                }
            })
            .catch(err => {
                console.error(err);
                showEditAddressError('Gagal memuat data alamat untuk diedit.');
            })
            .finally(() => document.getElementById('editModalLoading')?.classList.add('d-none'));
    }

    function updateAddressCard(address) {
        const card = document.querySelector(`.address-card[data-address-id="${address.id}"]`);
        if (!card) return;

        // jika ada perubahan default: bersihkan semua card
        if (address.is_default) {
            document.querySelectorAll('.address-card').forEach(c => {
                c.setAttribute('data-is-default', '0');
                const pill = c.querySelector('.address-pill');
                const dot = pill?.querySelector('.dot');
                if (pill) pill.classList.remove('default');
                if (dot) dot.style.background = 'var(--pink)';
                const txt = pill?.innerText || '';
                if (pill && txt.includes('• Utama')) {
                    pill.innerHTML = pill.innerHTML.replace('<span class="ms-1">• Utama</span>', '');
                }
            });
        }

        card.setAttribute('data-label', address.label || '');
        card.setAttribute('data-recipient-name', address.recipient_name || '');
        card.setAttribute('data-phone', address.phone || '');
        card.setAttribute('data-address', address.address || '');
        card.setAttribute('data-province-id', address.province_id || '');
        card.setAttribute('data-city-id', address.city_id || '');
        card.setAttribute('data-subdistrict-id', address.subdistrict_id || '');
        card.setAttribute('data-postal-code', address.postal_code || '');
        card.setAttribute('data-is-default', address.is_default ? 1 : 0);

        const isDefault = !!address.is_default;
        card.innerHTML = `
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="address-pill ${isDefault ? 'default' : ''}">
                        <span class="dot"></span>
                        ${escapeHtml(address.label || 'Alamat')}
                        ${isDefault ? '<span class="ms-1">• Utama</span>' : ''}
                    </span>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <button type="button" class="btn btn-sm btn-link text-dark p-0" onclick="openEditAddress(this)">
                        <i class="fas fa-pen"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-link text-danger p-0" onclick="deleteAddress(${address.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="fw-bold">${escapeHtml(address.recipient_name || '')}</div>
            <div class="muted small-2"><i class="fas fa-phone me-2"></i>${escapeHtml(address.phone || '')}</div>
            <div class="mt-2 small-2">
                ${escapeHtml(address.address || '')},
                ${address.district ? `Kec. ${escapeHtml(address.district)}, ` : ''}
                ${escapeHtml(address.city || '')}, ${escapeHtml(address.province || '')}
                ${address.postal_code ? ` - ${escapeHtml(address.postal_code)}` : ''}
            </div>
        `;

        if (isDefault) {
            const list = document.getElementById('addressList');
            list?.prepend(card);
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
</script>
@endpush

