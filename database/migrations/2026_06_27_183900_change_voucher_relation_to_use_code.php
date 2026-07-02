<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('user_vouchers', function (Blueprint $table) {
            // 1. Create temporary index on user_id to satisfy foreign key constraint
            $table->index('user_id', 'user_vouchers_user_id_fk_index');
            
            // 2. Drop unique index
            $table->dropUnique('user_vouchers_user_id_voucher_id_unique');
            
            // 3. Add voucher_code column
            $table->string('voucher_code', 50)->nullable()->after('voucher_id');
        });

        // Populate existing user_vouchers with the current code of their voucher
        $userVouchers = DB::table('user_vouchers')->get();
        foreach ($userVouchers as $uv) {
            $voucher = DB::table('vouchers')->where('id', $uv->voucher_id)->first();
            if ($voucher) {
                DB::table('user_vouchers')
                    ->where('id', $uv->id)
                    ->update(['voucher_code' => $voucher->code]);
            } else {
                // Fallback for dangling records
                DB::table('user_vouchers')
                    ->where('id', $uv->id)
                    ->update(['voucher_code' => 'UNKNOWN_' . $uv->voucher_id]);
            }
        }

        Schema::table('user_vouchers', function (Blueprint $table) {
            // Make voucher_code non-nullable after populating
            $table->string('voucher_code', 50)->nullable(false)->change();
            
            // Add unique index on user_id and voucher_code
            $table->unique(['user_id', 'voucher_code'], 'user_vouchers_user_id_voucher_code_unique');
            
            // Drop temporary index because user_vouchers_user_id_voucher_code_unique starts with user_id
            $table->dropIndex('user_vouchers_user_id_fk_index');
        });

        // Also add voucher_code to voucher_usage_logs for completeness
        Schema::table('voucher_usage_logs', function (Blueprint $table) {
            $table->string('voucher_code', 50)->nullable()->after('voucher_id');
        });

        // Populate existing voucher_usage_logs with the current code of their voucher
        $usageLogs = DB::table('voucher_usage_logs')->get();
        foreach ($usageLogs as $log) {
            $voucher = DB::table('vouchers')->where('id', $log->voucher_id)->first();
            if ($voucher) {
                DB::table('voucher_usage_logs')
                    ->where('id', $log->id)
                    ->update(['voucher_code' => $voucher->code]);
            } else {
                DB::table('voucher_usage_logs')
                    ->where('id', $log->id)
                    ->update(['voucher_code' => 'UNKNOWN_' . $log->voucher_id]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('voucher_usage_logs', function (Blueprint $table) {
            $table->dropColumn('voucher_code');
        });

        Schema::table('user_vouchers', function (Blueprint $table) {
            $table->index('user_id', 'user_vouchers_user_id_fk_index2');
            $table->dropUnique('user_vouchers_user_id_voucher_code_unique');
            $table->dropColumn('voucher_code');
            $table->unique(['user_id', 'voucher_id'], 'user_vouchers_user_id_voucher_id_unique');
            $table->dropIndex('user_vouchers_user_id_fk_index2');
        });
    }
};
