@extends('layouts.commonMaster')
@section('title','Dashboard Keuangan')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header dengan Filter Modern -->
    <div class="row align-items-center mb-4">
        <div class="col-md-6">
            <div class="d-flex align-items-center">
                {{-- <div class="flex-shrink-0">
                    <div class="avatar avatar-lg bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                        <i class="bx bx-wallet text-primary fs-4"></i>
                    </div>
                </div> --}}
                <div class="flex-grow-1">
                    <h4 class="fw-bold mb-1">Dashboard Keuangan</h4>
                    <p class="text-muted mb-0">Monitor arus kas dan performa keuangan</p>
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

    <!-- KPI Cards dengan Desain Modern -->
    <div class="row g-3 mb-4">
        @php
            $cards = [
                [
                    'title'=>'Total Tagihan',
                    'value'=>$totalTagihan,
                    'icon'=>'bx bx-file',
                    'color'=>'primary',
                    'trend'=>'up',
                    'description'=>'Tagihan bulan ini'
                ],
                [
                    'title'=>'Total Penerimaan Kas',
                    'value'=>$totalPembayaran,
                    'icon'=>'bx bx-wallet',
                    'color'=>'success', 
                    'trend'=>'up',
                    'description'=>'Kas masuk bulan ini'
                ],
                [
                    'title'=>'Penghapusan Piutang',
                    'value'=>$penghapusanPiutang,
                    'icon'=>'bx bx-trash',
                    'color'=>'danger',
                    'trend'=>'neutral',
                    'description'=>'Piutang dihapus'
                ],
                [
                    'title'=>'Sisa Tagihan',
                    'value'=>$sisaTagihan,
                    'icon'=>'bx bx-chart',
                    'color'=>'warning',
                    'trend'=>'down',
                    'description'=>'Belum dibayar'
                ],
            ];
        @endphp
        
        @foreach($cards as $card)
        <div class="col-xl-3 col-md-6 col-12">
            <div class="card card-hover border-0 h-100">
                <div class="card-body position-relative">
                    <!-- Badge Status -->
                    {{-- <span class="badge bg-{{ $card['color'] }} bg-opacity-10 text-{{ $card['color'] }} position-absolute top-0 end-0 m-3">
                        {{ $card['title'] }}
                    </span>
                     --}}
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-2 small fw-semibold">{{ $card['description'] }}</h6>
                            <h2 class="fw-bold mb-0">Rp {{ number_format($card['value'],0,',','.') }}</h2>
                        </div>
                        {{-- <div class="avatar flex-shrink-0">
                            <span class="avatar-initial rounded bg-{{ $card['color'] }} bg-opacity-10 p-3">
                                <i class="{{ $card['icon'] }} fs-4 text-{{ $card['color'] }}"></i>
                            </span>
                        </div> --}}
                    </div>
                    
                    <!-- Progress dan Trend -->
                    {{-- <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="text-muted small">Trend</span>
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
                            $maxValue = max(array_column($cards, 'value'));
                            $percentage = $maxValue > 0 ? ($card['value'] / $maxValue) * 100 : 0;
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

    <!-- Charts Section dengan Desain Modern -->
    <div class="row g-3 mb-4">
        <!-- Donut Chart -->
        <div class="col-lg-6 col-12">
            <div class="card border-0 h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center py-3">
                    <h6 class="mb-0 fw-bold">Proporsi Jenis Transaksi</h6>
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
                    <div id="donutJenis" style="height: 350px;"></div>
                </div>
            </div>
        </div>

        <!-- Line Chart -->
        <div class="col-lg-6 col-12">
            <div class="card border-0 h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center py-3">
                    <h6 class="mb-0 fw-bold">Penerimaan Kas Mingguan</h6>
                    {{-- <div class="btn-group btn-group-sm">
                        <button type="button" class="btn btn-outline-secondary active">Mingguan</button>
                        <button type="button" class="btn btn-outline-secondary">Bulanan</button>
                    </div> --}}
                </div>
                <div class="card-body pt-0">
                    <div id="chartArusKas" style="height: 350px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel dengan Tabs Modern -->
    <div class="card border-0">
        <div class="card-header bg-transparent border-0 p-0">
            <ul class="nav nav-tabs nav-tabs-alt mb-0" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tagihan-tab" type="button" role="tab">
                        <i class="bx bx-file me-2"></i>
                        Tagihan Terbaru
                        <span class="badge bg-primary rounded-pill ms-2">{{ $tagihanTerbaru->count() }}</span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#pembayaran-tab" type="button" role="tab">
                        <i class="bx bx-wallet me-2"></i>
                        Pembayaran Terbaru
                        <span class="badge bg-success rounded-pill ms-2">{{ $pembayaranTerbaru->count() }}</span>
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-0">
            <div class="tab-content">
                <!-- Tab Tagihan -->
                <div class="tab-pane fade show active" id="tagihan-tab" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="border-0 ps-4">#</th>
                                    <th class="border-0">Tanggal</th>
                                    <th class="border-0">Keterangan</th>
                                    <th class="border-0">Nama Pelanggan</th>
                                    <th class="border-0">Jatuh Tempo</th>
                                    <th class="border-0 text-end pe-4">Total Tagihan</th>
                                    <th class="border-0 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tagihanTerbaru as $t)
                                <tr class="cursor-pointer" onclick="viewTagihanDetail('{{ $t->id }}')">
                                    <td class="ps-4">
                                        <div class="fw-semibold text-muted">#{{ $loop->iteration }}</div>
                                    </td>
                                    <td>
                                        <div class="text-muted small">{{ date('d M Y', strtotime($t->tanggal)) }}</div>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 fw-semibold">{{ $t->keterangan }}</h6>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-light-primary rounded-circle me-3">
                                                <span class="avatar-initial">{{ substr($t->lembarKerja->klien->nama ?? 'C', 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $t->lembarKerja->klien->nama ?? '-' }}</h6>
                                                <small class="text-muted">Klien</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $isOverdue = strtotime($t->jatuh_tempo) < strtotime('today');
                                        @endphp
                                        <span class="badge {{ $isOverdue ? 'bg-danger' : 'bg-success' }} bg-opacity-10 text-{{ $isOverdue ? 'danger' : 'white' }}">
                                            {{ date('d M Y', strtotime($t->jatuh_tempo)) }}
                                        </span>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="fw-bold text-primary">
                                            Rp {{ number_format($t->total_tagihan,0,',','.') }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-warning bg-opacity-10 text-white">
                                            Belum Lunas
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="bx bx-file display-4 text-muted mb-3"></i>
                                            <h6 class="text-muted">Tidak ada data tagihan</h6>
                                            <p class="text-muted small mb-0">Belum ada tagihan terbaru</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Tab Pembayaran -->
                <div class="tab-pane fade" id="pembayaran-tab" role="tabpanel">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="border-0 ps-4">#</th>
                                    <th class="border-0">Tanggal</th>
                                    <th class="border-0">Keterangan</th>
                                    <th class="border-0">Nama Pelanggan</th>
                                    <th class="border-0 text-end pe-4">Nominal Bayar</th>
                                    <th class="border-0 text-center">Metode</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pembayaranTerbaru as $p)
                                <tr class="cursor-pointer" onclick="viewPembayaranDetail('{{ $p->id }}')">
                                    <td class="ps-4">
                                        <div class="fw-semibold text-muted">#{{ $loop->iteration }}</div>
                                    </td>
                                    <td>
                                        <div class="text-muted small">{{ date('d M Y', strtotime($p->tanggal)) }}</div>
                                    </td>
                                    <td>
                                        <h6 class="mb-0 fw-semibold">{{ $p->keterangan }}</h6>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar avatar-sm bg-light-success rounded-circle me-3">
                                                <span class="avatar-initial">{{ substr($p->lembarKerja->klien->nama ?? 'C', 0, 1) }}</span>
                                            </div>
                                            <div>
                                                <h6 class="mb-0">{{ $p->lembarKerja->klien->nama ?? '-' }}</h6>
                                                <small class="text-muted">Klien</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="fw-bold text-success">
                                            Rp {{ number_format($p->nominal_bayar,0,',','.') }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info bg-opacity-10 text-info">
                                            Transfer
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5">
                                        <div class="py-4">
                                            <i class="bx bx-wallet display-4 text-muted mb-3"></i>
                                            <h6 class="text-muted">Tidak ada data pembayaran</h6>
                                            <p class="text-muted small mb-0">Belum ada pembayaran terbaru</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
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
                <i class="bx bx-plus-circle me-2"></i>Tambah Tagihan
            </a></li>
            <li><a class="dropdown-item rounded d-flex align-items-center py-2" href="#">
                <i class="bx bx-credit-card me-2"></i>Input Pembayaran
            </a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item rounded d-flex align-items-center py-2" href="#">
                <i class="bx bx-download me-2"></i>Export Laporan
            </a></li>
        </ul>
    </div>
</div>
@endsection

@push('styles')
<style>
:root {
    --card-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    --card-hover: 0 8px 30px rgba(0, 0, 0, 0.12);
}

.card {
    border: none;
    border-radius: 16px;
    box-shadow: var(--card-shadow);
    transition: all 0.3s ease;
}

.card-hover {
    transition: all 0.3s ease;
    border: 1px solid transparent;
}

.card-hover:hover {
    transform: translateY(-5px);
    border-color: var(--bs-primary);
    box-shadow: var(--card-hover);
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
    // Line Chart Penerimaan Kas Mingguan
    var rupiahFormatter = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    });

    var optionsArea = {
        chart: { 
            type: 'area', 
            height: '100%', 
            toolbar: { show: false },
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800
            }
        },
        series: [
            { name: 'Penerimaan Kas', data: @json(array_column($chartData,'masuk')) }
        ],
        xaxis: { 
            categories: @json(array_column($chartData,'minggu')),
            labels: { style: { colors: '#6e6b7b', fontSize: '12px' } }
        },
        stroke: { curve: 'smooth', width: 3 },
        fill: { 
            type: 'gradient', 
            gradient: { 
                shadeIntensity: 1, 
                opacityFrom: 0.6, 
                opacityTo: 0.1, 
                stops: [0, 90, 100] 
            } 
        },
        colors: ['#28a745'],
        dataLabels: { enabled: false },
        tooltip: { 
            y: { 
                formatter: val => rupiahFormatter.format(val) 
            },
            theme: 'light',
            style: { fontSize: '13px', fontFamily: 'Inter, sans-serif' }
        },
        yaxis: {
            labels: {
                formatter: val => rupiahFormatter.format(val),
                style: { colors: '#6e6b7b', fontSize: '12px' }
            }
        },
        grid: { borderColor: '#e7e7e7', strokeDashArray: 5 }
    };

    new ApexCharts(document.querySelector("#chartArusKas"), optionsArea).render();

    // Donut Chart dengan animasi
    var optionsDonut = {
        chart: { 
            type: 'donut', 
            height: '100%',
            animations: {
                enabled: true,
                easing: 'easeinout',
                speed: 800
            }
        },
        series: [{{ $totalTagihan }}, {{ $totalPembayaran }}, {{ $penghapusanPiutang }}],
        labels: ['Tagihan','Penerimaan Kas','Penghapusan Piutang'],
        colors: ['#0d6efd','#198754','#dc3545'],
        legend: { 
            position: 'bottom',
            horizontalAlign: 'center'
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
                                return 'Rp ' + val.toLocaleString()
                            }
                        },
                        total: {
                            show: true,
                            label: 'Total',
                            fontSize: '14px',
                            formatter: function (w) {
                                return 'Rp ' + ({{ $totalTagihan }} + {{ $totalPembayaran }} + {{ $penghapusanPiutang }}).toLocaleString()
                            }
                        }
                    }
                }
            }
        },
        dataLabels: { enabled: false },
        tooltip: { 
            y: { 
                formatter: val => 'Rp ' + val.toLocaleString() 
            }
        }
    };
    new ApexCharts(document.querySelector("#donutJenis"), optionsDonut).render();

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
function viewTagihanDetail(id) {
    console.log('View tagihan detail:', id);
    // window.location.href = `/tagihan/${id}`;
}

function viewPembayaranDetail(id) {
    console.log('View pembayaran detail:', id);
    // window.location.href = `/pembayaran/${id}`;
}

function exportReport() {
    console.log('Exporting report...');
}

function refreshChart() {
    console.log('Refreshing chart...');
    location.reload();
}
</script>
@endpush