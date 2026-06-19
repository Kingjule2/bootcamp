<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sekolah', function (Blueprint $table) {
            $table->id('id_sekolah');
            $table->foreignId('id_users')->unique()->constrained('users', 'id_users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('NIS');
            $table->integer('jumlah_siswa');
            $table->integer('no_telp');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sekolah');
    }
};
