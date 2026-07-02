# BAB 5 — HASIL PENELITIAN

---

## 5.1 Desain dan Pengembangan

### 5.1.1 Tahap Perencanaan Kebutuhan

#### 5.1.1.1 Kebutuhan Fungsional

Berdasarkan analisis sistem yang dilakukan, diperoleh **92 kebutuhan fungsional** yang terbagi ke dalam 13 modul. Kebutuhan fungsional secara lengkap dapat dilihat pada file `ANALISIS_KEBUTUHAN_SKRIPSI.md`.

**Tabel 5.1 Ringkasan Kebutuhan Fungsional**

| No | Modul | Jumlah Kebutuhan |
|----|-------|:----------------:|
| 1 | Autentikasi & Manajemen Profil | 10 |
| 2 | Manajemen Kategori | 7 |
| 3 | Manajemen Produk | 10 |
| 4 | Manajemen Keranjang Belanja | 6 |
| 5 | Manajemen Checkout & Transaksi | 12 |
| 6 | Manajemen Voucher | 10 |
| 7 | Manajemen Rating & Ulasan | 9 |
| 8 | Manajemen Retur | 7 |
| 9 | Wishlist | 4 |
| 10 | Manajemen Banner | 7 |
| 11 | Dashboard Admin & Laporan | 6 |
| 12 | Notifikasi | 4 |
| | **TOTAL** | **92** |

#### 5.1.1.2 Kebutuhan Non-Fungsional

Diperoleh **28 kebutuhan non-fungsional** yang mencakup 7 aspek:

**Tabel 5.2 Ringkasan Kebutuhan Non-Fungsional**

| No | Aspek | Jumlah Kebutuhan |
|----|-------|:----------------:|
| 1 | Keamanan (Security) | 7 |
| 2 | Kinerja (Performance) | 3 |
| 3 | Keandalan (Reliability) | 4 |
| 4 | Kegunaan (Usability) | 5 |
| 5 | Kompatibilitas (Compatibility) | 3 |
| 6 | Portabilitas (Portability) | 3 |
| 7 | Maintainability | 3 |
| | **TOTAL** | **28** |

---

### 5.1.2 Tahap Desain Pengguna

#### 5.1.2.1 Arsitektur B2C

Sistem ACIAA E-Commerce menerapkan arsitektur **Business-to-Customer (B2C)** di mana penjual (admin) menjual produk langsung kepada konsumen (customer). Arsitektur sistem digambarkan sebagai berikut:

**[Gambar Arsitektur B2C]**

Penjelasan arsitektur:
1. **Customer** mengakses aplikasi melalui web browser.
2. **Web Server** melayani permintaan HTTP dan menjalankan aplikasi Laravel.
3. **Application Server** memproses logika bisnis, termasuk integrasi dengan:
   - **Midtrans API** — pemrosesan pembayaran
   - **RajaOngkir API (Komerce)** — perhitungan ongkos kirim
4. **Database Server** menyimpan data sistem menggunakan MySQL.

#### 5.1.2.2 Perancangan Database

Perancangan database menghasilkan **30 tabel** yang saling berelasi. Entity Relationship Diagram (ERD) sistem adalah sebagai berikut:

**[Gambar ERD]**

Relasi antar tabel meliputi:
- **One to One**: `users` → `customers`, `transactions` → `transaction_details`
- **One to Many**: `categories` → `products`, `users` → `transactions`, `products` → `product_ratings`
- **Many to Many**: `users` ↔ `vouchers` (melalui `user_vouchers`)

Struktur tabel lengkap dapat dilihat pada Lampiran.

#### 5.1.2.3 Perancangan Model B2C

Perancangan class diagram menghasilkan **17 class utama** yang merepresentasikan struktur data dan method sistem:

**Tabel 5.3 Class Diagram Sistem**

