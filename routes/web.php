<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\ReturController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

// ========== HALAMAN FRONTEND (KONSUMEN) ==========
// Halaman Landing & Beranda
Route::get('/', [HomeController::class, 'landing'])->name('landing');
Route::get('/home', [HomeController::class, 'index'])->name('home');

// Halaman Voucher & Klaim
Route::get('/vouchers', [HomeController::class, 'vouchers'])->name('vouchers.index');
Route::post('/vouchers/claim/{id}', [HomeController::class, 'claimVoucher'])->name('vouchers.claim')->middleware('auth');

// Halaman Produk
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/ajax', [ProductController::class, 'ajaxIndex'])->name('products.ajax');
    Route::get('/{slug}', [ProductController::class, 'show'])->name('products.show');
 // Route::get('/search', [ProductController::class, 'search'])->name('products.search');
});

// Cart (Keranjang Belanja)
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add', [CartController::class, 'add'])->name('cart.add');
    Route::put('/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/count', [CartController::class, 'getCount'])->name('cart.count'); // Added for navbar badge
    
    // AJAX routes
    Route::put('/{id}/ajax', [CartController::class, 'ajaxUpdate'])->name('cart.ajax.update');
    Route::delete('/{id}/ajax', [CartController::class, 'ajaxRemove'])->name('cart.ajax.remove');
});

// Direct Checkout (Beli Langsung dari Detail Produk)
Route::middleware(['auth'])->match(['get', 'post'], '/checkout/direct/{productId}', [CheckoutController::class, 'direct'])->name('checkout.direct');

Route::middleware(['auth'])->get('/checkout/direct-form', [CheckoutController::class, 'directForm'])->name('checkout.direct-form');
Route::middleware(['auth'])->post('/checkout/direct-process', [CheckoutController::class, 'directProcess'])->name('checkout.direct-process');

// API Lokasi & Alamat (Untuk Raja Ongkir dan Pilihan Alamat di Checkout)
Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('/provinces', [CheckoutController::class, 'getProvinces'])->name('api.provinces');
    Route::get('/cities/{provinceId}', [CheckoutController::class, 'getCities'])->name('api.cities');
    Route::get('/subdistricts/{cityId}', [CheckoutController::class, 'getSubdistricts'])->name('api.subdistricts');
    Route::get('/addresses', [CheckoutController::class, 'getAddresses'])->name('api.addresses');
    Route::post('/addresses', [CheckoutController::class, 'storeAddress'])->name('api.addresses.store');
    Route::put('/addresses/{id}', [CheckoutController::class, 'updateAddress'])->name('api.addresses.update');
    Route::delete('/addresses/{id}', [CheckoutController::class, 'deleteAddress'])->name('api.addresses.delete');
    Route::post('/shipping-cost', [CheckoutController::class, 'getShippingCost'])->name('api.shipping-cost');
});

// Live Search API (publik, tanpa auth)
Route::get('/api/search/live', [ProductController::class, 'liveSearch'])->middleware('web')->name('api.search.live');

// Midtrans payment notification (webhook)
Route::post('/midtrans/notification', [MidtransController::class, 'notification'])->name('midtrans.notification');

// Checkout
Route::middleware(['auth'])->prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/claim-voucher', [CheckoutController::class, 'claimVoucherAtCheckout'])->name('checkout.claim-voucher');
    Route::get('/success/{id}', [CheckoutController::class, 'success'])->name('checkout.success');
});

// Riwayat Transaksi
Route::middleware(['auth'])->prefix('transactions')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('transactions.index');
    Route::get('/{id}', [TransactionController::class, 'show'])->name('transactions.show');
});

