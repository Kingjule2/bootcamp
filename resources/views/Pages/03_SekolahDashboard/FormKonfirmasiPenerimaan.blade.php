<div 
    x-data="{
        isOnline: navigator.onLine,
        isLocallyReceived: false,
        init() {
            window.addEventListener('online', () => this.isOnline = true);
            window.addEventListener('offline', () => this.isOnline = false);
            // Check if this delivery was already received offline
            const pending = JSON.parse(localStorage.getItem('offline_deliveries') || '[]');
            if (pending.some(item => item.pengiriman_id === {{ $p->id }} && item.status_logistik === 'Diterima')) {
                this.isLocallyReceived = true;
            }
        },
        handleConfirm() {
            if (this.isOnline) {
                // Call Livewire directly
                @this.call('konfirmasiDiterima', {{ $p->id }});
            } else {
                // Offline fallback
                const pending = JSON.parse(localStorage.getItem('offline_deliveries') || '[]');
                
                // Add to queue if not already there
                if (!pending.some(item => item.pengiriman_id === {{ $p->id }} && item.status_logistik === 'Diterima')) {
                    pending.push({
                        pengiriman_id: {{ $p->id }},
                        status_logistik: 'Diterima',
                        received_at: new Date().toISOString(),
                        device_info: navigator.userAgent
                    });
                    localStorage.setItem('offline_deliveries', JSON.stringify(pending));
                }
                
                this.isLocallyReceived = true;
                
                // Trigger event to update status badge
                window.dispatchEvent(new CustomEvent('offline-queue-updated'));
                
                // Alert the user
                alert('Penerimaan disimpan secara lokal (Offline). Data akan disinkronisasikan otomatis saat koneksi kembali.');
                
                // Refresh
                window.location.reload();
            }
        }
    }"
>
    <template x-if="!isLocallyReceived">
        <x-components.shared.button 
            type="button" 
            variant="primary" 
            size="lg" 
            style="width: 100%;" 
            @click="handleConfirm()"
        >
            Konfirmasi Makanan Diterima
        </x-components.shared.button>
    </template>
    
    <template x-if="isLocallyReceived">
        <div style="background: #fffbeb; border: 1px solid #fde68a; border-radius: 0.75rem; padding: 1rem; margin-top: 0.75rem; text-align: center;">
            <div style="font-size: 0.8125rem; font-weight: 700; color: #92400e;">Penerimaan Terekam (Offline)</div>
            <div style="font-size: 0.75rem; color: #b45309;">Menunggu jaringan internet untuk sinkronisasi.</div>
        </div>
    </template>
</div>
