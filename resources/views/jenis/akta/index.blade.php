@extends('layouts.commonMaster')

@section('title', 'Master Jenis Akta')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Table Card -->
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-1"><i class="mdi mdi-file-document-multiple me-2"></i>Master Jenis Akta</h5>
                <small class="opacity-75">Kelola data tipe dan nama akta</small>
            </div>
            <a href="{{ route('jenis.akta.create') }}" class="btn btn-light btn-sm">
                <i class="mdi mdi-plus me-1"></i> Tambah Data
            </a>
        </div>

        <div class="card-body">
            <!-- Search and Filter Section -->
            {{-- <div class="row mb-4">
                <!-- Search Form -->
                <div class="col-md-6">
                    <form method="GET" action="{{ route('jenis.akta.index') }}" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="mdi mdi-magnify text-muted"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="form-control border-start-0" placeholder="Cari nama akta...">
                        </div>
                        <button type="submit" class="btn btn-primary px-3">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </form>
                </div>
            </div> --}}

            <!-- Summary Cards -->
            {{-- <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card bg-primary text-white">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-file-document mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Total Jenis Akta</h6>
                                    <h4 class="mb-0">{{ $data->total() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-success text-white">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-folder-multiple mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Tipe Akta Unik</h6>
                                    <h4 class="mb-0">{{ $data->unique('tipe_akta_id')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Table -->
            <div class="table-responsive rounded border">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="border-0">#</th>
                            <th width="30%" class="border-0">Tipe Akta</th>
                            <th width="45%" class="border-0">Nama Akta</th>
                            <th width="20%" class="border-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $row)
                        <tr class="border-bottom">
                            <td class="fw-bold text-muted">{{ $loop->iteration }}</td>
                            
                            <!-- Tipe Akta -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        <i class="mdi mdi-folder-text text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-medium text-dark">
                                            {{ $row->tipe->nama_tipe ?? 'Tidak ada tipe' }}
                                        </div>
                                        <div class="text-muted small">
                                            ID: {{ $row->tipe_akta_id ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Nama Akta -->
                            <td>
                                <div class="fw-medium text-dark">
                                    {{ $row->nama_akta }}
                                </div>
                                @if($row->keterangan)
                                <div class="text-muted small mt-1">
                                    {{ \Illuminate\Support\Str::limit($row->keterangan, 80) }}
                                </div>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('jenis.akta.edit', $row->id) }}" 
                                       class="btn btn-warning btn-icon btn-sm"
                                       data-bs-toggle="tooltip" 
                                       title="Edit Jenis Akta">
                                        <i class="mdi mdi-pencil-outline"></i>
                                    </a>
                                    <form id="deleteForm{{ $row->id }}" 
                                          action="{{ route('jenis.akta.destroy', $row->id) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-danger btn-icon btn-sm" 
                                                onclick="confirmDelete(event, 'deleteForm{{ $row->id }}', '{{ $row->nama_akta }}')" 
                                                data-bs-toggle="tooltip" 
                                                title="Hapus Jenis Akta">
                                            <i class="mdi mdi-trash-can-outline"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="mdi mdi-file-document-outline mdi-48px text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada data jenis akta</h5>
                                    <p class="text-muted mb-0">Mulai dengan menambahkan jenis akta pertama</p>
                                    <a href="{{ route('jenis.akta.create') }}" class="btn btn-primary mt-3">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Data
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($data->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }} jenis akta
                </div>
                <div>
                    {{ $data->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Inisialisasi Bootstrap tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Konfirmasi delete
    function confirmDelete(event, formId, namaAkta) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Jenis Akta?',
            text: `Apakah Anda yakin ingin menghapus "${namaAkta}"?`,
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
});
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

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

@media (max-width: 768px) {
    .filter-section .col-md-6 {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endpush