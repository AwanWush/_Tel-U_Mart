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
        Schema::table('riwayat_pembelian', function (Blueprint $table) {
            $table->string('jarak')->nullable()->after('alamat_pengantaran');
            $table->string('durasi')->nullable()->after('jarak');
        });
    }

    public function down()
    {
        Schema::table('riwayat_pembelian', function (Blueprint $table) {
            $table->dropColumn(['jarak', 'durasi']);
        });
    }
};
