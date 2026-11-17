@extends('layouts.admin')

@section('title', 'Profil Pelanggan')
@section('page_title', 'Profil Pelanggan')

@section('content')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">PELANGGAN</span>
                <div style="height: 1px; width: 40px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Profil Pelanggan</h1>
        </div>
        <a href="{{ route('admin.customers.index') }}" class="btn btn-link text-muted text-decoration-none p-0 fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row g-5">
        <!-- Kolom Kiri: Kartu Profil (Warna Putih Dihilangkan) -->
        <div class="col-lg-4">
            <div class="p-4 h-100 text-center" style="background-color: transparent !important; border: 1px solid #e0d5cb; border-radius: 16px;">
                
                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold mx-auto mb-3 shadow" style="width: 90px; height: 90px; font-size: 2.5rem; font-family: var(--dk-font-heading);">
                    {{ substr($user->name, 0, 1) }}
                </div>
                
                <h4 class="fw-bold mb-1" style="font-family: var(--dk-font-heading);">{{ $user->name }}</h4>
                <p class="text-muted small mb-4">Bergabung sejak {{ $user->created_at->format('d F Y') }}</p>
                
                <div class="text-start mt-4">
                    <div class="border-bottom pb-3 mb-3" style="border-color: #e0d5cb !important;">
                        <small class="text-muted text-uppercase d-block mb-1" style="letter-spacing: 1px; font-size: 0.65rem;">Email</small>
                        <span class="fw-medium text-dark">{{ $user->email }}</span>
                    </div>
                    
                    <div class="border-bottom pb-3 mb-3" style="border-color: #e0d5cb !important;">
                        <small class="text-muted text-uppercase d-block mb-1" style="letter-spacing: 1px; font-size: 0.65rem;">Nomor Telepon</small>
                        <!-- NOMOR TELEPON DITAMPILKAN DI SINI -->
                        <span class="fw-bold text-dark">{{ $user->phone ?? 'Belum diisi' }}</span>
                    </div>

                    <div>
                        <small class="text-muted text-uppercase d-block mb-1" style="letter-spacing: 1px; font-size: 0.65rem;">Total Belanja</small>
                        <span class="fw-bold" style="color: var(--dk-primary); font-size: 1.5rem; font-family: var(--dk-font-heading);">
                            Rp {{ number_format($totalSpent, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Riwayat Pesanan (Warna Putih Dihilangkan) -->
        <div class="col-lg-8">
            <div class="p-4 h-100" style="background-color: transparent !important; border: 1px solid #e0d5cb; border-radius: 16px;">
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <h5 class="fw-bold mb-0" style="font-family: var(--dk-font-heading);">Riwayat Pesanan</h5>
                    <span class="text-muted small">Total {{ $orders->count() }} transaksi</span>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr class="text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 1px; border-bottom: 1px solid #e0d5cb;">
                                <th class="py-3 fw-bold border-0">No. Pesanan</th>
                                <th class="py-3 fw-bold border-0">Total</th>
                                <th class="py-3 fw-bold border-0">Status</th>
                                <th class="py-3 fw-bold border-0 text-end">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($orders as $order)
                                <tr style="border-bottom: 1px solid #e0d5cb;">
                                    <td class="py-3 fw-bold" style="font-family: var(--dk-font-heading);">{{ $order->order_number }}</td>
                                    <td class="py-3 fw-bold text-dark">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                                    <td class="py-3">
                                        @php
                                            $statusColor = match($order->status->value) {
                                                'pending_payment' => '#E36A2E',
                                                'completed' => '#26966F',
                                                'cancelled' => '#DC5252',
                                                default => '#6B6B6B',
                                            };
                                        @endphp
                                        <span class="badge border bg-transparent rounded-pill" style="border-color: {{ $statusColor }} !important; color: {{ $statusColor }}; font-weight: 600;">
                                            {{ ucwords(str_replace('_', ' ', $order->status->value)) }}
                                        </span>
                                    </td>
                                    <td class="py-3 text-end text-muted">{{ $order->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">Pelanggan ini belum memiliki riwayat pesanan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- ================================================= --}}
    {{-- CSS TAMBAHAN UNTUK MENGHILANGKAN BACKGROUND PUTIH --}}
    {{-- ================================================= --}}
    <style>
        /* 1. Mematikan background putih pada kotak pembungkus (card) */
        .col-lg-8 > .p-4 {
            background: transparent !important;
            box-shadow: none !important;
        }

        /* 2. Memaksa tabel, baris, dan sel menjadi transparan (termasuk saat di-hover) */
        .table,
        .table-responsive,
        .table thead,
        .table tbody,
        .table tr,
        .table td,
        .table th {
            background-color: transparent !important;
            --bs-table-bg: transparent !important;
            --bs-table-accent-bg: transparent !important;
            --bs-table-hover-bg: transparent !important;
            --bs-table-striped-bg: transparent !important;
            box-shadow: none !important;
        }

        /* 3. Memastikan efek hover pada baris tabel tidak memunculkan warna putih/abu-abu */
        .table-hover > tbody > tr:hover > * {
            background-color: transparent !important;
            --bs-table-accent-bg: transparent !important;
        }
    </style>
@endsection