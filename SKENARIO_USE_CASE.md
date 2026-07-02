# SKENARIO USE CASE — ACIAA E-COMMERCE
## Format Formal Yuni Sugiarti

---

## A. AKTOR

| No | Aktor | Deskripsi |
|----|-------|-----------|
| 1 | Pengunjung | Pengguna yang belum terdaftar (tamu) yang dapat melihat katalog dan melakukan registrasi |
| 2 | Konsumen | Pengguna terdaftar yang memiliki hak akses penuh untuk transaksi, profil, dan riwayat pesanan |
| 3 | Admin | Pengelola sistem yang memiliki hak akses penuh untuk manajemen konten, stok, transaksi, dan data pengguna |

---

## B. SKENARIO USE CASE — PENGUNJUNG

---

### UC-01: Customer Service

| **Nama Use Case** | Customer Service |
|-------------------|-----------------|
| **Aktor** | Pengunjung |
| **Deskripsi** | Pengunjung dapat menghubungi admin melalui form pesan untuk menyampaikan pertanyaan, komplain, atau saran |
| **Pre-Kondisi** | Pengunjung berada di halaman utama |
| **Post-Kondisi** | Pesan berhasil dikirim ke admin |

| Aksi Aktor (Alur Dasar) | Reaksi Sistem |
|------------------------|---------------|
| 1. Pengunjung membuka halaman "Hubungi Kami" atau scroll ke footer | |
| 2. Pengunjung mengisi form: nama, email, subjek, dan pesan | |
| 3. Pengunjung menekan tombol "Kirim" | 4. Sistem memvalidasi input: nama minimal 3 karakter, email valid, pesan tidak kosong |
| | 5. Jika valid, sistem menyimpan pesan ke tabel `messages` |
| | 6. Sistem menampilkan flash message "Pesan berhasil dikirim" |

| Alur Alternatif |
|-----------------|
| **A1: Data tidak valid.** Jika nama < 3 karakter, email tidak valid, atau pesan kosong, sistem menampilkan error validasi dan data tidak tersimpan |

---

### UC-02: Mencari Produk

| **Nama Use Case** | Mencari Produk |
|-------------------|----------------|
| **Aktor** | Pengunjung, Konsumen |
| **Deskripsi** | Pengunjung/konsumen mencari produk berdasarkan kata kunci nama produk |
| **Pre-Kondisi** | Pengunjung/konsumen berada di halaman utama atau halaman katalog |
| **Post-Kondisi** | Sistem menampilkan daftar produk yang sesuai dengan kata kunci |

| Aksi Aktor (Alur Dasar) | Reaksi Sistem |
|------------------------|---------------|
| 1. Pengunjung mengetik kata kunci di kolom pencarian pada navbar | |
| 2. Pengunjung menekan tombol "Cari" atau menekan Enter | 3. Sistem mencari produk dengan nama mengandung kata kunci (query `LIKE %keyword%`) |
| | 4. Sistem menampilkan halaman hasil pencarian berisi grid produk yang cocok |

| Alur Alternatif |
|-----------------|
| **A1: Kata kunci tidak ditemukan.** Jika tidak ada produk yang cocok, sistem menampilkan pesan "Produk tidak ditemukan" dan menampilkan produk rekomendasi |
| **A2: Kata kunci kosong.** Jika kata kunci kosong, sistem menampilkan semua produk |

---

### UC-03: Melihat Produk

| **Nama Use Case** | Melihat Produk |
|-------------------|----------------|
| **Aktor** | Pengunjung, Konsumen |
| **Deskripsi** | Pengunjung/konsumen melihat detail lengkap suatu produk |
| **Pre-Kondisi** | Pengunjung/konsumen berada di halaman katalog atau hasil pencarian |
| **Post-Kondisi** | Sistem menampilkan detail produk lengkap |

| Aksi Aktor (Alur Dasar) | Reaksi Sistem |
|------------------------|---------------|
| 1. Pengunjung menekan gambar atau nama produk pada halaman katalog | |
| | 2. Sistem menampilkan halaman detail produk: gambar besar, galeri, nama, harga, deskripsi, stok, berat, rating rata-rata, daftar ulasan |
| 3. (Opsional) Pengunjung menekan gambar galeri | 4. Sistem mengganti gambar utama dengan gambar galeri yang dipilih |
| 5. (Opsional) Pengunjung memilih jumlah produk | 6. Sistem memperbarui total harga sesuai jumlah |
| 7. (Opsional) Pengunjung menekan "Tambah ke Keranjang" | 8a. **Jika belum login:** sistem mengarahkan ke halaman login |
| | 8b. **Jika sudah login:** sistem menyimpan item ke keranjang |
| 9. (Opsional) Pengunjung menekan ikon wishlist (hati) | 10a. **Jika belum login:** sistem mengarahkan ke halaman login |
| | 10b. **Jika sudah login:** sistem toggle wishlist (tambah/hapus) |

