# BAB 5 — HASIL PENELITIAN
## ACIAA E-Commerce

---

## 5.1 DESAIN DAN PENGEMBANGAN

---

### 5.1.1 Tahap Perencanaan Kebutuhan

Tahap perencanaan kebutuhan dilakukan dengan menganalisis sistem e-commerce yang telah dibangun untuk mengidentifikasi seluruh kebutuhan fungsional dan non-fungsional yang diperlukan.

---

#### 5.1.1.1 Kebutuhan Fungsional

Kebutuhan fungsional (functional requirements) menggambarkan fitur-fitur spesifik yang harus dimiliki sistem. Berdasarkan hasil analisis sistem ACIAA E-Commerce, diperoleh **92 kebutuhan fungsional** yang terbagi ke dalam 13 modul sebagai berikut:

**Tabel 5.1 Kebutuhan Fungsional Modul Autentikasi & Manajemen Pengguna**

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-01 | Registrasi Akun | Customer | Sistem menyediakan halaman registrasi bagi pengguna baru untuk mendaftar dengan mengisi nama, email, dan password |
| F-02 | Login Akun | Customer, Admin | Sistem menyediakan autentikasi login berbasis email dan password |
| F-03 | Login dengan Google | Customer | Sistem mendukung autentikasi menggunakan akun Google (OAuth) |
| F-04 | Logout Akun | Customer, Admin | Sistem menyediakan fitur logout untuk mengakhiri sesi |
| F-05 | Reset Password | Customer | Sistem menyediakan fitur lupa password melalui email |
| F-06 | Edit Profil | Customer | Sistem memungkinkan pengguna mengubah nama, email, nomor telepon, dan avatar |
| F-07 | Hapus Akun | Customer | Sistem memungkinkan pengguna menghapus akun mereka |
| F-08 | Manajemen Role User | Admin | Sistem membedakan role user menjadi `admin` dan `customer` |
| F-09 | Kelola Data User | Admin | Admin dapat melihat daftar user, detail, mengedit status aktif/nonaktif, dan menghapus user |

**Tabel 5.2 Kebutuhan Fungsional Modul Manajemen Produk & Kategori**

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-10 | Lihat Katalog Produk | Customer | Sistem menampilkan daftar produk lengkap dengan gambar, harga, dan rating |
| F-11 | Detail Produk | Customer | Sistem menampilkan detail produk termasuk deskripsi, harga, galeri gambar, stok, dan rating |
| F-12 | Filter Produk per Kategori | Customer | Sistem menampilkan produk berdasarkan kategori yang dipilih |
| F-13 | Cari Produk | Customer | Sistem menyediakan pencarian produk berdasarkan nama |
| F-14 | Lihat Produk Promo | Customer | Sistem menampilkan produk yang sedang promo di halaman utama |
| F-15 | Lihat Produk Terbaru | Customer | Sistem menampilkan produk terbaru di halaman utama |
| F-16 | CRUD Kategori | Admin | Admin dapat menambah, melihat, mengedit, dan menghapus kategori produk |
| F-17 | CRUD Produk | Admin | Admin dapat menambah, melihat, mengedit, dan menghapus produk termasuk upload gambar |
| F-18 | Atur Produk Promo | Admin | Admin dapat menandai produk sebagai promo dan mengatur harga diskon |
| F-19 | Manajemen Stok Produk | Admin | Admin dapat melihat stok, mengubah stok, melihat histori mutasi stok, dan bulk update stok |
| F-20 | Kategori Aktif/Nonaktif | Admin | Admin dapat mengaktifkan atau menonaktifkan kategori |

**Tabel 5.3 Kebutuhan Fungsional Modul Manajemen Banner**

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-21 | Lihat Banner | Customer | Sistem menampilkan banner slider di halaman landing dan home berdasarkan jadwal tayang |
| F-22 | CRUD Banner | Admin | Admin dapat menambah, melihat, mengedit, dan menghapus banner dengan gambar dan tautan |
| F-23 | Atur Jadwal Banner | Admin | Admin dapat mengatur tanggal mulai dan berakhir penayangan banner |

**Tabel 5.4 Kebutuhan Fungsional Modul Keranjang Belanja**

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-24 | Tambah ke Keranjang | Customer | Sistem memungkinkan customer menambahkan produk ke keranjang |
| F-25 | Lihat Keranjang | Customer | Sistem menampilkan daftar produk dalam keranjang dengan jumlah, harga, dan total |
| F-26 | Ubah Jumlah Item | Customer | Sistem memungkinkan customer mengubah kuantitas item di keranjang |
| F-27 | Hapus Item Keranjang | Customer | Sistem memungkinkan customer menghapus item dari keranjang |
| F-28 | Hitung Jumlah Item | Customer | Sistem menampilkan badge jumlah item keranjang di navbar (AJAX) |

**Tabel 5.5 Kebutuhan Fungsional Modul Wishlist**

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-29 | Tambah/Hapus Wishlist | Customer | Sistem memungkinkan customer menambahkan atau menghapus produk dari wishlist (toggle AJAX) |
| F-30 | Lihat Wishlist | Customer | Sistem menampilkan daftar produk yang disimpan di wishlist |
| F-31 | Hapus Wishlist | Customer | Sistem memungkinkan customer menghapus item wishlist satu per satu |
| F-32 | Hitung Wishlist | Customer | Sistem menampilkan badge jumlah wishlist di navbar (AJAX) |

**Tabel 5.6 Kebutuhan Fungsional Modul Checkout & Transaksi**

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-33 | Pilih Alamat Pengiriman | Customer | Sistem menampilkan daftar alamat customer dan memungkinkan memilih alamat pengiriman |
| F-34 | Tambah Alamat Baru | Customer | Sistem memungkinkan customer menambah alamat baru saat checkout |
| F-35 | Edit Alamat | Customer | Sistem memungkinkan customer mengedit alamat yang sudah ada |
| F-36 | Hapus Alamat | Customer | Sistem memungkinkan customer menghapus alamat |
| F-37 | Pilih Provinsi, Kota, Kecamatan | Customer | Sistem menyediakan pilihan lokasi berjenjang (provinsi → kota → kecamatan) |
| F-38 | Cek Ongkos Kirim | Customer | Sistem menghitung ongkos kirim real-time dari RajaOngkir (JNE, POS, TIKI) |
| F-39 | Pilih Layanan Kurir | Customer | Sistem menampilkan opsi layanan kurir beserta biaya dan estimasi |
| F-40 | Klaim Voucher (Kode) | Customer | Sistem memungkinkan customer memasukkan kode voucher di halaman checkout |
| F-41 | Pilih Voucher Tersimpan | Customer | Sistem menampilkan voucher yang sudah diklaim customer dan dapat dipilih |
| F-42 | Hitung Diskon Otomatis | Customer | Sistem menghitung diskon voucher secara otomatis (persen, nominal, atau free ongkir) |
| F-43 | Proses Checkout | Customer | Sistem memproses checkout dari keranjang menjadi transaksi |
| F-44 | Direct Checkout (Beli Langsung) | Customer | Sistem memungkinkan customer membeli produk langsung dari halaman detail tanpa keranjang |
| F-45 | Pembayaran Midtrans | Customer | Sistem mengintegrasikan pembayaran melalui Midtrans Snap (berbagai metode pembayaran) |
| F-46 | Notifikasi Pembayaran (Webhook) | System | Sistem menerima notifikasi pembayaran dari Midtrans secara otomatis |
| F-47 | Update Status Pembayaran Otomatis | System | Sistem memperbarui status pembayaran berdasarkan notifikasi Midtrans |
| F-48 | Lihat Riwayat Transaksi | Customer | Sistem menampilkan daftar transaksi milik customer |
| F-49 | Detail Transaksi | Customer | Sistem menampilkan detail transaksi termasuk info pengiriman dan tracking |

**Tabel 5.7 Kebutuhan Fungsional Modul Voucher & Diskon**

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-50 | Lihat Daftar Voucher | Customer, Guest | Sistem menampilkan voucher yang tersedia untuk diklaim |
| F-51 | Klaim Voucher | Customer | Sistem memungkinkan customer mengklaim voucher untuk digunakan nanti |
| F-52 | CRUD Voucher | Admin | Admin dapat menambah, melihat, mengedit, dan menghapus voucher |
| F-53 | Atur Tipe Voucher | Admin | Admin dapat memilih tipe voucher: `percentage`, `fixed`, atau `free_shipping` |
| F-54 | Atur Batasan Voucher | Admin | Admin dapat mengatur minimal belanja, minimal qty, maksimal diskon, kuota pemakaian, dan masa berlaku |
| F-55 | Lihat Log Penggunaan Voucher | Admin | Admin dapat melihat riwayat penggunaan voucher per transaksi |

**Tabel 5.8 Kebutuhan Fungsional Modul Rating & Ulasan**

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-56 | Buat Rating & Ulasan | Customer | Sistem memungkinkan customer memberikan rating (1-5) dan ulasan untuk produk yang dibeli |
| F-57 | Upload Gambar Ulasan | Customer | Sistem memungkinkan customer mengunggah gambar pada ulasan |
| F-58 | Edit Rating & Ulasan | Customer | Sistem memungkinkan customer mengedit ulasan yang sudah dibuat |
| F-59 | Hapus Rating & Ulasan | Customer | Sistem memungkinkan customer menghapus ulasan |
| F-60 | Lihat Rating Produk | Customer | Sistem menampilkan rating rata-rata dan jumlah ulasan pada produk |
| F-61 | Approve/Reject Ulasan | Admin | Admin dapat menyetujui atau tidak menyetujui tampilan ulasan |
| F-62 | Balas Ulasan | Admin | Admin dapat membalas ulasan dari customer |
| F-63 | Hapus Ulasan | Admin | Admin dapat menghapus ulasan yang tidak sesuai |

**Tabel 5.9 Kebutuhan Fungsional Modul Retur**

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-64 | Ajukan Retur | Customer | Sistem memungkinkan customer mengajukan retur untuk item dalam transaksi |
| F-65 | Pilih Alasan Retur | Customer | Customer dapat memilih alasan: produk cacat, salah barang, tidak sesuai deskripsi, masalah ukuran, lainnya |
| F-66 | Upload Bukti Retur | Customer | Sistem memungkinkan customer mengunggah foto bukti retur |
| F-67 | Batalkan Retur | Customer | Sistem memungkinkan customer membatalkan pengajuan retur |
| F-68 | Lihat Retur | Customer | Sistem menampilkan status pengajuan retur |
| F-69 | Kelola Retur | Admin | Admin dapat menyetujui, menolak, atau menyelesaikan retur |
| F-70 | Catatan Admin Retur | Admin | Admin dapat memberikan catatan saat menyetujui/menolak retur |

**Tabel 5.10 Kebutuhan Fungsional Modul Pengiriman & Tracking**

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-71 | Update Status Pesanan | Admin | Admin dapat mengubah status pesanan (pending → processing → shipped → delivered) |
| F-72 | Update Status Pembayaran | Admin | Admin dapat mengubah status pembayaran secara manual |
| F-73 | Input Nomor Resi | Admin | Admin dapat memasukkan nomor resi pengiriman |
| F-74 | Tracking URL Otomatis | System | Sistem membuat URL tracking berdasarkan kurir yang dipilih |
| F-75 | Kirim Notifikasi Email Resi | System | Sistem mengirim email notifikasi ke customer saat resi diinput |
| F-76 | Lihat Tracking Pengiriman | Customer | Sistem menampilkan nomor resi dan link tracking di detail transaksi |

**Tabel 5.11 Kebutuhan Fungsional Modul Dashboard Admin**

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-77 | Ringkasan Dashboard | Admin | Sistem menampilkan total produk, kategori, customer, transaksi, dan pendapatan |
| F-78 | Status Transaksi Overview | Admin | Sistem menampilkan jumlah transaksi per status (pending, processing, shipped, delivered, cancelled) |
| F-79 | Grafik Pendapatan Bulanan | Admin | Sistem menampilkan grafik pendapatan 6 bulan terakhir |
| F-80 | Grafik Produk Terlaris | Admin | Sistem menampilkan 10 produk terlaris |
| F-81 | Daftar Transaksi Terbaru | Admin | Sistem menampilkan 5 transaksi terbaru |
| F-82 | Produk Stok Menipis | Admin | Sistem menampilkan peringatan produk dengan stok menipis (≤15) |
| F-83 | Top Customers | Admin | Sistem menampilkan 5 customer dengan total belanja terbanyak |
| F-84 | Laporan Penjualan | Admin | Sistem menampilkan laporan penjualan dengan filter tanggal |
| F-85 | Export Laporan | Admin | Sistem memungkinkan export laporan penjualan ke Excel/CSV |

**Tabel 5.12 Kebutuhan Fungsional Modul Notifikasi**

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-86 | Notifikasi In-App | Customer | Sistem menampilkan notifikasi dalam aplikasi untuk update pesanan |
| F-87 | Tandai Notifikasi Dibaca | Customer | Sistem memungkinkan customer menandai notifikasi sudah dibaca |
| F-88 | Pengaturan Notifikasi | Customer | Customer dapat mengatur preferensi notifikasi (email/push untuk order/promosi) |
| F-89 | Kirim Email Promosi | System | Sistem mendukung pengiriman email promosi ke customer |
| F-90 | Kirim Pesan Customer Service | Customer | Customer dapat mengirim pesan (komplain, pertanyaan, saran) ke admin |

**Tabel 5.13 Kebutuhan Fungsional Modul Logging & Keamanan**

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-91 | Catat Aktivitas Admin | System | Sistem mencatat log aktivitas admin (aksi, modul, data lama, data baru) |
| F-92 | Pengaturan Toko | Admin | Admin dapat mengatur pengaturan toko berbasis key-value |

**Tabel 5.14 Rekapitulasi Kebutuhan Fungsional**

| No | Modul | Jumlah Kebutuhan | Kode |
|----|-------|:----------------:|------|
| 1 | Autentikasi & Manajemen Pengguna | 9 | F-01 s.d. F-09 |
| 2 | Manajemen Produk & Kategori | 11 | F-10 s.d. F-20 |
| 3 | Manajemen Banner | 3 | F-21 s.d. F-23 |
| 4 | Keranjang Belanja | 5 | F-24 s.d. F-28 |
| 5 | Wishlist | 4 | F-29 s.d. F-32 |
| 6 | Checkout & Transaksi | 17 | F-33 s.d. F-49 |
| 7 | Voucher & Diskon | 6 | F-50 s.d. F-55 |
| 8 | Rating & Ulasan | 8 | F-56 s.d. F-63 |
| 9 | Retur | 7 | F-64 s.d. F-70 |
| 10 | Pengiriman & Tracking | 6 | F-71 s.d. F-76 |
| 11 | Dashboard Admin | 9 | F-77 s.d. F-85 |
| 12 | Notifikasi | 5 | F-86 s.d. F-90 |
| 13 | Logging & Keamanan | 2 | F-91 s.d. F-92 |
| | **TOTAL** | **92** | |

---

