<?php

namespace App\Livewire\Dapur;

use App\Models\Menu;
use App\Models\Pengiriman;
use Livewire\Component;

class PengirimanView extends Component
{
    public $namaKurir = '';
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
            'namaKurir' => 'required|string|min:3|max:100',
        ]);

        $pengiriman = Pengiriman::where('id', $this->selectedPengirimanId)
            ->whereHas('menu', function($q) {
                $q->where('dapur_id', auth()->id());
            })
            ->firstOrFail();

        $pengiriman->update([
            'nama_kurir' => $this->namaKurir,
            'status_logistik' => 'Dalam Perjalanan',
            'dispatched_at' => now(),
            'device_info' => request()->userAgent(),
        ]);

        $this->reset(['namaKurir', 'showKirimModal', 'selectedPengirimanId']);
        session()->flash('success', 'Makanan berhasil dikirim! Kurir sedang dalam perjalanan.');
    }

    public function cancelKirim()
    {
        $this->reset(['namaKurir', 'showKirimModal', 'selectedPengirimanId']);
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

        return view('livewire.dapur.pengiriman-view', compact('pengirimans'));
    }
}
