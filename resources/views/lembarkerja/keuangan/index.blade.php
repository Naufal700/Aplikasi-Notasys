@extends('layouts.commonMaster')
@section('title','Keuangan — Semua Tagihan & Pembayaran')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

   <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">
                <i class="mdi mdi-cash-multiple me-2"></i> Daftar Tagihan & Pembayaran
            </h5>
        </div>

        <div class="card-body">

            {{-- Filter & Export --}}
            <div class="row mb-3">
                <div class="col-md-12 d-flex justify-content-start mb-2">
                    <button id="exportExcel" class="btn btn-success me-2" title="Export Excel">
                        <i class="mdi mdi-file-excel"></i>
                    </button>
                    <button id="exportPdf" class="btn btn-danger" title="Export PDF">
                        <i class="mdi mdi-file-pdf-box fs-5"></i>
                    </button>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3 mb-2">
                    <label>Tanggal Mulai</label>
                    <input type="date" id="filterStart" class="form-control">
                </div>
                <div class="col-md-3 mb-2">
                    <label>Tanggal Akhir</label>
                    <input type="date" id="filterEnd" class="form-control">
                </div>
                <div class="col-md-3 mb-2">
                    <label>Jenis</label>
                    <select id="filterJenis" class="form-select">
                        <option value="">-- Semua --</option>
                        <option value="Tagihan">Tagihan</option>
                        <option value="Bayar">Bayar</option>
                    </select>
                </div>
                <div class="col-md-3 mb-2 d-flex align-items-end">
                    <input type="text" id="searchKeyword" class="form-control me-2" placeholder="Search...">
                    <button id="btnFilter" class="btn btn-primary me-2" title="Filter">
                        <i class="mdi mdi-filter-variant"></i>
                    </button>
                    <button id="btnReset" class="btn btn-secondary" title="Reset">
                        <i class="mdi mdi-refresh"></i>
                    </button>
                </div>
            </div>

            {{-- Table --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered table-striped" id="keuanganTable">
                    <thead class="table-primary">
                        <tr class="text-nowrap">
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Pelanggan</th>
                            <th>No Pesanan</th>
                            <th>Jenis</th>
                            <th>Total</th>
                            <th>Jatuh Tempo</th>
                            <th>Metode Pembayaran</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="keuanganBody">
                        @php $no=1; @endphp
                        @foreach($tagihan as $t)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ \Carbon\Carbon::parse($t->tanggal)->format('d-m-Y') }}</td>
                            <td>{{ $t->lembarKerja->klien->nama ?? '-' }}</td>
                            <td>{{ $t->lembarKerja->no_pesanan ?? '-' }}</td>
                            <td>{{ $t->kategori->nama_kategori ?? '-' }}</td>
                            <td>{{ number_format($t->total_tagihan,0,',','.') }}</td>
                            <td>{{ \Carbon\Carbon::parse($t->jatuh_tempo)->format('d-m-Y') }}</td>
                            <td>{{ $t->metode_pembayaran }}</td>
                            <td>{{ $t->keterangan ?? '-' }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary btn-cetak" 
                                        data-url="{{ route('tagihan.print', $t->id) }}"
                                        title="Cetak">
                                    <i class="mdi mdi-printer"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('keuanganTable');
    const tbody = document.getElementById('keuanganBody');
    const rows = Array.from(tbody.rows);

    // Filter
    function filterTable() {
        const start = document.getElementById('filterStart').value;
        const end = document.getElementById('filterEnd').value;
        const jenis = document.getElementById('filterJenis').value.toLowerCase();
        const keyword = document.getElementById('searchKeyword').value.toLowerCase();

        rows.forEach(row => {
            const tanggal = moment(row.cells[1].innerText,'DD-MM-YYYY');
            const rowJenis = row.cells[4].innerText.toLowerCase();
            const rowText = row.innerText.toLowerCase();
            let show = true;

            if(start && tanggal.isBefore(moment(start))) show = false;
            if(end && tanggal.isAfter(moment(end))) show = false;
            if(jenis && rowJenis !== jenis) show = false;
            if(keyword && !rowText.includes(keyword)) show = false;

            row.style.display = show ? '' : 'none';
        });
    }

    document.getElementById('btnFilter').addEventListener('click', filterTable);
    document.getElementById('filterStart').addEventListener('change', filterTable);
    document.getElementById('filterEnd').addEventListener('change', filterTable);
    document.getElementById('filterJenis').addEventListener('change', filterTable);
    document.getElementById('searchKeyword').addEventListener('input', filterTable);

    document.getElementById('btnReset').addEventListener('click', () => {
        document.getElementById('filterStart').value = '';
        document.getElementById('filterEnd').value = '';
        document.getElementById('filterJenis').value = '';
        document.getElementById('searchKeyword').value = '';
        rows.forEach(row => row.style.display = '');
    });

    // Export Excel
    document.getElementById('exportExcel').addEventListener('click', () => {
        const wb = XLSX.utils.table_to_book(table, {sheet:"Tagihan"});
        XLSX.writeFile(wb, 'tagihan.xlsx');
    });

    // Export PDF
    document.getElementById('exportPdf').addEventListener('click', () => {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        doc.html(table, {
            callback: function (doc) {
                doc.save('tagihan.pdf');
            },
            x: 10,
            y: 10,
            width: 180
        });
    });

    // Cetak Tagihan / Struk
    document.querySelectorAll('.btn-cetak').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.dataset.url; // ambil URL dari Blade
            window.open(url, '_blank'); // buka di tab baru
        });
    });
});
</script>
@endpush
