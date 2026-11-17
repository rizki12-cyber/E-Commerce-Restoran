@extends('layouts.app')

@section('title', 'Detail Pesanan ' . $order->order_number . ' — Dapur Kaysan')

@section('content')
<div class="container py-5 my-4">
    
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-end mb-5">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">INVOICE</span>
                <div style="height: 1px; width: 40px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">#{{ $order->order_number }}</h1>
        </div>
        <a href="{{ route('customer.orders.index') }}" class="btn btn-link text-muted text-decoration-none p-0 fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 mb-4" style="background-color: rgba(38, 150, 111, 0.1); color: #26966F;">{{ session('success') }}</div>
    @endif

    <div class="row g-5">
        <!-- Kolom Kiri: Item & Instruksi -->
        <div class="col-lg-7">
            
            <!-- Status Pesanan Minimalis -->
            <div class="d-flex align-items-center justify-content-between border-bottom pb-3 mb-4" style="border-color: #e0d5cb !important;">
                <span class="text-muted text-uppercase" style="letter-spacing: 1px; font-size: 0.75rem;">Status Pesanan</span>
                <span class="fw-bold" style="font-size: 1.1rem; color: {{ $order->status->value === 'completed' ? '#26966F' : '#E36A2E' }};">
                    {{ ucwords(str_replace('_', ' ', $order->status->value)) }}
                </span>
            </div>

            <!-- Instruksi Pembayaran (Jika Belum Bayar) -->
            @if($order->payment_status->value === 'unpaid' && $order->payment_method->value === 'manual_transfer')
                <div class="p-4 mb-5 rounded-3" style="background-color: rgba(255,255,255,0.5); border: 1px dashed #ccc;">
                    <h6 class="fw-bold mb-3" style="font-family: var(--dk-font-heading);">Instruksi Pembayaran</h6>
                    <p class="text-muted mb-3">Silakan transfer tepat sebesar <strong class="text-dark">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong> ke:</p>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-1"><strong>BCA:</strong> 1234567890 <span class="text-muted">(a/n Dapur Kaysan)</span></li>
                        <li><strong>Mandiri:</strong> 0987654321 <span class="text-muted">(a/n Dapur Kaysan)</span></li>
                    </ul>
                    
                    @if($order->payments->first() && $order->payments->first()->proof_image)
                        <div class="alert border-0 rounded-3 mb-0" style="background-color: rgba(38, 150, 111, 0.1); color: #26966F;">
                            <i class="bi bi-clock-history me-1"></i> Bukti pembayaran sudah diunggah. Mohon tunggu verifikasi Admin.
                        </div>
                    @else
                        <form action="{{ route('customer.orders.payment.upload', $order->order_number) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Unggah Bukti (JPG/PNG)</label>
                                <input type="file" name="proof_image" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" required accept="image/*" style="border-bottom: 1px solid #ccc !important;">
                            </div>
                            <button type="submit" class="btn btn-primary px-4 py-2">Kirim Bukti</button>
                        </form>
                    @endif
                </div>
            @endif

            <!-- Daftar Item Pesanan -->
            <h5 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">Rincian Menu</h5>
            <div class="d-flex flex-column gap-3 mb-4">
                @foreach($order->items as $item)
                    <div class="d-flex justify-content-between align-items-start border-bottom pb-3" style="border-color: #e0d5cb !important;">
                        <div>
                            <h6 class="fw-bold mb-1" style="font-size: 1.1rem;">{{ $item->product_name }}</h6>
                            <small class="text-muted d-block">{{ $item->quantity }} x Rp {{ number_format($item->unit_price, 0, ',', '.') }}</small>
                            
                            @if($item->variant_name)
                                <small class="text-muted d-block" style="font-size: 0.8rem;">Varian: {{ $item->variant_name }}</small>
                            @endif
                            @if($item->addon_names)
                                <small class="text-muted d-block" style="font-size: 0.8rem;">Tambahan: {{ implode(', ', $item->addon_names) }}</small>
                            @endif

                            {{-- Tombol Review --}}
                            @if($order->status->value === 'completed')
                                @php $hasReviewed = \App\Models\Review::where('order_item_id', $item->id)->exists(); @endphp
                                @if(!$hasReviewed)
                                    <a href="{{ route('customer.reviews.create', [$order->order_number, $item->id]) }}" class="btn btn-sm btn-link text-decoration-none p-0 mt-2 fw-bold" style="color: var(--dk-primary);">
                                        <i class="bi bi-star me-1"></i> Beri Ulasan
                                    </a>
                                @else
                                    <span class="badge text-success bg-transparent p-0 mt-2"><i class="bi bi-check-circle"></i> Sudah Diulas</span>
                                @endif
                            @endif
                        </div>
                        <span class="fw-bold">Rp {{ number_format($item->line_total, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            </div>

        </div>

        <!-- Kolom Kanan: Ringkasan Pembayaran (Kaca) -->
        <div class="col-lg-5">
            <div class="p-4 sticky-top" style="top: 100px; background-color: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                <h4 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">Ringkasan</h4>
                
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-bold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Ongkos Kirim</span>
                    <span class="fw-bold">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Diskon ({{ $order->voucher_code }})</span>
                        <span class="fw-bold">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                    </div>
                @endif
                
                <hr style="border-color: #e0d5cb; opacity: 1;">
                
                <div class="d-flex justify-content-between mb-4 align-items-center">
                    <span class="fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.85rem;">Total</span>
                    <span class="fw-bold" style="color: var(--dk-primary); font-size: 1.8rem; font-family: var(--dk-font-heading);">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </span>
                </div>
                
                <div class="pt-3 border-top" style="border-color: #e0d5cb !important;">
                    <small class="text-muted d-block mb-1">Metode Pembayaran</small>
                    <span class="fw-bold text-uppercase" style="font-size: 0.85rem;">
                        {{ strtoupper(str_replace('_', ' ', $order->payment_method->value)) }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection