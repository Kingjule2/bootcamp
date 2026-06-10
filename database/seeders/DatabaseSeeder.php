<?php

namespace Database\Seeders;

use App\Models\LaporanSekolah;
use App\Models\Menu;
use App\Models\Pengiriman;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users (1 per role) ──
        $dapur = User::create([
            'username' => 'dapur1',
            'password' => 'password123',
            'role' => 'dapur',
            'nama_entitas' => 'Katering Sukses Makmur',
        ]);

        $gizi = User::create([
            'username' => 'gizi1',
            'password' => 'password123',
            'role' => 'ahli_gizi',
            'nama_entitas' => 'Dinas Kesehatan Kota Depok',
        ]);

        $sekolah = User::create([
            'username' => 'sekolah1',
            'password' => 'password123',
            'role' => 'sekolah',
            'nama_entitas' => 'SDN 01 Cinere',
        ]);

        $sekolah2 = User::create([
            'username' => 'sekolah2',
            'password' => 'password123',
            'role' => 'sekolah',
            'nama_entitas' => 'SDN 05 Beji',
        ]);

        $admin = User::create([
            'username' => 'admin1',
            'password' => 'password123',
            'role' => 'admin',
            'nama_entitas' => 'Dinas Pendidikan Kota Depok',
        ]);

        // ── Menus ──
        $menu1 = Menu::create([
            'dapur_id' => $dapur->id,
            'target_sekolah_id' => $sekolah->id,
            'nama_menu' => 'Nasi Putih, Ayam Goreng Lengkuas, Tumis Buncis, Buah Jeruk',
            'kalori' => 650,
            'protein' => 25,
            'porsi_rencana' => 500,
            'status' => 'Ready to Cook',
        ]);

        $menu2 = Menu::create([
            'dapur_id' => $dapur->id,
            'target_sekolah_id' => $sekolah2->id,
            'nama_menu' => 'Nasi Merah, Ikan Bakar Bumbu Kuning, Sayur Bayam, Buah Pisang',
            'kalori' => 580,
            'protein' => 22,
            'porsi_rencana' => 350,
            'status' => 'Pending Verification',
        ]);

        $menu3 = Menu::create([
            'dapur_id' => $dapur->id,
            'target_sekolah_id' => $sekolah->id,
            'nama_menu' => 'Nasi Putih, Rendang Sapi, Lalapan Mentimun, Buah Semangka',
            'kalori' => 720,
            'protein' => 30,
            'porsi_rencana' => 500,
            'status' => 'Rejected',
            'catatan_gizi' => 'Sayuran kurang bervariasi. Ganti lalapan mentimun dengan tumis kangkung yang tinggi serat dan zat besi.',
        ]);

        $menu4 = Menu::create([
            'dapur_id' => $dapur->id,
            'target_sekolah_id' => $sekolah->id,
            'nama_menu' => 'Nasi Putih, Telur Balado, Capcay Sayuran, Buah Apel',
            'kalori' => 550,
            'protein' => 18,
            'porsi_rencana' => 500,
            'status' => 'Pending Verification',
        ]);

        $menu5 = Menu::create([
            'dapur_id' => $dapur->id,
            'target_sekolah_id' => $sekolah2->id,
            'nama_menu' => 'Nasi Putih, Soto Ayam, Perkedel Kentang, Buah Melon',
            'kalori' => 610,
            'protein' => 20,
            'porsi_rencana' => 350,
            'status' => 'Ready to Cook',
        ]);

        // ── Pengiriman ──
        $pengiriman1 = Pengiriman::create([
            'menu_id' => $menu1->id,
            'nama_kurir' => 'Andi Prasetyo',
            'status_logistik' => 'Diterima',
            'dispatched_at' => Carbon::today()->setTime(10, 0),
            'received_at' => Carbon::today()->setTime(10, 45),
            'is_synced' => true,
            'device_info' => 'Chrome/Android 14 - Samsung A54',
        ]);

        // This one is overdue for admin alert demo
        $pengiriman2 = Pengiriman::create([
            'menu_id' => $menu5->id,
            'nama_kurir' => 'Budi Santoso',
            'status_logistik' => 'Dalam Perjalanan',
            'dispatched_at' => Carbon::now()->subHours(3),
            'received_at' => null,
            'is_synced' => true,
            'device_info' => 'Safari/iOS 18 - iPhone 15',
        ]);

        $pengiriman3 = Pengiriman::create([
            'menu_id' => $menu1->id,
            'nama_kurir' => 'Cahyo Wibowo',
            'status_logistik' => 'Sedang Dimasak',
            'dispatched_at' => null,
            'received_at' => null,
            'is_synced' => true,
        ]);

        // ── Laporan Sekolah ──
        LaporanSekolah::create([
            'pengiriman_id' => $pengiriman1->id,
            'porsi_diterima' => 498,
            'food_waste' => 12,
            'rating' => 4,
            'komentar' => 'Makanan segar dan enak. 2 box rusak saat pengiriman.',
        ]);
    }
}
