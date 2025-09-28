@extends('layouts.commonMaster')

@section('title', 'Daftar Klien')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Table Card -->
    <div class="card">
        <div class="card-header bg-light text-dark d-flex justify d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-1"><i class="mdi mdi-account-multiple me-2"></i>Daftar Klien</h5>
                <small class="opacity-75">Kelola data klien dengan mudah</small>
            </div>
            <div class="action-buttons">
                <a href="{{ route('klien.create') }}" class="btn btn-light btn-sm">
                    <i class="mdi mdi-plus me-1"></i> Tambah Klien
                </a>
            </div>
        </div>

        <div class="card-body">
            <!-- Search and Filter Section -->
            <div class="row mb-4">
                <!-- Search Form -->
                <div class="col-md-6">
                    <form method="GET" action="{{ route('klien.index') }}" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="mdi mdi-magnify text-muted"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="form-control border-start-0" placeholder="Cari nama klien...">
                        </div>
                        <button type="submit" class="btn btn-primary px-3">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section bg-light rounded p-4 mb-4">
                <form method="GET" action="{{ route('klien.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-medium">Kategori Klien</label>
                        <select name="tipe" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="pribadi" {{ request('tipe')=='pribadi'?'selected':'' }}>Pribadi</option>
                            <option value="bank_leasing" {{ request('tipe')=='bank_leasing'?'selected':'' }}>Bank / Leasing</option>
                            <option value="perusahaan" {{ request('tipe')=='perusahaan'?'selected':'' }}>Perusahaan</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label fw-medium">Tanggal Mulai</label>
                        <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" 
                               class="form-control">
                    </div>
                    
                    <div class="col-md-3">
                        <label class="form-label fw-medium">Tanggal Sampai</label>
                        <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" 
                               class="form-control">
                    </div>
                    
                    <div class="col-md-3 d-flex align-items-end gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="mdi mdi-filter-variant me-1"></i> Filter
                        </button>
                        <a href="{{ route('klien.index') }}" class="btn btn-outline-secondary" 
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
                            <th width="20%" class="border-0">Nama Klien</th>
                            <th width="10%" class="border-0">Tipe</th>
                            <th width="15%" class="border-0">Kontak</th>
                            <th width="15%" class="border-0">Lokasi</th>
                            <th width="15%" class="border-0">Tanggal</th>
                            <th width="10%" class="border-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($klien as $item)
                        <tr class="border-bottom">
                            <td class="fw-bold text-muted">{{ $loop->iteration }}</td>
                            
                            <!-- Nama dengan Link Edit -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        <i class="mdi mdi-account text-white"></i>
                                    </div>
                                    <div>
                                        <a href="{{ route('klien.edit', $item->id) }}" 
                                           class="text-decoration-none fw-medium text-dark hover-primary">
                                            {{ $item->nama }}
                                        </a>
                                        <div class="text-muted small">{{ $item->email }}</div>
                                    </div>
                                </div>
                            </td>

                            <!-- Tipe -->
                            <td>
                                <span class="badge 
                                    @if($item->tipe == 'pribadi') bg-info
                                    @elseif($item->tipe == 'bank_leasing') bg-warning
                                    @else bg-success
                                    @endif">
                                    {{ ucfirst(str_replace('_', ' ', $item->tipe)) }}
                                </span>
                            </td>

                            <!-- Kontak -->
                            <td>
                                <div class="d-flex flex-column">
                                    @if($item->no_telepon)
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="me-2">{{ $item->no_telepon }}</span>
                                        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/','',$item->no_telepon)) }}" 
                                           target="_blank" 
                                           class="text-success whatsapp-icon"
                                           data-bs-toggle="tooltip" 
                                           title="Hubungi via WhatsApp">
                                            <i class="mdi mdi-whatsapp mdi-18px"></i>
                                        </a>
                                    </div>
                                    @endif
                                    
                                    @if($item->email)
                                    <div class="d-flex align-items-center">
                                        <a href="https://mail.google.com/mail/?view=cm&to={{ $item->email }}" 
                                           target="_blank"
                                           class="text-decoration-none text-muted small"
                                           data-bs-toggle="tooltip" 
                                           title="Kirim Email">
                                            <i class="mdi mdi-email-outline me-1"></i>
                                            {{ \Illuminate\Support\Str::limit($item->email, 20) }}
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Lokasi -->
                            <td>
                                <div class="small">
                                    <div class="fw-medium">{{ $item->kabupaten->nama ?? '-' }}</div>
                                    <div class="text-muted">{{ $item->provinsi->nama ?? '-' }}</div>
                                </div>
                            </td>

                            <!-- Tanggal -->
                            <td>
                                <div class="small">
                                    <div class="fw-medium">Dibuat: {{ $item->created_at->format('d M Y') }}</div>
                                    <div class="text-muted">Update: {{ $item->updated_at->format('d M Y') }}</div>
                                </div>
                            </td>

                            <!-- Aksi -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    {{-- <a href="{{ route('klien.edit', $item->id) }}" 
                                       class="btn btn-warning btn-icon btn-sm"
                                       data-bs-toggle="tooltip" 
                                       title="Edit Klien">
                                        <i class="mdi mdi-pencil-outline"></i>
                                    </a> --}}
                                    <form id="deleteForm{{ $item->id }}" 
                                          action="{{ route('klien.destroy', $item->id) }}" 
                                          method="POST" 
                                          style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-danger btn-icon btn-sm" 
                                                onclick="confirmDelete(event, 'deleteForm{{ $item->id }}','{{ $item->nama }}')" 
                                                data-bs-toggle="tooltip" 
                                                title="Hapus Klien">
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
                                    <h5 class="text-muted">Belum ada data klien</h5>
                                    <p class="text-muted mb-0">Mulai dengan menambahkan klien pertama Anda</p>
                                    <a href="{{ route('klien.create') }}" class="btn btn-primary mt-3">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Klien
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($klien->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $klien->firstItem() ?? 0 }} - {{ $klien->lastItem() ?? 0 }} dari {{ $klien->total() }} klien
                </div>
                <div>
                    {{ $klien->withQueryString()->links('pagination::bootstrap-5') }}
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

    // Hover efek WA & Gmail
    document.querySelectorAll('.whatsapp-icon').forEach(el => {
        el.addEventListener('mouseenter', () => el.style.color = '#25D366');
        el.addEventListener('mouseleave', () => el.style.color = '#28a745');
    });

    // Konfirmasi delete
    function confirmDelete(event, formId, namaKlien) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Klien?',
            text: `Apakah Anda yakin ingin menghapus klien "${namaKlien}"?`,
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

.whatsapp-icon:hover, .gmail-icon:hover {
    transform: scale(1.2);
    transition: transform 0.2s;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

.action-buttons .btn {
    margin-left: 0.5rem;
}

@media (max-width: 768px) {
    .filter-section .col-md-3 {
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
@endpush