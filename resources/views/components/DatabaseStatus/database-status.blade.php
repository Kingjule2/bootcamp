<div
    x-data="{
        isOnline: navigator.onLine,
        unsyncedCount: 0,
        updateCount() {
            try {
                const pending = JSON.parse(localStorage.getItem('offline_deliveries') || '[]');
                this.unsyncedCount = pending.length;
            } catch (e) {
                this.unsyncedCount = 0;
            }
        },
        syncOfflineData() {
            if (!this.isOnline) return;
            const pending = JSON.parse(localStorage.getItem('offline_deliveries') || '[]');
            if (pending.length === 0) return;

            // Trigger window event that Livewire or global scripts can listen to
            window.dispatchEvent(new CustomEvent('trigger-sync', { detail: pending }));
        }
    }"
    x-init="
        updateCount();
        window.addEventListener('online', () => { isOnline = true; syncOfflineData(); });
        window.addEventListener('offline', () => { isOnline = false; });
        window.addEventListener('offline-queue-updated', () => { updateCount(); });
        // Periodically check queue size
        setInterval(() => updateCount(), 2000);
        // Attempt initial sync on load
        setTimeout(() => syncOfflineData(), 1500);
    "
    style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.375rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; border: 1px solid var(--color-border); background: var(--color-surface);"
>
    <!-- Dot indicator -->
    <span
        style="width: 8px; height: 8px; border-radius: 50%; display: inline-block; transition: background 0.3s;"
        :style="isOnline ? (unsyncedCount > 0 ? 'background: var(--color-warning-500); animation: pulse-badge 1.5s infinite;' : 'background: var(--color-success-500);') : 'background: var(--color-warning-500); animation: pulse-badge 1.5s infinite;'"
    ></span>

    <!-- Text status -->
    <span style="color: var(--color-text-secondary);">
        <template x-if="isOnline">
            <template x-if="unsyncedCount > 0">
                <span x-text="'Sinkronisasi (' + unsyncedCount + ' data)...'"></span>
            </template>
            <template x-if="unsyncedCount === 0">
                <span>Terhubung</span>
            </template>
        </template>
        <template x-if="!isOnline">
            <span x-text="'Offline (Lokal: ' + unsyncedCount + ' data)'"></span>
        </template>
    </span>
</div>
