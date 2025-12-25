<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::dropIfExists('produk_mart'); 
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::create('produk_mart', function (Blueprint $table) {
            $table->id();

            $table->foreignId('produk_id')->constrained('produk')->onDelete('cascade');
            $table->foreignId('mart_id')->constrained('mart')->onDelete('cascade');

            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('produk_mart');
    }
};
