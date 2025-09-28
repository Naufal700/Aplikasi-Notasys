@extends('layouts.commonMaster')
@section('title','Keuangan — Semua Tagihan & Pembayaran')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

   <div class="card">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center py-3">
            <div>
                <h5 class="mb-1"><i class="mdi mdi-cash-multiple me-2"></i>Daftar Tagihan & Pembayaran</h5>
                <small class="opacity-75">Kelola semua transaksi keuangan</small>
            </div>
            <div class="text-white">
                <span class="badge bg-light text-dark">
                    <i class="mdi mdi-counter me-1"></i>
                    Total: {{ $tagihan->count() }}
                </span>
            </div>
        </div>

        <div class="card-body">
            <!-- Export & Filter Section -->
            <div class="row mb-4">
                <!-- Export Buttons -->
                <div class="col-md-6">
                    <div class="d-flex align-items-center gap-2">
                        <label class="form-label fw-medium mb-0">Export Data:</label>
                        <button id="exportExcel" class="btn btn-success btn-sm" title="Export Excel">
                            <i class="mdi mdi-file-excel me-1"></i> Excel
                        </button>
                        <button id="exportPdf" class="btn btn-danger btn-sm" title="Export PDF">
                            <i class="mdi mdi-file-pdf-box me-1"></i> PDF
                        </button>
                    </div>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="filter-section bg-light rounded p-4 mb-4">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-medium">Tanggal Mulai</label>
                        <input type="date" id="filterStart" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-medium">Tanggal Akhir</label>
                        <input type="date" id="filterEnd" class="form-control">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-medium">Jenis</label>
                        <select id="filterJenis" class="form-select">
                            <option value="">Semua Jenis</option>
                            <option value="Tagihan">Tagihan</option>
                            <option value="Bayar">Pembayaran</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="mdi mdi-magnify text-muted"></i>
                            </span>
                            <input type="text" id="searchKeyword" class="form-control border-start-0" 
                                   placeholder="Cari pelanggan, no pesanan, atau keterangan...">
                        </div>
                        <button id="btnFilter" class="btn btn-primary ms-2" title="Terapkan Filter">
                            <i class="mdi mdi-filter-variant"></i>
                        </button>
                        <button id="btnReset" class="btn btn-outline-secondary ms-1" title="Reset Filter">
                            <i class="mdi mdi-refresh"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Summary Cards -->
            {{-- <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-cash mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Total Tagihan</h6>
                                    <h4 class="mb-0">Rp {{ number_format($tagihan->sum('total_tagihan'), 0, ',', '.') }}</h4>
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
                                    <h6 class="mb-0">Total Lunas</h6>
                                    <h4 class="mb-0">Rp {{ number_format($tagihan->where('status', 'lunas')->sum('total_tagihan'), 0, ',', '.') }}</h4>
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
                                    <i class="mdi mdi-clock-alert mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Jatuh Tempo</h6>
                                    <h4 class="mb-0">{{ $tagihan->where('jatuh_tempo', '<', now())->where('status', '!=', 'lunas')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body py-3">
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="mdi mdi-progress-clock mdi-24px"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-0">Dalam Proses</h6>
                                    <h4 class="mb-0">{{ $tagihan->where('status', 'proses')->count() }}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Table -->
            <div class="table-responsive rounded border">
                <table class="table table-hover align-middle mb-0" id="keuanganTable">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="border-0">#</th>
                            <th width="10%" class="border-0">Tanggal</th>
                            <th width="15%" class="border-0">Pelanggan & Pesanan</th>
                            <th width="10%" class="border-0">Jenis</th>
                            <th width="12%" class="border-0">Nominal</th>
                            <th width="12%" class="border-0">Jatuh Tempo</th>
                            <th width="12%" class="border-0">Status</th>
                            <th width="11%" class="border-0">Metode</th>
                            <th width="13%" class="border-0 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="keuanganBody">
                        @php $no=1; @endphp
                        @foreach($tagihan as $t)
                        <tr class="border-bottom">
                            <td class="fw-bold text-muted">{{ $no++ }}</td>
                            
                            <!-- Tanggal -->
                            <td>
                                <div class="small">
                                    <div class="fw-medium text-dark">
                                        {{ \Carbon\Carbon::parse($t->tanggal)->format('d M Y') }}
                                    </div>
                                </div>
                            </td>

                            <!-- Pelanggan & Pesanan -->
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="bg-info rounded-circle d-flex align-items-center justify-content-center me-3" 
                                         style="width: 40px; height: 40px;">
                                        <i class="mdi mdi-account text-white"></i>
                                    </div>
                                    <div>
                                        <div class="fw-medium text-dark">
                                            {{ $t->lembarKerja->klien->nama ?? '-' }}
                                        </div>
                                        <div class="text-muted small">
                                            {{ $t->lembarKerja->no_pesanan ?? '-' }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Jenis -->
                            <td>
                                <span class="badge 
                                    @if($t->kategori->nama_kategori == 'Tagihan') bg-primary
                                    @else bg-success
                                    @endif">
                                    <i class="mdi mdi-{{ $t->kategori->nama_kategori == 'Tagihan' ? 'file-document' : 'cash' }} me-1"></i>
                                    {{ $t->kategori->nama_kategori ?? '-' }}
                                </span>
                            </td>

                            <!-- Nominal -->
                            <td>
                                <div class="fw-bold text-dark">
                                    Rp {{ number_format($t->total_tagihan, 0, ',', '.') }}
                                </div>
                            </td>

                            <!-- Jatuh Tempo -->
                            <td>
                                @if($t->jatuh_tempo)
                                    @php
                                        $daysLeft = \Carbon\Carbon::parse($t->jatuh_tempo)->diffInDays(now(), false);
                                    @endphp
                                    <div class="small">
                                        <div class="fw-medium {{ $daysLeft < 0 ? 'text-danger' : 'text-dark' }}">
                                            {{ \Carbon\Carbon::parse($t->jatuh_tempo)->format('d M Y') }}
                                        </div>
                                        @if($daysLeft < 0)
                                            <div class="text-danger">
                                                <i class="mdi mdi-alert-circle-outline me-1"></i>
                                                Terlambat {{ abs($daysLeft) }} hari
                                            </div>
                                        @elseif($daysLeft == 0)
                                            <div class="text-warning">
                                                <i class="mdi mdi-clock-alert me-1"></i>
                                                Hari ini
                                            </div>
                                        @elseif($daysLeft <= 7)
                                            <div class="text-warning">
                                                <i class="mdi mdi-clock-outline me-1"></i>
                                                {{ $daysLeft }} hari lagi
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td>
                                <span class="badge bg-{{ match($t->status ?? 'proses') {
                                    'lunas' => 'success',
                                    'proses' => 'warning',
                                    'batal' => 'danger',
                                    default => 'secondary'
                                } }}">
                                    <i class="mdi mdi-{{ match($t->status ?? 'proses') {
                                        'lunas' => 'check-circle',
                                        'proses' => 'progress-clock',
                                        'batal' => 'close-circle',
                                        default => 'circle'
                                    } }} me-1"></i>
                                    {{ ucfirst($t->status ?? 'proses') }}
                                </span>
                            </td>

                            <!-- Metode Pembayaran -->
                            <td>
                                <span class="badge bg-light text-dark">
                                    <i class="mdi mdi-{{ match($t->metode_pembayaran) {
                                        'Transfer' => 'bank-transfer',
                                        'Tunai' => 'cash',
                                        'Kartu Kredit' => 'credit-card',
                                        default => 'wallet'
                                    } }} me-1"></i>
                                    {{ $t->metode_pembayaran }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <button class="btn btn-primary btn-icon btn-sm btn-cetak" 
                                            data-url="{{ route('tagihan.print', $t->id) }}"
                                            data-bs-toggle="tooltip" 
                                            title="Cetak Tagihan">
                                        <i class="mdi mdi-printer"></i>
                                    </button>
                                    @if($t->kategori->nama_kategori == 'Tagihan')
                                    <button class="btn btn-success btn-icon btn-sm"
                                            data-bs-toggle="tooltip" 
                                            title="Tandai Lunas">
                                        <i class="mdi mdi-check-circle"></i>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Empty State -->
            @if($tagihan->count() == 0)
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="mdi mdi-cash-remove mdi-48px text-muted mb-3"></i>
                    <h5 class="text-muted">Belum ada data tagihan</h5>
                    <p class="text-muted mb-0">Tidak ada transaksi yang tercatat untuk saat ini</p>
                </div>
            </div>
            @endif

        </div>
    </div>

</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const table = document.getElementById('keuanganTable');
    const tbody = document.getElementById('keuanganBody');
    const rows = Array.from(tbody.rows);

    // Inisialisasi Bootstrap tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Filter Table
    function filterTable() {
        const start = document.getElementById('filterStart').value;
        const end = document.getElementById('filterEnd').value;
        const jenis = document.getElementById('filterJenis').value.toLowerCase();
        const keyword = document.getElementById('searchKeyword').value.toLowerCase();

        rows.forEach(row => {
            const tanggal = moment(row.cells[1].querySelector('.fw-medium').innerText, 'DD MMM YYYY');
            const rowJenis = row.cells[3].innerText.toLowerCase();
            const rowText = row.innerText.toLowerCase();
            let show = true;

            if(start && tanggal.isBefore(moment(start))) show = false;
            if(end && tanggal.isAfter(moment(end))) show = false;
            if(jenis && !rowJenis.includes(jenis)) show = false;
            if(keyword && !rowText.includes(keyword)) show = false;

            row.style.display = show ? '' : 'none';
        });
    }

    // Event Listeners untuk Filter
    document.getElementById('btnFilter').addEventListener('click', filterTable);
    document.getElementById('filterStart').addEventListener('change', filterTable);
    document.getElementById('filterEnd').addEventListener('change', filterTable);
    document.getElementById('filterJenis').addEventListener('change', filterTable);
    document.getElementById('searchKeyword').addEventListener('input', filterTable);

    // Reset Filter
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
        XLSX.writeFile(wb, 'tagihan-pembayaran.xlsx');
    });

    // Export PDF
    document.getElementById('exportPdf').addEventListener('click', () => {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();
        
        // Add title
        doc.setFontSize(16);
        doc.text('LAPORAN TAGIHAN & PEMBAYARAN', 105, 15, { align: 'center' });
        
        // Add date
        doc.setFontSize(10);
        doc.text(`Dicetak pada: ${new Date().toLocaleDateString('id-ID')}`, 105, 22, { align: 'center' });
        
        // Convert table to PDF
        doc.autoTable({
            html: '#keuanganTable',
            startY: 30,
            styles: { fontSize: 8 },
            headStyles: { fillColor: [13, 110, 253] }
        });
        
        doc.save('laporan-tagihan.pdf');
    });

    // Cetak Tagihan
    document.querySelectorAll('.btn-cetak').forEach(btn => {
        btn.addEventListener('click', function() {
            const url = this.dataset.url;
            window.open(url, '_blank');
        });
    });
});
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

.empty-state {
    padding: 2rem 1rem;
}

.badge {
    font-size: 0.75rem;
    font-weight: 500;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
}

@media (max-width: 768px) {
    .filter-section .col-md-3,
    .filter-section .col-md-2 {
        margin-bottom: 1rem;
    }
    
    .table-responsive {
        font-size: 0.875rem;
    }
}
</style>
@endpush