@extends('layouts.commonMaster')

@section('title', 'Daftar Lembar Kerja')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Table Card -->
    <div class="card">
          <div class="card-header bg-light text-dark d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-1"><i class="mdi mdi-file-document-multiple me-2"></i>Daftar Lembar Kerja</h5>
                <small class="opacity-75">Kelola semua lembar kerja dan progress pekerjaan</small>
            </div>
            <a href="{{ route('lembar-kerja.create') }}" class="btn btn-light btn-sm">
                <i class="mdi mdi-plus me-1"></i> Tambah Lembar Kerja
            </a>
        </div>

        <div class="card-body">
            <!-- Search and Filter Section -->
            {{-- <div class="row mb-4">
                <!-- Search Form -->
                <div class="col-md-6">
                    <form method="GET" action="{{ route('lembar-kerja.index') }}" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="mdi mdi-magnify text-muted"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="form-control border-start-0" placeholder="Cari no pesanan, nama klien, atau lembar kerja...">
                        </div>
                        <button type="submit" class="btn btn-primary px-3">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </form>
                </div>
            </div> --}}

            <!-- Filter Section -->
            <div class="filter-section bg-light rounded p-4 mb-4">
                <form method="GET" action="{{ route('lembar-kerja.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-medium">Tanggal Mulai</label>
                        <input type="date" name="tgl_awal" class="form-control" value="{{ request('tgl_awal') }}">
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-medium">Tanggal Akhir</label>
                        <input type="date" name="tgl_akhir" class="form-control" value="{{ request('tgl_akhir') }}">
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label fw-medium">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            @foreach(['draft','proses','persetujuan','dibatalkan','selesai'] as $status)
                                <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label fw-medium">Layanan</label>
                        <select name="layanan_id" class="form-select">
                            <option value="">Semua Layanan</option>
                            @foreach($layanan as $l)
                                <option value="{{ $l->id }}" {{ request('layanan_id') == $l->id ? 'selected' : '' }}>
                                    {{ $l->nama_layanan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <label class="form-label fw-medium">Tipe Pelanggan</label>
                        <select name="tipe_pelanggan" class="form-select">
                            <option value="">Semua Tipe</option>
                            @foreach(['perorangan','perusahaan'] as $tipe)
                                <option value="{{ $tipe }}" {{ request('tipe_pelanggan') == $tipe ? 'selected' : '' }}>
                                    {{ ucfirst($tipe) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-filter-variant me-1"></i> Filter
                        </button>
                        <a href="{{ route('lembar-kerja.index') }}" class="btn btn-outline-secondary" 
                           data-bs-toggle="tooltip" title="Reset Filter">
                            <i class="mdi mdi-refresh"></i>
                        </a>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="table-responsive rounded border">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="border-0">#</th>
                            <th width="15%" class="border-0">Pesanan</th>
                            <th width="20%" class="border-0">Klien & Lembar Kerja</th>
                            <th width="10%" class="border-0">Tipe</th>
                            <th width="10%" class="border-0">Status</th>
                            <th width="15%" class="border-0">Layanan & Timeline</th>
                            <th width="15%" class="border-0">Tanggal</th>
                            <th width="10%" class="border-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lembarKerja as $lk)
                        <tr class="border-bottom">
                            <td class="fw-bold text-muted">{{ $loop->iteration }}</td>
                            
                            <!-- Info Pesanan -->
                            <td>
                                <div class="small">
                                    <div class="fw-medium text-primary">{{ $lk->no_pesanan }}</div>
                                    <div class="text-muted">
                                        {{ $lk->tgl_pesanan ? \Carbon\Carbon::parse($lk->tgl_pesanan)->format('d M Y') : '-' }}
                                    </div>
                                </div>
                            </td>

                            <!-- Klien & Lembar Kerja -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        <i class="mdi mdi-account text-white"></i>
                                    </div>
                                    <div>
                                        <a href="{{ route('lembar-kerja.edit', $lk->id) }}" 
                                           class="text-decoration-none fw-medium text-dark hover-primary d-block">
                                            {{ $lk->klien->nama }}
                                        </a>
                                        <div class="text-muted small mt-1">
                                            <i class="mdi mdi-file-document-outline me-1"></i>
                                            {{ $lk->nama_lembar }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Tipe Pelanggan -->
                            <td>
                                <span class="badge 
                                    @if($lk->tipe_pelanggan == 'perorangan') bg-info
                                    @else bg-warning
                                    @endif">
                                    <i class="mdi mdi-{{ $lk->tipe_pelanggan == 'perorangan' ? 'account' : 'office-building' }} me-1"></i>
                                    {{ ucfirst($lk->tipe_pelanggan) }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td>
                                <span class="badge bg-{{ match($lk->status) {
                                    'draft' => 'secondary',
                                    'proses' => 'info',
                                    'persetujuan' => 'warning',
                                    'dibatalkan' => 'danger',
                                    'selesai' => 'success',
                                    default => 'light'
                                } }}">
                                    <i class="mdi mdi-{{ match($lk->status) {
                                        'draft' => 'pencil',
                                        'proses' => 'progress-clock',
                                        'persetujuan' => 'check-decagram',
                                        'dibatalkan' => 'close-circle',
                                        'selesai' => 'check-circle',
                                        default => 'circle'
                                    } }} me-1"></i>
                                    {{ ucfirst($lk->status) }}
                                </span>
                            </td>

                            <!-- Layanan & Timeline -->
                            <td>
                                <div class="small">
                                    <div class="fw-medium text-dark">{{ $lk->layanan->nama_layanan }}</div>
                                    @if($lk->tgl_target)
                                    <div class="d-flex align-items-center mt-1">
                                        <i class="mdi mdi-calendar-clock me-1 text-muted"></i>
                                        <span class="text-muted">
                                            Target: {{ \Carbon\Carbon::parse($lk->tgl_target)->format('d M Y') }}
                                        </span>
                                    </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Tanggal -->
                            <td>
                                <div class="small">
                                    <div class="fw-medium">Dibuat: {{ $lk->created_at ? \Carbon\Carbon::parse($lk->created_at)->format('d M Y') : '-' }}</div>
                                    <div class="text-muted">Update: {{ $lk->updated_at ? \Carbon\Carbon::parse($lk->updated_at)->format('d M Y') : '-' }}</div>
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    {{-- <a href="{{ route('lembar-kerja.edit', $lk->id) }}" 
                                       class="btn btn-warning btn-icon btn-sm"
                                       data-bs-toggle="tooltip" 
                                       title="Edit Lembar Kerja">
                                        <i class="mdi mdi-pencil-outline"></i>
                                    </a> --}}
                                    <form id="deleteForm{{ $lk->id }}" 
                                          action="{{ route('lembar-kerja.destroy', $lk->id) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-danger btn-icon btn-sm" 
                                                onclick="confirmDelete(event, 'deleteForm{{ $lk->id }}', '{{ $lk->no_pesanan }}')" 
                                                data-bs-toggle="tooltip" 
                                                title="Hapus Lembar Kerja">
                                            <i class="mdi mdi-trash-can-outline"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="mdi mdi-file-document-outline mdi-48px text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada data lembar kerja</h5>
                                    <p class="text-muted mb-0">Mulai dengan membuat lembar kerja pertama Anda</p>
                                    <a href="{{ route('lembar-kerja.create') }}" class="btn btn-primary mt-3">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Lembar Kerja
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($lembarKerja->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $lembarKerja->firstItem() ?? 0 }} - {{ $lembarKerja->lastItem() ?? 0 }} dari {{ $lembarKerja->total() }} lembar kerja
                </div>
                <div>
                    {{ $lembarKerja->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Inisialisasi Bootstrap tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Konfirmasi delete
    function confirmDelete(event, formId, noPesanan) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Lembar Kerja?',
            text: `Apakah Anda yakin ingin menghapus lembar kerja dengan no pesanan "${noPesanan}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(formId).submit();
            }
        });
    }
</script>
@endpush

@push('styles')
<style>
.filter-section {
    background-color: #f8f9fa;
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
    font-size: 0.75rem;
    font-weight: 500;
}

.hover-primary:hover {
    color: #0d6efd !important;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

@media (max-width: 768px) {
    .filter-section .col-md-3,
    .filter-section .col-md-2 {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endpush