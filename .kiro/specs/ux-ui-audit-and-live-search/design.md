# Design: UX/UI Audit & Live Search

## Arsitektur Solusi

### Stack yang Digunakan

| Layer | Teknologi |
|---|---|
| Template | Laravel Blade |
| CSS | Bootstrap 5 (utama) + Tailwind CSS utility |
| Interaktivitas | Alpine.js (reactive) + Axios (AJAX) |
| Ikon | Lucide Icons + Font Awesome 6 |
| Build | Vite |

### Pola Desain

**AJAX via Axios** — semua request live search dan update keranjang menggunakan `axios` yang sudah tersedia di `package.json`. Response format: JSON.

**Alpine.js Reactive** — komponen yang butuh state lokal (dropdown search, toggle filter, quantity stepper) menggunakan `x-data` Alpine.js.

**Blade Components** — komponen reusable seperti toast, skeleton loader, dan product card dibuat sebagai Blade component di `resources/views/components/`.

---

## Komponen Baru yang Perlu Dibuat

### 1. `components/toast.blade.php`
Komponen toast global yang di-include di `layouts/app.blade.php`. Menampilkan pesan dari session (`session('success')`, `session('error')`) dan dapat dipanggil secara programmatik via JavaScript event.

```html
<!-- Trigger via JS: window.dispatchEvent(new CustomEvent('toast', {detail: {message: '...', type: 'success'}})) -->
<div x-data="toastManager()" @toast.window="show($event.detail)" ...>
```

### 2. `components/product-card.blade.php`
Kartu produk terpadu yang dipakai di semua grid (home, daftar produk, live search). Mengurangi duplikasi kode yang saat ini tersebar di `home.blade.php`, `products/index.blade.php`, dll.

### 3. `components/skeleton-loader.blade.php`
Skeleton placeholder untuk grid produk saat AJAX loading. Menggunakan CSS animation `@keyframes shimmer`.

### 4. `components/live-search-dropdown.blade.php`
Dropdown hasil pencarian real-time untuk navbar. Di-render via Blade tapi populasi data via AJAX.

---

## Rute AJAX Baru (Backend Minimal)

Hanya route yang diperlukan untuk mendukung UI—tidak mengubah logika bisnis yang ada.

| Method | Route | Controller | Response |
|---|---|---|---|
| `GET` | `/api/search/live` | `ProductController@liveSearch` | JSON: `{products: [{id, name, slug, price, discount_price, image, category}]}` |
| `GET` | `/products/ajax` | `ProductController@ajaxIndex` | JSON: `{html: '...rendered product cards...', total: N}` |
| `PUT` | `/cart/{id}/ajax` | `CartController@ajaxUpdate` | JSON: `{success: bool, subtotal: N, total: N}` |
| `DELETE` | `/cart/{id}/ajax` | `CartController@ajaxRemove` | JSON: `{success: bool, total: N, count: N}` |
| `POST` | `/wishlist/ajax` | `WishlistController@ajaxToggle` | JSON: `{success: bool, inWishlist: bool}` |

> **Catatan:** Route ini dibuat minimal—`ProductController@liveSearch` hanya memanggil query yang sudah ada di `ProductController@index` dengan scope terbatas (8 item, select kolom tertentu).

---

## Desain Live Search Navbar

### Flow

```
User types → (debounce 300ms) → Axios GET /api/search/live?q=... → JSON response
→ Alpine.js update `results` array → Dropdown tampil
```

### Markup Pattern (Alpine.js)

```html
<div x-data="liveSearch()" @click.outside="close()" class="search-container">
    <input type="text" 
           x-model.debounce.300ms="query"
           @input="search()"
           @keydown.enter.prevent="goToFullSearch()"
           @keydown.escape="close()"
           placeholder="Cari produk...">
    
    <div x-show="open && results.length > 0" class="search-dropdown">
        <template x-for="product in results">
            <a :href="product.url" class="search-result-item">
                <img :src="product.image" :alt="product.name">
                <div>
                    <p x-text="product.name"></p>
                    <span x-text="product.price"></span>
                </div>
            </a>
        </template>
    </div>

    <div x-show="open && query.length >= 2 && results.length === 0" class="search-empty">
        Produk tidak ditemukan
    </div>
</div>
```

### Posisi di Layout

Live search diintegrasikan ke `layouts/navigation.blade.php`. Di mobile, trigger berupa ikon search yang membuka search bar full-width di bawah navbar.

---

## Desain Live Search di Halaman Produk

### Flow

```
User types / filter berubah → (debounce 400ms) → Axios GET /products/ajax?search=...&category=...&sort=...
→ JSON {html, total} → Inject HTML ke #productGrid → Update counter
```

### State Management

Semua state filter (search query, kategori aktif, harga min/max, sort) disimpan di Alpine.js component `x-data="productFilter()"`. Ketika salah satu berubah, AJAX dipanggil otomatis via `$watch`.

### Skeleton Loader

Saat request sedang berlangsung, `#productGrid` diisi dengan 6–9 skeleton card:

```css
@keyframes shimmer {
    0% { background-position: -400px 0; }
    100% { background-position: 400px 0; }
}
.skeleton { background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%); ... }
```

---

## Desain Pembaruan Keranjang via AJAX

### Quantity Update