| No | Class | Atribut Utama | Method Utama |
|----|-------|--------------|--------------|
| 1 | User | id, name, email, password, role | getRoleAttribute() |
| 2 | Customer | id, user_id, phone, avatar, gender, birth_date | getAvatarAttribute() |
| 3 | Category | id, name, slug, image | scopeActive() |
| 4 | Product | id, category_id, name, slug, price, stock, weight, description | getDiscPriceAttribute(), scopeActive(), scopeFilter() |
| 5 | ProductGallery | id, product_id, photo | - |
| 6 | Cart | id, user_id, product_id, qty | - |
| 7 | Transaction | id, code, user_id, status, payment_status, shipping_price, total, sub_total | getTotalAttribute(), getShippingPriceAttribute() |
| 8 | TransactionDetail | id, transaction_id, product_id, qty, price | - |
| 9 | Address | id, user_id, label, province, city, subdistrict, detail, is_default | scopeActive() |
| 10 | Voucher | id, code, name, type, value, min_purchase, max_uses, expired_date | scopeActive() |
| 11 | UserVoucher | id, user_id, voucher_id, is_used | - |
| 12 | ProductRating | id, user_id, product_id, trans_detail_id, star, review, photo, status | - |
| 13 | Return | id, transaction_id, reason, description, status, photo | - |
| 14 | ReturnItem | id, return_id, product_id, qty | - |
| 15 | Wishlist | id, user_id, product_id | - |
| 16 | Banner | id, image, link, title, is_active | scopeActive() |
| 17 | Notification | id, user_id, title, message, is_read | - |

**Relasi Antar Class:**

**[Gambar Class Diagram]**

Class diagram lengkap dengan atribut, method, dan relasi dapat dilihat pada `CLASS_DIAGRAM_ANALISIS.md`.

---

### 5.1.3 Tahap Konstruksi

Tahap konstruksi merupakan proses pembangunan antarmuka sistem berdasarkan hasil perancangan yang telah dilakukan. Sistem dibangun menggunakan framework **Laravel 11** dengan **Tailwind CSS** untuk tampilan frontend.

#### 5.1.3.1 Interface User (Customer)

Berikut adalah antarmuka yang tersedia untuk pengguna dengan role customer:

**a. Halaman Landing Page**

**[Gambar Landing Page]**

Halaman utama sistem menampilkan banner promosi, produk terbaru, kategori produk, dan navigasi utama.

**b. Halaman Login**

**[Gambar Halaman Login]**

Halaman login menyediakan form autentikasi dengan input email dan password, tautan registrasi, dan opsi login menggunakan Google.

**c. Halaman Registrasi**

**[Gambar Halaman Registrasi]**

Halaman registrasi digunakan customer untuk membuat akun baru dengan mengisi nama, email, nomor telepon, dan password.

**d. Halaman Katalog Produk**

**[Gambar Halaman Katalog Produk]**

Halaman katalog menampilkan seluruh produk dalam bentuk grid dengan informasi gambar, nama, harga, dan stok.

**e. Halaman Detail Produk**

**[Gambar Halaman Detail Produk]**

Halaman detail produk menampilkan informasi lengkap produk, galeri gambar, deskripsi, rating, dan tombol tambah ke keranjang.

**f. Halaman Keranjang**

**[Gambar Halaman Keranjang]**

Halaman keranjang menampilkan daftar produk yang dipilih customer beserta jumlah, subtotal, dan tombol checkout.

**g. Halaman Checkout**

**[Gambar Halaman Checkout]**

Halaman checkout terdiri dari ringkasan pesanan, pemilihan alamat pengiriman, pemilihan kurir dan layanan pengiriman, serta pemilihan voucher.

**h. Halaman Pembayaran Midtrans**

**[Gambar Halaman Pembayaran Midtrans]**

Halaman pembayaran menampilkan Snap popup Midtrans yang menyediakan berbagai metode pembayaran.

**i. Halaman Riwayat Transaksi**

**[Gambar Halaman Riwayat Transaksi]**

Halaman riwayat menampilkan daftar transaksi customer dengan status dan total.

**j. Halaman Detail Transaksi**

**[Gambar Halaman Detail Transaksi]**

Halaman detail transaksi menampilkan informasi lengkap pesanan, termasuk produk, ongkir, diskon, status, dan nomor resi.

**k. Halaman Voucher**

**[Gambar Halaman Voucher]**

Halaman voucher menampilkan daftar voucher yang tersedia untuk diklaim oleh customer.

**l. Halaman Rating & Ulasan**

**[Gambar Halaman Rating]**

Halaman rating menampilkan form penilaian bintang dan ulasan untuk produk yang sudah dibeli.

