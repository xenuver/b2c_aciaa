# ANALISIS KEBUTUHAN FUNGSIONAL & NON-FUNGSIONAL
## ACIAA E-Commerce

---

## A. KEBUTUHAN FUNGSIONAL (Functional Requirements)

Kebutuhan fungsional menggambarkan fitur-fitur spesifik yang harus dimiliki sistem berdasarkan hasil analisis sistem yang telah dibangun.

### A.1 Modul Autentikasi & Manajemen Pengguna

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-01 | Registrasi Akun | Customer | Sistem menyediakan halaman registrasi bagi pengguna baru untuk mendaftar dengan mengisi nama, email, password |
| F-02 | Login Akun | Customer, Admin | Sistem menyediakan autentikasi login berbasis email dan password |
| F-03 | Login dengan Google | Customer | Sistem mendukung autentikasi menggunakan akun Google (OAuth) |
| F-04 | Logout Akun | Customer, Admin | Sistem menyediakan fitur logout untuk mengakhiri sesi |
| F-05 | Reset Password | Customer | Sistem menyediakan fitur lupa password melalui email |
| F-06 | Edit Profil | Customer | Sistem memungkinkan pengguna mengubah nama, email, nomor telepon, dan avatar |
| F-07 | Hapus Akun | Customer | Sistem memungkinkan pengguna menghapus akun mereka |
| F-08 | Manajemen Role User | Admin | Sistem membedakan role user menjadi `admin` dan `customer` |
| F-09 | Kelola Data User | Admin | Admin dapat melihat daftar user, detail, mengedit status aktif/nonaktif, dan menghapus user |

### A.2 Modul Manajemen Produk & Kategori

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

### A.3 Modul Manajemen Banner

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-21 | Lihat Banner | Customer | Sistem menampilkan banner slider di halaman landing dan home berdasarkan jadwal tayang |
| F-22 | CRUD Banner | Admin | Admin dapat menambah, melihat, mengedit, dan menghapus banner dengan gambar dan tautan |
| F-23 | Atur Jadwal Banner | Admin | Admin dapat mengatur tanggal mulai dan berakhir penayangan banner |

### A.4 Modul Keranjang Belanja (Cart)

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-24 | Tambah ke Keranjang | Customer | Sistem memungkinkan customer menambahkan produk ke keranjang |
| F-25 | Lihat Keranjang | Customer | Sistem menampilkan daftar produk dalam keranjang dengan jumlah, harga, dan total |
| F-26 | Ubah Jumlah Item | Customer | Sistem memungkinkan customer mengubah kuantitas item di keranjang |
| F-27 | Hapus Item Keranjang | Customer | Sistem memungkinkan customer menghapus item dari keranjang |
| F-28 | Hitung Jumlah Item | Customer | Sistem menampilkan badge jumlah item keranjang di navbar (AJAX) |

### A.5 Modul Wishlist

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-29 | Tambah/Hapus Wishlist | Customer | Sistem memungkinkan customer menambahkan atau menghapus produk dari wishlist (toggle AJAX) |
| F-30 | Lihat Wishlist | Customer | Sistem menampilkan daftar produk yang disimpan di wishlist |
| F-31 | Hapus Wishlist | Customer | Sistem memungkinkan customer menghapus item wishlist satu per satu |
| F-32 | Hitung Wishlist | Customer | Sistem menampilkan badge jumlah wishlist di navbar (AJAX) |

### A.6 Modul Checkout & Transaksi

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

### A.7 Modul Voucher & Diskon

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-50 | Lihat Daftar Voucher | Customer, Guest | Sistem menampilkan voucher yang tersedia untuk diklaim |
| F-51 | Klaim Voucher | Customer | Sistem memungkinkan customer mengklaim voucher untuk digunakan nanti |
| F-52 | CRUD Voucher | Admin | Admin dapat menambah, melihat, mengedit, dan menghapus voucher |
| F-53 | Atur Tipe Voucher | Admin | Admin dapat memilih tipe voucher: `percentage`, `fixed`, atau `free_shipping` |
| F-54 | Atur Batasan Voucher | Admin | Admin dapat mengatur minimal belanja, minimal qty, maksimal diskon, kuota pemakaian, dan masa berlaku |
| F-55 | Lihat Log Penggunaan Voucher | Admin | Admin dapat melihat riwayat penggunaan voucher per transaksi |

### A.8 Modul Rating & Ulasan

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

### A.9 Modul Retur

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-64 | Ajukan Retur | Customer | Sistem memungkinkan customer mengajukan retur untuk item dalam transaksi |
| F-65 | Pilih Alasan Retur | Customer | Customer dapat memilih alasan: produk cacat, salah barang, tidak sesuai deskripsi, masalah ukuran, lainnya |
| F-66 | Upload Bukti Retur | Customer | Sistem memungkinkan customer mengunggah foto bukti retur |
| F-67 | Batalkan Retur | Customer | Sistem memungkinkan customer membatalkan pengajuan retur |
| F-68 | Lihat Retur | Customer | Sistem menampilkan status pengajuan retur |
| F-69 | Kelola Retur | Admin | Admin dapat menyetujui, menolak, atau menyelesaikan retur |
| F-70 | Catatan Admin Retur | Admin | Admin dapat memberikan catatan saat menyetujui/menolak retur |

### A.10 Modul Pengiriman & Tracking

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-71 | Update Status Pesanan | Admin | Admin dapat mengubah status pesanan (pending → processing → shipped → delivered) |
| F-72 | Update Status Pembayaran | Admin | Admin dapat mengubah status pembayaran secara manual |
| F-73 | Input Nomor Resi | Admin | Admin dapat memasukkan nomor resi pengiriman |
| F-74 | Tracking URL Otomatis | System | Sistem membuat URL tracking berdasarkan kurir yang dipilih |
| F-75 | Kirim Notifikasi Email Resi | System | Sistem mengirim email notifikasi ke customer saat resi diinput |
| F-76 | Lihat Tracking Pengiriman | Customer | Sistem menampilkan nomor resi dan link tracking di detail transaksi |

### A.11 Modul Dashboard Admin

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
| F-85 | Export Laporan | Admin | Sistem memungkinkan export laporan penjualan |

### A.12 Modul Notifikasi

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-86 | Notifikasi In-App | Customer | Sistem menampilkan notifikasi dalam aplikasi untuk update pesanan |
| F-87 | Tandai Notifikasi Dibaca | Customer | Sistem memungkinkan customer menandai notifikasi sudah dibaca |
| F-88 | Pengaturan Notifikasi | Customer | Customer dapat mengatur preferensi notifikasi (email/push untuk order/promosi) |
| F-89 | Kirim Email Promosi | System | Sistem mendukung pengiriman email promosi ke customer |
| F-90 | Kirim Pesan Customer Service | Customer | Customer dapat mengirim pesan (komplain, pertanyaan, saran) ke admin |

### A.13 Modul Logging & Keamanan

| Kode | Kebutuhan Fungsional | Aktor | Deskripsi |
|------|---------------------|-------|-----------|
| F-91 | Catat Aktivitas Admin | System | Sistem mencatat log aktivitas admin (aksi, modul, data lama, data baru) |
| F-92 | Pengaturan Toko | Admin | Admin dapat mengatur pengaturan toko berbasis key-value |

---

## B. KEBUTUHAN NON-FUNGSIONAL (Non-Functional Requirements)

Kebutuhan non-fungsional menggambarkan atribut kualitas sistem yang harus dipenuhi.

### B.1 Keamanan (Security)

| Kode | Kebutuhan Non-Fungsional | Deskripsi |
|------|-------------------------|-----------|
| NF-01 | Autentikasi User | Sistem mewajibkan autentikasi untuk mengakses fitur customer (keranjang, checkout, transaksi) dan admin |
| NF-02 | Otorisasi Role | Sistem membatasi akses halaman admin hanya untuk user dengan role `admin` melalui AdminMiddleware |
| NF-03 | Proteksi Route | Sistem menggunakan middleware `auth` dan `admin` untuk melindungi route dari akses tidak sah |
| NF-04 | Validasi Input | Sistem melakukan validasi data input pada setiap form untuk mencegah injeksi data berbahaya |
| NF-05 | CSRF Protection | Sistem menggunakan proteksi CSRF Laravel pada semua form |
| NF-06 | Password Terenkripsi | Sistem menyimpan password user dalam bentuk hash (bcrypt) |
| NF-07 | Verifikasi Signature Midtrans | Sistem memverifikasi signature key pada notifikasi Midtrans untuk mencegah notifikasi palsu |

### B.2 Performa (Performance)

