@forelse($menus as $menu)
    <div style="padding: 1rem 1.5rem; border-bottom: 1px solid var(--color-border); transition: background 0.15s;" onmouseover="this.style.background='#f0fdf4'" onmouseout="this.style.background='transparent'">
        <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem;">
            <div style="flex: 1; min-width: 0;">
                <div style="font-size: 0.875rem; font-weight: 600; color: var(--color-text-primary); margin-bottom: 0.25rem;" class="truncate-2">
                    {{ $menu->nama_menu }}
                </div>
                <div style="font-size: 0.75rem; color: var(--color-text-muted); display: flex; gap: 0.75rem; flex-wrap: wrap;">
                    <span>Sekolah: {{ $menu->targetSekolah->nama_entitas }}</span>
                    <span>Kalori: {{ $menu->kalori }} kkal</span>
                    <span>Protein: {{ $menu->protein }}g</span>
                    <span>Porsi: {{ $menu->porsi_rencana }}</span>
                </div>
            </div>
            <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
                @if($menu->status === 'Pending Verification')
                    <span class="badge badge-pending">Pending</span>
                @elseif($menu->status === 'Ready to Cook')
                    <span class="badge badge-approved">Ready to Cook</span>
                @elseif($menu->status === 'Rejected')
                    <span class="badge badge-rejected">Ditolak</span>
                @endif

                @if($menu->status === 'Ready to Cook' && !$menu->pengiriman)
                    <span class="badge badge-approved">Menunggu Produksi</span>
                @elseif($menu->pengiriman)
                    <span class="badge badge-{{ $menu->pengiriman->status_logistik === 'Diterima' ? 'received' : 'transit' }}">
                        {{ $menu->pengiriman->status_logistik }}
                    </span>
                @endif
            </div>
        </div>

        @if($menu->status === 'Rejected' && $menu->catatan_gizi)
            <div style="margin-top: 0.5rem; padding: 0.5rem 0.75rem; background: #fef2f2; border-radius: 0.5rem; border-left: 3px solid #ef4444;">
                <div style="font-size: 0.6875rem; font-weight: 600; color: #991b1b; margin-bottom: 0.125rem;">Catatan Ahli Gizi:</div>
                <div style="font-size: 0.75rem; color: #7f1d1d;">{{ $menu->catatan_gizi }}</div>
            </div>
        @endif

        @if($menu->pengiriman && $menu->pengiriman->dispatched_at)
            <div style="margin-top: 0.5rem; font-size: 0.6875rem; color: var(--color-text-muted);">
                🚚 Kurir: {{ $menu->pengiriman->kurir?->user?->nama_entitas ?? '-' }} · Berangkat: {{ $menu->pengiriman->dispatched_at->format('H:i') }} WIB
                @if($menu->pengiriman->received_at)
                    · Diterima: {{ $menu->pengiriman->received_at->format('H:i') }} WIB
                @endif
            </div>
        @endif
    </div>
@empty
    <div style="padding: 3rem; text-align: center; color: var(--color-text-muted);">
        <p style="margin: 0;">Belum ada menu yang diajukan hari ini.</p>
    </div>
@endforelse
