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
        Schema::table('riwayat_pembelian', function (Blueprint $table) {
            $table->string('tipe_layanan')->nullable()->after('metode_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_pembelian', function (Blueprint $table) {
            $table->dropColumn('tipe_layanan');
        });
    }
};
