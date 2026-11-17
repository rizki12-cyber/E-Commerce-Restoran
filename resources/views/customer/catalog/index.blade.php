@extends('layouts.app')

@section('title', 'Menu Makanan — Dapur Kaysan')

@section('content')
<div class="container py-5 my-4">
    
    <!-- Header Editorial -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.8rem;">KATALOG</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-4 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Pilihan Menu</h1>
        </div>
    </div>

    <div class="row g-5">
        <!-- Sidebar Filter Minimalis -->
        <div class="col-lg-3">
            <div class="sticky-top" style="top: 100px; z-index: 10;">
                <form action="{{ route('catalog.index') }}" method="GET">
                    
                    <!-- Search -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Pencarian</label>
                        <input type="text" name="search" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" placeholder="Ketik nama makanan..." value="{{ request('search') }}" style="border-bottom: 1px solid #ccc !important;">
                    </div>

                    <!-- Kategori -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Kategori</label>
                        <select name="category" class="form-select border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" style="border-bottom: 1px solid #ccc !important;">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Harga -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Rentang Harga</label>
                        <div class="d-flex gap-3">
                            <input type="number" name="min_price" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none text-center" placeholder="Min" value="{{ request('min_price') }}" style="border-bottom: 1px solid #ccc !important;">
                            <span class="align-self-center text-muted">-</span>
                            <input type="number" name="max_price" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none text-center" placeholder="Max" value="{{ request('max_price') }}" style="border-bottom: 1px solid #ccc !important;">
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-5">
                        <button type="submit" class="btn btn-primary py-2">Terapkan Filter</button>
                        <a href="{{ route('catalog.index') }}" class="btn btn-link text-muted text-decoration-none small">Reset Pencarian</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Daftar Produk -->
        <div class="col-lg-9">
            
            <!-- Toolbar (Sorting) -->
            <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom" style="border-color: #e0d5cb !important;">
                <p class="text-muted mb-0 small">Menampilkan <strong>{{ $products->total() }}</strong> menu</p>
                <form action="{{ route('catalog.index') }}" method="GET" class="d-flex align-items-center gap-2">
                    @foreach(request()->except('sort') as $key => $value)
                        <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                    @endforeach
                    <label class="text-nowrap small fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Urutkan:</label>
                    <select name="sort" class="form-select form-select-sm border-0 bg-transparent fw-bold shadow-none" onchange="this.form.submit()" style="width: auto; cursor: pointer; color: var(--dk-primary);">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Harga Terendah</option>
                        <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Harga Tertinggi</option>
                        <option value="best_seller" {{ request('sort') == 'best_seller' ? 'selected' : '' }}>Terlaris</option>
                    </select>
                </form>
            </div>

            <!-- Grid Produk -->
            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-6 col-md-4">
                        <div class="product-editorial position-relative">
                            <!-- Gambar -->
                            <a href="{{ route('product.show', $product->slug) }}" class="d-block overflow-hidden mb-3" style="border-radius: 12px; aspect-ratio: 4/5;">
                                @if($product->primary_image)
                                    <img src="{{ Storage::url($product->primary_image) }}" class="w-100 h-100 object-fit-cover transition-img" alt="{{ $product->name }}">
                                @else
                                    <div class="bg-secondary bg-opacity-25 w-100 h-100 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image text-muted fs-1"></i>
                                    </div>
                                @endif
                            </a>

                            <!-- Badge Promo -->
                            @if($product->discount_price)
                                <span class="position-absolute top-0 start-0 m-3 fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px; color: var(--dk-primary);">Promo</span>
                            @endif
                            
                            <!-- Info -->
                            <div class="d-flex flex-column">
                                {{-- ✅ FIX: null-safe operator + fallback text --}}
                                <small class="text-muted text-uppercase mb-1" style="letter-spacing: 2px; font-size: 0.6rem;">
                                    {{ $product->category?->name ?? 'Tanpa Kategori' }}
                                </small>
                                
                                <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none">
                                    <h5 class="fw-bold text-dark mb-1 transition-title" style="font-family: var(--dk-font-heading); line-height: 1.3; font-size: 1.1rem;">
                                        {{ $product->name }}
                                    </h5>
                                </a>

                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div>
                                        @if($product->discount_price)
                                            <div class="text-muted small text-decoration-line-through" style="font-size: 0.75rem;">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </div>
                                            <div class="fw-bold" style="color: var(--dk-primary); font-size: 1rem;">
                                                Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                            </div>
                                        @else
                                            <div class="fw-bold" style="color: var(--dk-primary); font-size: 1rem;">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <a href="{{ route('product.show', $product->slug) }}" class="btn btn-sm btn-outline-dark rounded-circle d-flex align-items-center justify-content-center transition-btn" style="width: 32px; height: 32px; padding: 0; border-width: 1px;">
                                        <i class="bi bi-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <!-- Empty State Minimalis -->
                    <div class="col-12 text-center py-5 mt-4">
                        <i class="bi bi-search text-muted mb-3 d-block" style="font-size: 3rem; opacity: 0.5;"></i>
                        <h4 class="fw-bold" style="font-family: var(--dk-font-heading);">Menu Tidak Ditemukan</h4>
                        <p class="text-muted mb-4">Kami tidak dapat menemukan hidangan yang sesuai dengan pencarian Anda.</p>
                        <a href="{{ route('catalog.index') }}" class="btn btn-primary px-4">Lihat Semua Menu</a>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-5 d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* --- EFEK HOVER PRODUK EDITORIAL --- */
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

    .transition-btn {
        transition: all 0.3s ease;
        border-color: #ccc !important;
        color: var(--dk-text);
    }
    .product-editorial:hover .transition-btn {
        background-color: var(--dk-text) !important;
        border-color: var(--dk-text) !important;
        color: white !important;
        transform: rotate(90deg);
    }

    /* Menghilangkan outline biru bawaan Bootstrap pada input form */
    .form-control:focus, .form-select:focus {
        box-shadow: none;
        border-color: var(--dk-primary) !important;
    }
</style>
@endpush