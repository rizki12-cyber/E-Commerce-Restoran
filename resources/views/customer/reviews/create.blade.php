@extends('layouts.app')

@section('title', 'Beri Ulasan — Dapur Kaysan')

@section('content')
<div class="container py-5 my-5">
    <div class="row justify-content-center">
        <div class="col-lg-7 col-md-9">
            
            <!-- Header -->
            <div class="text-center mb-5">
                <div class="d-inline-flex align-items-center gap-3 mb-3">
                    <div style="height: 1px; width: 40px; background-color: #ccc;"></div>
                    <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.8rem;">ULASAN</span>
                    <div style="height: 1px; width: 40px; background-color: #ccc;"></div>
                </div>
                <h1 class="display-5 fw-bold mb-3" style="font-family: var(--dk-font-heading);">Bagikan Pengalaman</h1>
                <p class="text-muted">Berikan penilaian Anda untuk <br> <strong class="text-dark">{{ $orderItem->product_name }}</strong></p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger border-0 rounded-3 mb-4 text-center" style="background-color: rgba(220, 82, 82, 0.1); color: #DC5252;">{{ session('error') }}</div>
            @endif

            <form action="{{ route('customer.reviews.store') }}" method="POST">
                @csrf
                <input type="hidden" name="order_item_id" value="{{ $orderItem->id }}">
                <input type="hidden" name="order_number" value="{{ $order->order_number }}">

                <!-- Rating Segmented (Skala 1-5) -->
                <div class="mb-5 text-center">
                    <label class="form-label fw-bold text-uppercase d-block mb-4" style="font-size: 0.75rem; letter-spacing: 1px;">Seberapa Puas Anda?</label>
                    
                    <div class="d-flex justify-content-center gap-2 gap-md-3 mb-3">
                        <!-- Menggunakan fitur btn-check bawaan Bootstrap 5 -->
                        <input type="radio" class="btn-check" name="rating" id="rating1" value="1" required>
                        <label class="rating-circle" for="rating1">1</label>

                        <input type="radio" class="btn-check" name="rating" id="rating2" value="2">
                        <label class="rating-circle" for="rating2">2</label>

                        <input type="radio" class="btn-check" name="rating" id="rating3" value="3">
                        <label class="rating-circle" for="rating3">3</label>

                        <input type="radio" class="btn-check" name="rating" id="rating4" value="4">
                        <label class="rating-circle" for="rating4">4</label>

                        <input type="radio" class="btn-check" name="rating" id="rating5" value="5">
                        <label class="rating-circle" for="rating5">5</label>
                    </div>
                    
                    <!-- Teks Dinamis -->
                    <div class="mt-3 text-muted small" id="rating-text" style="font-weight: 500; font-size: 0.9rem;">Pilih skala 1 sampai 5</div>
                </div>

                <!-- Komentar -->
                <div class="mb-5">
                    <label class="form-label fw-bold text-uppercase" style="font-size: 0.75rem; letter-spacing: 1px;">Tulis Ulasan</label>
                    <textarea name="comment" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" rows="4" placeholder="Ceritakan pengalaman Anda menikmati hidangan ini..." required style="border-bottom: 1px solid #ccc !important; resize: none; font-size: 1.05rem;"></textarea>
                </div>

                <!-- Tombol Aksi -->
                <div class="d-flex flex-column flex-md-row align-items-center gap-3 mt-4">
                    <button type="submit" class="btn btn-primary btn-lg w-100 py-3" style="border-radius: 50px;">
                        Kirim Ulasan
                    </button>
                    <a href="{{ route('customer.orders.show', $order->order_number) }}" class="btn btn-link text-muted text-decoration-none w-100 text-center py-3">
                        Batal
                    </a>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* --- STYLING SEGMENTED RATING --- */
    .rating-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        border: 2px solid #e0d5cb;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        font-weight: 700;
        color: #6B6B6B;
        cursor: pointer;
        transition: all 0.3s ease;
        background-color: transparent;
        user-select: none;
    }

    /* Efek Hover */
    .rating-circle:hover {
        border-color: var(--dk-primary);
        color: var(--dk-primary);
        transform: translateY(-3px);
    }

    /* Efek Saat Dipilih (Checked) */
    .btn-check:checked + .rating-circle {
        background-color: var(--dk-primary);
        border-color: var(--dk-primary);
        color: #fff;
        transform: scale(1.1);
        box-shadow: 0 8px 20px rgba(227, 106, 46, 0.3);
    }

    /* Penyesuaian untuk layar HP */
    @media (max-width: 576px) {
        .rating-circle {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Script untuk mengubah teks di bawah tombol saat dipilih
    document.addEventListener('DOMContentLoaded', function() {
        const radios = document.querySelectorAll('.btn-check');
        const textDisplay = document.getElementById('rating-text');
        const texts = {
            '5': 'Sangat Puas (5)',
            '4': 'Puas (4)',
            '3': 'Cukup (3)',
            '2': 'Kurang (2)',
            '1': 'Sangat Kurang (1)'
        };

        radios.forEach(radio => {
            radio.addEventListener('change', function() {
                textDisplay.textContent = texts[this.value];
                textDisplay.classList.remove('text-muted');
                textDisplay.classList.add('text-dark', 'fw-bold');
            });
        });
    });
</script>
@endpush