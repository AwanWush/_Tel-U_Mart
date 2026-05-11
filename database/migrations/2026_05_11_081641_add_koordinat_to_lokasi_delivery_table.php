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
        Schema::table('lokasi_delivery', function (Blueprint $table) {
            $table->decimal('latitude', 10, 8)->nullable()->after('nama_gedung');
            $table->decimal('longitude', 11, 8)->nullable()->after('latitude');
            $table->unsignedBigInteger('mart_id')->nullable()->after('longitude');
            $table->foreign('mart_id')->references('id')->on('mart');
        });
    }

    public function down(): void
    {
        Schema::table('lokasi_delivery', function (Blueprint $table) {
            $table->dropForeign(['mart_id']);
            $table->dropColumn(['latitude', 'longitude', 'mart_id']);
        });
    }
};
