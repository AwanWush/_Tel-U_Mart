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
    public function up(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Schema::dropIfExists('notifications'); 
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('title');                    // Untuk judul notifikasi
            $table->text('message');                    // Untuk isi atau konten notifikasi
            $table->string('type')->nullable();         // Type notifikasi terdiri: order, payment, security, system, dan lain sebagainya(tambahkan jika perlu untuk Damar)
            $table->boolean('is_read')->default(false); // Untuk status apakah notifikasi tersebut sudah dibaca atau belum
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
