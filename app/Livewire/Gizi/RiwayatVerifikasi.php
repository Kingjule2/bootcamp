<?php

namespace App\Livewire\Gizi;

use App\Models\Menu;
use Livewire\Component;

class RiwayatVerifikasi extends Component
{
    /**
     * Menampilkan komponen riwayat verifikasi menu.
     * Mengambil daftar menu yang sudah diproses (disetujui atau ditolak) beserta relasinya.
     */
    public function render()
    {
        $riwayat = Menu::whereIn('status', ['Ready to Cook', 'Rejected'])
            ->with(['dapur', 'targetSekolah'])
            ->latest()
            ->get();

        return view('livewire.gizi.riwayat-verifikasi', compact('riwayat'));
    }
}
