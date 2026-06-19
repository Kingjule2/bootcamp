<div class="timeline">
    {{-- Step 1: Sedang Dimasak --}}
    <div class="timeline-step">
        <div class="timeline-dot {{ in_array($p->status_logistik, ['Sedang Dimasak', 'Dalam Perjalanan', 'Diterima']) ? 'completed' : '' }}">
            1
        </div>
        <div class="timeline-label {{ $p->status_logistik === 'Sedang Dimasak' ? 'active' : '' }}">
            Sedang Dimasak
        </div>
    </div>

    {{-- Step 2: Dalam Perjalanan --}}
    <div class="timeline-step">
        <div class="timeline-dot {{ in_array($p->status_logistik, ['Dalam Perjalanan', 'Diterima']) ? 'completed' : '' }} {{ $p->status_logistik === 'Dalam Perjalanan' ? 'active' : '' }}">
            2
        </div>
        <div class="timeline-label {{ $p->status_logistik === 'Dalam Perjalanan' ? 'active' : '' }}">
            Dalam Perjalanan
        </div>
    </div>

    {{-- Step 3: Diterima --}}
    <div class="timeline-step">
        <div class="timeline-dot {{ $p->status_logistik === 'Diterima' ? 'completed' : '' }}">
            @if($p->status_logistik === 'Diterima')
                ✓
            @else
                3
            @endif
        </div>
        <div class="timeline-label {{ $p->status_logistik === 'Diterima' ? 'active' : '' }}">
            Diterima
        </div>
    </div>
</div>

{{-- Delivery Info --}}
@if($p->dispatched_at)
    <div style="background: var(--color-surface); border-radius: 0.75rem; padding: 0.875rem 1rem; margin-top: 0.75rem; display: flex; align-items: center; gap: 0.75rem;">
        <div>
            <div style="font-size: 0.8125rem; font-weight: 600;">Kurir: {{ $p->nama_kurir }}</div>
            <div style="font-size: 0.75rem; color: var(--color-text-muted);">
                Jam Berangkat: {{ $p->dispatched_at->format('H:i') }} WIB
                @if($p->received_at)
                    · Diterima: {{ $p->received_at->format('H:i') }} WIB
                    · Durasi: {{ $p->getDeliveryDurationMinutes() }} menit
                @endif
            </div>
        </div>
    </div>
@endif

{{-- Overdue Warning --}}
@if($p->isOverdue())
    <div class="alert-overdue" style="padding: 0.875rem 1rem; margin-top: 0.75rem; display: flex; align-items: center; gap: 0.75rem;">
        <div>
            <div style="font-size: 0.875rem; font-weight: 700; color: #991b1b;">PERINGATAN: Potensi Makanan Basi</div>
            <div style="font-size: 0.75rem; color: #7f1d1d;">Pengiriman sudah > 2 jam tanpa konfirmasi penerimaan.</div>
        </div>
    </div>
@endif
