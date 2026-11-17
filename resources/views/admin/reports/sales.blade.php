@extends('layouts.admin')

@section('title', 'Laporan Penjualan')
@section('page_title', 'Laporan Penjualan')

@section('content')
    <!-- Header Editorial -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">SISTEM</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Laporan Penjualan</h1>
        </div>
    </div>

    <!-- Filter Tanggal (Warna Putih Dihilangkan) -->
    <div class="p-4 mb-5" style="background-color: transparent !important; border: 1px solid #e0d5cb; border-radius: 16px;">
        <form action="{{ route('admin.reports.sales') }}" method="GET" class="row g-4 align-items-end">
            <div class="col-md-4">
                <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Tanggal Mulai</label>
                <input type="date" name="start_date" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ $startDate }}" required style="border-bottom: 1px solid #ccc !important;">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Tanggal Akhir</label>
                <input type="date" name="end_date" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ $endDate }}" required style="border-bottom: 1px solid #ccc !important;">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary w-100 py-2">Tampilkan Laporan</button>
            </div>
        </form>
    </div>

    <!-- Ringkasan Statistik (Gaya Editorial) -->
    <div class="row g-4 mb-5 pb-3">
        <div class="col-md-6">
            <div class="border-start border-3 ps-3 py-1" style="border-color: var(--dk-text) !important;">
                <small class="text-muted text-uppercase fw-bold d-block mb-1" style="letter-spacing: 1px; font-size: 0.7rem;">Total Pendapatan (Lunas)</small>
                <h2 class="fw-bold mb-0" style="font-family: var(--dk-font-heading); font-size: 2.2rem;">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </h2>
            </div>
        </div>
        <div class="col-md-6">
            <div class="border-start border-3 ps-3 py-1" style="border-color: #ccc !important;">
                <small class="text-muted text-uppercase fw-bold d-block mb-1" style="letter-spacing: 1px; font-size: 0.7rem;">Total Transaksi</small>
                <h2 class="fw-bold mb-0" style="font-family: var(--dk-font-heading); font-size: 2.2rem;">
                    {{ number_format($totalOrders) }} <span style="font-size: 1rem; font-family: var(--dk-font-body); font-weight: 400; color: #6B6B6B;">Pesanan</span>
                </h2>
            </div>
        </div>
    </div>

    <div class="row g-5">
        <!-- Top Produk (Gaya List Bersih) -->
        <div class="col-lg-4">
            <div class="d-flex align-items-center gap-3 mb-4">
                <h5 class="fw-bold mb-0" style="font-family: var(--dk-font-heading);">5 Produk Terlaris</h5>
                <div class="flex-grow-1" style="height: 1px; background-color: #e0d5cb;"></div>
            </div>
            
            <div class="d-flex flex-column">
                @forelse($topProducts as $product)
                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom" style="border-color: #e0d5cb !important;">
                        <div>
                            <h6 class="fw-bold mb-1" style="font-size: 1rem;">{{ $product->product_name }}</h6>
                            <small class="text-muted" style="font-size: 0.75rem;">Terjual: {{ $product->total_qty }} pcs</small>
                        </div>
                        <span class="fw-bold" style="color: var(--dk-text);">Rp {{ number_format($product->total_revenue, 0, ',', '.') }}</span>
                    </div>
                @empty
                    <div class="py-4 text-muted text-center border-bottom" style="border-color: #e0d5cb !important;">Belum ada data penjualan.</div>
                @endforelse
            </div>
        </div>

        <!-- Tabel Transaksi (Tanpa Kotak) -->
        <div class="col-lg-8">
            <div class="d-flex align-items-center gap-3 mb-4">
                <h5 class="fw-bold mb-0" style="font-family: var(--dk-font-heading);">Rincian Transaksi</h5>
                <div class="flex-grow-1" style="height: 1px; background-color: #e0d5cb;"></div>
            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0" style="border-top: 2px solid var(--dk-text);">
                    <thead>
                        <tr class="text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 1px; border-bottom: 1px solid #e0d5cb;">
                            <th class="py-3 fw-bold">No. Pesanan</th>
                            <th class="py-3 fw-bold">Pelanggan</th>
                            <th class="py-3 fw-bold">Total Tagihan</th>
                            <th class="py-3 fw-bold text-end">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ordersList as $order)
                            <tr style="border-bottom: 1px solid #e0d5cb;">
                                <td class="py-3 fw-bold" style="font-family: var(--dk-font-heading);">{{ $order->order_number }}</td>
                                <td class="py-3 text-muted">{{ $order->customer_name }}</td>
                                <td class="py-3 fw-bold text-dark">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                <td class="py-3 text-end text-muted" style="font-size: 0.85rem;">{{ $order->created_at->format('d M Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">Tidak ada transaksi pada periode ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4">
                {{ $ordersList->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- CSS TAMBAHAN UNTUK MENGHILANGKAN BACKGROUND PUTIH --}}
    {{-- ================================================= --}}
    <style>
        /* 1. Memaksa tabel rincian transaksi menjadi transparan */
        .table, 
        .table tbody, 
        .table tr, 
        .table td, 
        .table th,
        .table thead {
            background-color: transparent !important;
            --bs-table-bg: transparent !important;
            --bs-table-accent-bg: transparent !important;
            --bs-table-hover-bg: transparent !important;
            --bs-table-striped-bg: transparent !important;
            box-shadow: none !important;
        }

        /* 2. Memastikan input tanggal tidak memiliki background putih */
        input[type="date"] {
            background-color: transparent !important;
        }
    </style>
@endsection