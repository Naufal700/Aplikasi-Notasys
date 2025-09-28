@extends('layouts.commonMaster')

@section('title', 'Dashboard Lembar Kerja')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header dengan Filter -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                {{-- <div class="flex-shrink-0">
                    <div class="avatar avatar-lg bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="bx bx-clipboard text-primary fs-4"></i>
                    </div>
                </div> --}}
                <div class="flex-grow-1">
                    <h4 class="fw-bold mb-1">Dashboard Lembar Kerja</h4>
                    <p class="text-muted mb-0">Monitor progress dan aktivitas pekerjaan</p>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <form method="GET" class="row g-2 justify-content-end">
                <div class="col-md-5">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-transparent border-end-0">
                            <i class="bx bx-calendar text-muted"></i>
                        </span>
                        <select name="month" class="form-select border-start-0 ps-0">
                            @foreach($months as $num => $name)
                            <option value="{{ $num }}" {{ $num == $selectedMonth ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="bx bx-filter me-1"></i>Filter
                    </button>
                </div>
                {{-- <div class="col-md-4">
                    <button type="button" class="btn btn-outline-secondary btn-sm w-100" onclick="exportReport()">
                        <i class="bx bx-download me-1"></i>Export
                    </button>
                </div> --}}
            </form>
        </div>
    </div>

    <!-- KPI Cards dengan Progress -->
    <div class="row g-3 mb-4">
        @php
            $totalItems = $countDraft + $countPersetujuan + $countProses + $countSelesai;
            $cards = [
                [
                    'title' => 'Draft',
                    'value' => $countDraft,
                    'icon' => 'bx bx-edit-alt',
                    'color' => 'secondary',
                    'trend' => 'up',
                    'description' => 'Menunggu input data'
                ],
                [
                    'title' => 'Persetujuan', 
                    'value' => $countPersetujuan,
                    'icon' => 'bx bx-time',
                    'color' => 'secondary',
                    'trend' => 'neutral',
                    'description' => 'Menunggu approval'
                ],
                [
                    'title' => 'Proses',
                    'value' => $countProses,
                    'icon' => 'bx bx-cog',
                    'color' => 'secondary',
                    'trend' => 'up',
                    'description' => 'Sedang dikerjakan'
                ],
                [
                    'title' => 'Selesai',
                    'value' => $countSelesai,
                    'icon' => 'bx bx-check-double',
                    'color' => 'secondary',
                    'trend' => 'up',
                    'description' => 'Telah diselesaikan'
                ]
            ];
        @endphp
        
        @foreach($cards as $card)
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card card-hover border-0 h-100">
                <div class="card-body position-relative">
                    <!-- Badge Status -->
                    <span class="badge bg-{{ $card['color'] }} bg-opacity-10 text-{{ $card['color'] }} position-absolute top-0 end-0 m-3">
                        {{ $card['title'] }}
                    </span>
                    
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            {{-- <h6 class="text-muted mb-2 small fw-semibold">{{ $card['description'] }}</h6> --}}
                            <h2 class="fw-bold mb-0">{{ number_format($card['value']) }}</h2>
                        </div>
                        {{-- <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-{{ $card['color'] }} bg-opacity-10 p-3">
                                <i class="{{ $card['icon'] }} fs-4 text-{{ $card['color'] }}"></i>
                            </span>
                        </div> --}}
                    </div>
                    
                    <!-- Progress dan Trend -->
                    {{-- <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Progress</span>
                        @if($card['trend'] == 'up')
                        <span class="badge bg-success bg-opacity-10 text-success">
                            <i class="bx bx-up-arrow-alt me-1"></i>+8%
                        </span>
                        @elseif($card['trend'] == 'down')
                        <span class="badge bg-danger bg-opacity-10 text-danger">
                            <i class="bx bx-down-arrow-alt me-1"></i>-3%
                        </span>
                        @else
                        <span class="badge bg-secondary bg-opacity-10 text-secondary">
                            <i class="bx bx-minus me-1"></i>0%
                        </span>
                        @endif
                    </div> --}}
                    
                    <!-- Progress Bar -->
                    {{-- <div class="progress mb-3" style="height: 6px;">
                        @php
                            $percentage = $totalItems > 0 ? ($card['value'] / $totalItems) * 100 : 0;
                        @endphp
                        <div class="progress-bar bg-{{ $card['color'] }}" 
                             role="progressbar" 
                             style="width: {{ $percentage }}%"
                             aria-valuenow="{{ $percentage }}" 
                             aria-valuemin="0" 
                             aria-valuemax="100">
                        </div>
                    </div> --}}
                    
                  
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Charts & Activity Section -->
    <div class="row g-3 mb-4">
        <!-- Donut Chart -->
        <div class="col-xl-5 col-lg-6 col-12">
            <div class="card border-0 h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center py-3">
                    <h6 class="mb-0 fw-bold">Distribusi Status</h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-horizontal-rounded"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#" onclick="refreshChart()"><i class="bx bx-refresh me-2"></i>Refresh</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bx bx-download me-2"></i>Export</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div id="donutChart" style="height: 320px;"></div>
                </div>
            </div>
        </div>

        <!-- Log Aktivitas -->
        <div class="col-xl-7 col-lg-6 col-12">
            <div class="card border-0 h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center py-3">
                    <h6 class="mb-0 fw-bold">Aktivitas Terkini</h6>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary rounded-pill me-2">{{ $logs->count() }}</span>
                        <button class="btn btn-sm btn-outline-secondary" onclick="loadMoreActivities()">
                            <i class="bx bx-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="activity-timeline" style="max-height: 340px; overflow-y: auto;">
                        @forelse($logs as $log)
                        <div class="activity-item position-relative ps-4 py-3 border-bottom border-light">
                            <!-- Timeline dot -->
                            {{-- <div class="position-absolute top-50 start-0 translate-middle-y">
                                <div class="avatar avatar-xs bg-primary rounded-circle">
                                    <i class="bx bx-time fs-6 text-white"></i>
                                </div>
                            </div> --}}
                            
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="mb-0 fw-semibold">{{ $log->aktivitas }}</h6>
                                <small class="text-muted">{{ $log->created_at->diffForHumans() }}</small>
                            </div>
                            
                            <p class="text-muted mb-1 small">{{ $log->detail }}</p>
                            
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs bg-light-primary rounded-circle me-2">
                                    <span class="avatar-initial small">{{ substr($log->user->name ?? 'S', 0, 1) }}</span>
                                </div>
                                <small class="text-muted">{{ $log->user->name ?? 'System' }}</small>
                                <span class="mx-2 text-muted">•</span>
                                <small class="text-muted">{{ $log->created_at->format('d M Y, H:i') }}</small>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-5">
                            <i class="bx bx-time display-4 text-muted mb-3"></i>
                            <h6 class="text-muted">Tidak ada aktivitas</h6>
                            <p class="text-muted small mb-0">Belum ada log aktivitas terbaru</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Work Items dengan Tabs -->
    <div class="card border-0">
        <div class="card-header bg-transparent border-0 p-0">
            <ul class="nav nav-tabs nav-tabs-alt mb-0" role="tablist">
                @php
                    $tabs = [
                        'persetujuan' => [
                            'name' => 'Persetujuan', 
                            'icon' => 'bx bx-time', 
                            'count' => $countPersetujuan,
                            'color' => 'warning'
                        ],
                        'proses' => [
                            'name' => 'Dalam Proses', 
                            'icon' => 'bx bx-cog', 
                            'count' => $countProses,
                            'color' => 'info'
                        ]
                    ];
                @endphp
                
                @foreach($tabs as $key => $tab)
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                            data-bs-toggle="tab" 
                            data-bs-target="#{{ $key }}-tab" 
                            type="button" 
                            role="tab">
                        <i class="{{ $tab['icon'] }} me-2"></i>
                        {{ $tab['name'] }}
                        <span class="badge bg-{{ $tab['color'] }} rounded-pill ms-2">{{ $tab['count'] }}</span>
                    </button>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="card-body p-0">
            <div class="tab-content">
                @php
                    $statusGroups = [
                        'persetujuan' => $persetujuan,
                        'proses' => $proses
                    ];
                @endphp

                @foreach($statusGroups as $key => $groupData)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $key }}-tab" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="border-0 ps-4">#</th>
                                    <th class="border-0">Pesanan</th>
                                    <th class="border-0">Klien</th>
                                    <th class="border-0">Layanan</th>
                                    @if($key === 'proses') 
                                    <th class="border-0 text-end">Sisa Tagihan</th>
                                    @endif
                                    <th class="border-0 text-end pe-4">Tanggal</th>
                                    {{-- <th class="border-0 text-center">Aksi</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($groupData as $item)
                                <tr class="cursor-pointer" onclick="viewDetail('{{ $item->id }}')">
                                    <td class="ps-4">
                                        <div class="fw-semibold text-muted">#{{ $loop->iteration }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-light-primary rounded-circle me-3">
                                                <span class="avatar-initial">#</span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ $item->no_pesanan }}</h6>
                                                <small class="text-muted">ID: {{ $item->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <h6 class="mb-0">{{ $item->klien->nama ?? '-' }}</h6>
                                        <small class="text-muted">Klien</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-white">
                                            {{ $item->layanan->nama_layanan ?? '-' }}
                                        </span>
                                    </td>
                                    @if($key === 'proses')
                                    <td class="text-end">
                                        <div class="fw-bold text-danger">
                                            Rp {{ number_format($item->sisa_tagihan, 0, ',', '.') }}
                                        </div>
                                        <small class="text-muted">Sisa</small>
                                    </td>
                                    @endif
                                    <td class="text-end pe-4">
                                        <div class="text-muted small">
                                            {{ $item->created_at->format('d M Y') }}
                                        </div>
                                        <div class="text-muted smaller">
                                            {{ $item->created_at->format('H:i') }}
                                        </div>
                                    </td>
                                    {{-- <td class="text-center">
                                        <div class="btn-group btn-group-sm">
                                            <button class="btn btn-outline-primary" onclick="event.stopPropagation(); viewDetail('{{ $item->id }}')">
                                                <i class="bx bx-show"></i>
                                            </button>
                                            <button class="btn btn-outline-success" onclick="event.stopPropagation(); updateStatus('{{ $item->id }}')">
                                                <i class="bx bx-edit"></i>
                                            </button>
                                        </div>
                                    </td> --}}
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="{{ $key === 'proses' ? 7 : 6 }}" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="bx bx-clipboard display-4 text-muted mb-3"></i>
                                            <h6 class="text-muted">Tidak ada data</h6>
                                            <p class="text-muted small mb-0">Belum ada lembar kerja {{ $tabs[$key]['name'] }}</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

<!-- Quick Action Button -->
<div class="position-fixed bottom-4 end-4 z-3">
    <div class="btn-group dropup">
        <button type="button" class="btn btn-primary rounded-circle shadow-lg p-3" data-bs-toggle="dropdown">
            <i class="bx bx-plus fs-4"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end p-2">
            <li><a class="dropdown-item rounded d-flex align-items-center py-2" href="#">
                <i class="bx bx-plus-circle me-2"></i>Tambah Lembar Kerja
            </a></li>
            <li><a class="dropdown-item rounded d-flex align-items-center py-2" href="#">
                <i class="bx bx-download me-2"></i>Export Laporan
            </a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item rounded d-flex align-items-center py-2" href="#">
                <i class="bx bx-refresh me-2"></i>Refresh Data
            </a></li>
        </ul>
    </div>
</div>
@endsection

@push('styles')
<style>
.card-hover {
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.card-hover:hover {
    transform: translateY(-5px);
    border-color: var(--bs-primary);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}

.cursor-pointer {
    cursor: pointer;
    transition: all 0.2s ease;
}

.cursor-pointer:hover {
    background-color: rgba(var(--bs-primary-rgb), 0.05);
    transform: translateX(4px);
}

.nav-tabs-alt .nav-link {
    border: none;
    border-bottom: 3px solid transparent;
    padding: 1rem 1.5rem;
    font-weight: 500;
    color: var(--bs-secondary);
    transition: all 0.3s ease;
}

.nav-tabs-alt .nav-link.active {
    border-bottom-color: var(--bs-primary);
    color: var(--bs-primary);
    background: transparent;
}

.activity-timeline {
    scrollbar-width: thin;
    scrollbar-color: var(--bs-light) transparent;
}

.activity-timeline::-webkit-scrollbar {
    width: 4px;
}

.activity-timeline::-webkit-scrollbar-track {
    background: transparent;
}

.activity-timeline::-webkit-scrollbar-thumb {
    background-color: var(--bs-light);
    border-radius: 2px;
}

.activity-item {
    border-left: 2px solid var(--bs-light);
}

.activity-item:last-child {
    border-bottom: none !important;
}

.avatar-initial {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.table > :not(caption) > * > * {
    padding: 1rem 0.75rem;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-header .dropdown {
        margin-top: 0.5rem;
    }
    
    .nav-tabs-alt .nav-link {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }
    
    .position-fixed {
        bottom: 1rem;
        right: 1rem;
    }
    
    .activity-item {
        padding-left: 1rem !important;
    }
}

@media (max-width: 576px) {
    .container-p-y {
        padding: 1rem 0.5rem !important;
    }
    
    .btn-group-sm .btn {
        padding: 0.25rem 0.5rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof ApexCharts !== "undefined") {

        // Donut Chart dengan animasi
        var donutOptions = {
            chart: {
                type: 'donut',
                height: 320,
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            series: [{{ $countDraft }}, {{ $countPersetujuan }}, {{ $countProses }}, {{ $countSelesai }}],
            labels: ['Draft', 'Persetujuan', 'Proses', 'Selesai'],
            colors: ['#6c757d', '#ffc107', '#0dcaf0', '#198754'],
            legend: {
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '13px',
                markers: {
                    width: 8,
                    height: 8,
                    radius: 6
                }
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '14px',
                                fontWeight: 600
                            },
                            value: {
                                show: true,
                                fontSize: '20px',
                                fontWeight: 700,
                                formatter: function (val) {
                                    return val
                                }
                            },
                            total: {
                                show: true,
                                label: 'Total',
                                fontSize: '14px',
                                formatter: function (w) {
                                    return {{ $totalItems }}
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
                theme: 'light',
                y: {
                    formatter: function(val) {
                        return val + ' item'
                    }
                }
            },
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        height: 280
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };
        
        var donutChart = new ApexCharts(document.querySelector("#donutChart"), donutOptions);
        donutChart.render();
    }

    // Add hover effects to table rows
    const tableRows = document.querySelectorAll('tbody tr.cursor-pointer');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(4px)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
});

// Fungsi utilitas
function viewDetail(id) {
    // Implementasi view detail
    console.log('View detail:', id);
    // window.location.href = `/lembar-kerja/${id}`;
}

function updateStatus(id) {
    // Implementasi update status
    console.log('Update status:', id);
}

function exportReport() {
    // Implementasi export report
    console.log('Exporting report...');
}

function refreshChart() {
    // Implementasi refresh chart
    console.log('Refreshing chart...');
    location.reload();
}

function loadMoreActivities() {
    // Implementasi load more activities
    console.log('Loading more activities...');
}
</script>
@endpush