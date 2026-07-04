# Fix Template & Navbar — Task List

> **Tujuan**: Memperbaiki masalah struktural pada templating Blade, navbar, dan konsistensi background agar seluruh halaman frontend tampil konsisten dan profesional.

---

## Masalah yang Ditemukan

### 1. 🔴 Notification Dropdown Muncul di Luar Navbar
**File**: `resources/views/layouts/navigation.blade.php` (line 199-235)

**Penyebab**: Struktur HTML `.dropdown-panel.notification-panel` memiliki masalah nesting `<div>`. Pada line 199 panel dibuka, tapi line 200 memiliki `<span>` header langsung tanpa wrapper `<div>` pembungkus, dan line 202 ada `</div>` yang menutup terlalu dini — sehingga konten panel (notification list, "Lihat Semua Notifikasi") bocor keluar dari panel dropdown.

**Gejala**: Panel notifikasi "Lihat Semua Notifikasi" tampil di luar navbar (screenshot user).

### 2. 🔴 Background `#FDF2F8` (Soft Pink) Tidak Konsisten
**File**: `resources/views/layouts/app.blade.php` (line 46, 94, 99)

**Penyebab**: CSS variable `--color-bg` disetel ke `#FDF2F8` (soft pink), dan diterapkan ke `<body>` dan `<div class="min-h-screen">`. Halaman-halaman seperti **checkout**, **cart**, **transactions**, dll. tidak meng-override ini, sehingga backgroundnya tampak soft pink, bukan putih bersih seperti **home** (yang secara visual tertutupi oleh hero carousel full-width).

**Harapan user**: Background semua halaman harus putih (`#FFFFFF`), bukan `#FDF2F8`.

### 3. 🟡 Duplikasi Design System (`:root` CSS Variables)
**File**: 
- `resources/views/layouts/app.blade.php` — lines 33-90
- `resources/views/layouts/landing.blade.php` — lines 28-85
- `resources/views/layouts/guest.blade.php` — lines 23-31

**Penyebab**: Design system (CSS variables) didefinisikan inline di **tiga** layout files secara terpisah, menyebabkan:
- Inkonsistensi jika salah satu diubah tapi yang lain lupa
- Duplikasi kode yang tidak perlu
- `guest.blade.php` punya variable names berbeda (`--pink`, `--bg`) dari `app.blade.php` (`--color-primary`, `--color-bg`)

### 4. 🟡 Landing Page Punya Navbar Sendiri (Duplikasi)
**File**: `resources/views/layouts/landing.blade.php` (line 91+)

**Penyebab**: Landing page memiliki navbar custom `.landing-navbar` terpisah dari `navigation.blade.php`. Ini bukan error, tapi menyebabkan dua set navbar CSS/HTML yang perlu di-maintain.

### 5. 🟡 1493 Baris di `navigation.blade.php`
**File**: `resources/views/layouts/navigation.blade.php`

File ini terlalu besar — mengandung ~1000 baris CSS inline plus ~480 baris HTML/Alpine.js. Idealnya CSS dipindah ke file terpisah.

---

## Task & Tahapan

### PHASE A — Fix Critical: Notification Dropdown ⬜

> **Goal**: Memperbaiki struktur HTML notification dropdown agar tidak bocor keluar navbar.

#### A.1 Fix `navigation.blade.php` notification panel HTML
- [x] Periksa nesting `<div>` di notification panel (line 199-235)
- [x] Pastikan `.dropdown-panel.notification-panel` membungkus SEMUA konten:
  - Header (Notifikasi + Tandai semua dibaca)
  - Notification list
  - Footer (Lihat Semua Notifikasi)
- [x] Pastikan `</div>` penutup `.dropdown-panel` ada di posisi yang benar
- [x] Test: klik bell icon → dropdown muncul DI DALAM navbar, bukan di luar
- [x] Test: klik di luar dropdown → dropdown tertutup
- [x] Test: mobile view → notifikasi accessible via mobile menu

### PHASE B — Fix Critical: Background Consistency ⬜

> **Goal**: Semua halaman memiliki background putih (`#FFFFFF`), bukan soft pink (`#FDF2F8`).

#### B.1 Update `app.blade.php`
- [x] Ubah `--color-bg: #FDF2F8;` → `--color-bg: #FFFFFF;` (line 46)
- [x] Atau alternatif: ubah `body` background ke `#FFFFFF` langsung
- [x] Hapus duplikasi `style="background-color: var(--color-bg);"` di `<div class="min-h-screen">` (line 99) — cukup set di `body` saja

#### B.2 Update `landing.blade.php`
- [x] Ubah `--color-bg: #FDF2F8;` → `--color-bg: #FFFFFF;` (line 41)
- [x] Pastikan body background konsisten

