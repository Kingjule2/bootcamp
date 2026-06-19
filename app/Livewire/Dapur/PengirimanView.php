<?php

namespace App\Livewire\Dapur;

use App\Models\Menu;
use App\Models\Pengiriman;
use Livewire\Component;

class PengirimanView extends Component
{
    public $id_kurir = '';
    public $showKirimModal = false;
    public $selectedPengirimanId = null;

    public function kirimMakanan($pengirimanId)
    {
        $this->selectedPengirimanId = $pengirimanId;
        $this->showKirimModal = true;
    }

    public function confirmKirim()
    {
        $this->validate([
            'id_kurir' => 'required|exists:kurir,id_kurir',
        ]);

        $pengiriman = Pengiriman::where('id_pengiriman', $this->selectedPengirimanId)
            ->whereHas('menu', function($q) {
                $q->where('dapur_id', auth()->id());
            })
            ->firstOrFail();

        $pengiriman->update([
            'id_kurir' => $this->id_kurir,
            'status_logistik' => 'Dalam Perjalanan',
            'dispatched_at' => now(),
            'device_info' => request()->userAgent(),
        ]);

        $this->reset(['id_kurir', 'showKirimModal', 'selectedPengirimanId']);
        session()->flash('success', 'Makanan berhasil dikirim! Kurir sedang dalam perjalanan.');
    }

    public function cancelKirim()
    {
        $this->reset(['id_kurir', 'showKirimModal', 'selectedPengirimanId']);
    }

    public function render()
    {
        // Get all pengiriman that are in process for this dapur
        $pengirimans = Pengiriman::whereHas('menu', function ($query) {
                $query->where('dapur_id', auth()->id());
            })
            ->with(['menu.targetSekolah'])
            ->latest()
            ->get();

        $kurirList = \App\Models\Kurir::with('user')->get();

        return view('livewire.dapur.pengiriman-view', compact('pengirimans', 'kurirList'));
    }
}
