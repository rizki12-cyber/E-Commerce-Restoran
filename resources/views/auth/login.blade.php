@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    <div class="auth-form-container {{ request()->routeIs('register') || $errors->has('name') ? 'show-register' : '' }}" id="auth-container">

        <!-- PANEL 1: LOGIN -->
        <div class="auth-form-panel" id="login-panel">
            <h1 class="auth-title" style="font-family:'Playfair Display'; font-size: 2.5rem; font-weight: 700;">Selamat Datang.</h1>
            <p class="auth-subtitle" style="color: #6B6B6B; margin-bottom: 2rem;">Silakan masuk untuk melanjutkan pesanan Anda.</p>

            @if (session('status'))
                <div class="alert alert-success mb-4 border-0 rounded-3" style="background-color: rgba(38, 150, 111, 0.1); color: #26966F;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="custom-input-group">
                    <label for="email">Alamat Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="nama@email.com">
                    <i class="bi bi-envelope input-icon"></i>
                    @error('email') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                </div>

                <div class="custom-input-group">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required placeholder="••••••••">
                    <i class="bi bi-eye-slash input-icon" onclick="togglePassword('password', this)"></i>
                    @error('password') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center mb-4 mt-2">
                    <div class="form-check">
                        <input class="form-check-input shadow-none" type="checkbox" name="remember" id="remember_me">
                        <label class="form-check-label text-muted small" for="remember_me">Ingat Saya</label>
                    </div>
                    <a class="auth-link small" href="{{ route('password.request') }}">Lupa Password?</a>
                </div>

                <button type="submit" class="btn-auth">Masuk ke Akun</button>
                
                <div class="text-center text-muted small mt-4">
                    Belum punya akun? <a class="auth-link" href="javascript:void(0);" onclick="toggleAuth('register')">Daftar sekarang</a>
                </div>
            </form>
        </div>

        <!-- PANEL 2: REGISTER -->
        <div class="auth-form-panel" id="register-panel">
            <h1 class="auth-title" style="font-family:'Playfair Display'; font-size: 2.5rem; font-weight: 700;">Buat Akun.</h1>
            <p class="auth-subtitle" style="color: #6B6B6B; margin-bottom: 2rem;">Daftar sekarang dan nikmati kemudahan memesan makanan.</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="custom-input-group">
                    <label for="name">Nama Lengkap</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="John Doe">
                    <i class="bi bi-person input-icon"></i>
                    @error('name') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                </div>

                <div class="custom-input-group">
                    <label for="email_reg">Alamat Email</label>
                    <input id="email_reg" type="email" name="email" value="{{ old('email') }}" required placeholder="nama@email.com">
                    <i class="bi bi-envelope input-icon"></i>
                    @error('email') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                </div>

                <div class="custom-input-group">
                    <label for="password_reg">Password</label>
                    <input id="password_reg" type="password" name="password" required placeholder="Minimal 8 karakter">
                    <i class="bi bi-eye-slash input-icon" onclick="togglePassword('password_reg', this)"></i>
                    @error('password') <small class="text-danger d-block mt-1">{{ $message }}</small> @enderror
                </div>

                <div class="custom-input-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required placeholder="Ulangi password">
                    <i class="bi bi-shield-lock input-icon"></i>
                </div>

                <button type="submit" class="btn-auth mt-3">Daftar Akun</button>
                
                <div class="text-center text-muted small mt-4">
                    Sudah punya akun? <a class="auth-link" href="javascript:void(0);" onclick="toggleAuth('login')">Masuk di sini</a>
                </div>
            </form>
        </div>

    </div>
@endsection

@push('scripts')
<script>
    function toggleAuth(mode) {
        const container = document.getElementById('auth-container');
        if (mode === 'register') {
            container.classList.add('show-register');
            window.history.pushState({}, '', '{{ route('register') }}');
        } else {
            container.classList.remove('show-register');
            window.history.pushState({}, '', '{{ route('login') }}');
        }
    }

    // Mendeteksi tombol Back/Forward Browser agar animasi sinkron dengan URL
    window.addEventListener('popstate', function() {
        if (window.location.pathname.includes('register')) {
            document.getElementById('auth-container').classList.add('show-register');
        } else {
            document.getElementById('auth-container').classList.remove('show-register');
        }
    });

    function togglePassword(inputId, icon) {
        const input = document.getElementById(inputId);
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('bi-eye-slash');
            icon.classList.add('bi-eye');
        } else {
            input.type = 'password';
            icon.classList.remove('bi-eye');
            icon.classList.add('bi-eye-slash');
        }
    }
</script>
@endpush