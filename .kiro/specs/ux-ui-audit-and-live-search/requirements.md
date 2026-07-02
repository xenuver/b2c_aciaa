# Requirements: UX/UI Audit & Live Search

## Latar Belakang

Proyek ini adalah aplikasi e-commerce fashion wanita "Aciaa Store" berbasis Laravel dengan Blade templates. Stack frontend: Bootstrap 5, Tailwind CSS, Alpine.js, Lucide Icons, Font Awesome. Tujuan adalah melakukan audit menyeluruh UX/UI halaman frontend (customer) dan mengimplementasikan interaksi tanpa reload halaman—terutama live search.

**Batasan lingkup:**
- Hanya halaman frontend/customer (bukan panel admin)
- Fokus pada tampilan/UI (bukan logika backend baru seperti sistem pembayaran, dll.)
- Implementasi live search menggunakan AJAX/Alpine.js/Axios
- CSS baru tetap memakai Bootstrap 5 sebagai fondasi

---

## Requirements

### 1. Audit & Perbaikan Halaman Landing (`/`)

**1.1** Halaman landing HARUS memiliki navigasi yang konsisten dengan halaman lain (header/navbar) sehingga pengguna tidak merasa berpindah ke situs berbeda.

**1.2** Testimonial di landing page HARUS dapat menampilkan lebih dari satu ulasan (carousel/slider), bukan hanya satu kutipan statis, sehingga terasa lebih kredibel.

**1.3** Bagian "Brand Manifesto" HARUS menggunakan gambar lokal/produk sendiri (bukan hardcode URL Unsplash), atau jika gambar eksternal tetap digunakan, harus ada fallback graceful jika gambar gagal dimuat.

**1.4** Tombol CTA di hero carousel HARUS memiliki ukuran tap target minimal 44×44px di layar mobile agar mudah diklik.

### 2. Audit & Perbaikan Halaman Home (`/home`)

**2.1** Halaman home HARUS menampilkan pesan flash (success/error) dari session dengan komponen toast yang konsisten di semua halaman.

**2.2** Countdown timer Flash Sale di halaman home HARUS memiliki waktu target yang nyata (diambil dari konfigurasi atau database), bukan selalu `00:00:00` ketika tidak ada promo aktif. Jika tidak ada promo, timer HARUS disembunyikan.

**2.3** Tombol "Beli Sekarang" pada promo slider HARUS mengarahkan ke halaman detail produk atau memicu AJAX add-to-cart, bukan menjadi dead button.

**2.4** Bagian rekomendasi HARUS hanya muncul jika ada data rekomendasi (`$recommendations->count() > 0`)—kondisi ini sudah ada, HARUS dipertahankan dan tidak dihapus saat refactoring.

### 3. Audit & Perbaikan Halaman Daftar Produk (`/products`)

**3.1** Filter harga (min/max) HARUS bisa diaplikasikan tanpa submit form penuh—perubahan pada slider atau input harga HARUS memicu reload halaman produk secara otomatis (atau menggunakan AJAX).

**3.2** Halaman produk HARUS menampilkan indikator loading saat pengguna sedang menunggu hasil filter/search, sehingga tidak tampak "hang".

**3.3** Pada tampilan mobile, sidebar filter HARUS bisa ditampilkan/disembunyikan via tombol toggle, dan tidak menghalangi konten produk secara default.

**3.4** Kartu produk di grid HARUS menampilkan rating rata-rata (bintang) jika produk sudah punya ulasan.

### 4. Live Search Global (Navbar)

**4.1** Navigasi utama (`layouts/navigation.blade.php`) HARUS menyediakan ikon/input pencarian yang ketika diklik/diketik langsung menampilkan dropdown hasil pencarian tanpa reload halaman.

**4.2** Dropdown hasil live search HARUS muncul dalam waktu kurang dari 500ms setelah pengguna berhenti mengetik (debounce ~300ms).

**4.3** Dropdown hasil live search HARUS menampilkan: thumbnail gambar produk, nama produk, dan harga. Jumlah hasil maksimal 8 item.

**4.4** Jika tidak ada hasil ditemukan, dropdown HARUS menampilkan pesan "Produk tidak ditemukan" yang informatif, bukan dropdown kosong.

**4.5** Menekan tombol Enter atau klik tombol "Cari" dari live search HARUS mengarahkan ke halaman `/products?search=...` dengan penuh.

**4.6** Dropdown live search HARUS tertutup otomatis ketika pengguna klik di luar area search atau menekan tombol Escape.

### 5. Live Search di Halaman Produk (`/products`)

**5.1** Input pencarian di halaman produk (`/products`) HARUS memperbarui daftar produk secara real-time tanpa reload halaman penuh, menggunakan AJAX/fetch.

**5.2** Live search di halaman produk HARUS terintegrasi dengan filter yang aktif (kategori, harga, sort)—pencarian tidak boleh mereset filter yang sudah dipilih pengguna.

**5.3** Saat live search sedang memproses request, grid produk HARUS menampilkan skeleton loader atau spinner untuk memberikan feedback visual.

**5.4** Hasil live search di halaman produk HARUS memperbarui jumlah produk yang ditampilkan ("X Products") secara real-time.

**5.5** Jika hasil pencarian kosong, halaman produk HARUS menampilkan empty state yang ramah (dengan ikon dan saran tindakan), bukan halaman kosong.

### 6. Audit & Perbaikan Halaman Keranjang (`/cart`)

**6.1** Update kuantitas item di keranjang HARUS dilakukan via AJAX tanpa reload halaman penuh, agar subtotal dan total ter-update secara instan.

**6.2** Hapus item dari keranjang HARUS memiliki konfirmasi yang lebih baik dari `confirm()` bawaan browser—gunakan modal atau inline konfirmasi yang sesuai dengan desain.

**6.3** Keranjang HARUS menampilkan notifikasi instan (toast) ketika item berhasil diupdate atau dihapus.

### 7. Audit & Perbaikan Halaman Detail Produk (`/products/{slug}`)

**7.1** Tombol "Tambah ke Keranjang" dan "Beli Sekarang" HARUS memberikan feedback visual (loading state, disable sementara, lalu toast sukses) saat diklik.

**7.2** Halaman detail produk HARUS menampilkan galeri gambar yang berfungsi dengan benar—thumbnail aktif harus ter-highlight, dan gambar utama berubah saat thumbnail diklik.

**7.3** Bagian ulasan/rating HARUS dapat di-load lebih lanjut (load more / pagination) tanpa reload halaman jika ulasan > 5.

### 8. Audit & Perbaikan Halaman Checkout

**8.1** Form checkout HARUS memberikan validasi inline real-time pada field alamat dan nomor telepon, tanpa harus submit dulu untuk melihat error.

**8.2** Pemilihan ongkos kirim HARUS menampilkan loading state saat menghitung ongkir, bukan diam tanpa respons.

### 9. Audit & Perbaikan Halaman Wishlist, Transaksi, Notifikasi

**9.1** Tombol tambah/hapus wishlist di semua halaman (home, daftar produk, detail produk) HARUS bekerja via AJAX dan memperbarui ikon hati secara instan tanpa reload.

**9.2** Daftar transaksi HARUS dapat difilter/dicari berdasarkan status atau nomor order tanpa reload halaman.

**9.3** Halaman notifikasi HARUS menampilkan badge jumlah notifikasi belum dibaca di navbar, dan badge tersebut HARUS ter-update real-time (atau setidaknya saat halaman di-refresh).

### 10. Konsistensi & Aksesibilitas Global

**10.1** Semua halaman HARUS menggunakan komponen toast yang sama (`components/toast.blade.php`) untuk menampilkan pesan sukses/error.

**10.2** Semua gambar produk HARUS memiliki atribut `alt` yang deskriptif (bukan kosong atau "default.jpg").

**10.3** Semua tombol interaktif (tambah ke keranjang, wishlist, search) HARUS memiliki atribut `aria-label` yang sesuai untuk aksesibilitas.

**10.4** Halaman HARUS responsif di breakpoint mobile (320px–767px), tablet (768px–1023px), dan desktop (1024px+) dengan layout yang tidak rusak.
