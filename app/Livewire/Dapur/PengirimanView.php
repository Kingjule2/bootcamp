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

    /**
     * Membuka modal konfirmasi pengiriman untuk makanan yang dipilih.
     * Menyimpan ID pengiriman yang dipilih ke dalam properti.
     *
     * @param int $pengirimanId ID dari pengiriman yang akan dikirim
     */
    public function kirimMakanan($pengirimanId)
    {
        $this->selectedPengirimanId = $pengirimanId;
        $this->showKirimModal = true;
    }

    /**
     * Mengkonfirmasi proses pengiriman makanan.
     * Memvalidasi kurir yang dipilih, memperbarui status pengiriman menjadi 'Dalam Perjalanan',
     * mencatat waktu pengiriman dan info perangkat, serta mengubah status tugas kurir menjadi 'On Delivery'.
     */
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

    /**
     * Membatalkan proses pengiriman dan menutup modal konfirmasi.
     * Mengosongkan data pilihan kurir dan pengiriman.
     */
    public function cancelKirim()
    {
        $this->reset(['selectedKurirId', 'showKirimModal', 'selectedPengirimanId']);
    }

    /**
     * Menampilkan komponen tampilan pengiriman.
     * Mengambil data pengiriman yang sedang diproses oleh dapur beserta data kurir.
     */
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
