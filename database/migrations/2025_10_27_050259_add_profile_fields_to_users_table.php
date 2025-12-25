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
        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'no_telp')) {
                $table->string('no_telp')->nullable();
            }
            if (!Schema::hasColumn('users', 'alamat_gedung')) {
                $table->string('alamat_gedung')->nullable();
            }
            if (!Schema::hasColumn('users', 'gambar')) {
                $table->string('gambar')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};

