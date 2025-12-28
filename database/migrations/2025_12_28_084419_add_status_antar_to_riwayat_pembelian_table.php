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
        // Menambahkan kolom status_antar setelah kolom status
        $table->string('status_antar')->nullable()->after('status'); 
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('riwayat_pembelian', function (Blueprint $table) {
            //
        });
    }
};
