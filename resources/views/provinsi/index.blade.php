@extends('layouts.commonMaster')

@section('title', 'Daftar Provinsi')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Table Card -->
    <div class="card">
          <div class="card-header bg-light text-dark d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-1"><i class="mdi mdi-map-marker-multiple me-2"></i>Daftar Provinsi</h5>
                <small class="opacity-75">Kelola data provinsi di Indonesia</small>
            </div>
            <a href="{{ route('provinsi.create') }}" class="btn btn-light btn-sm">
                <i class="mdi mdi-plus me-1"></i> Tambah Provinsi
            </a>
        </div>

        <div class="card-body">
            <!-- Search and Filter Section -->
            {{-- <div class="row mb-4">
                <!-- Search Form -->
                <div class="col-md-6">
                    <form method="GET" action="{{ route('provinsi.index') }}" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="mdi mdi-magnify text-muted"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="form-control border-start-0" placeholder="Cari nama provinsi...">
                        </div>
                        <button type="submit" class="btn btn-primary px-3">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </form>
                </div>
            </div> --}}

            <!-- Summary Cards -->
            {{-- <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-map-marker-radius mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Total Provinsi</h6>
                                    <h4 class="mb-0">{{ $provinsi->total() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-success text-white">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-city mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Kabupaten/Kota</h6>
                                    <h4 class="mb-0">{{ $totalKabupaten ?? '0' }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card bg-info text-white">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-earth mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Wilayah</h6>
                                    <h4 class="mb-0">Indonesia</h4>
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
                            <th width="10%" class="border-0">#</th>
                            <th width="60%" class="border-0">Provinsi</th>
                            <th width="30%" class="border-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($provinsi as $index => $p)
                        <tr class="border-bottom">
                            <td class="fw-bold text-muted">{{ $provinsi->firstItem() + $index }}</td>
                            
                            <!-- Info Provinsi -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        <i class="mdi mdi-map-marker text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-medium text-dark">{{ $p->nama }}</div>
                                        <div class="text-muted small">
                                            @if($p->kabupaten_count > 0)
                                                {{ $p->kabupaten_count }} Kabupaten/Kota
                                            @else
                                                Belum ada kabupaten
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('provinsi.edit', $p->id) }}" 
                                       class="btn btn-warning btn-icon btn-sm"
                                       data-bs-toggle="tooltip" 
                                       title="Edit Provinsi">
                                        <i class="mdi mdi-pencil-outline"></i>
                                    </a>
                                    <form id="deleteForm{{ $p->id }}" 
                                          action="{{ route('provinsi.destroy', $p->id) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-danger btn-icon btn-sm" 
                                                onclick="confirmDelete(event, 'deleteForm{{ $p->id }}', '{{ $p->nama }}')" 
                                                data-bs-toggle="tooltip" 
                                                title="Hapus Provinsi">
                                            <i class="mdi mdi-trash-can-outline"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="mdi mdi-map-marker-off mdi-48px text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada data provinsi</h5>
                                    <p class="text-muted mb-0">Mulai dengan menambahkan provinsi pertama</p>
                                    <a href="{{ route('provinsi.create') }}" class="btn btn-primary mt-3">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Provinsi
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($provinsi->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $provinsi->firstItem() ?? 0 }} - {{ $provinsi->lastItem() ?? 0 }} dari {{ $provinsi->total() }} provinsi
                </div>
                <div>
                    {{ $provinsi->withQueryString()->links('pagination::bootstrap-5') }}
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
    function confirmDelete(event, formId, namaProvinsi) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Provinsi?',
            text: `Apakah Anda yakin ingin menghapus provinsi "${namaProvinsi}"?`,
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
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endpush