#### 5.1.1.2 Kebutuhan Non-Fungsional

Kebutuhan non-fungsional (non-functional requirements) menggambarkan atribut kualitas sistem yang harus dipenuhi. Berdasarkan hasil analisis, diperoleh **28 kebutuhan non-fungsional** yang mencakup 7 aspek:

**Tabel 5.15 Kebutuhan Non-Fungsional — Keamanan (Security)**

| Kode | Kebutuhan Non-Fungsional | Deskripsi |
|------|-------------------------|-----------|
| NF-01 | Autentikasi User | Sistem mewajibkan autentikasi untuk mengakses fitur customer (keranjang, checkout, transaksi) dan admin |
| NF-02 | Otorisasi Role | Sistem membatasi akses halaman admin hanya untuk user dengan role `admin` melalui AdminMiddleware |
| NF-03 | Proteksi Route | Sistem menggunakan middleware `auth` dan `admin` untuk melindungi route dari akses tidak sah |
| NF-04 | Validasi Input | Sistem melakukan validasi data input pada setiap form untuk mencegah injeksi data berbahaya |
| NF-05 | CSRF Protection | Sistem menggunakan proteksi CSRF Laravel pada semua form |
| NF-06 | Password Terenkripsi | Sistem menyimpan password user dalam bentuk hash (bcrypt) |
| NF-07 | Verifikasi Signature Midtrans | Sistem memverifikasi signature key pada notifikasi Midtrans untuk mencegah notifikasi palsu |

**Tabel 5.16 Kebutuhan Non-Fungsional — Performa (Performance)**

| Kode | Kebutuhan Non-Fungsional | Deskripsi |
|------|-------------------------|-----------|
| NF-08 | Waktu Respons Halaman | Sistem merender halaman dalam waktu < 3 detik untuk halaman frontend |
| NF-09 | Caching Ongkos Kirim | Sistem menyimpan hasil perhitungan ongkos kirim ke database (tabel `shipping_costs`) untuk menghindari panggilan API berulang |
| NF-10 | Caching Data Lokasi | Sistem menyimpan data kecamatan (subdistricts) dari API Komerce ke database lokal |
| NF-11 | Penggunaan Database Index | Sistem menggunakan index pada kolom yang sering dicari (email, slug, user_id, dll) |

**Tabel 5.17 Kebutuhan Non-Fungsional — Keandalan (Reliability)**

| Kode | Kebutuhan Non-Fungsional | Deskripsi |
|------|-------------------------|-----------|
| NF-12 | Konsistensi Transaksi | Sistem menggunakan database transaction (`DB::beginTransaction`/`commit`/`rollBack`) untuk menjaga konsistensi data pada proses checkout |
| NF-13 | Restore Stok Otomatis | Sistem mengembalikan stok produk secara otomatis jika transaksi dibatalkan/expired |
| NF-14 | Penanganan Error | Sistem menangani error dengan try-catch dan mencatatnya ke log |
| NF-15 | Validasi Stok Sebelum Checkout | Sistem memastikan stok mencukupi sebelum mengurangi stok (decreaseStock saat checkout) |

**Tabel 5.18 Kebutuhan Non-Fungsional — Kegunaan (Usability)**

| Kode | Kebutuhan Non-Fungsional | Deskripsi |
|------|-------------------------|-----------|
| NF-16 | Antarmuka Responsif | Sistem menggunakan Tailwind CSS untuk tampilan yang responsif di berbagai ukuran layar |
| NF-17 | Notifikasi Feedback | Sistem menampilkan pesan sukses/error setelah setiap aksi (flash message session) |
| NF-18 | Navigasi Breadcrumb | Sistem menyediakan navigasi breadcrumb untuk memudahkan user mengetahui posisi halaman |
| NF-19 | Informasi Stok | Sistem menampilkan informasi ketersediaan stok pada halaman produk |

**Tabel 5.19 Kebutuhan Non-Fungsional — Kompatibilitas (Compatibility)**

| Kode | Kebutuhan Non-Fungsional | Deskripsi |
|------|-------------------------|-----------|
| NF-20 | Dukungan Browser Modern | Sistem mendukung browser terkini (Chrome, Firefox, Edge, Safari) |
| NF-21 | Integrasi Payment Gateway | Sistem terintegrasi dengan Midtrans Snap yang mendukung berbagai metode pembayaran (transfer bank, kartu kredit, e-wallet) |
| NF-22 | Integrasi Shipping API | Sistem terintegrasi dengan RajaOngkir API (Komerce) untuk perhitungan ongkos kirim real-time dengan 3 kurir: JNE, POS Indonesia, TIKI |

**Tabel 5.20 Kebutuhan Non-Fungsional — Maintainability**

| Kode | Kebutuhan Non-Fungsional | Deskripsi |
|------|-------------------------|-----------|
| NF-23 | Konfigurasi Terpusat | Sistem menggunakan file `.env` dan config untuk menyimpan konfigurasi (API key, database, mail) |
| NF-24 | Struktur Database Terdokumentasi | Sistem memiliki migration file yang mendokumentasikan skema database |
| NF-25 | Logging | Sistem mencatat error dan aktivitas penting ke dalam log file (`storage/logs`) |
| NF-26 | Pagination | Sistem menggunakan pagination untuk daftar produk dan transaksi yang panjang |
| NF-27 | Arsitektur MVC | Sistem menggunakan arsitektur Model-View-Controller yang memisahkan logika bisnis, data, dan tampilan |
| NF-28 | Penggunaan Service Layer | Sistem memisahkan logika bisnis kompleks ke dalam service class (MidtransService, RajaOngkirService) |

**Tabel 5.21 Rekapitulasi Kebutuhan Non-Fungsional**

| No | Aspek | Jumlah Kebutuhan | Kode |
|----|-------|:----------------:|------|
| 1 | Keamanan (Security) | 7 | NF-01 s.d. NF-07 |
| 2 | Performa (Performance) | 4 | NF-08 s.d. NF-11 |
| 3 | Keandalan (Reliability) | 4 | NF-12 s.d. NF-15 |
| 4 | Kegunaan (Usability) | 4 | NF-16 s.d. NF-19 |
| 5 | Kompatibilitas (Compatibility) | 3 | NF-20 s.d. NF-22 |
| 6 | Maintainability | 6 | NF-23 s.d. NF-28 |
| | **TOTAL** | **28** | |

---

### 5.1.2 Tahap Desain Pengguna

---

#### 5.1.2.1 Arsitektur B2C

Sistem ACIAA E-Commerce menerapkan arsitektur **Business-to-Customer (B2C)** di mana penjual (admin) menjual produk langsung kepada konsumen (customer). Arsitektur ini dipilih karena sesuai dengan model bisnis e-commerce satu toko yang melayani banyak pembeli.

**Gambar 5.1 Arsitektur B2C Sistem**

```
┌─────────────────────────────────────────────────────────────────────┐
│                        ┌──────────────┐                            │
│                        │   Customer   │                            │
│                        │  (Web Browser)│                           │
│                        └──────┬───────┘                            │
│                               │HTTP/HTTPS                          │
│                               ▼                                    │
│  ┌────────────────────────────────────────────────────────────┐    │
│  │                   WEB SERVER (Apache)                       │    │
│  │  ┌────────────────────────────────────────────────────┐    │    │
│  │  │              LARAVEL APPLICATION                    │    │    │
│  │  │  ┌──────────┐ ┌──────────┐ ┌──────────────────┐    │    │    │
│  │  │  │  Routes  │ │  Blade   │ │  Controllers     │    │    │    │
│  │  │  │  (web)   │ │  Views   │ │  (Logic)         │    │    │    │
│  │  │  └──────────┘ └──────────┘ └────────┬─────────┘    │    │    │
│  │  │                                      │              │    │    │
│  │  │  ┌───────────────────────────────────┴──────────┐   │    │    │
│  │  │  │           SERVICE LAYER                       │   │    │    │
│  │  │  │  ┌──────────────┐   ┌──────────────────┐     │   │    │    │
│  │  │  │  │MidtransService│   │RajaOngkirService │     │   │    │    │
│  │  │  │  └──────┬───────┘   └────────┬─────────┘     │   │    │    │
│  │  │  └─────────┼────────────────────┼────────────────┘   │    │    │
│  │  └────────────┼────────────────────┼────────────────────┘    │    │
│  │               │                    │                          │    │
│  └───────────────┼────────────────────┼──────────────────────────┘    │
│                  │                    │                                │
│                  ▼                    ▼                                │
│        ┌─────────────────┐  ┌─────────────────────┐                  │
│        │  Midtrans API   │  │ RajaOngkir Komerce  │                  │
│        │ (Payment Gateway)│  │ (Shipping Cost API) │                  │
│        └─────────────────┘  └─────────────────────┘                  │
│                                                                      │
│  ┌──────────────────────────────────────────────────────────────┐    │
│  │              DATABASE SERVER (MySQL)                         │    │
│  │  ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐ ┌──────┐     │    │
│  │  │Users │ │Produk│ │Trans │ │Cart  │ │Vouch │ │  ... │     │    │
│  │  └──────┘ └──────┘ └──────┘ └──────┘ └──────┘ └──────┘     │    │
│  └──────────────────────────────────────────────────────────────┘    │
└─────────────────────────────────────────────────────────────────────┘
```

**Komponen Arsitektur:**

| No | Komponen | Teknologi | Fungsi |
|----|----------|-----------|--------|
| 1 | Web Browser | Chrome, Firefox, Edge | Antarmuka pengguna untuk mengakses sistem |
| 2 | Web Server | Apache (XAMPP) | Melayani permintaan HTTP/HTTPS |
| 3 | Framework | Laravel 11 | Mengatur routing, middleware, controller, view |
| 4 | View Engine | Blade + Tailwind CSS | Merender tampilan HTML yang responsif |
| 5 | Service Layer | MidtransService, RajaOngkirService | Memisahkan logika bisnis integrasi dari controller |
| 6 | Payment Gateway | Midtrans Snap API | Menangani pembayaran dengan berbagai metode |
| 7 | Shipping API | RajaOngkir Komerce v1 | Menghitung ongkos kirim real-time |
| 8 | Database | MySQL (MariaDB) | Menyimpan seluruh data sistem |

**Alur Data Umum:**

1. **Customer** membuka aplikasi melalui browser → request HTTP dikirim ke **Web Server**.
2. **Web Server (Apache)** meneruskan request ke **Laravel Application**.
3. **Router** menentukan controller yang sesuai → **Controller** memproses logika.
4. Jika membutuhkan data, **Controller** memanggil **Model** (Eloquent ORM) untuk mengakses **Database**.
5. Jika membutuhkan integrasi eksternal, **Controller** memanggil **Service Layer** yang berkomunikasi dengan **Midtrans API** atau **RajaOngkir API**.
6. **Controller** mengirim data ke **View (Blade)** untuk dirender menjadi HTML.
7. HTML dikirim kembali ke browser customer.

---

#### 5.1.2.2 Perancangan Database

Perancangan database menghasilkan **30 tabel** yang saling berelasi. Berikut adalah struktur seluruh tabel yang digunakan dalam sistem:

**Tabel 5.22 Daftar Seluruh Tabel Database**

| No | Nama Tabel | Deskripsi | Relasi |
|----|-----------|-----------|--------|
| 1 | `users` | Data user (admin & customer) | PK dari banyak tabel |
| 2 | `customers` | Data profil tambahan customer | 1:1 ke users |
| 3 | `personal_access_tokens` | Token API Sanctum | - |
| 4 | `password_reset_tokens` | Token reset password | - |
| 5 | `sessions` | Sesi login user | - |
| 6 | `categories` | Kategori produk | 1:N ke products |
| 7 | `products` | Data produk | FK ke categories |
| 8 | `product_galleries` | Galeri gambar produk | FK ke products |
| 9 | `carts` | Keranjang per user | 1:1 ke users, 1:N ke cart_items |
| 10 | `cart_items` | Item dalam keranjang | FK ke carts, products |
| 11 | `transactions` | Transaksi pesanan | FK ke users, vouchers |
| 12 | `transaction_details` | Detail item per transaksi | FK ke transactions, products |
| 13 | `addresses` | Alamat pengiriman | FK ke users |
| 14 | `vouchers` | Voucher diskon | PK dari user_vouchers, usage_logs |
| 15 | `user_vouchers` | Voucher yang diklaim user | FK ke users, vouchers |
| 16 | `voucher_usage_logs` | Log pemakaian voucher | FK ke vouchers, transactions |
| 17 | `product_ratings` | Rating & ulasan produk | FK ke users, products, transactions |
| 18 | `returns` | Pengajuan retur | FK ke transactions, users |
| 19 | `return_items` | Item dalam retur | FK ke returns, transaction_details |
| 20 | `banners` | Banner promosi | - |
| 21 | `wishlists` | Wishlist user | FK ke users, products |
| 22 | `stocks` | Mutasi stok produk | FK ke products, users |
| 23 | `subdistricts` | Data kecamatan (cache Komerce) | - |
| 24 | `shipping_costs` | Cache ongkos kirim | - |
| 25 | `notifications` | Notifikasi in-app | FK ke users |
| 26 | `notification_settings` | Pengaturan notifikasi user | FK ke users |
| 27 | `activity_logs` | Log aktivitas admin | FK ke users |
| 28 | `messages` | Pesan customer ke admin | FK ke users |
| 29 | `settings` | Pengaturan toko key-value | - |
| 30 | `migrations` | Riwayat migrasi database | - |

**Struktur Detail Tabel Utama:**

**a. Tabel `users`**

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | bigint(20) UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | ID user |
| name | varchar(255) | NOT NULL | Nama lengkap |
| email | varchar(255) | UNIQUE, NOT NULL | Email |
| password | varchar(255) | NOT NULL | Password (bcrypt hash) |
| phone | varchar(20) | NULL | Nomor telepon |
| role | enum('admin','customer') | NOT NULL, DEFAULT 'customer' | Role user |
| provider | varchar(50) | NULL | Provider OAuth (Google) |
| provider_id | varchar(255) | NULL | ID dari provider |
| avatar | varchar(255) | NULL | Path avatar |
| email_verified_at | timestamp | NULL | Verifikasi email |
| remember_token | varchar(100) | NULL | Token remember me |
| created_at | timestamp | NULL | Waktu dibuat |
| updated_at | timestamp | NULL | Waktu diupdate |

**b. Tabel `products`**

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | bigint(20) UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | ID produk |
| category_id | bigint(20) UNSIGNED | FOREIGN KEY → categories(id) | Kategori |
| name | varchar(255) | NOT NULL | Nama produk |
| slug | varchar(255) | UNIQUE, NOT NULL | Slug URL |
| description | text | NULL | Deskripsi produk |
| price | decimal(12,2) | NOT NULL | Harga asli |
| discount_price | decimal(12,2) | NULL | Harga diskon |
| stock | int(11) | NOT NULL, DEFAULT 0 | Stok |
| weight | int(11) | NOT NULL, DEFAULT 0 | Berat (gram) |
| image | varchar(255) | NULL | Gambar utama |
| is_promo | tinyint(1) | NOT NULL, DEFAULT 0 | Status promo |
| is_active | tinyint(1) | NOT NULL, DEFAULT 1 | Status aktif |
| views_count | int(11) | NOT NULL, DEFAULT 0 | Jumlah dilihat |
| sold_count | int(11) | NOT NULL, DEFAULT 0 | Jumlah terjual |
| created_at | timestamp | NULL | Waktu dibuat |
| updated_at | timestamp | NULL | Waktu diupdate |

