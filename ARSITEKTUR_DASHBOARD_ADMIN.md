# ARSITEKTUR WEB B2C — DASHBOARD ADMIN
## ACIAA E-Commerce

---

## 1. POSISI DASHBOARD ADMIN DALAM ARSITEKTUR B2C

```
┌──────────────────────────────────────────────────────────────────────┐
│                        ┌──────────────┐                             │
│                        │    Admin     │                             │
│                        │  (Browser)   │                             │
│                        └──────┬───────┘                             │
│                               ▼                                     │
│  ┌─────────────────────────────────────────────────────────────┐    │
│  │                    WEB SERVER (Apache)                       │    │
│  │  ┌─────────────────────────────────────────────────────┐    │    │
│  │  │               LARAVEL APPLICATION                    │    │    │
│  │  │                                                      │    │    │
│  │  │  ┌──────────┐  ┌───────────┐  ┌──────────────────┐  │    │    │
│  │  │  │  Route   │  │ Middleware │  │   Controller     │  │    │    │
│  │  │  │ /admin/* │→ │auth + admin│→ │  AdminController │  │    │    │
│  │  │  └──────────┘  └───────────┘  └────────┬─────────┘  │    │    │
│  │  │                                         │             │    │    │
│  │  │  ┌──────────────────────────────────────┴──────────┐  │    │    │
│  │  │  │              SERVICE LAYER                       │  │    │    │
│  │  │  │  ┌──────────────┐   ┌──────────────────┐       │  │    │    │
│  │  │  │  │MidtransService│   │RajaOngkirService │       │  │    │    │
│  │  │  │  └──────────────┘   └──────────────────┘       │  │    │    │
│  │  │  └─────────────────────────────────────────────────┘  │    │    │
│  │  │                                                      │    │    │
│  │  │  ┌──────────────────────────────────────────────────┐ │    │    │
│  │  │  │              MODEL (Eloquent)                    │ │    │    │
│  │  │  │  Product  Category  Transaction  Voucher        │ │    │    │
│  │  │  │  User     Rating    Retur       Banner          │ │    │    │
│  │  │  │  Notification  Stock  ActivityLog               │ │    │    │
│  │  │  └───────────────────────┬──────────────────────────┘ │    │    │
│  │  └──────────────────────────┼─────────────────────────────┘    │    │
│  │                             ▼                                  │    │
│  │  ┌────────────────────────────────────────────────────────┐    │    │
│  │  │              DATABASE MySQL (aciaa3820_db)              │    │    │
│  │  │  ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐  │    │    │
│  │  │  │ products │ │categories│ │transact. │ │ vouchers │  │    │    │
│  │  │  ├──────────┤ ├──────────┤ ├──────────┤ ├──────────┤  │    │    │
│  │  │  │ users    │ │ ratings  │ │ returns  │ │ banners  │  │    │    │
│  │  │  ├──────────┤ ├──────────┤ ├──────────┤ ├──────────┤  │    │    │
│  │  │  │stocks    │ │activity_ │ │notif.    │ │settings  │  │    │    │
│  │  │  │          │ │logs      │ │          │ │          │  │    │    │
│  │  │  └──────────┘ └──────────┘ └──────────┘ └──────────┘  │    │    │
│  │  └────────────────────────────────────────────────────────┘    │    │
│  │                                                      │    │
│  │  ┌──────────────────────────────────────────────────┐ │    │
│  │  │              VIEW (Blade + Tailwind)              │ │    │
│  │  │  ┌──────────────────────────────────────────┐    │ │    │
│  │  │  │           DASHBOARD ADMIN                 │    │ │    │
│  │  │  │  ┌──────────────────┐  ┌──────────────┐  │    │ │    │
│  │  │  │  │   Stat Cards     │  │   Charts     │  │    │ │    │
│  │  │  │  │ (5 summary box) │  │ (bar chart)  │  │    │ │    │
│  │  │  │  ├──────────────────┤  ├──────────────┤  │    │ │    │
│  │  │  │  │   Recent Tables  │  │   Alerts     │  │    │ │    │
│  │  │  │  │ (transaksi,top) │  │ (low stock)  │  │    │ │    │
│  │  │  │  └──────────────────┘  └──────────────┘  │    │ │    │
│  │  │  └──────────────────────────────────────────┘    │ │    │
│  │  └──────────────────────────────────────────────────┘    │    │
│  └─────────────────────────────────────────────────────────────┘    │
└──────────────────────────────────────────────────────────────────────┘
```

