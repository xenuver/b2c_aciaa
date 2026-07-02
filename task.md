# Implementation Plan: UX/UI Audit & Live Search

## Overview

Rencana implementasi audit UX/UI menyeluruh untuk halaman frontend (customer) aplikasi e-commerce Aciaa Store, beserta implementasi live search tanpa reload halaman. Pekerjaan dibagi dalam 11 fase yang dapat dikerjakan secara berurutan, dimulai dari fondasi komponen bersama hingga perbaikan per halaman.

**Stack:** Laravel Blade + Bootstrap 5 + Alpine.js + Axios + Lucide Icons

## Tasks

### Fase 1: Fondasi & Infrastruktur

- [x] 1.1 Buat komponen toast global (`resources/views/components/toast.blade.php`) dengan dukungan tipe `success` dan `error`, menggunakan Alpine.js untuk state dan auto-dismiss setelah 3.5 detik
- [x] 1.2 Integrasikan toast container ke `resources/views/layouts/app.blade.php` dan konversi semua session flash (`session('success')`, `session('error')`) menjadi toast event via inline script
- [x] 1.3 Buat komponen skeleton loader (`resources/views/components/skeleton-loader.blade.php`) untuk grid produk dengan CSS shimmer animation yang sesuai dengan warna tema (pink/rose)
- [x] 1.4 Buat komponen product card terpadu (`resources/views/components/product-card.blade.php`) yang menampilkan: gambar, nama, kategori, rating bintang, harga (dengan diskon), dan tombol wishlist — siap digunakan di semua halaman grid

### Fase 2: Live Search Navbar (Global)

- [x] 2.1 Tambahkan method `liveSearch(Request $request)` di `app/Http/Controllers/ProductController.php` yang menerima query string `q`, mencari produk (nama/kategori), dan mengembalikan JSON maksimal 8 hasil dengan field: `id`, `name`, `slug`, `price`, `discount_price`, `image`, `category_name`
- [x] 2.2 Tambahkan route `GET /api/search/live` di `routes/web.php` yang mengarah ke `ProductController@liveSearch`, dengan middleware `web`
- [x] 2.3 Modifikasi `resources/views/layouts/navigation.blade.php` — tambahkan search bar dengan Alpine.js component (`x-data="liveSearch()"`) yang menampilkan input search dengan ikon Lucide, dan dropdown hasil pencarian
- [x] 2.4 Implementasikan dropdown live search: debounce 300ms, tampilkan thumbnail + nama + harga, pesan "Produk tidak ditemukan" jika kosong, tutup saat klik di luar atau tekan Escape, dan redirect ke `/products?search=...` saat Enter
- [x] 2.5 Pastikan live search navbar responsif di mobile: di layar kecil, search bar muncul sebagai full-width bar yang toggle saat ikon search diklik, bukan inline di navbar

### Fase 3: Live Search & Filter Halaman Produk

- [x] 3.1 Tambahkan method `ajaxIndex(Request $request)` di `ProductController.php` yang menerima parameter filter (search, category, min_price, max_price, sort) dan mengembalikan JSON: `{html: '...rendered product cards...', total: N, hasPages: bool}`
- [x] 3.2 Tambahkan route `GET /products/ajax` di `routes/web.php`
- [x] 3.3 Modifikasi `resources/views/frontend/products/index.blade.php` — bungkus grid produk dengan Alpine.js component `x-data="productFilter()"`, hubungkan semua input filter ke state Alpine.js
- [x] 3.4 Implementasikan `$watch` di Alpine.js yang memicu Axios GET ke `/products/ajax` dengan parameter filter aktif ketika search query berubah (debounce 400ms)
- [x] 3.5 Saat AJAX sedang berjalan, tampilkan skeleton loader di area grid produk dan disable tombol filter untuk mencegah double-request
- [x] 3.6 Update counter "X Products" dan area pagination secara real-time sesuai response AJAX
- [x] 3.7 Implementasikan empty state yang ramah di grid produk jika hasil pencarian kosong (ikon + pesan + tombol "Clear Filters")
- [x] 3.8 Ubah sidebar filter di mobile menjadi Bootstrap 5 Offcanvas — tambahkan tombol "Filter" di header halaman produk yang membuka offcanvas, agar filter tidak menghalangi grid di mobile

