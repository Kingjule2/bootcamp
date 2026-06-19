<x-layouts.auth>
    <div style="width: 100%; max-width: 420px; animation: slideUp 0.5s ease;">
        {{-- Logo & Branding --}}
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="display: inline-flex; align-items: center; justify-content: center; width: 72px; height: 72px; border-radius: 1.25rem; background: rgba(255,255,255,0.15); backdrop-filter: blur(10px); margin-bottom: 1rem; font-size: 2rem; box-shadow: 0 8px 32px rgba(0,0,0,0.1);">
                🍱
            </div>
            <h1 style="font-size: 1.75rem; font-weight: 800; color: white; margin: 0; letter-spacing: -0.03em;">
                NutriRoute
            </h1>
            <p style="font-size: 0.875rem; color: rgba(255,255,255,0.7); margin: 0.25rem 0 0;">
                Sistem Informasi Terpadu MBG
            </p>
        </div>

        {{-- Login Card --}}
        <div style="background: rgba(255,255,255,0.95); backdrop-filter: blur(20px); border-radius: 1.5rem; padding: 2rem; box-shadow: 0 20px 60px -12px rgba(0,0,0,0.25); border: 1px solid rgba(255,255,255,0.2);">
            <h2 style="font-size: 1.25rem; font-weight: 700; color: var(--color-text-primary); margin: 0 0 0.25rem;">
                Masuk ke Akun
            </h2>
            <p style="font-size: 0.8125rem; color: var(--color-text-muted); margin: 0 0 1.5rem;">
                Gunakan kredensial yang diberikan oleh administrator.
            </p>

            @if($errors->any())
                <div style="background: #fee2e2; border: 1px solid #fecaca; border-radius: 0.75rem; padding: 0.75rem 1rem; margin-bottom: 1.25rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span>⚠️</span>
                    <span style="font-size: 0.8125rem; color: #991b1b;">{{ $errors->first() }}</span>
                </div>
            @endif

            <form method="POST" action="/login" id="login-form">
                @csrf

                <div class="form-group">
                    <label for="username" class="form-label">Username atau Email</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        class="form-input"
                        placeholder="Masukkan username atau email..."
                        value="{{ old('username') }}"
                        required
                        autofocus
                        autocomplete="username"
                    >
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        class="form-input"
                        placeholder="Masukkan password..."
                        required
                        autocomplete="current-password"
                    >
                </div>

                <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 1.5rem;">
                    <input type="checkbox" name="remember" id="remember" style="accent-color: var(--color-primary-500); width: 16px; height: 16px; cursor: pointer;">
                    <label for="remember" style="font-size: 0.8125rem; color: var(--color-text-secondary); cursor: pointer;">
                        Ingat saya di perangkat ini
                    </label>
                </div>

                <button type="submit" class="btn btn-primary btn-lg" style="width: 100%;" id="login-btn">
                    🔐 Masuk ke Dashboard
                </button>
            </form>
        </div>

        {{-- Footer info --}}
        <div style="text-align: center; margin-top: 1.5rem;">
            <p style="font-size: 0.75rem; color: rgba(255,255,255,0.5);">
                SDG 2: Zero Hunger · SDG 3: Good Health<br>
                Program Makan Bergizi Gratis © {{ date('Y') }}
            </p>
        </div>
    </div>
</x-layouts.auth>
