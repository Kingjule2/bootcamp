<?php

namespace App\Livewire\Admin;

use App\Models\LaporanSekolah;
use App\Models\Menu;
use App\Models\Pengiriman;
use App\Models\User;
use App\Models\Sekolah;
use App\Models\AhliGizi;
use App\Models\Kurir;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Attributes\Url;

class AdminDashboard extends Component
{
    public $activeTab = 'monitoring'; // monitoring or user_management

    // User CRUD properties
    public $showUserModal = false;
    public $editingUserId = null;

    // User Form fields
    public $nama_entitas = '';
    public $username = '';
    public $email = '';
    public $password = '';
    public $role = '';

    // Profile-specific fields
    public $NIS = '';
    public $jumlah_siswa = 0;
    public $no_telp = '';
    public $plat_nomor = '';
    public $jenis_kendaraan = 'Motor';
    public $no_str = '';
    public $spesialisasi = '';

    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function openAddUser()
    {
        $this->resetForm();
        $this->editingUserId = null;
        $this->showUserModal = true;
    }

    public function editUser($userId)
    {
        $this->resetForm();
        $this->editingUserId = $userId;
        $user = \App\Models\User::with(['sekolah', 'kurir', 'ahliGizi'])->findOrFail($userId);

        $this->nama_entitas = $user->nama_entitas;
        $this->username = $user->username;
        $this->email = $user->email;
        $this->role = $user->role;

        if ($user->role === 'sekolah' && $user->sekolah) {
            $this->NIS = $user->sekolah->NIS;
            $this->jumlah_siswa = $user->sekolah->jumlah_siswa;
            $this->no_telp = $user->sekolah->no_telp;
        } elseif ($user->role === 'kurir' && $user->kurir) {
            $this->no_telp = $user->kurir->no_telp;
            $this->plat_nomor = $user->kurir->plat_nomor;
            $this->jenis_kendaraan = $user->kurir->jenis_kendaraan;
        } elseif ($user->role === 'ahli_gizi' && $user->ahliGizi) {
            $this->no_str = $user->ahliGizi->no_str;
            $this->spesialisasi = $user->ahliGizi->spesialisasi;
        }

        $this->showUserModal = true;
    }

    public function saveUser()
    {
        $rules = [
            'nama_entitas' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . ($this->editingUserId ?? 'NULL') . ',id_users',
            'email' => 'required|email|max:255|unique:users,email,' . ($this->editingUserId ?? 'NULL') . ',id_users',
            'role' => 'required|in:dapur,ahli_gizi,sekolah,kurir,admin',
        ];

        if (!$this->editingUserId) {
            $rules['password'] = 'required|string|min:6';
        } else {
            $rules['password'] = 'nullable|string|min:6';
        }

        if ($this->role === 'sekolah') {
            $rules['NIS'] = 'required|string|max:50';
            $rules['jumlah_siswa'] = 'required|integer|min:0';
        } elseif ($this->role === 'kurir') {
            $rules['no_telp'] = 'required|string|max:20';
            $rules['plat_nomor'] = 'required|string|max:20';
        } elseif ($this->role === 'ahli_gizi') {
            $rules['no_str'] = 'required|string|max:100';
        }

        $this->validate($rules);

        $userData = [
            'nama_entitas' => $this->nama_entitas,
            'username' => $this->username,
            'email' => $this->email,
            'role' => $this->role,
        ];

        if ($this->password) {
            $userData['password'] = bcrypt($this->password);
        }

        if ($this->editingUserId) {
            $user = \App\Models\User::findOrFail($this->editingUserId);
            $user->update($userData);
        } else {
            $user = \App\Models\User::create($userData);
        }

        // Sync Profile Data
        if ($this->role === 'sekolah') {
            \App\Models\Sekolah::updateOrCreate(
                ['id_users' => $user->id_users],
                ['NIS' => $this->NIS, 'jumlah_siswa' => $this->jumlah_siswa, 'no_telp' => $this->no_telp]
            );
        } elseif ($this->role === 'kurir') {
            \App\Models\Kurir::updateOrCreate(
                ['id_users' => $user->id_users],
                ['no_telp' => $this->no_telp, 'plat_nomor' => $this->plat_nomor, 'jenis_kendaraan' => $this->jenis_kendaraan]
            );
        } elseif ($this->role === 'ahli_gizi') {
            \App\Models\AhliGizi::updateOrCreate(
                ['id_users' => $user->id_users],
                ['no_str' => $this->no_str, 'spesialisasi' => $this->spesialisasi]
            );
        }

        $this->closeUserModal();
        session()->flash('success', 'Data user berhasil disimpan!');
    }

