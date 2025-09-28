@extends('layouts.commonMaster')

@section('title', 'Monitoring Lembar Kerja')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Table Card -->
    <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-1"><i class="mdi mdi-monitor-dashboard me-2"></i>Monitoring Lembar Kerja</h5>
                <small class="opacity-75">Pantau progress dan timeline pekerjaan</small>
            </div>
            <div class="text-white">
                <span class="badge bg-light text-dark">
                    <i class="mdi mdi-counter me-1"></i>
                    Total: {{ $lembarKerja->total() }}
                </span>
            </div>
        </div>

        <div class="card-body">
            <!-- Tabs -->
            <ul class="nav nav-tabs nav-tabs-custom mb-4" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $tab === 'lembar_kerja' ? 'active' : '' }}" 
                       href="{{ route('lembar-kerja.monitoring', ['tab' => 'lembar_kerja']) }}">
                        <i class="mdi mdi-file-document-multiple me-1"></i>
                        Monitoring Lembar Kerja
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab === 'proses' ? 'active' : '' }}" 
                       href="{{ route('lembar-kerja.monitoring', ['tab' => 'proses']) }}">
                        <i class="mdi mdi-progress-clock me-1"></i>
                        Monitoring Proses
                    </a>
                </li>
            </ul>

            <!-- Filter Section -->
            <div class="row mb-4">
                <!-- Quick Date Filter -->
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-2">
                        <label class="form-label fw-medium mb-0">Filter Cepat:</label>
                        <div class="btn-group" role="group">
                            <a href="{{ route('lembar-kerja.monitoring', array_merge(request()->all(), ['filter_date'=>'today'])) }}" 
                               class="btn btn-outline-primary btn-sm {{ $filterDate === 'today' ? 'active' : '' }}">
                                Hari Ini
                            </a>
                            <a href="{{ route('lembar-kerja.monitoring', array_merge(request()->all(), ['filter_date'=>'3days'])) }}" 
                               class="btn btn-outline-primary btn-sm {{ $filterDate === '3days' ? 'active' : '' }}">
                                3 Hari
                            </a>
                            <a href="{{ route('lembar-kerja.monitoring', array_merge(request()->all(), ['filter_date'=>'7days'])) }}" 
                               class="btn btn-outline-primary btn-sm {{ $filterDate === '7days' ? 'active' : '' }}">
                                7 Hari
                            </a>
                            <a href="{{ route('lembar-kerja.monitoring', array_merge(request()->except('filter_date'))) }}" 
                               class="btn btn-outline-primary btn-sm {{ $filterDate === 'all' ? 'active' : '' }}">
                                Semua
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Search Form -->
                <div class="col-md-6">
                    <form action="{{ route('lembar-kerja.monitoring') }}" method="GET" class="d-flex gap-2">
                        <input type="hidden" name="tab" value="{{ $tab }}">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="mdi mdi-magnify text-muted"></i>
                            </span>
                            <input type="text" name="search" class="form-control border-start-0" 
                                   placeholder="Cari no pesanan, nama lembar kerja, atau klien..." 
                                   value="{{ $search }}">
                        </div>
                        <button type="submit" class="btn btn-primary px-3">
                            <i class="mdi mdi-magnify"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Stats Cards -->
            {{-- @if($tab === 'lembar_kerja')
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-progress-clock mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Dalam Proses</h6>
                                    <h4 class="mb-0">{{ $lembarKerja->where('status', 'proses')->count() }}</h4>
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
                                    <i class="mdi mdi-check-decagram mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Menunggu Persetujuan</h6>
                                    <h4 class="mb-0">{{ $lembarKerja->where('status', 'persetujuan')->count() }}</h4>
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
                                    <i class="mdi mdi-check-circle mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Selesai</h6>
                                    <h4 class="mb-0">{{ $lembarKerja->where('status', 'selesai')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-secondary text-white">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-pencil mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Draft</h6>
                                    <h4 class="mb-0">{{ $lembarKerja->where('status', 'draft')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif --}}

            <!-- Table -->
            <div class="table-responsive rounded border">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            @if($tab === 'lembar_kerja')
                                <th width="15%" class="border-0">Timeline</th>
                                <th width="15%" class="border-0">Pesanan</th>
                                <th width="25%" class="border-0">Lembar Kerja & Klien</th>
                                <th width="15%" class="border-0">Status</th>
                                <th width="15%" class="border-0">Progress</th>
                                <th width="15%" class="border-0">Timeline</th>
                            @else
                                <th width="15%" class="border-0">Target Selesai</th>
                                <th width="15%" class="border-0">Tanggal Pesanan</th>
                                <th width="25%" class="border-0">Proses & Lembar Kerja</th>
                                <th width="10%" class="border-0">Status</th>
                                <th width="20%" class="border-0">Progress</th>
                                <th width="15%" class="border-0">Timeline</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lembarKerja as $lk)
                        <tr class="border-bottom">
                            @if($tab === 'lembar_kerja')
                                <!-- Timeline -->
                                <td>
                                    <div class="small">
                                        <div class="fw-medium text-dark">Target: {{ $lk->tgl_target ? \Carbon\Carbon::parse($lk->tgl_target)->format('d M Y') : '-' }}</div>
                                        <div class="text-muted">Pesan: {{ $lk->tgl_pesanan ? \Carbon\Carbon::parse($lk->tgl_pesanan)->format('d M Y') : '-' }}</div>
                                    </div>
                                </td>

                                <!-- Pesanan -->
                                <td>
                                    <div class="fw-medium text-primary">{{ $lk->no_pesanan }}</div>
                                </td>

                                <!-- Lembar Kerja & Klien -->
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-3" 
                                             style="width: 40px; height: 40px;">
                                            <i class="mdi mdi-file-document text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium text-dark">{{ $lk->nama_lembar }}</div>
                                            <div class="text-muted small">
                                                <i class="mdi mdi-account-outline me-1"></i>
                                                {{ $lk->klien->nama }}
                                            </div>
                                        </div>
                                    </div>
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

                                <!-- Progress -->
                                <td>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-{{ match($lk->status) {
                                            'draft' => 'secondary',
                                            'proses' => 'info',
                                            'persetujuan' => 'warning',
                                            'selesai' => 'success',
                                            default => 'light'
                                        } }}" style="width: {{ match($lk->status) {
                                            'draft' => '25',
                                            'proses' => '50',
                                            'persetujuan' => '75',
                                            'selesai' => '100',
                                            default => '0'
                                        } }}%"></div>
                                    </div>
                                    <small class="text-muted mt-1 d-block">
                                        {{ match($lk->status) {
                                            'draft' => '25% - Draft',
                                            'proses' => '50% - Proses',
                                            'persetujuan' => '75% - Menunggu Persetujuan',
                                            'selesai' => '100% - Selesai',
                                            default => '0% - Belum dimulai'
                                        } }}
                                    </small>
                                </td>

                                <!-- Timeline Indicator -->
                                <td>
                                    @if($lk->tgl_target)
                                        @php
                                            $daysLeft = \Carbon\Carbon::parse($lk->tgl_target)->diffInDays(now(), false);
                                        @endphp
                                        @if($daysLeft < 0)
                                            <span class="badge bg-success">
                                                <i class="mdi mdi-check-circle-outline me-1"></i>
                                                {{ abs($daysLeft) }} hari lebih awal
                                            </span>
                                        @elseif($daysLeft == 0)
                                            <span class="badge bg-warning">
                                                <i class="mdi mdi-alert-circle-outline me-1"></i>
                                                Deadline hari ini
                                            </span>
                                        @elseif($daysLeft <= 3)
                                            <span class="badge bg-danger">
                                                <i class="mdi mdi-alert me-1"></i>
                                                Terlambat {{ $daysLeft }} hari
                                            </span>
                                        @else
                                            <span class="badge bg-info">
                                                <i class="mdi mdi-clock-outline me-1"></i>
                                                {{ $daysLeft }} hari lagi
                                            </span>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">Tidak ada target</span>
                                    @endif
                                </td>

                            @else
                                <!-- Monitoring Proses -->
                                <td>
                                    <div class="fw-medium text-dark">
                                        {{ $lk->tgl_target ? \Carbon\Carbon::parse($lk->tgl_target)->format('d M Y') : '-' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="text-muted">
                                        {{ $lk->tgl_pesanan ? \Carbon\Carbon::parse($lk->tgl_pesanan)->format('d M Y') : '-' }}
                                    </div>
                                </td>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning rounded-circle d-flex align-items-center justify-content-center me-3" 
                                             style="width: 40px; height: 40px;">
                                            <i class="mdi mdi-progress-wrench text-white"></i>
                                        </div>
                                        <div>
                                            <div class="fw-medium text-dark">{{ $lk->nama_lembar }}</div>
                                            <div class="text-muted small">No: {{ $lk->no_pesanan }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge bg-{{ $lk->status === 'selesai' ? 'success' : 'warning' }}">
                                        <i class="mdi mdi-{{ $lk->status === 'selesai' ? 'check-circle' : 'progress-clock' }} me-1"></i>
                                        {{ $lk->status === 'selesai' ? 'Selesai' : 'Proses' }}
                                    </span>
                                </td>

                                <td>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-{{ $lk->status === 'selesai' ? 'success' : 'warning' }}" 
                                             style="width: {{ $lk->status === 'selesai' ? '100' : '60' }}%"></div>
                                    </div>
                                    <small class="text-muted mt-1 d-block">
                                        {{ $lk->status === 'selesai' ? '100% - Selesai' : '60% - Dalam Pengerjaan' }}
                                    </small>
                                </td>

                                <td>
                                    @if($lk->tgl_target && $lk->status !== 'selesai')
                                        @php
                                            $daysLeft = \Carbon\Carbon::parse($lk->tgl_target)->diffInDays(now(), false);
                                        @endphp
                                        @if($daysLeft < 0)
                                            <span class="badge bg-danger">
                                                <i class="mdi mdi-alert me-1"></i>
                                                Terlambat {{ abs($daysLeft) }} hari
                                            </span>
                                        @elseif($daysLeft <= 2)
                                            <span class="badge bg-warning">
                                                <i class="mdi mdi-alert-circle-outline me-1"></i>
                                                {{ $daysLeft }} hari lagi
                                            </span>
                                        @else
                                            <span class="badge bg-info">
                                                <i class="mdi mdi-clock-outline me-1"></i>
                                                {{ $daysLeft }} hari
                                            </span>
                                        @endif
                                    @elseif($lk->status === 'selesai')
                                        <span class="badge bg-success">
                                            <i class="mdi mdi-check-circle-outline me-1"></i>
                                            Tepat Waktu
                                        </span>
                                    @else
                                        <span class="badge bg-secondary">Tidak ada target</span>
                                    @endif
                                </td>
                            @endif
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="empty-state">
                                    <i class="mdi mdi-monitor-off mdi-48px text-muted mb-3"></i>
                                    <h5 class="text-muted">Tidak ada data monitoring</h5>
                                    <p class="text-muted mb-0">Tidak ada lembar kerja yang sesuai dengan filter</p>
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
                    Menampilkan {{ $lembarKerja->firstItem() ?? 0 }} - {{ $lembarKerja->lastItem() ?? 0 }} dari {{ $lembarKerja->total() }} data
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

@push('styles')
<style>
.nav-tabs-custom .nav-link {
    border: none;
    border-bottom: 3px solid transparent;
    color: #6c757d;
    font-weight: 500;
    padding: 0.75rem 1rem;
}

.nav-tabs-custom .nav-link.active {
    border-bottom-color: #0d6efd;
    color: #0d6efd;
    background: transparent;
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

.progress {
    border-radius: 4px;
}

.empty-state {
    padding: 2rem 1rem;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

@media (max-width: 768px) {
    .nav-tabs-custom .nav-link {
        padding: 0.5rem 0.75rem;
        font-size: 0.875rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
    
    .btn-group .btn {
        font-size: 0.75rem;
        padding: 0.25rem 0.5rem;
    }
}
</style>
@endpush