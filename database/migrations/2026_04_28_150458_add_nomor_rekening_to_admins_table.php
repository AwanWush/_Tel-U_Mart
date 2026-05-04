<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('admins', 'nomor_rekening')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->string('nomor_rekening')->nullable()->after('nama_bank');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('admins', 'nomor_rekening')) {
            Schema::table('admins', function (Blueprint $table) {
                $table->dropColumn('nomor_rekening');
            });
        }
    }
};