// Notifikasi Pelanggan
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [\App\Http\Controllers\NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read-redirect', [\App\Http\Controllers\NotificationController::class, 'readAndRedirect'])->name('notifications.read-redirect');
    Route::get('/api/notifications/unread-count', [\App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.unread-count');
    Route::get('/api/notifications/latest', [\App\Http\Controllers\NotificationController::class, 'latest'])->name('notifications.latest');
    Route::post('/notifications/{id}/read', [\App\Http\Controllers\NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/mark-all-read', [\App\Http\Controllers\NotificationController::class, 'markAllRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{id}', [\App\Http\Controllers\NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('/notifications/clear/all', [\App\Http\Controllers\NotificationController::class, 'clearAll'])->name('notifications.clear-all');
});


// Rating & Ulasan
Route::middleware(['auth'])->prefix('ratings')->group(function () {
    Route::get('/', [RatingController::class, 'myRatings'])->name('ratings.index');
    Route::get('/create/{productId}', [RatingController::class, 'create'])->name('ratings.create');
    Route::post('/', [RatingController::class, 'store'])->name('ratings.store');
    Route::get('/{id}/edit', [RatingController::class, 'edit'])->name('ratings.edit');
    Route::put('/{id}', [RatingController::class, 'update'])->name('ratings.update');
    Route::delete('/{id}', [RatingController::class, 'destroy'])->name('ratings.destroy');
});

// Retur Frontend (Customer) - HARUS DI LUAR GROUP ADMIN
Route::middleware(['auth'])->prefix('returs')->group(function () {
    Route::get('/', [ReturController::class, 'index'])->name('returs.index');
    Route::get('/create/{transactionId?}', [ReturController::class, 'create'])->name('returs.create');
    Route::post('/', [ReturController::class, 'store'])->name('returs.store');
    Route::get('/{id}', [ReturController::class, 'show'])->name('returs.show');
    Route::put('/{id}/cancel', [ReturController::class, 'cancel'])->name('returs.cancel');
    Route::get('/transaction/{id}/items', [ReturController::class, 'getTransactionItems'])->name('returs.items');
});

// Wishlist (Tanpa auth middleware)
Route::prefix('wishlist')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/toggle/{productId}', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::delete('/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');
    Route::get('/count', [WishlistController::class, 'getCount'])->name('wishlist.count');
    
    // AJAX routes
    Route::post('/ajax', [WishlistController::class, 'ajaxToggle'])->name('wishlist.ajax.toggle');
});

// Check Auth Status (untuk frontend)
Route::get('/check-auth', function () {
    return response()->json(['logged_in' => auth()->check()]);
})->name('check.auth');

// ========== HALAMAN ADMIN (BACKEND) ==========
// Group route admin dengan prefix 'admin' dan middleware
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Manajemen Produk
    Route::resource('products', App\Http\Controllers\Admin\ProductController::class)->names([
        'index' => 'admin.products.index',
        'create' => 'admin.products.create',
        'store' => 'admin.products.store',
        'edit' => 'admin.products.edit',
        'update' => 'admin.products.update',
        'destroy' => 'admin.products.destroy',
    ]);

    // Kelola Kategori
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class)->names([
        'index' => 'admin.categories.index',
        'create' => 'admin.categories.create',
        'store' => 'admin.categories.store',
        'edit' => 'admin.categories.edit',
        'update' => 'admin.categories.update',
        'destroy' => 'admin.categories.destroy',
    ]);

    // Kelola Banner
    Route::resource('banners', App\Http\Controllers\Admin\BannerController::class)->names([
        'index' => 'admin.banners.index',
        'create' => 'admin.banners.create',
        'store' => 'admin.banners.store',
        'edit' => 'admin.banners.edit',
        'update' => 'admin.banners.update',
        'destroy' => 'admin.banners.destroy',
    ]);

    // Kelola Transaksi
    Route::prefix('transactions')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\TransactionController::class, 'index'])->name('admin.transactions.index');
        Route::get('/{id}', [App\Http\Controllers\Admin\TransactionController::class, 'show'])->name('admin.transactions.show');
        Route::put('/{id}/status', [App\Http\Controllers\Admin\TransactionController::class, 'updateStatus'])->name('admin.transactions.update-status');
        Route::put('/{id}/payment', [App\Http\Controllers\Admin\TransactionController::class, 'updatePaymentStatus'])->name('admin.transactions.update-payment');
        Route::put('/{id}/tracking', [App\Http\Controllers\Admin\TransactionController::class, 'updateTracking'])->name('admin.transactions.update-tracking');
    });

    // Kelola Stok
    Route::prefix('stocks')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\StockController::class, 'index'])->name('admin.stocks.index');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\StockController::class, 'edit'])->name('admin.stocks.edit');
        Route::put('/{id}', [App\Http\Controllers\Admin\StockController::class, 'update'])->name('admin.stocks.update');
        Route::get('/{id}/history', [App\Http\Controllers\Admin\StockController::class, 'history'])->name('admin.stocks.history');
        Route::put('/bulk/update', [App\Http\Controllers\Admin\StockController::class, 'bulkUpdate'])->name('admin.stocks.bulk-update');
    });

    // Kelola Voucher
    Route::resource('vouchers', App\Http\Controllers\Admin\VoucherController::class)->names([
        'index' => 'admin.vouchers.index',
        'create' => 'admin.vouchers.create',
        'store' => 'admin.vouchers.store',
        'edit' => 'admin.vouchers.edit',
        'update' => 'admin.vouchers.update',
        'destroy' => 'admin.vouchers.destroy',
    ]);
    Route::get('/vouchers/{id}/usage', [App\Http\Controllers\Admin\VoucherController::class, 'usage'])->name('admin.vouchers.usage');

    // Kelola Pengguna
    Route::prefix('users')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('admin.users.index');
        Route::get('/{id}', [App\Http\Controllers\Admin\UserController::class, 'show'])->name('admin.users.show');
        Route::get('/{id}/edit', [App\Http\Controllers\Admin\UserController::class, 'edit'])->name('admin.users.edit');
        Route::put('/{id}', [App\Http\Controllers\Admin\UserController::class, 'update'])->name('admin.users.update');
        Route::put('/{id}/status', [App\Http\Controllers\Admin\UserController::class, 'updateStatus'])->name('admin.users.update-status');
        Route::delete('/{id}', [App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('admin.users.destroy');
    });

    // Laporan Penjualan
    Route::prefix('reports')->group(function () {
        Route::get('/sales', [App\Http\Controllers\Admin\ReportController::class, 'index'])->name('admin.reports.index');
        Route::get('/sales/export', [App\Http\Controllers\Admin\ReportController::class, 'export'])->name('admin.reports.export');
    });

    // Kelola Retur (Admin)
    Route::prefix('returs')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\ReturController::class, 'index'])->name('admin.returs.index');
        Route::get('/{id}', [App\Http\Controllers\Admin\ReturController::class, 'show'])->name('admin.returs.show');
        Route::put('/{id}/approve', [App\Http\Controllers\Admin\ReturController::class, 'approve'])->name('admin.returs.approve');
        Route::put('/{id}/reject', [App\Http\Controllers\Admin\ReturController::class, 'reject'])->name('admin.returs.reject');
        Route::put('/{id}/complete', [App\Http\Controllers\Admin\ReturController::class, 'complete'])->name('admin.returs.complete');
    });

    // Kelola Ulasan (Admin)
    Route::prefix('ratings')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\RatingController::class, 'index'])->name('admin.ratings.index');
        Route::put('/{id}/reply', [App\Http\Controllers\Admin\RatingController::class, 'reply'])->name('admin.ratings.reply');
        Route::put('/{id}/toggle-approve', [App\Http\Controllers\Admin\RatingController::class, 'toggleApprove'])->name('admin.ratings.toggle-approve');
        Route::delete('/{id}', [App\Http\Controllers\Admin\RatingController::class, 'destroy'])->name('admin.ratings.destroy');
    });
});

