@extends('layouts.app')

@section('title', 'Keranjang Belanja — Dapur Kaysan')

@section('content')
<div class="container py-5 my-4">
    
    <!-- Header Editorial -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.8rem;">PESANAN ANDA</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-4 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Keranjang Belanja</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 rounded-3 alert-auto-dismiss mb-4" style="background-color: rgba(38, 150, 111, 0.1); color: #26966F;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger border-0 rounded-3 alert-auto-dismiss mb-4" style="background-color: rgba(220, 82, 82, 0.1); color: #DC5252;">{{ session('error') }}</div>
    @endif

    @if($cart->items->isEmpty())
        <!-- Empty State Minimalis -->
        <div class="text-center py-5 my-5">
            <i class="bi bi-bag-x text-muted mb-4 d-block" style="font-size: 4rem; opacity: 0.3;"></i>
            <h3 class="fw-bold" style="font-family: var(--dk-font-heading);">Keranjang Kosong</h3>
            <p class="text-muted mb-4">Sepertinya Anda belum menambahkan hidangan lezat apa pun.</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary px-5 py-2">Mulai Belanja</a>
        </div>
    @else
        <div class="row g-5">
            <!-- Daftar Item -->
            <div class="col-lg-8">
                <div class="d-flex flex-column gap-4">
                    @foreach($cart->items as $item)
                        @php
                            // Hitung harga per item (termasuk varian dan addon)
                            $basePrice = $item->product->discount_price ?? $item->product->price;
                            $variantPrice = $item->variant ? $item->variant->additional_price : 0;
                            $addonPrice = 0;
                            if ($item->addon_ids) {
                                $addons = \App\Models\ProductAddon::whereIn('id', $item->addon_ids)->get();
                                foreach ($addons as $addon) {
                                    $addonPrice += $addon->price;
                                }
                            }
                            $finalPricePerItem = $basePrice + $variantPrice + $addonPrice;
                        @endphp

                        <div class="d-flex align-items-center border-bottom pb-4 gap-3 gap-md-4">
                            <!-- Gambar -->
                            <div style="width: 100px; height: 100px; flex-shrink: 0; overflow: hidden; border-radius: 12px;">
                                @if($item->product->primary_image)
                                    <img src="{{ Storage::url($item->product->primary_image) }}" class="w-100 h-100" style="object-fit: cover;">
                                @else
                                    <div class="bg-secondary bg-opacity-25 w-100 h-100 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image text-muted fs-3"></i>
                                    </div>
                                @endif
                            </div>

                            <!-- Info -->
                            <div class="flex-grow-1">
                                <small class="text-muted text-uppercase" style="letter-spacing: 1px; font-size: 0.6rem;">{{ $item->product->category->name }}</small>
                                <h5 class="fw-bold mb-1" style="font-family: var(--dk-font-heading); font-size: 1.2rem;">{{ $item->product->name }}</h5>
                                
                                @if($item->variant)
                                    <small class="text-muted d-block" style="font-size: 0.8rem;">Varian: {{ $item->variant->name }}</small>
                                @endif
                                @if($item->addon_ids)
                                    <small class="text-muted d-block" style="font-size: 0.8rem;">Tambahan: 
                                        @foreach(\App\Models\ProductAddon::whereIn('id', $item->addon_ids)->get() as $addon)
                                            {{ $addon->name }}@if(!$loop->last), @endif
                                        @endforeach
                                    </small>
                                @endif
                                
                                <span class="fw-bold mt-2 d-block" style="color: var(--dk-primary); font-size: 1.1rem;">
                                    Rp {{ number_format($finalPricePerItem, 0, ',', '.') }}
                                </span>
                            </div>

                            <!-- Aksi & Subtotal -->
                            <div class="text-end d-flex flex-column justify-content-between h-100" style="min-height: 80px;">
                                <form action="{{ route('customer.cart.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="number" name="quantity" class="form-control border-0 border-bottom rounded-0 px-0 text-center bg-transparent shadow-none fw-bold" value="{{ $item->quantity }}" min="1" style="width: 60px; border-bottom: 1px solid #ccc !important; font-size: 1.1rem;" onchange="this.form.submit()">
                                </form>
                                <form action="{{ route('customer.cart.destroy', $item->id) }}" method="POST" class="mt-3">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-link text-muted text-decoration-none p-0" style="font-size: 0.8rem; transition: color 0.2s;" onmouseover="this.style.color='#DC5252'" onmouseout="this.style.color='#6B6B6B'">
                                        <i class="bi bi-trash me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Ringkasan Belanja -->
            <div class="col-lg-4">
                <div class="p-4 sticky-top" style="top: 100px; background-color: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                    <h4 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">Ringkasan</h4>
                    
                    <div class="d-flex justify-content-between mb-3">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    
                    <p class="text-muted small mb-4">Ongkos kirim dan potongan voucher akan dihitung pada halaman checkout.</p>
                    <hr style="border-color: #e0d5cb; opacity: 1;">
                    
                    <div class="d-flex justify-content-between mb-4 align-items-center">
                        <span class="fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.85rem;">Total Sementara</span>
                        <span class="fw-bold" style="color: var(--dk-primary); font-size: 1.8rem; font-family: var(--dk-font-heading);">
                            Rp {{ number_format($subtotal, 0, ',', '.') }}
                        </span>
                    </div>
                    
                    <a href="{{ route('customer.checkout.index') }}" class="btn btn-primary w-100 py-3 d-flex justify-content-center align-items-center gap-2">
                        Lanjut ke Pembayaran <i class="bi bi-arrow-right"></i>
                    </a>                    
                </div>
            </div>
        </div>
    @endif
</div>
@endsection