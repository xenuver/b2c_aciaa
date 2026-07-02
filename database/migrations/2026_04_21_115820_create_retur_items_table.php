<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('retur_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('retur_id');
            $table->unsignedBigInteger('transaction_detail_id');
            $table->integer('quantity');
            $table->decimal('refund_amount', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('retur_items');
    }
};