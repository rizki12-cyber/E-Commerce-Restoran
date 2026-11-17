@extends('layouts.app')

@section('title', ($settings['app_name'] ?? config('app.name')) . ' — Premium Food E-Commerce')

@section('content')
    <!-- Hero Section -->
    @if($hero)
    <section class="py-4 py-lg-5 position-relative" style="overflow: hidden;">

        {{-- WATERMARK: CASA RASA (diagonal, animasi melintas) 
        <div class="position-absolute top-50 start-50 w-100 text-center" 
             style="z-index: 0; pointer-events: none; transform: translate(-50%, -50%) rotate(25deg);">
            <div class="watermark-anim-wrap">
                <h1 class="fw-bold text-uppercase m-0"
                    style="font-family: var(--dk-font-heading); font-size: 15vw; color: rgba(0, 0, 0, 0.04); white-space: nowrap; line-height: 1;">
                    CASA RASA
                </h1>
            </div>
        </div> --}}

        <div class="container position-relative" style="z-index: 1;">
            <div class="row align-items-center">
                
                <!-- Kolom Kiri: Teks -->
                <div class="col-lg-5 mb-5 mb-lg-0 text-center text-lg-start">
                    
                    <!-- Jam Operasional -->
                    <div class="mb-4 mb-lg-5 d-inline-block text-start ps-3 op-hours" style="border-left: 2px solid var(--dk-primary);">
                        <small class="text-uppercase fw-bold text-muted d-block mb-2 d-flex align-items-center gap-2 op-hours-title" 
                            style="letter-spacing: 2px; font-size: 0.75rem;">
                            <span class="live-dot"></span>
                            JAM OPERASIONAL
                        </small>
                        <div class="d-flex flex-column gap-1">
                            <span class="fw-medium op-hours-row" style="font-size: 0.85rem;">
                                <i class="bi bi-clock op-clock me-2 text-muted" style="font-size: 0.8rem;"></i>{{ $globalSettings['operating_hours_weekday'] ?? 'Mon-Sat: 09:00am - 08:00pm' }}
                            </span>
                            <span class="fw-medium op-hours-row" style="font-size: 0.85rem;">
                                <i class="bi bi-clock op-clock me-2 text-muted" style="font-size: 0.8rem;"></i>{{ $globalSettings['operating_hours_weekend'] ?? 'Sunday: 10:00am - 06:00pm' }}
                            </span>
                        </div>
                    </div>

                    <h1 class="display-4 display-lg-3 fw-bold mb-4" style="line-height: 1.1; letter-spacing: -1px;">
                        {{ $hero->title }}
                    </h1>
                    
                    <p class="lead mb-4 mb-lg-5 text-muted mx-auto mx-lg-0" style="max-width: 95%; line-height: 1.6; font-size: 1rem;">
                        {{ $hero->content }}
                    </p>

                    <div class="d-flex gap-4 align-items-center justify-content-center justify-content-lg-start mt-4 mt-lg-5">
                        <div class="text-center text-lg-start">
                            <h3 class="mb-0 fw-bold">250+</h3>
                            <small class="text-muted">Food items</small>
                        </div>
                        <div style="width: 1px; height: 40px; background-color: #ccc;"></div>
                        <div class="text-center text-lg-start">
                            <h3 class="mb-0 fw-bold">50+</h3>
                            <small class="text-muted">Restaurants</small>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Collage 3 Gambar (Static) -->
                <div class="col-lg-7 position-relative mt-5 mt-lg-0">
                    <div class="hero-collage mx-auto">
                        <!-- Gambar Utama (Tengah) -->
                        <div class="collage-main shadow-lg">
                            @if($hero->image)
                                <img src="{{ Storage::url($hero->image) }}" alt="Hero Main">
                            @else
                                <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Hero Main">
                            @endif
                        </div>

                        <!-- Gambar Kecil Atas -->
                        <div class="collage-top shadow">
                            @if(isset($hero->settings['hero_image_2']))
                                <img src="{{ Storage::url($hero->settings['hero_image_2']) }}" alt="Food 1">
                            @else
                                <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Food 1">
                            @endif
                        </div>

                        <!-- Gambar Kecil Bawah -->
                        <div class="collage-bottom shadow">
                            @if(isset($hero->settings['hero_image_3']))
                                <img src="{{ Storage::url($hero->settings['hero_image_3']) }}" alt="Food 2">
                            @else
                                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?ixlib=rb-4.0.3&auto=format&fit=crop&w=400&q=80" alt="Food 2">
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
    @endif

    <!-- Kategori Section -->
