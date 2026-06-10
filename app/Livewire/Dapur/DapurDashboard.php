<?php

namespace App\Livewire\Dapur;

use App\Models\Menu;
use App\Models\Pengiriman;
use App\Models\User;
use Livewire\Component;

class DapurDashboard extends Component
{
    public $namaKurir = '';
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
            'namaKurir' => 'required|string|min:3|max:100',
        ]);

        $menu = Menu::where('id', $this->selectedMenuId)
            ->where('dapur_id', auth()->id())
            ->where('status', 'Ready to Cook')
            ->firstOrFail();

        Pengiriman::create([
            'menu_id' => $menu->id,
            'nama_kurir' => $this->namaKurir,
            'status_logistik' => 'Dalam Perjalanan',
            'dispatched_at' => now(),
            'device_info' => request()->userAgent(),
        ]);

        $this->reset(['namaKurir', 'showKirimModal', 'selectedMenuId']);
        session()->flash('success', 'Makanan berhasil dikirim! Kurir sedang dalam perjalanan.');
    }

    public function cancelKirim()
    {
        $this->reset(['namaKurir', 'showKirimModal', 'selectedMenuId']);
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

        return view('livewire.dapur.dapur-dashboard', compact('menus', 'stats'));
    }
}