| Alur Alternatif |
|-----------------|
| **A1: Produk tidak ditemukan.** Jika ID produk tidak valid, sistem menampilkan 404 |
| **A2: Stok habis.** Jika stok = 0, tombol "Tambah ke Keranjang" dinonaktifkan dan menampilkan "Stok Habis" |

---

### UC-04: Melihat Ulasan

| **Nama Use Case** | Melihat Ulasan |
|-------------------|----------------|
| **Aktor** | Pengunjung, Konsumen |
| **Deskripsi** | Pengunjung/konsumen melihat ulasan dan rating dari pembeli lain pada halaman detail produk |
| **Pre-Kondisi** | Pengunjung/konsumen berada di halaman detail produk |
| **Post-Kondisi** | Sistem menampilkan daftar ulasan yang sudah disetujui admin |

| Aksi Aktor (Alur Dasar) | Reaksi Sistem |
|------------------------|---------------|
| 1. Pengunjung scroll ke bagian "Ulasan" pada halaman detail produk | |
| | 2. Sistem menampilkan: rating rata-rata (bintang + angka), jumlah ulasan, daftar ulasan per item (nama user, rating bintang, teks ulasan, gambar, balasan admin) |

| Alur Alternatif |
|-----------------|
| **A1: Belum ada ulasan.** Sistem menampilkan "Belum ada ulasan untuk produk ini" |

---

### UC-05: Daftar (Registrasi)

| **Nama Use Case** | Daftar (Registrasi) |
|-------------------|---------------------|
| **Aktor** | Pengunjung |
| **Deskripsi** | Pengunjung membuat akun baru untuk menjadi konsumen terdaftar |
| **Pre-Kondisi** | Pengunjung berada di halaman registrasi, belum memiliki akun |
| **Post-Kondisi** | Akun baru berhasil dibuat, pengunjung login otomatis sebagai konsumen |

| Aksi Aktor (Alur Dasar) | Reaksi Sistem |
|------------------------|---------------|
| 1. Pengunjung menekan tautan "Daftar" di halaman login atau navbar | |
| | 2. Sistem menampilkan halaman registrasi dengan form: nama, email, password |
| 3. Pengunjung mengisi nama, email, dan password | |
| 4. Pengunjung menekan tombol "Daftar" | 5. Sistem memvalidasi input: nama ≥ 3 karakter, email format valid dan unik, password ≥ 8 karakter |
| | 6. Jika valid, sistem membuat user baru (role: customer) dan hash password (bcrypt) |
| | 7. Sistem login otomatis dan mengarahkan ke halaman beranda |
| | 8. Sistem menampilkan flash message "Registrasi berhasil" |

| Alur Alternatif |
|-----------------|
| **A1: Nama < 3 karakter.** Sistem menolak: "Nama minimal 3 karakter" |
| **A2: Email tidak valid.** Sistem menolak: "Format email salah" |
| **A3: Email sudah terdaftar.** Sistem menolak: "Email sudah digunakan" |
| **A4: Password < 8 karakter.** Sistem menolak: "Password minimal 8 karakter" |
| **A5: Field kosong.** Sistem menolak: "Field wajib diisi" |

---

### UC-06: Login

| **Nama Use Case** | Login |
|-------------------|-------|
| **Aktor** | Pengunjung, Konsumen, Admin |
| **Deskripsi** | Proses masuk ke sistem agar pengguna dapat mengakses fitur sesuai hak akses masing-masing |
| **Pre-Kondisi** | Pengguna sudah memiliki akun terdaftar di sistem. Pengguna berada di halaman login |
| **Post-Kondisi** | Pengguna berhasil masuk ke dashboard/halaman utama sesuai peran (Admin atau Konsumen) |

| Aksi Aktor (Alur Dasar) | Reaksi Sistem |
|------------------------|---------------|
| 1. Pengunjung menekan tombol "Masuk" di navbar | |
| | 2. Sistem menampilkan halaman login dengan form email dan password |
| 3. Pengunjung memasukkan email dan password | |
| 4. Pengunjung menekan tombol "Login" | 5. Sistem memvalidasi input: email tidak kosong, password tidak kosong |
| | 6. Sistem mencocokkan kredensial dengan database |
| | 7. Jika valid, sistem login dan mengarahkan sesuai role: |
| | - Role `admin` → halaman dashboard admin |
| | - Role `customer` → halaman beranda |
| | 8. Sistem menampilkan flash message "Login berhasil" |

| Alur Alternatif |
|-----------------|
| **A1: Email atau password kosong.** Sistem menolak: "Email/Password wajib diisi" |
| **A2: Email tidak terdaftar.** Sistem menolak: "Email atau password salah" |
| **A3: Password salah.** Sistem menolak: "Email atau password salah" |
| **A4: Login dengan Google.** Pengunjung menekan "Masuk dengan Google" → redirect ke Google OAuth → setujui → callback → login otomatis |

