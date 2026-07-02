<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('transaction_id')->nullable();
            $table->integer('rating')->unsigned()->default(5);
            $table->text('review')->nullable();
            $table->json('images')->nullable();
            $table->boolean('is_approved')->default(true);
            $table->timestamps();
            $table->unique(['user_id', 'product_id', 'transaction_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};