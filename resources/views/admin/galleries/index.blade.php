@extends('layouts.admin')

@section('title', 'Galeri Foto')
@section('page_title', 'Manajemen Galeri Foto')

@section('content')
    <!-- Header Editorial -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">CMS</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Galeri Foto</h1>
        </div>
        <div class="mt-4 mt-md-0">
            <button class="btn btn-primary px-4 py-2" data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-upload me-2"></i> Unggah Foto
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-auto-dismiss border-0 rounded-3 mb-4" style="background-color: rgba(38, 150, 111, 0.1); color: #26966F;">{{ session('success') }}</div>
    @endif

    <!-- Grid Galeri -->
    <div class="row g-4">
        @forelse($galleries as $gallery)
            <div class="col-6 col-md-4 col-lg-3">
                <!-- Kartu Galeri Tanpa Kotak Kaku -->
                <div class="d-flex flex-column h-100">
                    <!-- Gambar -->
                    <div class="position-relative overflow-hidden rounded-3 mb-3 shadow-sm" style="aspect-ratio: 4/5;">
                        <img src="{{ Storage::url($gallery->image) }}" class="w-100 h-100 object-fit-cover transition-img" alt="{{ $gallery->title ?? 'Galeri' }}">
                        
                        <!-- Status Badge Melayang -->
                        @if(!$gallery->is_active)
                            <span class="position-absolute top-0 start-0 m-2 badge bg-danger bg-opacity-75 text-white border-0">Nonaktif</span>
                        @endif
                    </div>

                    <!-- Info & Aksi -->
                    <div class="d-flex justify-content-between align-items-start mt-auto">
                        <div>
                            <h6 class="fw-bold mb-1" style="font-family: var(--dk-font-heading); font-size: 1.05rem;">
                                {{ $gallery->title ?? 'Tanpa Judul' }}
                            </h6>
                            <small class="text-muted text-uppercase" style="letter-spacing: 1px; font-size: 0.65rem;">
                                {{ $gallery->created_at->format('d M Y') }}
                            </small>
                        </div>
                        
                        <div class="d-flex gap-1">
                            <button class="btn btn-sm btn-link text-muted p-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $gallery->id }}" title="Edit">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </button>
                            <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="button" class="btn btn-sm btn-link text-muted p-1"
                                        title="Hapus"
                                        data-confirm-title="Hapus foto ini?"
                                        data-confirm="Foto <strong>{{ $gallery->title }}</strong> akan dihapus permanen.">
                                    <i class="bi bi-trash fs-5"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 my-5">
                <i class="bi bi-images text-muted mb-3 d-block" style="font-size: 4rem; opacity: 0.3;"></i>
                <h3 class="fw-bold" style="font-family: var(--dk-font-heading);">Galeri Kosong</h3>
                <p class="text-muted">Belum ada foto yang diunggah untuk galeri ini.</p>
            </div>
        @endforelse
    </div>
    
    <div class="mt-5 d-flex justify-content-center">
        {{ $galleries->links('pagination::bootstrap-5') }}
    </div>

    <!-- ============================================== -->
    <!-- MODALS DIPINDAHKAN KE LUAR LOOPING AGAR VALID -->
    <!-- ============================================== -->

    <!-- Loop untuk Edit Modals -->
    @foreach($galleries as $gallery)
        <div class="modal fade" id="editModal{{ $gallery->id }}" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
                <form action="{{ route('admin.galleries.update', $gallery->id) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                    @csrf @method('PUT')
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold" style="font-family: var(--dk-font-heading);">Edit Foto Galeri</h5>
                        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body py-4">
                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Judul (Opsional)</label>
                            <input type="text" name="title" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ $gallery->title }}" style="border-bottom: 1px solid #ccc !important;">
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Ganti Foto (Biarkan kosong jika tidak diubah)</label>
                            <input type="file" name="image" class="form-control border-0 px-0 bg-transparent shadow-none" accept="image/*" style="font-size: 0.85rem;">
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input shadow-none" type="checkbox" name="is_active" {{ $gallery->is_active ? 'checked' : '' }}>
                            <label class="form-check-label fw-medium">Tampilkan di Website</label>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

    <!-- Create Modal Premium -->
    <div class="modal fade" id="createModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" style="font-family: var(--dk-font-heading);">Unggah Foto Baru</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Foto (Wajib)</label>
                        <input type="file" name="image" class="form-control border-0 px-0 bg-transparent shadow-none" required accept="image/*" style="font-size: 0.85rem;">
                    </div>
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Judul (Opsional)</label>
                        <input type="text" name="title" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" placeholder="Contoh: Suasana Restoran" style="border-bottom: 1px solid #ccc !important;">
                    </div>
                    <div class="form-check form-switch">
                        <input class="form-check-input shadow-none" type="checkbox" name="is_active" checked>
                        <label class="form-check-label fw-medium">Tampilkan di Website</label>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4">Unggah Foto</button>
                </div>
            </form>
        </div>
    </div>
@endsection