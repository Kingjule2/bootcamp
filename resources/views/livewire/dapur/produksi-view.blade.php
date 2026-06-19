<div>
    {{-- Flash Message --}}
    @if(session('success'))
        <div style="background: #d1fae5; border: 1px solid #a7f3d0; border-radius: 0.75rem; padding: 0.875rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; animation: slideIn 0.3s ease;">
            <span style="font-size: 0.875rem; color: #065f46; font-weight: 500;">{{ session('success') }}</span>
        </div>
    @endif

    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 1.125rem; font-weight: 700; margin: 0;">Daftar Menu untuk Diproduksi</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            @forelse($menus as $menu)
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--color-border); transition: background 0.15s;" onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background='transparent'">
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem;">
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-size: 1rem; font-weight: 600; color: var(--color-text-primary); margin-bottom: 0.35rem;" class="truncate-2">
                                {{ $menu->nama_menu }}
                            </div>
                            <div style="font-size: 0.8125rem; color: var(--color-text-muted); display: flex; gap: 0.85rem; flex-wrap: wrap;">
                                <span>Sekolah: {{ $menu->targetSekolah->nama_entitas }}</span>
                                <span>Kalori: {{ $menu->kalori }} kkal</span>
                                <span>Protein: {{ $menu->protein }}g protein</span>
                                <span>Porsi: {{ $menu->porsi_rencana }} porsi</span>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
                            @if(!$menu->pengiriman)
                                <button wire:click="mulaiMasak({{ $menu->id_menus }})" class="btn" style="background: var(--color-primary-600); color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; border: none; font-weight: 600; cursor: pointer;">
                                    👨‍🍳 Mulai Masak
                                </button>
                            @elseif($menu->pengiriman->status_logistik === 'Sedang Dimasak')
                                <span class="badge" style="background: #fef3c7; color: #d97706; padding: 0.5rem 1rem; font-size: 0.875rem;">
                                    Sedang Dimasak
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @empty
                <div style="padding: 4rem; text-align: center; color: var(--color-text-muted);">
                    <p style="margin: 0; font-size: 1.125rem; font-weight: 500;">Belum ada menu yang siap dimasak saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
