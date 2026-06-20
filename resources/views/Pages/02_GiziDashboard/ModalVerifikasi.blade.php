@if($showModal && $selectedMenu)
    <x-components.shared.modal show="showModal" title="Verifikasi Menu" maxWidth="560px">
        {{-- Menu Details --}}
        <div style="background: var(--color-surface); border-radius: 0.75rem; padding: 1.25rem; margin-bottom: 1.25rem;">
            <div style="font-size: 0.6875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em; color: var(--color-text-muted); margin-bottom: 0.75rem;">Detail Menu</div>

            <div style="font-size: 0.9375rem; font-weight: 600; color: var(--color-text-primary); margin-bottom: 0.75rem;">
                {{ $selectedMenu->nama_menu }}
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem;">
                <div style="background: white; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--color-border);">
                    <div style="font-size: 0.6875rem; color: var(--color-text-muted);">Kalori</div>
                    <div style="font-size: 1.125rem; font-weight: 700; color: var(--color-primary-600);">{{ $selectedMenu->kalori }} <span style="font-size: 0.75rem; font-weight: 400;">kkal</span></div>
                </div>
                <div style="background: white; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--color-border);">
                    <div style="font-size: 0.6875rem; color: var(--color-text-muted);">Protein</div>
                    <div style="font-size: 1.125rem; font-weight: 700; color: var(--color-primary-600);">{{ $selectedMenu->protein }} <span style="font-size: 0.75rem; font-weight: 400;">gram</span></div>
                </div>
                <div style="background: white; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--color-border);">
                    <div style="font-size: 0.6875rem; color: var(--color-text-muted);">Karbohidrat</div>
                    <div style="font-size: 1.125rem; font-weight: 700; color: #d97706;">{{ $selectedMenu->karbohidrat ?? '-' }} <span style="font-size: 0.75rem; font-weight: 400;">gram</span></div>
                </div>
                <div style="background: white; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--color-border);">
                    <div style="font-size: 0.6875rem; color: var(--color-text-muted);">Lemak</div>
                    <div style="font-size: 1.125rem; font-weight: 700; color: #ef4444;">{{ $selectedMenu->lemak ?? '-' }} <span style="font-size: 0.75rem; font-weight: 400;">gram</span></div>
                </div>
                <div style="background: white; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--color-border);">
                    <div style="font-size: 0.6875rem; color: var(--color-text-muted);">Jumlah Porsi</div>
                    <div style="font-size: 1.125rem; font-weight: 700;">{{ $selectedMenu->porsi_rencana }}</div>
                </div>
                <div style="background: white; padding: 0.75rem; border-radius: 0.5rem; border: 1px solid var(--color-border);">
                    <div style="font-size: 0.6875rem; color: var(--color-text-muted);">Tujuan</div>
                    <div style="font-size: 0.8125rem; font-weight: 600;">{{ $selectedMenu->targetSekolah->nama_entitas }}</div>
                </div>
            </div>

            <div style="margin-top: 0.75rem; font-size: 0.75rem; color: var(--color-text-muted);">
                Katering: <strong>{{ $selectedMenu->dapur->nama_entitas }}</strong> · {{ $selectedMenu->created_at->format('d M Y, H:i') }}
            </div>
        </div>

        {{-- Conditional Rejection Form --}}
        @include('Pages.02_GiziDashboard.FormCatatanReject')

        <x-slot name="footer">
            @if($showRejectInput)
                <x-components.shared.button wire:click="closeModal" variant="secondary">Batal</x-components.shared.button>
                <x-components.shared.button wire:click="reject" variant="danger">
                    Konfirmasi Tolak
                </x-components.shared.button>
            @else
                <x-components.shared.button wire:click="showRejectForm" variant="danger">
                    Reject
                </x-components.shared.button>
                <x-components.shared.button wire:click="approve" variant="primary">
                    Approve
                </x-components.shared.button>
            @endif
        </x-slot>
    </x-components.shared.modal>
@endif