**m. Halaman Retur**

**[Gambar Halaman Retur]**

Halaman retur menampilkan form pengajuan retur dengan pilihan alasan dan upload foto.

**n. Halaman Notifikasi**

**[Gambar Halaman Notifikasi]**

Halaman notifikasi menampilkan daftar notifikasi yang diterima customer dengan fitur filter dan mark as read.

**o. Halaman Wishlist**

**[Gambar Halaman Wishlist]**

Halaman wishlist menampilkan daftar produk yang disimpan customer.

#### 5.1.3.2 Interface Admin

Berikut adalah antarmuka yang tersedia untuk pengguna dengan role admin:

**a. Halaman Dashboard Admin**

**[Gambar Dashboard Admin]**

Dashboard admin menampilkan ringkasan data: total produk, kategori, customer, transaksi, pendapatan, grafik pendapatan 6 bulan, produk terlaris, transaksi terbaru, stok menipis, dan customer teraktif.

**b. Halaman Manajemen Produk**

**[Gambar Halaman Manajemen Produk]**

Halaman ini menampilkan daftar produk dalam bentuk tabel dengan fitur tambah, edit, hapus, dan pencarian.

**c. Halaman Form Tambah/Edit Produk**

**[Gambar Form Produk]**

Form produk terdiri dari input nama, kategori, harga, harga diskon, stok, berat, deskripsi, dan upload gambar.

**d. Halaman Manajemen Kategori**

**[Gambar Halaman Manajemen Kategori]**

Halaman ini menampilkan daftar kategori dengan fitur tambah, edit, dan hapus.

**e. Halaman Manajemen Transaksi**

**[Gambar Halaman Manajemen Transaksi]**

Halaman ini menampilkan daftar transaksi dengan fitur update status pesanan, status pembayaran, dan input nomor resi.

**f. Halaman Manajemen Voucher**

**[Gambar Halaman Manajemen Voucher]**

Halaman ini menampilkan daftar voucher dengan fitur tambah, edit, dan hapus.

**g. Halaman Manajemen Rating**

**[Gambar Halaman Manajemen Rating]**

Halaman ini menampilkan daftar rating yang perlu disetujui atau ditolak oleh admin.

**h. Halaman Manajemen Retur**

**[Gambar Halaman Manajemen Retur]**

Halaman ini menampilkan daftar pengajuan retur untuk disetujui atau ditolak.

**i. Halaman Manajemen Banner**

**[Gambar Halaman Manajemen Banner]**

Halaman ini menampilkan daftar banner dengan fitur tambah, edit, dan hapus.

**j. Halaman Manajemen Customer**

**[Gambar Halaman Manajemen Customer]**

Halaman ini menampilkan daftar customer yang terdaftar.

---

### 5.1.4 Tahap Implementasi

#### 5.1.4.1 Black Box Testing

Black box testing dilakukan dengan menggunakan teknik **Equivalence Partitioning (EP)** untuk menguji fungsionalitas sistem tanpa melihat struktur internal kode. Total terdapat **183 test case** yang terbagi ke dalam 12 modul.

**Tabel 5.4 Hasil Blackbox Testing**

| No | Modul | Jumlah TC | Valid | Invalid | Coverage |
|----|-------|:---------:|:-----:|:-------:|:--------:|
| 1 | Autentikasi | 16 | | | |
| 2 | Produk | 30 | | | |
| 3 | Keranjang | 10 | | | |
| 4 | Checkout | 40 | | | |
| 5 | Midtrans Payment | 9 | | | |
| 6 | Voucher | 18 | | | |
| 7 | Rating | 13 | | | |
| 8 | Retur | 14 | | | |
| 9 | Transaksi | 14 | | | |
| 10 | Wishlist | 5 | | | |
| 11 | Akses Admin | 3 | | | |
| 12 | Banner | 11 | | | |
| | **TOTAL** | **183** | | | |

Detail seluruh test case dapat dilihat pada `BLACKBOX_EP_TESTING.md`.

#### 5.1.4.2 Hosting

Sistem di-hosting menggunakan **ngrok** untuk tunneling ke local server XAMPP. Konfigurasi hosting:

**[Tabel Hosting]**

