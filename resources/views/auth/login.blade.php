<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-4">
        <h3 style="font-weight:700; color:#1a1a1a; margin-bottom:4px; font-size:1.25rem;">Masuk ke Akun</h3>
        <p style="color:#999; font-size:.85rem; margin:0;">Silakan masukkan email dan password kamu.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" style="display:block; margin-bottom:6px; font-weight:600; color:#555; font-size:.85rem;">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   style="width:100%; border:1.5px solid #e8e0de; border-radius:10px; padding:11px 14px; font-size:.9rem; background:#fcfafa; transition: border-color .2s, box-shadow .2s;"
                   onfocus="this.style.borderColor='var(--color-primary)'; this.style.boxShadow='0 0 0 3px rgba(194,24,91,0.15)'; this.style.background='#fff'"
                   onblur="this.style.borderColor='#e8e0de'; this.style.boxShadow='none'; this.style.background='#fcfafa'">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" style="display:block; margin-bottom:6px; font-weight:600; color:#555; font-size:.85rem;">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   style="width:100%; border:1.5px solid #e8e0de; border-radius:10px; padding:11px 14px; font-size:.9rem; background:#fcfafa; transition: border-color .2s, box-shadow .2s;"
                   onfocus="this.style.borderColor='var(--color-primary)'; this.style.boxShadow='0 0 0 3px rgba(194,24,91,0.15)'; this.style.background='#fff'"
                   onblur="this.style.borderColor='#e8e0de'; this.style.boxShadow='none'; this.style.background='#fcfafa'">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <label for="remember_me" class="d-flex align-items-center" style="cursor:pointer;">
                <input id="remember_me" type="checkbox" name="remember"
                       style="accent-color:var(--color-primary-light); width:16px; height:16px; margin-right:8px; border-radius:4px;">
                <span style="font-size:.84rem; color:#666;">Ingat saya</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" style="font-size:.84rem; color:var(--color-primary-light); text-decoration:none;">
                    Lupa password?
                </a>
            @endif
        </div>

        <button type="submit"
                style="width:100%; padding:12px; border:none; border-radius:10px; background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%); color:#fff; font-weight:600; font-size:.9rem; cursor:pointer; transition: transform .15s, box-shadow .15s;"
                onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 20px rgba(233,30,140,0.3)'"
                onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
            <i class="fas fa-sign-in-alt me-2"></i>Masuk
        </button>

        <div class="text-center mt-3">
            <span style="font-size:.84rem; color:#999;">Belum punya akun?</span>
            <a href="{{ route('register') }}" style="font-size:.84rem; color:var(--color-primary-light); text-decoration:none; font-weight:600; margin-left:4px;">Daftar di sini</a>
        </div>
    </form>
</x-guest-layout>
