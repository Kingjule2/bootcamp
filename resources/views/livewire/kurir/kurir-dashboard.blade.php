<div>
    {{-- Stats Row --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
        <div class="stat-card">
            <div>
                <div class="stat-value">{{ $stats['dalam_perjalanan'] }}</div>
                <div class="stat-label">Dalam Perjalanan</div>
            </div>
        </div>
        <div class="stat-card">
            <div>
                <div class="stat-value">{{ $stats['selesai_hari_ini'] }}</div>
                <div class="stat-label">Selesai Hari Ini</div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 1.125rem; font-weight: 700; margin: 0;">Tugas Pengiriman Saya</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            @forelse($pengirimans as $p)
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--color-border); transition: background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem;">
                            <div style="flex: 1; min-width: 0;">
                                <div style="font-size: 1rem; font-weight: 600; color: var(--color-text-primary); margin-bottom: 0.35rem;" class="truncate-2">
                                    {{ $p->menu->nama_menu }}
                                </div>
                                <div style="font-size: 0.8125rem; color: var(--color-text-muted); display: flex; gap: 0.85rem; flex-wrap: wrap;">
                                    <span>{{ $p->menu->porsi_rencana }} porsi</span>
                                </div>
                            </div>
                            <div>
                                <span class="badge badge-{{ $p->status_logistik === 'Diterima' ? 'received' : 'transit' }}">
                                    {{ $p->status_logistik }}
                                </span>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; padding: 1rem; background: #f8fafc; border-radius: 0.5rem; border: 1px solid var(--color-border);">
                            <div>
                                <div style="font-size: 0.6875rem; font-weight: 700; color: var(--color-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Dari (Katering)</div>
                                <div style="font-size: 0.875rem; font-weight: 600; color: var(--color-text-primary);">{{ $p->menu->dapur->nama_entitas }}</div>
                            </div>
                            <div>
                                <div style="font-size: 0.6875rem; font-weight: 700; color: var(--color-text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.25rem;">Tujuan (Sekolah)</div>
                                <div style="font-size: 0.875rem; font-weight: 600; color: var(--color-primary-600);">{{ $p->menu->targetSekolah->nama_entitas }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div style="padding: 4rem; text-align: center; color: var(--color-text-muted);">
                    <p style="margin: 0; font-size: 1.125rem; font-weight: 500;">Belum ada tugas pengiriman untuk Anda.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