| Aspek | Keterangan |
|-------|-----------|
| Web Server | Apache (XAMPP) |
| Database | MySQL (XAMPP, port 3307) |
| Tunneling | ngrok (URL: *.ngrok-free.dev) |
| Framework | Laravel 11 |
| PHP Version | 8.x |
| Midtrans Environment | Sandbox |
| Capture URL | `https://legroom-bluish-vastness.ngrok-free.dev/midtrans/notification` |

---

## 5.2 Demonstrasi

Demonstrasi sistem menjelaskan **alur penggunaan** fitur-fitur utama dari sudut pandang pengguna (customer dan admin). Berbeda dengan sub-bab 5.1.3 yang menampilkan tampilan setiap halaman secara statis, sub-bab ini menjelaskan **bagaimana pengguna menggunakan sistem** secara step-by-step.

### 5.2.1 Demonstrasi Alur Registrasi dan Login

1. Customer membuka halaman utama sistem.
2. Customer menekan tombol "Daftar" pada navbar untuk menuju halaman registrasi.
3. Customer mengisi form registrasi dengan nama, email, password, dan nomor telepon.
4. Sistem memvalidasi data, menyimpan akun baru, dan mengarahkan customer ke halaman utama.
5. Untuk login, customer menekan tombol "Masuk" dan memasukkan email serta password.
6. Sistem memverifikasi kredensial. Jika valid, customer diarahkan ke halaman utama sesuai role.
7. Jika login gagal, sistem menampilkan pesan error "Email atau password salah".
8. Customer juga dapat login menggunakan akun Google melalui tombol "Masuk dengan Google".

### 5.2.2 Demonstrasi Alur Pembelian Produk

1. Customer membuka halaman utama dan melihat produk-produk yang ditampilkan.
2. Customer mencari produk yang diinginkan melalui kolom pencarian atau memilih kategori.
3. Customer menekan gambar atau nama produk untuk melihat detail.
4. Pada halaman detail, customer memilih jumlah produk dan menekan "Tambah ke Keranjang".
5. Sistem menambahkan produk ke keranjang dan menampilkan notifikasi sukses.
6. Customer membuka halaman keranjang melalui ikon keranjang di navbar.
7. Customer memeriksa daftar produk, mengubah jumlah, atau menghapus produk.
8. Customer menekan tombol "Checkout" untuk melanjutkan ke pembayaran.

### 5.2.3 Demonstrasi Alur Checkout

1. Customer tiba di halaman checkout yang menampilkan ringkasan pesanan.
2. Customer memilih alamat pengiriman dari daftar alamat yang tersimpan atau menekan "Tambah Alamat Baru".
3. Customer memilih kurir pengiriman (JNE, POS, atau TIKI). Sistem memanggil API RajaOngkir untuk menghitung ongkos kirim.
4. Setelah ongkos kirim ditampilkan, customer memilih layanan pengiriman yang diinginkan.
5. Customer dapat memilih voucher dengan menekan tombol "Pilih Voucher". Sistem menghitung diskon secara otomatis.
6. Customer memeriksa total akhir (subtotal + ongkir - diskon) dan menekan "Bayar Sekarang".
7. Sistem membuat transaksi dan menampilkan popup pembayaran Midtrans Snap.
8. Customer memilih metode pembayaran (transfer bank, e-wallet, atau channel lainnya).
9. Customer menyelesaikan pembayaran. Sistem menerima notifikasi dari Midtrans dan memperbarui status transaksi.
10. Customer diarahkan ke halaman sukses yang menampilkan detail pesanan.

### 5.2.4 Demonstrasi Alur Tracking Pesanan

1. Customer membuka halaman "Riwayat Transaksi" dari menu akun.
2. Customer memilih transaksi yang ingin dilihat detailnya.
3. Halaman detail menampilkan status pesanan, status pembayaran, dan status pengiriman.
4. Jika admin telah memasukkan nomor resi, customer dapat melihat nomor resi tersebut.
5. Customer menekan tautan tracking untuk melacak posisi paket.

### 5.2.5 Demonstrasi Alur Klaim Voucher

1. Customer membuka halaman "Voucher" dari menu akun.
2. Sistem menampilkan daftar voucher yang tersedia beserta informasi syarat dan ketentuan.
3. Customer menekan tombol "Klaim" pada voucher yang diinginkan.
4. Sistem menambahkan voucher ke akun customer dan menampilkan notifikasi sukses.
5. Saat checkout, voucher yang sudah diklaim muncul di daftar pilihan voucher.

