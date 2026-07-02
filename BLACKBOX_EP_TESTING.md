# BLACKBOX TESTING — EQUIVALENCE PARTITIONING (EP)
## ACIAA E-Commerce

---

## 1. MODUL AUTENTIKASI

### 1.1 Registrasi

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 1 | Nama (Valid) | Mengisi nama dengan 3 karakter atau lebih | "Aciaa" | Data berhasil tersimpan | | |
| 2 | Nama (Invalid) | Mengisi nama kurang dari 3 karakter | "Ab" | Sistem menolak: minimal 3 karakter | | |
| 3 | Nama (Kosong) | Tidak mengisi nama | "" | Sistem menolak: nama wajib diisi | | |
| 4 | Email (Valid) | Mengisi email dengan format benar | "user@mail.com" | Data berhasil tersimpan | | |
| 5 | Email (Invalid) | Mengisi email tanpa @ | "useremail.com" | Sistem menolak: format email salah | | |
| 6 | Email (Invalid) | Mengisi email tanpa domain | "user@" | Sistem menolak: format email salah | | |
| 7 | Email (Kosong) | Tidak mengisi email | "" | Sistem menolak: email wajib diisi | | |
| 8 | Email (Duplikat) | Mengisi email yang sudah terdaftar | Email terdaftar | Sistem menolak: email sudah digunakan | | |
| 9 | Password (Valid) | Mengisi password 8 karakter atau lebih | "password123" | Data berhasil tersimpan | | |
| 10 | Password (Invalid) | Mengisi password kurang dari 8 karakter | "pass" | Sistem menolak: minimal 8 karakter | | |
| 11 | Password (Kosong) | Tidak mengisi password | "" | Sistem menolak: password wajib diisi | | |

### 1.2 Login

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 12 | Kredensial Valid | Login dengan email dan password benar | Email terdaftar + password benar | Redirect ke halaman utama/dashboard | | |
| 13 | Password Salah | Login dengan password yang salah | Email terdaftar + password "salah123" | Sistem menolak: kredensial tidak valid | | |
| 14 | Email Tidak Terdaftar | Login dengan email yang belum terdaftar | "tidakada@email.com" + password | Sistem menolak: kredensial tidak valid | | |
| 15 | Email Kosong | Login tanpa mengisi email | "" + password | Sistem menolak: email wajib diisi | | |
| 16 | Password Kosong | Login tanpa mengisi password | Email + "" | Sistem menolak: password wajib diisi | | |

---

## 2. MODUL PRODUK

### 2.1 CRUD Produk (Admin)

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 17 | Nama Valid | Mengisi nama produk | "Baju Batik" | Data produk tersimpan | | |
| 18 | Nama Kosong | Tidak mengisi nama produk | "" | Sistem menolak: nama wajib diisi | | |
| 19 | Harga Valid | Mengisi harga lebih dari 0 | 50000 | Data produk tersimpan | | |
| 20 | Harga Nol | Mengisi harga 0 | 0 | Sistem menolak: minimal 0 | | |
| 21 | Harga Negatif | Mengisi harga negatif | -5000 | Sistem menolak: minimal 0 | | |
| 22 | Harga Non-Numeric | Mengisi harga dengan huruf | "abc" | Sistem menolak: harus berupa angka | | |
| 23 | Harga Kosong | Tidak mengisi harga | "" | Sistem menolak: harga wajib diisi | | |
| 24 | Diskon Normal | Diskon lebih kecil dari harga asli | price=50000, discount=40000 | Diskon tersimpan dan valid | | |
| 25 | Diskon Sama | Diskon sama dengan harga asli | price=50000, discount=50000 | Tidak ada efek diskon | | |
| 26 | Diskon Lebih Besar | Diskon lebih besar dari harga asli | price=50000, discount=60000 | Diskon tidak logis (error) | | |
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

### 2.2 Pencarian & Filter Produk

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 37 | Keyword Ditemukan | Mencari produk yang ada | "Baju" | Menampilkan produk yang cocok | | |
| 38 | Keyword Tidak Ditemukan | Mencari produk yang tidak ada | "ZZZXYZ" | Menampilkan "produk tidak ditemukan" | | |
| 39 | Keyword Kosong | Mencari tanpa kata kunci | "" | Menampilkan semua produk | | |
| 40 | Filter Kategori Valid | Filter kategori dengan produk | Kategori ID valid | Produk per kategori | | |
| 41 | Filter Kategori Kosong | Filter kategori tanpa produk | Kategori ID (tanpa produk) | Tidak ada produk | | |
| 42 | Filter Kategori Invalid | Filter dengan kategori tidak ada | 9999 | Error / redirect | | |

