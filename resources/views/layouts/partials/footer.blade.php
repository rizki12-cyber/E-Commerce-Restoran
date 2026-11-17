<footer class="mt-5 pt-5 pb-3" style="background-color: #121212; color: #a0a0a0;">
    <div class="container">
        <div class="row g-4 mb-5">
            
            <!-- Kolom 1: Brand & Deskripsi -->
            <!-- Di HP: Full width, teks di tengah. Di Laptop: 3/12 lebar, teks kiri -->
            <div class="col-12 col-lg-4 text-center text-md-start mb-4 mb-md-0">
                <a href="{{ route('home') }}" class="d-flex align-items-center justify-content-center justify-content-md-start gap-3 text-decoration-none mb-3">
                    @if(isset($globalSettings['logo']) && $globalSettings['logo'])
                        <img src="{{ Storage::url($globalSettings['logo']) }}" alt="Logo" style="height: 40px; filter: brightness(0) invert(1);">
                    @endif
                    <span class="fs-4 fw-bold text-white" style="font-family: var(--dk-font-heading);">
                        {{ $globalSettings['app_name'] ?? config('app.name') }}
                    </span>
                </a>
                <p class="small mb-4 px-3 px-md-0" style="line-height: 1.8;">
                    {{ $globalSettings['footer_description'] ?? 'Menyajikan hidangan premium dengan bahan-bahan pilihan terbaik untuk pengalaman kuliner yang tak terlupakan.' }}
                </p>
                
                <!-- Sosial Media -->
                <div class="d-flex gap-2 justify-content-center justify-content-md-start">
                    @if(!empty($globalSettings['social_instagram']))
                        <a href="{{ $globalSettings['social_instagram'] }}" target="_blank" class="text-white text-decoration-none bg-dark rounded-circle d-flex align-items-center justify-content-center transition-hover" style="width: 36px; height: 36px; border: 1px solid #333;">
                            <i class="bi bi-instagram"></i>
                        </a>
                    @endif
                    @if(!empty($globalSettings['social_facebook']))
                        <a href="{{ $globalSettings['social_facebook'] }}" target="_blank" class="text-white text-decoration-none bg-dark rounded-circle d-flex align-items-center justify-content-center transition-hover" style="width: 36px; height: 36px; border: 1px solid #333;">
                            <i class="bi bi-facebook"></i>
                        </a>
                    @endif
                    @if(!empty($globalSettings['social_tiktok']))
                        <a href="{{ $globalSettings['social_tiktok'] }}" target="_blank" class="text-white text-decoration-none bg-dark rounded-circle d-flex align-items-center justify-content-center transition-hover" style="width: 36px; height: 36px; border: 1px solid #333;">
                            <i class="bi bi-tiktok"></i>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Kolom 2: Navigasi -->
            <!-- Di HP: 6/12 lebar. Di Laptop: 2/12 lebar -->
            <div class="col-6 col-md-4 col-lg-2">
                <h6 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 2px; font-size: 0.75rem;">Navigasi</h6>
                <ul class="list-unstyled d-flex flex-column gap-3 small">
                    <li><a href="{{ route('home') }}" class="text-decoration-none text-reset footer-link">Beranda</a></li>
                    <li><a href="{{ route('catalog.index') }}" class="text-decoration-none text-reset footer-link">Menu</a></li>
                    <li><a href="{{ route('home') }}#tentang" class="text-decoration-none text-reset footer-link">Tentang Kami</a></li>
                    <li><a href="{{ route('home') }}#galeri" class="text-decoration-none text-reset footer-link">Galeri</a></li>
                </ul>
            </div>

            <!-- Kolom 3: Kontak -->
            <!-- Di HP: 6/12 lebar. Di Laptop: 3/12 lebar -->
            <div class="col-6 col-md-4 col-lg-3">
                <h6 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 2px; font-size: 0.75rem;">Kontak</h6>
                <ul class="list-unstyled d-flex flex-column gap-3 small">
                    @if(!empty($globalSettings['contact_address']))
                    <li class="d-flex gap-2 gap-md-3">
                        <i class="bi bi-geo-alt text-white mt-1"></i>
                        <span style="word-break: break-word;">{{ $globalSettings['contact_address'] }}</span>
                    </li>
                    @endif
                    @if(!empty($globalSettings['contact_phone']))
                    <li class="d-flex gap-2 gap-md-3">
                        <i class="bi bi-telephone text-white mt-1"></i>
                        <span>{{ $globalSettings['contact_phone'] }}</span>
                    </li>
                    @endif
                    @if(!empty($globalSettings['contact_email']))
                    <li class="d-flex gap-2 gap-md-3">
                        <i class="bi bi-envelope text-white mt-1"></i>
                        <span style="word-break: break-all;">{{ $globalSettings['contact_email'] }}</span>
                    </li>
                    @endif
                </ul>
            </div>

            <!-- Kolom 4: Maps -->
            <!-- Di HP: Full width. Di Laptop: 3/12 lebar -->
            @if(!empty($globalSettings['google_maps_url']))
            <div class="col-12 col-md-4 col-lg-3 mt-4 mt-md-0">
                <h6 class="text-white text-uppercase fw-bold mb-4" style="letter-spacing: 2px; font-size: 0.75rem;">Lokasi Kami</h6>
                <div class="rounded-3 overflow-hidden shadow-sm w-100" style="height: 180px; border: 1px solid #333;">
                    <iframe src="{{ $globalSettings['google_maps_url'] }}" 
                            width="100%" height="100%" 
                            style="border:0; filter: grayscale(100%) invert(90%) contrast(80%);" 
                            allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
            </div>
            @endif
        </div>

        <!-- Garis Pemisah & Copyright -->
        <div class="border-top pt-4" style="border-color: #333 !important;">
            <div class="row align-items-center">
                <div class="col-12 text-center">
                    <p class="small mb-0">
                        &copy; {{ date('Y') }} {{ $globalSettings['app_name'] ?? config('app.name') }}. All rights reserved.
                    </p>
                </div>
            </div>
        </div>
    </div>
</footer>

@push('styles')
<style>
    /* Efek Hover Link Footer */
    .footer-link {
        transition: all 0.3s ease;
        display: inline-block;
    }
    .footer-link:hover {
        color: #fff !important;
        transform: translateX(5px);
    }

    /* Efek Hover Ikon Sosmed */
    .transition-hover {
        transition: all 0.3s ease;
    }
    .transition-hover:hover {
        background-color: var(--dk-primary) !important;
        border-color: var(--dk-primary) !important;
        transform: translateY(-3px);
    }
</style>
@endpush