    public function deleteUser($userId)
    {
        $user = \App\Models\User::findOrFail($userId);

        // Delete profiles first
        \App\Models\Sekolah::where('id_users', $userId)->delete();
        \App\Models\Kurir::where('id_users', $userId)->delete();
        \App\Models\AhliGizi::where('id_users', $userId)->delete();

        $user->delete();
        session()->flash('success', 'User berhasil dihapus.');
    }

    public function closeUserModal()
    {
        $this->showUserModal = false;
        $this->resetForm();
    }

    private function resetForm()
    {
        $this->reset([
            'nama_entitas', 'username', 'email', 'password', 'role',
            'NIS', 'jumlah_siswa', 'no_telp', 'plat_nomor', 'jenis_kendaraan',
            'no_str', 'spesialisasi', 'editingUserId'
        ]);
    }

    public function render()
    {
        // All users for list
        $users = \App\Models\User::with(['sekolah', 'kurir', 'ahliGizi'])->latest()->get();

        // All pengiriman for monitoring table
        $allPengiriman = Pengiriman::with(['menu.dapur', 'menu.targetSekolah', 'laporanSekolah'])
            ->latest()
            ->get();

        // Overdue deliveries (> 2 hours in transit)
        $overdueCount = $allPengiriman->filter(fn($p) => $p->isOverdue())->count();
        $warningCount = $allPengiriman->filter(fn($p) => $p->isWarning())->count();

        // Stats
        $totalPorsiMingguIni = Menu::whereHas('pengiriman', fn($q) => $q->where('status_logistik', 'Diterima'))
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('porsi_rencana');

        $avgRating = LaporanSekolah::whereDate('created_at', '>=', now()->startOfWeek())
            ->avg('rating');

        $totalWaste = LaporanSekolah::whereDate('created_at', '>=', now()->startOfWeek())->sum('food_waste');
        $totalPorsi = LaporanSekolah::whereDate('created_at', '>=', now()->startOfWeek())->sum('porsi_diterima');
        $wastePercentage = $totalPorsi > 0 ? round(($totalWaste / $totalPorsi) * 100, 1) : 0;

        // Chart data — porsi per day this week
        $porsiPerDay = [];
        $ratingPerDay = [];
        $wastePerDay = [];
        $labels = [];

        for ($i = 0; $i < 7; $i++) {
            $date = now()->startOfWeek()->addDays($i);
            $labels[] = $date->translatedFormat('D');

            $porsiPerDay[] = Menu::whereHas('pengiriman', fn($q) => $q->where('status_logistik', 'Diterima'))
                ->whereDate('created_at', $date)
                ->sum('porsi_rencana');

            $dayRating = LaporanSekolah::whereDate('created_at', $date)->avg('rating');
            $ratingPerDay[] = $dayRating ? round($dayRating, 1) : 0;

            $dayWaste = LaporanSekolah::whereDate('created_at', $date)->sum('food_waste');
            $dayPorsi = LaporanSekolah::whereDate('created_at', $date)->sum('porsi_diterima');
            $wastePerDay[] = $dayPorsi > 0 ? round(($dayWaste / $dayPorsi) * 100, 1) : 0;
        }

        $chartData = [
            'labels' => $labels,
            'porsi' => $porsiPerDay,
            'rating' => $ratingPerDay,
            'waste' => $wastePerDay,
        ];

        $stats = [
            'totalPorsi' => $totalPorsiMingguIni,
            'avgRating' => $avgRating ? round($avgRating, 1) : '-',
            'wastePercentage' => $wastePercentage,
            'overdueCount' => $overdueCount,
            'warningCount' => $warningCount,
            'totalPengiriman' => $allPengiriman->count(),
        ];

        return view('livewire.admin.admin-dashboard', compact('allPengiriman', 'stats', 'chartData', 'users'));
    }
}