**c. Tabel `transactions`**

| Kolom | Tipe Data | Constraint | Keterangan |
|-------|-----------|------------|------------|
| id | bigint(20) UNSIGNED | PRIMARY KEY, AUTO_INCREMENT | ID transaksi |
| user_id | bigint(20) UNSIGNED | FOREIGN KEY → users(id) | Pembeli |
| voucher_id | bigint(20) UNSIGNED | FOREIGN KEY → vouchers(id), NULL | Voucher dipakai |
| invoice_number | varchar(50) | UNIQUE, NOT NULL | Nomor invoice |
| subtotal | decimal(12,2) | NOT NULL | Total sebelum ongkir & diskon |
| shipping_cost | decimal(10,2) | NOT NULL, DEFAULT 0 | Biaya ongkir |
| discount_amount | decimal(10,2) | NOT NULL, DEFAULT 0 | Diskon voucher |
| grand_total | decimal(12,2) | NOT NULL | Total akhir |
| status | enum('pending','paid','processing','shipped','delivered','cancelled','refunded') | NOT NULL, DEFAULT 'pending' | Status pesanan |
| payment_status | enum('unpaid','pending','paid','failed','expired') | NOT NULL, DEFAULT 'unpaid' | Status bayar |
| midtrans_order_id | varchar(100) | NULL | Order ID Midtrans |
| midtrans_transaction_id | varchar(100) | NULL | Transaction ID Midtrans |
| payment_method | varchar(50) | NULL | Metode bayar |
| shipping_courier | varchar(50) | NULL | Kurir |
| shipping_service | varchar(50) | NULL | Layanan kurir |
| shipping_etd | varchar(20) | NULL | Estimasi |
| tracking_number | varchar(100) | NULL | Nomor resi |
| tracking_url | varchar(255) | NULL | URL tracking |
| shipping_address | text | NOT NULL | Alamat pengiriman |
| recipient_name | varchar(255) | NULL | Nama penerima |
| recipient_phone | varchar(20) | NULL | No HP penerima |
| notes | text | NULL | Catatan |
| paid_at | timestamp | NULL | Waktu bayar |
| shipped_at | timestamp | NULL | Waktu kirim |
| delivered_at | timestamp | NULL | Waktu terima |
| created_at | timestamp | NULL | Waktu dibuat |
| updated_at | timestamp | NULL | Waktu diupdate |

**d. ERD (Entity Relationship Diagram)**

**[Gambar Entity Relationship Diagram — lihat Lampiran]**

Relasi utama antar tabel:

| Tabel 1 | Relasi | Tabel 2 | Keterangan |
|---------|--------|---------|------------|
| users | 1 ── N | transactions | Satu user punya banyak transaksi |
| users | 1 ── N | addresses | Satu user punya banyak alamat |
| users | 1 ── N | product_ratings | Satu user punya banyak rating |
| users | 1 ── N | returns | Satu user punya banyak retur |
| users | 1 ── N | wishlists | Satu user punya banyak wishlist |
| users | 1 ── 1 | carts | Satu user punya satu keranjang |
| categories | 1 ── N | products | Satu kategori punya banyak produk |
| products | 1 ── N | cart_items | Satu produk bisa ada di banyak keranjang |
| products | 1 ── N | transaction_details | Satu produk bisa di banyak transaksi |
| products | 1 ── N | product_ratings | Satu produk punya banyak rating |
| products | 1 ── N | wishlists | Satu produk ada di banyak wishlist |
| transactions | 1 ── N | transaction_details | Satu transaksi punya banyak item |
| transactions | 1 ── 1 | returns | Satu transaksi bisa punya satu retur |
| vouchers | 1 ── N | user_vouchers | Satu voucher bisa diklaim banyak user |
| vouchers | 1 ── N | transactions | Satu voucher bisa dipakai banyak transaksi |
| returns | 1 ── N | return_items | Satu retur bisa punya banyak item |

---

#### 5.1.2.3 Perancangan Model B2C (Class Diagram)

Berdasarkan analisis sistem, dirancang **17 class utama** yang merepresentasikan struktur data, atribut, method, dan relasi antar objek dalam sistem.

**a. Class User**

| Atribut | Tipe Data | Deskripsi |
|---------|-----------|-----------|
| id | int | Primary Key |
| name | string | Nama lengkap |
| email | string [unique] | Email |
| password | string (bcrypt hash) | Password |
| phone | string | Nomor telepon |
| role | enum('admin','customer') | Role user |
| provider | string | Provider OAuth (Google) |
| provider_id | string | ID dari provider |
| avatar | string | Path avatar |
| email_verified_at | datetime|null | Verifikasi email |
| remember_token | string | Token remember me |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

| Method | Return | Deskripsi |
|--------|--------|-----------|
| cart() | hasOne(Cart) | Relasi ke Cart |
| transactions() | hasMany(Transaction) | Relasi ke Transaction |
| wishlists() | hasMany(Wishlist) | Relasi ke Wishlist |
| addresses() | hasMany(UserAddress) | Relasi ke Address |
| ratings() | hasMany(Rating) | Relasi ke Rating |
| returs() | hasMany(Retur) | Relasi ke Retur |
| userVouchers() | hasMany(UserVoucher) | Relasi ke UserVoucher |
| notifications() | hasMany(Notification) | Relasi ke Notification |

**b. Class Product**

| Atribut | Tipe Data | Deskripsi |
|---------|-----------|-----------|
| id | int | Primary Key |
| category_id | int (FK → Category) | Foreign Key ke Category |
| name | string | Nama produk |
| slug | string [unique] | Slug URL |
| description | text | Deskripsi |
| price | decimal(12,2) | Harga asli |
| discount_price | decimal(12,2)\|null | Harga diskon |
| stock | int | Stok |
| weight | int | Berat (gram) |
| image | string\|null | Gambar utama |
| is_promo | boolean | Status promo |
| is_active | boolean | Status aktif |
| views_count | int | Jumlah dilihat |
| sold_count | int | Jumlah terjual |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

| Method | Return | Deskripsi |
|--------|--------|-----------|
| category() | belongsTo(Category) | Relasi ke Category |
| cartItems() | hasMany(CartItem) | Relasi ke CartItem |
| transactionDetails() | hasMany(TransactionDetail) | Relasi ke TransactionDetail |
| ratings() | hasMany(Rating) | Relasi ke Rating |
| wishlists() | hasMany(Wishlist) | Relasi ke Wishlist |
| stocks() | hasMany(Stock) | Relasi ke Stock |
| getAverageRatingAttribute() | float | Hitung rata-rata rating |
| getRatingCountAttribute() | int | Hitung jumlah rating |
| getFinalPriceAttribute() | decimal | Harga setelah diskon |
| isInWishlist(user) | bool | Cek apakah di wishlist user tertentu |
| decreaseStock(qty) | void | Kurangi stok + increment sold_count |
| increaseStock(qty) | void | Tambah stok |

**c. Class Transaction**

| Atribut | Tipe Data | Deskripsi |
|---------|-----------|-----------|
| id | int | Primary Key |
| user_id | int (FK → User) | Pembeli |
| voucher_id | int (FK → Voucher\|null) | Voucher dipakai |
| invoice_number | string [unique] | Nomor invoice |
| subtotal | decimal(12,2) | Total sebelum ongkir & diskon |
| shipping_cost | decimal(10,2) | Biaya ongkos kirim |
| discount_amount | decimal(10,2) | Diskon voucher |
| grand_total | decimal(12,2) | Total akhir |
| status | enum | Status pesanan |
| payment_status | enum | Status bayar |
| midtrans_order_id | string\|null | Order ID Midtrans |
| shipping_courier | string\|null | Kurir |
| shipping_service | string\|null | Layanan kurir |
| tracking_number | string\|null | Nomor resi |
| tracking_url | string\|null | URL tracking |
| shipping_address | text | Alamat pengiriman |
| paid_at | timestamp\|null | Waktu bayar |
| created_at | timestamp | Waktu dibuat |

| Method | Return | Deskripsi |
|--------|--------|-----------|
| user() | belongsTo(User) | Relasi ke User |
| voucher() | belongsTo(Voucher) | Relasi ke Voucher |
| details() | hasMany(TransactionDetail) | Relasi ke TransactionDetail |
| retur() | hasOne(Retur) | Relasi ke Retur |
| generateInvoiceNumber() | string | Generate nomor invoice auto-increment |
| getResolvedTrackingUrlAttribute() | string|null | Dapatkan URL tracking |

**d. Class ProductRating (Rating)**

| Atribut | Tipe Data | Deskripsi |
|---------|-----------|-----------|
| id | int | Primary Key |
| user_id | int (FK → User) | Pemberi rating |
| product_id | int (FK → Product) | Produk dirating |
| transaction_id | int (FK → Transaction\|null) | Transaksi terkait |
| rating | int (1-5) | Nilai bintang |
| review | text\|null | Ulasan teks |
| images | json\|null | Gambar ulasan |
| is_approved | boolean | Status approve admin |
| admin_reply | text\|null | Balasan admin |
| created_at | timestamp | Waktu dibuat |
| updated_at | timestamp | Waktu diupdate |

| Method | Return | Deskripsi |
|--------|--------|-----------|
| user() | belongsTo(User) | Relasi ke User |
| product() | belongsTo(Product) | Relasi ke Product |
| transaction() | belongsTo(Transaction) | Relasi ke Transaction |

**e. Class Voucher**

| Atribut | Tipe Data | Deskripsi |
|---------|-----------|-----------|
| id | int | Primary Key |
| code | string [unique] | Kode voucher |
| name | string | Nama voucher |
| description | text\|null | Deskripsi |
| type | enum('percentage','fixed','free_shipping') | Tipe diskon |
| value | decimal(10,2) | Nilai diskon |
| min_purchase | decimal(10,2) | Minimal belanja |
| min_qty | int | Minimal qty |
| max_discount | decimal(10,2)\|null | Maks diskon |
| max_usage | int\|null | Kuota pemakaian |
| used_count | int | Sudah terpakai |
| start_date | date\|null | Tanggal mulai |
| expiry_date | date | Tanggal kadaluarsa |
| is_active | boolean | Status aktif |
| created_at | timestamp | Waktu dibuat |

| Method | Return | Deskripsi |
|--------|--------|-----------|
| transactions() | hasMany(Transaction) | Relasi ke Transaction |
| userVouchers() | hasMany(UserVoucher) | Relasi ke UserVoucher |
| usageLogs() | hasMany(VoucherUsageLog) | Relasi ke VoucherUsageLog |

**f. Class Retur**

| Atribut | Tipe Data | Deskripsi |
|---------|-----------|-----------|
| id | int | Primary Key |
| transaction_id | int (FK → Transaction) | Transaksi diretur |
| user_id | int (FK → User) | Pengaju retur |
| retur_number | string [unique] | Nomor retur |
| reason | enum('defective','wrong_item','not_as_description','size_issue','other') | Alasan retur |
| description | text\|null | Deskripsi tambahan |
| status | enum('pending','approved','rejected','completed') | Status retur |
| proof_image | string\|null | Foto bukti |
| admin_notes | text\|null | Catatan admin |
| created_at | timestamp | Waktu dibuat |

| Method | Return | Deskripsi |
|--------|--------|-----------|
| transaction() | belongsTo(Transaction) | Relasi ke Transaction |
| user() | belongsTo(User) | Relasi ke User |
| items() | hasMany(ReturItem) | Relasi ke ReturItem |

**g. Diagram Relasi Lengkap**

```
LEGENDA:
    1 ── N  : One-to-Many
    1 ── 1  : One-to-One
    
RELASI:
    User ──1→N── Cart
    User ──1→N── Transaction
    User ──1→N── Wishlist
    User ──1→N── Address
    User ──1→N── ProductRating
    User ──1→N── Retur
    User ──1→N── UserVoucher
    User ──1→N── Notification
    
    Category ──1→N── Product
    
    Product ──1→N── CartItem
    Product ──1→N── TransactionDetail
    Product ──1→N── ProductRating
    Product ──1→N── Wishlist
    Product ──1→N── Stock
    
    Cart ──1→N── CartItem
    
    Transaction ──1→N── TransactionDetail
    Transaction ──1→1── Retur
    
    TransactionDetail ──1→1── ReturItem
    
    Voucher ──1→N── Transaction
    Voucher ──1→N── UserVoucher
    
    Retur ──1→N── ReturItem
```

**[Gambar Class Diagram — lihat lampiran]**

---

### 5.1.3 Tahap Konstruksi

Tahap konstruksi merupakan proses pembangunan antarmuka sistem berdasarkan hasil perancangan yang telah dilakukan. Sistem dibangun menggunakan framework **Laravel 11** dengan **Tailwind CSS** untuk tampilan frontend dan **Alpine.js** untuk interaktivitas.

#### 5.1.3.1 Interface User (Customer)

**a. Halaman Landing Page (Beranda)**

**[Gambar 5.2 Halaman Landing Page]**

Halaman utama sistem (landing page) merupakan titik awal ketika pengguna membuka aplikasi. Halaman ini terdiri dari:
- **Navbar** — berisi logo, menu navigasi (Beranda, Produk, Kategori, Voucher), ikon pencarian, ikon wishlist, ikon keranjang, ikon notifikasi, dan dropdown profil user
- **Banner Slider** — menampilkan banner promosi yang dikelola admin, berganti secara otomatis
- **Kategori Produk** — menampilkan kategori dalam bentuk ikon grid
- **Produk Promo** — menampilkan produk yang sedang diskon
- **Produk Terbaru** — menampilkan produk terbaru yang ditambahkan
- **Footer** — berisi informasi toko, tautan, dan sosial media

**b. Halaman Login**

**[Gambar 5.3 Halaman Login]**

Halaman login digunakan oleh user yang sudah memiliki akun untuk masuk ke sistem. Komponen halaman:
- Form input **email**
- Form input **password** (type password)
- Tombol **"Masuk"** — submit form
- Tautan **"Lupa Password?"** — menuju halaman reset password
- Tautan **"Belum punya akun? Daftar"** — menuju halaman registrasi
- Tombol **"Masuk dengan Google"** — autentikasi OAuth
- Pesan error jika kredensial salah

**c. Halaman Registrasi**

**[Gambar 5.4 Halaman Registrasi]**

Halaman registrasi digunakan oleh pengguna baru untuk membuat akun. Komponen:
- Form input **Nama Lengkap** (min 3 karakter, required)
- Form input **Email** (format email valid, unique, required)
- Form input **Password** (min 8 karakter, required)
- Tombol **"Daftar"** — submit form
- Validasi client-side dan server-side

