@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('page_title', 'Edit Produk')

@section('content')
    <div class="d-flex justify-content-between align-items-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">KATALOG</span>
                <div style="height: 1px; width: 40px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Edit Produk</h1>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn btn-link text-muted text-decoration-none p-0 fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.products._form')
    </form>
@endsection