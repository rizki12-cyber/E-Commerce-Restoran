<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name'))</title>

        <title>@yield('title', config('app.name'))</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    {{-- SEO Meta Tags --}}
    <meta name="description" content="{{ $globalSettings['app_tagline'] ?? 'Dapur Kaysan - Premium Food E-Commerce. Pesan makanan lezat dengan mudah dan cepat.' }}">
    <meta name="keywords" content="makanan, kuliner, pesan antar makanan, dapur kaysan, catering, resto">
    <meta name="author" content="{{ $globalSettings['app_name'] ?? config('app.name') }}">
    
    {{-- Open Graph (Untuk Share ke WhatsApp/FB) --}}
    <meta property="og:title" content="@yield('title', config('app.name'))">
    <meta property="og:description" content="{{ $globalSettings['app_tagline'] ?? 'Pesan makanan lezat dari Dapur Kaysan.' }}">
    <meta property="og:image" content="{{ isset($globalSettings['logo']) ? Storage::url($globalSettings['logo']) : asset('favicon.ico') }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    {{-- Favicon --}}
    @if(isset($globalSettings['logo']))
        <link rel="icon" type="image/x-icon" href="{{ Storage::url($globalSettings['logo']) }}">
    @else
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @endif
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- TEMA DINAMIS --}}
    <style>
        :root {
            --dk-primary: {{ $globalSettings['primary_color'] ?? '#B76535' }} !important;
        }
        .btn-primary {
            background-color: var(--dk-primary) !important;
            border-color: var(--dk-primary) !important;
        }
        .btn-outline-primary {
            color: var(--dk-primary) !important;
            border-color: var(--dk-primary) !important;
        }
        .btn-outline-primary:hover {
            background-color: var(--dk-primary) !important;
            color: #fff !important;
        }
        .text-primary {
            color: var(--dk-primary) !important;
        }
    </style>
</head>
<body>
    @include('layouts.partials.navbar')

        {{-- Global Alert --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center mb-0 rounded-0" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show text-center mb-0 rounded-0" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <main class="min-vh-100">
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    @stack('scripts')
</body>
</html>