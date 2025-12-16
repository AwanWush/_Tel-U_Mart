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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::dropIfExists('wishlists'); 

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::create('wishlists', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');   // Untuk relasi antara User dan Wishlist
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade'); // Untuk relasi antara Product dan Wishlist
            $table->index('user_id');   // Indexing untuk meningkatkan performa
            $table->index('produk_id');

            $table->timestamps();

            $table->unique(['user_id', 'produk_id']);  // Memastikan agar user bisa wishlist produk yang sama
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
