<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ahli_gizi', function (Blueprint $table) {
            $table->id('id_ahli_gizi');
            $table->foreignId('id_users')->unique()->constrained('users', 'id_users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('no_str', 100);
            $table->enum('spesialisasi', ['Gizi Anak & Remaja', 'Food Safety dan Quality Auditor']);
            $table->integer('min_kalori');
            $table->integer('max_kalori');
            $table->integer('min_protein');
            $table->integer('max_karbohidrat');
            $table->integer('max_lemak');
            $table->enum('status_menu', ['Approve', 'Reject']);
            $table->string('catatan', 100);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ahli_gizi');
    }
};
