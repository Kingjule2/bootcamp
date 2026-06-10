<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#059669">
    <title>Offline — NutriRoute</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', system-ui, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #059669 0%, #047857 40%, #2C3E50 100%);
            color: white;
            text-align: center;
            padding: 2rem;
        }
        .container {
            max-width: 400px;
        }
        .icon {
            font-size: 4rem;
            margin-bottom: 1.5rem;
            animation: pulse 2s ease-in-out infinite;
        }
        h1 { font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem; }
        p { font-size: 0.9rem; opacity: 0.8; line-height: 1.5; margin-bottom: 1.5rem; }
        .retry-btn {
            display: inline-block;
            padding: 0.75rem 2rem;
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 0.75rem;
            color: white;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
        }
        .retry-btn:hover { background: rgba(255,255,255,0.3); }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="icon">📡</div>
        <h1>Tidak Ada Koneksi Internet</h1>
        <p>
            NutriRoute membutuhkan koneksi internet untuk menyinkronkan data pengiriman.
            Silakan periksa koneksi Anda dan coba lagi.
        </p>
        <a href="/" class="retry-btn" onclick="window.location.reload(); return false;">
            🔄 Coba Lagi
        </a>
    </div>
</body>
</html>
