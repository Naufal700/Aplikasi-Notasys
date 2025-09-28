@extends('layouts.commonMaster')

@section('title', 'Daftar Bank/Leasing')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Table Card -->
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-1"><i class="mdi mdi-bank me-2"></i>Daftar Bank / Leasing</h5>
                <small class="opacity-75">Kelola data bank dan leasing partner</small>
            </div>
            <a href="{{ route('bank-leasing.create') }}" class="btn btn-light btn-sm">
                <i class="mdi mdi-plus me-1"></i> Tambah Bank/Leasing
            </a>
        </div>

        <div class="card-body">
            {{-- <!-- Search and Filter Section -->
            <div class="row mb-4">
                <!-- Search Form -->
                <div class="col-md-6">
                    <form method="GET" action="{{ route('bank-leasing.index') }}" class="d-flex gap-2">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="mdi mdi-magnify text-muted"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="form-control border-start-0" placeholder="Cari nama lembaga...">
                        </div>
                        <button type="submit" class="btn btn-primary px-3">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </form>
                </div>
            </div> --}}

            <!-- Filter Section -->
            <div class="filter-section bg-light rounded p-4 mb-4">
                <form method="GET" action="{{ route('bank-leasing.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Cabang</label>
                        <input type="text" name="cabang" class="form-control" 
                               placeholder="Cari cabang..." value="{{ request('cabang') }}">
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Tanggal Mulai</label>
                        <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                    </div>
                    
                    <div class="col-md-4">
                        <label class="form-label fw-medium">Tanggal Sampai</label>
                        <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                    </div>
                    
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-filter-variant me-1"></i> Filter
                        </button>
                        <a href="{{ route('bank-leasing.index') }}" class="btn btn-outline-secondary" 
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
                            <th width="20%" class="border-0">Lembaga</th>
                            <th width="15%" class="border-0">PKS</th>
                            <th width="20%" class="border-0">Kontak Person</th>
                            <th width="15%" class="border-0">Status PKS</th>
                            <th width="15%" class="border-0">Tanggal</th>
                            <th width="10%" class="border-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bankLeasings as $item)
                        <tr class="border-bottom">
                            <td class="fw-bold text-muted">{{ $loop->iteration + $bankLeasings->firstItem() - 1 }}</td>
                            
                            <!-- Info Lembaga -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        <i class="mdi mdi-bank text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-medium text-dark">{{ $item->nama_lembaga }}</div>
                                        <div class="text-muted small">
                                            <i class="mdi mdi-map-marker-outline me-1"></i>{{ $item->cabang }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Info PKS -->
                            <td>
                                <div class="small">
                                    <div class="fw-medium">No: {{ $item->no_pks ?? '-' }}</div>
                                    @if($item->tanggal_berakhir_pks)
                                    <div class="text-muted">
                                        Berakhir: {{ \Carbon\Carbon::parse($item->tanggal_berakhir_pks)->format('d M Y') }}
                                    </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Kontak Person -->
                            <td>
                                <div class="small">
                                    <!-- Marketing -->
                                    @if($item->nama_marketing)
                                    <div class="mb-2">
                                        <div class="fw-medium text-primary">Marketing</div>
                                        <div>{{ $item->nama_marketing }}</div>
                                        @if($item->no_hp_marketing)
                                        <div class="d-flex align-items-center">
                                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/','',$item->no_hp_marketing)) }}" 
                                               target="_blank" 
                                               class="text-success whatsapp-icon me-2"
                                               data-bs-toggle="tooltip" 
                                               title="Hubungi Marketing">
                                                <i class="mdi mdi-whatsapp"></i>
                                            </a>
                                            <span>{{ $item->no_hp_marketing }}</span>
                                        </div>
                                        @endif
                                    </div>
                                    @endif

                                    <!-- ADK -->
                                    @if($item->nama_adk)
                                    <div class="mb-2">
                                        <div class="fw-medium text-info">ADK</div>
                                        <div>{{ $item->nama_adk }}</div>
                                        @if($item->no_hp_adk)
                                        <div class="d-flex align-items-center">
                                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/','',$item->no_hp_adk)) }}" 
                                               target="_blank" 
                                               class="text-success whatsapp-icon me-2"
                                               data-bs-toggle="tooltip" 
                                               title="Hubungi ADK">
                                                <i class="mdi mdi-whatsapp"></i>
                                            </a>
                                            <span>{{ $item->no_hp_adk }}</span>
                                        </div>
                                        @endif
                                    </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Status PKS -->
                            <td>
                                @if($item->tanggal_berakhir_pks)
                                    @php
                                        $daysLeft = \Carbon\Carbon::parse($item->tanggal_berakhir_pks)->diffInDays(now());
                                    @endphp
                                    @if($daysLeft <= 30)
                                        <span class="badge bg-danger">
                                            <i class="mdi mdi-alert-circle-outline me-1"></i>
                                            Kadaluarsa dalam {{ $daysLeft }} hari
                                        </span>
                                    @elseif($daysLeft <= 90)
                                        <span class="badge bg-warning">
                                            <i class="mdi mdi-clock-alert-outline me-1"></i>
                                            {{ $daysLeft }} hari lagi
                                        </span>
                                    @else
                                        <span class="badge bg-success">
                                            <i class="mdi mdi-check-circle-outline me-1"></i>
                                            Aktif
                                        </span>
                                    @endif
                                @else
                                    <span class="badge bg-secondary">Tidak ada PKS</span>
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
                                    <a href="{{ route('bank-leasing.edit', $item->id) }}" 
                                       class="btn btn-warning btn-icon btn-sm"
                                       data-bs-toggle="tooltip" 
                                       title="Edit Bank/Leasing">
                                        <i class="mdi mdi-pencil-outline"></i>
                                    </a>
                                    <form id="deleteForm{{ $item->id }}" 
                                          action="{{ route('bank-leasing.destroy', $item->id) }}" 
                                          method="POST" 
                                          class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                                class="btn btn-danger btn-icon btn-sm" 
                                                onclick="confirmDelete(event, 'deleteForm{{ $item->id }}', '{{ $item->nama_lembaga }}')" 
                                                data-bs-toggle="tooltip" 
                                                title="Hapus Bank/Leasing">
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
                                    <i class="mdi mdi-bank-outline mdi-48px text-muted mb-3"></i>
                                    <h5 class="text-muted">Belum ada data bank/leasing</h5>
                                    <p class="text-muted mb-0">Mulai dengan menambahkan bank/leasing pertama Anda</p>
                                    <a href="{{ route('bank-leasing.create') }}" class="btn btn-primary mt-3">
                                        <i class="mdi mdi-plus me-1"></i> Tambah Bank/Leasing
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($bankLeasings->hasPages())
            <div class="d-flex justify-content-between align-items-center mt-4">
                <div class="text-muted">
                    Menampilkan {{ $bankLeasings->firstItem() ?? 0 }} - {{ $bankLeasings->lastItem() ?? 0 }} dari {{ $bankLeasings->total() }} bank/leasing
                </div>
                <div>
                    {{ $bankLeasings->withQueryString()->links('pagination::bootstrap-5') }}
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
    function confirmDelete(event, formId, namaLembaga) {
        event.preventDefault();
        Swal.fire({
            title: 'Hapus Bank/Leasing?',
            text: `Apakah Anda yakin ingin menghapus "${namaLembaga}"?`,
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
    .filter-section .col-md-4 {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endpush