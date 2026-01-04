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
        Schema::table('mart', function (Blueprint $table) {
            // Menambahkan kolom status untuk fitur aktif/nonaktifkan unit mart
            $table->string('status')->default('aktif')->after('nama_mart');
        });
    }

    public function down(): void
    {
        Schema::table('mart', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
