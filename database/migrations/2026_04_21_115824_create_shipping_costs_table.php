<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_costs', function (Blueprint $table) {
            $table->id();
            $table->string('origin_city_id');
            $table->string('destination_city_id');
            $table->string('courier');
            $table->string('service');
            $table->string('description')->nullable();
            $table->integer('cost');
            $table->string('etd')->nullable();
            $table->timestamp('expires_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_costs');
    }
};