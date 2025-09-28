@extends('layouts.commonMaster')

@section('title', 'Dashboard Klien')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header dengan Filter -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
            {{-- <div class="flex-shrink-0">
                <div class="avatar avatar-lg bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                    <i class="bx bx-group text-primary fs-4"></i>
                </div>
            </div> --}}
            <div class="flex-grow-1">
                <h4 class="fw-bold mb-1">Dashboard Klien</h4>
                <p class="text-muted mb-0">Analisis dan monitoring data klien</p>
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
            </form>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="row g-3 mb-4">
        @php
            $kpi = [
                ['title'=>'Total Klien','value'=>$total,'icon'=>'bx bx-user','color'=>'primary','trend'=>'up'],
                ['title'=>'Pribadi','value'=>$pribadi,'icon'=>'bx bx-user-circle','color'=>'info','trend'=>'neutral'],
                ['title'=>'Bank/Leasing','value'=>$bankLeasing,'icon'=>'bx bx-bank','color'=>'success','trend'=>'up'],
                ['title'=>'Perusahaan','value'=>$perusahaan,'icon'=>'bx bx-building','color'=>'warning','trend'=>'down']
            ];
        @endphp
        
        @foreach($kpi as $card)
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card card-hover border-0 h-100">
                <div class="card-body position-relative">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-2 small fw-semibold text-uppercase">{{ $card['title'] }}</h6>
                            <h2 class="fw-bold mb-0">{{ number_format($card['value']) }}</h2>
                        </div>
                        <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-{{ $card['color'] }} bg-opacity-10 p-3">
                                <i class="{{ $card['icon'] }} fs-4 text-{{ $card['color'] }}"></i>
                            </span>
                        </div>
                    </div>
                    
                    <!-- Trend Indicator -->
                    {{-- <div class="d-flex align-items-center">
                        @if($card['trend'] == 'up')
                        <span class="badge bg-success bg-opacity-10 text-success me-2">
                            <i class="bx bx-up-arrow-alt me-1"></i>+12%
                        </span>
                        @elseif($card['trend'] == 'down')
                        <span class="badge bg-danger bg-opacity-10 text-danger me-2">
                            <i class="bx bx-down-arrow-alt me-1"></i>-5%
                        </span>
                        @else
                        <span class="badge bg-secondary bg-opacity-10 text-secondary me-2">
                            <i class="bx bx-minus me-1"></i>0%
                        </span>
                        @endif
                        <span class="text-muted small">vs bulan lalu</span>
                    </div>
                     --}}
                    <!-- Progress Bar -->
                    {{-- <div class="progress mt-3" style="height: 4px;">
                        @php
                            $percentage = $total > 0 ? ($card['value'] / $total) * 100 : 0;
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

    <!-- Charts Section -->
    <div class="row g-3 mb-4">
        <!-- Donut Chart -->
        <div class="col-xl-6 col-12">
            <div class="card border-0 h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center py-3">
                    <h6 class="mb-0 fw-bold">Distribusi Klien</h6>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-horizontal-rounded"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Export</a></li>
                            <li><a class="dropdown-item" href="#">Refresh</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body pt-0">
                    <div id="donutChart" style="height: 320px;"></div>
                </div>
            </div>
        </div>

        <!-- Bar Chart -->
        <div class="col-xl-6 col-12">
            <div class="card border-0 h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center py-3">
                    <h6 class="mb-0 fw-bold">Pertumbuhan Bulanan</h6>
                    {{-- <div class="btn-group btn-group-sm" role="group">
                        <button type="button" class="btn btn-outline-secondary active">Bulanan</button>
                        <button type="button" class="btn btn-outline-secondary">Tahunan</button>
                    </div> --}}
                </div>
                <div class="card-body pt-0">
                    <div id="barChart" style="height: 320px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Client Tables dengan Tabs -->
    <div class="card border-0">
        <div class="card-header bg-transparent border-0 p-0">
            <ul class="nav nav-tabs nav-tabs-alt mb-0" role="tablist">
                @php
                    $tabs = [
                        'pribadi' => ['name' => 'Pribadi', 'icon' => 'bx bx-user-circle', 'count' => $pribadi],
                        'bank' => ['name' => 'Bank/Leasing', 'icon' => 'bx bx-bank', 'count' => $bankLeasing],
                        'perusahaan' => ['name' => 'Perusahaan', 'icon' => 'bx bx-building', 'count' => $perusahaan]
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
                        <span class="badge bg-primary rounded-pill ms-2">{{ $tab['count'] }}</span>
                    </button>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="card-body p-0">
            <div class="tab-content">
                @php
                    $klienGroups = [
                        'pribadi' => $pribadiData,
                        'bank' => $bankLeasingData,
                        'perusahaan' => $perusahaanData
                    ];
                @endphp

                @foreach($klienGroups as $key => $groupData)
                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="{{ $key }}-tab" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0 ps-4">#</th>
                                    <th class="border-0">Klien</th>
                                    <th class="border-0">Kontak</th>
                                    {{-- <th class="border-0">Status</th> --}}
                                    <th class="border-0 text-end pe-4">Bergabung</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($groupData as $item)
                                <tr class="cursor-pointer" onclick="window.location='#'">
                                    <td class="ps-4">
                                        <div class="fw-semibold text-muted">#{{ $loop->iteration }}</div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-light-primary rounded-circle me-3">
                                                <span class="avatar-initial">{{ substr($item->nama, 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0 fw-semibold">{{ $item->nama }}</h6>
                                                <small class="text-muted">ID: {{ $item->id ?? 'N/A' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted">
                                            <div class="d-flex align-items-center mb-1">
                                                <i class="bx bx-phone me-2"></i>
                                                <small>{{ $item->no_telepon ?? '-' }}</small>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <i class="bx bx-envelope me-2"></i>
                                                <small>{{ $item->email ?? '-' }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    {{-- <td>
                                        <span class="badge bg-success bg-opacity-10 text-success">
                                            <i class="bx bx-check-circle me-1"></i>Aktif
                                        </span>
                                    </td> --}}
                                    <td class="text-end pe-4">
                                        <div class="text-muted small">
                                            {{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}
                                        </div>
                                        <div class="text-muted smaller">
                                            {{ $item->created_at ? $item->created_at->format('H:i') : '' }}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="bx bx-user-x display-4 text-muted mb-3"></i>
                                            <h6 class="text-muted">Tidak ada data klien</h6>
                                            <p class="text-muted small mb-0">Belum ada klien {{ $tabs[$key]['name'] }} terdaftar</p>
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

<!-- Quick Action Buttons (Floating) -->
<div class="position-fixed bottom-4 end-4 z-3">
    <div class="btn-group dropup">
        <button type="button" class="btn btn-primary rounded-circle shadow-lg p-3" data-bs-toggle="dropdown">
            <i class="bx bx-plus fs-4"></i>
        </button>
        <ul class="dropdown-menu dropdown-menu-end p-2">
            <li><a class="dropdown-item rounded d-flex align-items-center py-2" href="#">
                <i class="bx bx-user-plus me-2"></i>Tambah Klien
            </a></li>
            <li><a class="dropdown-item rounded d-flex align-items-center py-2" href="#">
                <i class="bx bx-download me-2"></i>Export Data
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
}

.cursor-pointer:hover {
    background-color: rgba(var(--bs-primary-rgb), 0.05);
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

.avatar-initial {
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.table > :not(caption) > * > * {
    padding: 1rem 0.75rem;
}

.progress {
    background-color: var(--bs-light);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .card-header .btn-group {
        margin-top: 1rem;
        width: 100%;
    }
    
    .nav-tabs-alt .nav-link {
        padding: 0.75rem 1rem;
        font-size: 0.875rem;
    }
    
    .position-fixed {
        bottom: 1rem;
        right: 1rem;
    }
}

@media (max-width: 576px) {
    .container-p-y {
        padding: 1rem 0.5rem !important;
    }
    
    .card-body {
        padding: 1rem !important;
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
            series: [{{ $pribadi }}, {{ $bankLeasing }}, {{ $perusahaan }}],
            labels: ['Pribadi', 'Bank/Leasing', 'Perusahaan'],
            colors: ['#0d6efd', '#198754', '#ffc107'],
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
                        size: '70%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '14px',
                                fontWeight: 600,
                                color: undefined
                            },
                            value: {
                                show: true,
                                fontSize: '20px',
                                fontWeight: 700,
                                color: '#697a8d'
                            },
                            total: {
                                show: true,
                                label: 'Total Klien',
                                color: '#697a8d',
                                fontSize: '14px',
                                formatter: function (w) {
                                    return {{ $total }}
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
                        return val + ' klien'
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

        // Bar Chart dengan gradient
        var barOptions = {
            chart: {
                type: 'bar',
                height: 320,
                toolbar: {
                    show: false
                },
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800
                }
            },
            series: [{
                name: 'Klien Baru',
                data: @json($growthData ?? array_fill(0, 12, 0))
            }],
            plotOptions: {
                bar: {
                    borderRadius: 6,
                    columnWidth: '55%',
                    dataLabels: {
                        position: 'top'
                    }
                }
            },
            colors: ['#0d6efd'],
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.5,
                    gradientToColors: ['#0d6efd'],
                    inverseColors: false,
                    opacityFrom: 0.8,
                    opacityTo: 0.2,
                    stops: [0, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            xaxis: {
                categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false
                }
            },
            yaxis: {
                min: 0,
                tickAmount: 5
            },
            grid: {
                borderColor: '#f1f1f1',
                strokeDashArray: 4,
                padding: {
                    top: 0,
                    right: 0,
                    bottom: 0,
                    left: 0
                }
            },
            tooltip: {
                theme: 'light'
            }
        };
        
        var barChart = new ApexCharts(document.querySelector("#barChart"), barOptions);
        barChart.render();
    }

    // Add hover effects to table rows
    const tableRows = document.querySelectorAll('tbody tr.cursor-pointer');
    tableRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateX(4px)';
            this.style.transition = 'transform 0.2s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateX(0)';
        });
    });
});
</script>
@endpush