@extends('layouts.admin')

@section('title', 'Konten Beranda')
@section('page_title', 'Manajemen Konten Beranda')

@section('content')
    <!-- Header Editorial -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">CMS</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Konten Beranda</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-auto-dismiss border-0 rounded-3 mb-4" style="background-color: rgba(38, 150, 111, 0.1); color: #26966F;">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.cms.homepage.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-5">
            
            <!-- Kolom Kiri: Hero & Why Choose Us -->
            <div class="col-lg-6">
                <!-- Hero Section -->
                <div class="p-4 mb-5" style="background: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                    <h5 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">Hero Section</h5>
                    
                    <div class="row g-3 mb-4">
                        <!-- Gambar 1 (Utama) -->
                        <div class="col-4 text-center">
                            <label class="form-label small fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Gambar Utama</label>
                            @if($hero->image)
                                <img src="{{ Storage::url($hero->image) }}" class="img-fluid rounded-3 mb-2 shadow-sm" style="height: 80px; width: 100%; object-fit: cover;">
                            @else
                                <div class="bg-secondary bg-opacity-10 rounded-3 mb-2 d-flex align-items-center justify-content-center" style="height: 80px;">
                                    <small class="text-muted" style="font-size: 0.7rem;">Kosong</small>
                                </div>
                            @endif
                            <input type="file" name="hero_image" class="form-control border-0 px-0 bg-transparent shadow-none" accept="image/*" style="font-size: 0.75rem;">
                        </div>

                        <!-- Gambar 2 (Atas) -->
                        <div class="col-4 text-center">
                            <label class="form-label small fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Atas Kanan</label>
                            @if(isset($hero->settings['hero_image_2']))
                                <img src="{{ Storage::url($hero->settings['hero_image_2']) }}" class="img-fluid rounded-3 mb-2 shadow-sm" style="height: 80px; width: 100%; object-fit: cover;">
                            @else
                                <div class="bg-secondary bg-opacity-10 rounded-3 mb-2 d-flex align-items-center justify-content-center" style="height: 80px;">
                                    <small class="text-muted" style="font-size: 0.7rem;">Kosong</small>
                                </div>
                            @endif
                            <input type="file" name="hero_image_2" class="form-control border-0 px-0 bg-transparent shadow-none" accept="image/*" style="font-size: 0.75rem;">
                        </div>

                        <!-- Gambar 3 (Bawah) -->
                        <div class="col-4 text-center">
                            <label class="form-label small fw-bold text-uppercase" style="font-size: 0.65rem; letter-spacing: 1px;">Bawah Kiri</label>
                            @if(isset($hero->settings['hero_image_3']))
                                <img src="{{ Storage::url($hero->settings['hero_image_3']) }}" class="img-fluid rounded-3 mb-2 shadow-sm" style="height: 80px; width: 100%; object-fit: cover;">
                            @else
                                <div class="bg-secondary bg-opacity-10 rounded-3 mb-2 d-flex align-items-center justify-content-center" style="height: 80px;">
                                    <small class="text-muted" style="font-size: 0.7rem;">Kosong</small>
                                </div>
                            @endif
                            <input type="file" name="hero_image_3" class="form-control border-0 px-0 bg-transparent shadow-none" accept="image/*" style="font-size: 0.75rem;">
                        </div>
                    </div>

                    <hr style="border-color: #e0d5cb; opacity: 1; margin-bottom: 1.5rem;">

                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Judul Utama</label>
                        <input type="text" name="hero_title" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ $hero->title }}" required style="border-bottom: 1px solid #ccc !important; font-size: 1.1rem;">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Deskripsi Singkat</label>
                        <textarea name="hero_content" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" rows="3" required style="border-bottom: 1px solid #ccc !important;">{{ $hero->content }}</textarea>
                    </div>
                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input shadow-none" type="checkbox" name="hero_is_active" id="hero_active" value="1" {{ $hero->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-medium" for="hero_active">Tampilkan Section Ini</label>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Why Choose Us -->
            <div class="col-lg-6">
                <div class="p-4 mb-5" style="background: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                    <h5 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">Why Choose Us</h5>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Judul Section</label>
                        <input type="text" name="why_title" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ $whyChooseUs->title }}" required style="border-bottom: 1px solid #ccc !important; font-size: 1.1rem;">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Deskripsi / Alasan</label>
                        <textarea name="why_content" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" rows="5" required style="border-bottom: 1px solid #ccc !important;">{{ $whyChooseUs->content }}</textarea>
                    </div>
                    <div class="form-check form-switch mt-4">
                        <input class="form-check-input shadow-none" type="checkbox" name="why_is_active" id="why_active" value="1" {{ $whyChooseUs->is_active ? 'checked' : '' }}>
                        <label class="form-check-label fw-medium" for="why_active">Tampilkan Section Ini</label>
                    </div>
                </div>
            </div>

            <!-- Tentang Kami (Full Width di Bawah) -->
            <div class="col-12">
                <div class="p-4" style="background: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                    <h5 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">Tentang Kami</h5>
                    
                    <div class="row g-5">
                        <div class="col-md-8">
                            <div class="mb-4">
                                <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Judul Section</label>
                                <input type="text" name="about_title" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ $aboutUs->title }}" required style="border-bottom: 1px solid #ccc !important; font-size: 1.1rem;">
                            </div>
                            <div class="mb-4">
                                <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Deskripsi</label>
                                <textarea name="about_content" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" rows="6" required style="border-bottom: 1px solid #ccc !important;">{{ $aboutUs->content }}</textarea>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input shadow-none" type="checkbox" name="about_is_active" id="about_active" value="1" {{ $aboutUs->is_active ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium" for="about_active">Tampilkan Section Ini</label>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            @if($aboutUs->image)
                                <img src="{{ Storage::url($aboutUs->image) }}" class="img-fluid rounded-3 mb-3 shadow-sm" style="height: 200px; width: 100%; object-fit: cover;">
                            @else
                                <div class="bg-secondary bg-opacity-10 rounded-3 mb-3 d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-image text-muted fs-1"></i>
                                </div>
                            @endif
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Gambar Tentang Kami</label>
                            <input type="file" name="about_image" class="form-control border-0 px-0 bg-transparent shadow-none" accept="image/*" style="font-size: 0.85rem;">
                            <small class="text-muted d-block mt-2" style="font-size: 0.7rem;">Rasio 4:3 atau 16:9 direkomendasikan.</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Simpan -->
        <div class="mt-5 text-end">
            <button type="submit" class="btn btn-primary px-5 py-3">
                <i class="bi bi-save me-2"></i> Simpan Konten Beranda
            </button>
        </div>
    </form>
@endsection