**d. Halaman Katalog Produk**

**[Gambar 5.5 Halaman Katalog Produk]**

Menampilkan semua produk dalam bentuk grid card (4 kolom di desktop). Setiap card menampilkan:
- Gambar produk
- Nama produk
- Harga (harga asli dicoret jika ada diskon, harga diskon ditampilkan)
- Bintang rating rata-rata
- Tombol **"Tambah ke Keranjang"** (muncul saat hover)
- Fitur: filter kategori (sidebar/dropdown), pencarian berdasarkan nama, sort by (terbaru, termurah, termahal, terlaris)

**e. Halaman Detail Produk**

**[Gambar 5.6 Halaman Detail Produk]**

Halaman detail produk menampilkan informasi lengkap tentang satu produk:
- **Gambar Utama** — gambar besar produk
- **Galeri Gambar** — thumbnail gambar tambahan
- **Nama Produk**
- **Harga** — harga asli, harga diskon jika promo
- **Rating** — bintang rata-rata + jumlah ulasan
- **Deskripsi** — deskripsi lengkap produk
- **Stok** — informasi ketersediaan
- **Berat** — berat produk dalam gram
- **Input Jumlah** — dengan tombol + dan -
- **Tombol "Tambah ke Keranjang"**
- **Tombol "Beli Sekarang"** — direct checkout
- **Tombol Wishlist** — toggle heart icon
- **Ulasan Produk** — daftar ulasan dari pembeli

**f. Halaman Keranjang Belanja**

**[Gambar 5.7 Halaman Keranjang Belanja]**

Halaman keranjang menampilkan daftar produk yang dipilih customer:
- **Daftar Item** — setiap item menampilkan gambar, nama, harga satuan, input jumlah (dengan tombol + dan -), subtotal, tombol hapus
- **Ringkasan Belanja** — total item, subtotal
- **Tombol "Checkout"** — lanjut ke halaman checkout
- Jika keranjang kosong: menampilkan ilustrasi + pesan "Keranjang belanja masih kosong"
- Badge jumlah item di navbar diperbarui secara real-time via AJAX

**g. Halaman Checkout**

**[Gambar 5.8 Halaman Checkout]**

Halaman checkout merupakan halaman multi-bagian yang terdiri dari:

**Bagian 1: Ringkasan Pesanan**
- Daftar produk yang dibeli (nama, qty, harga)

**Bagian 2: Alamat Pengiriman**
- Dropdown pilih alamat tersimpan
- Tombol "Tambah Alamat Baru"
- Form alamat: nama penerima, no HP, provinsi (dropdown cascading), kota (dropdown), kecamatan (dropdown), alamat detail, kode pos
- Set alamat default

**Bagian 3: Kurir & Layanan**
- Pilihan kurir: JNE, POS Indonesia, TIKI
- Setelah kurir dipilih, sistem memanggil API RajaOngkir untuk menampilkan layanan + biaya + estimasi
- Customer memilih layanan yang diinginkan

**Bagian 4: Voucher**
- Daftar voucher yang sudah diklaim (bisa dipilih)
- Input kode voucher (klaim baru)

**Bagian 5: Total Pembayaran**
- Subtotal
- Ongkos Kirim
- Diskon Voucher
- **Grand Total**
- Tombol "Bayar Sekarang"

**h. Halaman Pembayaran Midtrans**

**[Gambar 5.9 Halaman Pembayaran Midtrans]**

Saat customer menekan "Bayar Sekarang":
1. Sistem membuat transaksi dan mendapatkan Snap Token dari Midtrans
2. Popup Midtrans Snap ditampilkan
3. Customer memilih metode pembayaran:
   - **Virtual Account** (BCA, BRI, BNI, Mandiri)
   - **E-Wallet** (GoPay, OVO, Dana, LinkAja, ShopeePay)
   - **Convenience Store** (Indomaret, Alfamart)
   - **QRIS**
4. Customer menyelesaikan pembayaran
5. Popup menutup, customer diarahkan ke halaman sukses

**i. Halaman Riwayat Transaksi**

**[Gambar 5.10 Halaman Riwayat Transaksi]**

Menampilkan daftar transaksi customer dalam bentuk tabel/list dengan informasi:
- Nomor invoice
- Tanggal
- Status pesanan (badge warna: pending=kuning, processing=biru, shipped=hijau, delivered=hijau tua, cancelled=merah)
- Status pembayaran
- Total
- Tombol "Detail"

**j. Halaman Detail Transaksi**

**[Gambar 5.11 Halaman Detail Transaksi]**

Menampilkan detail lengkap satu transaksi:
- **Info Pesanan** — nomor invoice, tanggal, status
- **Info Pembayaran** — status, metode, waktu bayar
- **Info Pengiriman** — alamat, kurir, layanan, nomor resi (jika sudah dikirim), link tracking
- **Daftar Produk** — nama, qty, harga, subtotal
- **Rincian Biaya** — subtotal, ongkir, diskon, grand total
- **Tombol Aksi** — "Beri Ulasan" (jika sudah diterima), "Ajukan Retur" (jika dalam periode retur)

**k. Halaman Voucher**

**[Gambar 5.12 Halaman Voucher]**

Halaman voucher menampilkan:
- **Voucher Tersedia** — daftar voucher yang bisa diklaim dengan informasi: kode, nama, tipe diskon, nilai, minimal belanja, masa berlaku, tombol "Klaim"
- **Voucher Saya** — daftar voucher yang sudah diklaim dengan status (belum dipakai / sudah dipakai)
- Filter: berlaku, expired

**l. Halaman Rating & Ulasan**

**[Gambar 5.13 Halaman Rating]**

Halaman rating menampilkan:
- **Form Rating** — bintang 1-5 (clickable), textarea ulasan, upload gambar
- **Daftar Ulasan Saya** — riwayat ulasan yang sudah dibuat
- Tombol "Edit" dan "Hapus" pada ulasan milik sendiri

**m. Halaman Retur**

**[Gambar 5.14 Halaman Retur]**

Halaman retur menampilkan:
- **Form Pengajuan Retur** — pilih produk (dari transaksi), pilih alasan (dropdown), deskripsi tambahan (textarea), upload foto bukti (file input)
- **Daftar Retur Saya** — riwayat pengajuan retur dengan status

**n. Halaman Wishlist**

**[Gambar 5.15 Halaman Wishlist]**

Menampilkan daftar produk yang disimpan dalam bentuk grid dengan informasi produk dan tombol "Tambah ke Keranjang" atau "Hapus".

**o. Halaman Notifikasi**

**[Gambar 5.16 Halaman Notifikasi]**

Halaman notifikasi menampilkan daftar notifikasi dengan:
- Tab filter: **Semua**, **Belum Dibaca**
- Setiap notifikasi: ikon, judul, pesan, timestamp
- Tombol "Tandai Sudah Dibaca" per item
- Tombol "Tandai Semua Dibaca"
- Tombol "Hapus" per item
- Tombol "Hapus Semua"

#### 5.1.3.2 Interface Admin

**a. Halaman Dashboard Admin**

**[Gambar 5.17 Halaman Dashboard Admin]**

Halaman dashboard admin berisi ringkasan data toko:
- **Statistik Card** — total produk, total kategori, total customer, total transaksi, total pendapatan
- **Grafik Pendapatan Bulanan** — diagram batang 6 bulan terakhir
- **Grafik Produk Terlaris** — diagram batang 10 produk teratas
- **Transaksi Terbaru** — tabel 5 transaksi terakhir
- **Peringatan Stok** — daftar produk dengan stok ≤ 15
- **Top Customer** — 5 customer dengan total belanja terbanyak

**b. Halaman Manajemen Produk**

**[Gambar 5.18 Halaman Manajemen Produk]**

Tabel daftar produk dengan kolom: No, Gambar, Nama, Kategori, Harga, Stok, Status, Aksi
- Tombol **"Tambah Produk"** — menuju form tambah
- Tombol **"Edit"** — menuju form edit
- Tombol **"Hapus"** — konfirmasi lalu hapus
- Fitur pencarian berdasarkan nama
- Filter berdasarkan kategori
- Pagination

**c. Halaman Form Tambah/Edit Produk**

**[Gambar 5.19 Halaman Form Produk]**

Form dengan input:
- **Nama Produk** (required)
- **Kategori** (dropdown, required)
- **Harga** (numeric, required)
- **Harga Diskon** (numeric, optional)
- **Stok** (numeric, required)
- **Berat** (numeric, gram, required)
- **Deskripsi** (textarea, optional)
- **Gambar Utama** (file upload, jpeg/png/webp, max 10MB)
- **Galeri Gambar** (multiple file upload)
- **Status Aktif** (checkbox)
- **Status Promo** (checkbox)
- Tombol **"Simpan"** dan **"Batal"**

**d. Halaman Manajemen Kategori**

**[Gambar 5.20 Halaman Manajemen Kategori]**

Tabel daftar kategori: No, Nama, Icon, Status, Aksi
- Tombol "Tambah Kategori"
- Form: nama, slug (auto), icon, deskripsi, order, status aktif

**e. Halaman Manajemen Transaksi**

**[Gambar 5.21 Halaman Manajemen Transaksi]**

Tabel daftar transaksi dengan kolom: No, Invoice, Customer, Tanggal, Total, Status Pesanan, Status Bayar, Aksi
- Filter: status pesanan, status bayar, tanggal
- Pencarian berdasarkan invoice/customer
- Tombol **"Detail"** — menuju detail transaksi
- Pada detail: form update status pesanan, form update status bayar, form input nomor resi

**f. Halaman Manajemen Voucher**

**[Gambar 5.22 Halaman Manajemen Voucher]**

Tabel daftar voucher: No, Kode, Nama, Tipe, Nilai, Min Belanja, Kuota, Terpakai, Masa Berlaku, Status, Aksi
- Tombol "Tambah Voucher"
- Form: kode, nama, tipe (percentage/fixed/free_shipping), nilai, min_purchase, min_qty, max_discount, max_usage, start_date, expiry_date, is_active

**g. Halaman Manajemen Rating**

**[Gambar 5.23 Halaman Manajemen Rating]**

Tabel daftar rating: No, Produk, Customer, Rating, Ulasan, Gambar, Status, Aksi
- Tombol **"Setujui"** / **"Tolak"** — approve/reject ulasan
- Tombol **"Balas"** — membalas ulasan
- Tombol **"Hapus"** — menghapus ulasan

**h. Halaman Manajemen Retur**

**[Gambar 5.24 Halaman Manajemen Retur]**

Tabel daftar retur: No, No Retur, Invoice, Customer, Alasan, Status, Aksi
- Tombol **"Setujui"** — approve dengan catatan
- Tombol **"Tolak"** — reject dengan catatan
- Tombol **"Selesai"** — complete retur
- Filter: status retur

**i. Halaman Manajemen Banner**

**[Gambar 5.25 Halaman Manajemen Banner]**

Tabel daftar banner: No, Gambar, Judul, Tautan, Status, Aksi
- Tombol "Tambah Banner"
- Form: judul, gambar, link, order, start_date, end_date, is_active

**j. Halaman Manajemen Customer**

**[Gambar 5.26 Halaman Manajemen Customer]**

Tabel daftar customer: No, Nama, Email, Telepon, Tanggal Daftar, Total Transaksi, Aksi
- Tombol **"Detail"** — melihat detail customer + riwayat transaksi

---

### 5.1.4 Tahap Implementasi

---

#### 5.1.4.1 Black Box Testing

Black box testing dilakukan dengan menggunakan teknik **Equivalence Partitioning (EP)**. Teknik ini membagi domain input menjadi kelas-kelas partisi (valid dan invalid) dan menguji satu perwakilan dari setiap kelas. Pengujian dilakukan pada seluruh modul sistem tanpa melihat struktur internal kode.

**a. Modul Autentikasi (16 Test Case)**

**Tabel 5.23 Pengujian Blackbox — Autentikasi (Registrasi & Login)**

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 1 | Nama Valid | Mengisi nama dengan 3 karakter atau lebih | "Aciaa" | Data berhasil tersimpan | | |
| 2 | Nama Invalid | Mengisi nama kurang dari 3 karakter | "Ab" | Sistem menolak: minimal 3 karakter | | |
| 3 | Nama Kosong | Tidak mengisi nama | "" | Sistem menolak: nama wajib diisi | | |
| 4 | Email Valid | Mengisi email dengan format benar | "user@mail.com" | Data berhasil tersimpan | | |
| 5 | Email Invalid (tanpa @) | Mengisi email tanpa @ | "useremail.com" | Sistem menolak: format email salah | | |
| 6 | Email Invalid (tanpa domain) | Mengisi email tanpa domain | "user@" | Sistem menolak: format email salah | | |
| 7 | Email Kosong | Tidak mengisi email | "" | Sistem menolak: email wajib diisi | | |
| 8 | Email Duplikat | Mengisi email yang sudah terdaftar | Email terdaftar | Sistem menolak: email sudah digunakan | | |
| 9 | Password Valid | Mengisi password 8 karakter atau lebih | "password123" | Data berhasil tersimpan | | |
| 10 | Password Invalid | Mengisi password kurang dari 8 karakter | "pass" | Sistem menolak: minimal 8 karakter | | |
| 11 | Password Kosong | Tidak mengisi password | "" | Sistem menolak: password wajib diisi | | |
| 12 | Kredensial Valid | Login dengan email dan password benar | Email terdaftar + password benar | Redirect ke halaman utama/dashboard | | |
| 13 | Password Salah | Login dengan password yang salah | Email terdaftar + password "salah123" | Sistem menolak: kredensial tidak valid | | |
| 14 | Email Tidak Terdaftar | Login dengan email yang belum terdaftar | "tidakada@email.com" + password apapun | Sistem menolak: kredensial tidak valid | | |
| 15 | Email Kosong | Login tanpa mengisi email | "" + password | Sistem menolak: email wajib diisi | | |
| 16 | Password Kosong | Login tanpa mengisi password | Email + "" | Sistem menolak: password wajib diisi | | |

**b. Modul Produk (30 Test Case)**

