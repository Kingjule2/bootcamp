<?php

namespace App\Livewire\Admin;

use App\Models\LaporanSekolah;
use App\Models\Menu;
use App\Models\Pengiriman;
use Carbon\Carbon;
use Livewire\Component;

class AdminDashboard extends Component
{
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

        return view('livewire.admin.admin-dashboard', compact('allPengiriman', 'stats', 'chartData'));
    }
}
