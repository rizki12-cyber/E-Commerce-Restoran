@extends('layouts.app')

@section('title', 'Pesanan Saya — Dapur Kaysan')

@section('content')
<div class="container py-5 my-4">
    
    <!-- Header Editorial -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.8rem;">RIWAYAT</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-4 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Pesanan Saya</h1>
        </div>
    </div>

    @if($orders->isEmpty())
        <!-- Empty State Minimalis -->
        <div class="text-center py-5 my-5">
            <i class="bi bi-receipt text-muted mb-4 d-block" style="font-size: 4rem; opacity: 0.3;"></i>
            <h3 class="fw-bold" style="font-family: var(--dk-font-heading);">Belum Ada Transaksi</h3>
            <p class="text-muted mb-4">Anda belum pernah melakukan pemesanan di Dapur Kaysan.</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary px-5 py-2">Mulai Belanja</a>
        </div>
    @else
        <!-- Daftar Pesanan (Gaya Ledger/Buku Besar) -->
        <div class="d-flex flex-column">
            @foreach($orders as $order)
                <div class="border-bottom py-4" style="border-color: #e0d5cb !important; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='rgba(255,255,255,0.4)'" onmouseout="this.style.backgroundColor='transparent'">
                    <div class="row align-items-center g-3">
                        
                        <!-- Kiri: Info Pesanan -->
                        <div class="col-md-4">
                            <small class="text-muted text-uppercase" style="letter-spacing: 2px; font-size: 0.65rem;">
                                {{ $order->created_at->format('d M Y, H:i') }}
                            </small>
                            <h4 class="fw-bold mb-1 mt-1" style="font-family: var(--dk-font-heading);">
                                {{ $order->order_number }}
                            </h4>
                            <p class="text-muted small mb-0">{{ $order->items->count() }} Item Menu</p>
                        </div>

                        <!-- Tengah: Status -->
                        <div class="col-md-3 text-md-center">
                            @php
                                $statusColor = match($order->status->value) {
                                    'pending_payment' => '#E36A2E', // Oranye (Primary)
                                    'completed' => '#26966F',       // Hijau
                                    'cancelled' => '#DC5252',       // Merah
                                    default => '#6B6B6B',           // Abu-abu
                                };
                            @endphp
                            <span class="badge rounded-pill px-3 py-2 fw-medium" 
                                  style="background-color: transparent; border: 1px solid {{ $statusColor }}; color: {{ $statusColor }};">
                                {{ ucwords(str_replace('_', ' ', $order->status->value)) }}
                            </span>
                        </div>

                        <!-- Kanan: Total & Aksi -->
                        <div class="col-md-5 text-md-end">
                            <div class="d-flex flex-column flex-md-row justify-content-md-end align-items-md-center gap-3">
                                <div>
                                    <small class="text-muted d-block" style="font-size: 0.75rem;">Total Tagihan</small>
                                    <h4 class="fw-bold mb-0" style="color: var(--dk-primary); font-family: var(--dk-font-heading);">
                                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                                    </h4>
                                </div>
                                <a href="{{ route('customer.orders.show', $order->order_number) }}" class="btn btn-outline-dark px-4 py-2" style="border-radius: 50px;">
                                    Detail <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                            </div>
                        </div>
                        
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-5 d-flex justify-content-center">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>
@endsection