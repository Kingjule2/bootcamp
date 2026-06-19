<div wire:poll.5s>
    {{-- Flash Message --}}
    @if(session('success'))
        <div style="background: #d1fae5; border: 1px solid #a7f3d0; border-radius: 0.75rem; padding: 0.875rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; animation: slideIn 0.3s ease;">
            <span style="font-size: 0.875rem; color: #065f46; font-weight: 500;">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Stats Row --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
        <div class="stat-card">
            <div>
                <div class="stat-value">{{ $stats['total'] }}</div>
                <div class="stat-label">Total Menu</div>
            </div>
        </div>
        <div class="stat-card">
            <div>
                <div class="stat-value">{{ $stats['pending'] }}</div>
                <div class="stat-label">Menunggu Verifikasi</div>
            </div>
        </div>
        <div class="stat-card">
            <div>
                <div class="stat-value">{{ $stats['approved'] }}</div>
                <div class="stat-label">Siap Masak</div>
            </div>
        </div>
        <div class="stat-card">
            <div>
                <div class="stat-value">{{ $stats['rejected'] }}</div>
                <div class="stat-label">Ditolak</div>
            </div>
        </div>
    </div>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
        {{-- Left: Input Menu Form --}}
        <div>
            @livewire('dapur.form-input-menu')
        </div>

        {{-- Right: Menu List & Status Tracking --}}
        <div class="card">
            <div class="card-header">
                <h3 style="font-size: 0.9375rem; font-weight: 700; margin: 0;">Status Menu Harian</h3>
            </div>
            <div class="card-body" style="padding: 0;">
                @include('Pages.01_DapurDashboard.StatusTracking')
            </div>
        </div>
    </div>

    {{-- Kirim Modal --}}
    @include('Pages.01_DapurDashboard.TombolKirim')
</div>
