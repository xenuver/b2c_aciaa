<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Product;
use Illuminate\Console\Command;

class SendPromoEmail extends Command
{
    protected $signature = 'promo:send';
    protected $description = 'Kirim notifikasi promo web ke semua customer';

    public function handle()
    {
        // Ambil produk promo (max 5)
        $promoProducts = Product::where('is_active', 1)
            ->where('is_promo', 1)
            ->orWhereNotNull('discount_price')
            ->limit(5)
            ->get();

        if ($promoProducts->isEmpty()) {
            $this->info('Tidak ada produk promo.');
            return;
        }

        // Ambil semua customer
        $customers = User::where('role', 'customer')->get();

        $this->info('Mengirim notifikasi ke ' . $customers->count() . ' customer...');

        // Format nama produk promo untuk pesan
        $productNames = $promoProducts->pluck('name')->map(function($name) {
            return '"' . $name . '"';
        })->join(', ');

        foreach ($customers as $customer) {
            \App\Models\Notification::create([
                'user_id' => $customer->id,
                'title' => 'Promo Spesial Untuk Anda! ✨',
                'message' => "Halo {$customer->name}, nikmati promo khusus untuk produk pilihan kami: {$productNames}. Jangan lewatkan kesempatan ini!",
                'type' => 'promo',
                'link' => route('products.index'),
                'is_read' => false,
            ]);
            $this->info("Notifikasi web terkirim ke: {$customer->name}");
        }

        $this->info('Selesai!');
    }
}