<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dapur_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('target_sekolah_id')->constrained('users')->cascadeOnDelete();
            $table->text('nama_menu')->comment('Rincian makanan sesuai kriteria Isi Piringku');
            $table->unsignedInteger('kalori')->comment('Estimasi kalori dalam kkal');
            $table->unsignedInteger('protein')->comment('Estimasi protein dalam gram');
            $table->unsignedInteger('porsi_rencana')->comment('Jumlah kotak yang akan diproduksi');
            $table->enum('status', ['Pending Verification', 'Ready to Cook', 'Rejected'])->default('Pending Verification');
            $table->text('catatan_gizi')->nullable()->comment('Wajib diisi jika status Rejected');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
