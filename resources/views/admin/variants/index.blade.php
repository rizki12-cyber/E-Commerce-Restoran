@extends('layouts.admin')

@section('title', 'Variasi & Add-on')
@section('page_title', 'Variasi & Add-on')

@section('content')
    <!-- Header Editorial -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">KATALOG</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Variasi & Add-on</h1>
        </div>
    </div>

    <!-- Pemilih Produk Minimalis -->
    <div class="p-4 mb-5" style="background: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
        <form action="{{ route('admin.variants.index') }}" method="GET" class="d-flex flex-column flex-md-row gap-4 align-items-md-end">
            <div class="flex-grow-1">
                <label for="product_select" class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Pilih Produk untuk Dikelola</label>
                <select name="product_id" id="product_select" class="form-select border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" onchange="this.form.submit()" style="border-bottom: 1px solid #ccc !important; font-size: 1.1rem; font-family: var(--dk-font-heading);">
                    <option value="">-- Pilih Produk --</option>
                    @foreach($products as $p)
                        <option value="{{ $p->id }}" {{ request('product_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-auto-dismiss border-0 rounded-3 mb-4" style="background-color: rgba(38, 150, 111, 0.1); color: #26966F;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-auto-dismiss border-0 rounded-3 mb-4" style="background-color: rgba(220, 82, 82, 0.1); color: #DC5252;">{{ session('error') }}</div>
    @endif

    @if($selectedProduct)
        <div class="row g-5">
            <!-- Kolom Kiri: Variasi -->
            <div class="col-lg-6">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2" style="border-color: #e0d5cb !important;">
                    <h4 class="fw-bold mb-0" style="font-family: var(--dk-font-heading);">Variasi Produk</h4>
                    <button class="btn btn-sm btn-outline-dark rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addVariantModal">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </button>
                </div>
                
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr class="text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 1px;">
                                <th class="py-3 fw-bold border-0">Nama Variasi</th>
                                <th class="py-3 fw-bold border-0">Harga (+)</th>
                                <th class="py-3 fw-bold border-0 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($selectedProduct->variants as $v)
                                <tr style="border-bottom: 1px solid #e0d5cb;">
                                    <td class="py-3 fw-medium text-dark">{{ $v->name }}</td>
                                    <td class="py-3 text-muted">Rp {{ number_format($v->additional_price, 0, ',', '.') }}</td>
                                    <td class="py-3 text-end">
                                        <button class="btn btn-sm btn-link text-muted p-1 me-2" data-bs-toggle="modal" data-bs-target="#editVariantModal{{ $v->id }}" title="Edit">
                                            <i class="bi bi-pencil-square fs-5"></i>
                                        </button>
                                        <form action="{{ route('admin.variants.destroy', $v->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus variasi ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-link text-muted p-1" title="Hapus">
                                                <i class="bi bi-trash fs-5"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">Belum ada variasi untuk produk ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Kolom Kanan: Add-on -->
            <div class="col-lg-6">
                <div class="d-flex justify-content-between align-items-center mb-3 border-bottom pb-2" style="border-color: #e0d5cb !important;">
                    <h4 class="fw-bold mb-0" style="font-family: var(--dk-font-heading);">Tambahan (Add-on)</h4>
                    <button class="btn btn-sm btn-outline-dark rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#addAddonModal">
                        <i class="bi bi-plus-lg me-1"></i> Tambah
                    </button>
                </div>
                
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead>
                            <tr class="text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 1px;">
                                <th class="py-3 fw-bold border-0">Nama Add-on</th>
                                <th class="py-3 fw-bold border-0">Harga</th>
                                <th class="py-3 fw-bold border-0 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($selectedProduct->addons as $a)
                                <tr style="border-bottom: 1px solid #e0d5cb;">
                                    <td class="py-3 fw-medium text-dark">{{ $a->name }}</td>
                                    <td class="py-3 text-muted">Rp {{ number_format($a->price, 0, ',', '.') }}</td>
                                    <td class="py-3 text-end">
                                        <button class="btn btn-sm btn-link text-muted p-1 me-2" data-bs-toggle="modal" data-bs-target="#editAddonModal{{ $a->id }}" title="Edit">
                                            <i class="bi bi-pencil-square fs-5"></i>
                                        </button>
                                        <form action="{{ route('admin.addons.destroy', $a->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus add-on ini?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-link text-muted p-1" title="Hapus">
                                                <i class="bi bi-trash fs-5"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-5 text-muted">Belum ada add-on untuk produk ini.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- ============================================================ -->
        <!-- EDIT MODAL VARIASI — DI LUAR <tbody> (valid HTML & responsif) -->
        <!-- ============================================================ -->
        @foreach($selectedProduct->variants as $v)
            <div class="modal fade" id="editVariantModal{{ $v->id }}" tabindex="-1"
                 aria-labelledby="editVariantLabel{{ $v->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form action="{{ route('admin.variants.update', $v->id) }}" method="POST"
                          class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                        @csrf @method('PUT')

                        <div class="modal-header border-0 pb-0">
                            <div>
                                <span class="text-uppercase fw-bold text-muted d-block"
                                      style="letter-spacing: 2px; font-size: 0.65rem;">Ubah Variasi</span>
                                <h5 class="modal-title fw-bold mb-0"
                                    id="editVariantLabel{{ $v->id }}"
                                    style="font-family: var(--dk-font-heading);">
                                    Edit Variasi
                                </h5>
                            </div>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>

                        <div class="modal-body py-4">
                            <div class="mb-4">
                                <label for="edit_var_name_{{ $v->id }}" class="form-label fw-bold text-uppercase"
                                       style="font-size: 0.7rem; letter-spacing: 1px;">Nama Variasi</label>
                                <input type="text" name="name" id="edit_var_name_{{ $v->id }}"
                                       class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none @error('name') is-invalid @enderror"
                                       value="{{ $v->name }}" required
                                       style="border-bottom: 1px solid #ccc !important;">
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="edit_var_price_{{ $v->id }}" class="form-label fw-bold text-uppercase"
                                       style="font-size: 0.7rem; letter-spacing: 1px;">Harga Tambahan (Rp)</label>
                                <input type="number" name="additional_price" id="edit_var_price_{{ $v->id }}"
                                       class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none @error('additional_price') is-invalid @enderror"
                                       value="{{ $v->additional_price }}" required min="0" step="100"
                                       style="border-bottom: 1px solid #ccc !important;">
                                @error('additional_price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input shadow-none" type="checkbox" name="is_active"
                                       id="edit_var_active_{{ $v->id }}" {{ $v->is_active ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium" for="edit_var_active_{{ $v->id }}">
                                    Tampilkan Variasi
                                </label>
                            </div>
                        </div>

                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

        <!-- ============================================================ -->
        <!-- EDIT MODAL ADD-ON — DI LUAR <tbody>                          -->
        <!-- ============================================================ -->
        @foreach($selectedProduct->addons as $a)
            <div class="modal fade" id="editAddonModal{{ $a->id }}" tabindex="-1"
                 aria-labelledby="editAddonLabel{{ $a->id }}" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <form action="{{ route('admin.addons.update', $a->id) }}" method="POST"
                          class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                        @csrf @method('PUT')

                        <div class="modal-header border-0 pb-0">
                            <div>
                                <span class="text-uppercase fw-bold text-muted d-block"
                                      style="letter-spacing: 2px; font-size: 0.65rem;">Ubah Add-on</span>
                                <h5 class="modal-title fw-bold mb-0"
                                    id="editAddonLabel{{ $a->id }}"
                                    style="font-family: var(--dk-font-heading);">
                                    Edit Add-on
                                </h5>
                            </div>
                            <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Tutup"></button>
                        </div>

                        <div class="modal-body py-4">
                            <div class="mb-4">
                                <label for="edit_addon_name_{{ $a->id }}" class="form-label fw-bold text-uppercase"
                                       style="font-size: 0.7rem; letter-spacing: 1px;">Nama Add-on</label>
                                <input type="text" name="name" id="edit_addon_name_{{ $a->id }}"
                                       class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none @error('name') is-invalid @enderror"
                                       value="{{ $a->name }}" required
                                       style="border-bottom: 1px solid #ccc !important;">
                                @error('name')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="edit_addon_price_{{ $a->id }}" class="form-label fw-bold text-uppercase"
                                       style="font-size: 0.7rem; letter-spacing: 1px;">Harga (Rp)</label>
                                <input type="number" name="price" id="edit_addon_price_{{ $a->id }}"
                                       class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none @error('price') is-invalid @enderror"
                                       value="{{ $a->price }}" required min="0" step="100"
                                       style="border-bottom: 1px solid #ccc !important;">
                                @error('price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input shadow-none" type="checkbox" name="is_active"
                                       id="edit_addon_active_{{ $a->id }}" {{ $a->is_active ? 'checked' : '' }}>
                                <label class="form-check-label fw-medium" for="edit_addon_active_{{ $a->id }}">
                                    Tampilkan Add-on
                                </label>
                            </div>
                        </div>

                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary px-4">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach

        <!-- ============================================================ -->
        <!-- CREATE MODAL VARIASI                                         -->
        <!-- ============================================================ -->
        <div class="modal fade" id="addVariantModal" tabindex="-1"
             aria-labelledby="addVariantLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <form action="{{ route('admin.variants.store', $selectedProduct->id) }}" method="POST"
                      class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                    @csrf

                    <div class="modal-header border-0 pb-0">
                        <div>
                            <span class="text-uppercase fw-bold text-muted d-block"
                                  style="letter-spacing: 2px; font-size: 0.65rem;">Variasi Baru</span>
                            <h5 class="modal-title fw-bold mb-0" id="addVariantLabel"
                                style="font-family: var(--dk-font-heading);">
                                Tambah Variasi
                            </h5>
                        </div>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body py-4">
                        <div class="mb-4">
                            <label for="add_variant_name" class="form-label fw-bold text-uppercase"
                                   style="font-size: 0.7rem; letter-spacing: 1px;">Nama Variasi</label>
                            <input type="text" name="name" id="add_variant_name"
                                   class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none @error('name') is-invalid @enderror"
                                   placeholder="Contoh: Level Pedas 1" value="{{ old('name') }}" required
                                   style="border-bottom: 1px solid #ccc !important;">
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="add_variant_price" class="form-label fw-bold text-uppercase"
                                   style="font-size: 0.7rem; letter-spacing: 1px;">Harga Tambahan (Rp)</label>
                            <input type="number" name="additional_price" id="add_variant_price"
                                   class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none @error('additional_price') is-invalid @enderror"
                                   value="{{ old('additional_price', 0) }}" required min="0" step="100"
                                   style="border-bottom: 1px solid #ccc !important;">
                            @error('additional_price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input shadow-none" type="checkbox" name="is_active"
                                   id="add_variant_active" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="add_variant_active">
                                Tampilkan Variasi
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- ============================================================ -->
        <!-- CREATE MODAL ADD-ON                                          -->
        <!-- ============================================================ -->
        <div class="modal fade" id="addAddonModal" tabindex="-1"
             aria-labelledby="addAddonLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <form action="{{ route('admin.addons.store', $selectedProduct->id) }}" method="POST"
                      class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                    @csrf

                    <div class="modal-header border-0 pb-0">
                        <div>
                            <span class="text-uppercase fw-bold text-muted d-block"
                                  style="letter-spacing: 2px; font-size: 0.65rem;">Add-on Baru</span>
                            <h5 class="modal-title fw-bold mb-0" id="addAddonLabel"
                                style="font-family: var(--dk-font-heading);">
                                Tambah Add-on
                            </h5>
                        </div>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body py-4">
                        <div class="mb-4">
                            <label for="add_addon_name" class="form-label fw-bold text-uppercase"
                                   style="font-size: 0.7rem; letter-spacing: 1px;">Nama Add-on</label>
                            <input type="text" name="name" id="add_addon_name"
                                   class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none @error('name') is-invalid @enderror"
                                   placeholder="Contoh: Extra Telur" value="{{ old('name') }}" required
                                   style="border-bottom: 1px solid #ccc !important;">
                            @error('name')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="add_addon_price" class="form-label fw-bold text-uppercase"
                                   style="font-size: 0.7rem; letter-spacing: 1px;">Harga (Rp)</label>
                            <input type="number" name="price" id="add_addon_price"
                                   class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none @error('price') is-invalid @enderror"
                                   value="{{ old('price') }}" required min="0" step="100"
                                   style="border-bottom: 1px solid #ccc !important;">
                            @error('price')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input shadow-none" type="checkbox" name="is_active"
                                   id="add_addon_active" {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium" for="add_addon_active">
                                Tampilkan Add-on
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    // Auto-open modal edit yang gagal validasi (jika controller me-flash key-nya)
    document.addEventListener('DOMContentLoaded', function () {
        @if(session('edit_variant_id'))
            var elV = document.getElementById('editVariantModal{{ session('edit_variant_id') }}');
            if (elV) new bootstrap.Modal(elV).show();
        @endif
        @if(session('edit_addon_id'))
            var elA = document.getElementById('editAddonModal{{ session('edit_addon_id') }}');
            if (elA) new bootstrap.Modal(elA).show();
        @endif
    });
</script>
@endpush