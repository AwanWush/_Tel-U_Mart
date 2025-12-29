<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Matikan check foreign key agar bisa drop tabel yang nyangkut
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('carts');
        Schema::dropIfExists('cart_items'); // Hapus juga cart_items agar bersih
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            // Relasi ke User
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // Relasi ke Produk
            $table->foreignId('produk_id')
                ->constrained('produk')
                ->cascadeOnDelete();

            $table->integer('quantity')->default(1);
            $table->timestamps();

            // Mencegah duplikat: 1 user hanya punya 1 baris untuk 1 produk yang sama
            $table->unique(['user_id', 'produk_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};