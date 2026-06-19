<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id('id_pengiriman');
            $table->foreignId('id_menus')->constrained('menus', 'id_menus')->cascadeOnDelete();
            $table->foreignId('id_kurir')->constrained('kurir', 'id_kurir')->cascadeOnDelete();
            $table->enum('status_logistik', ['Sedang Dimasak', 'Dalam Perjalanan', 'Diterima'])->default('Sedang Dimasak');
            $table->timestamp('dispatched_at')->nullable()->comment('Waktu katering klik Kirim Makanan');
            $table->timestamp('received_at')->nullable()->comment('Waktu sekolah klik Konfirmasi');
            $table->boolean('is_synced')->default(true)->comment('FALSE jika input offline PWA');
            $table->string('device_info', 255)->nullable()->comment('User-agent untuk audit digital');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengiriman');
    }
};
