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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama parfum
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->foreignId('category_id')->constrained();

            // Harga & stok
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);

            // Info khusus parfum
            $table->string('fragrance_family')->nullable(); // Floral, Citrus, Woody, Oriental, Aquatic, dsb
            $table->integer('volume_ml')->default(50); // ukuran botol dalam ml

            // === FIELD UNTUK REKOMENDASI ===
            $table->enum('gender_target', ['male', 'female', 'unisex'])->default('unisex');
            $table->enum('usage_time', ['morning', 'night', 'all_day'])->nullable();
            $table->enum('situation', ['indoor', 'outdoor', 'mixed'])->nullable();
            $table->enum('longevity', ['long_last', 'light_frequent'])->nullable();

            $table->string('image')->nullable();
            $table->boolean('enabled')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
