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
   Masuk ke tab **Environment Variables**. Karena database sudah terpaket langsung di dalam container (otomatis), Anda **HANYA PERLU** mengisi dua variabel ini:
   - `APP_KEY`: Paste key yang Anda miliki (contoh: `base64:Dl6ZlxdYINPEn74Zn8whHJIz/Z9wSBb6+7d8eTXoe60=`).
   - `APP_URL`: URL dari domain Anda (contoh: `http://yc0k9wk73ta8yze5bo2chncv.43.157.223.77.sslip.io`).
   
   *(Anda tidak perlu lagi mengisi DB_HOST dkk secara manual!)*

## 4. Deploy
1. Kembali ke resource Docker Compose aplikasi Anda.
2. Klik tombol **Deploy**.
3. Tunggu proses build selesai. Coolify akan menggunakan `Dockerfile` yang telah dibuat untuk membangun *image* secara multi-stage (Node.js untuk assets, Composer untuk dependencies, dan Nginx+PHP-FPM untuk runtime).

## 5. Pasca-Deployment (Migrasi Database)
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
