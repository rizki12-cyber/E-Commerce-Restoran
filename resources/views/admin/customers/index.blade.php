@extends('layouts.admin')

@section('title', 'Manajemen Pelanggan')
@section('page_title', 'Daftar Pelanggan')

@section('content')
    <!-- Header Editorial -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">DATA PELANGGAN</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Pelanggan</h1>
        </div>
    </div>

    <!-- Tabel Minimalis -->
    <div class="table-responsive">
        <table class="table align-middle mb-0" style="border-top: 2px solid var(--dk-text);">
            <thead>
                <tr class="text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 1px; border-bottom: 1px solid #e0d5cb;">
                    <th class="py-3 fw-bold">Nama Pelanggan</th>
                    <th class="py-3 fw-bold">Kontak (Email & HP)</th>
                    <th class="py-3 fw-bold text-center">Total Pesanan</th>
                    <th class="py-3 fw-bold text-end">Total Belanja</th>
                    <th class="py-3 fw-bold text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customers as $customer)
                    <tr style="border-bottom: 1px solid #e0d5cb;">
                        <td class="py-3">
                            <div class="d-flex align-items-center gap-3">
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width: 40px; height: 40px; font-family: var(--dk-font-heading);">
                                    {{ substr($customer->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="fw-bold" style="font-family: var(--dk-font-heading); font-size: 1.05rem;">{{ $customer->name }}</div>
                                    <small class="text-muted" style="font-size: 0.75rem;">Terdaftar: {{ $customer->created_at->format('d M Y') }}</small>
                                </div>
                            </div>
                        </td>
                        <td class="py-3">
                            <div class="small mb-1">{{ $customer->email }}</div>
                            <!-- NOMOR TELEPON DITAMPILKAN DI SINI -->
                            <div class="small text-muted">
                                <i class="bi bi-telephone me-1"></i> {{ $customer->phone ?? 'Belum ada nomor' }}
                            </div>
                        </td>
                        <td class="py-3 text-center">
                            <span class="badge border border-secondary text-secondary bg-transparent rounded-pill" style="font-weight: 600;">
                                {{ $customer->orders_count }} Pesanan
                            </span>
                        </td>
                        <td class="py-3 text-end fw-bold" style="color: var(--dk-primary);">
                            Rp {{ number_format($customer->orders_sum_total_amount ?? 0, 0, ',', '.') }}
                        </td>
                        <td class="py-3 text-end">
                            <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-sm btn-link text-muted p-1" title="Lihat Profil">
                                <i class="bi bi-arrow-right-circle fs-4"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">Belum ada pelanggan yang terdaftar.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $customers->links('pagination::bootstrap-5') }}
    </div>

    {{-- ================================================= --}}
    {{-- CSS TAMBAHAN UNTUK MENGHILANGKAN BACKGROUND PUTIH --}}
    {{-- ================================================= --}}
    <style>
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
    </style>
@endsection