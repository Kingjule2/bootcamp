<?php

namespace App\Livewire\Dapur;

use App\Models\Menu;
use App\Models\Pengiriman;
use App\Models\User;
use Livewire\Component;

class DapurDashboard extends Component
{


    public function render()
    {
        $menus = Menu::where('dapur_id', auth()->id())
            ->with(['targetSekolah', 'pengiriman'])
            ->latest()
            ->get();

        $stats = [
            'total' => $menus->count(),
            'pending' => $menus->where('status', 'Pending Verification')->count(),
            'approved' => $menus->where('status', 'Ready to Cook')->count(),
            'rejected' => $menus->where('status', 'Rejected')->count(),
        ];

        $kurirs = \App\Models\Kurir::with('user')->get();

        return view('livewire.dapur.dapur-dashboard', compact('menus', 'stats', 'kurirs'));
    }
}
