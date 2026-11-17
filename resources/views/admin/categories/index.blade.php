@extends('layouts.admin')

@section('title', 'Manajemen Kategori')
@section('page_title', 'Kategori Produk')

@section('content')
    <!-- Header Editorial -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">KATALOG</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Kategori</h1>
        </div>

        <div class="mt-4 mt-md-0">
            <button class="btn btn-primary px-4 py-2"
                    data-bs-toggle="modal"
                    data-bs-target="#createModal">
                <i class="bi bi-plus-lg me-2"></i> Tambah Kategori
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-auto-dismiss border-0 rounded-3 mb-4"
             style="background-color: rgba(38, 150, 111, 0.1); color: #26966F;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-auto-dismiss border-0 rounded-3 mb-4"
             style="background-color: rgba(220, 82, 82, 0.1); color: #DC5252;">
            {{ session('error') }}
        </div>
    @endif

    <!-- Tabel Kategori -->
    <div class="table-responsive">
        <table class="table align-middle mb-0" style="border-top: 2px solid var(--dk-text);">
            <thead>
                <tr class="text-uppercase text-muted"
                    style="font-size: 0.7rem; letter-spacing: 1px; border-bottom: 1px solid #e0d5cb;">
                    <th class="py-3 fw-bold">Nama Kategori</th>
                    <th class="py-3 fw-bold">Slug</th>
                    <th class="py-3 fw-bold">Status</th>
                    <th class="py-3 fw-bold text-end">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($categories as $cat)
                    <tr style="border-bottom: 1px solid #e0d5cb;">
                        <td class="py-3">
                            <div class="fw-bold"
                                 style="font-family: var(--dk-font-heading); font-size: 1.1rem;">
                                {{ $cat->name }}
                            </div>
                        </td>

                        <td class="py-3 text-muted">
                            {{ $cat->slug }}
                        </td>

                        <td class="py-3">
                            @if($cat->is_active)
                                <span class="badge rounded-pill border border-success text-success bg-transparent"
                                      style="font-weight: 600;">
                                    Aktif
                                </span>
                            @else
                                <span class="badge rounded-pill border border-danger text-danger bg-transparent"
                                      style="font-weight: 600;">
                                    Nonaktif
                                </span>
                            @endif
                        </td>

                        <td class="py-3 text-end">
                            <button type="button"
                                    class="btn btn-sm btn-link text-muted p-1 me-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $cat->id }}"
                                    title="Edit">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </button>

                            <form action="{{ route('admin.categories.destroy', $cat->id) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        class="btn btn-sm btn-link text-muted p-1"
                                        title="Hapus"
                                        data-confirm-title="Hapus kategori ini?"
                                        data-confirm="Kategori <strong>{{ $cat->name }}</strong> akan dihapus permanen.">
                                    <i class="bi bi-trash fs-5"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            Belum ada kategori produk.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categories->links('pagination::bootstrap-5') }}
    </div>


    {{-- ================================================= --}}
    {{-- MODAL EDIT KATEGORI --}}
    {{-- ================================================= --}}

    @foreach($categories as $cat)
        <div class="modal fade category-modal"
             id="editModal{{ $cat->id }}"
             tabindex="-1"
             aria-labelledby="editModalLabel{{ $cat->id }}"
             aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <form action="{{ route('admin.categories.update', $cat->id) }}"
                      method="POST"
                      class="modal-content border-0 shadow-lg">

                    @csrf
                    @method('PUT')

                    <div class="modal-header border-0 pb-0">
                        <div>
                            <span class="text-uppercase fw-bold text-muted d-block"
                                  style="letter-spacing: 2px; font-size: 0.65rem;">
                                Ubah Data
                            </span>

                            <h5 class="modal-title fw-bold mb-0"
                                id="editModalLabel{{ $cat->id }}"
                                style="font-family: var(--dk-font-heading);">
                                Edit Kategori
                            </h5>
                        </div>

                        <button type="button"
                                class="btn-close shadow-none"
                                data-bs-dismiss="modal"
                                aria-label="Tutup">
                        </button>
                    </div>

                    <div class="modal-body py-4">

                        <div class="mb-4">
                            <label for="edit_name_{{ $cat->id }}"
                                   class="form-label fw-bold text-uppercase"
                                   style="font-size: 0.7rem; letter-spacing: 1px;">
                                Nama Kategori
                            </label>

                            <input type="text"
                                   name="name"
                                   id="edit_name_{{ $cat->id }}"
                                   class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none"
                                   value="{{ old('name', $cat->name) }}"
                                   required
                                   style="border-bottom: 1px solid #ccc !important;">
                        </div>

                        <div class="mb-4">
                            <label for="edit_slug_{{ $cat->id }}"
                                   class="form-label fw-bold text-uppercase"
                                   style="font-size: 0.7rem; letter-spacing: 1px;">
                                Slug
                            </label>

                            <input type="text"
                                   name="slug"
                                   id="edit_slug_{{ $cat->id }}"
                                   class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none"
                                   value="{{ old('slug', $cat->slug) }}"
                                   style="border-bottom: 1px solid #ccc !important;">

                            <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                                Biarkan kosong untuk generate otomatis dari nama.
                            </small>
                        </div>

                        <div class="mb-4">
                            <label for="edit_desc_{{ $cat->id }}"
                                   class="form-label fw-bold text-uppercase"
                                   style="font-size: 0.7rem; letter-spacing: 1px;">
                                Deskripsi
                            </label>

                            <textarea name="description"
                                      id="edit_desc_{{ $cat->id }}"
                                      rows="3"
                                      class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none"
                                      style="border-bottom: 1px solid #ccc !important;">{{ old('description', $cat->description) }}</textarea>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input shadow-none"
                                   type="checkbox"
                                   name="is_active"
                                   value="1"
                                   id="edit_is_active_{{ $cat->id }}"
                                   {{ old('is_active', $cat->is_active) ? 'checked' : '' }}>

                            <label class="form-check-label fw-medium"
                                   for="edit_is_active_{{ $cat->id }}">
                                Tampilkan Kategori Ini
                            </label>
                        </div>
                    </div>

                    <div class="modal-footer border-0 pt-0">
                        <button type="button"
                                class="btn btn-link text-muted text-decoration-none"
                                data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-primary px-4">
                            Simpan Perubahan
                        </button>
                    </div>

                </form>
            </div>
        </div>
    @endforeach


    {{-- ================================================= --}}
    {{-- MODAL TAMBAH KATEGORI --}}
    {{-- ================================================= --}}

    <div class="modal fade category-modal"
         id="createModal"
         tabindex="-1"
         aria-labelledby="createModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="{{ route('admin.categories.store') }}"
                  method="POST"
                  class="modal-content border-0 shadow-lg">

                @csrf

                <div class="modal-header border-0 pb-0">
                    <div>
                        <span class="text-uppercase fw-bold text-muted d-block"
                              style="letter-spacing: 2px; font-size: 0.65rem;">
                            Kategori Baru
                        </span>

                        <h5 class="modal-title fw-bold mb-0"
                            id="createModalLabel"
                            style="font-family: var(--dk-font-heading);">
                            Tambah Kategori
                        </h5>
                    </div>

                    <button type="button"
                            class="btn-close shadow-none"
                            data-bs-dismiss="modal"
                            aria-label="Tutup">
                    </button>
                </div>

                <div class="modal-body py-4">

                    <div class="mb-4">
                        <label for="create_name"
                               class="form-label fw-bold text-uppercase"
                               style="font-size: 0.7rem; letter-spacing: 1px;">
                            Nama Kategori
                        </label>

                        <input type="text"
                               name="name"
                               id="create_name"
                               class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none"
                               placeholder="Contoh: Makanan Utama"
                               required
                               style="border-bottom: 1px solid #ccc !important;">
                    </div>

                    <div class="mb-4">
                        <label for="create_desc"
                               class="form-label fw-bold text-uppercase"
                               style="font-size: 0.7rem; letter-spacing: 1px;">
                            Deskripsi (Opsional)
                        </label>

                        <textarea name="description"
                                  id="create_desc"
                                  rows="3"
                                  class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none"
                                  placeholder="Deskripsi singkat kategori..."
                                  style="border-bottom: 1px solid #ccc !important;"></textarea>
                    </div>

                    <div class="form-check form-switch">
                        <input class="form-check-input shadow-none"
                               type="checkbox"
                               name="is_active"
                               value="1"
                               id="create_is_active"
                               checked>

                        <label class="form-check-label fw-medium"
                               for="create_is_active">
                            Tampilkan Kategori Ini
                        </label>
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button"
                            class="btn btn-link text-muted text-decoration-none"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary px-4">
                        Simpan Kategori
                    </button>
                </div>

            </form>
        </div>
    </div>


    {{-- ================================================= --}}
    {{-- CSS MODAL FIX --}}
    {{-- ================================================= --}}

    <style>
        /* --- TAMBAHAN BARU: Menghilangkan background putih pada tabel --- */
        .table, 
        .table tbody, 
        .table tr, 
        .table td, 
        .table th {
            background-color: transparent !important;
            --bs-table-bg: transparent !important;
            --bs-table-accent-bg: transparent !important;
            box-shadow: none !important;
        }
        /* ----------------------------------------------------------------- */

        .category-modal {
            z-index: 2000 !important;
        }

        .modal-backdrop {
            z-index: 1990 !important;
        }

        .category-modal .modal-dialog {
            max-width: 520px;
            width: calc(100% - 30px);
        }

        .category-modal .modal-content {
            position: relative;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
        }

        .category-modal .modal-body {
            max-height: 65vh;
            overflow-y: auto;
        }

        .category-modal .modal-footer {
            padding: 1rem 1.5rem 1.5rem;
        }

        .category-modal .form-control:focus {
            box-shadow: none;
            border-bottom-color: #26966F !important;
        }

        .category-modal .form-check-input:checked {
            background-color: #26966F;
            border-color: #26966F;
        }

        body.modal-open {
            overflow: hidden !important;
        }
    </style>

    {{-- ================================================= --}}
    {{-- JAVASCRIPT MODAL FIX --}}
    {{-- ================================================= --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Pindahkan semua modal langsung ke body
            document.querySelectorAll('.category-modal').forEach(function (modal) {
                document.body.appendChild(modal);
            });

        });
    </script>

@endsection