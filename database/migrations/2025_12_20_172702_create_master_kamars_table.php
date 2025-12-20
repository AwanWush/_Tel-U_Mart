<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('nomor_kamar', 10)->nullable()->after('alamat_gedung');
        });

        Schema::create('master_kamars', function (Blueprint $table) {
            $table->id();
            $table->integer('lantai');
            $table->string('nomor_kamar', 5);
        });

        $data = [];
        
        // Lantai 1 (101-110)
        for ($i = 101; $i <= 110; $i++) { $data[] = ['lantai' => 1, 'nomor_kamar' => (string)$i]; }
        // Lantai 2 (201-220)
        for ($i = 201; $i <= 220; $i++) { $data[] = ['lantai' => 2, 'nomor_kamar' => (string)$i]; }
        // Lantai 3 (301-320)
        for ($i = 301; $i <= 320; $i++) { $data[] = ['lantai' => 3, 'nomor_kamar' => (string)$i]; }
        // Lantai 4 (401-420)
        for ($i = 401; $i <= 420; $i++) { $data[] = ['lantai' => 4, 'nomor_kamar' => (string)$i]; }

        DB::table('master_kamars')->insert($data);
    }

    public function down(): void
    {
        Schema::dropIfExists('master_kamars');
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('nomor_kamar');
        });
    }
};