<section class="py-4 py-lg-5 my-3 my-lg-5 position-relative overflow-hidden">

    {{-- WATERMARK: GAMBAR (di belakang konten) --}}
    <div class="position-absolute top-50 start-50 translate-middle w-100 d-flex justify-content-center align-items-center"
         style="z-index: 0; pointer-events: none; opacity: 0.05;">
        <img src="{{ isset($globalSettings['watermark_image']) && $globalSettings['watermark_image']
                       ? Storage::url($globalSettings['watermark_image'])
                       : Storage::url($globalSettings['logo'] ?? '') }}"
             alt=""
             style="max-width: 700px; width: 70%; height: auto; object-fit: contain;">
    </div>

    {{-- KONTEN (dipastikan di atas watermark) --}}
    <div class="container py-2 py-lg-4 position-relative" style="z-index: 1;">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 mb-lg-5">
            {{-- ... sisanya sama persis seperti aslinya ... --}}
                <div class="mb-3 mb-md-0">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.8rem;">KATEGORI</span>
                        <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
                    </div>
                    <h2 class="display-5 fw-bold mb-0 pt-2" style="font-family: var(--dk-font-heading);">Pilihan Menu</h2>
                </div>
                <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary d-none d-md-block">Lihat Semua Menu</a>
            </div>

            <div class="row g-3 g-lg-4">
                @foreach($categories as $index => $category)
                    <div class="col-6 col-md-3">
                        <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" class="text-decoration-none d-block category-link">
                            <div class="border-top pt-3 border-dark" style="border-width: 2px !important; transition: all 0.3s ease;">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <small class="text-muted fw-bold" style="font-size: 0.75rem;">0{{ $index + 1 }}</small>
                                        <h4 class="fw-bold mb-1 mt-1 text-dark transition-title" style="font-family: var(--dk-font-heading); font-size: 1.2rem;">
                                            {{ $category->name }}
                                        </h4>
                                        <small class="text-muted text-uppercase" style="letter-spacing: 1px; font-size: 0.65rem;">
                                            {{ $category->products->count() ?? 0 }} Menu
                                        </small>
                                    </div>
                                    <i class="bi bi-arrow-right fs-5 text-muted transition-arrow mt-2 d-none d-md-block"></i>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Produk Unggulan Section -->
    <section id="menu" class="py-4 py-lg-5 my-3 my-lg-5">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-4 mb-lg-5">
                <div class="mb-3 mb-md-0">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.8rem;">MENU UNGGULAN</span>
                        <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
                    </div>
                    <h2 class="display-5 fw-bold mb-0 pt-2" style="font-family: var(--dk-font-heading);">Pilihan Terbaik</h2>
                </div>
                <a href="{{ route('catalog.index') }}" class="btn btn-outline-primary d-none d-md-block">Lihat Semua Menu</a>
            </div>
            
            <div class="row g-3 g-lg-4">
                @forelse($featuredProducts as $product)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="product-editorial position-relative">
                            <a href="{{ route('product.show', $product->slug) }}" class="d-block overflow-hidden mb-2 mb-md-3" style="border-radius: 12px; aspect-ratio: 4/5;">
                                @if($product->primary_image)
                                    <img src="{{ Storage::url($product->primary_image) }}" class="w-100 h-100 object-fit-cover transition-img" alt="{{ $product->name }}">
                                @else
                                    <div class="bg-secondary bg-opacity-25 w-100 h-100 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image text-muted fs-1"></i>
                                    </div>
                                @endif
                            </a>

                            @if($product->discount_price)
                                <span class="position-absolute top-0 start-0 m-2 m-md-3 fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px; color: var(--dk-primary);">Promo</span>
                            @endif
                            
                            <div class="d-flex flex-column">
                                <small class="text-muted text-uppercase mb-1" style="letter-spacing: 1px; font-size: 0.6rem;">
                                    {{ $product->category?->name ?? 'Tanpa Kategori' }}
                                </small>
                                
                                <div class="d-flex justify-content-between align-items-start gap-2">
                                    <a href="{{ route('product.show', $product->slug) }}" class="text-decoration-none">
                                        <h6 class="fw-bold text-dark mb-1 transition-title" style="font-family: var(--dk-font-heading); line-height: 1.3; font-size: 1rem;">
                                            {{ $product->name }}
                                        </h6>
                                    </a>
                                </div>

                                <div class="d-flex justify-content-between align-items-center mt-1 mt-md-2">
                                    <div>
                                        @if($product->discount_price)
                                            <div class="text-muted small text-decoration-line-through" style="font-size: 0.7rem;">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </div>
                                            <div class="fw-bold" style="color: var(--dk-primary); font-size: 0.95rem;">
                                                Rp {{ number_format($product->discount_price, 0, ',', '.') }}
                                            </div>
                                        @else
                                            <div class="fw-bold" style="color: var(--dk-primary); font-size: 0.95rem;">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <a href="{{ route('product.show', $product->slug) }}" class="btn btn-sm btn-outline-dark rounded-circle d-flex align-items-center justify-content-center transition-btn d-none d-md-flex" style="width: 35px; height: 35px; padding: 0; border-width: 1px;">
                                        <i class="bi bi-plus"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <p class="text-muted">Belum ada produk unggulan saat ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section -->
    @if($aboutUs && $aboutUs->is_active)
    <section id="tentang" class="py-4 py-lg-5 my-3 my-lg-5 position-relative overflow-hidden">
        
                <!-- BACKGROUND TEXT RAKSASA (WATERMARK) MENYILANG -->
        <div class="position-absolute top-50 start-50 w-100 text-center" style="z-index: 0; pointer-events: none; transform: translate(-50%, -50%) rotate(25deg);">
            <h1 class="fw-bold text-uppercase m-0" style="font-family: var(--dk-font-heading); font-size: 15vw; color: rgba(0, 0, 0, 0.04); white-space: nowrap; line-height: 1;">
                CASA RASA
            </h1>
        </div>

        <!-- KONTEN UTAMA -->
        <div class="container py-2 py-lg-4 position-relative" style="z-index: 1;">
            <div class="row align-items-center g-4 g-lg-5">
                <div class="col-lg-5 text-center text-lg-start">
                    <div class="about-image-wrapper position-relative d-inline-block w-100">
                        @if($aboutUs->image)
                            <img src="{{ Storage::url($aboutUs->image) }}" class="img-fluid position-relative w-100 shadow-lg about-img" alt="Tentang Kami" style="object-fit: cover; height: 400px; border-radius: 200px 200px 20px 20px; z-index: 2;">
                        @else
                            <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" class="img-fluid position-relative w-100 shadow-lg about-img" alt="Tentang Kami" style="object-fit: cover; height: 400px; border-radius: 200px 200px 20px 20px; z-index: 2;">
                        @endif

                        <div class="position-absolute bottom-0 end-0 bg-white p-3 rounded-circle shadow-lg d-flex flex-column align-items-center justify-content-center m-3 m-md-4 badge-halal" style="width: 90px; height: 90px; z-index: 3; border: 1px solid var(--dk-border);">
                            <span class="fw-bold fs-5" style="font-family: var(--dk-font-heading); color: var(--dk-primary);">100%</span>
                            <span class="text-muted text-uppercase fw-bold" style="letter-spacing: 1px; font-size: 0.6rem;">Halal</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 offset-lg-1 mt-5 mt-lg-0">
                    <div class="d-flex align-items-center gap-3 mb-3 mb-md-4">
                        <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">Tentang Kami</span>
                        <div class="flex-grow-1" style="height: 1px; background-color: #ccc;"></div>
                    </div>
                    
                    <h2 class="display-6 display-lg-5 fw-bold mb-3 mb-md-4" style="font-family: var(--dk-font-heading); line-height: 1.2;">
                        {{ $aboutUs->title }}
                    </h2>
                    
                    <p class="text-muted mb-4 mb-lg-5" style="white-space: pre-line; line-height: 1.8; font-size: 0.95rem;">
                        {{ $aboutUs->content }}
                    </p>

                    <div class="row g-3 g-md-4">
                        <div class="col-6">
                            <div class="border-top pt-2 pt-md-3" style="border-color: var(--dk-text) !important; border-width: 2px !important;">
                                <h6 class="fw-bold mb-1" style="font-family: var(--dk-font-heading); font-size: 0.95rem;">01. Bahan Premium</h6>
                                <p class="text-muted small mb-0" style="line-height: 1.5; font-size: 0.8rem;">Dipilih dari supplier lokal terbaik.</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border-top pt-2 pt-md-3" style="border-color: var(--dk-text) !important; border-width: 2px !important;">
                                <h6 class="fw-bold mb-1" style="font-family: var(--dk-font-heading); font-size: 0.95rem;">02. Proses Higienis</h6>
                                <p class="text-muted small mb-0" style="line-height: 1.5; font-size: 0.8rem;">Dimasak sesuai standar kebersihan.</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border-top pt-2 pt-md-3" style="border-color: var(--dk-text) !important; border-width: 2px !important;">
                                <h6 class="fw-bold mb-1" style="font-family: var(--dk-font-heading); font-size: 0.95rem;">03. Selalu Hangat</h6>
                                <p class="text-muted small mb-0" style="line-height: 1.5; font-size: 0.8rem;">Dimasak fresh saat pesanan masuk.</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border-top pt-2 pt-md-3" style="border-color: var(--dk-text) !important; border-width: 2px !important;">
                                <h6 class="fw-bold mb-1" style="font-family: var(--dk-font-heading); font-size: 0.95rem;">04. Pelayanan Cepat</h6>
                                <p class="text-muted small mb-0" style="line-height: 1.5; font-size: 0.8rem;">Pesanan diproses kilat tanpa kurangi kualitas.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- Food Gallery Section -->
    @if($galleries->count() > 0)
    <section id="galeri" class="py-4 py-lg-5 my-3 my-lg-5">
        <div class="container py-2 py-lg-4">
            <div class="text-center mb-4 mb-lg-5">
                <h2 class="display-6 display-lg-5 fw-bold" style="font-family: var(--dk-font-heading);">Galeri Rasa</h2>
                <p class="text-muted">Intip kelezatan yang kami sajikan</p>
            </div>
            <div class="row g-3 g-lg-4 justify-content-center">
                @foreach($galleries as $gallery)
                    <div class="col-6 col-md-4">
                        <div class="gallery-img-wrapper rounded-4 overflow-hidden shadow-sm position-relative" style="height: 200px; height: 300px; /* Fallback for older browsers */">
                            <img src="{{ Storage::url($gallery->image) }}" alt="{{ $gallery->title ?? 'Galeri' }}" class="w-100 h-100 object-fit-cover">
                            @if($gallery->title)
                                <div class="position-absolute bottom-0 start-0 w-100 p-2 p-md-3" style="background: linear-gradient(to top, rgba(0,0,0,0.8), transparent);">
                                    <h6 class="text-white mb-0 fw-bold" style="font-size: 0.85rem;">{{ $gallery->title }}</h6>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

        <!-- CUSTOMER REVIEWS SECTION (MARQUEE ANIMATION) -->
    @if(isset($reviews) && $reviews->count() > 0)
    <section class="py-5 my-5 overflow-hidden">
        <div class="container text-center mb-5">
            <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                <div style="height: 1px; width: 40px; background-color: #ccc;"></div>
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.8rem;">TESTIMONI</span>
                <div style="height: 1px; width: 40px; background-color: #ccc;"></div>
            </div>
            <h2 class="display-6 display-lg-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Apa Kata Mereka?</h2>
        </div>

        <!-- Marquee Wrapper -->
        <div class="review-marquee-wrapper">
            <div class="review-marquee-content">
                
                {{-- LOOP 1: Review Asli --}}
                @foreach($reviews as $review)
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            @if($review->user?->avatar)
                                <img src="{{ Storage::url($review->user->avatar) }}" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover; border: 1px solid var(--dk-border);" alt="{{ $review->user->name }}">
                            @else
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px; font-family: var(--dk-font-heading); font-size: 1.1rem;">
                                    {{ substr($review->user?->name ?? 'U', 0, 1) }}
                                </div>
                            @endif
                            
                            <div>
                                <h6 class="fw-bold mb-0">{{ $review->user?->name ?? 'Pengguna' }}</h6>
                                <small class="text-muted" style="font-size: 0.7rem;">
                                    Membeli: {{ $review->product?->name ?? 'Produk Dihapus' }}
                                </small>
                            </div>
                        </div>
                        
                        <div class="text-warning mb-3 animated-stars" style="font-size: 0.8rem;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                        
                        <p class="text-muted mb-0" style="font-style: italic; line-height: 1.7; font-size: 0.95rem;">
                            "{{ Str::limit($review->comment, 120) }}"
                        </p>
                    </div>
                @endforeach

                {{-- LOOP 2: Duplikasi Review (untuk animasi seamless) --}}
                @foreach($reviews as $review)
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            @if($review->user?->avatar)
                                <img src="{{ Storage::url($review->user->avatar) }}" class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover; border: 1px solid var(--dk-border);" alt="{{ $review->user->name }}">
                            @else
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px; font-family: var(--dk-font-heading); font-size: 1.1rem;">
                                    {{ substr($review->user?->name ?? 'U', 0, 1) }}
                                </div>
                            @endif
                            
                            <div>
                                <h6 class="fw-bold mb-0">{{ $review->user?->name ?? 'Pengguna' }}</h6>
                                <small class="text-muted" style="font-size: 0.7rem;">
                                    Membeli: {{ $review->product?->name ?? 'Produk Dihapus' }}
                                </small>
                            </div>
                        </div>
                        
                        <div class="text-warning mb-3 animated-stars" style="font-size: 0.8rem;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                        
                        <p class="text-muted mb-0" style="font-style: italic; line-height: 1.7; font-size: 0.95rem;">
                            "{{ Str::limit($review->comment, 120) }}"
                        </p>
                    </div>
                @endforeach

            </div>
        </div>
    </section>
    @endif

    <!-- Why Choose Us -->
    @if($whyChooseUs)
    <section class="py-4 py-lg-5 my-3 my-lg-5">
        <div class="container py-2 py-lg-4">
            <div class="row align-items-start g-4 g-lg-5">
                <div class="col-lg-5">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">FILOSOFI KAMI</span>
                        <div style="height: 1px; width: 40px; background-color: #ccc;"></div>
                    </div>
                    <h2 class="display-6 display-lg-5 fw-bold mb-0" style="font-family: var(--dk-font-heading); line-height: 1.2; overflow-wrap: break-word; word-wrap: break-word; hyphens: auto;">
                        {{ $whyChooseUs->title }}
                    </h2>
                </div>

                <div class="col-lg-7 mt-4 mt-lg-0">
                    <div class="position-relative ms-2 ms-lg-4" style="border-left: 3px solid var(--dk-primary); padding-left: 1.5rem; padding-left: 2.5rem;">
                        <i class="bi bi-quote position-absolute text-muted opacity-25" style="font-size: 4rem; top: -20px; left: 10px; z-index: 0; line-height: 1;"></i>
                        <p class="fs-6 fs-lg-5 text-muted mb-0 position-relative" style="line-height: 1.8; font-style: italic; z-index: 1; padding-top: 1rem;">
                            {!! nl2br(e($whyChooseUs->content)) !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endif

    <!-- FAQ -->
    @if($faqs->count() > 0)
    <section class="py-4 py-lg-5 my-3 my-lg-5 position-relative overflow-hidden">
        
        <!-- BACKGROUND TEXT RAKSASA (WATERMARK) MENYILANG -->
        <div class="position-absolute top-50 start-50 w-100 text-center" style="z-index: 0; pointer-events: none; transform: translate(-50%, -50%) rotate(25deg);">
            <h1 class="fw-bold text-uppercase m-0" style="font-family: var(--dk-font-heading); font-size: 15vw; color: rgba(0, 0, 0, 0.04); white-space: nowrap; line-height: 1;">
                CASA RASA
            </h1>
        </div>

        <div class="container py-2 py-lg-4 position-relative" style="z-index: 1;">
            <div class="row align-items-start g-4 g-lg-5">
                
                <!-- Kolom Kiri -->
                <div class="col-lg-4">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">FAQ</span>
                        <div style="height: 1px; width: 40px; background-color: #ccc;"></div>
                    </div>
                    <h2 class="display-6 display-lg-5 fw-bold mb-3 mb-md-4 text-dark" style="font-family: var(--dk-font-heading); line-height: 1.2;">
                        Pertanyaan<br>Umum
                    </h2>
                    <p class="text-muted mb-4 mb-lg-0" style="line-height: 1.8; font-size: 0.95rem;">
                        Punya pertanyaan lain? Jangan ragu untuk menghubungi tim layanan pelanggan kami.
                    </p>
                </div>

                <!-- Kolom Kanan -->
                <div class="col-lg-8">
                    <div class="accordion accordion-flush" id="faqAccordion">
                        @foreach($faqs as $index => $faq)
                            <div class="accordion-item border-top border-bottom-0 border-start-0 border-end-0" style="background-color: transparent; border-color: #e0d5cb;">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed fw-bold px-0 text-start text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $faq->id }}" style="font-family: var(--dk-font-heading); font-size: 1.1rem; background-color: transparent; box-shadow: none; padding-top: 1.2rem; padding-bottom: 1.2rem;">
                                        {{ $faq->question }}
                                    </button>
                                </h2>
                                <div id="faq{{ $faq->id }}" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body px-0 text-muted" style="line-height: 1.8; padding-bottom: 1.2rem; padding-top: 0; font-size: 0.95rem;">
                                        {{ $faq->answer }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </section>
    @endif
@endsection

@push('styles')
<style>
    /* --- BASE STYLES (MOBILE FIRST) --- */
    .hero-collage {
        position: relative;
        height: 300px; /* Tinggi di Mobile */
        width: 100%;
        max-width: 350px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Memastikan gambar tidak bergerak (static) */
    .collage-main, .collage-top, .collage-bottom {
        animation: none !important;
        transform: none !important;
        transition: none !important;
    }

    .collage-main {
        width: 180px;
        height: 180px;
        border-radius: 50%;
        overflow: hidden;
        position: absolute;
        z-index: 2;
        border: 4px solid rgba(255, 255, 255, 0.5);
    }

    .collage-main img { width: 100%; height: 100%; object-fit: cover; }

    .collage-top {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        overflow: hidden;
        position: absolute;
        top: 10px;
        right: 0;
        z-index: 1;
        border: 3px solid rgba(255, 255, 255, 0.8);
    }

    .collage-bottom {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        position: absolute;
        bottom: 10px;
        left: 0;
        z-index: 1;
        border: 3px solid rgba(255, 255, 255, 0.8);
    }

    .collage-top img, .collage-bottom img { width: 100%; height: 100%; object-fit: cover; }

    .about-image-wrapper::before {
        content: '';
        position: absolute;
        top: -10px; left: -10px; right: 10px; bottom: 10px;
        border: 2px solid var(--dk-primary);
        border-radius: 200px 200px 20px 20px;
        z-index: 0;
        opacity: 0.5;
    }

    /* --- MEDIA QUERIES (DESKTOP / TABLET) --- */
    @media (min-width: 992px) {
        /* Hero Collage Desktop */
        .hero-collage { height: 500px; max-width: 100%; margin: 0; }
        .collage-main { width: 320px; height: 320px; border-width: 8px; }
        .collage-top { width: 180px; height: 180px; top: 20px; right: 0; }
        .collage-bottom { width: 220px; height: 220px; bottom: 20px; left: 0; }

        /* About Image Desktop */
        .about-img { height: 500px !important; border-radius: 250px 250px 20px 20px !important; }
        .about-image-wrapper::before {
            top: -15px; left: -15px; right: 15px; bottom: 15px;
            border-radius: 250px 250px 20px 20px;
        }
        
        /* Typography Desktop */
        .display-lg-3 { font-size: calc(1.5rem + 3.3vw) !important; }
        .display-lg-5 { font-size: calc(1.5rem + 2.5vw) !important; }
        .fs-lg-5 { font-size: 1.25rem !important; }
    }

    /* Efek Hover (Tetap Sama) */
    .category-link:hover .border-dark { border-color: var(--dk-primary) !important; transform: translateY(-3px); }
    .category-link:hover .transition-title { color: var(--dk-primary) !important; }
    .category-link:hover .transition-arrow { transform: translate(3px, 0); color: var(--dk-primary) !important; }
    .transition-title { transition: color 0.3s ease; }
    
    .product-editorial:hover .transition-img { transform: scale(1.05); }
    .transition-img { transition: transform 0.6s ease; }
    .product-editorial:hover .transition-title { color: var(--dk-primary) !important; }
    .product-editorial:hover .transition-btn { background-color: var(--dk-text) !important; color: white !important; transform: rotate(90deg); }
    .transition-btn { transition: all 0.3s ease; border-color: #ccc !important; }

    .gallery-img-wrapper img { transition: transform 0.5s ease; height: 100%; object-fit: cover; }
    .gallery-img-wrapper:hover img { transform: scale(1.05); }

    .accordion-button:not(.collapsed) { color: var(--dk-primary) !important; }
    .accordion-button::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%231A1A1A'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }
    .accordion-button:not(.collapsed)::after {
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23E36A2E'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }

    /* --- ANIMASI MARQUEE REVIEWS --- */
    .review-marquee-wrapper {
        display: flex;
        overflow: hidden;
        user-select: none;
        mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
        -webkit-mask-image: linear-gradient(to right, transparent, black 10%, black 90%, transparent);
    }

    .review-marquee-content {
        flex-shrink: 0;
        display: flex;
        align-items: stretch;
        gap: 2rem;
        min-width: 100%;
        padding: 1rem 0;
        animation: scroll-marquee 40s linear infinite;
    }

    .review-marquee-wrapper:hover .review-marquee-content {
        animation-play-state: paused;
    }

    @keyframes scroll-marquee {
        from { transform: translateX(0); }
        to { transform: translateX(calc(-50% - 1rem)); } 
    }

    /* ============================================
       DESAIN KARTU TESTIMONI (BENAR-BENAR TRANSPARAN)
       ============================================ */
    .testimonial-card {
        width: 350px;
        flex-shrink: 0;
        background: transparent !important; /* Paksa transparan */
        backdrop-filter: none !important; /* Hilangkan efek kaca */
        border: 1px solid #e0d5cb !important; /* Garis tepi tipis */
        border-radius: 12px;
        padding: 2rem;
        box-shadow: none !important; /* Hilangkan bayangan */
        transition: all 0.3s ease; 
    }

    /* Efek saat kursor diarahkan (hover) */
    .testimonial-card:hover {
        transform: translateY(-5px);
        border-color: var(--dk-primary) !important;
    }

    @media (max-width: 576px) {
        .testimonial-card {
            width: 280px;
            padding: 1.5rem;
        }
    }

    /* --- ANIMASI BINTANG MELAYANG --- */
    .animated-stars i {
        display: inline-block;
        animation: float-stars 2s ease-in-out infinite;
    }

    .animated-stars i:nth-child(1) { animation-delay: 0.0s; }
    .animated-stars i:nth-child(2) { animation-delay: 0.15s; }
    .animated-stars i:nth-child(3) { animation-delay: 0.3s; }
    .animated-stars i:nth-child(4) { animation-delay: 0.45s; }
    .animated-stars i:nth-child(5) { animation-delay: 0.6s; }

    @keyframes float-stars {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-4px); }
    }

    /* ============================================
       ANIMASI WATERMARK HERO (MELINTAS DIAGONAL)
       ============================================ */
    .watermark-anim-wrap {
        display: inline-block;
        animation: slide-watermark 15s linear infinite;
        will-change: transform, opacity;
    }

    @keyframes slide-watermark {
        0%   { transform: translateX(-100%); opacity: 0; }
        15%  { opacity: 1; }
        85%  { opacity: 1; }
        100% { transform: translateX(100%); opacity: 0; }
    }
    .live-dot {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    background-color: #26966F; /* hijau "open" */
    display: inline-block;
    position: relative;
}

    /* Efek cincin melingkar yang memudar */
    .live-dot::after {
        content: '';
        position: absolute;
        inset: 0;
        border-radius: 50%;
        background-color: #26966F;
        animation: liveRing 1.8s ease-out infinite;
    }

    @keyframes liveRing {
        0%   { transform: scale(1);   opacity: 0.6; }
        100% { transform: scale(2.5); opacity: 0; }
    }

    /* ============================================
   ANIMASI JAM OPERASIONAL (LIGHTWEIGHT) — FIXED
   ============================================ */

/* Container: fade-in saat load */
.op-hours {
    position: relative;
    /* 🔥 KUNCI: bikin border inline transparan agar pulse ::before KELIHATAN */
    border-left-color: transparent !important;
    animation: opFadeSlide 0.9s cubic-bezier(0.16, 1, 0.3, 1) both;
}

/* Pseudo-element = border yang berdenyut (loop terus) */
.op-hours::before {
    content: '';
    position: absolute;
    left: -2px;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--dk-primary);
    animation: opBorderPulse 2.4s ease-in-out infinite;
    pointer-events: none;
    will-change: opacity;
}

@keyframes opBorderPulse {
    0%, 100% { opacity: 1; }
    50%      { opacity: 0.15; }   /* kontras cukup biar keliatan jelas */
}

/* Judul muncul */
.op-hours-title {
    animation: opFadeSlide 0.7s ease-out 0.15s both;
}

/* Baris jam muncul staggered */
.op-hours-row {
    animation: opFadeSlide 0.6s ease-out both;
}
.op-hours-row:nth-child(1) { animation-delay: 0.30s; }
.op-hours-row:nth-child(2) { animation-delay: 0.45s; }

@keyframes opFadeSlide {
    from { opacity: 0; transform: translateY(10px); }
    to   { opacity: 1; transform: translateY(0); }
}

/* ⏰ Clock icon "tick" — tiap 3 detik (lebih sering = lebih keliatan) */
.op-hours-row .op-clock {
    display: inline-block;
    transform-origin: center;
    animation: opClockWiggle 3s ease-in-out infinite;
    will-change: transform;
}
.op-hours-row:nth-child(2) .op-clock { animation-delay: 0.4s; }

@keyframes opClockWiggle {
    0%, 70%, 100% { transform: rotate(0deg); }
    76%           { transform: rotate(-14deg); }
    82%           { transform: rotate(12deg); }
    88%           { transform: rotate(-7deg); }
    94%           { transform: rotate(4deg); }
}

/* Hormati preferensi user */
@media (prefers-reduced-motion: reduce) {
    .op-hours,
    .op-hours::before,
    .op-hours-title,
    .op-hours-row,
    .op-hours-row .op-clock {
        animation: none !important;
    }
}
</style>
@endpush