### 5.2.6 Demonstrasi Alur Memberi Rating

1. Customer membuka halaman detail transaksi yang sudah selesai (status selesai/diterima).
2. Customer menekan tombol "Beri Ulasan" pada produk yang ingin diberi rating.
3. Sistem menampilkan form rating dengan pilihan bintang (1-5), kolom ulasan teks, dan upload gambar.
4. Customer memilih bintang, menulis ulasan, dan menekan "Kirim".
5. Sistem menyimpan rating dengan status "pending" untuk disetujui admin terlebih dahulu.

### 5.2.7 Demonstrasi Alur Pengajuan Retur

1. Customer membuka halaman detail transaksi.
2. Customer menekan tombol "Ajukan Retur".
3. Customer memilih produk yang diretur, alasan retur (cacat, salah barang, tidak sesuai, ukuran, lainnya), menulis deskripsi, dan mengupload foto bukti.
4. Customer menekan tombol "Kirim" dan sistem menyimpan pengajuan retur.
5. Admin memproses pengajuan retur melalui halaman manajemen retur.
6. Status retur diperbarui menjadi "disetujui" atau "ditolak".

### 5.2.8 Demonstrasi Alur Manajemen Admin

1. Admin login dan masuk ke halaman dashboard yang menampilkan ringkasan data toko.
2. Admin mengelola produk: menekan "Produk" → "Tambah Produk" untuk menambahkan produk baru.
3. Admin mengelola transaksi: menekan "Transaksi" → memilih transaksi → mengubah status pengiriman dan memasukkan nomor resi.
4. Admin mengelola voucher: menekan "Voucher" → "Tambah Voucher" untuk membuat voucher baru.
5. Admin menyetujui rating: menekan "Rating" → menyetujui atau menolak ulasan customer.
6. Admin memproses retur: menekan "Retur" → menyetujui atau menolak pengajuan retur.

### 5.2.9 Demonstrasi Alur Notifikasi

1. Customer atau admin menerima notifikasi ketika ada event tertentu (pesanan baru, status berubah, dll).
2. Ikon notifikasi di navbar menampilkan badge jumlah notifikasi yang belum dibaca.
3. Customer menekan ikon notifikasi untuk melihat daftar notifikasi terbaru.
4. Customer membuka halaman notifikasi untuk melihat seluruh notifikasi.
5. Customer menekan "Tandai Sudah Dibaca" untuk menandai notifikasi.
6. Customer dapat menghapus notifikasi satu per satu atau menghapus semua.

---

## 5.3 Evaluasi

Evaluasi sistem dilakukan berdasarkan hasil pengujian blackbox yang telah dilaksanakan pada sub-bab 5.1.4.1. Bagian ini menganalisis hasil pengujian dan mengevaluasi pemenuhan kebutuhan sistem.

### 5.3.1 Analisis Hasil Blackbox Testing

Berdasarkan hasil blackbox testing pada Tabel 5.4, diperoleh analisis sebagai berikut:

**Tingkat Keberhasilan**

| Indikator | Hasil |
|-----------|-------|
| Total Test Case | 183 |
| Test Case Valid (sesuai harapan) | ___ (___%) |
| Test Case Invalid (ditemukan bug) | ___ (___%) |

*(diisi setelah pengujian selesai)*

### 5.3.2 Evaluasi Pemenuhan Kebutuhan Fungsional

**Tabel 5.5 Evaluasi Kebutuhan Fungsional**

| No | Modul | Kebutuhan Terpenuhi | Kebutuhan Tidak Terpenuhi | Persentase |
|----|-------|:-------------------:|:-------------------------:|:----------:|
| 1 | Autentikasi & Manajemen Profil | | | |
| 2 | Manajemen Kategori | | | |
| 3 | Manajemen Produk | | | |
| 4 | Manajemen Keranjang | | | |
| 5 | Manajemen Checkout & Transaksi | | | |
| 6 | Manajemen Voucher | | | |
| 7 | Manajemen Rating & Ulasan | | | |
| 8 | Manajemen Retur | | | |
| 9 | Wishlist | | | |
| 10 | Manajemen Banner | | | |
| 11 | Dashboard Admin & Laporan | | | |
| 12 | Notifikasi | | | |
| | **TOTAL** | | | |

