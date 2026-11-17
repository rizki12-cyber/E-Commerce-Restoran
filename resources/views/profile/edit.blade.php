@extends('layouts.app')

@section('title', 'Pengaturan Profil — Dapur Kaysan')

@section('content')
<div class="container py-5 my-4">
    
    <div class="row mb-5">
        <div class="col-12">
            <div class="d-flex align-items-center gap-3 mb-3">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.8rem;">AKUN</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-4 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Pengaturan Profil</h1>
        </div>
    </div>

    <div class="row g-5">
        <!-- Kolom Kiri: Form Edit Profil -->
        <div class="col-lg-7">
            <div class="mb-5">
                <h4 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">Informasi Pribadi</h4>
                
                <!-- TAMBAHKAN enctype UNTUK UPLOAD FILE -->
                <form method="post" action="{{ route('profile.update') }}" class="mt-4" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <!-- Foto Profil -->
                    <div class="d-flex align-items-center gap-4 mb-5">
                        <div class="position-relative">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" class="rounded-circle shadow-sm" style="width: 90px; height: 90px; object-fit: cover;">
                            @else
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 90px; height: 90px; font-size: 2.5rem; font-family: var(--dk-font-heading);">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Ganti Foto Profil</label>
                            <input type="file" name="avatar" class="form-control border-0 px-0 bg-transparent shadow-none" accept="image/*" style="font-size: 0.85rem;">
                            <small class="text-muted" style="font-size: 0.7rem;">Format: JPG, PNG, WEBP (Maks 2MB)</small>
                        </div>
                    </div>

                    <!-- Nama -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" style="border-bottom: 1px solid #ccc !important;">
                        @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Alamat Email</label>
                        <input type="email" name="email" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ old('email', $user->email) }}" required autocomplete="username" style="border-bottom: 1px solid #ccc !important;">
                        @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Nomor WhatsApp</label>
                        <input type="text" name="phone" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" value="{{ old('phone', $user->phone) }}" placeholder="08xxxxxxxxxx" style="border-bottom: 1px solid #ccc !important;">
                        @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="d-flex align-items-center gap-3 mt-5">
                        <button type="submit" class="btn btn-primary px-5 py-2">Simpan Perubahan</button>
                        
                        @if (session('status') === 'profile-updated')
                            <span class="text-success small fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Tersimpan!</span>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Kolom Kanan: Ubah Password & Hapus Akun -->
        <div class="col-lg-5">
            
            <!-- Form Ubah Password -->
            <div class="p-4 rounded-3 mb-4" style="background-color: rgba(255,255,255,0.5); border: 1px solid #e0d5cb;">
                <h5 class="fw-bold mb-3" style="font-family: var(--dk-font-heading);">Ubah Password</h5>
                
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Password Saat Ini</label>
                        <input type="password" name="current_password" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" autocomplete="current-password" style="border-bottom: 1px solid #ccc !important;">
                        @error('current_password', 'updatePassword') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Password Baru</label>
                        <input type="password" name="password" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" autocomplete="new-password" style="border-bottom: 1px solid #ccc !important;">
                        @error('password', 'updatePassword') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" autocomplete="new-password" style="border-bottom: 1px solid #ccc !important;">
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <button type="submit" class="btn btn-outline-dark px-4 py-2" style="border-radius: 50px;">Simpan Password</button>
                        @if (session('status') === 'password-updated')
                            <span class="text-success small fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Diperbarui!</span>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Form Hapus Akun (Opsional) -->
            <div class="p-4 rounded-3 border" style="border-color: #f0caca !important; background-color: #fffafa;">
                <h6 class="fw-bold text-danger mb-2">Hapus Akun</h6>
                <p class="text-muted small mb-3">Setelah akun dihapus, semua data akan hilang secara permanen.</p>
                
                <button type="button" class="btn btn-sm btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                    Hapus Akun Saya
                </button>

                <div class="modal fade" id="deleteAccountModal" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <form method="post" action="{{ route('profile.destroy') }}" class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
                            @csrf
                            @method('delete')
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-bold">Yakin ingin menghapus akun?</h5>
                                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted small">Masukkan password Anda untuk mengonfirmasi penghapusan permanen.</p>
                                <input type="password" name="password" class="form-control border-0 border-bottom rounded-0 px-0 shadow-none" placeholder="Password" style="border-bottom: 1px solid #ccc !important;">
                                @error('password', 'userDeletion') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-link text-muted text-decoration-none" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-danger">Ya, Hapus Akun</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection