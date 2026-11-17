@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('page_title', 'Pengaturan Website')

@section('content')
    <!-- Header Editorial -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">SISTEM</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Pengaturan</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-auto-dismiss border-0 rounded-3 mb-4" style="background-color: rgba(38, 150, 111, 0.1); color: #26966F;">{{ session('success') }}</div>
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

    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row g-5">
            
            <!-- Kolom Kiri: Informasi Teks -->
            <div class="col-lg-8">
                
                <!-- 01. Identitas Toko -->
                <div class="mb-5">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 2px; font-size: 0.7rem;">01. IDENTITAS TOKO</span>
                        <div class="flex-grow-1" style="height: 1px; background-color: #e0d5cb;"></div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Nama Website / Toko <span class="text-danger">*</span></label>
                        <input type="text" name="app_name" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ $settings['app_name'] ?? '' }}" required style="border-bottom: 1px solid #ccc !important; font-size: 1.1rem; font-family: var(--dk-font-heading);">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Tagline</label>
                        <input type="text" name="app_tagline" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ $settings['app_tagline'] ?? '' }}" placeholder="Contoh: Masakan Rumahan Rasa Bintang Lima" style="border-bottom: 1px solid #ccc !important;">
                    </div>
                </div>

                <!-- 02. Kontak & Lokasi -->
                <div class="mb-5">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 2px; font-size: 0.7rem;">02. KONTAK & LOKASI</span>
                        <div class="flex-grow-1" style="height: 1px; background-color: #e0d5cb;"></div>
                    </div>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Nomor Telepon / WhatsApp</label>
                            <input type="text" name="contact_phone" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ $settings['contact_phone'] ?? '' }}" style="border-bottom: 1px solid #ccc !important;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Email Bisnis</label>
                            <input type="email" name="contact_email" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ $settings['contact_email'] ?? '' }}" style="border-bottom: 1px solid #ccc !important;">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Alamat Lengkap</label>
                            <input type="text" name="contact_address" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ $settings['contact_address'] ?? '' }}" placeholder="Jl. Contoh No. 123, Jakarta" style="border-bottom: 1px solid #ccc !important;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Jam Operasional (Weekday)</label>
                            <input type="text" name="operating_hours_weekday" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ $settings['operating_hours_weekday'] ?? 'Mon-Sat: 09:00am - 08:00pm' }}" placeholder="Mon-Sat: 09:00am - 08:00pm" style="border-bottom: 1px solid #ccc !important;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Jam Operasional (Weekend)</label>
                            <input type="text" name="operating_hours_weekend" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ $settings['operating_hours_weekend'] ?? 'Sunday: 10:00am - 06:00pm' }}" placeholder="Sunday: 10:00am - 06:00pm" style="border-bottom: 1px solid #ccc !important;">
                        </div>
                    </div>
                </div>

                <!-- 03. Footer & Sosial Media -->
                <div class="mb-5">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 2px; font-size: 0.7rem;">03. FOOTER & SOSIAL MEDIA</span>
                        <div class="flex-grow-1" style="height: 1px; background-color: #e0d5cb;"></div>
                    </div>

                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Deskripsi Footer</label>
                            <textarea name="footer_description" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" rows="2" placeholder="Deskripsi singkat toko untuk di footer..." style="border-bottom: 1px solid #ccc !important;">{{ $settings['footer_description'] ?? 'Menyajikan hidangan premium dengan bahan-bahan pilihan terbaik untuk pengalaman kuliner yang tak terlupakan.' }}</textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Link Instagram</label>
                            <input type="url" name="social_instagram" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ $settings['social_instagram'] ?? '' }}" placeholder="https://instagram.com/..." style="border-bottom: 1px solid #ccc !important;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Link Facebook</label>
                            <input type="url" name="social_facebook" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ $settings['social_facebook'] ?? '' }}" placeholder="https://facebook.com/..." style="border-bottom: 1px solid #ccc !important;">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Link TikTok</label>
                            <input type="url" name="social_tiktok" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ $settings['social_tiktok'] ?? '' }}" placeholder="https://tiktok.com/@..." style="border-bottom: 1px solid #ccc !important;">
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Link Embed Google Maps</label>
                            <input type="text" name="google_maps_url" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ $settings['google_maps_url'] ?? '' }}" placeholder="https://www.google.com/maps/embed?pb=..." style="border-bottom: 1px solid #ccc !important;">
                            <small class="text-muted mt-1 d-block" style="font-size: 0.7rem;">
                                Buka Google Maps > Cari lokasi > Share > Embed a map > Copy isi atribut <code>src="..."</code>.
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Logo & Tema -->
            <div class="col-lg-4">
                <div class="p-4 mb-4" style="background: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                    <h5 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">Logo & Tema</h5>
                    
                    <!-- Logo Upload -->
                    <div class="mb-4 text-center">
                        <label class="form-label fw-bold text-uppercase d-block text-start mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">Logo Website</label>
                        
                        @if(isset($settings['logo']) && $settings['logo'])
                            <div class="bg-secondary bg-opacity-10 rounded-3 p-3 mb-3 d-flex align-items-center justify-content-center" style="height: 120px;">
                                <img src="{{ Storage::url($settings['logo']) }}" class="img-fluid" style="max-height: 80px; object-fit: contain;" alt="Logo">
                            </div>
                        @else
                            <div class="bg-secondary bg-opacity-10 rounded-3 mb-3 d-flex align-items-center justify-content-center" style="height: 120px;">
                                <span class="text-muted small">Belum ada logo</span>
                            </div>
                        @endif
                        
                        <input type="file" name="logo" class="form-control border-0 px-0 bg-transparent shadow-none" accept="image/*" style="font-size: 0.85rem;">
                        <small class="text-muted d-block mt-2 text-start" style="font-size: 0.7rem;">Format: PNG, JPG, SVG (Maks 2MB)</small>
                    </div>

                    <hr style="border-color: #e0d5cb; opacity: 1; margin: 1.5rem 0;">

                    <!-- Warna Utama -->
                    <div class="mb-2">
                        <label class="form-label fw-bold text-uppercase d-flex justify-content-between align-items-center" style="font-size: 0.7rem; letter-spacing: 1px;">
                            <span>Warna Utama</span>
                            <span class="text-muted" style="font-family: monospace;">{{ $settings['primary_color'] ?? '#B76535' }}</span>
                        </label>
                        <div class="d-flex align-items-center gap-3 mt-2">
                            <input type="color" name="primary_color" class="form-control form-control-color border-0 p-0 rounded-circle shadow-sm" value="{{ $settings['primary_color'] ?? '#B76535' }}" style="width: 40px; height: 40px; cursor: pointer;">
                            <span class="text-muted small">Klik untuk mengubah warna tema.</span>
                        </div>
                    </div>
                </div>

                <!-- Tombol Simpan -->
                <div class="d-grid mt-4">
                    <button type="submit" class="btn btn-primary btn-lg py-3" style="border-radius: 50px;">
                        <i class="bi bi-save me-2"></i> Simpan Pengaturan
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection