<?php

namespace App\Livewire\Dapur;

use App\Models\Menu;
use App\Models\Pengiriman;
use Livewire\Component;

class PengirimanView extends Component
{
    public $selectedKurirId = '';
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
            'selectedKurirId' => 'required|exists:kurir,id_kurir',
        ]);

        $pengiriman = Pengiriman::where('id_pengiriman', $this->selectedPengirimanId)
            ->whereHas('menu', function($q) {
                $q->where('dapur_id', auth()->id());
            })
            ->firstOrFail();

        $pengiriman->update([
            'id_kurir' => $this->selectedKurirId,
            'status_logistik' => 'Dalam Perjalanan',
            'dispatched_at' => now(),
            'device_info' => request()->userAgent(),
        ]);

        \App\Models\Kurir::where('id_kurir', $this->selectedKurirId)->update([
            'status_tugas' => 'On Delivery'
        ]);

        $this->reset(['selectedKurirId', 'showKirimModal', 'selectedPengirimanId']);
        session()->flash('success', 'Makanan berhasil dikirim! Kurir sedang dalam perjalanan.');
    }

    public function cancelKirim()
    {
        $this->reset(['selectedKurirId', 'showKirimModal', 'selectedPengirimanId']);
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

        $kurirs = \App\Models\Kurir::with('user')->get();

        return view('livewire.dapur.pengiriman-view', compact('pengirimans', 'kurirs'));
    }
}
