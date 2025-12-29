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
public function up()
{
    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    Schema::dropIfExists('riwayat_pembelian'); 

    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    Schema::create('riwayat_pembelian', function (Blueprint $table) { // Ganti Blueprint
        $table->id();
        $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
        $table->string('id_transaksi')->unique(); 
        $table->integer('total_harga');
        $table->string('status'); 
        $table->string('metode_pembayaran'); 
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
