<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengiriman', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete();
            $table->string('nama_kurir', 100);
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
