<div wire:poll.5s>
    {{-- Flash Message --}}
    @if(session('success'))
        <div style="background: #d1fae5; border: 1px solid #a7f3d0; border-radius: 0.75rem; padding: 0.875rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.5rem; animation: slideIn 0.3s ease;">
            <span style="font-size: 0.875rem; color: #065f46; font-weight: 500;">{{ session('success') }}</span>
        </div>
    @endif

    {{-- Header --}}
    <div style="margin-bottom: 1.5rem;">
        <h2 style="font-size: 1.25rem; font-weight: 700; margin: 0 0 0.25rem;">📍 Status Pengiriman Hari Ini</h2>
        <p style="font-size: 0.8125rem; color: var(--color-text-muted); margin: 0;">{{ auth()->user()->nama_entitas }}</p>
    </div>

    {{-- Delivery Cards --}}
    @forelse($pengiriman as $p)
        <div class="card" style="margin-bottom: 1.25rem; overflow: hidden;">
            {{-- Card Header with Menu Info --}}
            <div style="padding: 1rem 1.25rem; background: linear-gradient(135deg, var(--color-primary-50), white); border-bottom: 1px solid var(--color-border);">
                <div style="display: flex; align-items: flex-start; justify-content: space-between; gap: 0.75rem;">
                    <div style="flex: 1; min-width: 0;">
                        <div style="font-size: 0.9375rem; font-weight: 700; color: var(--color-text-primary); margin-bottom: 0.25rem;">
                            {{ $p->menu->nama_menu }}
                        </div>
                        <div style="font-size: 0.75rem; color: var(--color-text-muted); display: flex; gap: 0.75rem; flex-wrap: wrap;">
                            <span>🏭 {{ $p->menu->dapur->nama_entitas }}</span>
                            <span>📦 {{ $p->menu->porsi_rencana }} porsi</span>
                        </div>
                    </div>
                    @if($p->status_logistik === 'Sedang Dimasak')
                        <span class="badge badge-cooking">🍳 Dimasak</span>
                    @elseif($p->status_logistik === 'Dalam Perjalanan')
                        <span class="badge badge-transit">🚚 Dalam Perjalanan</span>
                    @else
                        <span class="badge badge-received">✅ Diterima</span>
                    @endif
                </div>
            </div>

            {{-- Timeline Tracker --}}
            <div style="padding: 1.25rem;">
                @include('Pages.03_SekolahDashboard.LiveStatusTracker')
            </div>

            {{-- Confirmation Button (for "Dalam Perjalanan" status) --}}
            @if($p->status_logistik === 'Dalam Perjalanan')
                <div style="padding: 0 1.25rem 1.25rem;">
                    @include('Pages.03_SekolahDashboard.FormKonfirmasiPenerimaan')
                </div>
            @endif

            {{-- Quality Report Form (shows after confirmation) --}}
            @if($showLaporanForm && $selectedPengirimanId === $p->id_pengiriman)
                <div style="padding: 0 1.25rem 1.25rem; animation: slideIn 0.3s ease;">
                    @include('Pages.03_SekolahDashboard.FoodWasteReport')
                </div>
            @endif

            {{-- Quality Report Button (for "Diterima" status but no report yet) --}}
            @if($p->status_logistik === 'Diterima' && !$p->laporanSekolah)
                @if(!($showLaporanForm && $selectedPengirimanId === $p->id_pengiriman))
                    <div style="padding: 0 1.25rem 1.25rem;">
                        <button wire:click="$set('selectedPengirimanId', {{ $p->id_pengiriman }}); $set('showLaporanForm', true); $set('porsi_diterima', {{ $p->menu->porsi_rencana }});" class="btn" style="background: var(--color-primary-600); color: white; border: none; padding: 0.5rem 1rem; border-radius: 0.5rem; font-weight: 600; font-size: 0.875rem; cursor: pointer; display: flex; align-items: center; gap: 0.35rem; width: 100%; justify-content: center; transition: background 0.2s;" onmouseover="this.style.background='var(--color-primary-700)'" onmouseout="this.style.background='var(--color-primary-600)'">
                            📝 Isi Laporan Kualitas Makanan
                        </button>
                    </div>
                @endif
            @endif

            {{-- Existing Report Display --}}
            @if($p->laporanSekolah && !($showLaporanForm && $selectedPengirimanId === $p->id_pengiriman))
                <div style="padding: 0 1.25rem 1.25rem;">
                    <div style="background: var(--color-surface); border-radius: 0.75rem; padding: 1rem; border: 1px solid var(--color-border);">
                        <div style="font-size: 0.6875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-text-muted); margin-bottom: 0.5rem;">📊 Laporan Kualitas</div>
                        <div style="display: flex; gap: 1.25rem; flex-wrap: wrap; font-size: 0.8125rem;">
                            <span>📦 {{ $p->laporanSekolah->porsi_diterima }} porsi diterima</span>
                            <span>🗑️ {{ $p->laporanSekolah->food_waste }} sisa</span>
                            <span>⭐ {{ $p->laporanSekolah->rating }}/5</span>
                        </div>
                        @if($p->laporanSekolah->komentar)
                            <div style="margin-top: 0.5rem; font-size: 0.8125rem; color: var(--color-text-secondary); font-style: italic;">
                                "{{ $p->laporanSekolah->komentar }}"
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    @empty
        <div class="card" style="padding: 3rem; text-align: center;">
            <div style="font-size: 2.5rem; margin-bottom: 0.75rem;">📍</div>
            <p style="font-size: 0.9375rem; font-weight: 600; color: var(--color-text-primary); margin: 0;">Belum Ada Pengiriman</p>
            <p style="font-size: 0.8125rem; color: var(--color-text-muted); margin: 0.25rem 0 0;">Pengiriman akan muncul setelah dapur mengirim makanan ke sekolah Anda.</p>
        </div>
    @endforelse
</div>
