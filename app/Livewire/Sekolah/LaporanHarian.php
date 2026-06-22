<?php

namespace App\Livewire\Sekolah;

use App\Models\LaporanSekolah;
use Livewire\Component;

class LaporanHarian extends Component
{
    /**
     * Menampilkan daftar laporan harian kualitas makanan yang telah disubmit oleh sekolah.
     */
    public function render()
    {
        $sekolahId = auth()->user()->sekolah->id_sekolah ?? null;

        // Fetch LaporanSekolah for this sekolah
        $laporans = LaporanSekolah::whereHas('pengiriman.menu', function($q) use ($sekolahId) {
            $q->where('id_sekolah', $sekolahId);
        })
        ->with(['pengiriman.menu.dapur'])
        ->latest()
        ->get();

        return view('livewire.sekolah.laporan-harian', compact('laporans'));
    }
}
