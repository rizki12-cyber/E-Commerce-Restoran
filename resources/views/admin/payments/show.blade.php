@extends('layouts.admin')

@section('title', 'Detail Pembayaran')
@section('page_title', 'Verifikasi Pembayaran')

@section('content')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">VERIFIKASI</span>
                <div style="height: 1px; width: 40px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Bukti Transfer</h1>
        </div>
        <a href="{{ route('admin.payments.index') }}" class="btn btn-link text-muted text-decoration-none p-0 fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row g-5">
        <!-- Kolom Kiri: Informasi & Aksi -->
        <div class="col-lg-6">
            <div class="p-4 h-100" style="background: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                <h5 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">Informasi Tagihan</h5>
                
                <div class="row g-3 mb-4">
                    <div class="col-sm-6">
                        <small class="text-muted text-uppercase d-block mb-1" style="letter-spacing: 1px; font-size: 0.65rem;">No. Pesanan</small>
                        <span class="fw-bold" style="font-size: 1.1rem;">{{ $payment->order->order_number }}</span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted text-uppercase d-block mb-1" style="letter-spacing: 1px; font-size: 0.65rem;">Pelanggan</small>
                        <span class="fw-bold">{{ $payment->order->customer_name }}</span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted text-uppercase d-block mb-1" style="letter-spacing: 1px; font-size: 0.65rem;">Metode</small>
                        <span class="fw-bold">{{ strtoupper(str_replace('_', ' ', $payment->method->value)) }}</span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted text-uppercase d-block mb-1" style="letter-spacing: 1px; font-size: 0.65rem;">Total Tagihan</small>
                        <span class="fw-bold" style="color: var(--dk-primary); font-size: 1.2rem; font-family: var(--dk-font-heading);">
                            Rp {{ number_format($payment->amount, 0, ',', '.') }}
                        </span>
                    </div>
                </div>

                <hr style="border-color: #e0d5cb; opacity: 1; margin: 2rem 0;">

                @if($payment->status->value === 'unpaid')
                    <h6 class="fw-bold mb-4 text-uppercase" style="letter-spacing: 1px; font-size: 0.75rem;">Aksi Verifikasi</h6>
                    
                    <form action="{{ route('admin.payments.verify', $payment->id) }}" method="POST" class="mb-4">
                        @csrf
                        <button type="submit" class="btn btn-primary w-100 py-3" onclick="return confirm('Yakin ingin menerima pembayaran ini?')">
                            <i class="bi bi-check-circle me-2"></i> Terima Pembayaran
                        </button>
                    </form>

                    <form action="{{ route('admin.payments.reject', $payment->id) }}" method="POST">
                        @csrf
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Atau Tolak Pembayaran</label>
                        <div class="d-flex gap-2">
                            <input type="text" name="rejection_reason" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" placeholder="Tulis alasan penolakan..." required style="border-bottom: 1px solid #ccc !important;">
                            <button type="submit" class="btn btn-outline-danger px-4" style="border-radius: 50px;">Tolak</button>
                        </div>
                    </form>
                @elseif($payment->status->value === 'paid')
                    <div class="alert border-0 rounded-3 mb-0 d-flex align-items-center" style="background-color: rgba(38, 150, 111, 0.1); color: #26966F;">
                        <i class="bi bi-check-circle-fill fs-4 me-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Pembayaran Lunas</h6>
                            <small>Diverifikasi pada {{ $payment->verified_at->format('d M Y H:i') }}</small>
                        </div>
                    </div>
                @else
                    <div class="alert border-0 rounded-3 mb-0 d-flex align-items-center" style="background-color: rgba(220, 82, 82, 0.1); color: #DC5252;">
                        <i class="bi bi-x-circle-fill fs-4 me-3"></i>
                        <div>
                            <h6 class="mb-0 fw-bold">Pembayaran Ditolak</h6>
                            <small>Alasan: {{ $payment->rejection_reason }}</small>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Kolom Kanan: Gambar Bukti -->
        <div class="col-lg-6">
            <div class="p-4 h-100 d-flex flex-column align-items-center justify-content-center" style="background: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                @if($payment->proof_image)
                    <a href="{{ Storage::url($payment->proof_image) }}" target="_blank" class="d-block w-100">
                        <img src="{{ Storage::url($payment->proof_image) }}" class="img-fluid rounded-3 shadow-sm w-100" style="object-fit: contain; max-height: 500px;" alt="Bukti Transfer">
                    </a>
                    <small class="text-muted mt-3"><i class="bi bi-zoom-in me-1"></i> Klik gambar untuk memperbesar</small>
                @else
                    <div class="text-center text-muted">
                        <i class="bi bi-image fs-1 mb-3 opacity-25"></i>
                        <p class="mb-0">Belum ada bukti transfer yang diunggah.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection