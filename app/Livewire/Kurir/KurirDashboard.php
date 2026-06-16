<?php

namespace App\Livewire\Kurir;

use App\Models\Pengiriman;
use Livewire\Component;

class KurirDashboard extends Component
{
    public function render()
    {
        // Get deliveries assigned to this kurir
        // Note: Currently nama_kurir is stored as string.
        // We'll match it with the user's nama_entitas.
        $pengirimans = Pengiriman::where('nama_kurir', auth()->user()->nama_entitas)
            ->whereIn('status_logistik', ['Dalam Perjalanan', 'Diterima'])
            ->with(['menu.dapur', 'menu.targetSekolah'])
            ->latest()
            ->get();

        $stats = [
            'dalam_perjalanan' => $pengirimans->where('status_logistik', 'Dalam Perjalanan')->count(),
            'selesai_hari_ini' => $pengirimans->where('status_logistik', 'Diterima')->where('updated_at', '>=', today())->count(),
        ];

        return view('livewire.kurir.kurir-dashboard', compact('pengirimans', 'stats'));
    }
}
