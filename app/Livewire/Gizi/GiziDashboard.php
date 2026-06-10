<?php

namespace App\Livewire\Gizi;

use App\Models\Menu;
use Livewire\Component;

class GiziDashboard extends Component
{
    public $selectedMenuId = null;
    public $showModal = false;
    public $catatan_gizi = '';
    public $showRejectInput = false;

    public function openVerifikasi(int $menuId)
    {
        $this->selectedMenuId = $menuId;
        $this->showModal = true;
        $this->catatan_gizi = '';
        $this->showRejectInput = false;
    }

    public function approve()
    {
        $menu = Menu::findOrFail($this->selectedMenuId);
        $menu->update([
            'status' => 'Ready to Cook',
            'catatan_gizi' => null,
        ]);

        $this->closeModal();
        session()->flash('success', 'Menu DISETUJUI ✅ — Status berubah menjadi Ready to Cook.');
    }

    public function showRejectForm()
    {
        $this->showRejectInput = true;
    }

    public function reject()
    {
        $this->validate([
            'catatan_gizi' => 'required|string|min:10',
        ], [
            'catatan_gizi.required' => 'Catatan wajib diisi sebagai umpan balik untuk dapur.',
            'catatan_gizi.min' => 'Catatan minimal 10 karakter agar informatif.',
        ]);

        $menu = Menu::findOrFail($this->selectedMenuId);
        $menu->update([
            'status' => 'Rejected',
            'catatan_gizi' => $this->catatan_gizi,
        ]);

        $this->closeModal();
        session()->flash('success', 'Menu DITOLAK ❌ — Catatan perbaikan telah dikirim ke dapur.');
    }

    public function closeModal()
    {
        $this->reset(['selectedMenuId', 'showModal', 'catatan_gizi', 'showRejectInput']);
    }

    public function render()
    {
        $pendingMenus = Menu::where('status', 'Pending Verification')
            ->with(['dapur', 'targetSekolah'])
            ->latest()
            ->get();

        $recentActions = Menu::whereIn('status', ['Ready to Cook', 'Rejected'])
            ->with(['dapur', 'targetSekolah'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        $selectedMenu = $this->selectedMenuId ? Menu::with(['dapur', 'targetSekolah'])->find($this->selectedMenuId) : null;

        $stats = [
            'pending' => $pendingMenus->count(),
            'approved_today' => Menu::where('status', 'Ready to Cook')->whereDate('updated_at', today())->count(),
            'rejected_today' => Menu::where('status', 'Rejected')->whereDate('updated_at', today())->count(),
        ];

        return view('livewire.gizi.gizi-dashboard', compact('pendingMenus', 'recentActions', 'selectedMenu', 'stats'));
    }
}
