<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS update_status_antar_otomatis");

        DB::unprepared("CREATE TRIGGER update_status_antar_otomatis BEFORE INSERT ON riwayat_pembelian FOR EACH ROW BEGIN IF NEW.id_transaksi NOT LIKE 'REWARD-%' THEN IF NEW.tipe_layanan = 'delivery' OR NEW.tipe_layanan IS NULL THEN SET NEW.status_antar = 'diproses'; END IF; IF NEW.tipe_layanan IS NULL THEN SET NEW.tipe_layanan = 'delivery'; END IF; END IF; END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS update_status_antar_otomatis");
    }
};