@extends('layouts.app')

@section('title', 'Checkout — Dapur Kaysan')

@section('content')
<div class="container py-5 my-4">
    
    <!-- Header Editorial -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.8rem;">LANGKAH TERAKHIR</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-4 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Konfirmasi Pesanan</h1>
        </div>
    </div>

    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-3 mb-4" style="background-color: rgba(220, 82, 82, 0.1); color: #DC5252;">{{ session('error') }}</div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger border-0 rounded-3 mb-4" style="background-color: rgba(220, 82, 82, 0.1); color: #DC5252;">
            <ul class="mb-0 small">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('customer.checkout.store') }}" method="POST">
        @csrf
        <div class="row g-5">
            <!-- Kolom Kiri: Form Data -->
            <div class="col-lg-7">
                
                <!-- Informasi Pelanggan -->
                <div class="mb-5">
                    <h4 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">01. Informasi Pelanggan</h4>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Nama Lengkap Penerima</label>
                            <input type="text" name="customer_name" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ auth()->user()->name }}" required style="border-bottom: 1px solid #ccc !important;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Nomor WhatsApp</label>
                            <input type="text" name="customer_phone" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ auth()->user()->phone }}" required placeholder="08xxxxxxxxxx" style="border-bottom: 1px solid #ccc !important;">
                        </div>
                    </div>
                </div>

                <!-- Metode Pengambilan / Pengiriman -->
                <div class="mb-5 pb-4 border-bottom" style="border-color: #e0d5cb !important;">
                    <h4 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">02. Metode Pengiriman</h4>
                    
                    <div class="d-flex flex-column gap-3 mb-4">
                        <div class="form-check">
                            <input class="form-check-input shadow-none" type="radio" name="shipping_method" id="method_pickup" value="pickup" checked>
                            <label class="form-check-label fw-medium ms-2" for="method_pickup">
                                Ambil Sendiri di Toko <span class="text-muted small">(Gratis)</span>
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input shadow-none" type="radio" name="shipping_method" id="method_delivery" value="delivery">
                            <label class="form-check-label fw-medium ms-2" for="method_delivery">
                                Kirim ke Alamat <span class="text-muted small">(+ Rp 10.000)</span>
                            </label>
                        </div>
                    </div>

                    <div id="address_form" style="display: none;">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Alamat Lengkap Pengiriman</label>
                        <textarea name="shipping_address" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" rows="2" placeholder="Nama jalan, RT/RW, Kelurahan, Kecamatan, Kota..." style="border-bottom: 1px solid #ccc !important;"></textarea>
                    </div>
                </div>

                <!-- Metode Pembayaran -->
                <div class="mb-5">
                    <h4 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">03. Metode Pembayaran</h4>
                    
                    <div class="d-flex flex-column gap-3 mb-4">
                        <div class="form-check">
                            <input class="form-check-input shadow-none" type="radio" name="payment_method" id="pay_transfer" value="manual_transfer" checked>
                            <label class="form-check-label fw-medium ms-2" for="pay_transfer">
                                <i class="bi bi-bank me-1 text-muted"></i> Transfer Bank Manual
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input shadow-none" type="radio" name="payment_method" id="pay_cod" value="cod">
                            <label class="form-check-label fw-medium ms-2" for="pay_cod">
                                <i class="bi bi-cash-coin me-1 text-muted"></i> Cash on Delivery (COD)
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Catatan Tambahan (Opsional)</label>
                        <textarea name="notes" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" rows="2" placeholder="Contoh: Pedasnya dipisah, tolong dibungkus rapi..." style="border-bottom: 1px solid #ccc !important;"></textarea>
                    </div>
                </div>

            </div>

            <!-- Kolom Kanan: Ringkasan -->
            <div class="col-lg-5">
                <!-- Desain Ringkasan Kaca (Glassmorphism) -->
                <div class="p-4 sticky-top" style="top: 100px; background-color: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                    <h4 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">Ringkasan Pesanan</h4>
                    
                    <ul class="list-unstyled mb-4">
                        @foreach($cart->items as $item)
                            @php
                                $basePrice = $item->product->discount_price ?? $item->product->price;
                                $variantPrice = $item->variant ? $item->variant->additional_price : 0;
                                $addonPrice = 0;
                                $addonNames = [];
                                if ($item->addon_ids) {
                                    $addons = \App\Models\ProductAddon::whereIn('id', $item->addon_ids)->get();
                                    foreach ($addons as $addon) {
                                        $addonPrice += $addon->price;
                                        $addonNames[] = $addon->name;
                                    }
                                }
                                $finalPricePerItem = $basePrice + $variantPrice + $addonPrice;
                            @endphp
                            <li class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom" style="border-color: #e0d5cb !important;">
                                <div>
                                    <h6 class="mb-1 fw-bold" style="font-family: var(--dk-font-heading); font-size: 1.05rem;">{{ $item->product->name }}</h6>
                                    <small class="text-muted d-block" style="font-size: 0.8rem;">
                                        {{ $item->quantity }} x Rp {{ number_format($finalPricePerItem, 0, ',', '.') }}
                                    </small>
                                    @if($item->variant)
                                        <small class="text-muted d-block" style="font-size: 0.75rem;">Varian: {{ $item->variant->name }}</small>
                                    @endif
                                    @if(count($addonNames) > 0)
                                        <small class="text-muted d-block" style="font-size: 0.75rem;">Add-on: {{ implode(', ', $addonNames) }}</small>
                                    @endif
                                </div>
                                <span class="fw-bold text-dark">Rp {{ number_format($finalPricePerItem * $item->quantity, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>

                    <!-- KOLOM VOUCHER -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Punya Kode Voucher?</label>
                        <input type="text" name="voucher_code" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" placeholder="Masukkan kode voucher" value="{{ old('voucher_code') }}" style="border-bottom: 1px solid #ccc !important;">
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3 pb-3 border-bottom" style="border-color: #e0d5cb !important;">
                        <span class="text-muted">Ongkos Kirim</span>
                        <span class="fw-bold" id="shipping_cost_display">Rp 0</span>
                    </div>
                    
                    <div class="d-flex justify-content-between mb-4 align-items-center mt-4">
                        <span class="fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.85rem;">Total Pembayaran</span>
                        <span class="fw-bold" style="color: var(--dk-primary); font-size: 1.8rem; font-family: var(--dk-font-heading);" id="total_display">
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 py-3 d-flex justify-content-center align-items-center gap-2">
                        Buat Pesanan <i class="bi bi-arrow-right"></i>
                    </button>
                    
                    <p class="text-center text-muted small mt-3 mb-0"><i class="bi bi-shield-lock me-1"></i> Transaksi Aman & Terenkripsi</p>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const subtotal = {{ $subtotal }};
        const methodDelivery = document.getElementById('method_delivery');
        const methodPickup = document.getElementById('method_pickup');
        const addressForm = document.getElementById('address_form');
        const shippingDisplay = document.getElementById('shipping_cost_display');
        const totalDisplay = document.getElementById('total_display');

        function updateShipping() {
            if (methodDelivery.checked) {
                addressForm.style.display = 'block';
                shippingDisplay.textContent = 'Rp 10.000';
                totalDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal + 10000);
            } else {
                addressForm.style.display = 'none';
                shippingDisplay.textContent = 'Rp 0';
                totalDisplay.textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(subtotal);
            }
        }

        methodDelivery.addEventListener('change', updateShipping);
        methodPickup.addEventListener('change', updateShipping);
        
        updateShipping();
    });
</script>
@endpush