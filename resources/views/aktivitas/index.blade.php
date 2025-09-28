@extends('layouts.commonMaster')

@section('title', 'Aktivitas User')

@section('layoutContent')
<div class="container-fluid py-4">
    <div class="card shadow-sm border-0">
          <div class="card-header bg-light text-dark d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-0"><i class="fas fa-history me-2"></i>Log Aktivitas User</h5>
                <small class="opacity-75">Riwayat aktivitas pengguna dalam sistem</small>
            </div>
            <div class="action-buttons">
                <a href="{{ route('aktivitas.index') }}" class="btn btn-light btn-sm">
                    <i class="fas fa-sync-alt me-1"></i> Refresh
                </a>
                {{-- Kalau mau tambah fitur export --}}
                {{-- <button class="btn btn-outline-light btn-sm">
                    <i class="fas fa-download me-1"></i> Export
                </button> --}}
            </div>
        </div>

        <div class="card-body">
            <!-- Filter Section -->
            <div class="filter-section bg-light rounded p-4 mb-4">
                <form method="GET" action="{{ route('aktivitas.index') }}">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label for="search" class="form-label fw-medium">Pencarian</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
                                <input type="text" name="search" id="search" class="form-control border-start-0"
                                       placeholder="Cari user, menu, atau aktivitas..."
                                       value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="start_date" class="form-label fw-medium">Tanggal Mulai</label>
                            <input type="date" name="start_date" id="start_date" class="form-control"
                                   value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-3">
                            <label for="end_date" class="form-label fw-medium">Tanggal Akhir</label>
                            <input type="date" name="end_date" id="end_date" class="form-control"
                                   value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter me-1"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Table Section -->
            <div class="table-responsive rounded border">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="border-0">#</th>
                            <th width="15%" class="border-0">User</th>
                            <th width="15%" class="border-0">Menu</th>
                            <th width="20%" class="border-0">Aktivitas</th>
                            <th width="25%" class="border-0">Detail</th>
                            <th width="20%" class="border-0">Waktu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $index => $log)
                        <tr class="border-bottom">
                            <td class="fw-bold text-muted">{{ $logs->firstItem() + $index }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{-- <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 36px; height: 36px;">
                                        <i class="fas fa-user text-white" style="font-size: 0.9rem;"></i>
                                    </div> --}}
                                    <div>
                                        <div class="fw-medium text-dark">{{ $log->user->name ?? 'Guest' }}</div>
                                        <small class="text-muted">{{ $log->user->email ?? 'N/A' }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">{{ $log->modul }}</span>
                            </td>
                            <td>
                                <div class="fw-medium text-dark">{{ $log->aktivitas }}</div>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 1000px;" title="{{ $log->detail }}">
                                    {{ $log->detail }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column">
                                    <span class="fw-medium text-dark">{{ $log->created_at->format('d M Y') }}</span>
                                    <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada aktivitas</h5>
                                    <p class="text-muted mb-0">Tidak ada data aktivitas yang tercatat untuk saat ini.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($logs->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $logs->firstItem() ?? 0 }} - {{ $logs->lastItem() ?? 0 }} dari {{ $logs->total() }} aktivitas
                </div>
                <div>
                    {{ $logs->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<style>
.filter-section {
    background-color: #f8f9fa;
    border-radius: 10px;
}

.table th {
    font-weight: 600;
    font-size: 0.875rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    color: #6c757d;
}

.table td {
    padding: 1rem 0.75rem;
    vertical-align: middle;
}

.table tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.04);
}

.empty-state {
    padding: 2rem 1rem;
}

.badge {
    font-size: 0.8rem;
    font-weight: 500;
}

.card {
    border: none;
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1);
    border-radius: 12px;
}

.card-header {
    border-radius: 12px 12px 0 0 !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.action-buttons .btn {
    margin-left: 0.5rem;
}

@media (max-width: 768px) {
    .container-fluid {
        padding: 1rem;
    }
    
    .filter-section .col-md-4,
    .filter-section .col-md-3,
    .filter-section .col-md-2 {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .action-buttons {
        margin-top: 1rem;
        width: 100%;
        display: flex;
        justify-content: flex-end;
    }
}
</style>
@endsection