---

## 2. KOMPONEN DASHBOARD ADMIN

### 2.1 Struktur Routing

| Route | Method | Controller | Middleware | Fungsi |
|-------|--------|------------|------------|--------|
| `/admin/dashboard` | GET | `Admin\DashboardController@index` | `auth`, `admin` | Halaman utama dashboard |
| `/admin/product` | GET | `Admin\ProductController@index` | `auth`, `admin` | Daftar produk |
| `/admin/product/create` | GET | `Admin\ProductController@create` | `auth`, `admin` | Form tambah produk |
| `/admin/product/{id}/edit` | GET | `Admin\ProductController@edit` | `auth`, `admin` | Form edit produk |
| `/admin/product` | POST | `Admin\ProductController@store` | `auth`, `admin` | Simpan produk baru |
| `/admin/product/{id}` | PUT | `Admin\ProductController@update` | `auth`, `admin` | Update produk |
| `/admin/product/{id}` | DELETE | `Admin\ProductController@destroy` | `auth`, `admin` | Hapus produk |
| `/admin/category` | GET/POST/PUT/DELETE | `Admin\CategoryController` | `auth`, `admin` | CRUD kategori |
| `/admin/voucher` | GET/POST/PUT/DELETE | `Admin\VoucherController` | `auth`, `admin` | CRUD voucher |
| `/admin/transaction` | GET | `Admin\TransactionController@index` | `auth`, `admin` | Daftar transaksi |
| `/admin/transaction/{id}` | GET | `Admin\TransactionController@show` | `auth`, `admin` | Detail transaksi |
| `/admin/transaction/{id}/status` | PUT | `Admin\TransactionController@updateStatus` | `auth`, `admin` | Update status |
| `/admin/transaction/{id}/payment` | PUT | `Admin\TransactionController@updatePayment` | `auth`, `admin` | Update status bayar |
| `/admin/transaction/{id}/resi` | PUT | `Admin\TransactionController@updateTracking` | `auth`, `admin` | Input resi |
| `/admin/rating` | GET | `Admin\RatingController@index` | `auth`, `admin` | Daftar rating |
| `/admin/rating/{id}/approve` | PUT | `Admin\RatingController@approve` | `auth`, `admin` | Setujui ulasan |
| `/admin/rating/{id}/reply` | POST | `Admin\RatingController@reply` | `auth`, `admin` | Balas ulasan |
| `/admin/retur` | GET | `Admin\ReturController@index` | `auth`, `admin` | Daftar retur |
| `/admin/retur/{id}/approve` | PUT | `Admin\ReturController@approve` | `auth`, `admin` | Setujui retur |
| `/admin/retur/{id}/reject` | PUT | `Admin\ReturController@reject` | `auth`, `admin` | Tolak retur |
| `/admin/banner` | GET/POST/PUT/DELETE | `Admin\BannerController` | `auth`, `admin` | CRUD banner |
| `/admin/report` | GET | `Admin\ReportController@index` | `auth`, `admin` | Laporan penjualan |
| `/admin/report/export` | GET | `Admin\ReportController@export` | `auth`, `admin` | Export Excel |
| `/admin/stock/{product}` | GET/POST | `Admin\StockController` | `auth`, `admin` | Manajemen stok |
| `/admin/user` | GET | `Admin\UserController@index` | `auth`, `admin` | Daftar user |
| `/admin/user/{id}` | DELETE | `Admin\UserController@destroy` | `auth`, `admin` | Hapus user |

---

### 2.2 Middleware — Proteksi Akses

```
Request → Route (/admin/*) → Middleware 'auth' → Middleware 'admin' → Controller
                                │                      │
                                ▼                      ▼
                         Belum login?             Role = admin?
                         → Redirect /login        → 403 Forbidden
```

**Implementasi `AdminMiddleware`:**

| Method | Logika |
|--------|--------|
| `handle($request, $next)` | Cek `auth()->user()->role === 'admin'` |
| Jika bukan admin | Return `abort(403)` atau redirect ke beranda |
| Jika admin | Lanjut ke controller (`return $next($request)`) |

---

### 2.3 Controller — DashboardController@index

**File:** `app/Http/Controllers/Admin/DashboardController.php`

**Method:** `index()`

**Query yang dijalankan:**