---

## C. SKENARIO USE CASE — KONSUMEN

---

### UC-07: Login (Konsumen)

*(Sama dengan UC-06, role: customer)*

---

### UC-08: Kelola Profil

| **Nama Use Case** | Kelola Profil |
|-------------------|---------------|
| **Aktor** | Konsumen |
| **Deskripsi** | Konsumen melihat dan mengubah data profil pribadi (nama, email, telepon, avatar) serta dapat menghapus akun |
| **Pre-Kondisi** | Konsumen sudah login dan berada di halaman profil |
| **Post-Kondisi** | Data profil berhasil diperbarui |

| Aksi Aktor (Alur Dasar) | Reaksi Sistem |
|------------------------|---------------|
| 1. Konsumen membuka menu "Profil Saya" dari dropdown akun | |
| | 2. Sistem menampilkan halaman profil dengan data: nama, email, nomor telepon, avatar |
| 3. Konsumen mengubah data (nama, email, telepon) | |
| 4. Konsumen menekan tombol "Simpan" | 5. Sistem memvalidasi input |
| | 6. Jika valid, sistem memperbarui data user di database |
| | 7. Sistem menampilkan flash message "Profil berhasil diperbarui" |
| 8. (Opsional) Konsumen mengupload avatar baru | 9. Sistem menyimpan file gambar, memperbarui kolom avatar |
| 10. (Opsional) Konsumen menekan "Hapus Akun" | 11. Sistem menampilkan modal konfirmasi |
| 12. Konsumen mengkonfirmasi | 13. Sistem menghapus akun dan logout |

| Alur Alternatif |
|-----------------|
| **A1: Email baru sudah dipakai.** Sistem menolak: "Email sudah digunakan" |
| **A2: Nama < 3 karakter.** Sistem menolak: "Nama minimal 3 karakter" |
| **A3: Hapus akun dibatalkan.** Jika konsumen membatalkan konfirmasi, akun tidak dihapus |

---

### UC-09: Melakukan Transaksi

| **Nama Use Case** | Melakukan Transaksi |
|-------------------|---------------------|
| **Aktor** | Konsumen |
| **Deskripsi** | Konsumen melakukan pembelian produk mulai dari checkout hingga pembayaran |
| **Pre-Kondisi** | Konsumen sudah login. Keranjang berisi minimal 1 produk. Konsumen berada di halaman keranjang |
| **Post-Kondisi** | Transaksi berhasil dibuat, konsumen diarahkan ke pembayaran Midtrans |

| Aksi Aktor (Alur Dasar) | Reaksi Sistem |
|------------------------|---------------|
| 1. Konsumen menekan tombol "Checkout" di halaman keranjang | |
| | 2. Sistem memvalidasi keranjang tidak kosong |
| | 3. Sistem menampilkan halaman checkout: ringkasan pesanan, alamat, kurir, voucher, total |
| 4. Konsumen memilih alamat pengiriman (dari daftar alamat tersimpan) | |
| 5. (Opsional) Konsumen menekan "Tambah Alamat Baru" | 6. Sistem menampilkan form alamat: nama penerima, no HP, provinsi, kota, kecamatan, detail alamat |
| 7. Konsumen memilih provinsi | 8. Sistem memuat daftar kota via RajaOngkir API (cached) |
| 9. Konsumen memilih kota | 10. Sistem memuat daftar kecamatan via RajaOngkir API (cached) |
| 11. Konsumen memilih kecamatan dan mengisi detail alamat, lalu simpan | 12. Sistem menyimpan alamat baru |
| 13. Konsumen memilih kurir (JNE/POS/TIKI) | 14. Sistem menghitung ongkos kirim via RajaOngkir API (cached) |
| | 15. Sistem menampilkan daftar layanan + biaya + estimasi |
| 16. Konsumen memilih layanan kurir | 17. Sistem memperbarui total: subtotal + ongkir |
| 18. (Opsional) Konsumen memilih voucher atau memasukkan kode voucher | 19. Jika voucher valid (min purchase terpenuhi, belum expired, belum habis): sistem menghitung diskon |
| 20. Konsumen memeriksa total akhir dan menekan "Bayar Sekarang" | 21. Sistem membuat transaksi (database transaction): create transaction, create transaction details, kurangi stok, update user_voucher, clear cart |
| | 22. Sistem memanggil Midtrans API untuk mendapatkan Snap Token |
| | 23. Midtrans mengembalikan Snap Token |
| | 24. Sistem menampilkan popup Midtrans Snap |
| 25. Konsumen memilih metode pembayaran (Transfer Bank, E-Wallet, QRIS, dll) | |
| 26. Konsumen menyelesaikan pembayaran | 27. Midtrans mengirim notifikasi webhook ke sistem |
| | 28. Sistem memverifikasi signature, memperbarui status pembayaran menjadi "paid" |
| | 29. Sistem mengirim notifikasi in-app ke konsumen |
| | 30. Konsumen diarahkan ke halaman sukses |