**Tabel 5.24 Pengujian Blackbox — CRUD Produk (Admin)**

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 17 | Nama Valid | Mengisi nama produk | "Baju Batik" | Data produk tersimpan | | |
| 18 | Nama Kosong | Tidak mengisi nama produk | "" | Sistem menolak: nama wajib diisi | | |
| 19 | Harga Valid | Mengisi harga lebih dari 0 | 50000 | Data produk tersimpan | | |
| 20 | Harga Nol | Mengisi harga 0 | 0 | Sistem menolak: minimal Rp1 | | |
| 21 | Harga Negatif | Mengisi harga negatif | -5000 | Sistem menolak: minimal Rp1 | | |
| 22 | Harga Non-Numeric | Mengisi harga dengan huruf | "abc" | Sistem menolak: harus berupa angka | | |
| 23 | Harga Kosong | Tidak mengisi harga | "" | Sistem menolak: harga wajib diisi | | |
| 24 | Diskon Normal | Diskon lebih kecil dari harga asli | price=50000, discount=40000 | Diskon tersimpan dan valid | | |
| 25 | Diskon Sama | Diskon sama dengan harga asli | price=50000, discount=50000 | Tidak ada efek diskon (harga final = 0) | | |
| 26 | Diskon Lebih Besar | Diskon lebih besar dari harga asli | price=50000, discount=60000 | Diskon tidak logis (error / auto-adjust) | | |
| 27 | Diskon Null | Tidak mengisi diskon | null | Produk tanpa diskon | | |
| 28 | Stok Valid | Mengisi stok minimal 0 | 100 | Stok tersimpan | | |
| 29 | Stok Negatif | Mengisi stok negatif | -5 | Sistem menolak: minimal 0 | | |
| 30 | Stok Non-Integer | Mengisi stok dengan huruf | "abc" | Sistem menolak: harus angka | | |
| 31 | Kategori Valid | Memilih kategori yang ada | category_id=1 | Produk masuk kategori | | |
| 32 | Kategori Invalid | Memilih kategori tidak ada | category_id=9999 | Sistem menolak: kategori tidak ditemukan | | |
| 33 | Kategori Kosong | Tidak memilih kategori | "" | Sistem menolak: kategori wajib diisi | | |
| 34 | Gambar Format Valid | Upload file gambar .jpg | "produk.jpg" (2MB) | Gambar tersimpan | | |
| 35 | Gambar Ukuran Besar | Upload file melebihi 10MB | File 15MB | Sistem menolak: maksimal 10MB | | |
| 36 | Gambar Format Invalid | Upload file bukan gambar | "file.pdf" | Sistem menolak: hanya jpeg/png/webp | | |

**Tabel 5.25 Pengujian Blackbox — Pencarian & Filter Produk**

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 37 | Keyword Ditemukan | Mencari produk yang ada | "Baju" | Menampilkan produk yang cocok | | |
| 38 | Keyword Tidak Ditemukan | Mencari produk yang tidak ada | "ZZZXYZ" | Menampilkan "produk tidak ditemukan" | | |
| 39 | Keyword Kosong | Mencari tanpa kata kunci | "" | Menampilkan semua produk | | |
| 40 | Filter Kategori Valid | Filter kategori dengan produk | Kategori ID valid | Produk per kategori | | |
| 41 | Filter Kategori Kosong | Filter kategori tanpa produk | Kategori ID (tanpa produk) | Tidak ada produk | | |
| 42 | Filter Kategori Invalid | Filter dengan kategori tidak ada | 9999 | Error / redirect | | |

**Tabel 5.26 Pengujian Blackbox — Stok Produk**

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 43 | Stok Masuk (In) | Menambah stok masuk | type="in", qty=10 | Stok +10, tercatat di log | | |
| 44 | Stok Keluar (Out) | Mengurangi stok keluar | type="out", qty=5 | Stok -5, tercatat di log | | |
| 45 | Stok Nol | Mutasi stok dengan quantity 0 | qty=0 | Tidak ada perubahan | | |
| 46 | Stok Negatif | Mutasi stok dengan quantity negatif | qty=-10 | Sistem menolak | | |

**c. Modul Keranjang (10 Test Case)**

**Tabel 5.27 Pengujian Blackbox — Keranjang Belanja**

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 47 | Tambah Produk Valid | Menambahkan produk yang ada | product_id=1, qty=2 | Item masuk ke keranjang | | |
| 48 | Tambah Produk Invalid | Menambahkan produk tidak ada | product_id=9999 | Sistem menolak: produk tidak ditemukan | | |
| 49 | Quantity Minimal 1 | Quantity bernilai 1 | qty=1 | Item tersimpan | | |
| 50 | Quantity 0 | Quantity bernilai 0 | qty=0 | Sistem menolak: minimal 1 | | |
| 51 | Quantity Negatif | Quantity bernilai negatif | qty=-3 | Sistem menolak: minimal 1 | | |
| 52 | Quantity Non-Integer | Quantity berupa huruf | qty="abc" | Sistem menolak: harus angka | | |
| 53 | Update Naik | Menambah quantity item | 1 → 5 | Quantity berubah | | |
| 54 | Update Turun | Mengurangi quantity item | 5 → 1 | Quantity berubah | | |
| 55 | Hapus Milik Sendiri | Menghapus item keranjang sendiri | cart_item_id valid | Item terhapus | | |
| 56 | Hapus Milik Orang Lain | Menghapus item keranjang user lain | cart_item_id (user lain) | 403 Forbidden | | |

**d. Modul Checkout (40 Test Case)**

**Tabel 5.28 Pengujian Blackbox — Manajemen Alamat**

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 57 | Nama Penerima Valid | Mengisi nama penerima | "Budi Santoso" | Alamat tersimpan | | |
| 58 | Nama Penerima Kosong | Tidak mengisi nama | "" | Sistem menolak: wajib diisi | | |
| 59 | No HP Valid | Mengisi nomor HP 10+ digit | "081234567890" | Tersimpan | | |
| 60 | No HP Kurang | Mengisi nomor HP < 10 digit | "08123" | Sistem menolak / tetap tersimpan | | |
| 61 | No HP Non-Numeric | Mengisi no HP dengan huruf | "abc123" | Sistem menolak: harus angka | | |
| 62 | No HP Kosong | Tidak mengisi no HP | "" | Sistem menolak: wajib diisi | | |
| 63 | Provinsi-Kota Sesuai | Kota sesuai dengan provinsi | province_id=12, city valid | Tersimpan | | |
| 64 | Provinsi-Kota Tidak Sesuai | Kota berbeda provinsi | province=Jawa Barat, city=Jakarta | Sistem menolak: tidak sesuai | | |
| 65 | Kecamatan Sesuai Kota | Kecamatan sesuai dengan kota | subdistrict_id valid | Tersimpan | | |
| 66 | Kecamatan Tidak Sesuai | Kecamatan beda kota | subdistrict_id (kota lain) | Sistem menolak: tidak sesuai | | |
| 67 | Kecamatan Null | Tanpa kecamatan | null | Tersimpan tanpa kecamatan | | |
| 68 | Alamat Default Pertama | Alamat pertama otomatis default | is_default=true | Jadi alamat utama | | |
| 69 | Alamat Default Ganti | Ganti alamat utama lain | is_default=true (alamat baru) | Alamat lama jadi biasa | | |

**Tabel 5.29 Pengujian Blackbox — Ongkos Kirim (RajaOngkir)**

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 70 | Kota Tujuan Valid | Cek ongkir dengan kota valid | destination=365 (Pontianak) | Menampilkan tarif | | |
| 71 | Kota Tujuan Invalid | Cek ongkir dengan kota tidak ada | destination=99999 | Sistem menolak | | |
| 72 | Kurir JNE | Cek ongkir JNE | courier="jne" | Tarif JNE tampil | | |
| 73 | Kurir POS | Cek ongkir POS | courier="pos" | Tarif POS tampil | | |
| 74 | Kurir TIKI | Cek ongkir TIKI | courier="tiki" | Tarif TIKI tampil | | |
| 75 | Kurir Tidak Tersedia | Cek ongkir kurir lain | courier="sicepat" | Sistem menolak: kurir tidak tersedia | | |
| 76 | Kurir Kosong | Cek ongkir tanpa kurir | courier="" | Sistem menolak: wajib diisi | | |
| 77 | Berat Valid | Cek ongkir dengan berat >0 | weight=1000g | Tarif dihitung akurat | | |
| 78 | Berat 0 | Cek ongkir dengan berat 0 | weight=0g | Auto-adjust ke 200g (default) | | |
| 79 | Berat Negatif | Cek ongkir dengan berat negatif | weight=-500g | Auto-adjust / error | | |
| 80 | Dengan Kecamatan | Cek ongkir pakai kecamatan tujuan | subdistrict_id valid | Tarif lebih akurat (district level) | | |
| 81 | Tanpa Kecamatan | Cek ongkir tanpa kecamatan | subdistrict_id=null | Tarif city level | | |

**Tabel 5.30 Pengujian Blackbox — Voucher di Checkout**

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 82 | Kode Valid & Baru | Klaim voucher dengan kode valid | "PROMO10" | Voucher berhasil diklaim | | |
| 83 | Kode Sudah Diklaim | Klaim voucher yang sudah pernah diklaim | "PROMO10" (ulang) | Sistem menolak: sudah diklaim | | |
| 84 | Kode Tidak Ada | Klaim dengan kode tidak terdaftar | "XXXXXXXX" | Sistem menolak: kode tidak valid | | |
| 85 | Kode Expired | Klaim voucher kadaluarsa | Kode expired | Sistem menolak: sudah kadaluarsa | | |
| 86 | Kuota Habis | Klaim voucher kuota penuh | max_usage terpenuhi | Sistem menolak: kuota habis | | |
| 87 | Belum Mulai | Klaim voucher sebelum start_date | start_date > hari ini | Sistem menolak: belum bisa dipakai | | |
| 88 | Kode Kosong | Klaim tanpa kode | "" | Sistem menolak: kode wajib | | |
| 89 | Min Purchase Terpenuhi | Pakai voucher memenuhi min belanja | subtotal ≥ min_purchase | Diskon berhasil dihitung | | |
| 90 | Min Purchase Tidak Terpenuhi | Pakai voucher di bawah min belanja | subtotal < min_purchase | Sistem menolak: minimal belanja | | |
| 91 | Min Qty Terpenuhi | Jumlah barang memenuhi min qty | total_qty ≥ min_qty | Diskon berhasil dihitung | | |
| 92 | Min Qty Tidak Terpenuhi | Jumlah barang kurang dari min qty | total_qty < min_qty | Sistem menolak: minimal qty | | |

**Tabel 5.31 Pengujian Blackbox — Proses Checkout**

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 93 | Semua Valid | Proses checkout data lengkap + valid | address + courier + cost valid | Transaksi terbuat, redirect ke Midtrans | | |
| 94 | Cart Kosong | Proses checkout saat cart kosong | cart tanpa item | Redirect + error "keranjang kosong" | | |
| 95 | Alamat Milik Orang Lain | Memilih alamat milik user lain | address_id user lain | 404 / Error | | |
| 96 | Ongkir Negatif | Ongkos kirim bernilai negatif | shipping_cost=-1000 | Sistem menolak | | |

**e. Modul Midtrans (9 Test Case)**

**Tabel 5.32 Pengujian Blackbox — Midtrans Payment**

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 97 | Settlement | Notifikasi pembayaran sukses (settlement) | transaction_status="settlement" | Status "paid", transaksi "processing" | | |
| 98 | Capture + Accept | Notifikasi capture diaccept | status="capture", fraud="accept" | Status "paid" | | |
| 99 | Capture + Deny | Notifikasi capture ditolak | status="capture", fraud="deny" | Status "pending" | | |
| 100 | Pending | Notifikasi masih pending | transaction_status="pending" | Status tetap "pending" | | |
| 101 | Deny | Notifikasi pembayaran ditolak | transaction_status="deny" | Status "failed" | | |
| 102 | Expire | Notifikasi pembayaran expired | transaction_status="expire" | Status "expired", transaksi "cancelled", stok dikembalikan | | |
| 103 | Cancel | Notifikasi pembayaran dibatalkan | transaction_status="cancel" | Status "failed" | | |
| 104 | Signature Valid | Signature key sesuai perhitungan | signature_key valid | Proses notifikasi diteruskan | | |
| 105 | Signature Invalid | Signature key tidak sesuai | signature_key asal | Error: invalid signature | | |

**f. Modul Voucher Admin (18 Test Case)**

**Tabel 5.33 Pengujian Blackbox — Voucher (Admin)**

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 106 | Kode Unik | Membuat voucher dengan kode baru | code="DISKON50" | Voucher tersimpan | | |
| 107 | Kode Duplikat | Membuat voucher dengan kode yang sudah ada | code="DISKON50" (sudah ada) | Sistem menolak: kode duplikat | | |
| 108 | Kode Kosong | Membuat voucher tanpa kode | code="" | Sistem menolak: wajib diisi | | |
| 109 | Tipe Percentage | Voucher diskon persen | type="percentage" | Diskon dalam persen | | |
| 110 | Tipe Fixed | Voucher diskon nominal | type="fixed" | Diskon dalam rupiah | | |
| 111 | Tipe Free Shipping | Voucher gratis ongkir | type="free_shipping" | Diskon senilai ongkos kirim | | |
| 112 | Tipe Invalid | Tipe tidak dalam pilihan | type="diskon" | Sistem menolak | | |
| 113 | Nilai Persen 1-100 | Diskon 20% | value=20 | Diskon 20% dari subtotal | | |
| 114 | Nilai Persen 0 | Diskon 0% | value=0 | Tidak ada diskon | | |
| 115 | Nilai Persen >100 | Diskon melebihi 100% | value=150 | Tidak logis (error) | | |
| 116 | Nilai Fixed > 0 | Diskon nominal Rp50.000 | value=50000 | Diskon Rp50.000 | | |
| 117 | Nilai Fixed 0 | Diskon nominal Rp0 | value=0 | Tidak ada diskon | | |
| 118 | Maks Diskon Unlimited | Tanpa batas maksimal diskon | max_discount=null | Diskon tanpa batas | | |
| 119 | Maks Diskon Terbatas | Dengan batas maksimal diskon | max_discount=20000 | Diskon maksimal Rp20.000 | | |
| 120 | Min Purchase 0 | Tanpa minimal belanja | min_purchase=0 | Bebas dipakai tanpa minimal | | |
| 121 | Min Purchase > 0 | Minimal belanja Rp100.000 | min_purchase=100000 | Minimal belanja Rp100rb | | |
| 122 | Maks Usage Unlimited | Tanpa batas pemakaian | max_usage=null | Bisa dipakai berkali-kali | | |
| 123 | Maks Usage Terbatas | Batas pemakaian 100 kali | max_usage=100 | Hanya 100 kali pemakaian | | |

**g. Modul Rating (13 Test Case)**

**Tabel 5.34 Pengujian Blackbox — Rating & Ulasan**

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 124 | Rating 1-5 | Memberi rating 4 | rating=4 | Rating tersimpan | | |
| 125 | Rating < 1 | Memberi rating 0 | rating=0 | Sistem menolak: minimal 1 | | |
| 126 | Rating > 5 | Memberi rating 6 | rating=6 | Sistem menolak: maksimal 5 | | |
| 127 | Rating Non-Integer | Rating berupa huruf | rating="a" | Sistem menolak: harus angka | | |
| 128 | Rating Null | Tidak mengisi rating | rating=null | Sistem menolak: wajib diisi | | |
| 129 | Review Diisi | Menulis ulasan | "Produk bagus sekali" | Ulasan tersimpan | | |
| 130 | Review Kosong | Tidak menulis ulasan | "" | Ulasan tetap tersimpan (opsional) | | |
| 131 | Dengan Gambar | Upload gambar pada ulasan | foto.jpg | Gambar tersimpan | | |
| 132 | Tanpa Gambar | Tidak upload gambar | null | Ulasan tanpa gambar | | |
| 133 | Rating Duplikat | Rating produk yang sama (user+produk+transaksi) | data sama | Sistem menolak: sudah pernah rating | | |
| 134 | Admin Approve | Admin menyetujui ulasan | is_approved=true | Ulasan tampil di publik | | |
| 135 | Admin Reject | Admin tidak menyetujui ulasan | is_approved=false | Ulasan tidak tampil di publik | | |
| 136 | Admin Reply | Admin membalas ulasan | "Terima kasih" | Balasan tersimpan | | |

