<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin — ' . config('app.name'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <style>
        /* ============================================
           ANIMASI HALAMAN ADMIN
           ============================================ */
        @keyframes adminBlurIn {
            0%   { opacity: 0; filter: blur(10px); transform: scale(1.02); }
            100% { opacity: 1; filter: blur(0);    transform: scale(1);    }
        }
        .admin-main-content {
            animation: adminBlurIn 0.6s cubic-bezier(0.25, 1, 0.5, 1) both;
        }

        @keyframes cardEnter {
            0%   { opacity: 0; transform: translateY(15px); }
            100% { opacity: 1; transform: translateY(0);    }
        }
        .admin-main-content .card {
            animation: cardEnter 0.5s ease-out both;
            animation-delay: var(--card-delay, 0s);
        }

        /* ============================================
           BACKDROP DRAWER (MOBILE)
           ============================================ */
        .admin-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            -webkit-backdrop-filter: blur(2px);
            backdrop-filter: blur(2px);
            z-index: 1045;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .admin-backdrop.is-active { display: block; opacity: 1; }

        /* ============================================
   MOBILE / TABLET (<992px) — SIDEBAR DRAWER
   ============================================ */
@media (max-width: 991.98px) {
    .admin-sidebar-drawer {
        position: fixed !important;
        inset: 0 !important; 
        height: 100% !important; 
        width: 280px !important;
        max-width: 85vw !important;
        z-index: 1050 !important;
        overflow-y: auto !important;
        transform: translateX(-100%);
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
        will-change: transform;
        
        /* 🔥 UBAH BAGIAN INI 🔥 */
        /* Jangan pakai transparent, tapi pakai warna tema kamu */
        background-color: var(--dk-bg) !important; 
    }
    
    .admin-sidebar-drawer.is-open { 
        transform: translateX(0); 
    }

    body.admin-menu-open { 
        overflow: hidden; 
    }
}

        /* ============================================
           REDUCED MOTION
           ============================================ */
        @media (prefers-reduced-motion: reduce) {
            .admin-main-content,
            .admin-main-content .card,
            .admin-sidebar-drawer,
            .admin-backdrop {
                animation: none !important;
                transition: none !important;
            }
        }

        
    </style>
</head>
<body>

    @if (session('success'))
        <span hidden data-flash-success="{{ session('success') }}"></span>
    @endif
    @if (session('error'))
        <span hidden data-flash-error="{{ session('error') }}"></span>
    @endif

    <div class="d-flex min-vh-100 admin-wrapper">

        {{-- Sidebar partial --}}
        @include('layouts.partials.admin-sidebar')

        {{-- Backdrop drawer (mobile) --}}
        <div class="admin-backdrop" id="adminBackdrop" aria-hidden="true"></div>

        <div class="flex-grow-1 d-flex flex-column min-w-0">
            @include('layouts.partials.admin-topbar')

            <main class="p-3 p-md-4 flex-grow-1 admin-main-content">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')

    <script>
    document.addEventListener('DOMContentLoaded', function () {

        /* ---------- STAGGER ANIMASI KARTU ---------- */
        document.querySelectorAll('.admin-main-content .card').forEach((card, i) => {
            card.style.setProperty('--card-delay', Math.min(i * 0.05, 0.6) + 's');
        });

        /* ---------- MOBILE DRAWER TOGGLE ---------- */
        const sidebar  = document.getElementById('adminSidebar');
        const toggle   = document.getElementById('adminMenuToggle');
        const backdrop = document.getElementById('adminBackdrop');
        if (!sidebar || !toggle || !backdrop) return;

        const isOpen = () => sidebar.classList.contains('is-open');

        function openSidebar() {
            sidebar.classList.add('is-open');
            backdrop.classList.add('is-active');
            document.body.classList.add('admin-menu-open');
            toggle.setAttribute('aria-expanded', 'true');
            toggle.setAttribute('aria-label', 'Tutup menu navigasi');
            toggle.innerHTML = '<i class="bi bi-x-lg fs-5"></i>';
        }

        function closeSidebar() {
            sidebar.classList.remove('is-open');
            backdrop.classList.remove('is-active');
            document.body.classList.remove('admin-menu-open');
            toggle.setAttribute('aria-expanded', 'false');
            toggle.setAttribute('aria-label', 'Buka menu navigasi');
            toggle.innerHTML = '<i class="bi bi-list fs-5"></i>';
        }

        toggle.addEventListener('click', () => isOpen() ? closeSidebar() : openSidebar());
        backdrop.addEventListener('click', closeSidebar);
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && isOpen()) closeSidebar();
        });

        // Tutup otomatis saat resize ke desktop
        let resizeTimer;
        window.addEventListener('resize', () => {
            clearTimeout(resizeTimer);
            resizeTimer = setTimeout(() => {
                if (window.innerWidth >= 992 && isOpen()) closeSidebar();
            }, 150);
        });
    });
    </script>

</body>
</html>