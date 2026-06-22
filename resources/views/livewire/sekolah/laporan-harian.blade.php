<div>
    {{-- Header --}}
    <div style="margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;">
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 700; margin: 0 0 0.25rem;">Laporan Harian Kualitas Makanan</h2>
            <p style="font-size: 0.8125rem; color: var(--color-text-muted); margin: 0;">{{ auth()->user()->nama_entitas }}</p>
        </div>
    </div>

    {{-- Laporan List --}}
    <div class="card">
        <div class="card-body" style="padding: 0;">
            @forelse($laporans as $laporan)
                <div style="padding: 1.25rem; border-bottom: 1px solid var(--color-border);">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; margin-bottom: 0.75rem;">
                        <div>
                            <div style="font-size: 0.9375rem; font-weight: 700; color: var(--color-text-primary); margin-bottom: 0.25rem;">
                                {{ $laporan->pengiriman->menu->nama_menu ?? 'Menu Tidak Tersedia' }}
                            </div>
                            <div style="font-size: 0.75rem; color: var(--color-text-muted);">
                                Dari: {{ $laporan->pengiriman->menu->dapur->nama_entitas ?? '-' }} • 
                                {{ $laporan->created_at->translatedFormat('l, d F Y H:i') }}
                            </div>
                        </div>
                        <div style="background: {{ $laporan->rating >= 4 ? '#d1fae5' : ($laporan->rating == 3 ? '#fef3c7' : '#fee2e2') }}; color: {{ $laporan->rating >= 4 ? '#065f46' : ($laporan->rating == 3 ? '#92400e' : '#991b1b') }}; padding: 0.25rem 0.5rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 700; display: flex; align-items: center; gap: 0.25rem;">
                            {{ $laporan->rating }}/5 ⭐
                        </div>
                    </div>

                    <div style="display: flex; gap: 1.5rem; flex-wrap: wrap; font-size: 0.8125rem; margin-bottom: 0.75rem; background: var(--color-surface); padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--color-border);">
                        <div>
                            <span style="color: var(--color-text-muted); display: block; font-size: 0.6875rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.125rem;">Porsi Diterima</span>
                            <span style="font-weight: 600;">{{ $laporan->porsi_diterima }} <span style="font-weight: 400; color: var(--color-text-secondary);">porsi</span></span>
                        </div>
                        <div>
                            <span style="color: var(--color-text-muted); display: block; font-size: 0.6875rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.125rem;">Food Waste</span>
                            <span style="font-weight: 600; color: {{ $laporan->food_waste > 0 ? '#dc2626' : '#16a34a' }};">{{ $laporan->food_waste }}</span>
                        </div>
                    </div>

                    @if($laporan->komentar)
                        <div style="font-size: 0.8125rem; color: var(--color-text-secondary); background: #f8fafc; padding: 0.75rem; border-radius: 0.5rem; border-left: 3px solid var(--color-primary-400); font-style: italic;">
                            "{{ $laporan->komentar }}"
                        </div>
                    @endif
                </div>
            @empty
                <div style="padding: 3rem; text-align: center; color: var(--color-text-muted);">
                    <div style="font-size: 2rem; margin-bottom: 0.5rem;">📊</div>
                    <p style="margin: 0; font-weight: 500;">Belum ada laporan harian.</p>
                    <p style="margin: 0.25rem 0 0; font-size: 0.8125rem;">Laporan akan muncul setelah Anda mengkonfirmasi penerimaan makanan dan mengisi form laporan kualitas.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
