@extends('layouts.app')

@section('title', $product->name . ' — Dapur Kaysan')

@section('content')
<div class="container py-5 my-4">
    
    <!-- Breadcrumb Minimalis -->
    <nav aria-label="breadcrumb" class="mb-5">
        <ol class="breadcrumb text-uppercase" style="font-size: 0.75rem; letter-spacing: 2px;">
            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-muted text-decoration-none">Beranda</a></li>
            <li class="breadcrumb-item"><a href="{{ route('catalog.index') }}" class="text-muted text-decoration-none">Menu</a></li>
            <li class="breadcrumb-item active" style="color: var(--dk-primary);" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row g-5">
        <!-- Gambar Produk -->
        <div class="col-lg-5 mb-4 mb-lg-0">
            <div class="position-relative overflow-hidden mx-auto" style="border-radius: 16px; background-color: #f5f5f5; max-width: 420px;">
                @if($product->primary_image)
                    <img src="{{ Storage::url($product->primary_image) }}" class="img-fluid w-100" style="object-fit: cover; aspect-ratio: 4/5;">
                @else
                    <div class="d-flex align-items-center justify-content-center" style="aspect-ratio: 4/5;">
                        <i class="bi bi-image text-muted" style="font-size: 5rem;"></i>
                    </div>
                @endif
                
                @if($product->discount_price)
                    <span class="position-absolute top-0 start-0 m-4 fw-bold text-uppercase" style="font-size: 0.8rem; letter-spacing: 2px; color: var(--dk-primary);">Promo</span>
                @endif
            </div>
        </div>

        <!-- Info Produk -->
        <div class="col-lg-7">
            
            <!-- Kategori -->
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">{{ $product->category->name }}</span>
                <div style="height: 1px; width: 40px; background-color: #ccc;"></div>
            </div>
            
            <h1 class="display-4 fw-bold mb-3" style="font-family: var(--dk-font-heading); line-height: 1.1;">
                {{ $product->name }}
            </h1>

            <!-- Rating & Info -->
            <div class="d-flex align-items-center gap-4 mb-4 text-muted small">
                <div class="text-warning">
                    <i class="bi bi-star-fill"></i> {{ number_format($reviews->avg('rating') ?? 0, 1) }} ({{ $reviews->total() }} Ulasan)
                </div>
                <div>Stok: <span class="fw-bold text-dark">{{ $product->stock }}</span></div>
                <div>SKU: <span class="fw-bold text-dark">{{ $product->sku }}</span></div>
            </div>

            <!-- Harga -->
            <div class="mb-4 pb-4 border-bottom" style="border-color: #e0d5cb !important;">
                @if($product->discount_price)
                    <span class="text-muted text-decoration-line-through fs-5 me-3">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    <span class="fw-bold" style="color: var(--dk-primary); font-size: 2.5rem; font-family: var(--dk-font-heading);">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                @else
                    <span class="fw-bold" style="color: var(--dk-primary); font-size: 2.5rem; font-family: var(--dk-font-heading);">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                @endif
            </div>

            <!-- Deskripsi -->
            <p class="text-muted mb-5" style="line-height: 1.9; font-size: 1.05rem;">{{ $product->description }}</p>

            <!-- Alert -->
            @if ($errors->any())
                <div class="alert alert-danger border-0 rounded-3 mb-4">
                    <ul class="mb-0 small">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success border-0 rounded-3 mb-4">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger border-0 rounded-3 mb-4">{{ session('error') }}</div>
            @endif

            <!-- FORM KERANJANG -->
            <form action="{{ route('customer.cart.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                
                <!-- Variasi -->
                @if($product->variants->count() > 0)
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Pilih Variasi</label>
                        <select name="variant_id" class="form-select border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" style="border-bottom: 1px solid #ccc !important;">
                            <option value="">-- Tanpa Variasi --</option>
                            @foreach($product->variants as $variant)
                                <option value="{{ $variant->id }}">{{ $variant->name }} (+ Rp {{ number_format($variant->additional_price, 0, ',', '.') }})</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <!-- Add-ons -->
                @if($product->addons->count() > 0)
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Tambahan (Opsional)</label>
                        @foreach($product->addons as $addon)
                            <div class="form-check mb-2">
                                <input class="form-check-input shadow-none" type="checkbox" name="addon_ids[]" value="{{ $addon->id }}" id="addon-{{ $addon->id }}">
                                <label class="form-check-label text-muted" for="addon-{{ $addon->id }}">
                                    {{ $addon->name }} <span class="text-dark fw-bold">(+ Rp {{ number_format($addon->price, 0, ',', '.') }})</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Kuantitas & Tombol Keranjang -->
                <div class="d-flex gap-3 align-items-end mt-5">
                    <div style="width: 100px;">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Jumlah</label>
                        <input type="number" name="quantity" class="form-control border-0 border-bottom rounded-0 px-0 text-center bg-transparent shadow-none fw-bold" value="1" min="1" max="{{ $product->stock }}" style="border-bottom: 1px solid #ccc !important; font-size: 1.2rem;">
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg flex-grow-1 py-3">
                        Tambah ke Keranjang
                    </button>
                </div>
            </form>
            
            <!-- FORM WISHLIST -->
            <div class="mt-3">
                <form action="{{ route('customer.wishlist.toggle') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-outline-dark w-100 py-2" style="border-radius: 50px;">
                        <i class="bi {{ $inWishlist ? 'bi-heart-fill text-danger' : 'bi-heart' }} me-2"></i> 
                        {{ $inWishlist ? 'Hapus dari Wishlist' : 'Simpan ke Wishlist' }}
                    </button>
                </form>
            </div>

        </div>
    </div>

    <!-- SECTION ULASAN PELANGGAN (Gaya Grid & Scrollable, Tanpa Background Putih) -->
    <div class="mt-5 pt-5 border-top" style="border-color: #e0d5cb !important;">
        <div class="row g-5">
            <!-- Judul Ulasan (Kiri) -->
            <div class="col-lg-4">
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.8rem;">ULASAN</span>
                    <div style="height: 1px; width: 40px; background-color: #ccc;"></div>
                </div>
                <h2 class="display-5 fw-bold mb-4" style="font-family: var(--dk-font-heading); line-height: 1.2;">
                    Apa Kata<br>Mereka?
                </h2>
                <p class="text-muted" style="line-height: 1.8;">
                    Ulasan asli dari pelanggan yang telah mencoba hidangan ini.
                </p>
            </div>

            <!-- Daftar Ulasan (Kanan - Grid 2 Kolom + Scroll) -->
            <div class="col-lg-8">
                @if($reviews->isEmpty())
                    <div class="py-4">
                        <p class="text-muted fst-italic">Belum ada ulasan untuk produk ini.</p>
                    </div>
                @else
                    
                    <!-- Kotak Scrollable -->
                    <div class="review-scrollable-box pe-3">
                        <div class="row g-4">
                            @foreach($reviews as $review)
                                <div class="col-md-6">
                                    <!-- Kartu Ulasan (Force Transparent) -->
                                    <div class="review-card h-100 p-3 pb-4 border-bottom" style="background: transparent !important; box-shadow: none !important; border-radius: 0 !important; border-color: #e0d5cb !important;">
                                        
                                        <!-- Header Ulasan -->
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <!-- LOGIKA FOTO PROFIL -->
                                                @if($review->user->avatar)
                                                    <img src="{{ Storage::url($review->user->avatar) }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover; border: 1px solid var(--dk-border);">
                                                @else
                                                    <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px; font-family: var(--dk-font-heading);">
                                                        {{ substr($review->user->name, 0, 1) }}
                                                    </div>
                                                @endif
                                                
                                                <div>
                                                    <h6 class="fw-bold mb-0" style="font-size: 0.95rem;">{{ $review->user->name }}</h6>
                                                    <small class="text-muted" style="font-size: 0.7rem;">{{ $review->created_at->format('d M Y') }}</small>
                                                </div>
                                            </div>
                                            @if($review->is_verified_purchase)
                                                <i class="bi bi-patch-check-fill text-success fs-5" title="Verified Purchase"></i>
                                            @endif
                                        </div>
                                        
                                        <!-- Bintang -->
                                        <div class="text-warning mb-2" style="font-size: 0.8rem;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                            @endfor
                                        </div>
                                        
                                        <!-- Komentar -->
                                        <p class="text-muted mb-0" style="line-height: 1.6; font-size: 0.9rem;">"{{ $review->comment }}"</p>

                                        <!-- Balasan Admin -->
                                        @if($review->replies->count() > 0)
                                            <div class="mt-3 p-2 rounded-3" style="background-color: rgba(0,0,0,0.03); border-left: 3px solid var(--dk-primary);">
                                                <strong class="d-block mb-1 text-dark" style="font-size: 0.75rem;"><i class="bi bi-shop me-1"></i> Balasan {{ $globalSettings['app_name'] ?? 'Admin' }}:</strong>
                                                @foreach($review->replies as $reply)
                                                    <p class="mb-0 text-muted" style="font-size: 0.8rem;">{{ $reply->reply }}</p>
                                                @endforeach
                                            </div>
                                        @endif

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pagination Ulasan -->
                    <div class="mt-4">
                        {{ $reviews->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Rekomendasi Produk -->
    @if($relatedProducts->count() > 0)
    <div class="mt-5 pt-5 border-top" style="border-color: #e0d5cb !important;">
        <h3 class="display-6 fw-bold mb-4" style="font-family: var(--dk-font-heading);">Mungkin Anda Suka</h3>
        <div class="row g-4">
            @foreach($relatedProducts as $related)
                <div class="col-6 col-md-3">
                    <div class="product-editorial position-relative">
                        <a href="{{ route('product.show', $related->slug) }}" class="d-block overflow-hidden mb-3" style="border-radius: 12px; aspect-ratio: 4/5;">
                            @if($related->primary_image)
                                <img src="{{ Storage::url($related->primary_image) }}" class="w-100 h-100 object-fit-cover transition-img" alt="{{ $related->name }}">
                            @else
                                <div class="bg-secondary bg-opacity-25 w-100 h-100 d-flex align-items-center justify-content-center">
                                    <i class="bi bi-image text-muted fs-1"></i>
                                </div>
                            @endif
                        </a>
                        <div class="d-flex flex-column">
                            <a href="{{ route('product.show', $related->slug) }}" class="text-decoration-none">
                                <h6 class="fw-bold text-dark mb-1 transition-title" style="font-family: var(--dk-font-heading); font-size: 1.1rem;">
                                    {{ $related->name }}
                                </h6>
                            </a>
                            <div class="fw-bold mt-1" style="color: var(--dk-primary); font-size: 0.95rem;">Rp {{ number_format($related->price, 0, ',', '.') }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>
@endsection

@push('styles')
<style>
    /* Efek Hover Rekomendasi Produk */
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

    /* Styling Checkbox Minimalis */
    .form-check-input:checked {
        background-color: var(--dk-primary);
        border-color: var(--dk-primary);
    }
    .form-check-input {
        border-color: #ccc;
    }
    
    /* Styling Dropdown Select Minimalis */
    .form-select:focus {
        border-color: var(--dk-primary) !important;
    }
    
    /* Breadcrumb Link Hover */
    .breadcrumb-item a:hover {
        color: var(--dk-text) !important;
    }

    /* --- KOTAK SCROLLABLE ULASAN --- */
    .review-scrollable-box {
        max-height: 480px;
        overflow-y: auto;
        padding-bottom: 1rem;
    }

    /* Custom Scrollbar Tipis */
    .review-scrollable-box::-webkit-scrollbar {
        width: 4px;
    }
    .review-scrollable-box::-webkit-scrollbar-track {
        background: transparent;
    }
    .review-scrollable-box::-webkit-scrollbar-thumb {
        background-color: #d1d1d1;
        border-radius: 10px;
    }
    .review-scrollable-box::-webkit-scrollbar-thumb:hover {
        background-color: var(--dk-primary);
    }

    /* Memastikan tidak ada background putih sama sekali di card ulasan */
    .review-card {
        background: transparent !important;
        box-shadow: none !important;
        border-radius: 0 !important;
    }
</style>
@endpush