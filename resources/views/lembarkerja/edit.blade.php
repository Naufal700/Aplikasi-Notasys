@extends('layouts.commonMaster')

@section('title', 'Edit Lembar Kerja')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card shadow-sm mb-3">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div class="mb-2 mb-md-0">
                <h5 class="fw-bold mb-1">
                    <i data-feather="edit-3" class="me-1"></i>
                    Edit Lembar Kerja — {{ $lembarKerja->nama_lembar ?? '-' }}
                </h5>

                {{-- Info Label --}}
                <div class="d-flex flex-wrap gap-3 mt-2">
                    <span class="badge bg-info text-dark">
                        <i data-feather="info" class="me-1"></i>
                        Status: {{ $lembarKerja->status ?? '-' }}
                    </span>
                    <span class="badge bg-success">
                        <i data-feather="dollar-sign" class="me-1"></i>
                        Total Tagihan: Rp {{ number_format($lembarKerja->total_tagihan ?? 0, 0, ',', '.') }}
                    </span>
                    <span class="badge bg-primary">
                        <i data-feather="credit-card" class="me-1"></i>
                        Total Dibayar: Rp {{ number_format($lembarKerja->total_dibayar ?? 0, 0, ',', '.') }}
                    </span>
                    <span class="badge bg-warning text-dark">
                        <i data-feather="alert-circle" class="me-1"></i>
                        Sisa Tagihan: Rp {{ number_format(($lembarKerja->total_tagihan ?? 0) - ($lembarKerja->total_dibayar ?? 0), 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- Button Action --}}
            <div class="d-flex gap-2 flex-wrap">
                <button type="button" class="btn btn-sm btn-success" id="btnAjukanAktivasi">
                    <i data-feather="send" class="me-1"></i> Ajukan Aktivasi
                </button>
                <button type="button" class="btn btn-sm btn-danger" id="btnBatalkan">
                    <i data-feather="x-circle" class="me-1"></i> Batalkan
                </button>
                <a href="{{ route('lembar-kerja.print', $lembarKerja->id) }}" target="_blank" class="btn btn-sm btn-primary">
                    <i data-feather="printer" class="me-1"></i> Print PDF
                </a>
            </div>
        </div>
    </div>

    {{-- Card utama form --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('lembar-kerja.update', $lembarKerja->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Tabs --}}
                <ul class="nav nav-tabs" id="lembarKerjaTab" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-lembarKerja" type="button">Lembar Kerja</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-proses" type="button">Proses</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-keuangan" type="button">Keuangan</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-dokumen" type="button">Dokumen</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-catatan" type="button">Catatan</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-userLog" type="button">User Log</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-setting" type="button">Setting</button>
                    </li>
                </ul>

                {{-- Tab Content --}}
                <div class="tab-content mt-4">
                    <div class="tab-pane fade show active" id="tab-lembarKerja">
                        @include('lembarkerja.tabs.lembarKerja')
                    </div>
                    <div class="tab-pane fade" id="tab-proses">
                        @include('lembarkerja.tabs.proses')
                    </div>
                    <div class="tab-pane fade" id="tab-keuangan">
                        @include('lembarkerja.tabs.keuangan')
                    </div>
                    <div class="tab-pane fade" id="tab-dokumen">
                        @include('lembarkerja.tabs.dokumen')
                    </div>
                    <div class="tab-pane fade" id="tab-catatan">
                        @include('lembarkerja.tabs.catatan')
                    </div>
                    <div class="tab-pane fade" id="tab-userLog">
                        @include('lembarkerja.tabs.userLog')
                    </div>
                    <div class="tab-pane fade" id="tab-setting">
                        @include('lembarkerja.tabs.setting')
                    </div>
                </div>

                {{-- Submit --}}
                <div class="mt-3 text-end">
                    <a href="{{ route('lembar-kerja.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-success">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Ajukan Aktivasi --}}
<div class="modal fade" id="modalAjukanAktivasi" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Keterangan Aktivasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label for="keterangan">Keterangan (opsional)</label>
        <textarea class="form-control" id="keterangan" rows="3" placeholder="Tambahkan keterangan jika perlu..."></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btnSubmitAktivasi">OK</button>
      </div>
    </div>
  </div>
