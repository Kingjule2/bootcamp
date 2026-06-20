<div>
    @if(session('success'))
        <div style="background: #d1fae5; border: 1px solid #a7f3d0; border-radius: 0.75rem; padding: 0.875rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; animation: slideIn 0.3s ease;">
            <span style="font-size: 0.875rem; color: #065f46; font-weight: 500;">{{ session('success') }}</span>
        </div>
    @endif

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

    {{-- Header & Tab Switcher --}}
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 1rem;">
        <h3 style="font-size: 1.125rem; font-weight: 700; margin: 0;">Tugas Pengiriman Saya</h3>
        
        <div style="display: flex; gap: 0.5rem; background: #f1f5f9; padding: 0.375rem; border-radius: 0.75rem; border: 1px solid var(--color-border);">
            <button wire:click="$set('activeTab', 'aktif')" style="display: flex; align-items: center; gap: 0.4rem; background: {{ $activeTab === 'aktif' ? 'white' : 'transparent' }}; color: {{ $activeTab === 'aktif' ? 'var(--color-primary-700)' : 'var(--color-text-secondary)' }}; border: none; padding: 0.4rem 0.875rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.8125rem; cursor: pointer; box-shadow: {{ $activeTab === 'aktif' ? '0 1px 3px rgba(0,0,0,0.1)' : 'none' }}; transition: all 0.2s;">
                🚚 Pengiriman Aktif
                @if($stats['dalam_perjalanan'] > 0)
                    <span style="background: var(--color-primary-600); color: white; font-size: 0.6875rem; border-radius: 9999px; padding: 0.1rem 0.5rem; min-width: 1.25rem; text-align: center;">{{ $stats['dalam_perjalanan'] }}</span>
                @endif
            </button>
            <button wire:click="$set('activeTab', 'riwayat')" style="display: flex; align-items: center; gap: 0.4rem; background: {{ $activeTab === 'riwayat' ? 'white' : 'transparent' }}; color: {{ $activeTab === 'riwayat' ? 'var(--color-primary-700)' : 'var(--color-text-secondary)' }}; border: none; padding: 0.4rem 0.875rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.8125rem; cursor: pointer; box-shadow: {{ $activeTab === 'riwayat' ? '0 1px 3px rgba(0,0,0,0.1)' : 'none' }}; transition: all 0.2s;">
                📋 Riwayat Selesai
            </button>
        </div>
    </div>
        <div class="card-body" style="padding: 0;">
            @if($activeTab === 'aktif')
                @forelse($pengirimanAktif as $p)
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
                                @if($p->menu->sekolah && $p->menu->sekolah->no_telp)
                                    <div style="font-size: 0.75rem; color: var(--color-text-muted); margin-top: 0.2rem;">
                                        📞 {{ $p->menu->sekolah->no_telp }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($p->status_logistik === 'Dalam Perjalanan')
                            <div style="display: flex; justify-content: flex-end; margin-top: 0.5rem;">
                                <button wire:click="tandaiDiterima({{ $p->id_pengiriman }})" class="btn" style="background: var(--color-primary-600); color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; gap: 0.35rem; transition: background 0.2s;" onmouseover="this.style.background='var(--color-primary-700)'" onmouseout="this.style.background='var(--color-primary-600)'">
                                    ✅ Tandai Sudah Sampai / Diserahkan
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
                @empty
                    <div style="padding: 4rem; text-align: center; color: var(--color-text-muted);">
                        <p style="margin: 0; font-size: 1.125rem; font-weight: 500;">Anda tidak memiliki pengiriman aktif saat ini.</p>
                        <p style="font-size: 0.8125rem; margin-top: 0.5rem;">Status Anda saat ini adalah Standby.</p>
                    </div>
                @endforelse
            @endif

            @if($activeTab === 'riwayat')
                @forelse($riwayatSelesai as $p)
                    <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--color-border); transition: background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
                            <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem;">
                                <div style="flex: 1; min-width: 0;">
                                    <div style="font-size: 1rem; font-weight: 600; color: var(--color-text-primary); margin-bottom: 0.35rem;" class="truncate-2">
                                        {{ $p->menu->nama_menu }}
                                    </div>
                                    <div style="font-size: 0.8125rem; color: var(--color-text-muted); display: flex; gap: 0.85rem; flex-wrap: wrap;">
                                        <span>Ke: {{ $p->menu->targetSekolah->nama_entitas }}</span>
                                        <span>{{ $p->menu->porsi_rencana }} porsi</span>
                                    </div>
                                </div>
                                <span class="badge badge-received">Selesai</span>
                            </div>
                            <div style="font-size: 0.75rem; color: var(--color-text-muted);">
                                Waktu Berangkat: {{ $p->dispatched_at->format('d M Y H:i') }} | Diterima: {{ $p->received_at->format('H:i') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div style="padding: 4rem; text-align: center; color: var(--color-text-muted);">
                        <p style="margin: 0; font-size: 1.125rem; font-weight: 500;">Belum ada riwayat pengiriman.</p>
                    </div>
                @endforelse
            @endif
        </div>
    </div>
</div>
