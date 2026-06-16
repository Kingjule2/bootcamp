<div wire:poll.5s>
    {{-- Flash Message --}}
    @if(session('success'))
        <div style="background: #d1fae5; border: 1px solid #a7f3d0; border-radius: 0.75rem; padding: 0.875rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; animation: slideIn 0.3s ease;">
            <span>✅</span>
            <span style="font-size: 0.875rem; color: #065f46; font-weight: 500;">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Stats Row --}}
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-bottom: 1.5rem;">
        <div class="stat-card">
            <div class="stat-icon" style="background: #fef3c7; color: #d97706;">⏳</div>
            <div>
                <div class="stat-value">{{ $stats['pending'] }}</div>
                <div class="stat-label">Antrean Pending</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #d1fae5; color: #059669;">✅</div>
            <div>
                <div class="stat-value">{{ $stats['approved_today'] }}</div>
                <div class="stat-label">Disetujui Hari Ini</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #fee2e2; color: #dc2626;">❌</div>
            <div>
                <div class="stat-value">{{ $stats['rejected_today'] }}</div>
                <div class="stat-label">Ditolak Hari Ini</div>
            </div>
        </div>
    </div>

    {{-- Review Queue Table --}}
    <div class="card" style="margin-bottom: 1.5rem;">
        <div class="card-header">
            <h3 style="font-size: 0.9375rem; font-weight: 700; margin: 0;">📋 Antrean Verifikasi Menu</h3>
            <span class="badge badge-pending">{{ $stats['pending'] }} menunggu</span>
        </div>
        <div class="card-body" style="padding: 0; overflow-x: auto;">
            @include('Pages.02_GiziDashboard.ReviewQueueTable')
        </div>
    </div>

    {{-- Recent Actions --}}
    @if($recentActions->count() > 0)
        <div class="card">
            <div class="card-header">
                <h3 style="font-size: 0.9375rem; font-weight: 700; margin: 0;">📜 Riwayat Verifikasi Terkini</h3>
            </div>
            <div class="card-body" style="padding: 0;">
                @foreach($recentActions as $action)
                    <div style="padding: 0.75rem 1.5rem; border-bottom: 1px solid var(--color-border); display: flex; align-items: center; justify-content: space-between;">
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-size: 0.8125rem; font-weight: 500;" class="truncate-2">{{ $action->nama_menu }}</div>
                            <div style="font-size: 0.6875rem; color: var(--color-text-muted);">
                                {{ $action->dapur->nama_entitas }} → {{ $action->targetSekolah->nama_entitas }}
                            </div>
                        </div>
                        @if($action->status === 'Ready to Cook')
                            <span class="badge badge-approved">✅ Approved</span>
                        @else
                            <span class="badge badge-rejected">❌ Rejected</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Verification Modal --}}
    @include('Pages.02_GiziDashboard.ModalVerifikasi')
</div>
