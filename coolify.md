# Panduan Deployment ke Coolify

Dokumen ini berisi panduan langkah demi langkah untuk melakukan deployment project ini (Laravel) ke Coolify menggunakan Docker Compose.

## 1. Persiapan Repositori
Pastikan semua kode, termasuk `Dockerfile` dan `docker-compose.yml` yang baru saja dibuat, sudah di-commit dan di-push ke repositori GitHub.

## 2. Setup di Coolify
1. Buka dashboard Coolify Anda.
2. Buat **Project** baru atau pilih project yang sudah ada.
3. Klik **New Resource** dan pilih **Docker Compose**.
4. Pilih sumber kode (Source):
   - Jika repositori bersifat publik, Anda bisa menggunakan Git (Public).
   - Jika repositori privat, pastikan Anda sudah menghubungkan akun GitHub Anda (melalui GitHub App atau Deploy Key) dan pilih repositori `b2c_aciaa`.

## 3. Konfigurasi Deployment
Setelah repositori dipilih, Coolify akan mendeteksi file `docker-compose.yml`.
Lakukan konfigurasi berikut:

1. **Domains**: Atur domain yang ingin digunakan untuk aplikasi Anda (misal: `https://app.domainanda.com`).
2. **Environment Variables**:
   Masuk ke tab **Environment Variables** dan tambahkan variabel yang dibutuhkan (sesuai dengan isi `.env.example`). Sangat penting untuk mengisi:
   - `APP_KEY`: Generate key laravel (bisa di-generate secara lokal dengan `php artisan key:generate --show` lalu paste di sini).
   - `APP_URL`: URL dari domain yang diatur sebelumnya.
   - `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`: Sesuaikan dengan kredensial database Anda (bisa dibuat menggunakan service Database di Coolify).

## 4. Setup Database (Jika Belum Ada)
1. Di Coolify, buat resource baru dan pilih **Database** (MySQL / PostgreSQL sesuai yang digunakan).
2. Setelah database berjalan, ambil informasi koneksi (Host, Port, User, Password, Database Name).
3. Karena database berada di jaringan Coolify yang sama, Anda bisa menggunakan nama service database (atau internal IP) sebagai `DB_HOST`.

## 5. Deploy
1. Kembali ke resource Docker Compose aplikasi Anda.
2. Klik tombol **Deploy**.
3. Tunggu proses build selesai. Coolify akan menggunakan `Dockerfile` yang telah dibuat untuk membangun *image* secara multi-stage (Node.js untuk assets, Composer untuk dependencies, dan Nginx+PHP-FPM untuk runtime).

## 6. Pasca-Deployment (Migrasi Database)
Setelah aplikasi berhasil di-deploy:
1. Buka tab **Terminal** pada resource aplikasi Anda di Coolify.
2. Jalankan perintah migrasi:
   ```bash
   php artisan migrate --force
   ```
3. (Opsional) Jika Anda menggunakan seeder:
   ```bash
   php artisan db:seed --force
   ```

Aplikasi Anda kini sudah berhasil berjalan dan dapat diakses melalui domain yang dikonfigurasi!
