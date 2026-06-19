<?php

namespace App\Livewire\Dapur;

use App\Models\Menu;
use App\Models\Pengiriman;
use Livewire\Component;

class ProduksiView extends Component
{
    public function mulaiMasak($menuId)
    {
        $menu = Menu::where('id_menus', $menuId)
            ->where('dapur_id', auth()->id())
            ->where('status', 'Ready to Cook')
            ->firstOrFail();

        // Check if pengiriman already exists
        if (!$menu->pengiriman) {
            Pengiriman::create([
                'id_menus' => $menu->id_menus,
                'id_kurir' => null,
                'status_logistik' => 'Sedang Dimasak',
            ]);

            session()->flash('success', 'Status menu berhasil diubah menjadi Sedang Dimasak!');
        }
    }

    public function render()
    {
        $menus = Menu::where('dapur_id', auth()->id())
            ->where('status', 'Ready to Cook')
            ->where(function ($query) {
                $query->doesntHave('pengiriman')
                      ->orWhereHas('pengiriman', function ($q) {
                          $q->where('status_logistik', 'Sedang Dimasak');
                      });
            })
            ->with('targetSekolah', 'pengiriman')
            ->latest()
            ->get();

        return view('livewire.dapur.produksi-view', compact('menus'));
    }
}