### Fase 4: AJAX Cart (Keranjang)

- [x] 4.1 Tambahkan method `ajaxUpdate(Request $request, CartItem $cartItem)` di `CartController.php` yang memperbarui kuantitas dan mengembalikan JSON: `{success, subtotal, cart_total, cart_count}`
- [x] 4.2 Tambahkan method `ajaxRemove(CartItem $cartItem)` di `CartController.php` yang menghapus item dan mengembalikan JSON: `{success, cart_total, cart_count}`
- [x] 4.3 Tambahkan route `PUT /cart/{cartItem}/ajax` dan `DELETE /cart/{cartItem}/ajax` di `routes/web.php`
- [x] 4.4 Refactor `resources/views/frontend/cart/index.blade.php` — ubah quantity stepper dan tombol hapus dari form submit biasa menjadi Axios calls, update DOM (subtotal item & total) secara langsung tanpa reload
- [x] 4.5 Ganti `window.confirm()` saat hapus item keranjang dengan Alpine.js inline confirm dialog (mini modal atau inline expand) yang sesuai dengan desain

### Fase 5: AJAX Wishlist

- [x] 5.1 Tambahkan method `ajaxToggle(Request $request)` di `WishlistController.php` yang menerima `product_id`, toggle wishlist, dan mengembalikan JSON: `{success, inWishlist, message}`
- [x] 5.2 Tambahkan route `POST /wishlist/ajax` di `routes/web.php`
- [x] 5.3 Refactor semua tombol wishlist di `home.blade.php`, `products/index.blade.php`, dan `products/show.blade.php` — gunakan Axios POST ke `/wishlist/ajax`, update ikon `fas fa-heart` / `far fa-heart` secara instan, tampilkan toast sukses

### Fase 6: Audit & Perbaikan Halaman Landing

- [x] 6.1 Ganti gambar Unsplash hardcode di seksi "Brand Manifesto" dengan referensi `asset('images/')` dan tambahkan atribut `onerror` sebagai fallback ke gambar placeholder lokal
- [x] 6.2 Konversi seksi Testimonial dari satu kutipan statis menjadi carousel minimal 2–3 slide dengan autoplay, menggunakan Bootstrap 5 Carousel atau Alpine.js (tanpa library tambahan)
- [x] 6.3 Pastikan semua tombol CTA di hero carousel memiliki `min-height: 44px` dan teks yang cukup jelas di mobile (ukuran font minimal 14px)
- [x] 6.4 Perbaiki responsivitas halaman landing di mobile 320px–480px: cek font size headline, spacing, dan layout kolom yang mungkin overflow

### Fase 7: Audit & Perbaikan Halaman Home

- [x] 7.1 Perbaiki Flash Sale countdown timer — tambahkan guard Blade: jika `$flashSaleEnd` null atau sudah lewat, sembunyikan seluruh section countdown agar tidak tampil `00:00:00`
- [x] 7.2 Hubungkan tombol "Beli Sekarang" di promo slider ke `route('products.show', $product->slug)` yang benar
- [x] 7.3 Perbaiki tombol wishlist di grid New Collection dan Rekomendasi — gunakan Axios wishlist toggle (Fase 5)

### Fase 8: Audit & Perbaikan Halaman Detail Produk

- [x] 8.1 Implementasikan gallery thumbnail switcher via Alpine.js — klik thumbnail mengubah gambar utama, thumbnail aktif mendapat border highlight (struktur HTML sudah ada, JS-nya perlu ditambahkan)
- [x] 8.2 Tambahkan loading state pada tombol "Tambah ke Keranjang" dan "Beli Sekarang": disable tombol + tampilkan spinner saat proses AJAX berlangsung, tampilkan toast sukses setelah berhasil
- [x] 8.3 Tambahkan tombol "Load More Reviews" di seksi ulasan produk yang fetch ulasan halaman berikutnya via Axios dan append ke daftar ulasan yang ada, tanpa reload

### Fase 9: Audit & Perbaikan Halaman Checkout

