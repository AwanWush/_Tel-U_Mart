<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('riwayat_pembelian', function (Blueprint $table) {
            if (!Schema::hasColumn('riwayat_pembelian', 'kurir_id')) {
                $table->unsignedBigInteger('kurir_id')->nullable()->after('user_id');

                $table->foreign('kurir_id')
                    ->references('id')
                    ->on('users')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_pembelian', function (Blueprint $table) {
            if (Schema::hasColumn('riwayat_pembelian', 'kurir_id')) {
                $table->dropForeign(['kurir_id']);
                $table->dropColumn('kurir_id');
            }
        });
    }
};