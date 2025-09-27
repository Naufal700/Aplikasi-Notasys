@extends('layouts.commonMaster')

@section('title', 'Dashboard Lembar Kerja')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Dashboard Lembar Kerja</h4>
    </div>
<form method="GET" class="row g-2 mb-4">
        <div class="col-md-2">
            <select name="month" class="form-select">
                @foreach($months as $num => $name)
                <option value="{{ $num }}" {{ $num == $selectedMonth ? 'selected' : '' }}>{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-50">Filter</button>
        </div>
    </form>
    <!-- KPI Cards -->
    <div class="row g-3 mb-4">
        @php
            $cards = [
                ['title'=>'Draft','value'=>$countDraft,'icon'=>'bx bx-file','color'=>'primary'],
                ['title'=>'Persetujuan','value'=>$countPersetujuan,'icon'=>'bx bx-check-circle','color'=>'warning'],
                ['title'=>'Proses','value'=>$countProses,'icon'=>'bx bx-loader-alt','color'=>'success'],
                ['title'=>'Selesai','value'=>$countSelesai,'icon'=>'bx bx-check','color'=>'danger']
            ];
        @endphp
        @foreach($cards as $card)
         <div class="col-md-3 col-12">
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

    <!-- Proporsi Status + Log Aktivitas -->
    <div class="row g-3 mb-4">
        <!-- Proporsi Status -->
        <div class="col-lg-6 col-md-12">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">Proporsi Status</h6>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <div id="donutChart" style="height: 300px; width: 100%;"></div>
                </div>
            </div>
        </div>

        <!-- Log Aktivitas -->
       <div class="col-lg-6 col-md-12">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light">
            <h6 class="mb-0 fw-bold">
                <i class="mdi mdi-history me-2"></i> Log Aktivitas Terbaru
            </h6>
        </div>
        <div class="card-body p-0" style="max-height: 330px; overflow-y: auto;">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light sticky-top">
                        <tr>
                            <th class="text-nowrap">Waktu</th>
                            <th>User</th>
                            <th>Aktivitas</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td class="text-nowrap">{{ $log->created_at->format('d-m-Y H:i:s') }}</td>
                            <td>{{ $log->user->name ?? '-' }}</td>
                            <td>{{ $log->aktivitas }}</td>
                            <td class="text-truncate" style="max-width: 200px;" title="{{ $log->detail }}">
                                {{ $log->detail }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">
                                Tidak ada log aktivitas.
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

    <!-- Tables per status -->
    @php
        $statusGroups = [
            'Persetujuan' => $persetujuan,
            'Proses' => $proses
        ];
    @endphp

    @foreach($statusGroups as $statusName => $groupData)
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-light">
            <h6 class="mb-0 fw-bold">{{ $statusName }}</h6>
        </div>
        <div class="card-body p-0">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle mb-0">
            <thead class="table-light sticky-top">
                <tr>
                    <th>#</th>
                    <th>No Pesanan</th>
                    <th>Nama</th>
                    <th>Layanan</th>
                    @if($statusName === 'Proses') <th>Sisa Tagihan</th> @endif
                    <th>Tanggal Buat</th>
                </tr>
            </thead>
            <tbody>
                @forelse($groupData as $item)
                <tr>
                    <th>{{ $loop->iteration }}</th>
                    <td>{{ $item->no_pesanan }}</td>
                    <td>{{ $item->klien->nama ?? '-' }}</td>
                    <td>{{ $item->layanan->nama_layanan ?? '-' }}</td>
                    @if($statusName === 'Proses')
                    <td>
                        <span class="badge bg-danger">
                            {{ number_format($item->sisa_tagihan,0,',','.') }}
                        </span>
                    </td>
                    @endif
                    <td>{{ $item->created_at->format('d-m-Y') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="@if($statusName === 'Proses') 6 @else 5 @endif" class="text-center text-muted">Tidak ada data.</td>
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
        // Donut Chart Proporsi Status
        var donutOptions = {
            chart: { type: 'donut', height: 300 },
            series: [{{ $countDraft }}, {{ $countPersetujuan }}, {{ $countProses }}, {{ $countSelesai }}],
            labels: ['Draft','Persetujuan','Proses','Selesai'],
            colors: ['#0d6efd','#ffc107','#198754','#dc3545'],
            legend: { position: 'bottom' },
            plotOptions: { pie: { donut: { size: '65%', labels: { show: true, total: { show: true, label: 'Total', formatter: () => {{ $countDraft+$countPersetujuan+$countProses+$countSelesai }} } } } } },
            dataLabels: { enabled: false },
            tooltip: { theme: 'light', y: { formatter: val => val } },
            responsive: [{ breakpoint: 576, options: { chart: { height: 220 }, legend: { position: 'bottom' } } }]
        };
        new ApexCharts(document.querySelector("#donutChart"), donutOptions).render();
    }
});
</script>
@endpush