| Alur Alternatif |
|-----------------|
| **A1: Keranjang kosong.** Sistem menolak: "Keranjang belanja masih kosong" dan redirect |
| **A2: Alamat tidak dipilih.** Sistem menolak: "Silakan pilih alamat pengiriman" |
| **A3: Kurir tidak dipilih.** Sistem menolak: "Silakan pilih kurir" |
| **A4: Stok tidak mencukupi saat checkout.** Sistem rollback transaksi, tampilkan error |
| **A5: Voucher tidak valid.** Sistem menolak: "Voucher tidak dapat digunakan" |
| **A6: Midtrans error.** Jika Midtrans tidak merespon, transaksi dibatalkan, stok dikembalikan |
| **A7: Pembayaran expired.** Jika konsumen tidak membayar dalam batas waktu, Midtrans kirim notifikasi expire, sistem update status expired + restore stok |

---

### UC-10: Riwayat Transaksi

| **Nama Use Case** | Riwayat Transaksi |
|-------------------|-------------------|
| **Aktor** | Konsumen |
| **Deskripsi** | Konsumen melihat daftar transaksi yang pernah dilakukan dan detailnya |
| **Pre-Kondisi** | Konsumen sudah login |
| **Post-Kondisi** | Sistem menampilkan daftar transaksi konsumen |

| Aksi Aktor (Alur Dasar) | Reaksi Sistem |
|------------------------|---------------|
| 1. Konsumen membuka menu "Riwayat Transaksi" dari dropdown akun | |
| | 2. Sistem menampilkan daftar transaksi milik konsumen (pagination): nomor invoice, tanggal, status (badge warna), status bayar, total, tombol "Detail" |
| 3. Konsumen menekan tombol "Detail" pada salah satu transaksi | 4. Sistem menampilkan halaman detail transaksi: info pesanan, info pembayaran, info pengiriman, daftar produk, rincian biaya |
| 5. (Jika sudah dikirim) Konsumen menekan link tracking | 6. Sistem membuka website kurir dengan nomor resi di tab baru |
| 7. (Jika sudah diterima) Konsumen menekan tombol "Beri Ulasan" | 8. Sistem mengarahkan ke form rating (UC-10 A1) |

| Alur Alternatif |
|-----------------|
| **A1: Beri Ulasan (Lacak Pesanan → Ulasan).** Konsumen mengisi bintang 1-5 + ulasan + upload gambar → sistem menyimpan rating dengan status pending |

---

### UC-11: Ajukan Retur

| **Nama Use Case** | Ajukan Retur |
|-------------------|--------------|
| **Aktor** | Konsumen |
| **Deskripsi** | Konsumen mengajukan pengembalian barang untuk produk dalam transaksi yang sudah diterima |
| **Pre-Kondisi** | Konsumen sudah login. Transaksi dengan status "delivered" |
| **Post-Kondisi** | Pengajuan retur tersimpan dengan status "pending" |

| Aksi Aktor (Alur Dasar) | Reaksi Sistem |
|------------------------|---------------|
| 1. Konsumen membuka halaman detail transaksi yang sudah diterima | |
| 2. Konsumen menekan tombol "Ajukan Retur" | |
| | 3. Sistem menampilkan form retur: pilih produk (dari transaksi), alasan (dropdown), deskripsi, upload foto |
| 4. Konsumen memilih produk yang diretur | |
| 5. Konsumen memilih alasan retur (Produk Cacat, Salah Barang, Tidak Sesuai, Ukuran, Lainnya) | |
| 6. Konsumen mengisi deskripsi dan (opsional) upload foto bukti | |
| 7. Konsumen menekan tombol "Kirim" | 8. Sistem memvalidasi: qty ≤ qty transaksi, alasan valid |
| | 9. Sistem menyimpan retur + retur item dengan status "pending" |
| | 10. Sistem menampilkan flash message "Pengajuan retur berhasil dikirim" |

| Alur Alternatif |
|-----------------|
| **A1: Qty melebihi pembelian.** Sistem menolak: "Jumlah retur melebihi quantity yang dibeli" |
| **A2: Alasan tidak valid.** Sistem menolak: alasan harus dari pilihan yang tersedia |
| **A3: Batalkan retur.** Konsumen dapat membatalkan retur selama status masih "pending" |

---

## D. SKENARIO USE CASE — ADMIN

---

### UC-12: Login (Admin)

