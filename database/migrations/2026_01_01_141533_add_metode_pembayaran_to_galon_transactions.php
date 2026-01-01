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
        Schema::table('galon_transactions', function (Blueprint $table) {
            $table->string('metode_pembayaran', 20)
                ->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('galon_transactions', function (Blueprint $table) {
            $table->dropColumn('metode_pembayaran');
        });
    }
};
