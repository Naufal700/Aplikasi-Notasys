@extends('layouts.commonMaster')
@section('title','Dashboard Keuangan')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Header + Filter -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold mb-0">Dashboard Keuangan</h4>
    </div>

    <!-- Filter Periode Bulan -->
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
                ['title'=>'Total Tagihan','value'=>$totalTagihan,'icon'=>'bx bx-file','color'=>'primary'],
                ['title'=>'Total Penerimaan Kas','value'=>$totalPembayaran,'icon'=>'bx bx-wallet','color'=>'success'],
                ['title'=>'Penghapusan Piutang','value'=>$penghapusanPiutang,'icon'=>'bx bx-trash','color'=>'danger'],
                ['title'=>'Sisa Tagihan','value'=>$sisaTagihan,'icon'=>'bx bx-chart','color'=>'warning'],
            ];
        @endphp
        @foreach($cards as $card)
        <div class="col-md-3 col-12">
            <div class="card shadow-sm border-0 h-100 hover-shadow">
                <div class="card-body d-flex align-items-center justify-content-between">
                    <div>
                        <h6 class="text-muted mb-1">{{ $card['title'] }}</h6>
                        <h3 class="fw-bold mb-0">Rp {{ number_format($card['value'],0,',','.') }}</h3>
                    </div>
                    <div class="avatar bg-light-{{ $card['color'] }} rounded-circle p-3">
                        <i class="{{ $card['icon'] }} fs-3 text-{{ $card['color'] }}"></i>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Donut & Line Chart Side by Side Lebar Sama -->
    <div class="row g-3 mb-4">
        <div class="col-lg-6 col-12">
            <!-- Donut Chart -->
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">Proporsi Jenis Transaksi</h6>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center" style="min-height:350px;">
                    <div id="donutJenis" style="height: 100%; width: 100%; max-width:400px;"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-12">
            <!-- Line Chart Penerimaan Kas Mingguan -->
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">Penerimaan Kas Mingguan</h6>
                </div>
                <div class="card-body" style="min-height:350px;">
                    <div id="chartArusKas" style="height: 100%; width: 100%;"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Tagihan & Pembayaran -->
    <div class="row g-3">
        <div class="col-12">
            <!-- Tagihan Terbaru -->
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">5 Tagihan Terbaru</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Jatuh Tempo</th>
                                    <th>Total Tagihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tagihanTerbaru as $t)
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime($t->tanggal)) }}</td>
                                    <td>{{ $t->keterangan }}</td>
                                    <td>{{ $t->lembarKerja->klien->nama ?? '-' }}</td>
                                    <td>{{ date('d-m-Y', strtotime($t->jatuh_tempo)) }}</td>
                                    <td>Rp {{ number_format($t->total_tagihan,0,',','.') }}</td>
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

            <!-- Pembayaran Terbaru -->
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light">
                    <h6 class="mb-0 fw-bold">5 Pembayaran Terbaru</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Nominal Bayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pembayaranTerbaru as $p)
                                <tr>
                                    <td>{{ date('d-m-Y', strtotime($p->tanggal)) }}</td>
                                    <td>{{ $p->keterangan }}</td>
                                    <td>{{ $p->lembarKerja->klien->nama ?? '-' }}</td>
                                    <td>Rp {{ number_format($p->nominal_bayar,0,',','.') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted">Tidak ada data.</td>
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // Line Chart Penerimaan Kas Mingguan
var rupiahFormatter = new Intl.NumberFormat('id-ID', {
    style: 'currency',
    currency: 'IDR',
    minimumFractionDigits: 0
});

var optionsArea = {
    chart: { type: 'area', height: '100%', toolbar: { show: false } },
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
        gradient: { shadeIntensity: 1, opacityFrom: 0.5, opacityTo: 0.1, stops: [0, 90, 100] } 
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


    // Donut Chart 3 Jenis
    var optionsDonut = {
        chart: { type: 'donut', height: '100%' },
        series: [{{ $totalTagihan }}, {{ $totalPembayaran }}, {{ $penghapusanPiutang }}],
        labels: ['Tagihan','Penerimaan Kas','Penghapusan Piutang'],
        colors: ['#0d6efd','#198754','#dc3545'],
        legend: { position: 'bottom' },
        dataLabels: { enabled: false },
        tooltip: { y: { formatter: val => 'Rp ' + val.toLocaleString() } }
    };
    new ApexCharts(document.querySelector("#donutJenis"), optionsDonut).render();

});
</script>
@endpush
