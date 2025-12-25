<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('token_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('gedung');
            $table->string('kamar');
            $table->string('nama_penghuni')->nullable();
            $table->string('nomor_hp')->nullable();

        
            $table->integer('nominal');    
            $table->string('metode');      
            $table->string('kode_token');     
            $table->integer('total_harga');   
            $table->string('status')->default('Berhasil');

            $table->timestamps();
        });
    }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('token_transactions');
    }
};

