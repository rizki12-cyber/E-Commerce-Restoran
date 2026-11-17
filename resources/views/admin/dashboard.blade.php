
@extends('layouts.admin')

@section('title', 'Admin Dashboard — ' . config('app.name'))
@section('page_title', 'Overview')

@section('content')

<style>
    /* Dashboard Panel - Transparent */
    .dashboard-panel {
        background: transparent !important;
        border: 1px solid #e0d5cb !important;
        border-radius: 16px;
        box-shadow: none !important;
        backdrop-filter: none !important;
        -webkit-backdrop-filter: none !important;
        transition: border-color 0.3s ease;
    }

    /* Table Transparent */
    .dashboard-panel .table,
    .dashboard-panel .table thead,
    .dashboard-panel .table tbody,
    .dashboard-panel .table tr,
    .dashboard-panel .table th,
    .dashboard-panel .table td {
        background-color: transparent !important;
        box-shadow: none !important;
    }

    .dashboard-panel .table tbody tr:hover {
        background-color: rgba(128, 128, 128, 0.04) !important;
    }

    /* Panel Hover */
    .dashboard-panel:hover {
        border-color: #c9b9a9 !important;
    }

    /* Product Image */
    .dashboard-product-image {
        width: 45px;
        height: 45px;
        object-fit: cover;
    }

    /* Chart */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }

    @media (max-width: 576px) {
        .dashboard-panel {
            padding: 1.25rem !important;
        }

        .dashboard-panel h4 {
            font-size: 1.1rem;
        }
    }
</style>


<!-- Header Editorial -->
<div class="d-flex align-items-center gap-3 mb-5 mt-2">
    <span class="text-uppercase fw-bold text-muted"
        style="letter-spacing: 3px; font-size: 0.75rem;">
        RINGKASAN HARI INI
    </span>

    <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
</div>


<!-- Ringkasan Statistik -->
<div class="row g-4 mb-5">

    <div class="col-6 col-md-3">
        <div class="border-start border-3 ps-3 py-1"
            style="border-color: var(--dk-text) !important;">

            <small class="text-muted text-uppercase fw-bold d-block mb-1"
                style="letter-spacing: 1px; font-size: 0.7rem;">
                Total Pendapatan
            </small>

            <h2 class="fw-bold mb-0"
                style="font-family: var(--dk-font-heading); font-size: 1.8rem;">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </h2>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="border-start border-3 ps-3 py-1"
            style="border-color: #ccc !important;">

            <small class="text-muted text-uppercase fw-bold d-block mb-1"
                style="letter-spacing: 1px; font-size: 0.7rem;">
                Total Pesanan
            </small>

            <h2 class="fw-bold mb-0"
                style="font-family: var(--dk-font-heading); font-size: 1.8rem;">
                {{ number_format($totalOrders) }}
            </h2>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="border-start border-3 ps-3 py-1"
            style="border-color: #E36A2E !important;">

            <small class="text-muted text-uppercase fw-bold d-block mb-1"
                style="letter-spacing: 1px; font-size: 0.7rem;">
                Pesanan Pending
            </small>

            <h2 class="fw-bold mb-0"
                style="font-family: var(--dk-font-heading); font-size: 1.8rem;">
                {{ number_format($pendingOrders) }}
            </h2>
        </div>
    </div>

    <div class="col-6 col-md-3">
        <div class="border-start border-3 ps-3 py-1"
            style="border-color: #ccc !important;">

            <small class="text-muted text-uppercase fw-bold d-block mb-1"
                style="letter-spacing: 1px; font-size: 0.7rem;">
                Total Pelanggan
            </small>

            <h2 class="fw-bold mb-0"
                style="font-family: var(--dk-font-heading); font-size: 1.8rem;">
                {{ number_format($totalCustomers) }}
            </h2>
        </div>
    </div>

</div>