| No | Data | Query | Tujuan |
|:--:|------|-------|--------|
| 1 | Total Produk | `Product::count()` | Stat card |
| 2 | Total Kategori | `Category::count()` | Stat card |
| 3 | Total Customer | `User::where('role','customer')->count()` | Stat card |
| 4 | Total Transaksi | `Transaction::count()` | Stat card |
| 5 | Total Pendapatan | `Transaction::where('payment_status','paid')->sum('grand_total')` | Stat card |
| 6 | Transaksi per Status | `Transaction::selectRaw("status, count(*) as total")->groupBy('status')->get()` | Overview status |
| 7 | Pendapatan 6 Bulan | `Transaction::where('payment_status','paid')->whereBetween('paid_at', ...)->selectRaw("...")->groupBy('month')->get()` | Grafik batang |
| 8 | 10 Produk Terlaris | `Product::orderBy('sold_count','desc')->take(10)->get()` | Grafik batang |
| 9 | 5 Transaksi Terbaru | `Transaction::with('user')->latest()->take(5)->get()` | Tabel recent |
| 10 | Stok Menipis | `Product::where('stock','<=',15)->orderBy('stock','asc')->take(10)->get()` | Alert |
| 11 | 5 Customer Teraktif | `User::withCount('transactions')->where('role','customer')->orderBy('transactions_count','desc')->take(5)->get()` | Top customer |

---

### 2.4 Tampilan Dashboard

**File View:** `resources/views/admin/dashboard/index.blade.php`

**Struktur Layout:**

```
┌─────────────────────────────────────────────────────────────────┐
│  [Sidebar]                        [Content Area]                │
│  ┌─────────┐                      ┌──────────────────────────┐  │
│  │ Logo    │                      │   DASHBOARD              │  │
│  │         │                      │                          │  │
│  │ ☐ Dash. │                      │ ┌───┐ ┌───┐ ┌───┐ ┌───┐ │  │
│  │ ☐ Produk│                      │ │ P │ │ K │ │ C │ │ T │ │  │
│  │ ☐ Ktgri │                      │ │ r │ │ t │ │ u │ │ r │ │  │
│  │ ☐ Trans │                      │ │ o │ │ g │ │ s │ │ a │ │  │
│  │ ☐ Vouch │                      │ │ d │ │ r │ │ t │ │ n │ │  │
│  │ ☐ Rating│                      │ └───┘ └───┘ └───┘ └───┘ │  │
│  │ ☐ Retur │                      │ ┌──────────────────────┐ │  │
│  │ ☐ Banner│                      │ │  Grafik Pendapatan   │ │  │
│  │ ☐ Lapor │                      │ │  (Bar Chart 6 bulan) │ │  │
│  │ ☐ Stok  │                      │ └──────────────────────┘ │  │
│  │ ☐ User  │                      │ ┌──────────┐ ┌────────┐ │  │
│  │         │                      │ │ Produk  │ │ Trans  │ │  │
│  │         │                      │ │ Terlaris│ │ Terbaru│ │  │
│  │ Logout  │                      │ └──────────┘ └────────┘ │  │
│  └─────────┘                      │ ┌──────────┐ ┌────────┐ │  │
│                                   │ │ Stok    │ │ Top    │ │  │
│                                   │ │ Menipis │ │ Cust.  │ │  │
│                                   │ └──────────┘ └────────┘ │  │
│                                   └──────────────────────────┘  │
└─────────────────────────────────────────────────────────────────┘
```

**Komponen View:**

| Section | Blade Component | Data Source |
|---------|----------------|-------------|
| Stat Cards | `@include('admin.dashboard._stat_cards')` | Total produk, kategori, customer, transaksi, pendapatan |
| Grafik Pendapatan | `@include('admin.dashboard._revenue_chart')` | 6 bulan terakhir (bulan, total) |
| Produk Terlaris | `@include('admin.dashboard._top_products')` | 10 produk dengan sold_count tertinggi |
| Transaksi Terbaru | `@include('admin.dashboard._recent_transactions')` | 5 transaksi terakhir |
| Stok Menipis | `@include('admin.dashboard._low_stock')` | Produk dengan stock ≤ 15 |
| Top Customer | `@include('admin.dashboard._top_customers')` | 5 customer dengan transaksi terbanyak |

**Grafik menggunakan Chart.js:**