// ========== AUTHENTIKASI (DARI BREEZE) ==========
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ========== REDIRECT AFTER LOGIN ==========
Route::get('/redirect', [AdminAuthController::class, 'redirectAfterLogin'])->middleware('auth')->name('redirect');

require __DIR__.'/auth.php';

// Route ajaib untuk bypass Nginx symlink permission
Route::get('/render-image', function (Illuminate\Http\Request $request) {
    $path = $request->query('path');
    if (!$path) abort(404);
    
    $filePath = storage_path('app/public/' . $path);
    if (!file_exists($filePath)) {
        $filePath = storage_path('app/public/default.jpg');
        if (!file_exists($filePath)) abort(404);
    }
    
    try {
        return response()->file($filePath);
    } catch (\Exception $e) {
        return response($e->getMessage(), 500);
    }
})->name('render-image');

// Route setup: copy semua gambar dari public/seed_images ke persistent storage
Route::get('/setup-storage', function() {
    $results = [];
    $baseDir = public_path('seed_images');

    // Copy products images
    $productsDir = storage_path('app/public/products');
    if (!is_dir($productsDir)) mkdir($productsDir, 0755, true);
    foreach (glob($baseDir . '/products_*') as $file) {
        $newName = str_replace('products_', '', basename($file));
        copy($file, $productsDir . '/' . $newName);
        $results[] = 'products/' . $newName;
    }

    // Copy banners images
    $bannersDir = storage_path('app/public/banners');
    if (!is_dir($bannersDir)) mkdir($bannersDir, 0755, true);
    foreach (glob($baseDir . '/banners_*') as $file) {
        $newName = str_replace('banners_', '', basename($file));
        copy($file, $bannersDir . '/' . $newName);
        $results[] = 'banners/' . $newName;
    }

    // Copy default.jpg
    if (file_exists($baseDir . '/default.jpg')) {
        copy($baseDir . '/default.jpg', storage_path('app/public/default.jpg'));
        $results[] = 'default.jpg';
    }

    \Illuminate\Support\Facades\Artisan::call('view:clear');
    \Illuminate\Support\Facades\Artisan::call('cache:clear');

    return response()->json([
        'status' => 'SUCCESS ✅',
        'total_files_copied' => count($results),
        'files' => $results,
    ]);
});