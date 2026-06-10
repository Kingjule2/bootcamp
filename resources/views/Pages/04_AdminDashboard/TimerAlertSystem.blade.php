@if($stats['overdueCount'] > 0)
    <div class="alert-overdue" style="padding: 1rem 1.5rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 1rem;">
        <span style="font-size: 2rem;">🚨</span>
        <div>
            <div style="font-size: 1rem; font-weight: 700; color: #991b1b;">
                WARNING: {{ $stats['overdueCount'] }} Pengiriman Melebihi Batas Waktu Aman!
            </div>
            <div style="font-size: 0.8125rem; color: #7f1d1d;">
                Potensi makanan basi terdeteksi. Pengiriman > 2 jam tanpa konfirmasi penerimaan.
            </div>
        </div>
    </div>
@endif
