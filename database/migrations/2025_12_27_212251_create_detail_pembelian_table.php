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
    Schema::create('detail_pembelian', function (Blueprint $table) {
        $table->id();
        // Menghubungkan ke tabel riwayat_pembelian
        $table->foreignId('riwayat_pembelian_id')->constrained('riwayat_pembelian')->onDelete('cascade');
        
        $table->string('nama_produk');
        $table->integer('harga_satuan');
        $table->integer('jumlah');
        $table->integer('subtotal');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_pembelian');
    }
};