### 2.3 Stok Produk

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 43 | Stok Masuk (In) | Menambah stok masuk | type="in", qty=10 | Stok +10, tercatat di log | | |
| 44 | Stok Keluar (Out) | Mengurangi stok keluar | type="out", qty=5 | Stok -5, tercatat di log | | |
| 45 | Stok Nol | Mutasi stok dengan quantity 0 | qty=0 | Tidak ada perubahan | | |
| 46 | Stok Negatif | Mutasi stok dengan quantity negatif | qty=-10 | Sistem menolak | | |

---

## 3. MODUL KERANJANG (CART)

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

---

## 4. MODUL CHECKOUT

### 4.1 Manajemen Alamat

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 57 | Nama Penerima Valid | Mengisi nama penerima | "Budi Santoso" | Alamat tersimpan | | |
| 58 | Nama Penerima Kosong | Tidak mengisi nama | "" | Sistem menolak: wajib diisi | | |
| 59 | No HP Valid | Mengisi nomor HP 10+ digit | "081234567890" | Tersimpan | | |
| 60 | No HP Kurang | Mengisi nomor HP < 10 digit | "08123" | Sistem menolak / tetap tersimpan | | |
| 61 | No HP Non-Numeric | Mengisi no HP dengan huruf | "abc123" | Sistem menolak: harus angka | | |
| 62 | No HP Kosong | Tidak mengisi no HP | "" | Sistem menolak: wajib diisi | | |
| 63 | Provinsi-Kota Sesuai | Kota sesuai dengan provinsi | province_id=12, city valid | Tersimpan | | |
| 64 | Provinsi-Kota Tidak Sesuai | Kota berbeda provinsi | province=Jawa, city=Kalbar | Sistem menolak: tidak sesuai | | |
| 65 | Kecamatan Sesuai Kota | Kecamatan sesuai dengan kota | subdistrict_id valid | Tersimpan | | |
| 66 | Kecamatan Tidak Sesuai | Kecamatan beda kota | subdistrict_id (kota lain) | Sistem menolak: tidak sesuai | | |
| 67 | Kecamatan Null | Tanpa kecamatan | null | Tersimpan tanpa kecamatan | | |
| 68 | Alamat Default Pertama | Alamat pertama otomatis default | is_default=true | Jadi alamat utama | | |
| 69 | Alamat Default Ganti | Ganti alamat utama lain | is_default=true (alamat baru) | Alamat lama jadi biasa | | |

### 4.2 Ongkos Kirim (RajaOngkir)

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

### 4.3 Voucher di Checkout

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 82 | Kode Valid & Baru | Klaim voucher dengan kode valid | "PROMO10" | Voucher berhasil diklaim | | |
| 83 | Kode Sudah Diklaim | Klaim voucher yang sudah pernah | "PROMO10" (ulang) | Sistem menolak: sudah diklaim | | |
| 84 | Kode Tidak Ada | Klaim dengan kode tidak terdaftar | "XXXXXXXX" | Sistem menolak: kode tidak valid | | |
| 85 | Kode Expired | Klaim voucher kadaluarsa | Kode expired | Sistem menolak: sudah kadaluarsa | | |
| 86 | Kuota Habis | Klaim voucher kuota penuh | max_usage terpenuhi | Sistem menolak: kuota habis | | |
| 87 | Belum Mulai | Klaim voucher sebelum start_date | start_date > hari ini | Sistem menolak: belum bisa dipakai | | |
| 88 | Kode Kosong | Klaim tanpa kode | "" | Sistem menolak: kode wajib | | |
| 89 | Min Purchase Terpenuhi | Pakai voucher memenuhi min belanja | subtotal ≥ min_purchase | Diskon berhasil dihitung | | |
| 90 | Min Purchase Tidak Terpenuhi | Pakai voucher di bawah min belanja | subtotal < min_purchase | Sistem menolak: minimal belanja | | |
| 91 | Min Qty Terpenuhi | Jumlah barang memenuhi min qty | total_qty ≥ min_qty | Diskon berhasil dihitung | | |
| 92 | Min Qty Tidak Terpenuhi | Jumlah barang kurang dari min qty | total_qty < min_qty | Sistem menolak: minimal qty | | |

