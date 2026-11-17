@extends('layouts.admin')

@section('title', 'Manajemen Inventory')
@section('page_title', 'Pergerakan Stok')

@section('content')
    <!-- Header Editorial -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">INVENTARIS</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Pergerakan Stok</h1>
        </div>
    </div>

    <div class="row g-5">
        <!-- Kolom Kiri: Form Input Stok (Gaya Kaca) -->
        <div class="col-lg-4">
            <div class="p-4 h-100" style="background: rgba(255, 255, 255, 0.6); border: 1px solid rgba(255, 255, 255, 0.9); border-radius: 16px; backdrop-filter: blur(10px); box-shadow: 0 10px 30px rgba(0,0,0,0.03);">
                <h5 class="fw-bold mb-4" style="font-family: var(--dk-font-heading);">Catat Pergerakan</h5>
                
                <form action="{{ route('admin.inventory.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Pilih Produk</label>
                        <select name="product_id" class="form-select border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" required style="border-bottom: 1px solid #ccc !important;">
                            <option value="">-- Pilih Produk --</option>
                            @foreach($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }} (Stok: {{ $p->stock }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Tipe Pergerakan</label>
                        <select name="type" class="form-select border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" required style="border-bottom: 1px solid #ccc !important;">
                            <option value="in">Stok Masuk (Restock)</option>
                            <option value="out">Stok Keluar (Rusak/Hilang)</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Jumlah (Qty)</label>
                        <input type="number" name="quantity" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" min="1" placeholder="0" required style="border-bottom: 1px solid #ccc !important; font-size: 1.2rem; font-weight: bold;">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Alasan</label>
                        <input type="text" name="reason" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" placeholder="Misal: Restock supplier" required style="border-bottom: 1px solid #ccc !important;">
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Catatan (Opsional)</label>
                        <textarea name="notes" class="form-control border-0 border-bottom rounded-0 px-0 bg-transparent shadow-none" rows="2" placeholder="Detail tambahan..." style="border-bottom: 1px solid #ccc !important; resize: none;"></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 mt-2">
                        <i class="bi bi-arrow-right-circle me-2"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

        <!-- Kolom Kanan: Tabel Riwayat -->
        <div class="col-lg-8">
            <!-- Header Riwayat -->
            <div class="d-flex justify-content-between align-items-end mb-3">
                <h5 class="fw-bold mb-0" style="font-family: var(--dk-font-heading);">Riwayat Terakhir</h5>
                <span class="text-muted small">Total {{ $movements->total() }} data</span>
            </div>

            <div class="table-responsive">
                {{-- Gunakan style inline untuk memastikan background tabel benar-benar transparan --}}
                <table class="table align-middle mb-0" 
                       style="border-top: 2px solid var(--dk-text); 
                              background-color: transparent !important;
                              --bs-table-bg: transparent; 
                              --bs-table-accent-bg: transparent; 
                              --bs-table-hover-bg: transparent;">
                    <thead>
                        <tr class="text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 1px; border-bottom: 1px solid #e0d5cb;">
                            <th class="py-3 fw-bold" style="background-color: transparent !important;">Waktu</th>
                            <th class="py-3 fw-bold" style="background-color: transparent !important;">Produk</th>
                            <th class="py-3 fw-bold" style="background-color: transparent !important;">Tipe</th>
                            <th class="py-3 fw-bold text-center" style="background-color: transparent !important;">Qty</th>
                            <th class="py-3 fw-bold" style="background-color: transparent !important;">Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movements as $mov)
                            <tr style="border-bottom: 1px solid #e0d5cb; background-color: transparent !important;">
                                <td class="py-3 text-muted" style="font-size: 0.85rem; background-color: transparent !important;">
                                    {{ $mov->created_at->format('d M Y') }} <br>
                                    <small>{{ $mov->created_at->format('H:i') }}</small>
                                </td>
                                <td class="py-3 fw-bold" style="font-family: var(--dk-font-heading); font-size: 1.05rem; background-color: transparent !important;">
                                    {{ $mov->product->name ?? '-' }}
                                </td>
                                <td class="py-3" style="background-color: transparent !important;">
                                    @if($mov->type == 'in')
                                        <span class="badge rounded-pill border border-success text-success bg-transparent" style="font-weight: 600;">Masuk</span>
                                    @elseif($mov->type == 'out')
                                        <span class="badge rounded-pill border border-danger text-danger bg-transparent" style="font-weight: 600;">Keluar</span>
                                    @else
                                        <span class="badge rounded-pill border border-warning text-warning bg-transparent" style="font-weight: 600;">Penyesuaian</span>
                                    @endif
                                </td>
                                <td class="py-3 text-center fw-bold fs-5" style="background-color: transparent !important;">
                                    {{ $mov->type == 'in' ? '+' : '-' }}{{ $mov->quantity }}
                                </td>
                                <td class="py-3" style="background-color: transparent !important;">
                                    <div class="text-dark">{{ $mov->reason }}</div>
                                    
                                    @if($mov->notes)
                                        <small class="text-muted d-block" style="font-style: italic;">"{{ $mov->notes }}"</small>
                                    @endif
                                    
                                    {{-- Info Admin --}}
                                    <small class="text-muted d-block mt-1" style="font-size: 0.75rem;">
                                        <i class="bi bi-person-circle me-1"></i> {{ $mov->admin->name ?? 'Sistem' }}
                                    </small>
                                </td>
                            </tr>
                        @empty
                            <tr style="background-color: transparent !important;">
                                <td colspan="5" class="text-center py-5 text-muted" style="background-color: transparent !important;">Belum ada riwayat pergerakan stok.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-4">
                {{ $movements->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
@endsection