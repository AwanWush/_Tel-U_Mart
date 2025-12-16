<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('galon_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('nama_galon');         
            $table->integer('harga_satuan');      
            $table->integer('jumlah');           
            $table->integer('total_harga');       

            $table->text('catatan')->nullable();
            $table->string('status')->default('pending'); 

            $table->timestamp('waktu_transaksi')->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('galon_transactions');
    }
};
