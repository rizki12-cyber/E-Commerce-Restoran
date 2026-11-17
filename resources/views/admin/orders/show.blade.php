@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('page_title', 'Detail Pesanan')

@section('content')
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">INVOICE</span>
                <div style="height: 1px; width: 40px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">#{{ $order->order_number }}</h1>
            <p class="text-muted mt-2 mb-0">Dibuat pada {{ $order->created_at->format('d F Y, H:i') }}</p>
        </div>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-link text-muted text-decoration-none p-0 fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.8rem;">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-auto-dismiss border-0 rounded-3 mb-4" style="background-color: rgba(38, 150, 111, 0.1); color: #26966F;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-auto-dismiss border-0 rounded-3 mb-4" style="background-color: rgba(220, 82, 82, 0.1); color: #DC5252;">{{ session('error') }}</div>
    @endif

    <div class="row g-5">
        <!-- Kolom Kiri: Info & Item -->
        <div class="col-lg-7">
            <div class="p-4 mb-5" style="background: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                <h5 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">Rincian Item</h5>
                
                <div class="d-flex flex-column gap-3 mb-4">
                    @foreach($order->items as $item)
                        <div class="d-flex justify-content-between align-items-start border-bottom pb-3" style="border-color: #e0d5cb !important;">
                            <div>
                                <h6 class="fw-bold mb-1" style="font-size: 1.05rem;">{{ $item->product_name }}</h6>
                                <small class="text-muted d-block">{{ $item->quantity }} x Rp {{ number_format($item->unit_price, 0, ',', '.') }}</small>
                                @if($item->variant_name) <small class="text-muted d-block" style="font-size: 0.8rem;">Varian: {{ $item->variant_name }}</small> @endif
                                @if($item->addon_names) <small class="text-muted d-block" style="font-size: 0.8rem;">Add-on: {{ implode(', ', $item->addon_names) }}</small> @endif
                            </div>
                            <span class="fw-bold">Rp {{ number_format($item->line_total, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span class="fw-bold">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Ongkos Kirim</span>
                    <span class="fw-bold">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                @if($order->discount_amount > 0)
                    <div class="d-flex justify-content-between mb-2 text-success">
                        <span>Diskon Voucher</span>
                        <span class="fw-bold">- Rp {{ number_format($order->discount_amount, 0, ',', '.') }}</span>
                    </div>
                @endif
                
                <hr style="border-color: #e0d5cb; opacity: 1; margin: 1.5rem 0;">
                
                <div class="d-flex justify-content-between align-items-center">
                    <span class="fw-bold text-uppercase" style="letter-spacing: 1px; font-size: 0.85rem;">Total Tagihan</span>
                    <span class="fw-bold" style="color: var(--dk-primary); font-size: 1.8rem; font-family: var(--dk-font-heading);">
                        Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            <div class="p-4" style="background: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                <h5 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">Informasi Pengiriman</h5>
                <div class="row g-3">
                    <div class="col-sm-6">
                        <small class="text-muted text-uppercase d-block mb-1" style="letter-spacing: 1px; font-size: 0.65rem;">Metode</small>
                        <span class="fw-bold">{{ strtoupper($order->shipping_method) }}</span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted text-uppercase d-block mb-1" style="letter-spacing: 1px; font-size: 0.65rem;">Nama Penerima</small>
                        <span class="fw-bold">{{ $order->customer_name }}</span>
                    </div>
                    <div class="col-sm-6">
                        <small class="text-muted text-uppercase d-block mb-1" style="letter-spacing: 1px; font-size: 0.65rem;">No. Telepon</small>
                        <span class="fw-bold">{{ $order->customer_phone }}</span>
                    </div>
                    @if($order->shipping_method === 'delivery')
                        <div class="col-12 mt-3">
                            <small class="text-muted text-uppercase d-block mb-1" style="letter-spacing: 1px; font-size: 0.65rem;">Alamat Lengkap</small>
                            <span class="text-muted" style="line-height: 1.6;">{{ $order->shipping_address['address'] ?? '-' }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Aksi & Timeline -->
        <div class="col-lg-5">
            @if($order->status->value !== 'cancelled' && $order->status->value !== 'completed' && $order->status->value !== 'refunded')
                <div class="p-4 mb-5" style="background: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                    <h5 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">Ubah Status</h5>
                    <form action="{{ route('admin.orders.updateStatus', $order->order_number) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Pilih Status Baru</label>
                            <select name="status" class="form-select border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" required style="border-bottom: 1px solid #ccc !important;">
                                <option value="">-- Pilih Status --</option>
                                @if($order->status->value === 'pending_payment')
                                    <option value="cancelled">Batalkan Pesanan</option>
                                    <option value="paid">Tandai Lunas (Manual)</option>
                                @elseif($order->status->value === 'paid')
                                    <option value="processing">Proses Pesanan</option>
                                    <option value="cancelled">Batalkan (Kembalikan Stok)</option>
                                @elseif($order->status->value === 'processing')
                                    @if($order->shipping_method === 'pickup')
                                        <option value="ready">Siap Diambil</option>
                                    @else
                                        <option value="on_delivery">Sedang Dikirim</option>
                                    @endif
                                    <option value="cancelled">Batalkan (Kembalikan Stok)</option>
                                @elseif($order->status->value === 'ready' || $order->status->value === 'on_delivery')
                                    <option value="completed">Selesaikan Pesanan</option>
                                @endif
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Catatan (Opsional)</label>
                            <textarea name="note" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" rows="2" placeholder="Contoh: Pesanan sedang disiapkan..." style="border-bottom: 1px solid #ccc !important; resize: none;"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">Simpan Perubahan</button>
                    </form>
                </div>
            @endif

            <div class="p-4" style="background: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                <h5 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">Timeline</h5>
                
                <div class="timeline-container ps-3">
                    @foreach($order->statusHistories as $history)
                        <div class="timeline-item position-relative pb-4">
                            <!-- Garis vertikal -->
                            @if(!$loop->last)
                                <div class="position-absolute" style="left: -1px; top: 10px; bottom: 0; width: 1px; background-color: #e0d5cb;"></div>
                            @endif
                            
                            <!-- Titik -->
                            <div class="position-absolute bg-dark rounded-circle" style="left: -5px; top: 5px; width: 9px; height: 9px;"></div>
                            
                            <div class="ps-3">
                                <h6 class="fw-bold mb-1 text-capitalize" style="font-family: var(--dk-font-heading); font-size: 1.1rem;">
                                    {{ str_replace('_', ' ', $history->to_status) }}
                                </h6>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">
                                    {{ $history->created_at->format('d M Y, H:i') }} • Oleh {{ $history->user->name ?? 'Sistem' }}
                                </small>
                                @if($history->note)
                                    <div class="mt-2 p-2 rounded" style="background-color: rgba(0,0,0,0.03); font-size: 0.85rem; color: #555;">
                                        "{{ $history->note }}"
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection