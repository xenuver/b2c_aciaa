# Panduan Fix Midtrans di Coolify

## Root Cause: "Invalid payment data" / "Failed to Load QR"

Masalah ini terjadi karena **mismatch antara environment Midtrans dan domain hosting**.

---

## ✅ Langkah Fix

### 1. Update `.env` di Coolify

Buka Environment Variables di Coolify dashboard dan update:

```env
# Ganti ke production jika sudah pakai key production
MIDTRANS_IS_PRODUCTION=true

# Pastikan APP_URL sesuai domain Coolify (tanpa trailing slash)
APP_URL=https://aciaastore.my.id

# Set session domain ke domain Anda
SESSION_DOMAIN=aciaastore.my.id

# Penting untuk HTTPS di Coolify
SESSION_SECURE_COOKIE=true
```

### 2. Jika masih mau pakai Sandbox

Jika ingin tetap pakai Sandbox (testing), lakukan ini di Midtrans Dashboard Sandbox:
1. Login ke https://dashboard.sandbox.midtrans.com
2. Masuk ke **Settings → Snap Preferences → System Settings**
3. Tambahkan domain Anda ke **Payment Link Domain** dan **Whitelist Domain**:
   - `https://aciaastore.my.id`
   - `aciaastore.my.id`

### 3. Pastikan Midtrans Keys Benar

- **Sandbox keys** dimulai dengan `Mid-client-` dan `Mid-server-`
- **Production keys** berbeda — dapatkan dari dashboard production Midtrans
- Jika pakai sandbox key tapi `MIDTRANS_IS_PRODUCTION=true` → akan error

### 4. Webhook Notification URL

Pastikan di Midtrans Dashboard → Settings → Configuration → Payment Notification URL diisi:
```
https://aciaastore.my.id/midtrans/notification
```

### 5. Clear Config Cache di Server

Setelah update `.env` di Coolify, jalankan:
```bash
php artisan config:clear
php artisan cache:clear
```

Atau trigger redeploy dari Coolify.

---

## Diagnosis Cepat

| Gejala | Penyebab | Solusi |
|--------|----------|--------|
| "Invalid payment data" | Domain tidak diwhitelist di Midtrans Sandbox | Whitelist domain, atau switch ke Production |
| "Failed to Load QR" | Sandbox snap.js tidak bisa load karena CORS | Sama seperti atas |
| Snap popup tidak muncul | snap_token null / key salah | Cek server key di .env |
| Paid tapi status masih pending | Webhook tidak masuk | Set notification URL di Midtrans dashboard |
