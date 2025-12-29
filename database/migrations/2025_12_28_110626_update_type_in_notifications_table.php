<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Cara paling aman adalah mengubahnya menjadi VARCHAR agar fleksibel
        Schema::table('notifications', function (Blueprint $blueprint) {
            $blueprint->string('type', 50)->change();
        });
    }

    public function down(): void
    {
        // Jika ingin kembali ke ENUM (opsional)
        Schema::table('notifications', function (Blueprint $blueprint) {
            $blueprint->enum('type', ['transaction', 'information'])->change();
        });
    }
};