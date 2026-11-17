@php
    // LOGIKA NOTIFIKASI & BADGE
    $pendingOrders   = \App\Models\Order::where('status', 'pending_payment')->count();
    $pendingPayments = \App\Models\Payment::where('status', 'unpaid')->whereNotNull('proof_image')->count();
    $pendingReviews  = \App\Models\Review::where('status', 'pending')->count();
    $lowStockProducts = \App\Models\Product::whereColumn('stock', '<=', 'min_stock')->count();
@endphp

<aside id="adminSidebar"
       class="p-3 d-flex flex-column custom-sidebar admin-sidebar-drawer"
       aria-label="Menu navigasi admin"
       style="background: transparent;
              backdrop-filter: blur(10px);
              -webkit-backdrop-filter: blur(10px);">

    <!-- Brand / Logo Admin -->
    <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-2 mb-4 text-decoration-none px-2">
        <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0"
             style="width: 35px; height: 35px; font-family: var(--dk-font-heading);">
            {{ substr($globalSettings['app_name'] ?? 'D', 0, 1) }}
        </div>
        <span class="fw-bold fs-5 text-truncate"
              style="font-family: var(--dk-font-heading); color: var(--dk-text); max-width: 180px;">
            {{ $globalSettings['app_name'] ?? 'Dapur Kaysan' }}
        </span>
    </a>

    <!-- Menu Navigasi -->
    <div class="sidebar-scroll flex-grow-1">

        <small class="sidebar-heading">UTAMA</small>
        <ul class="list-unstyled mb-4">
            <li>
                <a class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-grid-1x2"></i> Dashboard
                </a>
            </li>
        </ul>

        <small class="sidebar-heading">KATALOG</small>
        <ul class="list-unstyled mb-4">
            <li>
                <a class="sidebar-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}"
                   href="{{ route('admin.products.index') }}">
                    <i class="bi bi-box-seam"></i> Produk
                </a>
            </li>
            <li>
                <a class="sidebar-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"
                   href="{{ route('admin.categories.index') }}">
                    <i class="bi bi-tags"></i> Kategori
                </a>
            </li>
            <li>
                <a class="sidebar-link {{ request()->routeIs('admin.variants.*') ? 'active' : '' }}"
                   href="{{ route('admin.variants.index') }}">
                    <i class="bi bi-layers"></i> Variasi & Add-on
                </a>
            </li>
            <li>
                <a class="sidebar-link {{ request()->routeIs('admin.inventory.*') ? 'active' : '' }}"
                   href="{{ route('admin.inventory.index') }}">
                    <i class="bi bi-boxes"></i> Inventory
                    @if($lowStockProducts > 0)
                        <span class="badge rounded-pill bg-danger ms-auto">{{ $lowStockProducts }}</span>
                    @endif
                </a>
            </li>
        </ul>

        <small class="sidebar-heading">TRANSAKSI</small>
        <ul class="list-unstyled mb-4">
            <li>
                <a class="sidebar-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"
                   href="{{ route('admin.orders.index') }}">
                    <i class="bi bi-receipt"></i> Pesanan
                    @if($pendingOrders > 0)
                        <span class="badge rounded-pill bg-warning text-dark ms-auto">{{ $pendingOrders }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a class="sidebar-link {{ request()->routeIs('admin.payments.*') ? 'active' : '' }}"
                   href="{{ route('admin.payments.index') }}">
                    <i class="bi bi-credit-card"></i> Pembayaran
                    @if($pendingPayments > 0)
                        <span class="badge rounded-pill bg-danger ms-auto">{{ $pendingPayments }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a class="sidebar-link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}"
                   href="{{ route('admin.customers.index') }}">
                    <i class="bi bi-people"></i> Pelanggan
                </a>
            </li>
        </ul>

        <small class="sidebar-heading">PEMASARAN & CMS</small>
        <ul class="list-unstyled mb-4">
            <li>
                <a class="sidebar-link {{ request()->routeIs('admin.vouchers.*') ? 'active' : '' }}"
                   href="{{ route('admin.vouchers.index') }}">
                    <i class="bi bi-ticket-perforated"></i> Voucher & Promosi
                </a>
            </li>
            <li>
                <a class="sidebar-link {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}"
                   href="{{ route('admin.reviews.index') }}">
                    <i class="bi bi-star"></i> Review
                    @if($pendingReviews > 0)
                        <span class="badge rounded-pill bg-primary ms-auto">{{ $pendingReviews }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a class="sidebar-link {{ request()->routeIs('admin.cms.*') ? 'active' : '' }}"
                   data-bs-toggle="collapse" href="#cmsMenu" role="button">
                    <i class="bi bi-collection"></i> Konten Website
                    <i class="bi bi-chevron-down ms-auto" style="font-size: 0.7rem;"></i>
                </a>
                <div class="collapse {{ request()->routeIs('admin.cms.*') ? 'show' : '' }}" id="cmsMenu">
                    <ul class="list-unstyled ms-4 mt-1 sidebar-submenu">
                        <li><a class="sidebar-link py-1" href="{{ route('admin.cms.homepage.index') }}">- Beranda</a></li>
                        <li><a class="sidebar-link py-1" href="{{ route('admin.cms.faqs.index') }}">- FAQ</a></li>
                        <li><a class="sidebar-link py-1" href="{{ route('admin.galleries.index') }}">- Galeri Foto</a></li>
                    </ul>
                </div>
            </li>
        </ul>

        <small class="sidebar-heading">SISTEM</small>
        <ul class="list-unstyled">
            <li>
                <a class="sidebar-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}"
                   href="{{ route('admin.reports.sales') }}">
                    <i class="bi bi-graph-up-arrow"></i> Laporan Penjualan
                </a>
            </li>
            <li>
                <a class="sidebar-link {{ request()->routeIs('admin.activity-logs.*') ? 'active' : '' }}"
                   href="{{ route('admin.activity-logs.index') }}">
                    <i class="bi bi-journal-text"></i> Activity Log
                </a>
            </li>
            <li>
                <a class="sidebar-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}"
                   href="{{ route('admin.settings.index') }}">
                    <i class="bi bi-gear"></i> Pengaturan
                </a>
            </li>
        </ul>
    </div>
</aside>