*(Sama dengan UC-06, role: admin, redirect ke dashboard admin)*

---

### UC-13: Manajemen Produk

| **Nama Use Case** | Manajemen Produk |
|-------------------|------------------|
| **Aktor** | Admin |
| **Deskripsi** | Admin mengelola data produk: menambah, melihat, mengedit, dan menghapus produk |
| **Pre-Kondisi** | Admin sudah login dan berada di halaman dashboard |
| **Post-Kondisi** | Data produk berhasil ditambahkan/diubah/dihapus |

| Aksi Aktor (Alur Dasar) — Tambah Produk | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin membuka menu "Produk" | |
| | 2. Sistem menampilkan daftar produk dalam tabel (pagination) |
| 3. Admin menekan tombol "Tambah Produk" | |
| | 4. Sistem menampilkan form: nama, kategori, harga, harga diskon, stok, berat, deskripsi, gambar utama, galeri gambar |
| 5. Admin mengisi data produk dan mengupload gambar | |
| 6. Admin menekan "Simpan" | 7. Sistem memvalidasi input |
| | 8. Sistem menyimpan produk ke database |
| | 9. Sistem menampilkan flash message "Produk berhasil ditambahkan" |

| Aksi Aktor (Alur Dasar) — Edit Produk | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin menekan tombol "Edit" pada produk yang dipilih | |
| | 2. Sistem menampilkan form dengan data produk yang sudah ada |
| 3. Admin mengubah data yang diinginkan | |
| 4. Admin menekan "Simpan" | 5. Sistem memvalidasi dan memperbarui data produk |
| | 6. Sistem menampilkan flash message "Produk berhasil diperbarui" |

| Aksi Aktor (Alur Dasar) — Hapus Produk | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin menekan tombol "Hapus" pada produk | |
| | 2. Sistem menampilkan modal konfirmasi "Yakin ingin menghapus?" |
| 3. Admin mengkonfirmasi | 4. Sistem menghapus produk dan gambar terkait |
| | 5. Flash message "Produk berhasil dihapus" |

| Alur Alternatif |
|-----------------|
| **A1: Nama kosong.** Sistem menolak: "Nama produk wajib diisi" |
| **A2: Harga negatif/nol.** Sistem menolak: "Harga harus lebih dari 0" |
| **A3: Kategori tidak valid.** Sistem menolak: "Kategori tidak ditemukan" |
| **A4: Gambar terlalu besar (>10MB).** Sistem menolak: "Ukuran maksimal 10MB" |
| **A5: Format gambar tidak didukung.** Sistem menolak: "Hanya jpeg, png, webp" |
| **A6: Hapus dibatalkan.** Produk tidak jadi dihapus |

---

### UC-14: Kelola Stok

| **Nama Use Case** | Kelola Stok |
|-------------------|-------------|
| **Aktor** | Admin |
| **Deskripsi** | Admin mengelola mutasi stok produk (stok masuk dan stok keluar) serta melihat histori mutasi |
| **Pre-Kondisi** | Admin sudah login |
| **Post-Kondisi** | Stok produk berubah dan tercatat di histori mutasi |

| Aksi Aktor (Alur Dasar) | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin membuka menu "Produk" dan memilih produk | |
| 2. Admin menekan "Kelola Stok" atau tombol stok | |
| | 3. Sistem menampilkan halaman manajemen stok: stok saat ini, form mutasi (tipe: in/out, qty, deskripsi), histori mutasi |
| 4. Admin memilih tipe "Stok Masuk (In)" atau "Stok Keluar (Out)" | |
| 5. Admin mengisi jumlah dan deskripsi | |
| 6. Admin menekan "Simpan" | 7. Sistem memvalidasi qty > 0 |
| | 8. Jika tipe "in": stok + qty. Jika tipe "out": stok - qty |
| | 9. Sistem mencatat mutasi ke tabel `stocks` |
| | 10. Flash message "Stok berhasil diupdate" |

| Alur Alternatif |
|-----------------|
| **A1: Qty ≤ 0.** Sistem menolak: "Quantity harus lebih dari 0" |
| **A2: Stok keluar melebihi stok saat ini.** Sistem menolak: "Stok tidak mencukupi" |
| **A3: Produk tidak aktif.** Sistem menolak: "Produk tidak aktif" |

---

### UC-15: Kelola Kategori

| **Nama Use Case** | Kelola Kategori |
|-------------------|-----------------|
| **Aktor** | Admin |
| **Deskripsi** | Admin mengelola kategori produk: menambah, melihat, mengedit, menghapus, dan mengatur status kategori |
| **Pre-Kondisi** | Admin sudah login |
| **Post-Kondisi** | Data kategori berhasil ditambahkan/diubah/dihapus |

| Aksi Aktor (Alur Dasar) — Tambah Kategori | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin membuka menu "Kategori" | |
| | 2. Sistem menampilkan daftar kategori dalam tabel |
| 3. Admin menekan "Tambah Kategori" | |
| | 4. Sistem menampilkan form: nama, slug (auto), icon, deskripsi, order, status aktif |
| 5. Admin mengisi data dan menekan "Simpan" | 6. Sistem memvalidasi: nama unik |
| | 7. Sistem menyimpan kategori |
| | 8. Flash message "Kategori berhasil ditambahkan" |

| Alur Alternatif |
|-----------------|
| **A1: Nama kategori sudah ada.** Sistem menolak: "Nama kategori sudah digunakan" |
| **A2: Edit/Hapus kategori.** Alur serupa dengan manajemen produk |

---

### UC-16: Kelola Banner

| **Nama Use Case** | Kelola Banner |
|-------------------|---------------|
| **Aktor** | Admin |
| **Deskripsi** | Admin mengelola banner promosi: menambah, melihat, mengedit, menghapus, dan mengatur jadwal tayang |
| **Pre-Kondisi** | Admin sudah login |
| **Post-Kondisi** | Data banner berhasil disimpan |

| Aksi Aktor (Alur Dasar) | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin membuka menu "Banner" | |
| | 2. Sistem menampilkan daftar banner |
| 3. Admin menekan "Tambah Banner" | |
| | 4. Sistem menampilkan form: judul, gambar, link, order, start_date, end_date, is_active |
| 5. Admin mengisi data, upload gambar, dan menekan "Simpan" | 6. Sistem memvalidasi: judul wajib, gambar format jpeg/png |
| | 7. Sistem menyimpan banner |
| | 8. Flash message "Banner berhasil ditambahkan" |

| Alur Alternatif |
|-----------------|
| **A1: Judul kosong.** Sistem menolak: "Judul banner wajib diisi" |
| **A2: Format gambar invalid.** Sistem menolak: "Hanya jpeg/png" |

---

### UC-17: Voucher

| **Nama Use Case** | Voucher |
|-------------------|---------|
| **Aktor** | Admin |
| **Deskripsi** | Admin mengelola voucher diskon: menambah, melihat, mengedit, menghapus, dan melihat log penggunaan |
| **Pre-Kondisi** | Admin sudah login |
| **Post-Kondisi** | Data voucher berhasil disimpan |

| Aksi Aktor (Alur Dasar) — Tambah Voucher | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin membuka menu "Voucher" | |
| | 2. Sistem menampilkan daftar voucher (kode, nama, tipe, nilai, min belanja, kuota, masa berlaku, status) |
| 3. Admin menekan "Tambah Voucher" | |
| | 4. Sistem menampilkan form: kode, nama, tipe (percentage/fixed/free_shipping), value, min_purchase, min_qty, max_discount, max_usage, start_date, expiry_date, is_active |
| 5. Admin mengisi data dan menekan "Simpan" | 6. Sistem memvalidasi: kode unik, tipe valid, nilai > 0 |
| | 7. Sistem menyimpan voucher |
| | 8. Flash message "Voucher berhasil ditambahkan" |

| Alur Alternatif |
|-----------------|
| **A1: Kode duplikat.** Sistem menolak: "Kode voucher sudah digunakan" |
| **A2: Kode kosong.** Sistem menolak: "Kode voucher wajib diisi" |
| **A3: Tipe tidak valid.** Sistem menolak: "Tipe harus percentage, fixed, atau free_shipping" |
| **A4: Nilai diskon 0 atau negatif.** Sistem menolak: "Nilai harus lebih dari 0" |
| **A5: Persen > 100.** Sistem menolak: "Diskon persen maksimal 100" |

---

### UC-18: Kelola Transaksi (Update Status Pesanan/Pembayaran)

| **Nama Use Case** | Kelola Transaksi |
|-------------------|------------------|
| **Aktor** | Admin |
| **Deskripsi** | Admin mengelola transaksi: melihat daftar, mengupdate status pesanan, status pembayaran, dan input nomor resi |
| **Pre-Kondisi** | Admin sudah login |
| **Post-Kondisi** | Status transaksi berhasil diperbarui |

| Aksi Aktor (Alur Dasar) — Update Status | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin membuka menu "Transaksi" | |
| | 2. Sistem menampilkan daftar transaksi (filter: status, payment_status, tanggal) |
| 3. Admin memilih transaksi dan menekan "Detail" | |
| | 4. Sistem menampilkan detail transaksi: info pesanan, pembayaran, pengiriman, daftar produk |
| 5. Admin mengubah status pesanan (dropdown: pending/processing/shipped/delivered/cancelled) | |
| 6. Admin menekan "Simpan" | 7. Sistem memvalidasi: status valid |
| | 8. Sistem memperbarui status dan timestamp (shipped_at/delivered_at) |
| | 9. Jika status "cancelled": sistem mengembalikan stok produk |
| | 10. Sistem mengirim notifikasi in-app ke konsumen |
| | 11. Flash message "Status berhasil diupdate" |

