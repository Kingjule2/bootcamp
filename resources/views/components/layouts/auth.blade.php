<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Login ke NutriRoute — Sistem Informasi Terpadu Penyaluran Makan Bergizi Gratis">
    <meta name="theme-color" content="#059669">
    <title>Login — NutriRoute</title>

    <link rel="manifest" href="/manifest.json">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="margin: 0; min-height: 100vh; display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, #059669 0%, #047857 40%, #2C3E50 100%); padding: 1rem;">

    {{-- Decorative shapes --}}
    <div style="position: fixed; top: -15%; right: -10%; width: 500px; height: 500px; border-radius: 50%; background: rgba(255,255,255,0.04); pointer-events: none;"></div>
    <div style="position: fixed; bottom: -20%; left: -10%; width: 600px; height: 600px; border-radius: 50%; background: rgba(255,255,255,0.03); pointer-events: none;"></div>

    {{ $slot }}
</body>
</html>
