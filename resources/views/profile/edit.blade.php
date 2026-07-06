@extends('layouts.app')

@section('title', 'Profil Saya')

@push('styles')
<style>
    .profile-page {
        font-family: var(--font-body, 'Montserrat', sans-serif);
    }
    .profile-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        border: 1px solid rgba(0,0,0,0.04);
        overflow: hidden;
        margin-bottom: 1.25rem;
    }
    .profile-card-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .profile-card-header .header-icon {
        width: 38px;
        height: 38px;
        border-radius: 10px;
        background: linear-gradient(135deg, rgba(194,24,91,0.1), rgba(233,30,140,0.1));
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .profile-card-header .header-icon i {
        color: var(--color-primary);
        font-size: 1rem;
    }
    .profile-card-header h5 {
        margin: 0;
        font-weight: 700;
        font-size: 1rem;
        color: #1a1a1a;
    }
    .profile-card-header p {
        margin: 0;
        font-size: 0.8rem;
        color: #9ca3af;
    }
    .profile-card-body {
        padding: 1.5rem;
    }
    /* Override Breeze/Tailwind form styles to match our design system */
    .profile-card-body input[type="text"],
    .profile-card-body input[type="email"],
    .profile-card-body input[type="password"],
    .profile-card-body textarea {
        display: block;
        width: 100%;
        padding: 0.6rem 1rem;
        font-size: 0.9rem;
        border: 1.5px solid #D1D5DB;
        border-radius: 12px;
        background: #fff;
        color: #1a1a1a;
        transition: border-color 0.2s, box-shadow 0.2s;
        outline: none;
        font-family: var(--font-body, 'Montserrat', sans-serif);
    }
    .profile-card-body input:focus,
    .profile-card-body textarea:focus {
        border-color: var(--color-primary);
        box-shadow: 0 0 0 3px rgba(194,24,91,0.12);
    }
    .profile-card-body label {
        display: block;
        font-size: 0.85rem;
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.4rem;
    }
    .profile-card-body .form-group,
    .profile-card-body > div > div {
        margin-bottom: 1.25rem;
    }
    /* PrimaryButton override */
    .profile-card-body button[type="submit"],
    .profile-card-body .btn-primary-profile {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 0.65rem 1.75rem;
        background: linear-gradient(135deg, var(--color-primary), var(--color-primary-light));
        color: #fff;
        border: none;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.9rem;
        cursor: pointer;
        transition: all 0.2s;
        font-family: var(--font-body, 'Montserrat', sans-serif);
    }
    .profile-card-body button[type="submit"]:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(194,24,91,0.3);
    }
    /* Danger button */
    .profile-card-body button[type="submit"].danger-btn,
    .profile-card-body .btn-danger-profile {
        background: linear-gradient(135deg, #dc2626, #ef4444);
    }
    .profile-card-body button[type="submit"].danger-btn:hover {
        box-shadow: 0 6px 20px rgba(220,38,38,0.3);
    }
    /* Input error messages */
    .profile-card-body .text-red-600,
    .profile-card-body .error-msg {
        font-size: 0.78rem;
        color: #dc2626;
        margin-top: 4px;
    }
    /* Success message */
    .profile-card-body .success-msg,
    .profile-card-body p[x-show] {
        font-size: 0.82rem;
        color: #16a34a;
        margin-top: 8px;
    }
    /* Section divider dalam card */
    .profile-card-body hr {
        border: none;
        border-top: 1px solid #f3f4f6;
        margin: 1.25rem 0;
    }
</style>
@endpush

@section('content')
<div class="container my-4 profile-page" style="max-width: 900px;">
    <!-- Hero Banner -->
    <div class="mb-4 rounded-4 px-4 py-5" style="background: linear-gradient(135deg, #111111 0%, #1a1a1a 50%, #2a2a2a 100%); position: relative; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
        <div style="position: absolute; top: -50px; right: -50px; width: 250px; height: 250px; background: radial-gradient(circle, rgba(194,24,91,0.2) 0%, transparent 70%); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -30px; left: 10%; width: 150px; height: 150px; background: radial-gradient(circle, rgba(233,30,140,0.1) 0%, transparent 70%); border-radius: 50%;"></div>
        <h1 class="text-white mb-2 position-relative" style="font-family: var(--font-heading, 'Cormorant', serif); font-size: 2.2rem;"><i class="fas fa-user-circle me-3" style="color: var(--color-primary);"></i>Profil Saya</h1>
        <p class="text-white-50 mb-0 position-relative" style="font-size: 0.95rem;">Kelola informasi akun dan keamanan Anda</p>
    </div>

    <div class="profile-wrapper">
        @if (session('status') === 'profile-updated')
        <div class="d-flex align-items-center gap-2 mb-3 px-3 py-2 rounded-3" style="background:#f0fdf4;border:1px solid #bbf7d0;font-size:0.85rem;color:#166534;">
            <i class="fas fa-check-circle"></i> Profil berhasil diperbarui.
        </div>
        @endif

        <!-- Update Profile Card -->
        <div class="profile-card">
            <div class="profile-card-header">
                <div class="header-icon"><i class="fas fa-user"></i></div>
                <div>
                    <h5>Informasi Profil</h5>
                    <p>Perbarui nama dan alamat email akun Anda</p>
                </div>
            </div>
            <div class="profile-card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Update Password Card -->
        <div class="profile-card">
            <div class="profile-card-header">
                <div class="header-icon"><i class="fas fa-lock"></i></div>
                <div>
                    <h5>Ubah Password</h5>
                    <p>Pastikan akun Anda menggunakan password yang kuat</p>
                </div>
            </div>
            <div class="profile-card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete Account Card -->
        <div class="profile-card">
            <div class="profile-card-header">
                <div class="header-icon" style="background:rgba(220,38,38,0.1);">
                    <i class="fas fa-trash-alt" style="color:#dc2626;"></i>
                </div>
                <div>
                    <h5 style="color:#dc2626;">Hapus Akun</h5>
                    <p>Tindakan ini tidak dapat dibatalkan</p>
                </div>
            </div>
            <div class="profile-card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
