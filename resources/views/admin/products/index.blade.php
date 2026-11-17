
@extends('layouts.admin')

@section('title', 'Manajemen Produk')
@section('page_title', 'Katalog Produk')

@section('content')

    <style>
        /* Menghilangkan background putih bawaan Bootstrap */
        .product-table,
        .product-table thead,
        .product-table tbody,
        .product-table tr,
        .product-table th,
        .product-table td {
            background-color: transparent !important;
            box-shadow: none !important;
        }

        .product-table {
            --bs-table-bg: transparent;
            --bs-table-color: inherit;
            --bs-table-accent-bg: transparent;
            border-top: 2px solid var(--dk-text);
        }

        .product-table tbody tr {
            border-bottom: 1px solid #e0d5cb;
        }

        .product-table tbody tr:hover {
            background-color: rgba(128, 128, 128, 0.04) !important;
        }

        .product-table th {
            border-bottom: 1px solid #e0d5cb;
        }

        .product-table td {
            border-color: transparent;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .product-action {
            transition: color 0.2s ease;
        }

        .product-action:hover {
            color: var(--dk-text) !important;
        }

        @media (max-width: 768px) {
            .product-table {
                min-width: 850px;
            }
        }
    </style>

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted"
                    style="letter-spacing: 3px; font-size: 0.75rem;">
                    INVENTARIS
                </span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>

            <h1 class="display-5 fw-bold mb-0"
                style="font-family: var(--dk-font-heading);">
                Daftar Produk
            </h1>
        </div>

        <div class="mt-4 mt-md-0">
            <a href="{{ route('admin.products.create') }}"
                class="btn btn-primary px-4 py-2">
                <i class="bi bi-plus-lg me-2"></i>
                Tambah Produk
            </a>
        </div>
    </div>

    <!-- Notifikasi -->
    @if(session('success'))
        <div class="alert alert-success alert-auto-dismiss border-0 rounded-3 mb-4"
            style="background-color: rgba(38, 150, 111, 0.1); color: #26966F;">
            {{ session('success') }}
        </div>
    @endif

    <!-- Tabel Produk -->
    <div class="table-responsive">
        <table class="table product-table align-middle mb-0">

            <thead>
                <tr class="text-uppercase text-muted"
                    style="font-size: 0.7rem; letter-spacing: 1px;">

                    <th class="py-3 fw-bold">Gambar</th>
                    <th class="py-3 fw-bold">Nama Produk</th>
                    <th class="py-3 fw-bold">Kategori</th>
                    <th class="py-3 fw-bold">Harga</th>
                    <th class="py-3 fw-bold">Stok</th>
                    <th class="py-3 fw-bold">Status</th>
                    <th class="py-3 fw-bold text-end">Aksi</th>

                </tr>
            </thead>

            <tbody>
                @forelse($products as $product)

                    <tr>
                        <!-- Gambar -->
                        <td class="py-3">
                            @if($product->primary_image)
                                <img
                                    src="{{ Storage::url($product->primary_image) }}"
                                    alt="{{ $product->name }}"
                                    class="rounded-2 product-image">
                            @else
                                <div class="rounded-2 d-flex align-items-center justify-content-center"
                                    style="width: 60px; height: 60px; background: rgba(128,128,128,0.08);">
                                    <i class="bi bi-image text-muted fs-4"></i>
                                </div>
                            @endif
                        </td>

                        <!-- Nama Produk -->
                        <td class="py-3">
                            <div class="fw-bold mb-1"
                                style="font-family: var(--dk-font-heading); font-size: 1.1rem;">
                                {{ $product->name }}
                            </div>

                            <small class="text-muted" style="font-size: 0.75rem;">
                                SKU: {{ $product->sku }}
                            </small>
                        </td>

                        <!-- Kategori -->
                        <td class="py-3 text-muted">
                            {{ $product->category?->name ?? 'Tanpa Kategori' }}
                        </td>

                        <!-- Harga -->
                        <td class="py-3 fw-bold text-dark">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </td>

                        <!-- Stok -->
                        <td class="py-3">
                            <span class="badge rounded-pill
                                {{ $product->stock <= $product->min_stock
                                    ? 'border border-danger text-danger bg-transparent'
                                    : 'border border-secondary text-secondary bg-transparent' }}"
                                style="font-weight: 600;">
                                {{ $product->stock }}
                            </span>
                        </td>

                        <!-- Status -->
                        <td class="py-3">
                            @if($product->is_active)
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

                        <!-- Aksi -->
                        <td class="py-3 text-end text-nowrap">

                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                class="btn btn-sm btn-link text-muted p-1 me-2 product-action"
                                title="Edit">
                                <i class="bi bi-pencil-square fs-5"></i>
                            </a>

                            <form action="{{ route('admin.products.destroy', $product->id) }}"
                                method="POST"
                                class="d-inline">

                                @csrf
                                @method('DELETE')

                                <button type="button"
                                    class="btn btn-sm btn-link text-muted p-1 product-action"
                                    title="Hapus"
                                    data-confirm-title="Hapus produk ini?"
                                    data-confirm="Produk <strong>{{ $product->name }}</strong> akan dihapus permanen.">

                                    <i class="bi bi-trash fs-5"></i>

                                </button>
                            </form>

                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-box-seam fs-1 d-block mb-3 opacity-50"></i>
                            <div class="fw-semibold">Belum Ada Produk</div>
                            <small>Produk yang kamu tambahkan akan muncul di sini.</small>
                        </td>
                    </tr>

                @endforelse
            </tbody>

        </table>
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>

@endsection
