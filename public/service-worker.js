const CACHE_NAME = 'nutriroute-cache-v1';
const ASSETS_TO_CACHE = [
    '/login',
    '/offline-fallback',
    '/assets/icons/icon-192.png',
    '/assets/icons/icon-512.png'
];

// Install: Cache core assets
self.addEventListener('install', (event) => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then((cache) => cache.addAll(ASSETS_TO_CACHE))
            .then(() => self.skipWaiting())
    );
});

// Activate: Clean old caches
self.addEventListener('activate', (event) => {
    event.waitUntil(
        caches.keys().then((cacheNames) => {
            return Promise.all(
                cacheNames
                    .filter((name) => name !== CACHE_NAME)
                    .map((name) => caches.delete(name))
            );
        }).then(() => self.clients.claim())
    );
});

// Fetch: Network-first with cache fallback
self.addEventListener('fetch', (event) => {
    // Skip non-GET requests
    if (event.request.method !== 'GET') return;

    // Skip Chrome extensions and livewire requests
    if (event.request.url.includes('chrome-extension') ||
        event.request.url.includes('livewire')) return;

    event.respondWith(
        fetch(event.request)
            .then((response) => {
                // Clone the response and cache it
                const responseClone = response.clone();
                caches.open(CACHE_NAME).then((cache) => {
                    cache.put(event.request, responseClone);
                });
                return response;
            })
            .catch(() => {
                // Try cache first, then offline fallback
                return caches.match(event.request).then((cachedResponse) => {
                    if (cachedResponse) return cachedResponse;

                    // If HTML request, show offline page
                    if (event.request.headers.get('accept')?.includes('text/html')) {
                        return caches.match('/offline-fallback');
                    }
                });
            })
    );
});