</div>
{{-- Modal Tambah Tagihan --}}
<div class="modal fade" id="modalTambahTagihan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formTambahTagihan">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Tagihan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label>Tanggal <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="tanggal" required>
            </div>
            <div class="mb-3">
                <label>Jenis <span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="jenis" value="Tagihan" readonly>
            </div>
            <div class="mb-3">
                <label>Total Tagihan <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="total_tagihan" required>
            </div>
            <div class="mb-3">
                <label>Jatuh Tempo <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="jatuh_tempo" required>
            </div>
            <div class="mb-3">
                <label>Metode Pembayaran <span class="text-danger">*</span></label>
                <select class="form-select" name="metode_pembayaran" required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="Transfer">Transfer</option>
                    <option value="Tunai">Tunai</option>
                    <option value="EDC">EDC</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Keterangan <span class="text-danger">*</span></label>
                <textarea class="form-control" name="keterangan" rows="3" required></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Tagihan</button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function () {

    // Render feather icons
    if(window.feather) feather.replace();

    // ======= TAB LOGIC =======
    var activeTab = localStorage.getItem("activeTab");
    if (activeTab) {
        var tabTrigger = document.querySelector('[data-bs-target="' + activeTab + '"]');
        if (tabTrigger) new bootstrap.Tab(tabTrigger).show();
    }

    var tabButtons = document.querySelectorAll('button[data-bs-toggle="tab"]');
    tabButtons.forEach(function (btn) {
        btn.addEventListener("shown.bs.tab", function (event) {
            localStorage.setItem("activeTab", event.target.getAttribute("data-bs-target"));
        });
    });

    // ======= MODAL AJUKAN AKTIVASI =======
    var modalEl = document.getElementById('modalAjukanAktivasi');
    var modal = new bootstrap.Modal(modalEl);
    var btnAjukan = document.getElementById('btnAjukanAktivasi');
    var btnSubmit = document.getElementById('btnSubmitAktivasi');
    var textareaKeterangan = document.getElementById('keterangan');

    // Klik tombol Ajukan Aktivasi -> buka modal
    btnAjukan.addEventListener('click', function() {
        if (!btnAjukan.dataset.status || btnAjukan.dataset.status !== "tambahTagihan") {
            modal.show();
        } else {
            // aksi Tambah Tagihan & Proses
            // alert("Proses Tambah Tagihan & Proses dijalankan!");
        }
    });

    // Klik OK di modal
    btnSubmit.addEventListener('click', function() {
        var keterangan = textareaKeterangan.value.trim(); // opsional
        console.log("Keterangan:", keterangan);

        modal.hide();

        // ubah tombol menjadi Tambah Tagihan & Proses dengan ikon
        btnAjukan.innerHTML = '<i data-feather="plus-circle" class="me-1"></i> Tagihan';
        btnAjukan.classList.remove("btn-success");
        btnAjukan.classList.add("btn-primary");
        btnAjukan.dataset.status = "tambahTagihan";

        // re-render feather icons
        if(window.feather) feather.replace();
    });
// ======= MODAL TAMBAH TAGIHAN =======
    var btnAjukan = document.getElementById('btnAjukanAktivasi');
    var modalTagihanEl = document.getElementById('modalTambahTagihan');
    var modalTagihan = new bootstrap.Modal(modalTagihanEl);
    var formTambahTagihan = document.getElementById('formTambahTagihan');

    // Klik tombol Tambah Tagihan & Proses
    btnAjukan.addEventListener('click', function() {
        if(btnAjukan.dataset.status === "tambahTagihan") {
            modalTagihan.show();
        }
    });

    // Submit form tagihan
    formTambahTagihan.addEventListener('submit', function(e){
        e.preventDefault();

        var formData = new FormData(formTambahTagihan);
        for(let [key, value] of formData.entries()){
            if(!value){
                alert("Field '" + key + "' wajib diisi!");
                return;
            }
        }

        // Simulasi simpan data
        console.log("Data Tagihan:", Object.fromEntries(formData.entries()));

        modalTagihan.hide();
        formTambahTagihan.reset();
        alert("Tagihan berhasil disimpan (simulasi)!");
    });
});
</script>
@endpush
