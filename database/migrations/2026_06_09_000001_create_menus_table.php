<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id('id_menus');
            $table->foreignId('dapur_id')->constrained('users', 'id_users')->cascadeOnDelete();
            $table->foreignId('id_sekolah')->constrained('sekolah', 'id_sekolah')->cascadeOnDelete();
            $table->text('nama_menu')->comment('Rincian makanan sesuai kriteria Isi Piringku');
            $table->unsignedInteger('kalori')->comment('Estimasi kalori dalam kkal');
            $table->unsignedInteger('protein')->comment('Estimasi protein dalam gram');
            $table->unsignedInteger('porsi_rencana')->comment('Jumlah kotak yang akan diproduksi');
            $table->enum('status', ['Pending Verification', 'Ready to Cook', 'Rejected'])->default('Pending Verification');
            $table->text('catatan_gizi')->nullable()->comment('Wajib diisi jika status Rejected');
            $table->unsignedInteger('karbohidrat')->default(0);
            $table->unsignedInteger('lemak')->default(0);
            $table->foreignId('id_ahli_gizi')->nullable()->constrained('ahli_gizi', 'id_ahli_gizi')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
