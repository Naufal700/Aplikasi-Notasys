@extends('layouts.commonMaster')

@section('title', 'Dashboard')

@section('layoutContent')
<link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}">

<div class="container-xxl flex-grow-1 container-p-y">

    <h4 class="fw-bold py-3 mb-4">Dashboard</h4>

    {{-- Row Stat Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3 col-6">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h6>Total Klien</h6>
                    <h3>120</h3>
                    <span class="text-white-50">Jumlah klien terdaftar</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h6>Proyek Aktif</h6>
                    <h3>45</h3>
                    <span class="text-white-50">Sedang berjalan</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h6>Form Order</h6>
                    <h3>78</h3>
                    <span class="text-white-50">Dalam proses</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h6>Pending Approval</h6>
                    <h3>5</h3>
                    <span class="text-white-50">Perlu ditinjau</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Row Charts --}}
    <div class="row g-3">
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    Pendapatan Bulanan
                </div>
                <div class="card-body">
                    <div id="chartPendapatan" style="height: 300px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    Proyek per Layanan
                </div>
                <div class="card-body">
                    <div id="chartProyek" style="height: 300px;"></div>
                </div>
            </div>
        </div>
    </div>

</div>

@push('scripts')
<script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function(){

    // Chart Pendapatan Bulanan (Area Chart)
    var optionsPendapatan = {
        chart: { type: 'area', height: 300, toolbar: { show: false } },
        series: [{ name: 'Pendapatan', data: [5000, 7000, 8000, 6000, 9000, 10000, 12000] }],
        xaxis: { categories: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul'] },
        colors: ['#0d6efd'],
        dataLabels: { enabled: false },
        stroke: { curve: 'smooth' }
    };
    var chartPendapatan = new ApexCharts(document.querySelector("#chartPendapatan"), optionsPendapatan);
    chartPendapatan.render();

    // Chart Proyek per Layanan (Bar Chart)
    var optionsProyek = {
        chart: { type: 'bar', height: 300, toolbar: { show: false } },
        series: [{ name: 'Proyek', data: [10, 20, 15, 5, 8] }],
        xaxis: { categories: ['PPAT','Notaris','Legalisasi','Waarmerking','Lainnya'] },
        colors: ['#198754'],
        dataLabels: { enabled: true }
    };
    var chartProyek = new ApexCharts(document.querySelector("#chartProyek"), optionsProyek);
    chartProyek.render();

});
</script>
@endpush
@endsection
