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

        Schema::dropIfExists('produk'); 

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::create('produk', function (Blueprint $table) {
            $table->id();

            $table->foreignId('kategori_id')->constrained('kategori_produk')->onDelete('cascade');
            $table->string('nama_produk');
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 12, 2);
            $table->integer('stok')->nullable()->default(0);
            $table->string('gambar')->nullable();
            $table->enum('status_ketersediaan', ['Tersedia', 'Habis'])->default('Tersedia');
            $table->boolean('is_active')->default(true);
            $table->decimal('persentase_diskon', 5, 2)->nullable();   // Diskon diasumsikan mulai dari 0–90%

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