<!-- Grafik & Informasi Tambahan -->
<div class="row g-4 mb-5">

    <!-- Performa Penjualan -->
    <div class="col-lg-8">
        <div class="dashboard-panel p-4 h-100">

            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h4 class="fw-bold mb-1"
                        style="font-family: var(--dk-font-heading);">
                        Performa Penjualan
                    </h4>

                    <p class="text-muted small mb-0">
                        Data pendapatan 7 hari terakhir
                    </p>
                </div>

                <i class="bi bi-graph-up-arrow text-muted fs-4"></i>
            </div>

            <div class="chart-container">
                <canvas id="salesChart"></canvas>
            </div>

        </div>
    </div>


    <!-- Informasi Sistem -->
    <div class="col-lg-4">
        <div class="dashboard-panel p-4 h-100 d-flex flex-column">

            <h4 class="fw-bold mb-4"
                style="font-family: var(--dk-font-heading);">
                Informasi Sistem
            </h4>

            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4"
                style="border-color: #e0d5cb !important;">

                <span class="text-muted text-uppercase fw-bold"
                    style="letter-spacing: 1px; font-size: 0.7rem;">
                    Total Produk
                </span>

                <h4 class="mb-0 fw-bold"
                    style="font-family: var(--dk-font-heading);">
                    {{ number_format($totalProducts) }}
                </h4>
            </div>

            <div class="mt-auto">
                <p class="text-muted small mb-0" style="line-height: 1.8;">
                    Selamat datang di Panel Admin
                    <strong class="text-dark">
                        {{ $globalSettings['app_name'] ?? 'CASA RASA' }}
                    </strong>.
                    Kelola operasional toko Anda dengan mudah.
                </p>
            </div>

        </div>
    </div>

</div>


<!-- Pesanan Terbaru & Stok Menipis -->
<div class="row g-4">

    <!-- Pesanan Terbaru -->
    <div class="col-lg-7">
        <div class="dashboard-panel p-4 h-100">

            <div class="d-flex justify-content-between align-items-end mb-4">

                <div>
                    <h5 class="fw-bold mb-1"
                        style="font-family: var(--dk-font-heading);">
                        Pesanan Terbaru
                    </h5>

                    <p class="text-muted small mb-0">
                        5 transaksi terakhir
                    </p>
                </div>

                <a href="{{ route('admin.orders.index') }}"
                    class="btn btn-sm btn-link text-muted text-decoration-none p-0 fw-bold"
                    style="font-size: 0.8rem;">
                    Lihat Semua
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>


            <div class="table-responsive">
                <table class="table align-middle mb-0">

                    <thead>
                        <tr class="text-uppercase text-muted"
                            style="font-size: 0.65rem; letter-spacing: 1px; border-bottom: 1px solid #e0d5cb;">

                            <th class="py-2 fw-bold border-0">No. Pesanan</th>
                            <th class="py-2 fw-bold border-0">Pelanggan</th>
                            <th class="py-2 fw-bold border-0">Total</th>
                            <th class="py-2 fw-bold border-0 text-end">Status</th>

                        </tr>
                    </thead>

                    <tbody>
                        @forelse($recentOrders as $order)

                            <tr style="border-bottom: 1px solid #e0d5cb;">

                                <td class="py-3 fw-bold"
                                    style="font-family: var(--dk-font-heading);">
                                    {{ $order->order_number }}
                                </td>

                                <td class="py-3 text-muted">
                                    {{ $order->customer_name }}
                                </td>

                                <td class="py-3 fw-bold text-dark">
                                    Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                </td>

                                <td class="py-3 text-end">

                                    @php
                                        $statusColor = match($order->status->value) {
                                            'pending_payment' => '#E36A2E',
                                            'completed' => '#26966F',
                                            'cancelled' => '#DC5252',
                                            default => '#6B6B6B',
                                        };
                                    @endphp

                                    <span class="badge border bg-transparent rounded-pill"
                                        style="border-color: {{ $statusColor }} !important; color: {{ $statusColor }}; font-weight: 600; font-size: 0.7rem;">

                                        {{ ucwords(str_replace('_', ' ', $order->status->value)) }}

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="text-center py-4 text-muted">
                                    Belum ada pesanan terbaru.
                                </td>
                            </tr>

                        @endforelse
                    </tbody>

                </table>
            </div>

        </div>
    </div>


    <!-- Stok Menipis -->
    <div class="col-lg-5">
        <div class="dashboard-panel p-4 h-100">

            <div class="d-flex justify-content-between align-items-end mb-4">

                <div>
                    <h5 class="fw-bold mb-1"
                        style="font-family: var(--dk-font-heading);">
                        Stok Menipis
                    </h5>

                    <p class="text-muted small mb-0">
                        Produk yang perlu segera di-restock
                    </p>
                </div>

                <a href="{{ route('admin.products.index') }}"
                    class="btn btn-sm btn-link text-muted text-decoration-none p-0 fw-bold"
                    style="font-size: 0.8rem;">
                    Kelola
                    <i class="bi bi-arrow-right"></i>
                </a>

            </div>


            <div class="d-flex flex-column gap-3">

                @forelse($lowStockProducts as $product)

                    <div class="d-flex align-items-center justify-content-between border-bottom pb-2"
                        style="border-color: #e0d5cb !important;">

                        <div class="d-flex align-items-center gap-3">

                            @if($product->primary_image)

                                <img
                                    src="{{ Storage::url($product->primary_image) }}"
                                    alt="{{ $product->name }}"
                                    class="rounded-2 dashboard-product-image">

                            @else

                                <div class="rounded-2 d-flex align-items-center justify-content-center"
                                    style="width: 45px; height: 45px; background: rgba(128,128,128,0.12);">

                                    <i class="bi bi-box text-muted"></i>

                                </div>

                            @endif

                            <div>
                                <h6 class="fw-bold mb-0" style="font-size: 0.95rem;">
                                    {{ $product->name }}
                                </h6>

                                <small class="text-muted" style="font-size: 0.75rem;">
                                    Min. Stok: {{ $product->min_stock }}
                                </small>
                            </div>

                        </div>

                        <div class="text-end">

                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1"
                                style="font-weight: 700;">
                                Sisa {{ $product->stock }}
                            </span>

                        </div>

                    </div>

                @empty

                    <div class="text-center py-4">
                        <i class="bi bi-check-circle text-success fs-1 mb-2 d-block"></i>

                        <p class="text-muted mb-0">
                            Semua stok produk aman.
                        </p>
                    </div>

                @endforelse

            </div>

        </div>
    </div>

