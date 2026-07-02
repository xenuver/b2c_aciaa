<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            if (!Schema::hasColumn('vouchers', 'min_qty')) {
                $table->integer('min_qty')->default(0)->after('min_purchase');
            }
        });

        // Safe modify enum for MySQL
        DB::statement("ALTER TABLE vouchers MODIFY COLUMN type ENUM('percentage', 'fixed', 'free_shipping') NOT NULL DEFAULT 'percentage'");
    }

    public function down(): void
    {
        Schema::table('vouchers', function (Blueprint $table) {
            if (Schema::hasColumn('vouchers', 'min_qty')) {
                $table->dropColumn('min_qty');
            }
        });

        DB::statement("ALTER TABLE vouchers MODIFY COLUMN type ENUM('percentage', 'fixed') NOT NULL DEFAULT 'percentage'");
    }
};
