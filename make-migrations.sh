#!/bin/bash

# Tabel master
php artisan make:migration create_categories_table
php artisan make:migration create_products_table
php artisan make:migration create_banners_table
php artisan make:migration create_vouchers_table

# Tabel transaksi
php artisan make:migration create_transactions_table
php artisan make:migration create_transaction_details_table

# Tabel keranjang
php artisan make:migration create_carts_table
php artisan make:migration create_cart_items_table

# Tabel wishlist
php artisan make:migration create_wishlists_table

# Tabel retur
php artisan make:migration create_returs_table
php artisan make:migration create_retur_items_table

# Tabel notifikasi
php artisan make:migration create_notifications_table
php artisan make:migration create_notification_settings_table

# Tabel rating & ulasan
php artisan make:migration create_ratings_table

# Tabel customer service
php artisan make:migration create_customer_service_messages_table

# Tabel log aktivitas
php artisan make:migration create_activity_logs_table

# Tabel stok
php artisan make:migration create_stocks_table

# Tabel ongkos kirim (cache rajaongkir)
php artisan make:migration create_shipping_costs_table

# Tabel voucher klaim & log
php artisan make:migration create_user_vouchers_table
php artisan make:migration create_voucher_usage_logs_table

# Tabel alamat pengiriman
php artisan make:migration create_user_addresses_table

# Tabel setting toko
php artisan make:migration create_store_settings_table

# Tabel laporan keuangan & dashboard
php artisan make:migration create_financial_reports_table
php artisan make:migration create_daily_sales_summaries_table

echo "Semua migration telah dibuat!"