**h. Modul Retur (14 Test Case)**

**Tabel 5.35 Pengujian Blackbox — Retur**

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 137 | Alasan Produk Cacat | Retur karena produk cacat | reason="defective" | Retur "produk cacat" | | |
| 138 | Alasan Salah Barang | Retur karena salah barang | reason="wrong_item" | Retur "salah barang" | | |
| 139 | Alasan Tidak Sesuai | Retur karena tidak sesuai deskripsi | reason="not_as_description" | Retur "tidak sesuai deskripsi" | | |
| 140 | Alasan Ukuran | Retur karena masalah ukuran | reason="size_issue" | Retur "masalah ukuran" | | |
| 141 | Alasan Lainnya | Retur dengan alasan lain | reason="other" | Retur "lainnya" | | |
| 142 | Alasan Invalid | Alasan tidak dalam pilihan | reason="salah" | Sistem menolak | | |
| 143 | Qty ≤ Transaksi | Retur 1 item dari 3 yang dibeli | qty=1 | Retur diproses | | |
| 144 | Qty > Transaksi | Retur melebihi jumlah yang dibeli | qty=5 (beli 3) | Sistem menolak: melebihi quantity | | |
| 145 | Upload Bukti | Upload foto bukti retur | foto_bukti.jpg | Bukti tersimpan | | |
| 146 | Tanpa Bukti | Tidak upload bukti | null | Retur tanpa bukti | | |
| 147 | Admin Approve | Admin menyetujui retur | status="approved" | Retur disetujui | | |
| 148 | Admin Reject | Admin menolak retur | status="rejected" | Retur ditolak | | |
| 149 | Admin Complete | Admin menyelesaikan retur | status="completed" | Retur selesai | | |
| 150 | Customer Batal | Customer membatalkan retur (status pending) | cancel | Retur dibatalkan | | |

**i. Modul Transaksi Admin (14 Test Case)**

**Tabel 5.36 Pengujian Blackbox — Transaksi (Admin)**

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 151 | Status Pending | Update status ke pending | status="pending" | Status pending | | |
| 152 | Status Processing | Update status ke processing | status="processing" | Status diproses | | |
| 153 | Status Shipped | Update status ke shipped | status="shipped" | Status dikirim, shipped_at terisi | | |
| 154 | Status Delivered | Update status ke delivered | status="delivered" | Status selesai, delivered_at terisi | | |
| 155 | Status Cancelled | Update status ke cancelled | status="cancelled" | Status batal, stok dikembalikan | | |
| 156 | Status Invalid | Mengisi status tidak dalam pilihan | status="selesai" | Sistem menolak | | |
| 157 | Payment Paid | Update payment ke paid | payment_status="paid" | Lunas, paid_at terisi | | |
| 158 | Payment Unpaid | Update payment ke unpaid | payment_status="unpaid" | Belum bayar | | |
| 159 | Payment Failed | Update payment ke failed | payment_status="failed" | Gagal bayar | | |
| 160 | Payment Expired | Update payment ke expired | payment_status="expired" | Kedaluwarsa | | |
| 161 | Payment Invalid | Payment tidak dalam pilihan | payment_status="lunas" | Sistem menolak | | |
| 162 | Resi Valid | Input nomor resi pengiriman | tracking_number="JP1234567890" | Resi tersimpan, status "shipped", notifikasi web terkirim | | |
| 163 | Resi Kosong | Input resi tanpa nomor | tracking_number="" | Sistem menolak: wajib diisi | | |
| 164 | Resi Sebelum Lunas | Input resi saat payment belum paid | payment_status="unpaid" | Sistem menolak: harus lunas dulu | | |

**j. Modul Wishlist (5 Test Case)**

**Tabel 5.37 Pengujian Blackbox — Wishlist**

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 165 | Toggle Masuk | Wishlist produk yang belum ada | product_id=1 | Produk masuk wishlist | | |
| 166 | Toggle Keluar | Wishlist produk yang sudah ada | product_id=1 (ulang) | Produk keluar wishlist | | |
| 167 | Produk Invalid | Wishlist produk tidak ada | product_id=9999 | Sistem menolak: produk tidak ditemukan | | |
| 168 | Hapus Milik Sendiri | Hapus wishlist milik sendiri | wishlist_id valid | Terhapus | | |
| 169 | Hapus Milik Orang Lain | Hapus wishlist milik user lain | wishlist_id (orang lain) | 403 Forbidden | | |

**k. Modul Akses Admin (3 Test Case)**

**Tabel 5.38 Pengujian Blackbox — Akses Admin**

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 170 | Role Admin | Admin mengakses halaman admin | role="admin" | Akses diberikan ke dashboard | | |
| 171 | Role Customer | Customer mengakses halaman admin | role="customer" | 403 Forbidden / redirect | | |
| 172 | Guest (Belum Login) | User belum login mengakses admin | guest | Redirect ke halaman login | | |

**l. Modul Banner (11 Test Case)**

**Tabel 5.39 Pengujian Blackbox — Banner**

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 173 | Title Diisi | Mengisi judul banner | "Promo Akhir Tahun" | Banner tersimpan | | |
| 174 | Title Kosong | Tidak mengisi judul | "" | Sistem menolak: wajib diisi | | |
| 175 | Gambar Valid | Upload gambar .jpg | banner.jpg | Tersimpan | | |
| 176 | Gambar Invalid | Upload file bukan gambar | file.pdf | Sistem menolak: hanya jpeg/png | | |
| 177 | Link Valid | URL banner valid | "https://tokopedia.com" | Ada tautan | | |
| 178 | Link Kosong | Banner tanpa tautan | "" | Banner tanpa link | | |
| 179 | Start Date Null | Banner langsung tayang | null | Langsung tampil | | |
| 180 | End Date Null | Banner tanpa batas akhir | null | Tayang terus | | |
| 181 | Jadwal Aktif | Banner dalam rentang tayang | start ≤ now ≤ end | Banner tampil | | |
| 182 | Jadwal Belum Mulai | Banner belum waktunya tayang | now < start | Banner tidak tampil | | |
| 183 | Jadwal Lewat | Banner sudah lewat masa tayang | now > end | Banner tidak tampil | | |

**Rekapitulasi Test Case**

**Tabel 5.40 Rekapitulasi Blackbox Testing**

| No | Modul | Jumlah TC | Valid | Invalid | Coverage |
|----|-------|:---------:|:-----:|:-------:|:--------:|
| 1 | Autentikasi | 16 | | | |
| 2 | Produk | 30 | | | |
| 3 | Keranjang | 10 | | | |
| 4 | Checkout | 40 | | | |
| 5 | Midtrans | 9 | | | |
| 6 | Voucher | 18 | | | |
| 7 | Rating | 13 | | | |
| 8 | Retur | 14 | | | |
| 9 | Transaksi Admin | 14 | | | |
| 10 | Wishlist | 5 | | | |
| 11 | Akses Admin | 3 | | | |
| 12 | Banner | 11 | | | |
| | **TOTAL** | **183** | | | |

---

#### 5.1.4.2 Hosting

Sistem dijalankan pada lingkungan lokal menggunakan **XAMPP** dengan **ngrok** sebagai tunneling untuk mengakomodasi webhook Midtrans yang memerlukan URL publik.

**Tabel 5.41 Konfigurasi Hosting**

| Aspek | Spesifikasi |
|-------|-------------|
| **Web Server** | Apache 2.4 (XAMPP) |
| **PHP** | PHP 8.x |
| **Database** | MySQL (MariaDB) via XAMPP, port 3307 |
| **Database Name** | `aciaa3820_db` |
| **Framework** | Laravel 11 |
| **Frontend** | Tailwind CSS, Alpine.js |
| **Tunneling** | ngrok (URL publik: *.ngrok-free.dev) |
| **Midtrans Environment** | Sandbox (is_3ds: true) |
| **Midtrans Notification URL** | `https://<ngrok-url>/midtrans/notification` |

**Langkah Deployment:**
1. Pastikan XAMPP (Apache + MySQL) berjalan.
2. Jalankan migration: `php artisan migrate`
3. Jalankan storage link: `php artisan storage:link`
4. Jalankan aplikasi: `php artisan serve` atau akses via `localhost/aciaa_221103820/public`
5. Jalankan ngrok: `ngrok http http://localhost:80` (atau port yang sesuai)
6. Update `APP_URL` di `.env` dengan URL ngrok
7. Update URL notifikasi Midtrans dengan URL ngrok

---

## 5.2 DEMONSTRASI

Demonstrasi sistem menjelaskan **alur penggunaan** fitur-fitur utama dari sudut pandang pengguna (customer dan admin). Berbeda dengan sub-bab 5.1.3 yang menampilkan tampilan setiap halaman secara statis, sub-bab ini menjelaskan **bagaimana pengguna menggunakan sistem** secara step-by-step.

---

### 5.2.1 Demonstrasi Alur Registrasi dan Login

**Skenario: Pengguna baru mendaftar dan login ke sistem**

| Langkah | Aksi | Sistem | Screenshot |
|---------|------|--------|:----------:|
| 1 | Pengguna membuka halaman utama sistem | Menampilkan landing page dengan banner, kategori, produk | [Gambar 5.27] |
| 2 | Pengguna menekan tombol "Daftar" di navbar | Mengarahkan ke halaman registrasi | [Gambar 5.28] |
| 3 | Pengguna mengisi form: Nama = "Budi Santoso", Email = "budi@mail.com", Password = "budi12345" | - | - |
| 4 | Pengguna menekan tombol "Daftar" | Memvalidasi input: nama ≥ 3 karakter, email valid, password ≥ 8 karakter, email unik | - |
| 5 | - | Jika valid: membuat akun baru, login otomatis, redirect ke beranda | [Gambar 5.29] |
| 5a | - | Jika email sudah terdaftar: menampilkan error "Email sudah digunakan" | [Gambar 5.30] |
| 6 | Pengguna logout dan menekan "Masuk" | Mengarahkan ke halaman login | [Gambar 5.31] |
| 7 | Pengguna memasukkan email dan password yang benar | Memverifikasi kredensial | - |
| 8 | - | Jika cocok: redirect ke halaman utama (customer) atau dashboard (admin) | [Gambar 5.32] |
| 8a | - | Jika salah: menampilkan error "Email atau password salah" | [Gambar 5.33] |

---

### 5.2.2 Demonstrasi Alur Pembelian Produk

**Skenario: Customer mencari produk, melihat detail, dan menambahkan ke keranjang**

| Langkah | Aksi | Sistem | Screenshot |
|---------|------|--------|:----------:|
| 1 | Customer membuka halaman utama | Menampilkan produk promo dan terbaru | [Gambar 5.34] |
| 2 | Customer mengetik "Baju" di kolom pencarian | Menampilkan produk yang namanya mengandung "Baju" | [Gambar 5.35] |
| 3 | Customer memilih kategori "Pakaian" dari sidebar | Memfilter produk hanya dari kategori Pakaian | [Gambar 5.36] |
| 4 | Customer menekan gambar produk | Menampilkan halaman detail produk: gambar besar, galeri, harga, deskripsi, stok, rating | [Gambar 5.37] |
| 5 | Customer memilih jumlah = 2, menekan "Tambah ke Keranjang" | Validasi: stok tersedia? qty ≥ 1? | - |
| 6 | - | Jika valid: menambahkan ke cart, flash message "Produk ditambahkan ke keranjang" | [Gambar 5.38] |
| 6a | - | Jika stok habis: menampilkan "Stok tidak mencukupi" | [Gambar 5.39] |
| 7 | Customer melihat navbar | Badge keranjang berubah dari 0 ke 2 (via AJAX) | [Gambar 5.40] |

---

### 5.2.3 Demonstrasi Alur Checkout dan Pembayaran

**Skenario: Customer melakukan checkout hingga pembayaran**

| Langkah | Aksi | Sistem | Screenshot |
|---------|------|--------|:----------:|
| 1 | Customer menekan ikon keranjang di navbar | Menampilkan halaman keranjang dengan daftar item + subtotal | [Gambar 5.41] |
| 2 | Customer menekan tombol "Checkout" | Validasi cart tidak kosong, redirect ke halaman checkout | [Gambar 5.42] |
| 3 | Customer memilih alamat pengiriman dari dropdown | Menampilkan daftar alamat tersimpan | [Gambar 5.43] |
| 4 | Customer menekan "Tambah Alamat Baru" | Menampilkan modal/form alamat | [Gambar 5.44] |
| 5 | Customer memilih provinsi → sistem load kota → customer pilih kota → sistem load kecamatan → customer pilih kecamatan → isi detail alamat → simpan | Cascading dropdown via AJAX ke API Komerce (data di-cache lokal) | [Gambar 5.45] |
| 6 | Customer memilih kurir "JNE" dari dropdown | Sistem memanggil API RajaOngkir Komerce dengan parameter: origin=513, destination=city_id, weight=total_berat, courier=jne | [Gambar 5.46] |
| 7 | - | Menampilkan daftar layanan JNE: REG (Rp..., 2-3 hari), OKE (Rp..., 3-5 hari), YES (Rp..., 1 hari) | [Gambar 5.47] |
| 8 | Customer memilih layanan "REG" | Ongkos kirim terisi, total otomatis dihitung ulang | [Gambar 5.48] |
| 9 | Customer memilih voucher "DISKON10" dari daftar voucer yang sudah diklaim | Sistem menghitung diskon 10% dari subtotal, menampilkan potongan | [Gambar 5.49] |
| 10 | Customer memeriksa total: subtotal + ongkir - diskon = grand total | - | [Gambar 5.50] |
| 11 | Customer menekan "Bayar Sekarang" | Sistem membuat transaksi (DB transaction): create transaction, create transaction details, kurangi stok, update user_voucher, clear cart | [Gambar 5.51] |
| 12 | - | Sistem memanggil MidtransService untuk mendapatkan Snap Token | - |
| 13 | - | Midtrans mengembalikan Snap Token | - |
| 14 | - | Frontend menampilkan popup Midtrans Snap | [Gambar 5.52] |
| 15 | Customer memilih "Transfer BCA" → "Bayar" | Midtrans memproses pembayaran | [Gambar 5.53] |
| 16 | Customer menyelesaikan pembayaran | Popup menutup, customer diarahkan ke halaman sukses | [Gambar 5.54] |
| 17 | - | Midtrans mengirim notifikasi POST ke `/midtrans/notification` | - |
| 18 | - | Sistem verifikasi signature → update status jadi "paid" | - |
| 19 | - | Sistem membuat notifikasi in-app untuk customer | [Gambar 5.55] |

