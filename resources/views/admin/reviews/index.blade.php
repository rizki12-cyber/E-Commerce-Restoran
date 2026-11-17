@extends('layouts.admin')

@section('title', 'Manajemen Review')
@section('page_title', 'Daftar Ulasan Pelanggan')

@section('content')
    <!-- Header Editorial -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">MODERASI</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Ulasan Pelanggan</h1>
        </div>
        
        <!-- Filter Minimalis -->
        <form action="{{ route('admin.reviews.index') }}" method="GET" class="d-flex gap-3 mt-4 mt-md-0">
            <div>
                <select name="status" class="form-select border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" onchange="this.form.submit()" style="border-bottom: 1px solid #ccc !important; font-weight: 500;">
                    <option value="">Semua Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div>
                <select name="rating" class="form-select border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" onchange="this.form.submit()" style="border-bottom: 1px solid #ccc !important; font-weight: 500;">
                    <option value="">Semua Rating</option>
                    @for($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} Bintang</option>
                    @endfor
                </select>
            </div>
        </form>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-auto-dismiss border-0 rounded-3 mb-4" style="background-color: rgba(38, 150, 111, 0.1); color: #26966F;">{{ session('success') }}</div>
    @endif

    <div class="row g-4">
        @forelse($reviews as $review)
            <div class="col-lg-6">
                <!-- Panel Kaca (Glassmorphism) -->
                <div class="p-4 h-100 d-flex flex-column" style="background: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                    
                    <!-- Header Review -->
                    <div class="d-flex justify-content-between align-items-start mb-3 pb-3 border-bottom" style="border-color: #e0d5cb !important;">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px; font-family: var(--dk-font-heading); font-size: 1.1rem;">
                                {{ substr($review->user->name, 0, 1) }}
                            </div>
                            <div>
                                <h6 class="fw-bold mb-0" style="font-size: 1.1rem;">{{ $review->user?->name ?? 'Pengguna Dihapus' }}</h6>
                                <small class="text-muted" style="font-size: 0.75rem;">{{ $review->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                        
                        @if($review->status === 'approved')
                            <span class="badge rounded-pill border border-success text-success bg-transparent" style="font-weight: 600;">Approved</span>
                        @elseif($review->status === 'pending')
                            <span class="badge rounded-pill border border-warning text-warning bg-transparent" style="font-weight: 600;">Pending</span>
                        @else
                            <span class="badge rounded-pill border border-danger text-danger bg-transparent" style="font-weight: 600;">Rejected</span>
                        @endif
                    </div>

                    <!-- Body Review -->
                    <div class="d-flex justify-content-between mb-3 align-items-center">
                        <span class="text-muted small text-uppercase" style="letter-spacing: 1px; font-size: 0.65rem;">Produk: <strong class="text-dark">{{ $review->product?->name ?? 'Produk Dihapus' }}</strong></span>
                        <div class="text-warning" style="font-size: 0.85rem;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                            @endfor
                        </div>
                    </div>

                    <p class="mb-4 text-muted" style="line-height: 1.7; font-style: italic;">
                        "{{ $review->comment }}"
                    </p>

                    <!-- Balasan Admin (Jika Ada) -->
                    @if($review->replies->count() > 0)
                        <div class="mb-4 p-3 rounded-3 border-start border-3" style="background-color: rgba(0,0,0,0.03); border-color: var(--dk-text) !important;">
                            <strong class="d-block mb-1 text-dark small"><i class="bi bi-shop me-1"></i> Balasan Anda:</strong>
                            @foreach($review->replies as $reply)
                                <p class="mb-0 small text-muted">{{ $reply->reply }}</p>
                            @endforeach
                        </div>
                    @endif

                    <!-- Tombol Aksi (Minimalis) -->
                    <div class="d-flex gap-2 mt-auto pt-3 border-top" style="border-color: #e0d5cb !important;">
                        @if($review->status !== 'approved')
                            <form action="{{ route('admin.reviews.updateStatus', $review->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3" style="font-weight: 600;">Setujui</button>
                            </form>
                        @endif
                        
                        @if($review->status !== 'rejected')
                            <form action="{{ route('admin.reviews.updateStatus', $review->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="rejected">
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3" style="font-weight: 600;">Tolak</button>
                            </form>
                        @endif
                        
                        <button class="btn btn-sm btn-link text-muted text-decoration-none ms-auto p-0 fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#replyForm-{{ $review->id }}" style="font-size: 0.85rem;">
                            <i class="bi bi-reply me-1"></i> Balas
                        </button>
                    </div>

                    <!-- Form Balasan (Collapse) -->
                    <div class="collapse mt-3" id="replyForm-{{ $review->id }}">
                        <form action="{{ route('admin.reviews.reply', $review->id) }}" method="POST" class="d-flex gap-2">
                            @csrf
                            <input type="text" name="reply" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" placeholder="Tulis balasan Anda..." required style="border-bottom: 1px solid #ccc !important;">
                            <button type="submit" class="btn btn-primary px-4" style="border-radius: 50px;">Kirim</button>
                        </form>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 my-5">
                <i class="bi bi-chat-square-text text-muted mb-3 d-block" style="font-size: 4rem; opacity: 0.3;"></i>
                <h3 class="fw-bold" style="font-family: var(--dk-font-heading);">Belum Ada Ulasan</h3>
                <p class="text-muted">Ulasan dari pelanggan akan muncul di sini setelah pesanan mereka selesai.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-5 d-flex justify-content-center">
        {{ $reviews->links('pagination::bootstrap-5') }}
    </div>
@endsection