| Aksi Aktor (Alur Dasar) — Input Resi | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin mengisi nomor resi pada kolom tracking_number | |
| 2. Admin menekan "Simpan" | 3. Sistem memvalidasi: payment_status harus "paid", resi tidak kosong |
| | 4. Jika valid: sistem menyimpan resi, mengupdate status ke "shipped", mengisi shipped_at |
| | 5. Sistem membuat tracking_url otomatis |
| | 6. Sistem mengirim notifikasi in-app ke konsumen |
| | 7. Flash message "Resi berhasil disimpan" |

| Alur Alternatif |
|-----------------|
| **A1: Payment belum lunas.** Sistem menolak input resi: "Pembayaran harus lunas terlebih dahulu" |
| **A2: Resi kosong.** Sistem menolak: "Nomor resi wajib diisi" |
| **A3: Status invalid.** Sistem menolak: "Status pesanan tidak valid" |
| **A4: Cancelled tanpa alasan.** Sistem dapat meminta konfirmasi sebelum membatalkan |

---

### UC-19: Retur (Setujui/Tolak Retur)

| **Nama Use Case** | Retur |
|-------------------|-------|
| **Aktor** | Admin |
| **Deskripsi** | Admin memproses pengajuan retur: melihat, menyetujui, menolak, atau menyelesaikan retur |
| **Pre-Kondisi** | Admin sudah login. Ada pengajuan retur dengan status "pending" |
| **Post-Kondisi** | Status retur berubah sesuai keputusan admin |

| Aksi Aktor (Alur Dasar) — Setujui Retur | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin membuka menu "Retur" | |
| | 2. Sistem menampilkan daftar retur (filter: status) |
| 3. Admin memilih retur dengan status "pending" | |
| | 4. Sistem menampilkan detail: produk, alasan, deskripsi, foto bukti |
| 5. Admin memeriksa bukti dan menekan "Setujui" | |
| | 6. Sistem menampilkan modal input catatan (opsional) |
| 7. Admin mengisi catatan (opsional) dan konfirmasi | 8. Sistem mengupdate status retur menjadi "approved", menyimpan catatan |
| | 9. Sistem mengirim notifikasi in-app ke konsumen "Retur Anda disetujui" |
| 10. Admin memproses refund dan menekan "Selesai" | 11. Sistem mengupdate status menjadi "completed" |

| Aksi Aktor (Alur Dasar) — Tolak Retur | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin menekan "Tolak" | |
| | 2. Sistem menampilkan modal input alasan penolakan (wajib) |
| 3. Admin mengisi alasan dan konfirmasi | 4. Sistem mengupdate status menjadi "rejected", menyimpan alasan |
| | 5. Sistem mengirim notifikasi ke konsumen "Retur Anda ditolak: [alasan]" |

| Alur Alternatif |
|-----------------|
| **A1: Alasan tolak kosong.** Sistem meminta: "Alasan penolakan wajib diisi" |

---

### UC-20: Kelola Ulasan (Sembunyikan/Balas/Hapus)

| **Nama Use Case** | Kelola Ulasan |
|-------------------|---------------|
| **Aktor** | Admin |
| **Deskripsi** | Admin mengelola ulasan produk: menyetujui, menolak, membalas, dan menghapus ulasan |
| **Pre-Kondisi** | Admin sudah login |
| **Post-Kondisi** | Status ulasan berubah sesuai aksi admin |

| Aksi Aktor (Alur Dasar) — Setujui Ulasan | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin membuka menu "Rating" atau "Ulasan" | |
| | 2. Sistem menampilkan daftar ulasan (filter: status approved/pending) |
| 3. Admin menekan "Setujui" pada ulasan pending | |
| | 4. Sistem mengupdate is_approved = true |
| | 5. Ulasan tampil di halaman publik produk |

| Aksi Aktor (Alur Dasar) — Tolak/Sembunyikan | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin menekan "Tolak" atau "Sembunyikan" | |
| | 2. Sistem mengupdate is_approved = false |
| | 3. Ulasan tidak tampil di publik |

| Aksi Aktor (Alur Dasar) — Balas Ulasan | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin menekan "Balas" pada ulasan | |
| | 2. Sistem menampilkan form balasan |
| 3. Admin mengetik balasan dan menekan "Kirim" | 4. Sistem menyimpan balasan di kolom admin_reply |
| | 5. Balasan tampil di publik di bawah ulasan |

| Aksi Aktor (Alur Dasar) — Hapus | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin menekan "Hapus" pada ulasan | |
| | 2. Sistem menampilkan modal konfirmasi |
| 3. Admin konfirmasi | 4. Sistem menghapus ulasan dari database |

