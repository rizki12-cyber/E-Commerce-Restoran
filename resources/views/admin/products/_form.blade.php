@if ($errors->any())
    <div class="alert alert-danger border-0 rounded-3 mb-4" style="background-color: rgba(220, 82, 82, 0.1); color: #DC5252;">
        <ul class="mb-0 small">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row g-5">
    <!-- Kolom Kiri: Informasi & Harga -->
    <div class="col-lg-8">
        
        <!-- Section 1: Informasi Produk -->
        <div class="mb-5">
            <div class="d-flex align-items-center gap-3 mb-4">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 2px; font-size: 0.7rem;">01. INFORMASI DASAR</span>
                <div class="flex-grow-1" style="height: 1px; background-color: #e0d5cb;"></div>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Nama Produk <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ old('name', $product->name ?? '') }}" required style="border-bottom: 1px solid #ccc !important; font-size: 1.1rem;">
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Deskripsi Singkat</label>
                <textarea name="short_description" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" rows="2" style="border-bottom: 1px solid #ccc !important;">{{ old('short_description', $product->short_description ?? '') }}</textarea>
            </div>
            
            <div class="mb-4">
                <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Deskripsi Lengkap <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" rows="5" required style="border-bottom: 1px solid #ccc !important;">{{ old('description', $product->description ?? '') }}</textarea>
            </div>
        </div>

        <!-- Section 2: Harga & Stok -->
        <div>
            <div class="d-flex align-items-center gap-3 mb-4">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 2px; font-size: 0.7rem;">02. HARGA & STOK</span>
                <div class="flex-grow-1" style="height: 1px; background-color: #e0d5cb;"></div>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Harga Normal (Rp) <span class="text-danger">*</span></label>
                    <input type="number" name="price" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ old('price', $product->price ?? '') }}" required min="0" style="border-bottom: 1px solid #ccc !important;">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Harga Diskon (Rp)</label>
                    <input type="number" name="discount_price" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ old('discount_price', $product->discount_price ?? '') }}" min="0" style="border-bottom: 1px solid #ccc !important;">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Stok Tersedia <span class="text-danger">*</span></label>
                    <input type="number" name="stock" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ old('stock', $product->stock ?? 0) }}" required min="0" style="border-bottom: 1px solid #ccc !important;">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Minimal Stok (Peringatan) <span class="text-danger">*</span></label>
                    <input type="number" name="min_stock" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ old('min_stock', $product->min_stock ?? 5) }}" required min="0" style="border-bottom: 1px solid #ccc !important;">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">SKU Produk <span class="text-danger">*</span></label>
                    <input type="text" name="sku" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ old('sku', $product->sku ?? '') }}" required style="border-bottom: 1px solid #ccc !important;">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Kategori <span class="text-danger">*</span></label>
                    <select name="category_id" class="form-select border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" required style="border-bottom: 1px solid #ccc !important;">
                        <option value="">-- Pilih Kategori --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id ?? '') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <!-- Kolom Kanan: Gambar & Status (Gaya Kaca/Glassmorphism) -->
    <div class="col-lg-4">
        <div class="p-4 mb-4" style="background: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
            <h6 class="fw-bold mb-3 text-uppercase" style="letter-spacing: 1px; font-size: 0.75rem;">Gambar Utama</h6>
            
            @if(isset($product) && $product->primary_image)
                <img src="{{ Storage::url($product->primary_image) }}" class="img-fluid rounded-3 mb-3 shadow-sm" style="width: 100%; height: 200px; object-fit: cover;" alt="Preview">
            @else
                <div class="bg-secondary bg-opacity-10 rounded-3 mb-3 d-flex align-items-center justify-content-center" style="height: 200px;">
                    <i class="bi bi-image text-muted fs-1"></i>
                </div>
            @endif

            <input type="file" name="primary_image" class="form-control border-0 px-0 bg-transparent shadow-none" accept="image/*" style="font-size: 0.85rem;">
            <small class="text-muted d-block mt-2" style="font-size: 0.7rem;">Format: JPG, PNG, WEBP. Maks 2MB.</small>
        </div>

        <div class="p-4 mb-4" style="background: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
            <h6 class="fw-bold mb-3 text-uppercase" style="letter-spacing: 1px; font-size: 0.75rem;">Pengaturan Status</h6>
            
            <div class="form-check form-switch mb-3">
                <input class="form-check-input shadow-none" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
                <label class="form-check-label fw-medium" for="is_active">Produk Aktif</label>
            </div>
            <div class="form-check form-switch mb-3">
                <input class="form-check-input shadow-none" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $product->is_featured ?? false) ? 'checked' : '' }}>
                <label class="form-check-label fw-medium" for="is_featured">Produk Unggulan</label>
            </div>
            <div class="form-check form-switch">
                <input class="form-check-input shadow-none" type="checkbox" name="is_best_seller" id="is_best_seller" value="1" {{ old('is_best_seller', $product->is_best_seller ?? false) ? 'checked' : '' }}>
                <label class="form-check-label fw-medium" for="is_best_seller">Best Seller</label>
            </div>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-primary py-2">
                <i class="bi bi-save me-1"></i> Simpan Produk
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-link text-muted text-decoration-none py-2">Batal</a>
        </div>
    </div>
</div>