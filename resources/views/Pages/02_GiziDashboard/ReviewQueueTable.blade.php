@if($pendingMenus->count() > 0)
    <table class="data-table">
        <thead>
            <tr>
                <th>Katering</th>
                <th>Menu Makanan</th>
                <th>Kalori</th>
                <th>Protein</th>
                <th>Porsi</th>
                <th>Tujuan</th>
                <th>Waktu Masuk</th>
                <th style="text-align: center;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pendingMenus as $menu)
                <tr style="cursor: pointer;" onclick="this.querySelector('button').click()">
                    <td>
                        <div style="font-weight: 600; font-size: 0.8125rem;">{{ $menu->dapur->nama_entitas }}</div>
                    </td>
                    <td>
                        <div class="truncate-2" style="max-width: 200px; font-size: 0.8125rem;">{{ $menu->nama_menu }}</div>
                    </td>
                    <td>
                        <span style="font-weight: 600;">{{ $menu->kalori }}</span>
                        <span style="font-size: 0.6875rem; color: var(--color-text-muted);"> kkal</span>
                    </td>
                    <td>
                        <span style="font-weight: 600;">{{ $menu->protein }}</span>
                        <span style="font-size: 0.6875rem; color: var(--color-text-muted);"> g</span>
                    </td>
                    <td style="font-weight: 600;">{{ $menu->porsi_rencana }}</td>
                    <td style="font-size: 0.8125rem;">{{ $menu->targetSekolah->nama_entitas }}</td>
                    <td style="font-size: 0.75rem; color: var(--color-text-muted);">{{ $menu->created_at->format('H:i') }}</td>
                    <td style="text-align: center;">
                        <x-components.shared.button wire:click="openVerifikasi({{ $menu->id }})" variant="primary" style="font-size: 0.75rem; padding: 0.375rem 0.75rem;">
                            Review
                        </x-components.shared.button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <div style="padding: 3rem; text-align: center; color: var(--color-text-muted);">
        <p style="margin: 0; font-weight: 500;">Semua menu sudah diverifikasi!</p>
        <p style="margin: 0.25rem 0 0; font-size: 0.8125rem;">Tidak ada antrean pending saat ini.</p>
    </div>
@endif