---

### UC-21: Kelola Pengguna (Blokir/Hapus)

| **Nama Use Case** | Kelola Pengguna |
|-------------------|-----------------|
| **Aktor** | Admin |
| **Deskripsi** | Admin melihat daftar pengguna, melihat detail, memblokir, atau menghapus akun pengguna |
| **Pre-Kondisi** | Admin sudah login |
| **Post-Kondisi** | Status pengguna berubah (diblokir/dihapus) |

| Aksi Aktor (Alur Dasar) — Lihat Pengguna | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin membuka menu "Kelola Pengguna" atau "Customer" | |
| | 2. Sistem menampilkan daftar customer dalam tabel (nama, email, telepon, tgl daftar, total transaksi) |

| Aksi Aktor (Alur Dasar) — Blokir Pengguna | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin menekan tombol "Blokir" pada pengguna | |
| | 2. Sistem menampilkan modal konfirmasi |
| 3. Admin konfirmasi | 4. Sistem mengubah status user menjadi nonaktif |
| | 5. User tidak dapat login. Flash message "Pengguna berhasil diblokir" |

| Aksi Aktor (Alur Dasar) — Hapus Pengguna | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin menekan "Hapus" pada pengguna | |
| | 2. Sistem menampilkan modal konfirmasi |
| 3. Admin konfirmasi | 4. Sistem menghapus user beserta data terkait (transaksi, alamat, dll) |
| | 5. Flash message "Pengguna berhasil dihapus" |

| Alur Alternatif |
|-----------------|
| **A1: Memblokir admin.** Sistem menolak: "Tidak dapat memblokir admin lain" |
| **A2: Hapus dibatalkan.** Tidak ada perubahan |

---

### UC-22: Laporan Penjualan (Ekspor Excel)

| **Nama Use Case** | Laporan Penjualan |
|-------------------|-------------------|
| **Aktor** | Admin |
| **Deskripsi** | Admin melihat laporan penjualan dengan filter tanggal dan mengexport ke Excel/CSV |
| **Pre-Kondisi** | Admin sudah login |
| **Post-Kondisi** | Laporan ditampilkan dan/atau file excel terdownload |

| Aksi Aktor (Alur Dasar) — Lihat Laporan | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin membuka menu "Laporan Penjualan" | |
| | 2. Sistem menampilkan halaman laporan: tabel transaksi (filter: tanggal, status) |
| 3. Admin memilih rentang tanggal dan menekan "Filter" | |
| | 4. Sistem menampilkan data transaksi dalam rentang tanggal |

| Aksi Aktor (Alur Dasar) — Ekspor Excel | Reaksi Sistem |
|------------------------|---------------|
| 1. Admin menekan tombol "Export Excel" | |
| | 2. Sistem membuat file Excel berisi data transaksi (no, invoice, customer, tanggal, status, status bayar, total) |
| | 3. File Excel terdownload otomatis |

| Alur Alternatif |
|-----------------|
| **A1: Tidak ada data.** Sistem menampilkan "Tidak ada transaksi pada periode tersebut" |

---

## C. DAFTAR SELURUH USE CASE

| No | Kode Use Case | Nama Use Case | Aktor |
|:--:|:-------------:|---------------|-------|
| 1 | UC-01 | Customer Service | Pengunjung |
| 2 | UC-02 | Mencari Produk | Pengunjung, Konsumen |
| 3 | UC-03 | Melihat Produk | Pengunjung, Konsumen |
| 4 | UC-04 | Melihat Ulasan | Pengunjung, Konsumen |
| 5 | UC-05 | Daftar (Registrasi) | Pengunjung |
| 6 | UC-06 | Login | Pengunjung, Konsumen, Admin |
| 7 | UC-07 | Login (Konsumen) | Konsumen |
| 8 | UC-08 | Kelola Profil | Konsumen |
| 9 | UC-09 | Melakukan Transaksi | Konsumen |
| 10 | UC-10 | Riwayat Transaksi | Konsumen |
| 11 | UC-11 | Ajukan Retur | Konsumen |
| 12 | UC-12 | Login (Admin) | Admin |
| 13 | UC-13 | Manajemen Produk | Admin |
| 14 | UC-14 | Kelola Stok | Admin |
| 15 | UC-15 | Kelola Kategori | Admin |
| 16 | UC-16 | Kelola Banner | Admin |
| 17 | UC-17 | Voucher | Admin |
| 18 | UC-18 | Kelola Transaksi | Admin |
| 19 | UC-19 | Retur (Setujui/Tolak) | Admin |
| 20 | UC-20 | Kelola Ulasan | Admin |
| 21 | UC-21 | Kelola Pengguna | Admin |
| 22 | UC-22 | Laporan Penjualan | Admin |
