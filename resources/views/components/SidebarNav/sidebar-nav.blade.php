<aside class="sidebar" :class="{ open: sidebarOpen }" id="sidebar-nav">
    {{-- Brand --}}
    <div class="sidebar-brand" style="flex-direction: column; align-items: flex-start; gap: 0.5rem;">
        <img src="/assets/images/logo-fdly.png" alt="FDLY" style="height: 32px; width: auto; filter: brightness(0) invert(1);">
        <div style="font-size: 0.65rem; opacity: 0.6; letter-spacing: 0.05em; color: white; padding-left: 2px;">SISTEM MBG</div>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">
        <div class="sidebar-section-title">Menu Utama</div>

        @if(auth()->user()->isDapur())
            <a href="{{ route('dapur.dashboard') }}" class="sidebar-nav-item {{ request()->routeIs('dapur.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"></span> Input Menu
            </a>
            <a href="{{ route('dapur.produksi') }}" class="sidebar-nav-item {{ request()->routeIs('dapur.produksi') ? 'active' : '' }}">
                <span class="nav-icon"></span> Produksi
            </a>
            <a href="{{ route('dapur.pengiriman') }}" class="sidebar-nav-item {{ request()->routeIs('dapur.pengiriman') ? 'active' : '' }}">
                <span class="nav-icon"></span> Pengiriman
            </a>
        @endif

        @if(auth()->user()->isAhliGizi())
            <a href="{{ route('gizi.dashboard') }}" class="sidebar-nav-item {{ request()->routeIs('gizi.dashboard') ? 'active' : '' }}">
                <span class="nav-icon"></span> Review Antrean
            </a>
            <a href="{{ route('gizi.riwayat') }}" class="sidebar-nav-item {{ request()->routeIs('gizi.riwayat') ? 'active' : '' }}">
                <span class="nav-icon"></span> Riwayat Verifikasi
            </a>
        @endif

        @if(auth()->user()->isSekolah())
            <a href="{{ route('sekolah.dashboard') }}" class="sidebar-nav-item {{ request()->routeIs('sekolah.*') ? 'active' : '' }}">
                <span class="nav-icon"></span> Status Pengiriman
            </a>
            <a href="{{ route('sekolah.dashboard') }}" class="sidebar-nav-item">
                <span class="nav-icon"></span> Laporan Harian
            </a>
        @endif

        @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard', ['tab' => 'monitoring']) }}" class="sidebar-nav-item {{ request()->routeIs('admin.*') && (request('tab') === 'monitoring' || !request('tab')) ? 'active' : '' }}">
                <span class="nav-icon"></span> Monitoring Live
            </a>
            <a href="{{ route('admin.dashboard', ['tab' => 'statistik']) }}" class="sidebar-nav-item {{ request()->routeIs('admin.*') && request('tab') === 'statistik' ? 'active' : '' }}">
                <span class="nav-icon"></span> Statistik
            </a>
            <a href="{{ route('admin.dashboard', ['tab' => 'users']) }}" class="sidebar-nav-item {{ request()->routeIs('admin.*') && request('tab') === 'users' ? 'active' : '' }}">
                <span class="nav-icon"></span> User Management
            </a>
        @endif

        @if(auth()->user()->isKurir())
            <a href="{{ route('kurir.dashboard') }}" class="sidebar-nav-item {{ request()->routeIs('kurir.*') ? 'active' : '' }}">
                <span class="nav-icon"></span> Tugas Pengiriman
            </a>
        @endif
    </nav>

    {{-- Footer with user info --}}
    <div class="sidebar-footer">
        <div style="display: flex; align-items: center; gap: 0.75rem;">
            <div style="width: 36px; height: 36px; border-radius: 50%; background: linear-gradient(135deg, var(--color-primary-400), var(--color-primary-600)); display: flex; align-items: center; justify-content: center; color: white; font-weight: 700; font-size: 0.8rem;">
                {{ strtoupper(substr(auth()->user()->username, 0, 2)) }}
            </div>
            <div style="flex: 1; min-width: 0;">
                <div style="font-size: 0.8125rem; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                    {{ auth()->user()->nama_entitas }}
                </div>
                <div style="font-size: 0.6875rem; opacity: 0.5; text-transform: capitalize;">
                    {{ str_replace('_', ' ', auth()->user()->role) }}
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" title="Keluar" style="background: none; border: 1px solid rgba(255,255,255,0.25); border-radius: 0.375rem; color: rgba(255,255,255,0.75); cursor: pointer; font-size: 0.75rem; padding: 0.25rem 0.5rem; font-weight: 500;" onmouseover="this.style.color='#f87171'; this.style.borderColor='#f87171';" onmouseout="this.style.color='rgba(255,255,255,0.75)'; this.style.borderColor='rgba(255,255,255,0.25)';">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</aside>
