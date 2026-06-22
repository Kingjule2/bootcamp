<?php

namespace App\Livewire\Sekolah;

use App\Models\LaporanSekolah;
use App\Models\Menu;
use App\Models\Pengiriman;
use Livewire\Component;

class SekolahDashboard extends Component
{
    public $porsi_diterima = '';
    public $food_waste = 0;
    public $rating = 0;
    public $komentar = '';
    public $selectedPengirimanId = null;
    public $showKonfirmasiForm = false;
    public $showLaporanForm = false;
    public $activeTab = 'pengiriman'; // 'pengiriman' | 'menu_masuk'

    /**
     * Mengkonfirmasi bahwa makanan telah diterima oleh sekolah.
     * Mengubah status pengiriman menjadi 'Diterima', membebaskan tugas kurir,
     * dan menampilkan form laporan kualitas makanan untuk diisi oleh sekolah.
     *
     * @param int $pengirimanId ID pengiriman yang dikonfirmasi
     */
    public function konfirmasiDiterima(int $pengirimanId)
    {
        $sekolahId = auth()->user()->sekolah->id_sekolah ?? null;

        $pengiriman = Pengiriman::where('id_pengiriman', $pengirimanId)
            ->whereHas('menu', fn($q) => $q->where('id_sekolah', $sekolahId))
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

        $this->selectedPengirimanId = $pengirimanId;
        $this->porsi_diterima = $pengiriman->menu->porsi_rencana;
        $this->showLaporanForm = true;

        session()->flash('success', '✅ Penerimaan dikonfirmasi! Silakan isi laporan kualitas.');
    }

    /**
     * Menyimpan laporan kualitas makanan (jumlah porsi, food waste, rating, dan komentar).
     * Melakukan validasi input, menyimpan data laporan ke database, dan mereset form laporan.
     */
    public function submitLaporan()
    {
        $this->validate([
            'porsi_diterima' => 'required|integer|min:0',
            'food_waste'     => 'required|integer|min:0',
            'rating'         => 'required|integer|min:1|max:5',
            'komentar'       => 'nullable|string|max:500',
        ], [
            'rating.min' => 'Silakan beri rating minimal 1 bintang.',
        ]);

        LaporanSekolah::create([
            'pengiriman_id' => $this->selectedPengirimanId,
            'porsi_diterima'=> $this->porsi_diterima,
            'food_waste'    => $this->food_waste,
            'rating'        => $this->rating,
            'komentar'      => $this->komentar,
        ]);

        $this->reset(['porsi_diterima', 'food_waste', 'rating', 'komentar', 'selectedPengirimanId', 'showLaporanForm']);
        session()->flash('success', '📝 Laporan kualitas berhasil dikirim. Terima kasih!');
    }

    /**
     * Mengatur nilai rating (bintang) pada form laporan kualitas makanan.
     *
     * @param int $value Nilai rating yang dipilih (1-5)
     */
    public function setRating(int $value)
    {
        $this->rating = $value;
    }

    /**
     * Menampilkan komponen dashboard sekolah.
     * Mengambil data pengiriman aktif menuju sekolah ini dan daftar menu masuk
     * yang sudah disetujui tapi belum dikirim.
     */
    public function render()
    {
        $sekolahId = auth()->user()->sekolah->id_sekolah ?? null;

        // Active delivery tracking
        $pengiriman = Pengiriman::whereHas('menu', fn($q) => $q->where('id_sekolah', $sekolahId))
            ->with(['menu.dapur', 'menu.sekolah', 'kurir.user', 'laporanSekolah'])
            ->latest()
            ->get();

        // Approved menus not yet dispatched — for transparency
        $menuMasuk = Menu::where('id_sekolah', $sekolahId)
            ->where('status', 'Ready to Cook')
            ->whereDoesntHave('pengiriman')
            ->with('dapur')
            ->latest()
            ->get();

        return view('livewire.sekolah.sekolah-dashboard', compact('pengiriman', 'menuMasuk'));
    }
}
