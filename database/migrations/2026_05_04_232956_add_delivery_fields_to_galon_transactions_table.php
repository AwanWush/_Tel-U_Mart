<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galon_transactions', function (Blueprint $table) {
            // Tambahkan kolom setelah metode_pembayaran
            $table->string('metode_pengiriman')->default('ambil')->after('metode_pembayaran');
            $table->integer('ongkir')->default(0)->after('metode_pengiriman');
        });
    }

    public function down(): void
    {
        Schema::table('galon_transactions', function (Blueprint $table) {
            $table->dropColumn(['metode_pengiriman', 'ongkir']);
        });
    }
};
