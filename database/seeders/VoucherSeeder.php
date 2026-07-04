<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voucher;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (Voucher::count() == 0) {
            $vouchers = [
                [
                    'code' => 'MEMBERSIP',
                    'name' => 'Member Voucher',
                    'description' => 'Diskon 10% untuk pembelian pertama fashion wanita',
                    'type' => 'percentage',
                    'value' => 20.00,
                    'min_purchase' => 100000.00,
                    'min_qty' => 0,
                    'max_discount' => 50000.00,
                    'max_usage' => 200,
                    'used_count' => 0,
                    'start_date' => now()->subDays(1),
                    'expiry_date' => now()->addMonths(3),
                    'is_active' => 1,
                    'user_type' => 'active_user',
                    'min_completed_orders' => 5,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'code' => 'FREESHIPP',
                    'name' => 'Gratis Ongkir',
                    'description' => 'Gratis ongkir minimal belanja Rp 150.000',
                    'type' => 'percentage',
                    'value' => 100.00,
                    'min_purchase' => 150000.00,
                    'min_qty' => 0,
                    'max_discount' => 50000.00,
                    'max_usage' => 100,
                    'used_count' => 0,
                    'start_date' => now()->subDays(1),
                    'expiry_date' => now()->addMonths(1),
                    'is_active' => 1,
                    'user_type' => 'general',
                    'min_completed_orders' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'code' => 'HEMAT30',
                    'name' => 'Diskon 30%',
                    'description' => 'Diskon 30% khusus fashion, maksimal Rp 50.000',
                    'type' => 'percentage',
                    'value' => 30.00,
                    'min_purchase' => 500000.00,
                    'min_qty' => 0,
                    'max_discount' => 50000.00,
                    'max_usage' => 50,
                    'used_count' => 0,
                    'start_date' => now()->subDays(1),
                    'expiry_date' => now()->addMonths(1),
                    'is_active' => 1,
                    'user_type' => 'general',
                    'min_completed_orders' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'code' => 'PROMO50K',
                    'name' => 'Potongan Rp 50.000',
                    'description' => 'Potongan Rp 50.000 minimal belanja Rp 200.000',
                    'type' => 'fixed',
                    'value' => 50000.00,
                    'min_purchase' => 200000.00,
                    'min_qty' => 0,
                    'max_discount' => 50000.00,
                    'max_usage' => 80,
                    'used_count' => 0,
                    'start_date' => now()->subDays(1),
                    'expiry_date' => now()->addMonths(2),
                    'is_active' => 1,
                    'user_type' => 'general',
                    'min_completed_orders' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'code' => 'BUY5',
                    'name' => 'Beli 5 Item Gratis Ongkir',
                    'description' => 'Beli minimal 5 item, gratis ongkir',
                    'type' => 'percentage',
                    'value' => 100.00,
                    'min_purchase' => 0.00,
                    'min_qty' => 5,
                    'max_discount' => 60000.00,
                    'max_usage' => 50,
                    'used_count' => 0,
                    'start_date' => now()->subDays(1),
                    'expiry_date' => now()->addMonths(3),
                    'is_active' => 1,
                    'user_type' => 'general',
                    'min_completed_orders' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ];

            Voucher::insert($vouchers);
        }
    }
}
