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
    #[Url]
    public $tab = 'monitoring';

    // Properties for creating user
    public $newUsername = '';
    public $newPassword = '';
    public $newRole = '';
    public $newNamaEntitas = '';

    protected $validationAttributes = [
        'newUsername' => 'Username',
        'newPassword' => 'Password',
        'newRole' => 'Role',
        'newNamaEntitas' => 'Nama Instansi/Entitas',
    ];

    public function createUser()
    {
        $this->validate([
            'newUsername' => 'required|string|min:4|unique:users,username',
            'newPassword' => 'required|string|min:6',
            'newRole' => 'required|in:dapur,ahli_gizi,sekolah,admin,kurir',
            'newNamaEntitas' => 'required|string|min:4',
        ]);

        $user = User::create([
            'username' => $this->newUsername,
            'password' => $this->newPassword, // Hashes automatically via casts in User model
            'role' => $this->newRole,
            'nama_entitas' => $this->newNamaEntitas,
        ]);

        // Create child metadata record if applicable
        if ($user->role === 'sekolah') {
            Sekolah::create([
                'id_users' => $user->id_users,
                'NIS' => rand(100000, 999999),
                'jumlah_siswa' => 0,
                'no_telp' => 0,
            ]);
        } elseif ($user->role === 'ahli_gizi') {
            AhliGizi::create([
                'id_users' => $user->id_users,
                'no_str' => '-',
                'spesialisasi' => 'Gizi Anak & Remaja',
                'min_kalori' => 0,
                'max_kalori' => 0,
                'min_protein' => 0,
                'max_karbohidrat' => 0,
                'max_lemak' => 0,
                'status_menu' => 'Approve',
                'catatan' => '-',
            ]);
        } elseif ($user->role === 'kurir') {
            Kurir::create([
                'id_users' => $user->id_users,
                'no_telp' => '-',
                'plat_nomor' => '-',
                'jenis_kendaraan' => '-',
                'status_tugas' => 'Standby',
            ]);
        }

        $this->reset(['newUsername', 'newPassword', 'newRole', 'newNamaEntitas']);

        session()->flash('message', 'Pengguna baru berhasil dibuat!');
    }

    public function deleteUser($userId)
    {
        if ($userId === auth()->id()) {
            session()->flash('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
            return;
        }

        $user = User::find($userId);
        if ($user) {
            $user->delete();
            session()->flash('message', 'Pengguna berhasil dihapus!');
        }
    }

    public function render()
    {
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

        // Fetch users list if on user management tab
        $users = [];
        if ($this->tab === 'users') {
            $users = User::latest()->get();
        }

        return view('livewire.admin.admin-dashboard', compact('allPengiriman', 'stats', 'chartData', 'users'));
    }
}