Dari 92 kebutuhan fungsional yang teridentifikasi, sebanyak ___ kebutuhan (___%) terpenuhi dan ___ kebutuhan (___%) tidak terpenuhi.

### 5.3.3 Evaluasi Pemenuhan Kebutuhan Non-Fungsional

**Tabel 5.6 Evaluasi Kebutuhan Non-Fungsional**

| No | Aspek | Kebutuhan Terpenuhi | Kebutuhan Tidak Terpenuhi | Persentase |
|----|-------|:-------------------:|:-------------------------:|:----------:|
| 1 | Keamanan | | | |
| 2 | Kinerja | | | |
| 3 | Keandalan | | | |
| 4 | Kegunaan | | | |
| 5 | Kompatibilitas | | | |
| 6 | Portabilitas | | | |
| 7 | Maintainability | | | |
| | **TOTAL** | | | |

### 5.3.4 Temuan Bug

*(Diisi jika ada bug yang ditemukan selama pengujian)*

**Tabel 5.7 Daftar Temuan Bug**

| No | Modul | Skenario | Bug | Status |
|----|-------|---------|-----|--------|
| - | - | - | Tidak ada bug yang ditemukan | - |

### 5.3.5 Kesimpulan Evaluasi

Berdasarkan hasil pengujian dan evaluasi yang telah dilakukan:

1. Sistem dinyatakan **layak / tidak layak** untuk digunakan berdasarkan ___% test case yang berhasil.
2. Kebutuhan fungsional sistem terpenuhi sebesar ___%.
3. Kebutuhan non-fungsional sistem terpenuhi sebesar ___%.
4. Sistem dapat berjalan dengan baik pada lingkungan hosting yang telah dikonfigurasi.

---

## 5.4 Komunikasi

Sub-bab komunikasi menjelaskan bagaimana sistem berinteraksi dengan pengguna dan sistem eksternal, keterbatasan sistem, serta saran pengembangan selanjutnya.

### 5.4.1 Komunikasi dengan Pengguna

Sistem berkomunikasi dengan pengguna melalui beberapa media:

**Tabel 5.8 Media Komunikasi dengan Pengguna**

| Media | Deskripsi | Digunakan di |
|-------|-----------|-------------|
| Antarmuka Web (UI) | Pengguna berinteraksi dengan sistem melalui halaman web responsif | Seluruh halaman |
| Flash Message | Notifikasi temporer yang muncul setelah aksi pengguna (sukses/error/warning) | Setiap form submission |
| Notifikasi In-App | Notifikasi tersimpan di database yang tampil di dropdown navbar | Update status transaksi, promo |
| Validasi Form | Pesan validasi real-time saat pengguna mengisi form | Form registrasi, login, checkout |

### 5.4.2 Komunikasi dengan Sistem Eksternal

Sistem terintegrasi dengan dua layanan eksternal utama:

#### 5.4.2.1 Komunikasi dengan Midtrans (Payment Gateway)

**Gambar 5.X Alur Komunikasi Midtrans**

| Detail | Keterangan |
|--------|-----------|
| Metode | HTTP REST API + Webhook |
| Autentikasi | Server Key & Client Key (environment variable) |
| Keamanan | Verifikasi signature key (SHA512 hash) |

**Alur Komunikasi:**
1. Aplikasi backend mengirim data transaksi ke endpoint Midtrans Snap API.
2. Midtrans mengembalikan Snap Token yang digunakan oleh frontend.
3. Frontend menampilkan Snap Popup menggunakan Snap Token.
4. Customer memilih metode pembayaran dan melakukan pembayaran.
5. Midtrans mengirim notifikasi HTTP POST ke endpoint `/midtrans/notification`.
6. Sistem backend menerima notifikasi, memverifikasi signature key, dan memperbarui status transaksi.
7. Notifikasi in-app dikirimkan ke customer terkait perubahan status.

**Kode Implementasi:**
- Service: `app/Services/MidtransService.php`
- Controller: `app/Http/Controllers/MidtransController.php`
- Konfigurasi: `config/midtrans.php`

