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
        $table->string('alamat_pengantaran')->nullable()->after('tipe_layanan');
    });
}

public function down(): void
{
    Schema::table('riwayat_pembelian', function (Blueprint $table) {
        $table->dropColumn('alamat_pengantaran');
    });
}
};
