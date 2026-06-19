<div 
    x-data="{
        isOnline: navigator.onLine,
        isLocallyReported: false,
        rating: @entangle('rating'),
        porsi_diterima: @entangle('porsi_diterima'),
        food_waste: @entangle('food_waste'),
        komentar: @entangle('komentar'),
        init() {
            window.addEventListener('online', () => this.isOnline = true);
            window.addEventListener('offline', () => this.isOnline = false);
            // Check if this report was already submitted offline
            const pending = JSON.parse(localStorage.getItem('offline_deliveries') || '[]');
            if (pending.some(item => item.pengiriman_id === {{ $p->id }} && item.type === 'report')) {
                this.isLocallyReported = true;
            }
        },
        submitReport() {
            if (this.isOnline) {
                @this.call('submitLaporan');
            } else {
                // Validate locally
                if (this.porsi_diterima === null || this.porsi_diterima === '') {
                    alert('Porsi diterima harus diisi.');
                    return;
                }
                if (!this.rating || this.rating < 1 || this.rating > 5) {
                    alert('Silakan beri rating minimal 1 bintang.');
                    return;
                }

                const pending = JSON.parse(localStorage.getItem('offline_deliveries') || '[]');
                
                // Add to queue if not already reported
                if (!pending.some(item => item.pengiriman_id === {{ $p->id }} && item.type === 'report')) {
                    pending.push({
                        pengiriman_id: {{ $p->id }},
                        type: 'report',
                        porsi_diterima: parseInt(this.porsi_diterima),
                        food_waste: parseInt(this.food_waste || 0),
                        rating: parseInt(this.rating),
                        komentar: this.komentar
                    });
                    localStorage.setItem('offline_deliveries', JSON.stringify(pending));
                }
                
                this.isLocallyReported = true;
                
                // Trigger event to update status badge
                window.dispatchEvent(new CustomEvent('offline-queue-updated'));
                
                // Alert the user
                alert('Laporan kualitas disimpan secara lokal (Offline). Data akan disinkronisasikan otomatis saat koneksi kembali.');
                
                // Refresh
                window.location.reload();
            }
        }
    }"
>
    <template x-if="isLocallyReported">
        <div style="background: #e0f2fe; border: 1px solid #bae6fd; border-radius: 0.75rem; padding: 1rem; text-align: center;">
            <div style="font-size: 0.8125rem; font-weight: 700; color: #0369a1;">Laporan Kualitas Tersimpan (Offline)</div>
            <div style="font-size: 0.75rem; color: #0284c7;">Akan terkirim otomatis saat online.</div>
        </div>
    </template>
    
    <template x-if="!isLocallyReported">
        <div style="background: #f0fdf4; border: 1px solid #a7f3d0; border-radius: 0.75rem; padding: 1.25rem;">
            <h4 style="font-size: 0.9375rem; font-weight: 700; margin: 0 0 1rem; color: var(--color-primary-700);">Laporan Kualitas Makanan</h4>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                <div class="form-group">
                    <label class="form-label">Porsi Diterima</label>
                    <input type="number" x-model="porsi_diterima" class="form-input" min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Sisa Makanan (porsi)</label>
                    <input type="number" x-model="food_waste" class="form-input" min="0" placeholder="0">
                </div>
            </div>

            {{-- Star Rating --}}
            <div class="form-group">
                <label class="form-label">Rating Kepuasan</label>
                <div style="display: flex; gap: 0.375rem;">
                    <template x-for="i in 5">
                        <button
                            type="button"
                            @click="rating = i"
                            style="background: none; border: none; font-size: 2rem; cursor: pointer; padding: 0.25rem; transition: transform 0.15s; color: #f59e0b;"
                            :style="rating >= i ? 'opacity: 1;' : 'opacity: 0.3;'"
                            onmouseover="this.style.transform='scale(1.2)'"
                            onmouseout="this.style.transform='scale(1)'"
                        >
                            ★
                        </button>
                    </template>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Komentar (opsional)</label>
                <textarea x-model="komentar" class="form-input" rows="2" placeholder="Contoh: Makanan segar dan enak..." style="resize: vertical;"></textarea>
            </div>

            <x-components.shared.button type="button" variant="primary" style="width: 100%;" @click="submitReport()">
                Kirim Laporan
            </x-components.shared.button>
        </div>
    </template>
</div>