</div>

@endsection


@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const canvas = document.getElementById('salesChart');

        if (!canvas || typeof Chart === 'undefined') {
            return;
        }

        const ctx = canvas.getContext('2d');

        const labels = @json($chartLabels);
        const dataValues = @json($chartValues);

        let gradient = ctx.createLinearGradient(0, 0, 0, 300);

        gradient.addColorStop(0, 'rgba(26, 26, 26, 0.1)');
        gradient.addColorStop(1, 'rgba(26, 26, 26, 0)');

        new Chart(ctx, {
            type: 'line',

            data: {
                labels: labels,

                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: dataValues,

                    borderColor: '#1A1A1A',
                    backgroundColor: gradient,
                    borderWidth: 2,

                    pointBackgroundColor: '#1A1A1A',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,

                    fill: true,
                    tension: 0.4
                }]
            },

            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        display: false
                    },

                    tooltip: {
                        backgroundColor: '#1A1A1A',
                        padding: 12,
                        cornerRadius: 8,

                        titleFont: {
                            family: 'Inter',
                            size: 13
                        },

                        bodyFont: {
                            family: 'Inter',
                            size: 14,
                            weight: 'bold'
                        },

                        callbacks: {
                            label: function(context) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID')
                                    .format(context.parsed.y);
                            }
                        }
                    }
                },

                scales: {
                    x: {
                        grid: {
                            display: false
                        },

                        ticks: {
                            font: {
                                family: 'Inter',
                                size: 11
                            },

                            color: '#6B6B6B'
                        }
                    },

                    y: {
                        beginAtZero: true,

                        border: {
                            display: false
                        },

                        grid: {
                            color: 'rgba(0,0,0,0.05)'
                        },

                        ticks: {
                            font: {
                                family: 'Inter',
                                size: 11
                            },

                            color: '#6B6B6B',

                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID')
                                    .format(value);
                            }
                        }
                    }
                }
            }
        });

    });
</script>
@endpush
