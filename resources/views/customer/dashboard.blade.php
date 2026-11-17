@extends('layouts.app')

@section('title', 'Dashboard — ' . ($globalSettings['app_name'] ?? config('app.name')))

@section('content')
<div class="container py-5 my-4">
    
    <!-- Header Sambutan -->
    <div class="row align-items-end mb-5 pb-4 border-bottom" style="border-color: #e0d5cb !important;">
        <div class="col-md-8">
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.8rem;">AKUN SAYA</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-4 fw-bold mb-2" style="font-family: var(--dk-font-heading); line-height: 1.1;">
                Halo, {{ explode(' ', auth()->user()->name)[0] }}.
            </h1>
            <p class="text-muted mb-0" style="font-size: 1.05rem;">
                Selamat datang kembali di {{ $globalSettings['app_name'] ?? config('app.name') }}.
            </p>
        </div>
        <div class="col-md-4 text-md-end mt-4 mt-md-0">
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-dark px-4 py-2" style="border-radius: 50px;">
                <i class="bi bi-person-gear me-2"></i> Pengaturan Profil
            </a>
        </div>
    </div>

    <!-- Ringkasan Statistik (Gaya Editorial) -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="border-start border-3 ps-3 py-2" style="border-color: var(--dk-primary) !important;">
                <small class="text-muted text-uppercase fw-bold d-block mb-1" style="letter-spacing: 1px;">Total Pesanan</small>
                <h2 class="fw-bold mb-0" style="font-family: var(--dk-font-heading);">
                    {{ auth()->user()->orders->count() }}
                </h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border-start border-3 ps-3 py-2" style="border-color: #ccc !important;">
                <small class="text-muted text-uppercase fw-bold d-block mb-1" style="letter-spacing: 1px;">Pesanan Selesai</small>
                <h2 class="fw-bold mb-0" style="font-family: var(--dk-font-heading);">
                    {{ auth()->user()->orders->where('status.value', 'completed')->count() }}
                </h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border-start border-3 ps-3 py-2" style="border-color: #ccc !important;">
                <small class="text-muted text-uppercase fw-bold d-block mb-1" style="letter-spacing: 1px;">Wishlist</small>
                <h2 class="fw-bold mb-0" style="font-family: var(--dk-font-heading);">
                    {{ auth()->user()->wishlist ? auth()->user()->wishlist->items->count() : 0 }}
                </h2>
            </div>
        </div>
    </div>

    <!-- Menu Navigasi Grid -->
    <div class="row g-4 mb-5">
        <!-- Pesanan -->
        <div class="col-md-6">
            <a href="{{ route('customer.orders.index') }}" class="text-decoration-none group-link d-block p-4 rounded-3 border" style="border-color: #e0d5cb !important; transition: all 0.3s;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-receipt fs-4"></i>
                    </div>
                    <i class="bi bi-arrow-up-right fs-4 text-muted transition-arrow"></i>
                </div>
                <h4 class="fw-bold text-dark mb-1" style="font-family: var(--dk-font-heading);">Pesanan Saya</h4>
                <p class="text-muted mb-0 small">Lacak pesanan aktif dan lihat riwayat transaksi Anda.</p>
            </a>
        </div>

        <!-- Wishlist -->
        <div class="col-md-6">
            <a href="{{ route('customer.wishlist.index') }}" class="text-decoration-none group-link d-block p-4 rounded-3 border" style="border-color: #e0d5cb !important; transition: all 0.3s;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                        <i class="bi bi-heart fs-4"></i>
                    </div>
                    <i class="bi bi-arrow-up-right fs-4 text-muted transition-arrow"></i>
                </div>
                <h4 class="fw-bold text-dark mb-1" style="font-family: var(--dk-font-heading);">Wishlist</h4>
                <p class="text-muted mb-0 small">Menu favorit yang telah Anda simpan untuk nanti.</p>
            </a>
        </div>
    </div>

    <!-- Pesanan Terakhir -->
    @if(auth()->user()->orders->count() > 0)
    <div class="mt-5">
        <div class="d-flex justify-content-between align-items-end mb-4">
            <h3 class="fw-bold mb-0" style="font-family: var(--dk-font-heading);">Pesanan Terakhir</h3>
            <a href="{{ route('customer.orders.index') }}" class="text-decoration-none text-muted small fw-bold text-uppercase" style="letter-spacing: 1px;">Lihat Semua <i class="bi bi-arrow-right"></i></a>
        </div>
        
        <div class="d-flex flex-column">
            @foreach(auth()->user()->orders()->latest()->take(3)->get() as $order)
                <div class="d-flex justify-content-between align-items-center py-3 border-bottom" style="border-color: #e0d5cb !important;">
                    <div>
                        <h6 class="fw-bold mb-1">{{ $order->order_number }}</h6>
                        <small class="text-muted">{{ $order->created_at->format('d M Y') }} • {{ $order->items->count() }} Menu</small>
                    </div>
                    <div class="text-end d-flex align-items-center gap-4">
                        <div class="d-none d-md-block">
                            @php
                                $statusColor = match($order->status->value) {
                                    'pending_payment' => '#E36A2E',
                                    'completed' => '#26966F',
                                    'cancelled' => '#DC5252',
                                    default => '#6B6B6B',
                                };
                            @endphp
                            <span class="fw-bold" style="color: {{ $statusColor }}; font-size: 0.85rem;">
                                {{ ucwords(str_replace('_', ' ', $order->status->value)) }}
                            </span>
                        </div>
                        <a href="{{ route('customer.orders.show', $order->order_number) }}" class="btn btn-sm btn-outline-dark rounded-circle" style="width: 35px; height: 35px; padding: 0;">
                            <i class="bi bi-chevron-right"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection

@push('styles')
<style>
    /* Efek Hover pada Menu Grid */
    .group-link:hover {
        background-color: rgba(255, 255, 255, 0.6) !important;
        border-color: var(--dk-primary) !important;
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.03);
    }
    
    .group-link:hover .transition-arrow {
        color: var(--dk-primary) !important;
        transform: translate(3px, -3px);
    }

    .transition-arrow {
        transition: all 0.3s ease;
    }
</style>
@endpush