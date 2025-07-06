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
        Schema::create('makanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('penjual_id')->constrained()->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('original_price')->nullable();
            $table->integer('discounted_price')->nullable();
            $table->integer('first_stock')->default(0);
            $table->integer('current_stock')->default(0);
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->date('date_upload')->nullable();
            $table->enum('status', ['available', 'unavailable', 'inactive', 'expired'])->default('inactive');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('makanans');
    }
};
