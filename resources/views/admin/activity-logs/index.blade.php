@extends('layouts.admin')

@section('title', 'Activity Log')
@section('page_title', 'Log Aktivitas Admin')

@section('content')
    <!-- Header Editorial -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 mt-2">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <span class="text-uppercase fw-bold text-muted" style="letter-spacing: 3px; font-size: 0.75rem;">SISTEM</span>
                <div style="height: 1px; width: 60px; background-color: #ccc;"></div>
            </div>
            <h1 class="display-5 fw-bold mb-0" style="font-family: var(--dk-font-heading);">Activity Log</h1>
            <p class="text-muted mt-2 mb-0">Rekam jejak seluruh tindakan administratif di dalam sistem.</p>
        </div>
    </div>

    <!-- Tabel Minimalis -->
    <div class="table-responsive">
        <table class="table align-middle mb-0" style="border-top: 2px solid var(--dk-text);">
            <thead>
                <tr class="text-uppercase text-muted" style="font-size: 0.7rem; letter-spacing: 1px; border-bottom: 1px solid #e0d5cb;">
                    <th class="py-3 fw-bold">Waktu</th>
                    <th class="py-3 fw-bold">Admin</th>
                    <th class="py-3 fw-bold">Aksi</th>
                    <th class="py-3 fw-bold">Deskripsi</th>
                    <th class="py-3 fw-bold text-end">IP Address</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr style="border-bottom: 1px solid #e0d5cb; transition: background-color 0.2s;">
                        <td class="py-3 text-nowrap text-muted" style="font-size: 0.85rem;">
                            {{ $log->created_at->format('d M Y') }} <br>
                            <small style="font-size: 0.75rem;">{{ $log->created_at->format('H:i:s') }}</small>
                        </td>
                        <td class="py-3">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-dark text-white rounded-circle d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width: 32px; height: 32px; font-size: 0.8rem; font-family: var(--dk-font-heading);">
                                    {{ substr($log->user->name ?? 'S', 0, 1) }}
                                </div>
                                <span class="fw-bold text-dark" style="font-size: 0.95rem;">{{ $log->user->name ?? 'Sistem' }}</span>
                            </div>
                        </td>
                        <td class="py-3">
                            <!-- Aksi bergaya monospace seperti log sistem -->
                            <span class="badge border border-secondary text-secondary bg-transparent rounded-1" style="font-family: monospace; font-weight: 500; font-size: 0.8rem;">
                                {{ $log->action }}
                            </span>
                        </td>
                        <td class="py-3 text-muted" style="font-size: 0.9rem; max-width: 400px; white-space: normal;">
                            {{ $log->description }}
                        </td>
                        <td class="py-3 text-end text-muted" style="font-family: monospace; font-size: 0.8rem;">
                            {{ $log->ip_address }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-journal-x fs-1 mb-3 d-block opacity-25"></i>
                            Belum ada aktivitas yang tercatat.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $logs->links('pagination::bootstrap-5') }}
    </div>

    <style>
    /* Hilangkan background putih pada tabel */
    .table,
    .table thead,
    .table tbody,
    .table tr,
    .table th,
    .table td {
        background-color: transparent !important;
        --bs-table-bg: transparent !important;
        --bs-table-accent-bg: transparent !important;
        --bs-table-hover-bg: transparent !important;
        box-shadow: none !important;
    }

    /* Pastikan wrapper tabel transparan */
    .table-responsive {
        background: transparent !important;
    }

    /* Efek hover tetap transparan */
    .table tbody tr:hover {
        background-color: rgba(40, 150, 114, 0.04) !important;
    }
</style>
@endsection