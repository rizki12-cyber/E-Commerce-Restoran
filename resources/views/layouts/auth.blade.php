<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Auth') — {{ $globalSettings['app_name'] ?? config('app.name') }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: #F8F9FA;
            background-image: url("data:image/svg+xml,%3Csvg width='120' height='120' viewBox='0 0 120 120' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' stroke='%23E0E0E0' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M20 20 Q 30 10 40 20 T 60 20'/%3E%3Ccircle cx='90' cy='30' r='5'/%3E%3Crect x='20' y='80' width='15' height='15' transform='rotate(15 25 85)'/%3E%3Cpath d='M 80 80 A 10 10 0 0 1 100 80'/%3E%3Cpath d='M 60 60 L 70 50 L 80 60'/%3E%3Ccircle cx='15' cy='50' r='3' fill='%23E0E0E0'/%3E%3Cpath d='M 90 100 L 100 90'/%3E%3Cpath d='M 105 70 Q 110 60 115 70'/%3E%3C/g%3E%3C/svg%3E");
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }

        .auth-wrapper {
            width: 100%;
            max-width: 1100px;
            min-height: 650px;
            background: #fff;
            border-radius: 24px;
            box-shadow: 0 30px 80px rgba(48, 37, 31, 0.15); 
            overflow: hidden;
            display: flex;
            flex-direction: row;
            margin: 2rem auto;
        }

        /* --- PANEL KIRI: EDITORIAL STYLE (HITAM PEKAT) --- */
        .auth-left {
            width: 45%;
            background-color: #121212;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 2rem 3rem 7rem 3rem; 
            overflow: hidden;
        }

        .auth-left-bg-text {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Playfair Display', serif;
            font-size: 8rem;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.03);
            writing-mode: vertical-rl;
            white-space: nowrap;
            z-index: 1;
            pointer-events: none;
            letter-spacing: 10px;
        }

        .auth-brand-logo {
            position: relative; 
            z-index: 3;
            font-family: 'Playfair Display', serif;
            font-size: 2rem; 
            font-weight: 700;
            color: #fff;
            text-decoration: none;
            letter-spacing: 2px;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .auth-arch-image {
            width: 85%;
            max-width: 320px;
            height: 380px; 
            border-radius: 200px 200px 20px 20px;
            overflow: hidden;
            position: relative;
            z-index: 2;
            border: 1px solid rgba(255, 255, 255, 0.15);
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            background-color: #0d0d0d;
        }

        .auth-arch-image img,
        .auth-arch-image svg {
            width: 100%;
            height: 100%;
            display: block;
            object-fit: cover;
        }

        .auth-arch-image img {
            filter: grayscale(20%) contrast(110%);
        }

        .auth-left-tagline {
            position: absolute;
            bottom: 2.5rem;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            text-align: center;
            z-index: 3;
        }

        .auth-left-tagline small {
            display: block;
            font-size: 0.65rem;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #a0a0a0;
            margin-bottom: 0.5rem;
        }

        .auth-left-tagline h4 {
            font-family: 'Playfair Display', serif;
            font-size: 1.2rem;
            font-weight: 400;
            margin: 0;
            font-style: italic;
            color: #ffffff !important;
        }

        /* --- PANEL KANAN: FORM --- */
        .auth-right {
            width: 55%;
            position: relative;
            overflow: hidden; 
            background-color: #fff;
            display: flex;
        }

        .auth-form-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .custom-input-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .custom-input-group label {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #6B6B6B;
            display: block;
            margin-bottom: 5px;
        }

        .custom-input-group input {
            width: 100%;
            background-color: transparent;
            border: none;
            border-bottom: 1px solid #d1d1d1;
            border-radius: 0;
            padding: 10px 0;
            font-size: 1rem;
            color: #1A1A1A;
            transition: all 0.3s;
        }

        .custom-input-group input:focus {
            outline: none;
            border-bottom-color: #1A1A1A;
            box-shadow: none;
        }

        .custom-input-group .input-icon {
            position: absolute;
            right: 0;
            bottom: 12px;
            color: #6B6B6B;
            cursor: pointer;
            font-size: 1.1rem;
        }

        .btn-auth {
            background-color: #1A1A1A;
            color: #fff;
            border: none;
            border-radius: 50px;
            padding: 15px;
            font-weight: 600;
            width: 100%;
            font-size: 1rem;
            transition: all 0.3s;
            margin-top: 1rem;
        }

        .btn-auth:hover {
            background-color: #333333; 
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        }

        .auth-link {
            color: #1A1A1A;
            text-decoration: none;
            font-weight: 600;
            border-bottom: 1px solid transparent;
            transition: all 0.3s;
            cursor: pointer;
        }

        .auth-link:hover {
            color: #6B6B6B;
            border-bottom-color: #6B6B6B;
        }

        /* --- ANIMASI SLIDING FORM (DESKTOP) --- */
        .auth-form-panel {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 100%;
            max-width: 450px; 
            padding: 0 2rem;
            transform: translate(-50%, -50%); 
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.6s ease;
        }

        #login-panel {
            transform: translate(-50%, -50%);
            opacity: 1;
            pointer-events: auto;
        }
        #register-panel {
            transform: translate(150%, -50%); 
            opacity: 0;
            pointer-events: none;
        }

        .auth-form-container.show-register #login-panel {
            transform: translate(-150%, -50%); 
            opacity: 0;
            pointer-events: none;
        }
        .auth-form-container.show-register #register-panel {
            transform: translate(-50%, -50%); 
            opacity: 1;
            pointer-events: auto;
        }

        /* ============================================= */
        /* ============== TABLET (769–1024) ============ */
        /* ============================================= */
        @media (max-width: 1024px) and (min-width: 769px) {
            .auth-left-bg-text {
                font-size: 5.5rem;
                letter-spacing: 6px;
            }
            .auth-arch-image {
                height: 300px;
            }
            .auth-brand-logo {
                font-size: 1.6rem;
            }
            .auth-wrapper {
                min-height: 600px;
            }
        }

        /* ============================================= */
        /* ================ MOBILE (≤768) ============== */
        /* ============================================= */
        @media (max-width: 768px) {
            body {
                align-items: flex-start;
                justify-content: center;
                padding: 1rem;
                background-attachment: scroll;
                min-height: 100vh;
                min-height: 100dvh;
            }

            .auth-wrapper {
                flex-direction: column;
                width: 100%;
                max-width: 520px;
                min-height: auto;
                margin: 0 auto;
                border-radius: 20px;
            }

            /* Panel kiri: logo + gambar + tagline (ditumpuk vertikal) */
            .auth-left {
                width: 100%;
                padding: 1.75rem 1.5rem 1.5rem;
                flex-direction: column;
                justify-content: center;
            }

            .auth-left-bg-text {
                display: none;
            }

            .auth-brand-logo {
                font-size: 1.4rem;
                margin-bottom: 1.25rem;
                letter-spacing: 1.5px;
            }

            /* Gambar tetap tampil — diperkecil & proporsional */
            .auth-arch-image {
                display: block;
                width: 60%;
                max-width: 220px;
                height: 250px;
                border-radius: 110px 110px 16px 16px;
                box-shadow: 0 12px 30px rgba(0,0,0,0.45);
            }

            .auth-left-tagline {
                position: relative;
                bottom: auto;
                left: auto;
                transform: none;
                margin-top: 1.25rem;
                width: 100%;
            }
            .auth-left-tagline small {
                font-size: 0.6rem;
                letter-spacing: 3px;
                margin-bottom: 0.35rem;
            }
            .auth-left-tagline h4 {
                font-size: 1rem;
            }

            .auth-right {
                width: 100%;
                display: block;
                height: auto;
                min-height: 0;
            }

            .auth-form-container {
                position: relative;
                width: 100%;
                height: auto;
                min-height: 0;
                padding: 2rem 0;
            }

            .auth-form-panel {
                position: relative;
                top: auto;
                left: auto;
                transform: none !important;
                width: 100%;
                max-width: 100%;
                padding: 0 1.5rem;
                transition: opacity 0.3s ease;
            }

            #login-panel {
                display: block;
                opacity: 1;
                pointer-events: auto;
            }
            #register-panel {
                display: none;
                opacity: 0;
                pointer-events: none;
            }

            .auth-form-container.show-register #login-panel {
                display: none;
                opacity: 0;
                pointer-events: none;
            }
            .auth-form-container.show-register #register-panel {
                display: block;
                opacity: 1;
                pointer-events: auto;
            }

            .custom-input-group {
                margin-bottom: 1.25rem;
            }

            .btn-auth {
                padding: 13px;
                font-size: 0.95rem;
            }
        }

        /* ============================================= */
        /* ============ MOBILE KECIL (≤480) ============ */
        /* ============================================= */
        @media (max-width: 480px) {
            body {
                padding: 0.5rem;
            }
            .auth-wrapper {
                border-radius: 16px;
            }
            .auth-left {
                padding: 1.5rem 1.25rem 1.25rem;
            }
            .auth-brand-logo {
                font-size: 1.25rem;
                margin-bottom: 1rem;
            }
            .auth-arch-image {
                width: 62%;
                max-width: 190px;
                height: 210px;
                border-radius: 95px 95px 14px 14px;
            }
            .auth-left-tagline {
                margin-top: 1rem;
            }
            .auth-left-tagline h4 {
                font-size: 0.9rem;
            }
            .auth-form-container {
                padding: 1.5rem 0;
            }
            .auth-form-panel {
                padding: 0 1.25rem;
            }
            .custom-input-group label {
                font-size: 0.7rem;
            }
            .custom-input-group input {
                font-size: 0.95rem;
            }
        }
    </style>
</head>
<body>

    <div class="auth-wrapper">
        <!-- Panel Kiri: Desain Editorial -->
        <div class="auth-left">
            <!-- Teks Raksasa di Background -->
            <div class="auth-left-bg-text">
                {{ $globalSettings['app_name'] ?? 'DAPUR KAYSAN' }}
            </div>
            
            <!-- Nama Restoran -->
            <a href="{{ route('home') }}" class="auth-brand-logo">
                {{ $globalSettings['app_name'] ?? 'Dapur Kaysan' }}.
            </a>

            <!-- Gambar Melengkung (foto Unsplash + fallback SVG otomatis) -->
            <div class="auth-arch-image">
                <img
                    src="{{ asset('images/login.jpg') }}"
                    alt="Fine Dining — Kemewahan dalam setiap gigitan"
                    loading="lazy"
                    decoding="async"
                    referrerpolicy="no-referrer"
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">

                <!-- Fallback SVG (hidden by default, tampil jika foto gagal) -->
                <svg viewBox="0 0 320 380" xmlns="http://www.w3.org/2000/svg"
                     preserveAspectRatio="xMidYMid slice" role="img"
                     aria-label="Ilustrasi fine dining"
                     style="display:none;">
                    <defs>
                        <linearGradient id="bgGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" stop-color="#0d0d0d"/>
                            <stop offset="50%" stop-color="#1a1512"/>
                            <stop offset="100%" stop-color="#0d0d0d"/>
                        </linearGradient>
                        <radialGradient id="warmGlow" cx="50%" cy="45%" r="55%">
                            <stop offset="0%" stop-color="#c9a96e" stop-opacity="0.14"/>
                            <stop offset="100%" stop-color="#c9a96e" stop-opacity="0"/>
                        </radialGradient>
                    </defs>
                    <rect width="320" height="380" fill="url(#bgGrad)"/>
                    <rect width="320" height="380" fill="url(#warmGlow)"/>
                    <g stroke="#c9a96e" stroke-opacity="0.35" fill="none" stroke-width="0.8">
                        <path d="M20 20 L20 50 M20 20 L50 20"/>
                        <path d="M300 20 L300 50 M300 20 L270 20"/>
                        <path d="M20 360 L20 330 M20 360 L50 360"/>
                        <path d="M300 360 L300 330 M300 360 L270 360"/>
                    </g>
                    <text x="160" y="60" text-anchor="middle" fill="#c9a96e"
                          font-family="Georgia, serif" font-size="9" letter-spacing="6" opacity="0.85">FINE DINING</text>
                    <g stroke="#e8dcc4" stroke-width="1.2" fill="none" stroke-linecap="round">
                        <ellipse cx="160" cy="110" rx="34" ry="6"/>
                        <path d="M126 110 Q126 170 160 175 Q194 170 194 110"/>
                        <line x1="160" y1="175" x2="160" y2="240"/>
                        <ellipse cx="160" cy="242" rx="30" ry="5"/>
                    </g>
                    <path d="M135 140 Q160 155 185 140 Q180 170 160 172 Q140 170 135 140 Z"
                          fill="#c9a96e" fill-opacity="0.15"/>
                    <g>
                        <ellipse cx="160" cy="315" rx="65" ry="18" stroke="#e8dcc4" stroke-width="1.2" fill="none"/>
                        <ellipse cx="160" cy="310" rx="52" ry="14" stroke="#e8dcc4" stroke-width="0.8" fill="none" stroke-opacity="0.6"/>
                        <ellipse cx="160" cy="308" rx="28" ry="8" fill="#c9a96e" fill-opacity="0.15"/>
                        <g fill="#c9a96e">
                            <circle cx="145" cy="306" r="2.5"/>
                            <circle cx="155" cy="303" r="3"/>
                            <circle cx="168" cy="305" r="2.5"/>
                            <circle cx="178" cy="308" r="2"/>
                        </g>
                    </g>
                    <text x="160" y="365" text-anchor="middle" fill="#c9a96e"
                          font-family="Georgia, serif" font-size="8" letter-spacing="5" opacity="0.6">EST. 2026</text>
                </svg>
            </div>

            <!-- Tagline di Bawah -->
            <div class="auth-left-tagline">
                <small>EST. 2026</small>
                <h4>"Kemewahan dalam setiap gigitan."</h4>
            </div>
        </div>

        <!-- Panel Kanan: Form -->
        <div class="auth-right">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>