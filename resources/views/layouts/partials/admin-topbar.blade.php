<header class="px-3 px-md-4 py-3 d-flex justify-content-between align-items-center"
        style="background: transparent;
               backdrop-filter: blur(10px);
               -webkit-backdrop-filter: blur(10px);
               border-bottom: 1px solid var(--dk-border);
               position: sticky;
               top: 0; z-index: 1020;">

    <!-- Kiri: Hamburger (mobile) + Judul -->
    <div class="d-flex align-items-center gap-2 gap-md-3 min-w-0">
        <button type="button"
                class="btn btn-light border-0 d-lg-none p-2 flex-shrink-0"
                id="adminMenuToggle"
                aria-label="Buka menu navigasi"
                aria-controls="adminSidebar"
                aria-expanded="false">
            <i class="bi bi-list fs-5"></i>
        </button>

        <div class="min-w-0">
            <span class="text-muted text-uppercase fw-bold d-block mb-1"
                  style="font-size: 0.65rem; letter-spacing: 2px;">Dashboard</span>
            <h1 class="h4 mb-0 fw-bold text-truncate"
                style="font-family: var(--dk-font-heading); color: var(--dk-text);">
                @yield('page_title', 'Overview')
            </h1>
        </div>
    </div>

    <!-- Kanan: Profil Dropdown -->
    <div class="dropdown flex-shrink-0">
                <a href="#"
           class="d-flex align-items-center gap-2 gap-md-3 text-decoration-none dropdown-toggle hide-caret"
           data-bs-toggle="dropdown" aria-expanded="false" style="color: var(--dk-text);">

            {{-- 🔥 BAGIAN INI YANG DIUBAH 🔥 --}}
            @if(auth()->user()->avatar) {{-- Ganti 'avatar' sesuai nama kolom foto di database kamu --}}
                <img src="{{ Storage::url(auth()->user()->avatar) }}" 
                     alt="{{ auth()->user()->name }}" 
                     class="rounded-circle shadow-sm object-fit-cover"
                     style="width: 42px; height: 42px;">
            @else
                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm"
                     style="width: 42px; height: 42px; font-family: var(--dk-font-heading); font-size: 1.1rem;">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
            @endif
            {{-- BATAS PERUBAHAN --}}

            <div class="d-none d-md-block text-start">
                <span class="d-block fw-bold" style="font-size: 0.9rem;">{{ auth()->user()->name }}</span>
                <span class="d-block text-muted" style="font-size: 0.75rem;">Administrator</span>
            </div>
        </a>

        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 mt-3"
            style="border-radius: 16px; padding: 10px; min-width: 220px;">
            <li>
                <div class="px-3 py-2 border-bottom mb-2">
                    <small class="text-muted d-block text-uppercase fw-bold"
                           style="font-size: 0.65rem; letter-spacing: 1px;">Akun Saya</small>
                </div>
            </li>
            <li>
                <a class="dropdown-item rounded-3 d-flex align-items-center gap-2 py-2"
                   href="{{ route('profile.edit') }}">
                    <i class="bi bi-person text-muted"></i> Pengaturan Profil
                </a>
            </li>
            <li>
                <a class="dropdown-item rounded-3 d-flex align-items-center gap-2 py-2"
                   href="{{ route('home') }}" target="_blank">
                    <i class="bi bi-globe text-muted"></i> Lihat Website
                </a>
            </li>
            <li><hr class="dropdown-divider my-2"></li>
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="dropdown-item rounded-3 d-flex align-items-center gap-2 py-2 text-danger fw-medium">
                        <i class="bi bi-box-arrow-right"></i> Logout
                    </button>
                </form>
            </li>
        </ul>
    </div>
</header>

@push('styles')
<style>
    .hide-caret::after { display: none !important; }

    .dropdown-menu .dropdown-item {
        transition: all 0.2s ease;
        color: var(--dk-text);
    }
    .dropdown-menu .dropdown-item:hover {
        background-color: var(--dk-bg);
        color: var(--dk-primary);
        transform: translateX(5px);
    }
    .dropdown-menu .dropdown-item.text-danger:hover {
        background-color: rgba(220, 82, 82, 0.1);
        color: #DC5252 !important;
    }
</style>
@endpush