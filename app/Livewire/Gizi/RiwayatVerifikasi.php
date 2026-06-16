<?php

namespace App\Livewire\Gizi;

use App\Models\Menu;
use Livewire\Component;

class RiwayatVerifikasi extends Component
{
    public function render()
    {
        $riwayat = Menu::whereIn('status', ['Ready to Cook', 'Rejected'])
            ->with(['dapur', 'targetSekolah'])
            ->latest()
            ->get();

        return view('livewire.gizi.riwayat-verifikasi', compact('riwayat'));
    }
}