### 4.4 Proses Checkout

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 93 | Semua Valid | Proses checkout dengan data lengkap | address + courier + cost valid | Transaksi terbuat, redirect ke Midtrans | | |
| 94 | Cart Kosong | Proses checkout saat cart kosong | cart tanpa item | Redirect + error "keranjang kosong" | | |
| 95 | Alamat Milik Orang Lain | Memilih alamat milik user lain | address_id user lain | 404 / Error | | |
| 96 | Ongkir Negatif | Ongkos kirim bernilai negatif | shipping_cost=-1000 | Sistem menolak | | |

---

## 5. MODUL MIDTRANS (PAYMENT)

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 97 | Settlement | Notifikasi pembayaran sukses | transaction_status="settlement" | Status "paid", transaksi "processing" | | |
| 98 | Capture + Accept | Notifikasi capture diaccept | status="capture", fraud="accept" | Status "paid" | | |
| 99 | Capture + Deny | Notifikasi capture ditolak | status="capture", fraud="deny" | Status "pending" | | |
| 100 | Pending | Notifikasi masih pending | transaction_status="pending" | Status tetap "pending" | | |
| 101 | Deny | Notifikasi pembayaran ditolak | transaction_status="deny" | Status "failed" | | |
| 102 | Expire | Notifikasi pembayaran expired | transaction_status="expire" | Status "expired", transaksi "cancelled", stok dikembalikan | | |
| 103 | Cancel | Notifikasi pembayaran dibatalkan | transaction_status="cancel" | Status "failed" | | |
| 104 | Signature Valid | Signature key sesuai perhitungan | signature_key valid | Proses notifikasi diteruskan | | |
| 105 | Signature Invalid | Signature key tidak sesuai | signature_key asal | Error: invalid signature | | |

---

## 6. MODUL VOUCHER (ADMIN)

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 106 | Kode Unik | Membuat voucher dengan kode baru | code="DISKON50" | Voucher tersimpan | | |
| 107 | Kode Duplikat | Membuat voucher dengan kode yang sudah ada | code="DISKON50" (ada) | Sistem menolak: kode duplikat | | |
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

---

## 7. MODUL RATING

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

---

## 8. MODUL RETUR

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

---

## 9. MODUL TRANSAKSI (ADMIN)

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

---

## 10. MODUL WISHLIST

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 165 | Toggle Masuk | Wishlist produk yang belum ada | product_id=1 | Produk masuk wishlist | | |
| 166 | Toggle Keluar | Wishlist produk yang sudah ada | product_id=1 (ulang) | Produk keluar wishlist | | |
| 167 | Produk Invalid | Wishlist produk tidak ada | product_id=9999 | Sistem menolak: produk tidak ditemukan | | |
| 168 | Hapus Milik Sendiri | Hapus wishlist milik sendiri | wishlist_id valid | Terhapus | | |
| 169 | Hapus Milik Orang Lain | Hapus wishlist milik user lain | wishlist_id (orang lain) | 403 Forbidden | | |

---

## 11. MODUL AKSES ADMIN

| No | Kelas Uji | Skenario Uji | Data Masukan | Hasil yang Diharapkan | Hasil Pengujian | Status |
|----|-----------|-------------|-------------|----------------------|----------------|--------|
| 170 | Role Admin | Admin mengakses halaman admin | role="admin" | Akses diberikan ke dashboard | | |
| 171 | Role Customer | Customer mengakses halaman admin | role="customer" | 403 Forbidden | | |
| 172 | Guest (Belum Login) | User belum login mengakses admin | guest | Redirect ke halaman login | | |

---

## 12. MODUL BANNER

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

---

## RINGKASAN

| No | Modul | Jumlah TC |
|----|-------|:---------:|
| 1 | Autentikasi | 16 |
| 2 | Produk | 30 |
| 3 | Keranjang | 10 |
| 4 | Checkout | 40 |
| 5 | Midtrans | 9 |
| 6 | Voucher (Admin) | 18 |
| 7 | Rating | 13 |
| 8 | Retur | 14 |
| 9 | Transaksi (Admin) | 14 |
| 10 | Wishlist | 5 |
| 11 | Akses Admin | 3 |
| 12 | Banner | 11 |
| | **TOTAL** | **183 Test Case** |

**Catatan:** Kolom **Hasil Pengujian** dan **Status** diisi manual setelah pengujian dilakukan.
