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
        $giziRecord = \App\Models\AhliGizi::create([
            'id_users' => $gizi->id_users,
            'no_str' => 'STR123456',
            'spesialisasi' => 'Gizi Anak & Remaja',
            'min_kalori' => 500,
            'max_kalori' => 800,
            'min_protein' => 15,
            'max_karbohidrat' => 100,
            'max_lemak' => 30,
            'status_menu' => 'Approve',
            'catatan' => 'Seeder default',
        ]);

        $sekolah = User::create([
            'username' => 'sekolah1',
            'password' => 'password123',
            'role' => 'sekolah',
            'nama_entitas' => 'SDN 01 Cinere',
        ]);
        $sekolahRecord1 = \App\Models\Sekolah::create([
            'id_users' => $sekolah->id_users,
            'NIS' => 10001,
            'jumlah_siswa' => 500,
            'no_telp' => 12345,
        ]);

        $sekolah2 = User::create([
            'username' => 'sekolah2',
            'password' => 'password123',
            'role' => 'sekolah',
            'nama_entitas' => 'SDN 05 Beji',
        ]);
        $sekolahRecord2 = \App\Models\Sekolah::create([
            'id_users' => $sekolah2->id_users,
            'NIS' => 10002,
            'jumlah_siswa' => 350,
            'no_telp' => 54321,
        ]);

        $admin = User::create([
            'username' => 'admin1',
            'password' => 'password123',
            'role' => 'admin',
            'nama_entitas' => 'Dinas Pendidikan Kota Depok',
        ]);

        // ── Seed Couriers (Kurir) ──
        $kurir1 = User::create([
            'username' => 'kurir1',
            'password' => 'password123',
            'role' => 'kurir',
            'nama_entitas' => 'Andi Prasetyo',
        ]);
        $kurirRecord1 = \App\Models\Kurir::create([
            'id_users' => $kurir1->id_users,
            'no_telp' => '08121111111',
            'plat_nomor' => 'B 1111 AAA',
            'jenis_kendaraan' => 'Motor',
            'bukti_pengiriman' => '',
            'status_tugas' => 'Standby',
        ]);

        $kurir2 = User::create([
            'username' => 'kurir2',
            'password' => 'password123',
            'role' => 'kurir',
            'nama_entitas' => 'Budi Santoso',
        ]);
        $kurirRecord2 = \App\Models\Kurir::create([
            'id_users' => $kurir2->id_users,
            'no_telp' => '08122222222',
            'plat_nomor' => 'B 2222 BBB',
            'jenis_kendaraan' => 'Motor',
            'bukti_pengiriman' => '',
            'status_tugas' => 'On Delivery',
        ]);

        $kurir3 = User::create([
            'username' => 'kurir3',
            'password' => 'password123',
            'role' => 'kurir',
            'nama_entitas' => 'Cahyo Wibowo',
        ]);
        $kurirRecord3 = \App\Models\Kurir::create([
            'id_users' => $kurir3->id_users,
            'no_telp' => '08123333333',
            'plat_nomor' => 'B 3333 CCC',
            'jenis_kendaraan' => 'Mobil Box',
            'bukti_pengiriman' => '',
            'status_tugas' => 'Standby',
        ]);

        // ── Menus ──
        $menu1 = Menu::create([
            'dapur_id' => $dapur->id_users,
            'id_sekolah' => $sekolahRecord1->id_sekolah,
            'nama_menu' => 'Nasi Putih, Ayam Goreng Lengkuas, Tumis Buncis, Buah Jeruk',
            'kalori' => 650,
            'protein' => 25,
            'karbohidrat' => 90,
            'lemak' => 20,
            'porsi_rencana' => 500,
            'status' => 'Ready to Cook',
            'id_ahli_gizi' => $giziRecord->id_ahli_gizi,
        ]);

        $menu2 = Menu::create([
            'dapur_id' => $dapur->id_users,
            'id_sekolah' => $sekolahRecord2->id_sekolah,
            'nama_menu' => 'Nasi Merah, Ikan Bakar Bumbu Kuning, Sayur Bayam, Buah Pisang',
            'kalori' => 580,
            'protein' => 22,
            'karbohidrat' => 80,
            'lemak' => 18,
            'porsi_rencana' => 350,
            'status' => 'Pending Verification',
            'id_ahli_gizi' => null,
        ]);

        $menu3 = Menu::create([
            'dapur_id' => $dapur->id_users,
            'id_sekolah' => $sekolahRecord1->id_sekolah,
            'nama_menu' => 'Nasi Putih, Rendang Sapi, Lalapan Mentimun, Buah Semangka',
            'kalori' => 720,
            'protein' => 30,
            'karbohidrat' => 95,
            'lemak' => 25,
            'porsi_rencana' => 500,
            'status' => 'Rejected',
            'catatan_gizi' => 'Sayuran kurang bervariasi. Ganti lalapan mentimun dengan tumis kangkung yang tinggi serat dan zat besi.',
            'id_ahli_gizi' => $giziRecord->id_ahli_gizi,
        ]);

        $menu4 = Menu::create([
            'dapur_id' => $dapur->id_users,
            'id_sekolah' => $sekolahRecord1->id_sekolah,
            'nama_menu' => 'Nasi Putih, Telur Balado, Capcay Sayuran, Buah Apel',
            'kalori' => 550,
            'protein' => 18,
            'karbohidrat' => 75,
            'lemak' => 15,
            'porsi_rencana' => 500,
            'status' => 'Pending Verification',
            'id_ahli_gizi' => null,
        ]);

        $menu5 = Menu::create([
            'dapur_id' => $dapur->id_users,
            'id_sekolah' => $sekolahRecord2->id_sekolah,
            'nama_menu' => 'Nasi Putih, Soto Ayam, Perkedel Kentang, Buah Melon',
            'kalori' => 610,
            'protein' => 20,
            'karbohidrat' => 85,
            'lemak' => 16,
            'porsi_rencana' => 350,
            'status' => 'Ready to Cook',
            'id_ahli_gizi' => $giziRecord->id_ahli_gizi,
        ]);

        // ── Pengiriman ──
        $pengiriman1 = Pengiriman::create([
            'id_menus' => $menu1->id_menus,
            'id_kurir' => $kurirRecord1->id_kurir,
            'status_logistik' => 'Diterima',
            'dispatched_at' => Carbon::today()->setTime(10, 0),
            'received_at' => Carbon::today()->setTime(10, 45),
            'is_synced' => true,
            'device_info' => 'Chrome/Android 14 - Samsung A54',
        ]);

        // This one is overdue for admin alert demo
        $pengiriman2 = Pengiriman::create([
            'id_menus' => $menu5->id_menus,
            'id_kurir' => $kurirRecord2->id_kurir,
            'status_logistik' => 'Dalam Perjalanan',
            'dispatched_at' => Carbon::now()->subHours(3),
            'received_at' => null,
            'is_synced' => true,
            'device_info' => 'Safari/iOS 18 - iPhone 15',
        ]);

        $pengiriman3 = Pengiriman::create([
            'id_menus' => $menu1->id_menus,
            'id_kurir' => $kurirRecord3->id_kurir,
            'status_logistik' => 'Sedang Dimasak',
            'dispatched_at' => null,
            'received_at' => null,
            'is_synced' => true,
        ]);

        // ── Laporan Sekolah ──
        LaporanSekolah::create([
            'pengiriman_id' => $pengiriman1->id_pengiriman,
            'porsi_diterima' => 498,
            'food_waste' => 12,
            'rating' => 4,
            'komentar' => 'Makanan segar dan enak. 2 box rusak saat pengiriman.',
        ]);
    }
}
