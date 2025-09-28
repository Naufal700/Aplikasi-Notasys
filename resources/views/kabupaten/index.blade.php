@extends('layouts.commonMaster')

@section('title', 'Daftar Kabupaten')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Table Card -->
    <div class="card">
          <div class="card-header bg-light text-dark d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-1"><i class="mdi mdi-city me-2"></i>Daftar Kabupaten</h5>
                <small class="opacity-75">Kelola data kabupaten/kota di Indonesia</small>
            </div>
            <a href="{{ route('kabupaten.create') }}" class="btn btn-light btn-sm">
                <i class="mdi mdi-plus me-1"></i> Tambah Kabupaten
            </a>
        </div>

        <div class="card-body">
            <!-- Table -->
            <div class="table-responsive rounded border">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="10%" class="border-0">#</th>
                            <th width="60%" class="border-0">Kabupaten/Kota</th>
                            <th width="30%" class="border-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kabupaten as $index => $k)
                        <tr class="border-bottom">
                            <td class="fw-bold text-muted">{{ $kabupaten->firstItem() + $index }}</td>
                            
                            <!-- Info Kabupaten -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        <i class="mdi mdi-city text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-medium text-dark">{{ $k->nama }}</div>
                                        <div class="text-muted small">
                                            Provinsi: {{ $k->provinsi->nama ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('kabupaten.edit', $k->id) }}" 
                                       class="btn btn-warning btn-icon btn-sm"
                                       data-bs-toggle="tooltip" 
                                       title="Edit Kabupaten">
                                        <i class="mdi mdi-pencil-outline"></i>
                                    </a>
                                    <form id="deleteForm{{ $k->id }}" 
                                          action="{{ route('kabupaten.destroy', $k->id) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-danger btn-icon btn-sm" 
                                                onclick="confirmDelete(event, 'deleteForm{{ $k->id }}', '{{ $k->nama }}')" 
                                                data-bs-toggle="tooltip" 
                                                title="Hapus Kabupaten">
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
                                    <i class="mdi mdi-city-off mdi-48px text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada data kabupaten</h5>
                                    <p class="text-muted mb-0">Mulai dengan menambahkan kabupaten/kota pertama</p>
                                    <a href="{{ route('kabupaten.create') }}" class="btn btn-primary mt-3">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Kabupaten
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($kabupaten->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $kabupaten->firstItem() ?? 0 }} - {{ $kabupaten->lastItem() ?? 0 }} dari {{ $kabupaten->total() }} kabupaten/kota
                </div>
                <div>
                    {{ $kabupaten->withQueryString()->links('pagination::bootstrap-5') }}
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
    function confirmDelete(event, formId, namaKabupaten) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Kabupaten?',
            text: `Apakah Anda yakin ingin menghapus kabupaten/kota "${namaKabupaten}"?`,
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
