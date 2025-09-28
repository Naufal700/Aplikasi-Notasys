@extends('layouts.commonMaster')

@section('title', 'Daftar Partner Notaris PPAT')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Table Card -->
    <div class="card">
          <div class="card-header bg-light text-dark d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-1"><i class="mdi mdi-handshake me-2"></i>Daftar Partner Notaris PPAT</h5>
                <small class="opacity-75">Kelola data partner dan mitra kerja</small>
            </div>
            <a href="{{ route('partners.create') }}" class="btn btn-light btn-sm">
                <i class="mdi mdi-plus me-1"></i> Tambah Partner
            </a>
        </div>

        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="row mb-4">
                <!-- Search Form -->
                <div class="col-md-6">
                    <form method="GET" action="{{ route('partners.index') }}" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="mdi mdi-magnify text-muted"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="form-control border-start-0" placeholder="Cari nama partner, email, atau PIC...">
                        </div>
                        <button type="submit" class="btn btn-primary px-3">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section bg-light rounded p-4 mb-4">
                <form method="GET" action="{{ route('partners.index') }}" class="row g-3 align-items-end">
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Provinsi</label>
                        <select name="provinsi_id" id="filter_provinsi" class="form-select">
                            <option value="">Semua Provinsi</option>
                            @foreach($provinsiList as $p)
                                <option value="{{ $p->id }}" {{ request('provinsi_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Kabupaten</label>
                        <select name="kabupaten_id" id="filter_kabupaten" class="form-select">
                            <option value="">Semua Kabupaten</option>
                            @foreach($kabupatenList as $k)
                                <option value="{{ $k->id }}" {{ request('kabupaten_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-4 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="mdi mdi-filter-variant me-1"></i> Filter
                        </button>
                        <a href="{{ route('partners.index') }}" class="btn btn-outline-secondary" 
                           data-bs-toggle="tooltip" title="Reset Filter">
                            <i class="mdi mdi-refresh"></i>
                        </a>
                    </div>
                </form>
            </div>

            <!-- Summary Cards -->
            {{-- <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-account-multiple mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Total Partner</h6>
                                    <h4 class="mb-0">{{ $partners->total() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-map-marker mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Provinsi</h6>
                                    <h4 class="mb-0">{{ $partners->unique('provinsi_id')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-city mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Kabupaten</h6>
                                    <h4 class="mb-0">{{ $partners->unique('kabupaten_id')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-account-tie mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Dengan PIC</h6>
                                    <h4 class="mb-0">{{ $partners->whereNotNull('pic_nama')->count() }}</h4>
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
                            <th width="20%" class="border-0">Partner</th>
                            <th width="15%" class="border-0">Lokasi</th>
                            <th width="15%" class="border-0">Kontak</th>
                            <th width="20%" class="border-0">PIC</th>
                            <th width="15%" class="border-0">Alamat</th>
                            <th width="10%" class="border-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($partners as $index => $partner)
                        <tr class="border-bottom">
                            <td class="fw-bold text-muted">{{ $partners->firstItem() + $index }}</td>
                            
                            <!-- Info Partner -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        <i class="mdi mdi-account-tie text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-medium text-dark">{{ $partner->nama }}</div>
                                        <div class="text-muted small">
                                            {{ $partner->email ?? 'Tidak ada email' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Lokasi -->
                            <td>
                                <div class="small">
                                    <div class="fw-medium text-dark">{{ $partner->kabupaten->nama ?? '-' }}</div>
                                    <div class="text-muted">{{ $partner->provinsi->nama ?? '-' }}</div>
                                </div>
                            </td>

                            <!-- Kontak -->
                            <td>
                                @if($partner->email)
                                <div class="d-flex align-items-center mb-1">
                                    <i class="mdi mdi-email-outline me-2 text-muted"></i>
                                    <span class="text-truncate" style="max-width: 150px;">{{ $partner->email }}</span>
                                </div>
                                @endif
                                @if($partner->telepon)
                                <div class="d-flex align-items-center">
                                    <i class="mdi mdi-phone-outline me-2 text-muted"></i>
                                    <span>{{ $partner->telepon }}</span>
                                </div>
                                @endif
                            </td>

                            <!-- PIC -->
                            <td>
                                @if($partner->pic_nama)
                                <div class="small">
                                    <div class="fw-medium text-dark">{{ $partner->pic_nama }}</div>
                                    <div class="text-muted">{{ $partner->pic_jabatan ?? '-' }}</div>
                                    @if($partner->pic_keterangan)
                                    <div class="text-muted mt-1">
                                        <small>{{ \Illuminate\Support\Str::limit($partner->pic_keterangan, 50) }}</small>
                                    </div>
                                    @endif
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>

                            <!-- Alamat -->
                            <td>
                                <div class="text-truncate" style="max-width: 200px;" 
                                     data-bs-toggle="tooltip" title="{{ $partner->alamat_lengkap ?? 'Tidak ada alamat' }}">
                                    {{ $partner->alamat_lengkap ?? '-' }}
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('partners.edit', $partner->id) }}" 
                                       class="btn btn-warning btn-icon btn-sm"
                                       data-bs-toggle="tooltip" 
                                       title="Edit Partner">
                                        <i class="mdi mdi-pencil-outline"></i>
                                    </a>
                                    <form id="deleteForm{{ $partner->id }}" 
                                          action="{{ route('partners.destroy', $partner->id) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-danger btn-icon btn-sm" 
                                                onclick="confirmDelete(event, 'deleteForm{{ $partner->id }}', '{{ $partner->nama }}')" 
                                                data-bs-toggle="tooltip" 
                                                title="Hapus Partner">
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
                                    <i class="mdi mdi-account-off-outline mdi-48px text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada data partner</h5>
                                    <p class="text-muted mb-0">Mulai dengan menambahkan partner pertama Anda</p>
                                    <a href="{{ route('partners.create') }}" class="btn btn-primary mt-3">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Partner
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($partners->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $partners->firstItem() ?? 0 }} - {{ $partners->lastItem() ?? 0 }} dari {{ $partners->total() }} partner
                </div>
                <div>
                    {{ $partners->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Inisialisasi Bootstrap tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Select2 untuk filter provinsi/kabupaten
    $('#filter_provinsi').select2({ 
        placeholder: "Pilih Provinsi",
        width: '100%'
    });
    
    $('#filter_kabupaten').select2({ 
        placeholder: "Pilih Kabupaten",
        width: '100%'
    });

    // Load kabupaten berdasarkan provinsi saat filter berubah
    $('#filter_provinsi').change(function() {
        let provinsiId = $(this).val();
        $('#filter_kabupaten').html('<option value="">Loading...</option>').trigger('change');

        if(provinsiId){
            $.get("{{ url('partners/kabupaten') }}/"+provinsiId, function(data){
                let options = '<option value="">Semua Kabupaten</option>';
                data.forEach(function(k){
                    options += `<option value="${k.id}">${k.nama}</option>`;
                });
                $('#filter_kabupaten').html(options).trigger('change');
            });
        } else {
            $('#filter_kabupaten').html('<option value="">Semua Kabupaten</option>').trigger('change');
        }
    });

    // Konfirmasi delete
    function confirmDelete(event, formId, namaPartner) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Partner?',
            text: `Apakah Anda yakin ingin menghapus "${namaPartner}"?`,
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

.select2-container .select2-selection--single {
    height: 38px;
    border: 1px solid #ced4da;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px;
}

@media (max-width: 768px) {
    .filter-section .col-md-4 {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .select2-container {
        width: 100% !important;
    }
}
</style>
@endpush