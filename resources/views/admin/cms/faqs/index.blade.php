
@extends('layouts.admin')

@section('title', 'Manajemen FAQ')
@section('page_title', 'Daftar FAQ')

@section('content')
    <!-- Header Editorial -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">CMS</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Pertanyaan Umum (FAQ)</h1>
        </div>

        <div class="mt-4 mt-md-0">
            <button type="button" class="btn btn-primary px-4 py-2"
                    data-bs-toggle="modal"
                    data-bs-target="#createFaqModal">
                <i class="bi bi-plus-lg me-2"></i> Tambah FAQ
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

    <!-- Tabel FAQ -->
    <div class="table-responsive">
        <table class="table align-middle mb-0" style="border-top: 2px solid var(--dk-text);">
            <thead>
                <tr class="text-uppercase text-muted"
                    style="font-size: 0.7rem; letter-spacing: 1px; border-bottom: 1px solid #e0d5cb;">
                    <th class="py-3 fw-bold">Pertanyaan</th>
                    <th class="py-3 fw-bold">Jawaban Singkat</th>
                    <th class="py-3 fw-bold">Status</th>
                    <th class="py-3 fw-bold text-end">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($faqs as $faq)
                    <tr style="border-bottom: 1px solid #e0d5cb;">
                        <td class="py-3">
                            <div class="fw-bold"
                                 style="font-family: var(--dk-font-heading); font-size: 1.05rem;">
                                {{ $faq->question }}
                            </div>
                        </td>

                        <td class="py-3 text-muted" style="max-width: 300px;">
                            {{ Str::limit($faq->answer, 60) }}
                        </td>

                        <td class="py-3">
                            @if($faq->is_active)
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
                                    data-bs-target="#editFaqModal{{ $faq->id }}"
                                    title="Edit">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </button>

                            <form action="{{ route('admin.cms.faqs.destroy', $faq->id) }}"
                                  method="POST"
                                  class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        class="btn btn-sm btn-link text-muted p-1"
                                        title="Hapus"
                                        data-confirm-title="Hapus FAQ ini?"
                                        data-confirm="FAQ <strong>{{ $faq->question }}</strong> akan dihapus permanen.">
                                    <i class="bi bi-trash fs-5"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            Belum ada FAQ yang ditambahkan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $faqs->links('pagination::bootstrap-5') }}
    </div>

    <!-- ========================================== -->
    <!-- MODAL EDIT FAQ -->
    <!-- ========================================== -->

    @foreach($faqs as $faq)
        <div class="modal fade faq-modal"
             id="editFaqModal{{ $faq->id }}"
             tabindex="-1"
             aria-labelledby="editFaqModalLabel{{ $faq->id }}"
             aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <form action="{{ route('admin.cms.faqs.update', $faq->id) }}"
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
                                id="editFaqModalLabel{{ $faq->id }}"
                                style="font-family: var(--dk-font-heading);">
                                Edit FAQ
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
                            <label for="edit_question_{{ $faq->id }}"
                                   class="form-label fw-bold text-uppercase"
                                   style="font-size: 0.7rem; letter-spacing: 1px;">
                                Pertanyaan
                            </label>

                            <input type="text"
                                   name="question"
                                   id="edit_question_{{ $faq->id }}"
                                   class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none"
                                   value="{{ $faq->question }}"
                                   required
                                   style="border-bottom: 1px solid #ccc !important; font-size: 1.05rem;">
                        </div>

                        <div class="mb-4">
                            <label for="edit_answer_{{ $faq->id }}"
                                   class="form-label fw-bold text-uppercase"
                                   style="font-size: 0.7rem; letter-spacing: 1px;">
                                Jawaban
                            </label>

                            <textarea name="answer"
                                      id="edit_answer_{{ $faq->id }}"
                                      rows="4"
                                      class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none"
                                      required
                                      style="border-bottom: 1px solid #ccc !important; resize: none;">{{ $faq->answer }}</textarea>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input shadow-none"
                                   type="checkbox"
                                   name="is_active"
                                   value="1"
                                   id="edit_is_active_{{ $faq->id }}"
                                   {{ $faq->is_active ? 'checked' : '' }}>

                            <label class="form-check-label fw-medium"
                                   for="edit_is_active_{{ $faq->id }}">
                                Tampilkan FAQ ini
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

    <!-- ========================================== -->
    <!-- MODAL TAMBAH FAQ -->
    <!-- ========================================== -->

    <div class="modal fade faq-modal"
         id="createFaqModal"
         tabindex="-1"
         aria-labelledby="createFaqModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="{{ route('admin.cms.faqs.store') }}"
                  method="POST"
                  class="modal-content border-0 shadow-lg">

                @csrf

                <div class="modal-header border-0 pb-0">
                    <div>
                        <span class="text-uppercase fw-bold text-muted d-block"
                              style="letter-spacing: 2px; font-size: 0.65rem;">
                            FAQ Baru
                        </span>

                        <h5 class="modal-title fw-bold mb-0"
                            id="createFaqModalLabel"
                            style="font-family: var(--dk-font-heading);">
                            Tambah FAQ
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
                        <label for="create_question"
                               class="form-label fw-bold text-uppercase"
                               style="font-size: 0.7rem; letter-spacing: 1px;">
                            Pertanyaan
                        </label>

                        <input type="text"
                               name="question"
                               id="create_question"
                               class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none"
                               placeholder="Contoh: Apakah bisa pesan antar?"
                               required
                               style="border-bottom: 1px solid #ccc !important; font-size: 1.05rem;">
                    </div>

                    <div class="mb-4">
                        <label for="create_answer"
                               class="form-label fw-bold text-uppercase"
                               style="font-size: 0.7rem; letter-spacing: 1px;">
                            Jawaban
                        </label>

                        <textarea name="answer"
                                  id="create_answer"
                                  rows="4"
                                  class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none"
                                  placeholder="Tulis jawaban lengkap..."
                                  required
                                  style="border-bottom: 1px solid #ccc !important; resize: none;"></textarea>
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
                            Tampilkan FAQ ini
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
                        Simpan FAQ
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- CSS MODAL FIX -->
    <!-- ========================================== -->

    <style>
        /* Tabel tetap transparan */
        .table,
        .table tbody,
        .table thead,
        .table tr,
        .table td,
        .table th {
            background-color: transparent !important;
            --bs-table-bg: transparent !important;
            --bs-table-accent-bg: transparent !important;
            --bs-table-hover-bg: transparent !important;
            box-shadow: none !important;
        }

        /* Posisi modal */
        .faq-modal {
            z-index: 2000 !important;
        }

        .modal-backdrop {
            z-index: 1990 !important;
        }

        /* Ukuran modal seperti modal Kategori */
        .faq-modal .modal-dialog {
            max-width: 520px;
            width: calc(100% - 30px);
        }

        /* Background putih solid */
        .faq-modal .modal-content {
            position: relative;
            background: #fff !important;
            border: none !important;
            border-radius: 16px;
            overflow: hidden;
            color: #333;
        }

        /* Area isi modal */
        .faq-modal .modal-body {
            max-height: 65vh;
            overflow-y: auto;
        }

        /* Footer */
        .faq-modal .modal-footer {
            padding: 1rem 1.5rem 1.5rem;
        }

        /* Input dan textarea */
        .faq-modal .form-control {
            color: #333;
        }

        .faq-modal .form-control:focus {
            box-shadow: none !important;
            border-bottom-color: #26966F !important;
        }

        /* Switch */
        .faq-modal .form-check-input:checked {
            background-color: #26966F;
            border-color: #26966F;
        }

        /* Scrollbar modal */
        .faq-modal .modal-body::-webkit-scrollbar {
            width: 5px;
        }

        .faq-modal .modal-body::-webkit-scrollbar-thumb {
            background: #d5d5d5;
            border-radius: 10px;
        }

        body.modal-open {
            overflow: hidden !important;
        }
    </style>

    <!-- ========================================== -->
    <!-- JAVASCRIPT MODAL FIX -->
    <!-- ========================================== -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Pindahkan modal langsung ke body agar tidak terhalang
            // oleh overflow, transform, atau stacking context layout.
            document.querySelectorAll('.faq-modal').forEach(function (modal) {
                document.body.appendChild(modal);
            });
        });
    </script>

@endsection
