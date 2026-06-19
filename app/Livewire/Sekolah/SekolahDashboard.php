<?php

namespace App\Livewire\Sekolah;

use App\Models\LaporanSekolah;
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

    public function submitLaporan()
    {
        $this->validate([
            'porsi_diterima' => 'required|integer|min:0',
            'food_waste' => 'required|integer|min:0',
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string|max:500',
        ], [
            'rating.min' => 'Silakan beri rating minimal 1 bintang.',
        ]);

        LaporanSekolah::create([
            'pengiriman_id' => $this->selectedPengirimanId,
            'porsi_diterima' => $this->porsi_diterima,
            'food_waste' => $this->food_waste,
            'rating' => $this->rating,
            'komentar' => $this->komentar,
        ]);

        $this->reset(['porsi_diterima', 'food_waste', 'rating', 'komentar', 'selectedPengirimanId', 'showLaporanForm']);
        session()->flash('success', '📝 Laporan kualitas berhasil dikirim. Terima kasih!');
    }

    public function setRating(int $value)
    {
        $this->rating = $value;
    }

    public function render()
    {
        $sekolahId = auth()->user()->sekolah->id_sekolah ?? null;

        $pengiriman = Pengiriman::whereHas('menu', fn($q) => $q->where('id_sekolah', $sekolahId))
            ->with(['menu.dapur', 'laporanSekolah'])
            ->latest()
            ->get();

        return view('livewire.sekolah.sekolah-dashboard', compact('pengiriman'));
    }
}