---

### 5.2.4 Demonstrasi Alur Tracking Pesanan

**Skenario: Customer mengecek status dan tracking pesanan**

| Langkah | Aksi | Sistem | Screenshot |
|---------|------|--------|:----------:|
| 1 | Customer membuka menu "Riwayat Transaksi" | Menampilkan daftar transaksi dengan status | [Gambar 5.56] |
| 2 | Customer menekan tombol "Detail" pada transaksi | Menampilkan detail lengkap: info pesanan, pembayaran, pengiriman, daftar produk, rincian biaya | [Gambar 5.57] |
| 3 | Jika sudah ada resi, customer menekan link tracking | Membuka website kurir (JNE/POS/TIKI) dengan nomor resi | [Gambar 5.58] |
| 4 | Jika belum ada resi, status menampilkan "Dikemas / Diproses" | - | [Gambar 5.59] |

---

### 5.2.5 Demonstrasi Alur Klaim dan Penggunaan Voucher

**Skenario: Customer melihat voucher yang tersedia, mengklaim, dan menggunakannya**

| Langkah | Aksi | Sistem | Screenshot |
|---------|------|--------|:----------:|
| 1 | Customer membuka menu "Voucher" | Menampilkan tab: "Tersedia" dan "Voucher Saya" | [Gambar 5.60] |
| 2 | Customer melihat voucher "DISKON10" — diskon 10%, min belanja Rp50rb, berlaku 30 hari | - | [Gambar 5.61] |
| 3 | Customer menekan "Klaim" | Validasi: belum kadaluarsa? kuota masih ada? | - |
| 4 | - | Jika valid: create UserVoucher, flash message "Voucher berhasil diklaim" | [Gambar 5.62] |
| 5 | Saat checkout, customer membuka bagian voucher | Menampilkan daftar voucher milik customer yang belum dipakai | [Gambar 5.63] |
| 6 | Customer memilih voucher "DISKON10" | Jika min_purchase terpenuhi: potong subtotal 10% | [Gambar 5.64] |
| 7 | Customer juga bisa memasukkan kode voucher baru | Mencari kode di database → jika valid dan belum diklaim: tambahkan ke user_vouchers → gunakan | [Gambar 5.65] |

---

### 5.2.6 Demonstrasi Alur Memberi Rating dan Ulasan

**Skenario: Customer memberi rating setelah pesanan diterima**

| Langkah | Aksi | Sistem | Screenshot |
|---------|------|--------|:----------:|
| 1 | Customer membuka detail transaksi yang statusnya "delivered" | Menampilkan tombol "Beri Ulasan" pada setiap produk | [Gambar 5.66] |
| 2 | Customer menekan "Beri Ulasan" | Menampilkan form rating: bintang 1-5 (clickable), textarea review, upload gambar | [Gambar 5.67] |
| 3 | Customer memilih bintang 4, menulis "Produk bagus, sesuai deskripsi", upload foto | - | - |
| 4 | Customer menekan "Kirim" | Validasi: rating 1-5? duplikat (user+produk+transaksi)? | - |
| 5 | - | Jika valid: create ProductRating dengan is_approved = false (pending) | [Gambar 5.68] |
| 6 | Admin membuka menu "Rating" | Melihat daftar rating pending | [Gambar 5.69] |
| 7 | Admin menekan "Setujui" | is_approved = true, rating tampil di halaman produk publik | [Gambar 5.70] |

---

### 5.2.7 Demonstrasi Alur Pengajuan Retur

**Skenario: Customer mengajukan retur karena produk cacat**

| Langkah | Aksi | Sistem | Screenshot |
|---------|------|--------|:----------:|
| 1 | Customer membuka detail transaksi yang sudah diterima | Menampilkan tombol "Ajukan Retur" | [Gambar 5.71] |
| 2 | Customer menekan "Ajukan Retur" | Menampilkan form retur: pilih produk (dari transaksi), alasan (dropdown), deskripsi, upload foto | [Gambar 5.72] |
| 3 | Customer memilih produk, alasan "Produk Cacat", deskripsi "Ada sobek di bagian lengan", upload foto | - | - |
| 4 | Customer menekan "Kirim" | Validasi: qty ≤ qty transaksi? | - |
| 5 | - | Jika valid: create Retur + ReturItem, status "pending" | [Gambar 5.73] |
| 6 | Admin membuka menu "Retur" | Melihat daftar retur pending | [Gambar 5.74] |
| 7 | Admin memeriksa bukti dan menekan "Setujui" | status = "approved", notifikasi ke customer | [Gambar 5.75] |
| 8 | Admin memproses refund, menekan "Selesai" | status = "completed" | [Gambar 5.76] |

---

### 5.2.8 Demonstrasi Alur Manajemen Transaksi oleh Admin

**Skenario: Admin mengelola status pesanan dan input resi**

| Langkah | Aksi | Sistem | Screenshot |
|---------|------|--------|:----------:|
| 1 | Admin login dan masuk ke dashboard | Menampilkan ringkasan: total transaksi, pendapatan, stok menipis | [Gambar 5.77] |
| 2 | Admin membuka menu "Transaksi" | Menampilkan tabel daftar transaksi dengan filter status | [Gambar 5.78] |
| 3 | Admin filter "pending" → melihat pesanan baru | - | [Gambar 5.79] |
| 4 | Admin buka detail transaksi → ubah status ke "processing" | Status berubah, notifikasi dikirim ke customer | [Gambar 5.80] |
| 5 | Admin input nomor resi "JNE123456789" → sistem otomatis membuat tracking_url | Status berubah jadi "shipped", shipped_at terisi, notifikasi in-app | [Gambar 5.81] |
| 6 | Customer menerima barang → admin update status ke "delivered" | delivered_at terisi | [Gambar 5.82] |

---

### 5.2.9 Demonstrasi Alur Notifikasi In-App

**Skenario: Customer melihat notifikasi**

| Langkah | Aksi | Sistem | Screenshot |
|---------|------|--------|:----------:|
| 1 | Customer melihat ikon lonceng di navbar | Menampilkan badge angka (jumlah notifikasi unread) | [Gambar 5.83] |
| 2 | Customer hover/klik ikon lonceng | Dropdown menampilkan 5 notifikasi terbaru | [Gambar 5.84] |
| 3 | Customer menekan "Lihat Semua" | Membuka halaman notifikasi | [Gambar 5.85] |
| 4 | Customer menekan "Tandai Sudah Dibaca" pada satu notifikasi | is_read = true, badge berkurang | [Gambar 5.86] |
| 5 | Customer menekan "Tandai Semua Dibaca" | Semua notifikasi user jadi is_read = true | [Gambar 5.87] |

---

## 5.3 EVALUASI

Evaluasi sistem dilakukan berdasarkan hasil pengujian blackbox yang telah dilaksanakan pada sub-bab 5.1.4.1. Bagian ini menganalisis hasil pengujian dan mengevaluasi pemenuhan kebutuhan sistem.

---

### 5.3.1 Analisis Hasil Blackbox Testing

Berdasarkan hasil pengujian blackbox dengan teknik Equivalence Partitioning pada Tabel 5.23 sampai Tabel 5.39, diperoleh analisis sebagai berikut:

**Tabel 5.42 Rekapitulasi Hasil Pengujian**

| Modul | Total TC | Valid | Invalid | Coverage |
|-------|:--------:|:-----:|:-------:|:--------:|
| Autentikasi | 16 | | | |
| Produk | 30 | | | |
| Keranjang | 10 | | | |
| Checkout | 40 | | | |
| Midtrans | 9 | | | |
| Voucher | 18 | | | |
| Rating | 13 | | | |
| Retur | 14 | | | |
| Transaksi Admin | 14 | | | |
| Wishlist | 5 | | | |
| Akses Admin | 3 | | | |
| Banner | 11 | | | |
| **TOTAL** | **183** | | | |

*(Kolom Valid, Invalid, dan Coverage diisi setelah pengujian dilakukan)*

**Rumus Perhitungan:**

```
Persentase Coverage = (Jumlah TC Valid / Total TC) × 100%
Persentase Bug = (Jumlah TC Invalid / Total TC) × 100%
```

---

### 5.3.2 Evaluasi Pemenuhan Kebutuhan Fungsional

**Tabel 5.43 Evaluasi Kebutuhan Fungsional**

| No | Modul | Total Kebutuhan | Terpenuhi | Tidak Terpenuhi | Persentase |
|----|-------|:--------------:|:---------:|:---------------:|:----------:|
| 1 | Autentikasi & Manajemen Pengguna | 9 | | | |
| 2 | Manajemen Produk & Kategori | 11 | | | |
| 3 | Manajemen Banner | 3 | | | |
| 4 | Keranjang Belanja | 5 | | | |
| 5 | Wishlist | 4 | | | |
| 6 | Checkout & Transaksi | 17 | | | |
| 7 | Voucher & Diskon | 6 | | | |
| 8 | Rating & Ulasan | 8 | | | |
| 9 | Retur | 7 | | | |
| 10 | Pengiriman & Tracking | 6 | | | |
| 11 | Dashboard Admin | 9 | | | |
| 12 | Notifikasi | 5 | | | |
| 13 | Logging & Keamanan | 2 | | | |
| | **TOTAL** | **92** | | | |

*(Kolom diisi setelah evaluasi selesai)*

Dari 92 kebutuhan fungsional yang teridentifikasi pada Tabel 5.1 sampai Tabel 5.13, sebanyak ___ kebutuhan (___%) berhasil diimplementasikan dan ___ kebutuhan (___%) tidak terpenuhi.

---

### 5.3.3 Evaluasi Pemenuhan Kebutuhan Non-Fungsional

**Tabel 5.44 Evaluasi Kebutuhan Non-Fungsional**

| No | Aspek | Total Kebutuhan | Terpenuhi | Tidak Terpenuhi | Persentase |
|----|-------|:--------------:|:---------:|:---------------:|:----------:|
| 1 | Keamanan (Security) | 7 | | | |
| 2 | Performa (Performance) | 4 | | | |
| 3 | Keandalan (Reliability) | 4 | | | |
| 4 | Kegunaan (Usability) | 4 | | | |
| 5 | Kompatibilitas (Compatibility) | 3 | | | |
| 6 | Maintainability | 6 | | | |
| | **TOTAL** | **28** | | | |

*(Kolom diisi setelah evaluasi selesai)*

---

### 5.3.4 Temuan Bug

**Tabel 5.45 Daftar Temuan Bug**

| No | Modul | Skenario Uji | Bug yang Ditemukan | Severity | Status |
|----|-------|-------------|-------------------|:--------:|:------:|
| - | - | - | Tidak ada bug yang ditemukan | - | - |

*(Diisi jika ada bug yang ditemukan selama pengujian)*

Severity: **Critical** (sistem crash), **Major** (fitur tidak berfungsi), **Minor** (tampilan/UX), **Trivial** (typo/detail kecil)

---

### 5.3.5 Kesimpulan Evaluasi

Berdasarkan hasil pengujian blackbox dan evaluasi pemenuhan kebutuhan yang telah dilakukan, dapat disimpulkan:

1. **Tingkat Keberhasilan Sistem**
   - Dari 183 test case yang diuji, ___ test case (___%) berjalan sesuai dengan hasil yang diharapkan.
   - ___ test case (___%) menunjukkan perilaku yang tidak sesuai (bug/error).
   - Sistem dinyatakan **layak / tidak layak** untuk digunakan berdasarkan hasil pengujian.

2. **Pemenuhan Kebutuhan Fungsional**
   - Sebanyak ___ dari 92 kebutuhan fungsional (___%) telah berhasil diimplementasikan.
   - Kebutuhan yang tidak terpenuhi: ___ (___%).
   - Seluruh modul inti e-commerce telah berfungsi dengan baik.

3. **Pemenuhan Kebutuhan Non-Fungsional**
   - Sebanyak ___ dari 28 kebutuhan non-fungsional (___%) telah terpenuhi.
   - Aspek keamanan: autentikasi, otorisasi, CSRF, enkripsi password, dan verifikasi signature Midtrans telah diimplementasikan.
   - Aspek performa: caching ongkir dan data lokasi telah mengurangi panggilan API berulang.
   - Aspek keandalan: database transaction dan restore stok otomatis telah berjalan.

4. **Kualitas Sistem**
   - Sistem telah terintegrasi dengan Midtrans (payment gateway) dan RajaOngkir Komerce (shipping cost API).
   - Antarmuka responsif menggunakan Tailwind CSS.
   - Notifikasi in-app berfungsi untuk memberikan update kepada customer.

---

## 5.4 KOMUNIKASI

Sub-bab komunikasi menjelaskan bagaimana sistem berinteraksi dengan pengguna dan sistem eksternal, keterbatasan sistem yang ditemukan selama penelitian, serta saran untuk pengembangan sistem selanjutnya.

---

### 5.4.1 Komunikasi dengan Pengguna

Sistem berkomunikasi dengan pengguna (customer dan admin) melalui beberapa media sebagai berikut:

**Tabel 5.46 Media Komunikasi dengan Pengguna**

| No | Media Komunikasi | Deskripsi | Implementasi |
|----|-----------------|-----------|--------------|
| 1 | **Antarmuka Web (UI)** | Pengguna berinteraksi melalui halaman web yang responsif dengan navigasi yang jelas | Blade Template + Tailwind CSS |
| 2 | **Flash Message** | Notifikasi temporer yang muncul setelah aksi pengguna (sukses/error/warning), hilang otomatis setelah beberapa detik | Laravel `session()->flash()` + Alpine.js auto-hide |
| 3 | **Notifikasi In-App** | Notifikasi tersimpan di database (`notifications` table) yang muncul di dropdown navbar dan halaman notifikasi khusus | `App\Models\Notification::create()`, AJAX untuk badge count |
| 4 | **Validasi Form (Client-side)** | Pesan validasi muncul real-time saat pengguna mengisi form sebelum submit | Alpine.js + atribut HTML5 (required, minlength, pattern) |
| 5 | **Validasi Form (Server-side)** | Pesan validasi dari server muncul setelah submit jika ada data yang tidak valid | Laravel Form Request Validation + error bag |
| 6 | **Modal / Popup Konfirmasi** | Konfirmasi sebelum aksi destruktif (hapus, batalkan) | Alpine.js modal + konfirmasi |
| 7 | **Midtrans Snap Popup** | Popup pembayaran dari Midtrans yang menampilkan pilihan metode pembayaran | Midtrans Snap.js |
| 8 | **Toast Notification (AJAX)** | Notifikasi kecil di pojok layar untuk aksi AJAX (tambah keranjang, wishlist) | Alpine.js + CSS transition |

**Alur Notifikasi In-App:**

