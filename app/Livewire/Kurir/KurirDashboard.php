<?php

namespace App\Livewire\Kurir;

use App\Models\Pengiriman;
use Livewire\Component;

class KurirDashboard extends Component
{
    public function render()
    {
        // Get the courier record for the logged-in user
        $kurir = auth()->user()->kurir;

        $pengirimans = Pengiriman::where('id_kurir', $kurir?->id_kurir ?? 0)
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