| Kode | Kebutuhan Non-Fungsional | Deskripsi |
|------|-------------------------|-----------|
| NF-08 | Waktu Respons Halaman | Sistem merender halaman dalam waktu < 3 detik untuk halaman frontend |
| NF-09 | Caching Ongkos Kirim | Sistem menyimpan hasil perhitungan ongkos kirim ke database (tabel `shipping_costs`) untuk menghindari panggilan API berulang |
| NF-10 | Caching Data Lokasi | Sistem menyimpan data kecamatan (subdistricts) dari API Komerce ke database lokal |
| NF-11 | Penggunaan Database Index | Sistem menggunakan index pada kolom yang sering dicari (email, slug, user_id, dll) |

### B.3 Keandalan (Reliability)

| Kode | Kebutuhan Non-Fungsional | Deskripsi |
|------|-------------------------|-----------|
| NF-12 | Konsistensi Transaksi | Sistem menggunakan database transaction (`DB::beginTransaction`/`commit`/`rollBack`) untuk menjaga konsistensi data pada proses checkout |
| NF-13 | Restore Stok Otomatis | Sistem mengembalikan stok produk secara otomatis jika transaksi dibatalkan/expired |
| NF-14 | Penanganan Error | Sistem menangani error dengan try-catch dan mencatatnya ke log |
| NF-15 | Validasi Stok Sebelum Checkout | Sistem memastikan stok mencukupi sebelum mengurangi stok (decreaseStock saat checkout) |

### B.4 Kegunaan (Usability)

| Kode | Kebutuhan Non-Fungsional | Deskripsi |
|------|-------------------------|-----------|
| NF-16 | Antarmuka Responsif | Sistem menggunakan Tailwind CSS untuk tampilan yang responsif di berbagai ukuran layar |
| NF-17 | Notifikasi Feedback | Sistem menampilkan pesan sukses/error setelah setiap aksi (flash message session) |
| NF-18 | Navigasi Breadcrumb | Sistem menyediakan navigasi breadcrumb untuk memudahkan user mengetahui posisi halaman |
| NF-19 | Informasi Stok | Sistem menampilkan informasi ketersediaan stok pada halaman produk |

### B.5 Kompatibilitas (Compatibility)

| Kode | Kebutuhan Non-Fungsional | Deskripsi |
|------|-------------------------|-----------|
| NF-20 | Dukungan Browser Modern | Sistem mendukung browser terkini (Chrome, Firefox, Edge, Safari) |
| NF-21 | Integrasi Payment Gateway | Sistem terintegrasi dengan Midtrans Snap yang mendukung berbagai metode pembayaran (transfer bank, kartu kredit, e-wallet) |
| NF-22 | Integrasi Shipping API | Sistem terintegrasi dengan RajaOngkir API (Komerce) untuk perhitungan ongkos kirim real-time dengan 3 kurir: JNE, POS Indonesia, TIKI |

### B.6 Skalabilitas (Scalability)

| Kode | Kebutuhan Non-Fungsional | Deskripsi |
|------|-------------------------|-----------|
| NF-23 | Arsitektur MVC | Sistem menggunakan arsitektur Model-View-Controller yang memisahkan logika bisnis, data, dan tampilan |
| NF-24 | Penggunaan Service Layer | Sistem memisahkan logika bisnis kompleks ke dalam service class (MidtransService, RajaOngkirService) |
| NF-25 | Pagination | Sistem menggunakan pagination untuk daftar produk dan transaksi yang panjang |

### B.7 Maintainability

| Kode | Kebutuhan Non-Fungsional | Deskripsi |
|------|-------------------------|-----------|
| NF-26 | Konfigurasi Terpusat | Sistem menggunakan file `.env` dan config untuk menyimpan konfigurasi (API key, database, mail) |
| NF-27 | Struktur Database Terdokumentasi | Sistem memiliki migration file yang mendokumentasikan skema database |
| NF-28 | Logging | Sistem mencatat error dan aktivitas penting ke dalam log file (storage/logs) |

---

## C. KESIAPAN IMPLEMENTASI

Berdasarkan analisis di atas, dari **92 kebutuhan fungsional** dan **28 kebutuhan non-fungsional** yang teridentifikasi:

- **100% kebutuhan fungsional** telah diimplementasikan dalam sistem
- **100% kebutuhan non-fungsional** telah dipenuhi oleh arsitektur sistem

Sistem ACIAA E-Commerce telah memenuhi seluruh kebutuhan sebagai platform e-commerce yang lengkap dengan fitur manajemen produk, transaksi, pembayaran Midtrans, ongkos kirim RajaOngkir, voucher diskon, rating ulasan, retur barang, notifikasi, dan laporan keuangan.
