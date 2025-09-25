@extends('layouts.commonMaster')

@section('title', 'Dashboard Klien')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Dashboard Klien</h4>
    </div>

    <!-- KPI Cards -->
    <div class="row g-3 mb-4">
        @php
            $kpi = [
                ['title'=>'Total Klien','value'=>$total,'icon'=>'bx bx-user','color'=>'primary'],
                ['title'=>'Pribadi','value'=>$pribadi,'icon'=>'bx bx-user-circle','color'=>'info'],
                ['title'=>'Bank/Leasing','value'=>$bankLeasing,'icon'=>'bx bx-bank','color'=>'success'],
                ['title'=>'Perusahaan','value'=>$perusahaan,'icon'=>'bx bx-building','color'=>'warning']
            ];
        @endphp
        @foreach($kpi as $card)
        <div class="col-md-3 col-6">
            <div class="card shadow-sm border-0 h-100 hover-shadow">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1">{{ $card['title'] }}</h6>
                        <h3 class="fw-bold mb-0">{{ $card['value'] }}</h3>
                    </div>
                    <div class="avatar bg-light-{{ $card['color'] }} rounded-circle p-3">
                        <i class="{{ $card['icon'] }} fs-3 text-{{ $card['color'] }}"></i>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Charts -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header">
                    <h6 class="mb-0 fw-bold">Proporsi Klien</h6>
                </div>
                <div class="card-body">
                    <div id="donutChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header">
                    <h6 class="mb-0 fw-bold">Pertumbuhan Bulanan</h6>
                </div>
                <div class="card-body">
                    <div id="barChart" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tables per tipe -->
    @php
        $klienGroups = [
            'Pribadi' => $pribadiData,
            'Bank/Leasing' => $bankLeasingData,
            'Perusahaan' => $perusahaanData
        ];
    @endphp

    @foreach($klienGroups as $groupName => $groupData)
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header">
            <h6 class="mb-0 fw-bold">{{ $groupName }}</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama</th>
                            <th>No Telepon</th>
                            <th>Email</th>
                            <th>Tanggal Dibuat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groupData as $item)
                        <tr>
                            <th>{{ $loop->iteration }}</th>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->no_telepon }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->created_at ? $item->created_at->format('d-m-Y') : '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach

</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    if (typeof ApexCharts !== "undefined") {

        // --- Donut Chart with total in center ---
        var donutOptions = {
            chart: { type: 'donut', height: 300 },
            series: [{{ $pribadi }}, {{ $bankLeasing }}, {{ $perusahaan }}],
            labels: ['Pribadi', 'Bank/Leasing', 'Perusahaan'],
            colors: ['#0d6efd', '#198754', '#ffc107'],
            legend: { position: 'bottom' },
            plotOptions: {
                pie: {
                    donut: {
                        size: '65%',
                        labels: {
                            show: true,
                            name: { show: true },
                            value: { show: true },
                            total: {
                                show: true,
                                label: 'Total',
                                formatter: () => {{ $total }}
                            }
                        }
                    },
                    expandOnClick: true
                }
            },
            dataLabels: { enabled: false },
            tooltip: { theme: 'light', y: { formatter: val => val } },
            responsive: [{ breakpoint: 576, options: { chart: { height: 220 }, legend: { position: 'bottom' } } }]
        };
        new ApexCharts(document.querySelector("#donutChart"), donutOptions).render();

        // --- Bar Chart Pertumbuhan Bulanan ---
        var barOptions = {
            chart: { type: 'bar', height: 300, toolbar: { show: false }, animations: { enabled: true } },
            series: [{ name: 'Klien Baru', data: @json($growthData ?? []) }],
            plotOptions: { bar: { borderRadius: 4, columnWidth: '50%' } },
            colors: ['#ffc107'],
            dataLabels: { enabled: false },
            xaxis: { categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'] },
            yaxis: { min: 0 },
            tooltip: { theme: 'light' },
            grid: { borderColor: '#f1f1f1' }
        };
        new ApexCharts(document.querySelector("#barChart"), barOptions).render();
    }

});
</script>
@endpush
