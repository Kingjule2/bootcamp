<?php

namespace App\Livewire\Dapur;

use App\Models\Menu;
use App\Models\Pengiriman;
use App\Models\User;
use Livewire\Component;

class DapurDashboard extends Component
{
    public $selectedKurirId = '';
    public $showKirimModal = false;
    public $selectedMenuId = null;

    public function kirimMakanan(int $menuId)
    {
        $this->selectedMenuId = $menuId;
        $this->showKirimModal = true;
    }

    public function confirmKirim()
    {
        $this->validate([
            'selectedKurirId' => 'required|exists:kurir,id_kurir',
        ]);

        $menu = Menu::where('id_menus', $this->selectedMenuId)
            ->where('dapur_id', auth()->id())
            ->where('status', 'Ready to Cook')
            ->firstOrFail();

        Pengiriman::create([
            'id_menus' => $menu->id_menus,
            'id_kurir' => $this->selectedKurirId,
            'status_logistik' => 'Dalam Perjalanan',
            'dispatched_at' => now(),
            'device_info' => request()->userAgent(),
        ]);

        \App\Models\Kurir::where('id_kurir', $this->selectedKurirId)->update([
            'status_tugas' => 'On Delivery'
        ]);

        $this->reset(['selectedKurirId', 'showKirimModal', 'selectedMenuId']);
        session()->flash('success', 'Makanan berhasil dikirim! Kurir sedang dalam perjalanan.');
    }

    public function cancelKirim()
    {
        $this->reset(['selectedKurirId', 'showKirimModal', 'selectedMenuId']);
    }

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
