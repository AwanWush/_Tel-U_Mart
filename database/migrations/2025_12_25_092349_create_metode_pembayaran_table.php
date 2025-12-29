<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::dropIfExists('metode_pembayaran'); 

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Schema::create('metode_pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('kategori'); // E-Wallet, VA, dll
            $table->string('bank')->nullable();
            $table->string('norek')->nullable();
            $table->string('telepon')->nullable();
            $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metode_pembayaran');
    }
};