```javascript
// Data pendapatan 6 bulan
const revenueData = {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
    datasets: [{
        label: 'Pendapatan',
        data: [5000000, 7000000, 6500000, 8000000, 9500000, 11000000],
        backgroundColor: '#4F46E5'
    }]
};

// Data produk terlaris
const topProductData = {
    labels: ['Produk A', 'Produk B', 'Produk C', ...],
    datasets: [{
        label: 'Terjual',
        data: [50, 45, 40, ...],
        backgroundColor: '#10B981'
    }]
};
```

---

### 2.5 Alur Data Dashboard

```
                        REQUEST dari Admin Browser
                                │
                                ▼
                        GET /admin/dashboard
                                │
                                ▼
                    ┌───────────────────────┐
                    │  AdminMiddleware       │
                    │  Cek: role == admin?   │
                    │  → Ya: lanjut         │
                    │  → Tidak: 403         │
                    └───────────┬───────────┘
                                │
                                ▼
                    ┌───────────────────────┐
                    │  DashboardController  │
                    │  @index()             │
                    └───────────┬───────────┘
                                │
                    ┌───────────┴───────────┐
                    │  11 Queries ke DB     │
                    │                       │
                    │  Product::count()     │
                    │  User::count()        │
                    │  Transaction::sum()   │
                    │  ...                  │
                    └───────────┬───────────┘
                                │
                                ▼
                    ┌───────────────────────┐
                    │  Compact data ke View │
                    │  return view(         │
                    │   'admin.dashboard',  │
                    │   compact(            │
                    │    'totalProducts',   │
                    │    'totalCategories', │
                    │    'totalCustomers',  │
                    │    'totalTrans',      │
                    │    'totalRevenue',    │
                    │    'revenueData',     │
                    │    'topProducts',     │
                    │    'recentTrans',     │
                    │    'lowStock',        │
                    │    'topCustomers'     │
                    │   )                  │
                    │  )                   │
                    └───────────┬───────────┘
                                │
                                ▼
                    ┌───────────────────────┐
                    │  BLADE VIEW           │
                    │  Render dengan        │
                    │  Tailwind + Alpine.js │
                    │  + Chart.js           │
                    └───────────┬───────────┘
                                │
                                ▼
                    RESPONSE HTML ke Admin Browser
```

---

## 3. DAFTAR SELURUH HALAMAN ADMIN

| No | Halaman | Route | Controller |
|:--:|---------|-------|------------|
| 1 | **Dashboard** | `/admin/dashboard` | `DashboardController@index` |
| 2 | **Produk** | `/admin/product` | `ProductController@index/create/store/edit/update/destroy` |
| 3 | **Stok** | `/admin/stock/{product}` | `StockController@index/store` |
| 4 | **Kategori** | `/admin/category` | `CategoryController@index/create/store/edit/update/destroy` |
| 5 | **Banner** | `/admin/banner` | `BannerController@index/create/store/edit/update/destroy` |
| 6 | **Voucher** | `/admin/voucher` | `VoucherController@index/create/store/edit/update/destroy` |
| 7 | **Transaksi** | `/admin/transaction` | `TransactionController@index/show/updateStatus/updatePayment/updateTracking` |
| 8 | **Rating** | `/admin/rating` | `RatingController@index/approve/reply/destroy` |
| 9 | **Retur** | `/admin/retur` | `ReturController@index/approve/reject/complete` |
| 10 | **User** | `/admin/user` | `UserController@index/destroy` |
| 11 | **Laporan** | `/admin/report` | `ReportController@index/export` |

---

## 4. TEKNOLOGI YANG DIGUNAKAN DI DASHBOARD

| Komponen | Teknologi |
|----------|-----------|
| **Layout** | Blade Template + Tailwind CSS |
| **Sidebar Navigation** | Alpine.js (toggle collapse, active state) |
| **Stat Cards** | Tailwind CSS (grid, shadow, rounded) |
| **Grafik Batang** | Chart.js (CDN) |
| **Tabel Data** | Tailwind CSS (table striped, hover) |
| **Modal Konfirmasi** | Alpine.js (x-show, x-transition) |
| **Flash Message** | Alpine.js (auto-hide after 3s) |
| **Badge Status** | Tailwind CSS (warna: kuning/biru/hijau/merah) |
| **Pagination** | Laravel Pagination + Tailwind |
| **Filter & Search** | Laravel Query Builder + Alpine.js |
| **Export Excel** | Laravel Excel (Maatwebsite) |
