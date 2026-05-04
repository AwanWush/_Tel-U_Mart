<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            if (!Schema::hasColumn('admins', 'nama_custom')) {
                $table->string('nama_custom')->nullable()->after('user_id');
            }

            if (!Schema::hasColumn('admins', 'gaji')) {
                $table->decimal('gaji', 12, 2)->default(0)->after('nomor_rekening');
            }

            if (!Schema::hasColumn('admins', 'tanggal_gaji')) {
                $table->timestamp('tanggal_gaji')->nullable()->after('gaji');
            }
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropColumn([
                'nama_custom',
                'gaji',
                'tanggal_gaji'
            ]);
        });
    }
};