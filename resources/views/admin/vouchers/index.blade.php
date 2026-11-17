@extends('layouts.admin')

@section('title', 'Voucher & Promosi')
@section('page_title', 'Manajemen Voucher')

@section('content')

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">PEMASARAN</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Voucher & Promosi</h1>
        </div>

        <div class="mt-4 mt-md-0">
            <button type="button" class="btn btn-primary px-4 py-2"
                    data-bs-toggle="modal" data-bs-target="#createModal">
                <i class="bi bi-plus-lg me-2"></i> Buat Voucher
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

    <!-- Tabel Voucher -->
    <div class="table-responsive">
        <table class="table align-middle mb-0 voucher-table"
               style="border-top: 2px solid var(--dk-text);">
            <thead>
                <tr class="text-uppercase text-muted"
                    style="font-size: 0.7rem; letter-spacing: 1px; border-bottom: 1px solid #e0d5cb;">
                    <th class="py-3 fw-bold">Kode Voucher</th>
                    <th class="py-3 fw-bold">Nilai Diskon</th>
                    <th class="py-3 fw-bold">Min. Belanja</th>
                    <th class="py-3 fw-bold">Kuota</th>
                    <th class="py-3 fw-bold">Masa Berlaku</th>
                    <th class="py-3 fw-bold text-end">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($vouchers as $v)
                    <tr style="border-bottom: 1px solid #e0d5cb;">
                        <td class="py-3">
                            <div class="d-inline-block border border-dark rounded-2 px-3 py-1 fw-bold mb-1"
                                 style="font-family: monospace; font-size: 1.1rem; letter-spacing: 2px; border-style: dashed !important;">
                                {{ $v->code }}
                            </div>
                            <div class="text-muted small">{{ $v->name }}</div>
                        </td>

                        <td class="py-3 fw-bold text-dark">
                            @if($v->type->value === 'percentage')
                                <span class="fs-5">{{ $v->value }}%</span>
                            @else
                                <span class="fs-5">Rp {{ number_format($v->value, 0, ',', '.') }}</span>
                            @endif
                        </td>

                        <td class="py-3 text-muted">
                            Rp {{ number_format($v->min_purchase, 0, ',', '.') }}
                        </td>

                        <td class="py-3 text-muted">
                            @if($v->quota)
                                {{ $v->quota }} <small>pengguna</small>
                            @else
                                <i class="bi bi-infinity fs-5"></i>
                            @endif
                        </td>

                        <td class="py-3 text-muted" style="font-size: 0.85rem;">
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi bi-calendar-event"></i>
                                {{ $v->start_at->format('d/m/y') }} - {{ $v->end_at->format('d/m/y') }}
                            </div>
                        </td>

                        <td class="py-3 text-end">
                            <button type="button"
                                    class="btn btn-sm btn-link text-muted p-1 me-2"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editModal{{ $v->id }}"
                                    title="Edit">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </button>

                            <form action="{{ route('admin.vouchers.destroy', $v->id) }}"
                                  method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')

                                <button type="button"
                                        class="btn btn-sm btn-link text-muted p-1"
                                        title="Hapus"
                                        data-confirm-title="Hapus voucher ini?"
                                        data-confirm="Voucher <strong>{{ $v->name }}</strong> akan dihapus permanen.">
                                    <i class="bi bi-trash fs-5"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            Belum ada voucher promosi.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $vouchers->links('pagination::bootstrap-5') }}
    </div>


    {{-- ============================================= --}}
    {{-- MODAL EDIT VOUCHER --}}
    {{-- ============================================= --}}

    @foreach($vouchers as $v)
        <div class="modal fade voucher-modal"
             id="editModal{{ $v->id }}"
             tabindex="-1"
             aria-labelledby="editLabel{{ $v->id }}"
             aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <form action="{{ route('admin.vouchers.update', $v->id) }}"
                      method="POST" class="modal-content">

                    @csrf
                    @method('PUT')

                    <div class="modal-header border-0 pb-0">
                        <div>
                            <span class="text-uppercase fw-bold text-muted d-block"
                                  style="font-size: 0.65rem; letter-spacing: 2px;">
                                Ubah Data
                            </span>
                            <h5 class="modal-title fw-bold"
                                id="editLabel{{ $v->id }}"
                                style="font-family: var(--dk-font-heading);">
                                Edit Voucher
                            </h5>
                        </div>

                        <button type="button" class="btn-close shadow-none"
                                data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>

                    <div class="modal-body py-4">

                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase">Kode Voucher</label>
                            <input type="text" name="code"
                                   class="form-control voucher-input fw-bold"
                                   value="{{ $v->code }}" required
                                   style="font-family: monospace; letter-spacing: 2px;">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase">Nama Program</label>
                            <input type="text" name="name"
                                   class="form-control voucher-input"
                                   value="{{ $v->name }}" required>
                        </div>

                        <div class="row g-4 mb-4">
                            <div class="col-6">
                                <label class="form-label fw-bold text-uppercase">Tipe</label>
                                <select name="type" class="form-select voucher-input" required>
                                    <option value="fixed" {{ $v->type->value === 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                                    <option value="percentage" {{ $v->type->value === 'percentage' ? 'selected' : '' }}>Persen (%)</option>
                                </select>
                            </div>

                            <div class="col-6">
                                <label class="form-label fw-bold text-uppercase">Nilai Diskon</label>
                                <input type="number" name="value"
                                       class="form-control voucher-input"
                                       value="{{ $v->value }}" min="1" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase">Min. Belanja (Rp)</label>
                            <input type="number" name="min_purchase"
                                   class="form-control voucher-input"
                                   value="{{ $v->min_purchase }}" min="0" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase">
                                Kuota (Kosongkan jika unlimited)
                            </label>
                            <input type="number" name="quota"
                                   class="form-control voucher-input"
                                   value="{{ $v->quota }}" min="1" placeholder="∞">
                        </div>

                        <div class="row g-4">
                            <div class="col-6">
                                <label class="form-label fw-bold text-uppercase">Mulai</label>
                                <input type="date" name="start_at"
                                       class="form-control voucher-input"
                                       value="{{ $v->start_at->format('Y-m-d') }}" required>
                            </div>

                            <div class="col-6">
                                <label class="form-label fw-bold text-uppercase">Selesai</label>
                                <input type="date" name="end_at"
                                       class="form-control voucher-input"
                                       value="{{ $v->end_at->format('Y-m-d') }}" required>
                            </div>
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


    {{-- ============================================= --}}
    {{-- MODAL TAMBAH VOUCHER --}}
    {{-- ============================================= --}}

    <div class="modal fade voucher-modal"
         id="createModal"
         tabindex="-1"
         aria-labelledby="createLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <form action="{{ route('admin.vouchers.store') }}"
                  method="POST" class="modal-content">

                @csrf

                <div class="modal-header border-0 pb-0">
                    <div>
                        <span class="text-uppercase fw-bold text-muted d-block"
                              style="font-size: 0.65rem; letter-spacing: 2px;">
                            Promosi Baru
                        </span>
                        <h5 class="modal-title fw-bold"
                            id="createLabel"
                            style="font-family: var(--dk-font-heading);">
                            Buat Voucher Baru
                        </h5>
                    </div>

                    <button type="button" class="btn-close shadow-none"
                            data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="modal-body py-4">

                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase">Kode Voucher</label>
                        <input type="text" name="code"
                               class="form-control voucher-input fw-bold"
                               placeholder="CONTOH: KAYSAN10" required
                               style="font-family: monospace; letter-spacing: 2px;">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase">Nama Program</label>
                        <input type="text" name="name"
                               class="form-control voucher-input"
                               placeholder="Contoh: Diskon Akhir Tahun" required>
                    </div>

                    <div class="row g-4 mb-4">
                        <div class="col-6">
                            <label class="form-label fw-bold text-uppercase">Tipe</label>
                            <select name="type" class="form-select voucher-input" required>
                                <option value="fixed">Nominal (Rp)</option>
                                <option value="percentage">Persen (%)</option>
                            </select>
                        </div>

                        <div class="col-6">
                            <label class="form-label fw-bold text-uppercase">Nilai Diskon</label>
                            <input type="number" name="value"
                                   class="form-control voucher-input" min="1" required>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase">Min. Belanja (Rp)</label>
                        <input type="number" name="min_purchase"
                               class="form-control voucher-input"
                               value="0" min="0" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase">
                            Kuota (Kosongkan jika unlimited)
                        </label>
                        <input type="number" name="quota"
                               class="form-control voucher-input"
                               min="1" placeholder="∞">
                    </div>

                    <div class="row g-4">
                        <div class="col-6">
                            <label class="form-label fw-bold text-uppercase">Mulai</label>
                            <input type="date" name="start_at"
                                   class="form-control voucher-input" required>
                        </div>

                        <div class="col-6">
                            <label class="form-label fw-bold text-uppercase">Selesai</label>
                            <input type="date" name="end_at"
                                   class="form-control voucher-input" required>
                        </div>
                    </div>

                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button"
                            class="btn btn-link text-muted text-decoration-none"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit" class="btn btn-primary px-4">
                        Buat Voucher
                    </button>
                </div>

            </form>
        </div>
    </div>


    {{-- ============================================= --}}
    {{-- CSS FIX MODAL DAN BACKGROUND TRANSPARAN --}}
    {{-- ============================================= --}}

    <style>
        /* Tabel transparan */
        .voucher-table,
        .voucher-table thead,
        .voucher-table tbody,
        .voucher-table tr,
        .voucher-table th,
        .voucher-table td {
            background: transparent !important;
            --bs-table-bg: transparent;
            --bs-table-accent-bg: transparent;
            --bs-table-hover-bg: transparent;
            box-shadow: none !important;
        }

        /* Modal di atas seluruh elemen halaman */
        .voucher-modal {
            z-index: 2000 !important;
        }

        .modal-backdrop {
            z-index: 1990 !important;
        }

        .voucher-modal .modal-dialog {
            max-width: 560px;
            width: calc(100% - 30px);
            margin-left: auto;
            margin-right: auto;
        }

        /* ==================================================== */
        /* PERUBAHAN DI SINI: Modal menjadi SOLID (Tidak Transparan) */
        /* ==================================================== */
        .voucher-modal .modal-content {
            background-color: #FBF9F6 !important; /* Warna solid, bukan transparent */
            border: 1px solid #e0d5cb !important;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important; /* Tambah shadow agar terlihat melayang */
            overflow: hidden;
        }

        .voucher-modal .modal-header,
        .voucher-modal .modal-body,
        .voucher-modal .modal-footer {
            background-color: transparent !important; /* Biarkan transparan agar ikut warna solid di atas */
        }

        .voucher-modal .modal-header {
            padding: 1.5rem 1.5rem 0;
        }

        .voucher-modal .modal-body {
            padding-left: 1.5rem;
            padding-right: 1.5rem;
            max-height: 65vh;
            overflow-y: auto;
        }

        .voucher-modal .modal-footer {
            padding: 0 1.5rem 1.5rem;
        }

        /* Label */
        .voucher-modal .form-label {
            font-size: 0.7rem;
            letter-spacing: 1px;
            color: var(--dk-text);
        }

        /* Input transparan (menyatu dengan modal solid) */
        .voucher-modal .voucher-input {
            background: transparent !important;
            border: none !important;
            border-bottom: 1px solid #b9aea2 !important;
            border-radius: 0 !important;
            padding-left: 0;
            padding-right: 0;
            box-shadow: none !important;
            color: var(--dk-text);
        }

        .voucher-modal .voucher-input:focus {
            background: transparent !important;
            border-bottom: 1px solid #26966F !important;
            box-shadow: none !important;
        }

        .voucher-modal .voucher-input::placeholder {
            color: #999;
            opacity: 0.8;
        }

        .voucher-modal .voucher-input option {
            background-color: #FBF9F6;
            color: #333;
        }

        .voucher-modal .btn-close {
            filter: none;
        }

        .voucher-modal .modal-title {
            color: var(--dk-text);
        }

        .voucher-modal .modal-footer .btn-link {
            color: var(--dk-text) !important;
        }

        .voucher-modal .modal-footer .btn-primary {
            background-color: #26966F;
            border-color: #26966F;
        }

        .voucher-modal .modal-footer .btn-primary:hover {
            background-color: #207d5d;
            border-color: #207d5d;
        }

        .modal-backdrop.show {
            opacity: 0.65;
        }

        body.modal-open {
            overflow: hidden !important;
        }

        @media (max-width: 576px) {
            .voucher-modal .modal-dialog {
                width: calc(100% - 20px);
            }

            .voucher-modal .modal-header {
                padding: 1.25rem 1.25rem 0;
            }

            .voucher-modal .modal-body {
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }

            .voucher-modal .modal-footer {
                padding: 0 1.25rem 1.25rem;
            }
        }
    </style>


    {{-- ============================================= --}}
    {{-- JAVASCRIPT FIX MODAL --}}
    {{-- ============================================= --}}

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            // Pindahkan modal ke body agar tidak terhalang parent container
            document.querySelectorAll('.voucher-modal').forEach(function (modal) {
                if (modal.parentElement !== document.body) {
                    document.body.appendChild(modal);
                }
            });

        });
    </script>

@endsection