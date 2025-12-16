<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('lokasi_delivery')) {
            Schema::create('lokasi_delivery', function (Blueprint $table) {
                $table->id();
                $table->string('nama_lokasi');
                $table->string('nama_gedung')->nullable();
                $table->string('foto')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('lokasi_delivery');
    }
};
