<x-guest-layout>
    <div class="mb-4">
        <h3 style="font-weight:700; color:#1a1a1a; margin-bottom:4px; font-size:1.25rem;">Buat Akun Baru</h3>
        <p style="color:#999; font-size:.85rem; margin:0;">Daftarkan dirimu untuk mulai berbelanja di ACIAA.</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="mb-3">
            <label for="name" style="display:block; margin-bottom:6px; font-weight:600; color:#555; font-size:.85rem;">Nama Lengkap</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   style="width:100%; border:1.5px solid #e8e0de; border-radius:10px; padding:11px 14px; font-size:.9rem; background:#fcfafa; transition: border-color .2s, box-shadow .2s;"
                   onfocus="this.style.borderColor='#d4a5a5'; this.style.boxShadow='0 0 0 3px rgba(212,165,165,0.15)'; this.style.background='#fff'"
                   onblur="this.style.borderColor='#e8e0de'; this.style.boxShadow='none'; this.style.background='#fcfafa'">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" style="display:block; margin-bottom:6px; font-weight:600; color:#555; font-size:.85rem;">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   style="width:100%; border:1.5px solid #e8e0de; border-radius:10px; padding:11px 14px; font-size:.9rem; background:#fcfafa; transition: border-color .2s, box-shadow .2s;"
                   onfocus="this.style.borderColor='#d4a5a5'; this.style.boxShadow='0 0 0 3px rgba(212,165,165,0.15)'; this.style.background='#fff'"
                   onblur="this.style.borderColor='#e8e0de'; this.style.boxShadow='none'; this.style.background='#fcfafa'">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" style="display:block; margin-bottom:6px; font-weight:600; color:#555; font-size:.85rem;">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   style="width:100%; border:1.5px solid #e8e0de; border-radius:10px; padding:11px 14px; font-size:.9rem; background:#fcfafa; transition: border-color .2s, box-shadow .2s;"
                   onfocus="this.style.borderColor='#d4a5a5'; this.style.boxShadow='0 0 0 3px rgba(212,165,165,0.15)'; this.style.background='#fff'"
                   onblur="this.style.borderColor='#e8e0de'; this.style.boxShadow='none'; this.style.background='#fcfafa'">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" style="display:block; margin-bottom:6px; font-weight:600; color:#555; font-size:.85rem;">Konfirmasi Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   style="width:100%; border:1.5px solid #e8e0de; border-radius:10px; padding:11px 14px; font-size:.9rem; background:#fcfafa; transition: border-color .2s, box-shadow .2s;"
                   onfocus="this.style.borderColor='#d4a5a5'; this.style.boxShadow='0 0 0 3px rgba(212,165,165,0.15)'; this.style.background='#fff'"
                   onblur="this.style.borderColor='#e8e0de'; this.style.boxShadow='none'; this.style.background='#fcfafa'">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit"
                style="width:100%; padding:12px; border:none; border-radius:10px; background: linear-gradient(135deg, #d4a5a5 0%, #b5838d 100%); color:#fff; font-weight:600; font-size:.9rem; cursor:pointer; transition: transform .15s, box-shadow .15s;"
                onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 20px rgba(181,131,141,0.3)'"
                onmouseout="this.style.transform='none'; this.style.boxShadow='none'">
            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
        </button>

        <div class="text-center mt-3">
            <span style="font-size:.84rem; color:#999;">Sudah punya akun?</span>
            <a href="{{ route('login') }}" style="font-size:.84rem; color:#b5838d; text-decoration:none; font-weight:600; margin-left:4px;">Masuk di sini</a>
        </div>
    </form>
</x-guest-layout>