Saat user klik `+`/`-` atau ubah input:
1. `changeQty()` function dipanggil
2. Axios PUT `/cart/{id}/ajax` dengan `{quantity: N}`
3. Response `{subtotal, total}` → Update DOM langsung
4. Dispatch event `toast` → Toast muncul "Keranjang diperbarui"

### Remove Item

1. User klik ikon trash → Muncul Alpine.js inline confirm (bukan `window.confirm`)
2. Jika konfirmasi → Axios DELETE `/cart/{id}/ajax`
3. Animasi slide-up pada cart card → Remove dari DOM
4. Update total & counter

---

## Desain Toast System

Toast global di-mount di `layouts/app.blade.php`:

```html
<div x-data="{ toasts: [] }" 
     @toast.window="toasts.push($event.detail); setTimeout(() => toasts.shift(), 3500)"
     class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1090">
    <template x-for="(t, i) in toasts" :key="i">
        <div class="toast show" :class="t.type === 'error' ? 'border-danger' : 'border-success'">
            <div class="toast-body d-flex align-items-center gap-2">
                <i :class="t.type === 'error' ? 'fas fa-times-circle text-danger' : 'fas fa-check-circle text-success'"></i>
                <span x-text="t.message"></span>
            </div>
        </div>
    </template>
</div>
```

Session flash juga dikonversi ke toast via inline script di layout:

```js
@if(session('success'))
window.dispatchEvent(new CustomEvent('toast', {detail: {message: "{{ session('success') }}", type: 'success'}}));
@endif
```

---

## Perbaikan UI Spesifik per Halaman

### Landing Page (`/`)
- Ganti gambar Unsplash di Brand Manifesto dengan `asset('images/...')` dengan fallback `onerror`
- Testimonial: tambah carousel/slider sederhana dengan autoplay
- Mobile CTA: pastikan `min-height: 44px; min-width: 44px` pada semua button

### Home Page (`/home`)
- Pindah flash session ke toast system global
- Flash sale timer: tambah guard `@if($flashSaleEnd)` — jika null/expired, sembunyikan section countdown
- Promo slider "Beli Sekarang": arahkan ke `route('products.show', $product->slug)`

### Halaman Produk (`/products`)
- Mobile filter: tambah tombol "Filter" di mobile → sidebar filter menjadi offcanvas Bootstrap 5
- Product card: tambah rata-rata rating (`$product->ratings_avg_rating`) sebagai bintang kecil di bawah harga
- Loading state: overlay spinner di atas grid produk selama AJAX

### Halaman Detail Produk (`/products/{slug}`)
- Gallery thumbnails: Alpine.js `x-on:click` untuk swap gambar utama (sudah ada struktur, perlu JS)
- Add to cart button: `x-bind:disabled="loading"` + spinner saat proses
- Reviews: tambah "Load More" button yang fetch ulasan berikutnya via AJAX

### Halaman Cart (`/cart`)
- Qty stepper: Axios-based update, bukan form submit
- Remove: Alpine.js inline confirm dialog
- Total otomatis update di DOM

### Wishlist di Semua Halaman
- Tombol wishlist toggle: Axios POST `/wishlist/ajax` → update ikon `fas fa-heart` / `far fa-heart` tanpa reload

### Halaman Notifikasi
- Badge notifikasi di navbar: counter dari `$unreadNotifications` yang di-pass via View Composer atau include partial

---

## Konsistensi & Aksesibilitas

### Atribut `alt` pada Gambar
Semua `<img>` produk menggunakan: `alt="{{ $product->name }}"` bukan string kosong atau "default.jpg".

### ARIA Labels
Semua tombol ikon:
```html
<button aria-label="Tambah ke wishlist">
<button aria-label="Hapus dari keranjang">
<button aria-label="Cari produk">
```

### Responsive Breakpoints

| Breakpoint | Layout Produk Grid | Sidebar |
|---|---|---|
| Mobile < 768px | 1–2 kolom | Offcanvas (hidden default) |
| Tablet 768–1023px | 2–3 kolom | Collapsible |
| Desktop ≥ 1024px | 3–4 kolom | Sticky sidebar |

---

## File yang Dimodifikasi / Dibuat

### File Baru
- `resources/views/components/toast.blade.php`
- `resources/views/components/product-card.blade.php`
- `resources/views/components/skeleton-loader.blade.php`
- `resources/js/live-search.js` (Alpine.js component functions)

### File Dimodifikasi
- `resources/views/layouts/navigation.blade.php` — tambah live search
- `resources/views/layouts/app.blade.php` — tambah toast container
- `resources/views/frontend/home.blade.php` — perbaikan UI
- `resources/views/frontend/landing.blade.php` — perbaikan UI
- `resources/views/frontend/products/index.blade.php` — live search + filter AJAX
- `resources/views/frontend/products/show.blade.php` — gallery JS + cart AJAX
- `resources/views/frontend/cart/index.blade.php` — AJAX update/remove
- `resources/views/frontend/wishlist/index.blade.php` — UI audit
- `resources/views/frontend/transactions/index.blade.php` — filter/search
- `resources/views/frontend/notifications/index.blade.php` — badge & UI
- `app/Http/Controllers/ProductController.php` — tambah method `liveSearch()`, `ajaxIndex()`
- `app/Http/Controllers/CartController.php` — tambah method `ajaxUpdate()`, `ajaxRemove()`
- `app/Http/Controllers/WishlistController.php` — tambah method `ajaxToggle()`
- `routes/web.php` — tambah route AJAX