#### B.3 Update `guest.blade.php`
- [x] Ubah `--bg:#FDF2F8;` → `--bg:#FFFFFF;` (line 28)
- [x] Atau gunakan variable name yang sama dengan `app.blade.php`

#### B.4 Verifikasi halaman-halaman
- [x] Home → background putih ✓
- [x] Products index → background putih ✓
- [x] Product detail → background putih ✓
- [x] Cart → background putih ✓
- [x] Checkout → background putih ✓
- [x] Transactions → background putih ✓
- [x] Profile → background putih ✓
- [x] Wishlist → background putih ✓
- [x] Auth pages (login/register) → background sesuai desain ✓

### PHASE C — Consolidate Design System ⬜

> **Goal**: Satu sumber kebenaran untuk CSS variables, tidak duplikasi di 3 layout files.

#### C.1 Buat partial `_design-system.blade.php`
- [x] Buat file `resources/views/partials/_design-system.blade.php`
- [x] Pindahkan semua `:root` CSS variables ke sini
- [x] Include dari `app.blade.php`, `landing.blade.php`, dan `guest.blade.php`

#### C.2 Update layout files
- [x] `app.blade.php`: ganti inline `:root` block → `@include('partials._design-system')`
- [x] `landing.blade.php`: ganti inline `:root` block → `@include('partials._design-system')`
- [x] `guest.blade.php`: ganti custom vars (`--pink`, `--bg`) → gunakan partial yang sama
- [x] Update referensi di `guest.blade.php` body styles dari `var(--bg)` → `var(--color-bg)`

#### C.3 Verifikasi
- [x] Semua halaman tetap berfungsi setelah konsolidasi
- [x] Tidak ada broken styles
- [x] Variable names konsisten di semua halaman

### PHASE D — Polish Navbar ⬜

> **Goal**: Navbar terlihat rapi, profesional, dan konsisten.

#### D.1 Pastikan z-index dan overflow benar
- [x] `.fashion-navbar` z-index `1000` — sudah benar
- [x] `.dropdown-panel` z-index `1000` → naikkan ke `1050` agar selalu di atas
- [x] `.notification-panel` pastikan `position: absolute; right: 0;` benar relatif terhadap parent `.user-dropdown`

#### D.2 Notification panel styling consistency
- [x] Header notification panel: tambah padding dan border-bottom yang jelas
- [x] Font styling konsisten dengan tema Montserrat
- [x] Hover effects pada notification items

#### D.3 Mobile responsiveness
- [x] Test navbar di 375px, 768px, 1024px
- [x] Pastikan hamburger menu smooth
- [x] Pastikan search bar mobile berfungsi

### PHASE E — Dynamic Templating Refactor (Blade Components & Assets) ⬜

> **Goal**: Merapikan arsitektur templating Blade agar benar-benar modular, DRY (Don't Repeat Yourself), dan mudah dikelola layaknya *dynamic web templating* yang baik.

#### E.1 Ekstraksi CSS Inline ke File Eksternal
- [x] Buat file `public/css/navbar.css` dan pindahkan ~1000 baris CSS dari `navigation.blade.php` ke dalamnya.
- [x] Buat file `public/css/landing.css` untuk menyimpan CSS spesifik halaman landing.
- [x] Include CSS tersebut menggunakan `<link rel="stylesheet">` di layout utama agar Blade files lebih bersih (fokus pada HTML).

#### E.2 Konsolidasi Navbar & Header
- [x] Ubah `landing.blade.php` agar menggunakan navbar global (`navigation.blade.php`) dengan *state* transparan, BUKAN menggunakan HTML navbar tersendiri yang di-*hardcode*.
- [x] Gunakan Blade components (`<x-navbar>`) atau `@include` secara konsisten untuk semua elemen berulang.

#### E.3 Refactor Base HTML
- [x] Buat satu *Master Base Layout* (misal `layouts.base`) yang berisi struktur dasar `<html>`, `<head>`, dan tag `<body>` beserta `<script>` global.
- [x] Ubah `app.blade.php`, `landing.blade.php`, dan `guest.blade.php` agar *extends* ke `layouts.base` sehingga tidak ada lagi duplikasi tag `<head>` dan import font/script di setiap layout.

---

## Urutan Pengerjaan

```
PHASE A (Fix Notification Dropdown) → PHASE B (Fix Background) → PHASE C (Consolidate Design System) → PHASE D (Polish Navbar) → PHASE E (Dynamic Templating Refactor)
```

## Catatan Penting

1. **JANGAN ubah logika PHP/Laravel/Alpine.js** — hanya perbaiki HTML structure dan CSS
2. **Test setelah setiap perubahan** — pastikan fungsi dropdown, search, cart badge tetap bekerja
3. **Commit per-phase** agar mudah di-revert jika bermasalah
