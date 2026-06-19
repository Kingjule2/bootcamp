<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="FDLY — Sistem Informasi Terpadu Penyaluran Makan Bergizi Gratis untuk Program MBG Indonesia. Transparansi, efisiensi, dan akuntabilitas distribusi pangan.">
    <meta name="theme-color" content="#059669">
    <title>FDLY — Sistem Informasi Terpadu MBG</title>

    <link rel="manifest" href="/manifest.json">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ═══ Landing Page Specific Styles ═══ */
        :root {
            --landing-primary: #059669;
            --landing-primary-light: #10b981;
            --landing-primary-dark: #047857;
            --landing-secondary: #2C3E50;
            --landing-secondary-dark: #0f172a;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body.landing-body {
            font-family: 'Inter', ui-sans-serif, system-ui, sans-serif;
            color: #0f172a;
            overflow-x: hidden;
            background: #F8FAFC;
        }

        /* ═══ Navbar ═══ */
        .landing-nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            padding: 1rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px) saturate(180%);
            -webkit-backdrop-filter: blur(20px) saturate(180%);
            box-shadow: 0 1px 3px rgba(0,0,0,0.06), 0 6px 16px rgba(0,0,0,0.04);
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .landing-nav.scrolled {
            padding: 0.75rem 2rem;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }

        .nav-brand {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            text-decoration: none;
        }

        .nav-brand-icon {
            width: 42px;
            height: 42px;
            border-radius: 0.75rem;
            background: linear-gradient(135deg, #34d399, #059669);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.3);
            transition: transform 0.3s ease;
        }

        .nav-brand:hover .nav-brand-icon {
            transform: scale(1.05) rotate(-3deg);
        }

        .nav-brand-text {
            font-size: 1.25rem;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.03em;
            transition: color 0.35s ease;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 600;
            color: #475569;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
        }

        .nav-links a:hover {
            color: #059669;
            background: #ecfdf5;
        }

        .nav-login-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.5rem !important;
            font-weight: 600 !important;
            border-radius: 0.75rem !important;
            background: linear-gradient(135deg, #10b981, #059669) !important;
            border: 1px solid #059669 !important;
            color: white !important;
            box-shadow: 0 4px 14px -3px rgba(5, 150, 105, 0.4);
            transition: all 0.25s ease !important;
        }

        .nav-login-btn:hover {
            background: linear-gradient(135deg, #34d399, #10b981) !important;
            box-shadow: 0 6px 20px -3px rgba(5, 150, 105, 0.5);
            transform: translateY(-1px);
        }

        /* ═══ Hero Section ═══ */
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, #059669 0%, #047857 35%, #2C3E50 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            padding: 6rem 2rem 4rem;
        }

        /* Animated background shapes */
        .hero-shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,0.04);
            pointer-events: none;
        }

        .hero-shape-1 {
            width: 600px; height: 600px;
            top: -15%; right: -10%;
            animation: floatShape 20s ease-in-out infinite;
        }

        .hero-shape-2 {
            width: 400px; height: 400px;
            bottom: -10%; left: -5%;
            animation: floatShape 15s ease-in-out infinite reverse;
        }

        .hero-shape-3 {
            width: 200px; height: 200px;
            top: 40%; left: 15%;
            background: rgba(52, 211, 153, 0.08);
            animation: floatShape 12s ease-in-out infinite 3s;
        }

        .hero-grid {
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.03) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse at center, black 30%, transparent 70%);
            -webkit-mask-image: radial-gradient(ellipse at center, black 30%, transparent 70%);
        }

        @keyframes floatShape {
            0%, 100% { transform: translate(0, 0) scale(1); }
            25% { transform: translate(20px, -30px) scale(1.02); }
            50% { transform: translate(-10px, 20px) scale(0.98); }
            75% { transform: translate(15px, 10px) scale(1.01); }
        }

        .hero-content {
            max-width: 1200px;
            width: 100%;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .hero-text {
            animation: heroFadeIn 0.8s ease-out;
        }

        @keyframes heroFadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.375rem 1rem;
            border-radius: 9999px;
            background: rgba(255,255,255,0.12);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.15);
            font-size: 0.8125rem;
            font-weight: 600;
            color: #a7f3d0;
            margin-bottom: 1.5rem;
            letter-spacing: 0.02em;
        }

        .hero-badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #34d399;
            animation: pulse-dot 2s ease-in-out infinite;
        }

        @keyframes pulse-dot {
            0%, 100% { opacity: 1; box-shadow: 0 0 0 0 rgba(52, 211, 153, 0.4); }
            50% { opacity: 0.8; box-shadow: 0 0 0 6px rgba(52, 211, 153, 0); }
        }

        .hero-title {
            font-size: clamp(2.25rem, 5vw, 3.5rem);
            font-weight: 900;
            color: white;
            line-height: 1.1;
            letter-spacing: -0.04em;
            margin-bottom: 1.25rem;
        }

        .hero-title-highlight {
            background: linear-gradient(135deg, #a7f3d0, #34d399);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.125rem;
            color: rgba(255,255,255,0.75);
            line-height: 1.7;
            margin-bottom: 2.5rem;
            max-width: 480px;
        }

        .hero-actions {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            font-size: 1rem;
            font-weight: 700;
            color: #059669;
            background: white;
            border: none;
            border-radius: 1rem;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hero-btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.2);
        }

        .hero-btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            font-size: 1rem;
            font-weight: 600;
            color: white;
            background: rgba(255,255,255,0.1);
            border: 1.5px solid rgba(255,255,255,0.25);
            border-radius: 1rem;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .hero-btn-secondary:hover {
            background: rgba(255,255,255,0.2);
            border-color: rgba(255,255,255,0.4);
            transform: translateY(-2px);
        }

        /* Hero Visual */
        .hero-visual {
            display: flex;
            justify-content: center;
            animation: heroFadeIn 0.8s ease-out 0.3s both;
        }

        .hero-dashboard-preview {
            background: rgba(255,255,255,0.08);
            backdrop-filter: blur(20px);
            border-radius: 1.5rem;
            border: 1px solid rgba(255,255,255,0.12);
            padding: 2rem;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.2);
        }

        .preview-header {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .preview-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .preview-dot-red { background: #ef4444; }
        .preview-dot-yellow { background: #f59e0b; }
        .preview-dot-green { background: #10b981; }

        .preview-stat-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .preview-stat {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.08);
            border-radius: 1rem;
            padding: 1.25rem;
            text-align: center;
        }

        .preview-stat-value {
            font-size: 1.75rem;
            font-weight: 800;
            color: white;
            line-height: 1;
        }

        .preview-stat-label {
            font-size: 0.75rem;
            color: rgba(255,255,255,0.5);
            margin-top: 0.375rem;
        }

        .preview-bar-chart {
            display: flex;
            align-items: flex-end;
            gap: 0.5rem;
            height: 80px;
        }

        .preview-bar {
            flex: 1;
            border-radius: 0.375rem 0.375rem 0 0;
            background: linear-gradient(to top, rgba(16, 185, 129, 0.3), rgba(16, 185, 129, 0.7));
            animation: barGrow 1.5s ease-out 0.8s both;
            transform-origin: bottom;
        }

        @keyframes barGrow {
            from { transform: scaleY(0); }
            to { transform: scaleY(1); }
        }

        /* ═══ Stats Ticker ═══ */
        .stats-ticker {
            background: white;
            border-bottom: 1px solid #e2e8f0;
            padding: 2rem 0;
        }

        .stats-ticker-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
        }

        .ticker-item {
            text-align: center;
        }

        .ticker-value {
            font-size: 2rem;
            font-weight: 800;
            color: #059669;
            letter-spacing: -0.03em;
        }

        .ticker-label {
            font-size: 0.8125rem;
            color: #94a3b8;
            margin-top: 0.25rem;
        }

        /* ═══ Features Section ═══ */
        .section {
            padding: 6rem 2rem;
        }

        .section-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.8125rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #059669;
            margin-bottom: 1rem;
        }

        .section-eyebrow-line {
            width: 24px;
            height: 2px;
            background: #059669;
            border-radius: 1px;
        }

        .section-title {
            font-size: clamp(1.75rem, 3.5vw, 2.5rem);
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.03em;
            margin-bottom: 1rem;
        }

        .section-description {
            font-size: 1.0625rem;
            color: #64748b;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }

        .feature-card {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 1.25rem;
            padding: 2rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #34d399, #059669);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px -8px rgba(0,0,0,0.1);
            border-color: #a7f3d0;
        }

        .feature-card:hover::before {
            opacity: 1;
        }

        .feature-icon {
            width: 56px;
            height: 56px;
            border-radius: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .feature-icon-green {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            color: #059669;
        }

        .feature-icon-blue {
            background: linear-gradient(135deg, #e0f2fe, #bae6fd);
            color: #0284c7;
        }

        .feature-icon-amber {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            color: #d97706;
        }

        .feature-icon-purple {
            background: linear-gradient(135deg, #f3e8ff, #e9d5ff);
            color: #7c3aed;
        }

        .feature-icon-rose {
            background: linear-gradient(135deg, #ffe4e6, #fecdd3);
            color: #e11d48;
        }

        .feature-icon-teal {
            background: linear-gradient(135deg, #ccfbf1, #99f6e4);
            color: #0d9488;
        }

        .feature-title {
            font-size: 1.0625rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .feature-desc {
            font-size: 0.875rem;
            color: #64748b;
            line-height: 1.6;
        }

        /* ═══ How It Works ═══ */
        .how-section {
            background: linear-gradient(180deg, #f0fdf4 0%, #F8FAFC 100%);
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            position: relative;
        }

        .steps-grid::before {
            content: '';
            position: absolute;
            top: 40px;
            left: 12.5%;
            right: 12.5%;
            height: 3px;
            background: linear-gradient(90deg, #d1fae5, #059669, #d1fae5);
            border-radius: 2px;
        }

        .step-card {
            text-align: center;
            position: relative;
        }

        .step-number {
            width: 56px;
            height: 56px;
            border-radius: 50%;
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            font-weight: 800;
            margin: 0 auto 1.25rem;
            box-shadow: 0 4px 14px rgba(5,150,105,0.3);
            position: relative;
            z-index: 1;
        }

        .step-title {
            font-size: 1rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 0.5rem;
        }

        .step-desc {
            font-size: 0.8125rem;
            color: #64748b;
            line-height: 1.6;
        }

        /* ═══ SDG Section ═══ */
        .sdg-section {
            background: linear-gradient(135deg, #2C3E50 0%, #0f172a 100%);
            color: white;
        }

        .sdg-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
            align-items: center;
        }

        .sdg-text h3 {
            font-size: 1.75rem;
            font-weight: 800;
            margin-bottom: 1.25rem;
            letter-spacing: -0.03em;
        }

        .sdg-text p {
            font-size: 1rem;
            color: rgba(255,255,255,0.7);
            line-height: 1.8;
        }

        .sdg-cards {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1.25rem;
        }

        .sdg-card {
            background: rgba(255,255,255,0.06);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 1.25rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
        }

        .sdg-card:hover {
            background: rgba(255,255,255,0.1);
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0,0,0,0.3);
        }

        .sdg-card-icon {
            font-size: 2rem;
            margin-bottom: 0.75rem;
        }

        .sdg-card-title {
            font-size: 0.9375rem;
            font-weight: 700;
            margin-bottom: 0.375rem;
        }

        .sdg-card-desc {
            font-size: 0.8125rem;
            color: rgba(255,255,255,0.5);
            line-height: 1.5;
        }

        /* ═══ CTA Section ═══ */
        .cta-section {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            text-align: center;
            padding: 5rem 2rem;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: rgba(255,255,255,0.05);
            pointer-events: none;
        }

        .cta-title {
            font-size: clamp(1.5rem, 3vw, 2rem);
            font-weight: 800;
            color: white;
            margin-bottom: 1rem;
            letter-spacing: -0.03em;
        }

        .cta-desc {
            font-size: 1rem;
            color: rgba(255,255,255,0.8);
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .cta-btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 1rem 2.5rem;
            font-size: 1.0625rem;
            font-weight: 700;
            color: #059669;
            background: white;
            border: none;
            border-radius: 1rem;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 8px 30px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .cta-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 14px 40px rgba(0,0,0,0.2);
        }

        /* ═══ Footer ═══ */
        .landing-footer {
            background: #0f172a;
            color: rgba(255,255,255,0.6);
            padding: 3rem 2rem 2rem;
        }

        .footer-inner {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .footer-brand {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .footer-brand-icon {
            width: 32px;
            height: 32px;
            border-radius: 0.5rem;
            background: linear-gradient(135deg, #34d399, #059669);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.875rem;
        }

        .footer-brand-text {
            font-size: 1rem;
            font-weight: 700;
            color: white;
        }

        .footer-text {
            font-size: 0.8125rem;
            text-align: center;
        }

        .footer-sdg {
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* ═══ Scroll Animations ═══ */
        .animate-on-scroll {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .animate-on-scroll.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* ═══ Mobile hamburger ═══ */
        .mobile-menu-btn {
            display: none;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #0f172a;
            padding: 0.25rem;
        }

        /* ═══ Responsive ═══ */
        @media (max-width: 1024px) {
            .hero-content {
                grid-template-columns: 1fr;
                text-align: center;
                gap: 3rem;
            }

            .hero-subtitle {
                margin: 0 auto 2.5rem;
            }

            .hero-actions {
                justify-content: center;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .sdg-grid {
                grid-template-columns: 1fr;
                text-align: center;
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 7rem 1.25rem 3rem;
            }

            .nav-links {
                display: none;
            }

            .nav-links.open {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: white;
                padding: 1rem;
                box-shadow: 0 8px 30px rgba(0,0,0,0.1);
                border-radius: 0 0 1rem 1rem;
            }

            .nav-links.open a {
                color: #475569;
                padding: 0.75rem 1rem;
            }

            .mobile-menu-btn {
                display: block;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .steps-grid {
                grid-template-columns: 1fr 1fr;
            }

            .steps-grid::before {
                display: none;
            }

            .stats-ticker-inner {
                grid-template-columns: repeat(2, 1fr);
            }

            .sdg-cards {
                grid-template-columns: 1fr;
            }

            .hero-dashboard-preview {
                padding: 1.25rem;
            }

            .footer-inner {
                flex-direction: column;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .steps-grid {
                grid-template-columns: 1fr;
            }

            .hero-actions {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>
<body class="landing-body">

    {{-- ═══ Navigation ═══ --}}
    <nav class="landing-nav" id="landing-nav">
        <a href="/" class="nav-brand">
            <img src="/assets/images/logo-fdly.png" alt="FDLY" style="height: 38px; width: auto;">
        </a>

        <button class="mobile-menu-btn" id="mobile-menu-toggle" aria-label="Toggle menu">
            ☰
        </button>

        <ul class="nav-links" id="nav-links">
            <li><a href="#fitur">Fitur</a></li>
            <li><a href="#cara-kerja">Cara Kerja</a></li>
            <li><a href="#sdg">SDG</a></li>
            <li>
                <a href="{{ route('login') }}" class="nav-login-btn" id="nav-login-btn">
                    Masuk
                </a>
            </li>
        </ul>
    </nav>

    {{-- ═══ Hero Section ═══ --}}
    <section class="hero-section" id="hero">
        <div class="hero-shape hero-shape-1"></div>
        <div class="hero-shape hero-shape-2"></div>
        <div class="hero-shape hero-shape-3"></div>
        <div class="hero-grid"></div>

        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-badge">
                    <span class="hero-badge-dot"></span>
                    Program Makan Bergizi Gratis 2025
                </div>

                <h1 class="hero-title">
                    Distribusi Pangan<br>
                    <span class="hero-title-highlight">Cerdas & Transparan</span>
                </h1>

                <p class="hero-subtitle">
                    Sistem informasi terpadu yang menghubungkan dapur katering, ahli gizi, kurir, dan sekolah
                    untuk memastikan setiap porsi MBG sampai tepat waktu dan berkualitas.
                </p>

                <div class="hero-actions">
                    <a href="{{ route('login') }}" class="hero-btn-primary" id="hero-login-btn">
                        Masuk ke Dashboard
                    </a>
                    <a href="#fitur" class="hero-btn-secondary" id="hero-learn-btn">
                        Pelajari Lebih
                    </a>
                </div>
            </div>

            <div class="hero-visual">
                <div class="hero-dashboard-preview">
                    <div class="preview-header">
                        <span class="preview-dot preview-dot-red"></span>
                        <span class="preview-dot preview-dot-yellow"></span>
                        <span class="preview-dot preview-dot-green"></span>
                        <span style="flex:1; text-align:center; font-size:0.75rem; color:rgba(255,255,255,0.4); font-weight:600;">FDLY Dashboard</span>
                    </div>

                    <div class="preview-stat-grid">
                        <div class="preview-stat">
                            <div class="preview-stat-value">12,847</div>
                            <div class="preview-stat-label">Porsi Hari Ini</div>
                        </div>
                        <div class="preview-stat">
                            <div class="preview-stat-value">98.5%</div>
                            <div class="preview-stat-label">Tingkat Penyaluran</div>
                        </div>
                        <div class="preview-stat">
                            <div class="preview-stat-value">156</div>
                            <div class="preview-stat-label">Sekolah Terlayani</div>
                        </div>
                        <div class="preview-stat">
                            <div class="preview-stat-value">4.8 ★</div>
                            <div class="preview-stat-label">Rating Kualitas</div>
                        </div>
                    </div>

                    <div class="preview-bar-chart">
                        <div class="preview-bar" style="height:45%"></div>
                        <div class="preview-bar" style="height:65%"></div>
                        <div class="preview-bar" style="height:55%"></div>
                        <div class="preview-bar" style="height:80%"></div>
                        <div class="preview-bar" style="height:72%"></div>
                        <div class="preview-bar" style="height:90%"></div>
                        <div class="preview-bar" style="height:85%"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ Stats Ticker ═══ --}}
    <div class="stats-ticker">
        <div class="stats-ticker-inner">
            <div class="ticker-item animate-on-scroll">
                <div class="ticker-value" data-target="500" data-suffix="+">0+</div>
                <div class="ticker-label">Sekolah Terdaftar</div>
            </div>
            <div class="ticker-item animate-on-scroll">
                <div class="ticker-value" data-target="50000" data-suffix="+">0+</div>
                <div class="ticker-label">Porsi Harian</div>
            </div>
            <div class="ticker-item animate-on-scroll">
                <div class="ticker-value" data-target="200" data-suffix="+">0+</div>
                <div class="ticker-label">Mitra Katering</div>
            </div>
            <div class="ticker-item animate-on-scroll">
                <div class="ticker-value" data-target="99" data-suffix="%">0%</div>
                <div class="ticker-label">Tingkat Keberhasilan</div>
            </div>
        </div>
    </div>

    {{-- ═══ Features Section ═══ --}}
    <section class="section" id="fitur">
        <div class="section-container">
            <div class="section-header animate-on-scroll">
                <div class="section-eyebrow">
                    <span class="section-eyebrow-line"></span>
                    Fitur Unggulan
                    <span class="section-eyebrow-line"></span>
                </div>
                <h2 class="section-title">Solusi Lengkap untuk<br>Distribusi Pangan Nasional</h2>
                <p class="section-description">
                    Platform terintegrasi dengan lima panel khusus untuk setiap peran dalam rantai distribusi MBG.
                </p>
            </div>

            <div class="features-grid">
                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon feature-icon-green"></div>
                    <h3 class="feature-title">Panel Dapur Katering</h3>
                    <p class="feature-desc">
                        Kelola produksi harian, catat jumlah porsi, dan unggah bukti foto masakan sebelum pengiriman.
                    </p>
                </div>

                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon feature-icon-blue"></div>
                    <h3 class="feature-title">Panel Ahli Gizi</h3>
                    <p class="feature-desc">
                        Verifikasi dan approve menu harian, pantau standar kalori, serta pastikan kepatuhan gizi.
                    </p>
                </div>

                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon feature-icon-amber"></div>
                    <h3 class="feature-title">Panel Kurir</h3>
                    <p class="feature-desc">
                        Tracking pengiriman real-time, konfirmasi serah terima, dan dokumentasi bukti penyerahan.
                    </p>
                </div>

                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon feature-icon-purple"></div>
                    <h3 class="feature-title">Panel Sekolah</h3>
                    <p class="feature-desc">
                        Terima dan konfirmasi kedatangan makanan, berikan rating kualitas, serta dukung mode offline.
                    </p>
                </div>

                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon feature-icon-rose"></div>
                    <h3 class="feature-title">Dashboard Admin</h3>
                    <p class="feature-desc">
                        Analisis data distribusi, pantau KPI seluruh wilayah, dan kelola akun pengguna sistem.
                    </p>
                </div>

                <div class="feature-card animate-on-scroll">
                    <div class="feature-icon feature-icon-teal"></div>
                    <h3 class="feature-title">PWA & Offline</h3>
                    <p class="feature-desc">
                        Progressive Web App dengan sinkronisasi offline, ideal untuk daerah dengan koneksi terbatas.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ How It Works ═══ --}}
    <section class="section how-section" id="cara-kerja">
        <div class="section-container">
            <div class="section-header animate-on-scroll">
                <div class="section-eyebrow">
                    <span class="section-eyebrow-line"></span>
                    Cara Kerja
                    <span class="section-eyebrow-line"></span>
                </div>
                <h2 class="section-title">Alur Distribusi yang Efisien</h2>
                <p class="section-description">
                    Empat langkah sederhana dari dapur hingga meja makan siswa.
                </p>
            </div>

            <div class="steps-grid">
                <div class="step-card animate-on-scroll">
                    <div class="step-number">1</div>
                    <h3 class="step-title">Produksi</h3>
                    <p class="step-desc">Dapur katering memasak dan menginput menu beserta bukti foto ke sistem.</p>
                </div>

                <div class="step-card animate-on-scroll">
                    <div class="step-number">2</div>
                    <h3 class="step-title">Verifikasi</h3>
                    <p class="step-desc">Ahli gizi memeriksa kesesuaian menu dengan standar nutrisi dan menyetujui pengiriman.</p>
                </div>

                <div class="step-card animate-on-scroll">
                    <div class="step-number">3</div>
                    <h3 class="step-title">Pengiriman</h3>
                    <p class="step-desc">Kurir mengantarkan makanan ke sekolah dengan tracking real-time dan bukti pengiriman.</p>
                </div>

                <div class="step-card animate-on-scroll">
                    <div class="step-number">4</div>
                    <h3 class="step-title">Penerimaan</h3>
                    <p class="step-desc">Sekolah mengkonfirmasi penerimaan dan memberikan rating kualitas makanan.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ SDG Section ═══ --}}
    <section class="section sdg-section" id="sdg">
        <div class="section-container">
            <div class="sdg-grid">
                <div class="sdg-text animate-on-scroll">
                    <div class="section-eyebrow" style="color: #34d399;">
                        <span class="section-eyebrow-line" style="background: #34d399;"></span>
                        Sustainable Development Goals
                    </div>
                    <h3>Mendukung Tujuan Pembangunan Berkelanjutan</h3>
                    <p>
                        FDLY dirancang untuk mendukung pencapaian SDG Indonesia,
                        khususnya dalam bidang ketahanan pangan dan kesehatan masyarakat.
                        Setiap fitur yang kami bangun berlandaskan prinsip transparansi,
                        akuntabilitas, dan keberlanjutan.
                    </p>
                </div>

                <div class="sdg-cards animate-on-scroll">
                    <div class="sdg-card">
                        <div class="sdg-card-title">SDG 2: Zero Hunger</div>
                        <div class="sdg-card-desc">Menghapus kelaparan, mencapai ketahanan pangan, dan meningkatkan nutrisi.</div>
                    </div>
                    <div class="sdg-card">
                        <div class="sdg-card-title">SDG 3: Good Health</div>
                        <div class="sdg-card-desc">Menjamin kehidupan yang sehat dan mendorong kesejahteraan di segala usia.</div>
                    </div>
                    <div class="sdg-card">
                        <div class="sdg-card-title">SDG 4: Quality Education</div>
                        <div class="sdg-card-desc">Siswa yang kenyang dan sehat adalah kunci pendidikan yang berkualitas.</div>
                    </div>
                    <div class="sdg-card">
                        <div class="sdg-card-title">SDG 17: Partnerships</div>
                        <div class="sdg-card-desc">Kolaborasi antara pemerintah, mitra katering, dan sekolah.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ CTA Section ═══ --}}
    <section class="cta-section">
        <div style="position: relative; z-index: 1;">
            <h2 class="cta-title animate-on-scroll">Siap Bergabung dengan FDLY?</h2>
            <p class="cta-desc animate-on-scroll">
                Masuk ke dashboard dan mulai kelola distribusi makan bergizi gratis di wilayah Anda.
            </p>
            <a href="{{ route('login') }}" class="cta-btn animate-on-scroll" id="cta-login-btn">
                Masuk ke Dashboard
            </a>
        </div>
    </section>

    {{-- ═══ Footer ═══ --}}
    <footer class="landing-footer">
        <div class="footer-inner">
            <div class="footer-brand">
                <img src="/assets/images/logo-fdly.png" alt="FDLY" style="height: 32px; width: auto; filter: brightness(0) invert(1);">
            </div>

            <div class="footer-text">
                Sistem Informasi Terpadu Penyaluran Makan Bergizi Gratis © {{ date('Y') }}
            </div>

            <div class="footer-sdg">
                SDG 2 &nbsp;·&nbsp; SDG 3 &nbsp;·&nbsp; SDG 4
            </div>
        </div>
    </footer>

    {{-- ═══ Scripts ═══ --}}
    <script>
        // Navbar scroll effect
        const nav = document.getElementById('landing-nav');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Mobile menu toggle
        const mobileBtn = document.getElementById('mobile-menu-toggle');
        const navLinks = document.getElementById('nav-links');
        mobileBtn.addEventListener('click', () => {
            navLinks.classList.toggle('open');
        });

        // Close mobile menu on link click
        navLinks.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('open');
            });
        });

        // Scroll animations (Intersection Observer)
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((entry, index) => {
                if (entry.isIntersecting) {
                    // Stagger animation
                    setTimeout(() => {
                        entry.target.classList.add('visible');
                    }, index * 80);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });

        // Counter animation for stats
        function animateCounters() {
            const counters = document.querySelectorAll('.ticker-value[data-target]');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const suffix = counter.getAttribute('data-suffix') || '';
                const duration = 2000;
                const increment = target / (duration / 16);
                let current = 0;

                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    counter.textContent = Math.floor(current).toLocaleString('id-ID') + suffix;
                }, 16);
            });
        }

        // Trigger counter when stats section is visible
        const statsSection = document.querySelector('.stats-ticker');
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.3 });

        statsObserver.observe(statsSection);

        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>
