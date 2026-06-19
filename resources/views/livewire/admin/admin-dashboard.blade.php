<div wire:poll.10s>
    {{-- Flash Messages --}}
    @if(session('success'))
        <div style="background: #d1fae5; border: 1px solid #a7f3d0; border-radius: 0.75rem; padding: 0.875rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; animation: slideIn 0.3s ease;">
            <span style="font-size: 0.875rem; color: #065f46; font-weight: 500;">✅ {{ session('success') }}</span>
        </div>
    @endif
    @if(session('error'))
        <div style="background: #fee2e2; border: 1px solid #fecaca; border-radius: 0.75rem; padding: 0.875rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; animation: slideIn 0.3s ease;">
            <span style="font-size: 0.875rem; color: #991b1b; font-weight: 500;">⚠️ {{ session('error') }}</span>
        </div>
    @endif
    {{-- Modern Tab Switcher --}}
    <div style="display: flex; gap: 0.5rem; margin-bottom: 1.5rem; background: #f1f5f9; padding: 0.375rem; border-radius: 0.75rem; width: max-content; border: 1px solid var(--color-border);">
        <button wire:click="switchTab('monitoring')" style="display: flex; align-items: center; gap: 0.5rem; background: {{ $activeTab === 'monitoring' ? 'white' : 'transparent' }}; color: {{ $activeTab === 'monitoring' ? 'var(--color-primary-700)' : 'var(--color-text-secondary)' }}; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem; cursor: pointer; box-shadow: {{ $activeTab === 'monitoring' ? '0 1px 3px rgba(0,0,0,0.1)' : 'none' }}; transition: all 0.2s;">
            📡 Monitoring & Statistik
        </button>
        <button wire:click="switchTab('user_management')" style="display: flex; align-items: center; gap: 0.5rem; background: {{ $activeTab === 'user_management' ? 'white' : 'transparent' }}; color: {{ $activeTab === 'user_management' ? 'var(--color-primary-700)' : 'var(--color-text-secondary)' }}; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem; cursor: pointer; box-shadow: {{ $activeTab === 'user_management' ? '0 1px 3px rgba(0,0,0,0.1)' : 'none' }}; transition: all 0.2s;">
            👥 Manajemen User
        </button>
    </div>

    @if($activeTab === 'monitoring')
        {{-- Alert Banner for Overdue --}}
        @include('Pages.04_AdminDashboard.TimerAlertSystem')

        {{-- Stats Grid --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
            <div class="stat-card">
                <div class="stat-icon" style="background: var(--color-primary-100); color: var(--color-primary-600);">📦</div>
                <div>
                    <div class="stat-value">{{ number_format($stats['totalPorsi']) }}</div>
                    <div class="stat-label">Porsi Minggu Ini</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #fef3c7; color: #d97706;">⭐</div>
                <div>
                    <div class="stat-value">{{ $stats['avgRating'] }}</div>
                    <div class="stat-label">Rata-rata Rating</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: #e0f2fe; color: #0284c7;">🗑️</div>
                <div>
                    <div class="stat-value">{{ $stats['wastePercentage'] }}%</div>
                    <div class="stat-label">Food Waste</div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon" style="background: {{ $stats['overdueCount'] > 0 ? '#fee2e2' : '#d1fae5' }}; color: {{ $stats['overdueCount'] > 0 ? '#dc2626' : '#059669' }};">
                    {{ $stats['overdueCount'] > 0 ? '🚨' : '✅' }}
                </div>
                <div>
                    <div class="stat-value" style="{{ $stats['overdueCount'] > 0 ? 'color: #dc2626;' : '' }}">{{ $stats['overdueCount'] }}</div>
                    <div class="stat-label">Pengiriman Overdue</div>
                </div>
            </div>
        </div>

        {{-- Charts Row --}}
        @include('Pages.04_AdminDashboard.StatistikGrafik')

        {{-- Monitoring Table --}}
        <div class="card">
            <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem;">
                <div>
                    <h3 style="font-size: 0.9375rem; font-weight: 700; margin: 0;">📡 Monitoring Pengiriman Real-Time</h3>
                    <span style="font-size: 0.75rem; color: var(--color-text-muted);">{{ $stats['totalPengiriman'] }} total pengiriman</span>
                </div>
                
                {{-- Filters & Actions --}}
                <div style="display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari menu, dapur, sekolah..." style="padding: 0.4rem 0.75rem; font-size: 0.8125rem; border: 1px solid var(--color-border); border-radius: 0.5rem; outline: none; width: 220px;" />
                    
                    <select wire:model.live="filterStatus" style="padding: 0.4rem 0.75rem; font-size: 0.8125rem; border: 1px solid var(--color-border); border-radius: 0.5rem; outline: none;">
                        <option value="">Semua Status</option>
                        <option value="Sedang Dimasak">Sedang Dimasak</option>
                        <option value="Dalam Perjalanan">Dalam Perjalanan</option>
                        <option value="Diterima">Diterima</option>
                    </select>

                    <input type="date" wire:model.live="filterDate" style="padding: 0.4rem 0.75rem; font-size: 0.8125rem; border: 1px solid var(--color-border); border-radius: 0.5rem; outline: none;" />

                    <button wire:click="exportCSV" style="background: white; border: 1px solid var(--color-border); color: #16a34a; font-weight: 600; font-size: 0.8125rem; padding: 0.4rem 0.875rem; border-radius: 0.5rem; cursor: pointer; display: flex; align-items: center; gap: 0.35rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.2s;" onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background='white'">
                        📊 Export CSV
                    </button>
                </div>
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
                                    <td>
                                        @if($p->status_logistik === 'Diterima')
                                            <span class="traffic-green" style="font-size: 1.25rem;">🟢</span>
                                        @elseif($p->isOverdue())
                                            <span class="traffic-red" style="font-size: 1.25rem;">🔴</span>
                                        @elseif($p->isWarning())
                                            <span class="traffic-yellow" style="font-size: 1.25rem;">🟡</span>
                                        @elseif($p->status_logistik === 'Dalam Perjalanan')
                                            <span class="traffic-yellow" style="font-size: 1.25rem;">🟡</span>
                                        @else
                                            <span style="font-size: 1.25rem;">⚪</span>
                                        @endif
                                    </td>
                                    <td style="font-size: 0.8125rem; font-weight: 500;">{{ $p->menu?->dapur?->nama_entitas ?? '-' }}</td>
                                    <td>
                                        <div class="truncate-2" style="max-width: 180px; font-size: 0.8125rem;">{{ $p->menu?->nama_menu ?? '-' }}</div>
                                    </td>
                                    <td style="font-size: 0.8125rem;">{{ $p->menu?->targetSekolah?->nama_entitas ?? '-' }}</td>
                                    <td style="font-size: 0.8125rem;">
                                        @if($p->kurir?->user)
                                            {{ $p->kurir->user->nama_entitas }}
                                        @else
                                            <span style="color: var(--color-text-muted); font-style: italic;">Belum Ditentukan</span>
                                        @endif
                                    </td>
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
                                            <span style="font-weight: 600;">⭐ {{ $p->laporanSekolah->rating }}/5</span>
                                        @else
                                            <span style="color: var(--color-text-muted);">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @if($p->isOverdue())
                                    <tr>
                                        <td colspan="9" style="padding: 0.5rem 1rem; background: #fef2f2; border-bottom: 2px solid #fecaca;">
                                            <div style="display: flex; align-items: center; gap: 0.5rem; color: #991b1b; font-size: 0.8125rem; font-weight: 600;">
                                                ⚠️ WARNING: Potensi Makanan Basi — Pengiriman sudah {{ $p->getDeliveryDurationMinutes() }} menit tanpa konfirmasi!
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div style="padding: 3rem; text-align: center; color: var(--color-text-muted);">
                        <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📡</div>
                        <p style="margin: 0;">Belum ada data pengiriman.</p>
                    </div>
                @endif
            </div>
        </div>
    @else
        @include('Pages.04_AdminDashboard.UserManagement')
    @endif

    {{-- User Modal Form --}}
    @include('Pages.04_AdminDashboard.ModalUserForm')


</div>