- [x] 9.1 Tambahkan validasi inline real-time pada form checkout: field nomor telepon (format Indonesia), field alamat (minimal 10 karakter) — tampilkan pesan error di bawah field secara langsung tanpa submit menggunakan Alpine.js
- [x] 9.2 Tambahkan loading state pada dropdown/select ongkos kirim: saat pilihan provinsi/kota berubah dan ongkir sedang dihitung, tampilkan spinner kecil dan disable tombol checkout sementara

### Fase 10: Audit & Perbaikan Halaman Wishlist, Transaksi, Notifikasi

- [x] 10.1 Audit dan perbaiki tampilan `frontend/wishlist/index.blade.php` — pastikan konsisten dengan grid produk di halaman lain, tambahkan tombol hapus dari wishlist via AJAX
- [x] 10.2 Tambahkan fitur filter/pencarian sederhana di `frontend/transactions/index.blade.php` — input search berdasarkan nomor order atau status, filter via Axios tanpa reload
- [x] 10.3 Tambahkan badge notifikasi belum dibaca di navbar (`layouts/navigation.blade.php`) — ambil dari View Composer atau blade variable `$unreadCount`, tampilkan sebagai badge merah kecil di ikon lonceng

### Fase 11: Konsistensi & Aksesibilitas Global

- [~] 11.1 Audit dan perbaiki semua atribut `alt` pada tag `<img>` produk di semua halaman frontend — ganti string kosong, "default.jpg", atau nilai tidak deskriptif dengan nama produk yang sesuai
- [~] 11.2 Tambahkan `aria-label` yang deskriptif pada semua tombol ikon interaktif: wishlist toggle, cart remove, quantity stepper, dan search icon
- [x] 11.3 Test dan perbaiki layout responsive di breakpoint kritis: sidebar filter (`/products`) di tablet, product card grid di mobile, checkout form di mobile
- [x] 11.4 Migrasikan sisa toast manual (`@if(session('success'))`) yang masih tersisa ke global `<x-toast />` component, dan sesuaikan Alpine.js dispatch events-nya.

## Task Dependency Graph

```json
{
  "waves": [
    {
      "wave": 1,
      "tasks": ["1.1", "1.2", "1.3", "1.4"],
      "description": "Fondasi komponen bersama — harus selesai sebelum fase lain"
    },
    {
      "wave": 2,
      "tasks": ["2.1", "2.2", "2.3", "2.4", "2.5", "3.1", "3.2", "4.1", "4.2", "4.3", "5.1", "5.2"],
      "description": "Backend AJAX endpoints dan navbar live search markup"
    },
    {
      "wave": 3,
      "tasks": ["3.3", "3.4", "3.5", "3.6", "3.7", "3.8", "4.4", "4.5", "5.3"],
      "description": "Implementasi frontend AJAX (produk, cart, wishlist)"
    },
    {
      "wave": 4,
      "tasks": ["6.1", "6.2", "6.3", "6.4", "7.1", "7.2", "7.3", "8.1", "8.2", "8.3", "9.1", "9.2", "10.1", "10.2", "10.3"],
      "description": "Audit dan perbaikan per halaman — dapat dikerjakan paralel"
    },
    {
      "wave": 5,
      "tasks": ["11.1", "11.2", "11.3", "11.4"],
      "description": "Konsistensi dan aksesibilitas global — cleanup terakhir"
    }
  ]
}
```

## Notes

- Semua route AJAX baru menggunakan middleware `web` (bukan `api`) agar tetap mendapat CSRF protection dan session Laravel
- Tidak ada perubahan logika bisnis (kalkulasi harga, proses transaksi, dll.) — semua perubahan murni UI/frontend
- Tipe data response JSON harus konsisten: selalu return `{success: bool, message: string, data: ...}`
- Untuk AJAX yang membutuhkan auth, gunakan `@auth` guard yang sudah ada — jika user belum login dan mencoba wishlist/cart, return 401 dan frontend redirect ke login
- Gunakan Alpine.js `x-data` component functions (bukan inline object) untuk reusability: `liveSearch()`, `productFilter()`, `cartManager()`, `wishlistToggle()`
