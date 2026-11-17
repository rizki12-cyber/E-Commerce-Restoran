@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran')
@section('page_title', 'Daftar Pembayaran')

@section('content')
    <!-- Header Editorial -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">TRANSAKSI</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Verifikasi Pembayaran</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-auto-dismiss border-0 rounded-3 mb-4" style="background-color: rgba(38, 150, 111, 0.1); color: #26966F;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-auto-dismiss border-0 rounded-3 mb-4" style="background-color: rgba(220, 82, 82, 0.1); color: #DC5252;">{{ session('error') }}</div>
    @endif

    <!-- Tabel Minimalis -->
    <div class="table-responsive">
        <table class="table align-middle mb-0" style="border-top: 2px solid var(--dk-text);">
            <thead>
                <tr class="text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 1px; border-bottom: 1px solid #e0d5cb;">
                    <th class="py-3 fw-bold">No. Pesanan</th>
                    <th class="py-3 fw-bold">Pelanggan</th>
                    <th class="py-3 fw-bold">Metode</th>
                    <th class="py-3 fw-bold">Total Tagihan</th>
                    <th class="py-3 fw-bold">Status</th>
                    <th class="py-3 fw-bold text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($payments as $payment)
                    <tr style="border-bottom: 1px solid #e0d5cb;">
                        <td class="py-3">
                            <div class="fw-bold" style="font-family: var(--dk-font-heading); font-size: 1.05rem;">{{ $payment->order->order_number }}</div>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ $payment->created_at->format('d M Y, H:i') }}</small>
                        </td>
                        <td class="py-3 text-muted">{{ $payment->order->customer_name }}</td>
                        <td class="py-3">
                            <span class="badge border border-secondary text-secondary bg-transparent" style="font-weight: 600;">
                                {{ strtoupper(str_replace('_', ' ', $payment->method->value)) }}
                            </span>
                        </td>
                        <td class="py-3 fw-bold text-dark">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                        <td class="py-3">
                            @if($payment->status->value === 'unpaid')
                                <span class="badge rounded-pill border border-warning text-warning bg-transparent" style="font-weight: 600;">Menunggu</span>
                            @elseif($payment->status->value === 'paid')
                                <span class="badge rounded-pill border border-success text-success bg-transparent" style="font-weight: 600;">Lunas</span>
                            @else
                                <span class="badge rounded-pill border border-danger text-danger bg-transparent" style="font-weight: 600;">Ditolak</span>
                            @endif
                        </td>
                        <td class="py-3 text-end">
                            <a href="{{ route('admin.payments.show', $payment->id) }}" class="btn btn-sm btn-link text-muted p-1" title="Verifikasi">
                                <i class="bi bi-arrow-right-circle fs-4"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">Belum ada bukti pembayaran yang diunggah.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $payments->links('pagination::bootstrap-5') }}
    </div>

    {{-- ================================================= --}}
    {{-- CSS TAMBAHAN UNTUK MENGHILANGKAN BACKGROUND PUTIH --}}
    {{-- ================================================= --}}
    <style>
        /* Memaksa tabel dan seluruh isinya menjadi transparan */
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