@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan — Dapur Kaysan')

@section('content')
<div class="container py-5 text-center d-flex flex-column align-items-center justify-content-center" style="min-height: 60vh;">
    <h1 class="display-1 fw-bold" style="color: var(--dk-primary);">404</h1>
    <h2 class="fw-bold mb-3">Ups! Halaman Tidak Ditemukan</h2>
    <p class="text-muted mb-4">Sepertinya hidangan yang Anda cari sudah habis atau tidak ada di menu kami.</p>
    <a href="{{ route('home') }}" class="btn btn-primary btn-lg px-4">
        <i class="bi bi-house-door me-2"></i> Kembali ke Beranda
    </a>
</div>
@endsection