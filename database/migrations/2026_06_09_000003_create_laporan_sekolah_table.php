<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('laporan_sekolah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengiriman_id')->constrained('pengiriman')->cascadeOnDelete();
            $table->unsignedInteger('porsi_diterima')->comment('Jumlah fisik kotak layak konsumsi');
            $table->unsignedInteger('food_waste')->default(0)->comment('Sisa porsi tidak termakan');
            $table->unsignedTinyInteger('rating')->comment('Kepuasan kualitas 1-5');
            $table->string('foto_makanan', 255)->nullable()->comment('Path foto bukti akuntabilitas');
            $table->text('komentar')->nullable()->comment('Ulasan kualitas makanan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('laporan_sekolah');
    }
};
