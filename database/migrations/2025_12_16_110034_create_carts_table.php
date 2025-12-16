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

        Schema::dropIfExists('carts'); 

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::create('carts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');   // Untuk relasi antara User dan Cart
            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade'); // Untuk relasi antara Product dan Cart
            $table->integer('quantity')->default(1);
            $table->index('user_id');   // Indexing untuk meningkatkan performa
            $table->index('produk_id');

            $table->timestamps();

            $table->unique(['user_id', 'produk_id']);  // Untuk memastikan user tidak dapat menambahkan product yang sama kedalam cart
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
