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
        Schema::table('admins', function (Blueprint $table) {
            if (! Schema::hasColumn('admins', 'nama_bank')) {
                $table->string('nama_bank')->nullable();
            }
            if (! Schema::hasColumn('admins', 'nomor_rekening')) {
                $table->string('nomor_rekening')->unique()->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn(['nama_bank', 'nomor_rekening']);
        });
    }
};
