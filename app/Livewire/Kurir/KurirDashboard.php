<?php

namespace App\Livewire\Kurir;

use App\Models\Pengiriman;
use Livewire\Component;

class KurirDashboard extends Component
{
    public $activeTab = 'aktif'; // 'aktif' atau 'riwayat'

    /**
     * Menandai pengiriman sebagai selesai/diterima oleh pihak sekolah.
     * Memperbarui status logistik, mencatat waktu penerimaan, info perangkat,
     * dan mengembalikan status tugas kurir menjadi 'Standby'.
     *
     * @param int $pengirimanId ID pengiriman yang diselesaikan
     */
    public function tandaiDiterima(int $pengirimanId)
    {
        $kurirId = auth()->user()->kurir->id_kurir ?? null;

        $pengiriman = Pengiriman::where('id_pengiriman', $pengirimanId)
            ->where('id_kurir', $kurirId)
            ->where('status_logistik', 'Dalam Perjalanan')
            ->firstOrFail();

        $pengiriman->update([
            'status_logistik' => 'Diterima',
            'received_at' => now(),
            'device_info' => request()->userAgent(),
        ]);

        if ($pengiriman->id_kurir) {
            \App\Models\Kurir::where('id_kurir', $pengiriman->id_kurir)->update([
                'status_tugas' => 'Standby'
            ]);
        }

        session()->flash('success', '✅ Pengiriman berhasil diselesaikan! Status tugas Anda kembali Standby.');
    }

    /**
     * Menampilkan komponen dashboard kurir.
     * Memuat daftar pengiriman aktif (dalam perjalanan), riwayat pengiriman yang selesai,
     * serta statistik terkait tugas kurir tersebut.
     */
    public function render()
    {
        // Get deliveries assigned to this kurir
        $kurirId = auth()->user()->kurir->id_kurir ?? null;

        $pengirimanAktif = $kurirId
            ? Pengiriman::where('id_kurir', $kurirId)
                ->where('status_logistik', 'Dalam Perjalanan')
                ->with(['menu.dapur', 'menu.targetSekolah'])
                ->latest()
                ->get()
            : collect();

        $riwayatSelesai = $kurirId
            ? Pengiriman::where('id_kurir', $kurirId)
                ->where('status_logistik', 'Diterima')
                ->with(['menu.dapur', 'menu.targetSekolah'])
                ->latest()
                ->get()
            : collect();

        $stats = [
            'dalam_perjalanan' => $pengirimanAktif->count(),
            'selesai_hari_ini' => $riwayatSelesai->where('updated_at', '>=', today())->count(),
        ];

        return view('livewire.kurir.kurir-dashboard', compact('pengirimanAktif', 'riwayatSelesai', 'stats'));
    }
}
