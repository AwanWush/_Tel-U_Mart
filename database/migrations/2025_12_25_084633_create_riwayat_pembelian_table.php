<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::create('riwayat_pembelian', function (Table $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('id_transaksi')->unique(); // Contoh: TM-ABC123456789
        $table->integer('total_harga');
        $table->string('status'); // Sukses, Pending, Gagal
        $table->string('metode_pembayaran'); // COD, Transfer VA
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pembelian');
    }
};
