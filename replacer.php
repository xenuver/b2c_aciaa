<?php
// Script untuk copy semua gambar dari public/seed_images ke storage
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
    
    Artisan::call('view:clear');
    Artisan::call('cache:clear');
    
    return response()->json([
        'status' => 'SUCCESS',
        'files_copied' => count($results),
        'files' => $results
    ]);
});