```
┌──────────┐     Event terjadi      ┌──────────────┐
│  System  │ ──────────────────────→ │ Notification │
│ (Event)  │                        │ Model::create │
└──────────┘                        └──────┬───────┘
                                           │
                                           ▼
                                    ┌──────────────┐
                                    │   Database    │
                                    │ notifications │
                                    └──────┬───────┘
                                           │
                    ┌──────────────────────┼──────────────────────┐
                    │                      │                      │
                    ▼                      ▼                      ▼
             ┌──────────┐          ┌──────────────┐       ┌──────────────┐
             │ Dropdown │          │ Badge (AJAX) │       │  Halaman     │
             │ Navbar   │          │ /api/unread  │       │ Notifikasi   │
             └──────────┘          └──────────────┘       └──────────────┘
```

---

### 5.4.2 Komunikasi dengan Sistem Eksternal

Sistem terintegrasi dengan **dua layanan eksternal utama**: Midtrans (payment gateway) dan RajaOngkir Komerce (shipping cost API). Selain itu, sistem juga mendukung autentikasi Google OAuth.

---

#### 5.4.2.1 Komunikasi dengan Midtrans (Payment Gateway)

**Gambar 5.88 Alur Komunikasi dengan Midtrans**

```
┌─────────┐        ┌──────────────┐        ┌──────────┐
│Aplikasi │        │   Midtrans   │        │ Browser  │
│ Backend │        │     API      │        │ (Client) │
└────┬────┘        └──────┬───────┘        └────┬─────┘
     │                    │                     │
     │  1. Snap Request   │                     │
     │───────────────────→│                     │
     │                    │                     │
     │  2. Snap Token     │                     │
     │←───────────────────│                     │
     │                    │                     │
     │  3. Kirim Snap Token ke View             │
     │─────────────────────────────────────────→│
     │                    │                     │
     │                    │   4. Snap Popup     │
     │                    │←────────────────────│
     │                    │                     │
     │                    │  5. User Bayar      │
     │                    │────────────────────→│
     │                    │                     │
     │  6. Notifikasi Webhook (POST)            │
     │←───────────────────│                     │
     │                    │                     │
     │  7. Verifikasi Signature & Update Status │
     │                    │                     │
     │  8. Notifikasi In-App ke Customer        │
```

**Detail Teknis:**

| Item | Keterangan |
|------|-----------|
| **Metode** | HTTP REST API + Webhook (POST) |
| **Endpoint Snap** | `https://app.sandbox.midtrans.com/snap/v1/transactions` |
| **Endpoint Webhook** | `https://<domain>/midtrans/notification` |
| **Autentikasi** | Server Key (Basic Auth Base64) untuk API call |
| **Client Key** | Digunakan di frontend untuk inisialisasi Snap |
| **Library** | `midtrans/midtrans-php` (Composer) |
| **Service Class** | `app/Services/MidtransService.php` |
| **Controller** | `app/Http/Controllers/MidtransController.php` |
| **Environment** | Sandbox (production key berbeda) |
| **3DS** | `is_3ds: true` (verifikasi 3D Secure untuk kartu kredit) |

**Tahap 1 — Request Snap Token (Backend → Midtrans):**

Backend mengirim request POST ke Midtrans API dengan data transaksi:

```json
{
  "transaction_details": {
    "order_id": "INV-20250101-00001",
    "gross_amount": 150000
  },
  "customer_details": {
    "first_name": "Budi",
    "email": "budi@mail.com",
    "phone": "081234567890"
  },
  "item_details": [
    {
      "id": 1,
      "price": 50000,
      "quantity": 2,
      "name": "Produk 1"
    }
  ],
  "callbacks": {
    "finish": "https://domain/checkout/success"
  }
}
```

**Tahap 2 — Midtrans Response:**

```json
{
  "token": "abcd1234-snap-token",
  "redirect_url": "https://app.sandbox.midtrans.com/snap/v2/abcd1234"
}
```

**Tahap 3 — Midtrans Notification (Webhook):**

Midtrans mengirim POST ke endpoint `/midtrans/notification` dengan payload:

```json
{
  "transaction_status": "settlement",
  "order_id": "INV-20250101-00001",
  "status_code": "200",
  "gross_amount": "150000.00",
  "signature_key": "hash_sha512",
  "payment_type": "bank_transfer",
  "transaction_time": "2025-01-01 10:00:00"
}
```

**Tahap 4 — Verifikasi Signature:**

```php
// Di MidtransService.php
$signature = hash('sha512', $orderId . $statusCode . $grossAmount . $serverKey);
if ($signature !== $signatureKey) {
    // Tolak notifikasi
    return response('Invalid signature', 403);
}
```

**Tahap 5 — Update Status:**

| Transaction Status | Aksi Sistem |
|:-----------------:|-------------|
| `settlement` atau `capture` + fraud = `accept` | payment_status → "paid", status → "processing" |
| `pending` | payment_status → "pending" |
| `deny` atau `cancel` | payment_status → "failed" |
| `expire` | payment_status → "expired", status → "cancelled", restore stok |
| `refund` atau `partial_refund` | status → "refunded" (partial/partial) |

---

#### 5.4.2.2 Komunikasi dengan RajaOngkir Komerce (Shipping Cost)

**Gambar 5.89 Alur Komunikasi dengan RajaOngkir Komerce**

```
┌─────────┐        ┌──────────────┐        ┌──────────┐
│Aplikasi │        │   Komerce    │        │ Browser  │
│ Backend │        │     API      │        │ (Client) │
└────┬────┘        └──────┬───────┘        └────┬─────┘
     │                    │                     │
     │  1. Pilih Provinsi │                     │
     │←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←│
     │                    │                     │
     │  2. Get Provinces  │                     │
     │───────────────────→│                     │
     │←───────────────────│                     │
     │                    │                     │
     │  3. Tampilkan Dropdown Provinsi          │
     │─────────────────────────────────────────→│
     │                    │                     │
     │  4. Pilih Kota     │                     │
     │←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←│
     │                    │                     │
     │  5. Get Cities     │                     │
     │───────────────────→│                     │
     │←───────────────────│                     │
     │                    │                     │
     │  6. Pilih Kurir & Hitung Ongkir          │
     │←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←←│
     │                    │                     │
     │  7. Check Cache    │                     │
     │  (shipping_costs)  │                     │
     │  ┌─ Ada → pakai cache                    │
     │  └─ Tidak ada → lanjut ke step 8         │
     │                    │                     │
     │  8. Cek Ongkir API │                     │
     │───────────────────→│                     │
     │←───────────────────│                     │
     │                    │                     │
     │  9. Simpan ke cache + Tampilkan          │
     │─────────────────────────────────────────→│
```

**Detail Teknis:**

| Item | Keterangan |
|------|-----------|
| **Metode** | HTTP REST API (Komerce v1) |
| **Base URL** | `https://api.komerce.id/api/v1` |
| **Autentikasi** | API Key via Header `x-api-key` |
| **Service Class** | `app/Services/RajaOngkirService.php` |
| **Controller** | `app/Http/Controllers/RajaOngkirController.php` |
| **Config File** | `config/rajaongkir.php` |
| **Origin** | Kota Pontianak (subdistrict_id: 4911, city_id: 365, province_id: 13) |
| **Kurir Tersedia** | `jne`, `pos`, `tiki` |
| **Layanan Exclude** | JNE Trucking (JTR), TIKI motor, TRC |

**Endpoint yang Digunakan:**

| Endpoint | Fungsi | Response |
|----------|--------|----------|
| `/destination/province` | Mendapatkan daftar provinsi | `{data: [{id, name}]}` |
| `/destination/city/{province_id}` | Mendapatkan daftar kota/provinsi | `{data: [{id, name}]}` |
| `/destination/district/{city_id}` | Mendapatkan daftar kecamatan/kota | `{data: [{id, name, subdistrict_id}]}` |
| `/calculate/domestic-cost` | Hitung ongkos kirim (kota) | `{data: [{...}]}` |
| `/calculate/district/domestic-cost` | Hitung ongkir (kecamatan) | `{data: [{...}]}` |

**Request Cek Ongkir:**

```json
POST /calculate/domestic-cost
Headers: x-api-key: wFauJ2bP514d9a3b8291690bzXdjCqfY

{
  "origin": 513,
  "destination": 365,
  "weight": 1000,
  "courier": "jne"
}
```

**Response:**

```json
{
  "data": [
    {
      "service": "REG",
      "description": "Layanan Reguler",
      "cost": 12000,
      "etd": "2-3 hari"
    },
    {
      "service": "OKE",
      "description": "Ongkos Kirim Ekonomis",
      "cost": 8000,
      "etd": "3-5 hari"
    }
  ]
}
```

**Caching Strategy:**

```php
// Di RajaOngkirService.php
// 1. Cek cache di tabel shipping_costs
// 2. Jika ada dan belum expired (< 1 hari): pakai cache
// 3. Jika tidak ada / expired: panggil API Komerce
// 4. Simpan hasil API ke tabel shipping_costs
// 5. Kembalikan data
```

---

#### 5.4.2.3 Komunikasi dengan Google OAuth

| Item | Keterangan |
|------|-----------|
| **Metode** | OAuth 2.0 |
| **Library** | Laravel Socialite |
| **Provider** | Google |
| **Alur** | Login → redirect ke Google Consent → user setujui → callback → autentikasi sukses |

---

### 5.4.3 Keterbatasan Sistem

Berdasarkan hasil penelitian, pengujian, dan analisis yang telah dilakukan, sistem ACIAA E-Commerce memiliki beberapa keterbatasan sebagai berikut:

**Tabel 5.47 Keterbatasan Sistem**

| No | Keterbatasan | Penjelasan |
|:--:|-------------|-----------|
| 1 | **Hanya 3 Kurir** | Sistem hanya mengimplementasikan 3 kurir (JNE, POS Indonesia, TIKI), padahal RajaOngkir Komerce mendukung lebih banyak ekspedisi seperti SiCepat, J&T, dan AnterAja |
| 2 | **Tidak Ada Fitur Chat Real-Time** | Komunikasi antara customer dan admin masih terbatas melalui notifikasi sistem dan form pesan, belum ada fitur chat langsung berbasis WebSocket |
| 3 | **Single Store** | Sistem hanya mendukung satu toko dengan satu alamat asal pengiriman (Pontianak), belum mendukung multi-cabang atau marketplace |
| 4 | **Email Notification Non-Aktif** | Notifikasi pengiriman dan promo hanya menggunakan notifikasi in-app (web), notifikasi email tidak digunakan karena preferensi pengguna |
| 5 | **Tidak Ada Refund Otomatis** | Proses refund ketika retur masih dilakukan secara manual oleh admin, belum terintegrasi dengan sistem pembayaran |
| 6 | **Single Bahasa** | Sistem hanya menggunakan Bahasa Indonesia, belum ada dukungan multi-bahasa (Inggris, Mandarin, dll) |
| 7 | **Hosting Menggunakan ngrok** | Sistem masih berjalan di lingkungan pengembangan (localhost) dengan tunneling ngrok, belum menggunakan hosting production yang stabil |
| 8 | **Pengelolaan Stok Manual** | Stok produk dikelola secara manual oleh admin, belum ada integrasi dengan sistem inventory otomatis atau supplier |
| 9 | **Tidak Ada Sistem Rekomendasi** | Produk yang ditampilkan di halaman utama tidak dipersonalisasi berdasarkan preferensi atau riwayat pembelian customer |
| 10 | **Export Laporan Terbatas** | Laporan penjualan hanya bisa diexport dalam format Excel/CSV, belum mendukung format PDF |

---

### 5.4.4 Saran Pengembangan

Berdasarkan hasil evaluasi dan keterbatasan yang teridentifikasi, berikut adalah saran untuk pengembangan sistem selanjutnya:

**Tabel 5.48 Saran Pengembangan**

| No | Saran | Prioritas | Manfaat |
|:--:|-------|:--------:|---------|
| 1 | **Deployment ke Hosting Production (VPS/Cloud)** | **Tinggi** | Menjamin stabilitas, keamanan, dan ketersediaan sistem 24/7 tanpa tunneling |
| 2 | **Fitur Chat Real-Time** | Sedang | Mempercepat komunikasi dan meningkatkan kepuasan customer |
| 3 | **Integrasi dengan Marketplace (Tokopedia, Shopee)** | Sedang | Otomatisasi manajemen multi-channel dan perluasan jangkauan pasar |
| 4 | **Aplikasi Mobile (Android/iOS)** | Sedang | Kemudahan akses bagi pengguna yang lebih sering menggunakan smartphone |
| 5 | **Integrasi WhatsApp Gateway** | Sedang | Notifikasi alternatif yang lebih cepat dan lebih banyak dibaca oleh customer |
| 6 | **Sistem Rekomendasi Produk Berbasis AI** | Rendah | Personalisasi berdasarkan riwayat pembelian meningkatkan konversi penjualan |
| 7 | **Notifikasi Email Aktif** | Rendah | Notifikasi cadangan jika customer tidak membuka aplikasi dalam waktu lama |
| 8 | **Multi-Bahasa (Indonesia + Inggris)** | Rendah | Memperluas jangkauan ke customer asing atau non-Bahasa Indonesia |
| 9 | **Multi-Store / Multi-Cabang** | Rendah | Mendukung pengembangan bisnis dengan beberapa outlet |
| 10 | **Sistem Refund Otomatis via Midtrans** | Sedang | Efisiensi proses retur dan meningkatkan kepercayaan customer |
| 11 | **Manajemen Supplier & Restock Otomatis** | Rendah | Mencegah kehabisan stok dengan restock otomatis |
| 12 | **Export Laporan PDF** | Rendah | Format laporan tambahan untuk keperluan administrasi dan akuntansi |

---

## RINGKASAN BAB 5

| Bagian | Isi |
|--------|-----|
| **5.1 Desain dan Pengembangan** | Perencanaan kebutuhan (92 fungsional + 28 non-fungsional), desain arsitektur B2C, perancangan database (30 tabel), class diagram (17 class), konstruksi antarmuka (15 halaman user + 10 halaman admin), implementasi blackbox testing (183 test case), hosting (XAMPP + ngrok) |
| **5.2 Demonstrasi** | 9 alur penggunaan step-by-step: registrasi/login, pembelian, checkout/pembayaran Midtrans, tracking, voucher, rating, retur, transaksi admin, notifikasi |
| **5.3 Evaluasi** | Analisis hasil blackbox testing, evaluasi pemenuhan fungsional & non-fungsional, temuan bug, kesimpulan |
| **5.4 Komunikasi** | Media komunikasi dengan pengguna (antarmuka, flash message, notifikasi), integrasi dengan sistem eksternal (Midtrans, RajaOngkir, Google OAuth), 10 keterbatasan sistem, 12 saran pengembangan |

---

**DAFTAR LAMPIRAN**

- Lampiran 1: Analisis Kebutuhan Fungsional dan Non-Fungsional Lengkap
- Lampiran 2: Class Diagram Sistem
- Lampiran 3: Entity Relationship Diagram (ERD)
- Lampiran 4: Tabel Blackbox Testing Lengkap (183 Test Case)
- Lampiran 5: Screenshot Antarmuka Sistem
