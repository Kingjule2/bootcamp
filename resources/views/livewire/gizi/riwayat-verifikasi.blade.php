<div>
    <div class="card">
        <div class="card-header">
            <h3 style="font-size: 1.125rem; font-weight: 700; margin: 0;">Riwayat Verifikasi Menu</h3>
        </div>
        <div class="card-body" style="padding: 0;">
            @forelse($riwayat as $action)
                <div style="padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--color-border); transition: background 0.15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                    <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 1rem;">
                        <div style="flex: 1; min-width: 0;">
                            <div style="font-size: 1rem; font-weight: 600; color: var(--color-text-primary); margin-bottom: 0.35rem;" class="truncate-2">
                                {{ $action->nama_menu }}
                            </div>
                            <div style="font-size: 0.8125rem; color: var(--color-text-muted); display: flex; gap: 0.85rem; flex-wrap: wrap;">
                                <span>Dapur: {{ $action->dapur->nama_entitas }}</span>
                                <span>Sekolah: {{ $action->targetSekolah->nama_entitas }}</span>
                                <span>Kalori: {{ $action->kalori }} kkal</span>
                                <span>Protein: {{ $action->protein }}g</span>
                                <span>Porsi: {{ $action->porsi_rencana }}</span>
                            </div>
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 0.5rem;">
                            @if($action->status === 'Ready to Cook')
                                <span class="badge badge-approved" style="font-size: 0.875rem; padding: 0.4rem 0.8rem;">Approved</span>
                            @else
                                <span class="badge badge-rejected" style="font-size: 0.875rem; padding: 0.4rem 0.8rem;">Rejected</span>
                            @endif
                            <div style="font-size: 0.75rem; color: var(--color-text-muted);">
                                {{ $action->updated_at->format('d M Y, H:i') }}
                            </div>
                        </div>
                    </div>
                    
                    @if($action->status === 'Rejected' && $action->catatan_gizi)
                        <div style="margin-top: 1rem; padding: 0.75rem 1rem; background: #fef2f2; border-radius: 0.5rem; border-left: 4px solid #ef4444;">
                            <div style="font-size: 0.75rem; font-weight: 700; color: #991b1b; margin-bottom: 0.25rem;">Catatan Penolakan:</div>
                            <div style="font-size: 0.875rem; color: #7f1d1d;">{{ $action->catatan_gizi }}</div>
                        </div>
                    @endif
                </div>
            @empty
                <div style="padding: 4rem; text-align: center; color: var(--color-text-muted);">
                    <p style="margin: 0; font-size: 1.125rem; font-weight: 500;">Belum ada riwayat verifikasi.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
