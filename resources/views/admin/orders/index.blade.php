@extends('layouts.admin')

@section('title', 'Manajemen Pesanan')
@section('page_title', 'Daftar Pesanan')

@section('content')
    <!-- Header Editorial -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">TRANSAKSI</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Daftar Pesanan</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-auto-dismiss border-0 rounded-3 mb-4" style="background-color: rgba(38, 150, 111, 0.1); color: #26966F;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-auto-dismiss border-0 rounded-3 mb-4" style="background-color: rgba(220, 82, 82, 0.1); color: #DC5252;">{{ session('error') }}</div>
    @endif

    <!-- Filter Minimalis -->
    <div class="mb-4">
        <form action="{{ route('admin.orders.index') }}" method="GET" class="d-flex flex-column flex-md-row gap-3 align-items-md-end">
            <div class="flex-grow-1">
                <input type="text" name="search" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" placeholder="Cari No. Pesanan / Nama Pelanggan..." value="{{ request('search') }}" style="border-bottom: 1px solid #ccc !important;">
            </div>
            <div style="width: 200px;">
                <select name="status" class="form-select border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" onchange="this.form.submit()" style="border-bottom: 1px solid #ccc !important;">
                    <option value="">Semua Status</option>
                    @foreach($statuses as $status)
                        <option value="{{ $status->value }}" {{ request('status') == $status->value ? 'selected' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $status->value)) }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-outline-dark px-4 py-2" style="border-radius: 50px;">Filter</button>
        </form>
    </div>

    <!-- Tabel Minimalis -->
    <div class="table-responsive">
        <table class="table align-middle mb-0" style="border-top: 2px solid var(--dk-text);">
            <thead>
                <tr class="text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 1px; border-bottom: 1px solid #e0d5cb;">
                    <th class="py-3 fw-bold">No. Pesanan</th>
                    <th class="py-3 fw-bold">Pelanggan</th>
                    <th class="py-3 fw-bold">Total Tagihan</th>
                    <th class="py-3 fw-bold">Status</th>
                    <th class="py-3 fw-bold">Pembayaran</th>
                    <th class="py-3 fw-bold text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr style="border-bottom: 1px solid #e0d5cb;">
                        <td class="py-3">
                            <div class="fw-bold" style="font-family: var(--dk-font-heading); font-size: 1.05rem;">{{ $order->order_number }}</div>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ $order->created_at->format('d M Y, H:i') }}</small>
                        </td>
                        <td class="py-3 text-muted">{{ $order->customer_name }}</td>
                        <td class="py-3 fw-bold">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                        <td class="py-3">
                            @php
                                $statusColor = match($order->status->value) {
                                    'pending_payment' => '#E36A2E', // Oranye
                                    'paid', 'processing' => '#6B6B6B', // Abu
                                    'ready', 'on_delivery' => '#1A1A1A', // Hitam
                                    'completed' => '#26966F', // Hijau
                                    'cancelled', 'refunded' => '#DC5252', // Merah
                                    default => '#6B6B6B'
                                };
                            @endphp
                            <span class="badge rounded-pill bg-transparent border" style="border-color: {{ $statusColor }} !important; color: {{ $statusColor }}; font-weight: 600;">
                                {{ ucwords(str_replace('_', ' ', $order->status->value)) }}
                            </span>
                        </td>
                        <td class="py-3">
                            @if($order->payment_status->value === 'paid')
                                <span class="text-success fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Lunas</span>
                            @elseif($order->payment_status->value === 'unpaid')
                                <span class="text-warning fw-bold"><i class="bi bi-clock-history me-1"></i> Belum Bayar</span>
                            @else
                                <span class="text-danger fw-bold"><i class="bi bi-x-circle-fill me-1"></i> {{ ucfirst($order->payment_status->value) }}</span>
                            @endif
                        </td>
                        <td class="py-3 text-end">
                            <a href="{{ route('admin.orders.show', $order->order_number) }}" class="btn btn-sm btn-link text-muted p-1" title="Lihat Detail">
                                <i class="bi bi-arrow-right-circle fs-4"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada pesanan yang masuk.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $orders->links('pagination::bootstrap-5') }}
    </div>

    {{-- ================================================= --}}
    {{-- CSS TAMBAHAN UNTUK MENGHILANGKAN BACKGROUND PUTIH --}}
    {{-- ================================================= --}}
    <style>
        /* 1. Menghilangkan background putih pada tabel */
        .table, 
        .table tbody, 
        .table tr, 
        .table td, 
        .table th {
            background-color: transparent !important;
            --bs-table-bg: transparent !important;
            --bs-table-accent-bg: transparent !important;
            box-shadow: none !important;
        }

        /* 2. Memaksa warna background saat select di-klik (dropdown) jadi ikut tema */
        select option {
            background-color: var(--dk-bg, #FBF9F6) !important;
            color: #333 !important;
        }

        /* 3. Pastikan input pencarian transparan */
        input[type="text"] {
            background-color: transparent !important;
        }
    </style>
@endsection