@extends('layouts.commonMaster')

@section('title', 'Daftar Perusahaan')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Table Card -->
    <div class="card">
          <div class="card-header bg-light text-dark d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-1"><i class="mdi mdi-office-building me-2"></i>Daftar Perusahaan</h5>
                <small class="opacity-75">Kelola data perusahaan dan lembaga</small>
            </div>
            <a href="{{ route('perusahaan.create') }}" class="btn btn-light btn-sm">
                <i class="mdi mdi-plus me-1"></i> Tambah Perusahaan
            </a>
        </div>

        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="row mb-4">
                <!-- Search Form -->
                <div class="col-md-6">
                    <form method="GET" action="{{ route('perusahaan.index') }}" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="mdi mdi-magnify text-muted"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="form-control border-start-0" placeholder="Cari nama perusahaan...">
                        </div>
                        <button type="submit" class="btn btn-primary px-3">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section bg-light rounded p-4 mb-4">
                <form method="GET" action="{{ route('perusahaan.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-medium">Jenis Lembaga</label>
                        <select name="jenis_lembaga" class="form-select">
                            <option value="">Semua Jenis</option>
                            @foreach(['PT','CV','Koperasi','Yayasan'] as $jenis)
                                <option value="{{ $jenis }}" {{ request('jenis_lembaga') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-medium">Tanggal Mulai</label>
                        <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-medium">Tanggal Sampai</label>
                        <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                    </div>
                    
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="mdi mdi-filter-variant me-1"></i> Filter
                        </button>
                        <a href="{{ route('perusahaan.index') }}" class="btn btn-outline-secondary" 
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
                            <th width="15%" class="border-0">Perusahaan</th>
                            <th width="10%" class="border-0">Jenis</th>
                            <th width="15%" class="border-0">Kontak</th>
                            <th width="15%" class="border-0">PIC</th>
                            <th width="15%" class="border-0">Tanggal</th>
                            <th width="10%" class="border-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($perusahaans as $item)
                        <tr class="border-bottom">
                            <td class="fw-bold text-muted">{{ $loop->iteration + $perusahaans->firstItem() - 1 }}</td>
                            
                            <!-- Info Perusahaan -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        <i class="mdi mdi-office-building text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-medium text-dark">{{ $item->nama_lembaga }}</div>
                                        <div class="text-muted small">{{ $item->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Jenis Lembaga -->
                            <td>
                                <span class="badge 
                                    @if($item->jenis_lembaga == 'PT') bg-primary
                                    @elseif($item->jenis_lembaga == 'CV') bg-info
                                    @elseif($item->jenis_lembaga == 'Koperasi') bg-success
                                    @else bg-warning
                                    @endif">
                                    {{ $item->jenis_lembaga }}
                                </span>
                            </td>

                            <!-- Kontak -->
                            <td>
                                <div class="small">
                                    @if($item->telp_kantor)
                                    <div class="d-flex align-items-center mb-1">
                                        <i class="mdi mdi-phone-outline me-2 text-muted"></i>
                                        <span>{{ $item->telp_kantor }}</span>
                                    </div>
                                    @endif
                                    
                                    @if($item->email)
                                    <div class="d-flex align-items-center">
                                        <i class="mdi mdi-email-outline me-2 text-muted"></i>
                                        <span class="text-truncate" style="max-width: 150px;">{{ $item->email }}</span>
                                    </div>
                                    @endif
                                </div>
                            </td>

                            <!-- PIC -->
                            <td>
                                @if($item->nama_pic)
                                <div class="small">
                                    <div class="fw-medium">{{ $item->nama_pic }}</div>
                                    @if($item->no_telp_pic)
                                    <div class="d-flex align-items-center mt-1">
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/','',$item->no_telp_pic)) }}" 
                                           target="_blank" 
                                           class="text-success whatsapp-icon me-2"
                                           data-bs-toggle="tooltip" 
                                           title="Hubungi PIC via WhatsApp">
                                            <i class="mdi mdi-whatsapp"></i>
                                        </a>
                                        <span class="text-muted">{{ $item->no_telp_pic }}</span>
                                    </div>
                                    @endif
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>

                            <!-- Tanggal -->
                            <td>
                                <div class="small">
                                    <div class="fw-medium">Dibuat: {{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d M Y') : '-' }}</div>
                                    <div class="text-muted">Update: {{ $item->updated_at ? \Carbon\Carbon::parse($item->updated_at)->format('d M Y') : '-' }}</div>
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('perusahaan.edit', $item->id) }}" 
                                       class="btn btn-warning btn-icon btn-sm"
                                       data-bs-toggle="tooltip" 
                                       title="Edit Perusahaan">
                                        <i class="mdi mdi-pencil-outline"></i>
                                    </a>
                                    <form id="deleteForm{{ $item->id }}" 
                                          action="{{ route('perusahaan.destroy', $item->id) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-danger btn-icon btn-sm" 
                                                onclick="confirmDelete(event, 'deleteForm{{ $item->id }}', '{{ $item->nama_lembaga }}')" 
                                                data-bs-toggle="tooltip" 
                                                title="Hapus Perusahaan">
                                            <i class="mdi mdi-trash-can-outline"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="mdi mdi-office-building-outline mdi-48px text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada data perusahaan</h5>
                                    <p class="text-muted mb-0">Mulai dengan menambahkan perusahaan pertama Anda</p>
                                    <a href="{{ route('perusahaan.create') }}" class="btn btn-primary mt-3">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Perusahaan
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($perusahaans->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $perusahaans->firstItem() ?? 0 }} - {{ $perusahaans->lastItem() ?? 0 }} dari {{ $perusahaans->total() }} perusahaan
                </div>
                <div>
                    {{ $perusahaans->withQueryString()->links('pagination::bootstrap-5') }}
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

    // Hover efek WA
    document.querySelectorAll('.whatsapp-icon').forEach(el => {
        el.addEventListener('mouseenter', () => el.style.color = '#25D366');
        el.addEventListener('mouseleave', () => el.style.color = '#28a745');
    });

    // Konfirmasi delete
    function confirmDelete(event, formId, namaPerusahaan) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Perusahaan?',
            text: `Apakah Anda yakin ingin menghapus perusahaan "${namaPerusahaan}"?`,
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

.whatsapp-icon:hover {
    transform: scale(1.2);
    transition: transform 0.2s;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

@media (max-width: 768px) {
    .filter-section .col-md-3 {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endpush