#### 5.4.2.2 Komunikasi dengan RajaOngkir Komerce (Shipping)

**Gambar 5.X Alur Komunikasi RajaOngkir**

| Detail | Keterangan |
|--------|-----------|
| Metode | HTTP REST API (Komerce v1) |
| Autentikasi | API Key (environment variable) |
| Endpoint | `/calculate/domestic-cost`, `/destination/province`, `/destination/city`, `/destination/district` |
| Kurir | JNE, POS Indonesia, TIKI |
| Exclude | JTR (JNE Trucking), TIKI motor / TRC |
| Origin | Kota Pontianak (subdistrict_id: 4911) |

**Alur Komunikasi:**
1. Saat customer membuka halaman checkout, sistem mengambil data provinsi dari API Komerce.
2. Customer memilih provinsi → sistem mengambil data kota → customer memilih kota → sistem mengambil data kecamatan.
3. Setelah customer memilih alamat lengkap dan kurir, sistem memanggil API ongkos kirim.
4. API mengembalikan daftar layanan dengan biaya dan estimasi pengiriman.
5. Hasil perhitungan di-cache selama 1 hari di tabel `shipping_costs` untuk menghindari panggilan API berulang.
6. Jika API gagal (timeout/error), sistem menggunakan data cache yang masih tersedia.

**Kode Implementasi:**
- Service: `app/Services/RajaOngkirService.php`
- Controller: `app/Http/Controllers/RajaOngkirController.php`
- Konfigurasi: `config/rajaongkir.php`

### 5.4.3 Keterbatasan Sistem

Berdasarkan hasil penelitian, sistem ACIAA E-Commerce memiliki beberapa keterbatasan:

**Tabel 5.9 Keterbatasan Sistem**

| No | Keterbatasan | Penjelasan |
|----|-------------|------------|
| 1 | Hanya 3 kurir | Sistem hanya mengimplementasikan JNE, POS, dan TIKI, padahal RajaOngkir mendukung lebih banyak ekspedisi |
| 2 | Tidak ada fitur chat real-time | Komunikasi antara customer dan admin masih melalui notifikasi sistem, belum ada fitur chat langsung |
| 3 | Single store | Sistem hanya mendukung satu toko dengan satu alamat asal pengiriman, belum mendukung multi-cabang |
| 4 | Email notification non-aktif | Notifikasi hanya melalui in-app web notification, notifikasi email tidak digunakan |
| 5 | Tidak ada refund otomatis | Proses refund masih dilakukan secara manual oleh admin |
| 6 | Single bahasa | Sistem hanya menggunakan Bahasa Indonesia, belum ada dukungan multi-bahasa |
| 7 | Hosting ngrok | Sistem masih berjalan di localhost dengan tunneling ngrok, belum menggunakan hosting production |

### 5.4.4 Saran Pengembangan

Berdasarkan hasil evaluasi dan keterbatasan yang teridentifikasi, berikut saran untuk pengembangan sistem selanjutnya:

**Tabel 5.10 Saran Pengembangan**

| No | Saran | Prioritas | Manfaat |
|----|-------|:---------:|---------|
| 1 | Integrasi dengan marketplace (Tokopedia, Shopee, dll) | Medium | Otomatisasi manajemen multi-channel |
| 2 | Fitur chat real-time customer-admin (WebSocket/Laravel Reverb) | Medium | Mempercepat komunikasi |
| 3 | Export laporan PDF | Low | Format laporan tambahan selain Excel/CSV |
| 4 | Sistem rekomendasi produk berbasis AI | Low | Personalisasi berdasarkan riwayat pembelian |
| 5 | Aplikasi mobile (React Native / Flutter) | Medium | Kemudahan akses pengguna mobile |
| 6 | Multi-bahasa Indonesia & Inggris | Low | Memperluas jangkauan pengguna |
| 7 | Multi-store / multi-cabang | Low | Mendukung pengembangan bisnis |
| 8 | Integrasi WhatsApp Gateway untuk notifikasi | Medium | Notifikasi alternatif yang lebih cepat |
| 9 | Deployment ke hosting production (VPS / cloud) | **High** | Stabilitas dan keamanan sistem |
| 10 | Sistem refund otomatis | Medium | Efisiensi proses retur |

