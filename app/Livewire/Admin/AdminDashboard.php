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

    // Filter & Search
    #[Url]
    public $search = '';
    
    #[Url]
    public $filterStatus = '';
    
    #[Url]
    public $filterDate = '';

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

    /**
     * Mengganti tab aktif pada tampilan dashboard (misal: monitoring atau user management).
     *
     * @param string $tab Nama tab yang akan diaktifkan
     */
    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }

    /**
     * Membuka modal untuk menambahkan user baru.
     * Mereset form dan memastikan mode bukan edit.
     */
    public function openAddUser()
    {
        $this->resetForm();
        $this->editingUserId = null;
        $this->showUserModal = true;
    }

    /**
     * Membuka modal untuk mengedit data user yang sudah ada.
     * Memuat data user beserta profil spesifiknya (Sekolah/Kurir/Ahli Gizi) ke dalam form.
     *
     * @param int $userId ID user yang akan diedit
     */
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

    /**
     * Menyimpan data user (baik untuk penambahan user baru maupun update user).
     * Melakukan validasi data sesuai peran (role), mengenkripsi password (jika ada),
     * menyimpan data ke tabel users, serta mensinkronisasi data profil spesifik.
     */
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

    /**
     * Menghapus user dari sistem beserta data profil terkaitnya.
     * Melakukan pengecekan terlebih dahulu agar tidak menghapus user yang masih memiliki tanggungan aktif
     * (seperti menu aktif di dapur atau pengiriman aktif di kurir).
     *
     * @param int $userId ID user yang akan dihapus
     */
    public function deleteUser($userId)
    {
        if ($userId === auth()->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
            return;
        }

        $user = \App\Models\User::findOrFail($userId);

        // Cek menu aktif (Dapur)
        $activeMenus = \App\Models\Menu::where('dapur_id', $userId)
            ->whereIn('status', ['Pending Verification', 'Ready to Cook'])
            ->count();

        // Cek pengiriman aktif (Kurir)
        $kurirProfile = \App\Models\Kurir::where('id_users', $userId)->first();
        $activeDeliveries = $kurirProfile
            ? \App\Models\Pengiriman::where('id_kurir', $kurirProfile->id_kurir)
                ->where('status_logistik', 'Dalam Perjalanan')
                ->count()
            : 0;

        if ($activeMenus > 0 || $activeDeliveries > 0) {
            session()->flash('error',
                "Tidak bisa menghapus user ini karena masih memiliki " .
                ($activeMenus > 0 ? "{$activeMenus} menu aktif" : '') .
                ($activeMenus > 0 && $activeDeliveries > 0 ? ' dan ' : '') .
                ($activeDeliveries > 0 ? "{$activeDeliveries} pengiriman aktif" : '') . "."
            );
            return;
        }

        // Delete profiles first
        \App\Models\Sekolah::where('id_users', $userId)->delete();
        \App\Models\Kurir::where('id_users', $userId)->delete();
        \App\Models\AhliGizi::where('id_users', $userId)->delete();

        $user->delete();
        session()->flash('success', 'User berhasil dihapus.');
    }

    /**
     * Menutup modal manajemen user dan mereset semua field pada form.
     */
    public function closeUserModal()
    {
        $this->showUserModal = false;
        $this->resetForm();
    }

    /**
     * Mengosongkan dan mereset seluruh field form input user ke kondisi awal.
     */
    private function resetForm()
    {
        $this->reset([
            'nama_entitas', 'username', 'email', 'password', 'role',
            'NIS', 'jumlah_siswa', 'no_telp', 'plat_nomor', 'jenis_kendaraan',
            'no_str', 'spesialisasi', 'editingUserId'
        ]);
    }

    /**
     * Mengunduh data laporan pengiriman MBG dalam format CSV.
     * Menerapkan filter pencarian, status, dan tanggal sebelum mengekspor data,
     * serta memformat data ke dalam struktur CSV.
     */
    public function exportCSV()
    {
        $query = Pengiriman::with(['menu.dapur', 'menu.targetSekolah', 'kurir.user', 'laporanSekolah']);

        if ($this->search) {
            $query->whereHas('menu', function ($q) {
                $q->where('nama_menu', 'like', '%' . $this->search . '%')
                  ->orWhereHas('dapur', fn($q2) => $q2->where('nama_entitas', 'like', '%' . $this->search . '%'))
                  ->orWhereHas('targetSekolah', fn($q3) => $q3->where('nama_entitas', 'like', '%' . $this->search . '%'));
            });
        }

        if ($this->filterStatus) {
            $query->where('status_logistik', $this->filterStatus);
        }

        if ($this->filterDate) {
            $query->whereDate('created_at', $this->filterDate);
        }

        $pengiriman = $query->latest()->get();

        $csvData = "ID Pengiriman,Status,Katering,Menu,Sekolah Tujuan,Kurir,Waktu Berangkat,Waktu Diterima,Porsi,Rating\n";

        foreach ($pengiriman as $p) {
            $csvData .= sprintf(
                "%s,%s,\"%s\",\"%s\",\"%s\",\"%s\",%s,%s,%s,%s\n",
                $p->id_pengiriman,
                $p->status_logistik,
                $p->menu->dapur->nama_entitas ?? '-',
                str_replace('"', '""', $p->menu->nama_menu ?? '-'),
                $p->menu->targetSekolah->nama_entitas ?? '-',
                $p->kurir->user->nama_entitas ?? '-',
                $p->dispatched_at ? $p->dispatched_at->format('Y-m-d H:i') : '-',
                $p->received_at ? $p->received_at->format('Y-m-d H:i') : '-',
                $p->menu->porsi_rencana,
                $p->laporanSekolah->rating ?? '-'
            );
        }

        return response()->streamDownload(function () use ($csvData) {
            echo $csvData;
        }, 'laporan_mbg_' . date('Y-m-d') . '.csv');
    }

    /**
     * Menampilkan komponen dashboard admin.
     * Mengambil data seluruh pengguna, data pengiriman (dengan filter),
     * menghitung berbagai metrik dan statistik (peringatan, overdue, waste, dll),
     * serta menyiapkan data untuk ditampilkan pada chart/grafik.
     */
    public function render()
    {
        // All users for list
        $users = \App\Models\User::with(['sekolah', 'kurir', 'ahliGizi'])->latest()->get();

        // All pengiriman for monitoring table
        // All pengiriman for monitoring table with filters
        $query = Pengiriman::with(['menu.dapur', 'menu.targetSekolah', 'kurir.user', 'laporanSekolah']);

        if ($this->search) {
            $query->whereHas('menu', function ($q) {
                $q->where('nama_menu', 'like', '%' . $this->search . '%')
                  ->orWhereHas('dapur', fn($q2) => $q2->where('nama_entitas', 'like', '%' . $this->search . '%'))
                  ->orWhereHas('targetSekolah', fn($q3) => $q3->where('nama_entitas', 'like', '%' . $this->search . '%'));
            });
        }

        if ($this->filterStatus) {
            $query->where('status_logistik', $this->filterStatus);
        }

        if ($this->filterDate) {
            $query->whereDate('created_at', $this->filterDate);
        }

        $allPengiriman = $query->latest()->get();

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
