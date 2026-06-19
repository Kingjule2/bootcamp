<div wire:poll.10s>
    @if($tab === 'monitoring')
        {{-- Alert Banner for Overdue --}}
        @include('Pages.04_AdminDashboard.TimerAlertSystem')

        {{-- Stats Grid --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
            <div class="stat-card">
                <div>
                    <div class="stat-value">{{ number_format($stats['totalPorsi']) }}</div>
                    <div class="stat-label">Porsi Minggu Ini</div>
                </div>
            </div>
            <div class="stat-card">
                <div>
                    <div class="stat-value">{{ $stats['avgRating'] }}</div>
                    <div class="stat-label">Rata-rata Rating</div>
                </div>
            </div>
            <div class="stat-card">
                <div>
                    <div class="stat-value">{{ $stats['wastePercentage'] }}%</div>
                    <div class="stat-label">Food Waste</div>
                </div>
            </div>
            <div class="stat-card">
                <div>
                    <div class="stat-value" style="{{ $stats['overdueCount'] > 0 ? 'color: #dc2626;' : '' }}">{{ $stats['overdueCount'] }}</div>
                    <div class="stat-label">Pengiriman Overdue</div>
                </div>
            </div>
        </div>

        {{-- Monitoring Table --}}
        <div class="card">
            <div class="card-header">
                <h3 style="font-size: 0.9375rem; font-weight: 700; margin: 0; color: var(--color-text-primary);">Monitoring Pengiriman Real-Time</h3>
                <span style="font-size: 0.75rem; color: var(--color-text-muted);">{{ $stats['totalPengiriman'] }} total pengiriman</span>
            </div>
            <div class="card-body" style="padding: 0; overflow-x: auto;">
                @if($allPengiriman->count() > 0)
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Katering</th>
                                <th>Menu</th>
                                <th>Sekolah Tujuan</th>
                                <th>Kurir</th>
                                <th>Berangkat</th>
                                <th>Diterima</th>
                                <th>Durasi</th>
                                <th>Rating</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allPengiriman as $p)
                                <tr class="{{ $p->isOverdue() ? 'row-overdue' : '' }}">
                                    <td style="text-align: center; vertical-align: middle;">
                                        @if($p->status_logistik === 'Diterima')
                                            <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: #10b981;" title="Diterima"></span>
                                        @elseif($p->isOverdue())
                                            <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: #ef4444;" title="Overdue"></span>
                                        @elseif($p->isWarning() || $p->status_logistik === 'Dalam Perjalanan')
                                            <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: #f59e0b;" title="Dalam Perjalanan"></span>
                                        @else
                                            <span style="display: inline-block; width: 10px; height: 10px; border-radius: 50%; background-color: #94a3b8;" title="Sedang Dimasak"></span>
                                        @endif
                                    </td>
                                    <td style="font-size: 0.8125rem; font-weight: 500;">{{ $p->menu->dapur->nama_entitas }}</td>
                                    <td>
                                        <div class="truncate-2" style="max-width: 180px; font-size: 0.8125rem;">{{ $p->menu->nama_menu }}</div>
                                    </td>
                                    <td style="font-size: 0.8125rem;">{{ $p->menu->targetSekolah->nama_entitas }}</td>
                                    <td style="font-size: 0.8125rem;">{{ $p->nama_kurir }}</td>
                                    <td style="font-size: 0.8125rem; color: var(--color-text-muted);">
                                        {{ $p->dispatched_at ? $p->dispatched_at->format('H:i') : '-' }}
                                    </td>
                                    <td style="font-size: 0.8125rem; color: var(--color-text-muted);">
                                        {{ $p->received_at ? $p->received_at->format('H:i') : '-' }}
                                    </td>
                                    <td>
                                        @if($p->getDeliveryDurationMinutes() !== null)
                                            <span style="font-weight: 600; color: {{ $p->isOverdue() ? '#dc2626' : ($p->isWarning() ? '#d97706' : 'var(--color-primary-600)') }};">
                                                {{ $p->getDeliveryDurationMinutes() }} min
                                            </span>
                                        @else
                                            <span style="color: var(--color-text-muted);">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($p->laporanSekolah)
                                            <span style="font-weight: 600;">{{ $p->laporanSekolah->rating }}/5</span>
                                        @else
                                            <span style="color: var(--color-text-muted);">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($p->isOverdue())
                                    <tr>
                                        <td colspan="9" style="padding: 0.5rem 1rem; background: #fef2f2; border-bottom: 2px solid #fecaca;">
                                            <div style="display: flex; align-items: center; gap: 0.5rem; color: #991b1b; font-size: 0.8125rem; font-weight: 600;">
                                                Peringatan: Potensi Makanan Basi — Pengiriman sudah {{ $p->getDeliveryDurationMinutes() }} menit tanpa konfirmasi!
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="padding: 3rem; text-align: center; color: var(--color-text-muted);">
                        <p style="margin: 0;">Belum ada data pengiriman.</p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    @if($tab === 'statistik')
        {{-- Stats Grid --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
            <div class="stat-card">
                <div>
                    <div class="stat-value">{{ number_format($stats['totalPorsi']) }}</div>
                    <div class="stat-label">Porsi Minggu Ini</div>
                </div>
            </div>
            <div class="stat-card">
                <div>
                    <div class="stat-value">{{ $stats['avgRating'] }}</div>
                    <div class="stat-label">Rata-rata Rating</div>
                </div>
            </div>
            <div class="stat-card">
                <div>
                    <div class="stat-value">{{ $stats['wastePercentage'] }}%</div>
                    <div class="stat-label">Food Waste</div>
                </div>
            </div>
            <div class="stat-card">
                <div>
                    <div class="stat-value" style="{{ $stats['overdueCount'] > 0 ? 'color: #dc2626;' : '' }}">{{ $stats['overdueCount'] }}</div>
                    <div class="stat-label">Pengiriman Overdue</div>
                </div>
            </div>
        </div>

        {{-- Charts Row --}}
        @include('Pages.04_AdminDashboard.StatistikGrafik')
    @endif

    @if($tab === 'users')
        {{-- User Management Tab --}}
        <div style="margin-bottom: 1.5rem;">
            @if (session()->has('message'))
                <div class="badge badge-approved" style="width: 100%; justify-content: center; padding: 0.75rem; margin-bottom: 1.5rem; text-transform: none; font-size: 0.875rem;">
                    {{ session('message') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="badge badge-rejected" style="width: 100%; justify-content: center; padding: 0.75rem; margin-bottom: 1.5rem; text-transform: none; font-size: 0.875rem;">
                    {{ session('error') }}
                </div>
            @endif

            <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; align-items: start;">
                <!-- Tambah Pengguna Form -->
                <div class="card" style="flex: 1 1 300px; padding: 1.5rem; min-width: 0;">
                    <h3 style="font-size: 1.125rem; font-weight: 700; margin-bottom: 1.25rem; border-bottom: 1px solid var(--color-border); padding-bottom: 0.5rem; color: var(--color-text-primary);">Tambah Pengguna</h3>
                    <form wire:submit.prevent="createUser">
                        <div class="form-group">
                            <label class="form-label" for="newUsername">Username</label>
                            <input type="text" id="newUsername" wire:model="newUsername" class="form-input" placeholder="Masukkan username">
                            @error('newUsername') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="newPassword">Password</label>
                            <input type="password" id="newPassword" wire:model="newPassword" class="form-input" placeholder="Minimal 6 karakter">
                            @error('newPassword') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="newRole">Role</label>
                            <select id="newRole" wire:model="newRole" class="form-input" style="height: auto;">
                                <option value="">-- Pilih Role --</option>
                                <option value="dapur">Dapur (Katering Mitra)</option>
                                <option value="ahli_gizi">Ahli Gizi (Verifikator)</option>
                                <option value="sekolah">Sekolah (Penerima)</option>
                                <option value="admin">Admin Dinas</option>
                                <option value="kurir">Kurir</option>
                            </select>
                            @error('newRole') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="newNamaEntitas">Nama Entitas/Instansi/Kurir</label>
                            <input type="text" id="newNamaEntitas" wire:model="newNamaEntitas" class="form-input" placeholder="Nama instansi/kurir">
                            @error('newNamaEntitas') <span class="form-error">{{ $message }}</span> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem;">
                            Simpan Akun Baru
                        </button>
                    </form>
                </div>

                <!-- Daftar Pengguna Table -->
                <div class="card" style="flex: 2 2 600px; min-width: 0;">
                    <div class="card-header">
                        <h3 style="font-size: 1.125rem; font-weight: 700; margin: 0; color: var(--color-text-primary);">Daftar Pengguna Sistem</h3>
                        <span style="font-size: 0.75rem; color: var(--color-text-muted);">Total: {{ count($users) }} pengguna</span>
                    </div>
                    <div class="card-body" style="padding: 0; overflow-x: auto;">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Username</th>
                                    <th>Role</th>
                                    <th>Nama Entitas / Instansi</th>
                                    <th>Tanggal Dibuat</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td style="font-weight: 600;">{{ $user->username }}</td>
                                        <td>
                                            @if($user->role === 'admin')
                                                <span class="badge" style="background-color: #fee2e2; color: #991b1b; border: 1px solid #fecaca; text-transform: none;">Admin</span>
                                            @elseif($user->role === 'dapur')
                                                <span class="badge" style="background-color: #e0f2fe; color: #0369a1; border: 1px solid #bae6fd; text-transform: none;">Dapur</span>
                                            @elseif($user->role === 'ahli_gizi')
                                                <span class="badge" style="background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; text-transform: none;">Ahli Gizi</span>
                                            @elseif($user->role === 'sekolah')
                                                <span class="badge" style="background-color: #d1fae5; color: #047857; border: 1px solid #a7f3d0; text-transform: none;">Sekolah</span>
                                            @elseif($user->role === 'kurir')
                                                <span class="badge" style="background-color: #f3e8ff; color: #6b21a8; border: 1px solid #e9d5ff; text-transform: none;">Kurir</span>
                                            @endif
                                        </td>
                                        <td>{{ $user->nama_entitas }}</td>
                                        <td style="color: var(--color-text-muted); font-size: 0.8rem;">
                                            {{ $user->created_at ? $user->created_at->format('d M Y H:i') : '-' }}
                                        </td>
                                        <td style="text-align: center;">
                                            @if($user->id !== auth()->id())
                                                <button wire:click="deleteUser({{ $user->id }})" 
                                                        wire:confirm="Apakah Anda yakin ingin menghapus pengguna ini?"
                                                        class="btn btn-danger" 
                                                        style="padding: 0.35rem 0.75rem; font-size: 0.75rem; line-height: 1;">
                                                    Hapus
                                                </button>
                                            @else
                                                <span style="font-size: 0.75rem; color: var(--color-text-muted); font-style: italic;">Akun Anda</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Chart.js Initialization --}}
    @if($tab === 'statistik')
        <script>
            document.addEventListener('livewire:init', () => {
                initCharts();
            });

            // Re-init charts on Livewire poll updates
            document.addEventListener('livewire:navigated', () => {
                initCharts();
            });

            function initCharts() {
                const chartPorsiEl = document.getElementById('chartPorsi');
                if (!chartPorsiEl) return;

                const chartData = @json($chartData);

                // Destroy existing charts if they exist
                ['chartPorsi', 'chartRating', 'chartWaste'].forEach(id => {
                    const existing = Chart.getChart(id);
                    if (existing) existing.destroy();
                });

                // Chart 1: Total Porsi (Bar Chart)
                new Chart(chartPorsiEl, {
                    type: 'bar',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'Porsi',
                            data: chartData.porsi,
                            backgroundColor: 'rgba(16, 185, 129, 0.6)',
                            borderColor: 'rgb(5, 150, 105)',
                            borderWidth: 2,
                            borderRadius: 6,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: { legend: { display: false } },
                        scales: { y: { beginAtZero: true, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
                    }
                });

                // Chart 2: Rating (Line Chart)
                new Chart(document.getElementById('chartRating'), {
                    type: 'line',
                    data: {
                        labels: chartData.labels,
                        datasets: [{
                            label: 'Rating',
                            data: chartData.rating,
                            borderColor: 'rgb(245, 158, 11)',
                            backgroundColor: 'rgba(245, 158, 11, 0.1)',
                            fill: true,
                            tension: 0.4,
                            pointBackgroundColor: 'rgb(245, 158, 11)',
                            pointRadius: 4,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: { legend: { display: false } },
                        scales: { y: { min: 0, max: 5, grid: { color: '#f1f5f9' } }, x: { grid: { display: false } } }
                    }
                });

                // Chart 3: Food Waste (Doughnut Chart)
                const totalWaste = chartData.waste.reduce((a, b) => a + b, 0);
                const avgWaste = chartData.waste.length > 0 ? (totalWaste / chartData.waste.filter(v => v > 0).length || 0) : 0;
                new Chart(document.getElementById('chartWaste'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Food Waste', 'Terkonsumsi'],
                        datasets: [{
                            data: [avgWaste.toFixed(1), (100 - avgWaste).toFixed(1)],
                            backgroundColor: ['rgba(239, 68, 68, 0.6)', 'rgba(16, 185, 129, 0.6)'],
                            borderColor: ['rgb(220, 38, 38)', 'rgb(5, 150, 105)'],
                            borderWidth: 2,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        plugins: {
                            legend: { position: 'bottom', labels: { font: { size: 11 } } }
                        },
                        cutout: '65%',
                    }
                });
            }

            // Reinit on Livewire update
            if (typeof Livewire !== 'undefined') {
                Livewire.hook('morph.updated', () => {
                    setTimeout(initCharts, 100);
                });
            }
        </script>
    @endif
</div>
