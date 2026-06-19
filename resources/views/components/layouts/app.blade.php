<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta name="description" content="FDLY — Sistem Informasi Terpadu Penyaluran Makan Bergizi Gratis">
    <meta name="theme-color" content="#059669">
    <title>{{ $title ?? 'FDLY' }} — Sistem MBG</title>

    {{-- PWA Manifest --}}
    <link rel="manifest" href="/manifest.json">
    <link rel="apple-touch-icon" href="/assets/icons/icon-192.png">

    {{-- Google Font: Inter --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    {{-- Chart.js CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="antialiased" x-data="{ sidebarOpen: false }">

    {{-- Mobile Sidebar Overlay --}}
    <div class="sidebar-overlay" :class="{ active: sidebarOpen }" @click="sidebarOpen = false"></div>

    {{-- Sidebar component --}}
    @include('Components.SidebarNav.sidebar-nav')

    {{-- Main Content --}}
    <div class="main-content">
        {{-- Top Bar --}}
        <header class="topbar">
            <div style="display: flex; align-items: center; gap: 1rem;">
                {{-- Mobile hamburger --}}
                <button
                    class="md:hidden"
                    @click="sidebarOpen = !sidebarOpen"
                    style="background: none; border: none; font-size: 1.5rem; cursor: pointer; padding: 0.25rem; display: none;"
                    id="mobile-menu-btn"
                >
                    ☰
                </button>
                <div>
                    <h1 style="font-size: 1.125rem; font-weight: 700; color: var(--color-text-primary); margin: 0;">
                        {{ $title ?? 'Dashboard' }}
                    </h1>
                    <p style="font-size: 0.75rem; color: var(--color-text-muted); margin: 0;">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </p>
                </div>
            </div>
            <div style="display: flex; align-items: center; gap: 1rem;">
                {{-- Connection & Sync Indicator --}}
                @include('Components.DatabaseStatus.database-status')

                <div style="display: flex; align-items: center; gap: 0.75rem;">
                    <div style="font-size: 0.8125rem; color: var(--color-text-secondary); text-align: right;">
                        <div style="font-weight: 600;">{{ auth()->user()->nama_entitas }}</div>
                        <div style="font-size: 0.6875rem; color: var(--color-text-muted); text-transform: capitalize;">
                            {{ str_replace('_', ' ', auth()->user()->role) }}
                        </div>
                    </div>
                    <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--color-primary-400), var(--color-primary-600)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.8rem;">
                        {{ strtoupper(substr(auth()->user()->username, 0, 2)) }}
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="page-content">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts

    {{-- Mobile menu toggle and PWA sync script --}}
    <script>
        // Show hamburger on mobile
        const menuBtn = document.getElementById('mobile-menu-btn');
        function checkMobile() {
            if (window.innerWidth <= 768) {
                menuBtn.style.display = 'block';
            } else {
                menuBtn.style.display = 'none';
            }
        }
        checkMobile();
        window.addEventListener('resize', checkMobile);

        // Register service worker
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/service-worker.js')
                    .then(reg => console.log('SW registered:', reg.scope))
                    .catch(err => console.warn('SW registration failed:', err));
            });
        }

        // Global offline queue sync listener
        window.addEventListener('trigger-sync', (e) => {
            const deliveries = e.detail;
            console.log('Online detected. Syncing offline data...', deliveries);

            fetch('/sekolah/sync-offline', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ deliveries: deliveries })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    console.log('Offline data synced successfully!');
                    localStorage.removeItem('offline_deliveries');
                    window.dispatchEvent(new CustomEvent('offline-queue-updated'));
                    // Reload to reflect changes
                    window.location.reload();
                } else {
                    console.error('Failed to sync:', data.message);
                }
            })
            .catch(err => console.error('Error during offline sync fetch:', err));
        });
    </script>
</body>
</html>
