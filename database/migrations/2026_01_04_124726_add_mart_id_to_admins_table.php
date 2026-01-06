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
        Schema::table('admins', function (Blueprint $table) {
            // Menambahkan kolom mart_id sebagai foreign key
            $table->unsignedBigInteger('mart_id')->nullable()->after('user_id');
            $table->foreign('mart_id')->references('id')->on('mart')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['mart_id']);
            $table->dropColumn('mart_id');
        });
    }
};
