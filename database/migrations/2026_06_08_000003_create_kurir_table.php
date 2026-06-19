<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kurir', function (Blueprint $table) {
            $table->id('id_kurir');
            $table->foreignId('id_users')->unique()->constrained('users', 'id_users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('no_telp', 20);
            $table->string('plat_nomor', 20);
            $table->string('jenis_kendaraan', 100);
            $table->string('bukti_pengiriman', 225)->nullable();
            $table->enum('status_tugas', ['Standby', 'On Delivery', 'Istirahat'])->default('Standby');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kurir');
    }
};
