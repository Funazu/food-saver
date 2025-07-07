<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pembeli_id')->constrained()->onDelete('cascade');
            $table->foreignId('penjual_id')->constrained()->onDelete('cascade');
            $table->foreignId('makanan_id')->constrained()->onDelete('cascade');
            $table->integer('quantity')->default(1);
            $table->integer('total_price')->default(0);
            $table->enum('status', ['pending', 'dikonfirmasi', 'siap_diambil', 'sudah_diambil', 'dibatalkan_pembeli', 'dibatalkan_penjual'])->default('pending');
            $table->dateTime('order_date')->nullable();
            $table->dateTime('pickup_date')->nullable();
            $table->enum('payment_method', ['cash', 'transfer', 'qris'])->default('cash');
            $table->string('unique_code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
