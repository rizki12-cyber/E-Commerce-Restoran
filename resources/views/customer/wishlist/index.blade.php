@extends('layouts.app')

@section('title', 'Wishlist — Dapur Kaysan')

@section('content')
<div class="container py-5 my-4">
    
    <!-- Header Editorial -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.8rem;">FAVORIT</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-4 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Wishlist Saya</h1>
        </div>
    </div>

    @if($items->isEmpty())
        <!-- Empty State Minimalis -->
        <div class="text-center py-5 my-5">
            <i class="bi bi-heart text-muted mb-4 d-block" style="font-size: 4rem; opacity: 0.3;"></i>
            <h3 class="fw-bold" style="font-family: var(--dk-font-heading);">Belum Ada Favorit</h3>
            <p class="text-muted mb-4">Simpan hidangan favorit Anda di sini untuk memudahkan pemesanan di lain waktu.</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary px-5 py-2">Jelajahi Menu</a>
        </div>
    @else
        <!-- Grid Produk -->
        <div class="row g-4">
            @foreach($items as $item)
                <div class="col-6 col-md-4 col-lg-3">
                    <div class="product-editorial position-relative">
                        
                        <!-- Gambar Produk -->
                        <a href="{{ route('product.show', $item->product->slug) }}" class="d-block overflow-hidden mb-3" style="border-radius: 12px; aspect-ratio: 4/5;">
                            @if($item->product->primary_image)
                                <img src="{{ Storage::url($item->product->primary_image) }}" class="w-100 h-100 object-fit-cover transition-img" alt="{{ $item->product->name }}">
                            @else
                                <div class="bg-secondary bg-opacity-25 w-100 h-100 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-image text-muted fs-1"></i>
                                </div>
                            @endif
                        </a>

                        <!-- Tombol Hapus (Floating) -->
                        <form action="{{ route('customer.wishlist.toggle') }}" method="POST" class="position-absolute top-0 end-0 m-3">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                            <button type="submit" class="btn btn-sm rounded-circle d-flex align-items-center justify-content-center shadow-sm" 
                                    title="Hapus dari Wishlist" 
                                    style="width: 32px; height: 32px; padding: 0; background: rgba(255, 255, 255, 0.9); backdrop-filter: blur(4px); border: none; transition: all 0.2s;"
                                    onmouseover="this.style.transform='scale(1.1)'" 
                                    onmouseout="this.style.transform='scale(1)'">
                                <i class="bi bi-x-lg text-danger" style="font-size: 0.8rem;"></i>
                            </button>
                        </form>

                        <!-- Info Produk -->
                        <div class="d-flex flex-column">
                            <small class="text-muted text-uppercase mb-1" style="letter-spacing: 2px; font-size: 0.6rem;">
                                {{ $item->product->category->name ?? 'Menu' }}
                            </small>
                            
                            <a href="{{ route('product.show', $item->product->slug) }}" class="text-decoration-none">
                                <h5 class="fw-bold text-dark mb-1 transition-title" style="font-family: var(--dk-font-heading); line-height: 1.3; font-size: 1.1rem;">
                                    {{ $item->product->name }}
                                </h5>
                            </a>
                            
                            <!-- Harga -->
                            <div class="fw-bold mt-2" style="color: var(--dk-primary); font-size: 1rem;">
                                @if($item->product->discount_price)
                                    Rp {{ number_format($item->product->discount_price, 0, ',', '.') }}
                                @else
                                    Rp {{ number_format($item->product->price, 0, ',', '.') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Efek Hover Produk */
    .transition-img {
        transition: transform 0.6s ease;
    }
    .product-editorial:hover .transition-img {
        transform: scale(1.05);
    }
    
    .transition-title {
        transition: color 0.3s ease;
    }
    .product-editorial:hover .transition-title {
        color: var(--dk-primary) !important;
    }
</style>
@endpush