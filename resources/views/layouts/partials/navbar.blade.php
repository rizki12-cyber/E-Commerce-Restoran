<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
                <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center gap-3" href="{{ route('home') }}">
            @if(isset($globalSettings['logo']) && $globalSettings['logo'])
                <img src="{{ Storage::url($globalSettings['logo']) }}" alt="Logo" 
                     style="height: 55px; width: auto; max-width: 160px; object-fit: contain;">
            @endif
            <span style="font-family: var(--dk-font-heading); font-weight: 700; font-size: 1.6rem;">
                {{ $globalSettings['app_name'] ?? config('app.name') }}
            </span>
        </a>

        <!-- Hamburger Button (Custom) -->
        <button class="navbar-toggler border-0 shadow-none p-2" type="button" data-bs-toggle="collapse"
                data-bs-target="#publicNavbar" aria-controls="publicNavbar"
                aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-1 text-dark"></i>
        </button>

        <div class="collapse navbar-collapse" id="publicNavbar">
            
            <!-- Profil Mobile (Hanya Muncul di HP) -->
            <div class="d-lg-none p-3 mb-3 rounded-4" style="background: rgba(0,0,0,0.03);">
                @auth
                    <div class="d-flex align-items-center gap-3">
                        @if(auth()->user()->avatar)
                            <img src="{{ Storage::url(auth()->user()->avatar) }}" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover; border: 2px solid #fff;">
                        @else
                            <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; font-family: var(--dk-font-heading); font-size: 1.5rem;">
                                {{ substr(auth()->user()->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <h6 class="fw-bold mb-0">{{ auth()->user()->name }}</h6>
                            <small class="text-muted">{{ auth()->user()->email }}</small>
                        </div>
                    </div>
                @else
                    <div class="d-flex gap-2">
                        <a href="{{ route('login') }}" class="btn btn-outline-dark w-100 rounded-pill">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-primary w-100 rounded-pill">Register</a>
                    </div>
                @endauth
            </div>

            <!-- Menu Tengah -->
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0 fw-medium gap-2 gap-lg-4">
                <li class="nav-item">
                    <a class="nav-link nav-link-premium {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-premium {{ request()->routeIs('catalog.*') ? 'active' : '' }}" href="{{ route('catalog.index') }}">Menu</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-premium" href="#tentang">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-premium" href="#galeri">Galeri</a>
                </li>
                @auth
                    <!-- Menu Tambahan Khusus Mobile -->
                    <li class="nav-item d-lg-none">
                        <a class="nav-link nav-link-premium" href="{{ route('dashboard') }}">Dashboard</a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a class="nav-link nav-link-premium" href="{{ route('customer.orders.index') }}">Pesanan Saya</a>
                    </li>
                    <li class="nav-item d-lg-none">
                        <a class="nav-link nav-link-premium text-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">Logout</a>
                    </li>
                    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
                @endauth
            </ul>

            <!-- Ikon & Profil Kanan (Desktop) -->
            <ul class="navbar-nav align-items-lg-center gap-2 gap-lg-3 mt-3 mt-lg-0 d-none d-lg-flex">
                
                <!-- Garis Pemisah Vertikal -->
                <li class="nav-item">
                    <div style="width: 1px; height: 24px; background-color: #e0d5cb; margin: 0 10px;"></div>
                </li>

                <!-- Ikon Search -->
                <li class="nav-item">
                    <a href="{{ route('catalog.index') }}" class="nav-icon-btn" title="Cari Menu">
                        <i class="bi bi-search"></i>
                    </a>
                </li>

                <!-- Wishlist -->
                <li class="nav-item">
                    <a href="{{ auth()->check() && auth()->user()->role === 'customer' ? route('customer.wishlist.index') : route('login') }}" class="nav-icon-btn" title="Wishlist">
                        <i class="bi bi-heart"></i>
                    </a>
                </li>

                <!-- Tombol Cart -->
                <li class="nav-item">
                    <a href="{{ auth()->check() && auth()->user()->role === 'customer' ? route('customer.cart.index') : route('login') }}" class="nav-icon-btn position-relative" title="Keranjang">
                        <i class="bi bi-bag"></i>
                        @auth
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->first()?->items()->sum('quantity') ?? 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-dark text-white" style="font-size: 0.6rem; border: 2px solid var(--dk-bg); padding: 0.35em 0.5em;">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        @endauth
                    </a>
                </li>

                <!-- Profile Dropdown Desktop -->
                @auth
                    <li class="nav-item dropdown ms-lg-2">
                        <a class="nav-link dropdown-toggle d-flex align-items-center gap-2 text-dark fw-medium p-0 border-0 shadow-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if(auth()->user()->avatar)
                                <img src="{{ Storage::url(auth()->user()->avatar) }}" class="rounded-circle shadow-sm" style="width: 40px; height: 40px; object-fit: cover; border: 2px solid #fff;">
                            @else
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px; font-family: var(--dk-font-heading); font-size: 1.1rem; border: 2px solid #fff;">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                        </a>
                        
                        <ul class="dropdown-menu dropdown-menu-end dropdown-premium mt-3">
                            <li>
                                <div class="px-3 py-2 border-bottom mb-2 d-flex align-items-center gap-3">
                                    <div>
                                        <h6 class="mb-0 fw-bold" style="font-family: var(--dk-font-heading);">{{ auth()->user()->name }}</h6>
                                        <small class="text-muted" style="font-size: 0.75rem;">{{ auth()->user()->email }}</small>
                                    </div>
                                </div>
                            </li>
                            <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="bi bi-grid-1x2 text-primary"></i> Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('customer.orders.index') }}"><i class="bi bi-receipt text-success"></i> Pesanan Saya</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-person text-info"></i> Pengaturan Profil</a></li>
                            <li><hr class="dropdown-divider my-2"></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger fw-medium"><i class="bi bi-box-arrow-right"></i> Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <!-- TOMBOL LOGIN & REGISTER UNTUK DESKTOP (TAMBAHAN BARU) -->
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-outline-dark btn-sm px-4 rounded-pill fw-medium" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary btn-sm px-4 rounded-pill fw-medium" href="{{ route('register') }}">Register</a>
                    </li>
                @endauth
            </ul>

            <!-- Ikon Aksi Mobile (Bawah Menu) -->
            <div class="d-flex d-lg-none justify-content-around mt-4 pt-3 border-top">
                <a href="{{ route('catalog.index') }}" class="text-decoration-none text-dark text-center">
                    <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 45px; height: 45px;">
                        <i class="bi bi-search fs-5"></i>
                    </div>
                    <small style="font-size: 0.7rem;">Cari</small>
                </a>
                <a href="{{ auth()->check() && auth()->user()->role === 'customer' ? route('customer.wishlist.index') : route('login') }}" class="text-decoration-none text-dark text-center">
                    <div class="bg-white rounded-circle shadow-sm d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 45px; height: 45px;">
                        <i class="bi bi-heart fs-5"></i>
                    </div>
                    <small style="font-size: 0.7rem;">Wishlist</small>
                </a>
                <a href="{{ auth()->check() && auth()->user()->role === 'customer' ? route('customer.cart.index') : route('login') }}" class="text-decoration-none text-dark text-center position-relative">
                    <div class="bg-dark text-white rounded-circle shadow-sm d-flex align-items-center justify-content-center mx-auto mb-1" style="width: 45px; height: 45px;">
                        <i class="bi bi-bag fs-5"></i>
                        @auth
                            @php
                                $cartCount = \App\Models\Cart::where('user_id', auth()->id())->first()?->items()->sum('quantity') ?? 0;
                            @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger text-white" style="font-size: 0.6rem; border: 2px solid #fff;">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        @endauth
                    </div>
                    <small style="font-size: 0.7rem;">Keranjang</small>
                </a>
            </div>

        </div>
    </div>
</nav>

@push('styles')
<style>
    /* --- NAVBAR PREMIUM STYLES (DESKTOP) --- */
    .nav-link-premium {
        position: relative;
        color: var(--dk-text) !important;
        font-weight: 500;
        padding: 0.5rem 0;
        transition: color 0.3s ease;
    }
    
    .nav-link-premium::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 2px;
        background-color: var(--dk-primary);
        transition: width 0.3s ease;
    }

    .nav-link-premium:hover::after,
    .nav-link-premium.active::after {
        width: 100%;
    }

    .nav-link-premium:hover,
    .nav-link-premium.active {
        color: var(--dk-primary) !important;
    }

    .nav-icon-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        color: var(--dk-text);
        font-size: 1.25rem;
        transition: all 0.3s ease;
        text-decoration: none;
    }

    .nav-icon-btn:hover {
        background-color: rgba(0,0,0,0.04);
        color: var(--dk-primary);
        transform: translateY(-2px);
    }

    .dropdown-premium {
        border: none !important;
        border-radius: 16px !important;
        box-shadow: 0 15px 40px rgba(0,0,0,0.08) !important;
        padding: 10px !important;
        min-width: 250px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        animation: slideUpFade 0.3s ease forwards;
    }

    .dropdown-premium .dropdown-item {
        border-radius: 10px;
        padding: 12px 15px;
        font-weight: 500;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .dropdown-premium .dropdown-item:hover {
        background-color: var(--dk-bg);
        transform: translateX(5px);
    }

    @keyframes slideUpFade {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .dropdown-toggle::after {
        display: none;
    }

    /* --- NAVBAR MOBILE STYLES (FLOATING MENU) --- */
    @media (max-width: 991.98px) {
        .navbar-collapse {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            margin-top: 15px;
            padding: 1.5rem;
            border: 1px solid rgba(0,0,0,0.05);
            max-height: 85vh;
            overflow-y: auto;
        }

        .nav-link-premium {
            font-size: 1.25rem;
            font-family: var(--dk-font-heading);
            padding: 12px 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            display: block;
        }

        .nav-link-premium::after {
            display: none;
        }
        
        .nav-link-premium:hover {
            color: var(--dk-primary) !important;
            padding-left: 5px;
        }
    }
</style>
@endpush