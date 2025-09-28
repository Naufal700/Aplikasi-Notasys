@extends('layouts.commonMaster')
@section('title','Master Kas & Bank')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Table Card -->
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-1"><i class="mdi mdi-wallet-outline me-2"></i>Master Kas & Bank</h5>
                <small class="opacity-75">Kelola data rekening kas dan bank perusahaan</small>
            </div>
            <a href="{{ route('master.kasbank.create') }}" class="btn btn-light btn-sm">
                <i class="mdi mdi-plus me-1"></i> Tambah Data
            </a>
        </div>

        <div class="card-body">
                                  <!-- Filter Section -->
            <div class="filter-section bg-light rounded p-4 mb-4">
    <form method="GET" action="{{ route('master.kasbank.index') }}" class="row g-3 align-items-end">
        <!-- Search Input -->
        <div class="col-md-4">
            <label class="form-label fw-medium">Pencarian</label>
            <div class="input-group">
                <span class="input-group-text bg-white border-end-0">
                    <i class="mdi mdi-magnify text-muted"></i>
                </span>
                <input type="text" name="search" value="{{ request('search') }}" 
                       class="form-control border-start-0" placeholder="Cari nama akun, bank, atau nomor rekening...">
            </div>
        </div>

        <!-- Jenis Akun Filter -->
        <div class="col-md-3">
            <label class="form-label fw-medium">Jenis Akun</label>
            <select name="jenis" class="form-select">
                <option value="">Semua Jenis</option>
                <option value="Kas" {{ request('jenis') == 'Kas' ? 'selected' : '' }}>Kas</option>
                <option value="Bank" {{ request('jenis') == 'Bank' ? 'selected' : '' }}>Bank</option>
            </select>
        </div>
        
        <!-- Action Buttons -->
        <div class="col-md-5 d-flex align-items-end gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="mdi mdi-filter-variant me-1"></i> Terapkan Filter
            </button>
            <a href="{{ route('master.kasbank.index') }}" class="btn btn-outline-secondary" 
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
                                    <i class="mdi mdi-wallet mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Total Kas</h6>
                                    <h4 class="mb-0">{{ $data->where('jenis', 'Kas')->count() }}</h4>
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
                                    <i class="mdi mdi-bank mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Total Bank</h6>
                                    <h4 class="mb-0">{{ $data->where('jenis', 'Bank')->count() }}</h4>
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
                                    <i class="mdi mdi-account-circle mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Total Akun</h6>
                                    <h4 class="mb-0">{{ $data->total() }}</h4>
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
                                    <i class="mdi mdi-credit-card-multiple mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Rekening Aktif</h6>
                                    <h4 class="mb-0">{{ $data->count() }}</h4>
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
                            <th width="10%" class="border-0">Jenis</th>
                            <th width="25%" class="border-0">Akun / Bank</th>
                            <th width="20%" class="border-0">Atas Nama</th>
                            <th width="20%" class="border-0">Nomor Rekening</th>
                            <th width="20%" class="border-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $i => $d)
                        <tr class="border-bottom">
                            <td class="fw-bold text-muted">
                                {{ ($data->currentPage()-1)*$data->perPage() + $i + 1 }}
                            </td>
                            
                            <!-- Jenis -->
                            <td>
                                <span class="badge bg-{{ $d->jenis == 'Kas' ? 'primary' : 'success' }}">
                                    <i class="mdi mdi-{{ $d->jenis == 'Kas' ? 'wallet' : 'bank' }} me-1"></i>
                                    {{ $d->jenis }}
                                </span>
                            </td>

                            <!-- Nama Akun / Bank -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-{{ $d->jenis == 'Kas' ? 'primary' : 'success' }} rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        <i class="mdi mdi-{{ $d->jenis == 'Kas' ? 'wallet' : 'bank' }} text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-medium text-dark">
                                            {{ $d->jenis == 'Kas' ? $d->nama_akun : $d->nama_bank }}
                                        </div>
                                        @if($d->jenis == 'Bank')
                                        <div class="text-muted small">
                                            {{ $d->nama_akun ?? '-' }}
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Atas Nama -->
                            <td>
                                <div class="fw-medium text-dark">
                                    {{ $d->atas_nama ?? '-' }}
                                </div>
                            </td>

                            <!-- Nomor Rekening -->
                            <td>
                                @if($d->nomor_rekening)
                                <div class="d-flex align-items-center">
                                    <span class="fw-medium text-dark">{{ $d->nomor_rekening }}</span>
                                    <button class="btn btn-sm btn-outline-secondary ms-2 copy-btn" 
                                            data-text="{{ $d->nomor_rekening }}"
                                            data-bs-toggle="tooltip" 
                                            title="Salin nomor rekening">
                                        <i class="mdi mdi-content-copy"></i>
                                    </button>
                                </div>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>

                            <!-- Aksi -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('master.kasbank.edit', $d->id) }}" 
                                       class="btn btn-warning btn-icon btn-sm"
                                       data-bs-toggle="tooltip" 
                                       title="Edit Data">
                                        <i class="mdi mdi-pencil-outline"></i>
                                    </a>
                                    
                                    <form id="deleteForm{{ $d->id }}" 
                                          action="{{ route('master.kasbank.destroy', $d->id) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-danger btn-icon btn-sm" 
                                                onclick="confirmDelete(event, 'deleteForm{{ $d->id }}', '{{ $d->jenis == 'Kas' ? $d->nama_akun : $d->nama_bank }}')" 
                                                data-bs-toggle="tooltip" 
                                                title="Hapus Data">
                                            <i class="mdi mdi-trash-can-outline"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="mdi mdi-wallet-outline mdi-48px text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada data kas & bank</h5>
                                    <p class="text-muted mb-0">Mulai dengan menambahkan akun kas atau bank pertama</p>
                                    <a href="{{ route('master.kasbank.create') }}" class="btn btn-primary mt-3">
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
                    Menampilkan {{ $data->firstItem() ?? 0 }} - {{ $data->lastItem() ?? 0 }} dari {{ $data->total() }} akun
                </div>
                <div>
                    {{ $data->appends(request()->query())->links('pagination::bootstrap-5') }}
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

    // Copy nomor rekening
    document.querySelectorAll('.copy-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const text = this.getAttribute('data-text');
            navigator.clipboard.writeText(text).then(() => {
                // Ubah icon sementara
                const originalHTML = this.innerHTML;
                this.innerHTML = '<i class="mdi mdi-check"></i>';
                this.classList.remove('btn-outline-secondary');
                this.classList.add('btn-outline-success');
                
                setTimeout(() => {
                    this.innerHTML = originalHTML;
                    this.classList.remove('btn-outline-success');
                    this.classList.add('btn-outline-secondary');
                }, 2000);
            });
        });
    });

    // Konfirmasi delete
    function confirmDelete(event, formId, namaAkun) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Data?',
            text: `Apakah Anda yakin ingin menghapus "${namaAkun}"?`,
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

.copy-btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
}

@media (max-width: 768px) {
    .filter-section .col-md-4 {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endpush