@extends('layouts.commonMaster')

@section('title', 'Edit Lembar Kerja')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Header Card --}}
    <div class="card shadow-sm mb-3">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div class="mb-2 mb-md-0">
                <h5 class="fw-bold mb-1">
                    <i data-feather="edit-3" class="me-1"></i>
                    Edit Lembar Kerja — {{ $lembarKerja->nama_lembar ?? '-' }}
                </h5>
                <div class="d-flex flex-wrap gap-2 mt-2">
    <span class="badge bg-info text-dark small">
        Status: {{ $lembarKerja->status ?? '-' }}
    </span>
    <span class="badge bg-success small" id="badgeTotalTagihan">
        Total Tagihan: Rp {{ number_format($totalTagihan ?? 0, 0, ',', '.') }}
    </span>
    <span class="badge bg-primary small" id="badgeTotalDibayar">
        Total Dibayar: Rp {{ number_format($totalDibayar ?? 0, 0, ',', '.') }}
    </span>
    <span class="badge bg-warning text-dark small" id="badgeSisaTagihan">
        Sisa Tagihan: Rp {{ number_format($sisaTagihan ?? 0, 0, ',', '.') }}
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

    {{-- Form Card --}}
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
                    <div class="tab-pane fade show active" id="tab-lembarKerja">@include('lembarkerja.tabs.lembarKerja')</div>
                    <div class="tab-pane fade" id="tab-proses">@include('lembarkerja.tabs.proses')</div>
                    <div class="tab-pane fade" id="tab-keuangan">@include('lembarkerja.tabs.keuangan')</div>
                    <div class="tab-pane fade" id="tab-dokumen">@include('lembarkerja.tabs.dokumen')</div>
                    <div class="tab-pane fade" id="tab-catatan">@include('lembarkerja.tabs.catatan')</div>
                    <div class="tab-pane fade" id="tab-userLog">@include('lembarkerja.tabs.userLog')</div>
                    <div class="tab-pane fade" id="tab-setting">@include('lembarkerja.tabs.setting')</div>
                </div>

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
        @csrf
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
                <label>Keterangan</label>
                <textarea class="form-control" name="keterangan" rows="3"></textarea>
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
    if(window.feather) feather.replace();

    // ================= TAB LOGIC =================
    let activeTab = localStorage.getItem("activeTab");
    if (activeTab) {
        let tabTrigger = document.querySelector('[data-bs-target="' + activeTab + '"]');
        if (tabTrigger) new bootstrap.Tab(tabTrigger).show();
    }
    document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(btn => {
        btn.addEventListener("shown.bs.tab", function (event) {
            localStorage.setItem("activeTab", event.target.getAttribute("data-bs-target"));
        });
    });

    // ================= MODAL AJUKAN / TAGIHAN =================
    const btnAjukan = document.getElementById('btnAjukanAktivasi');
    const modalAktivasiEl = document.getElementById('modalAjukanAktivasi');
    const modalAktivasi = new bootstrap.Modal(modalAktivasiEl);
    const btnSubmitAktivasi = document.getElementById('btnSubmitAktivasi');

    const modalTagihanEl = document.getElementById('modalTambahTagihan');
    const modalTagihan = new bootstrap.Modal(modalTagihanEl);
    const formTambahTagihan = document.getElementById('formTambahTagihan');

    btnAjukan.addEventListener('click', function() {
        if(btnAjukan.dataset.status !== "tambahTagihan"){
            modalAktivasi.show();
        } else {
            modalTagihan.show();
        }
    });

    btnSubmitAktivasi.addEventListener('click', function() {
        modalAktivasi.hide();
        btnAjukan.innerHTML = '<i data-feather="plus-circle" class="me-1"></i> Tagihan';
        btnAjukan.classList.remove("btn-success");
        btnAjukan.classList.add("btn-primary");
        btnAjukan.dataset.status = "tambahTagihan";
        if(window.feather) feather.replace();
    });

    // ================= TAMBAH TAGIHAN =================
    formTambahTagihan.addEventListener('submit', async function(e){
        e.preventDefault();

        const formData = new FormData();
        modalTagihanEl.querySelectorAll('input[name], select[name], textarea[name]').forEach(el => {
            formData.append(el.name, el.value);
        });
        formData.append('_token', "{{ csrf_token() }}");

        try {
            const res = await fetch("{{ route('lembar-kerja.tagihan.store', $lembarKerja->id) }}", {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: formData
            });

            const data = await res.json();

            // ================= VALIDASI =================
            if(res.status === 422){
                const messages = Object.values(data.errors).map(e => e.join(', ')).join('<br>');
                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal',
                    html: messages
                });
                return;
            }

            // ================= CEK SERVER ERROR =================
            if(!res.ok){
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    text: data.message || 'Server error, coba lagi!',
                    toast: true,
                    position: 'top-end'
                });
                return;
            }

            // ================= KIRIM EVENT KE TAB KEUANGAN =================
            const event = new CustomEvent('tagihanAdded', { detail: data.tagihan });
            document.getElementById('tab-keuangan').dispatchEvent(event);

            // Reset form dan tutup modal
            formTambahTagihan.reset();
            modalTagihan.hide();

            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Tagihan berhasil ditambahkan',
                toast: true,
                position: 'top-end',
                timer: 2000,
                showConfirmButton: false
            });

        } catch(err){
            console.error(err);
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: 'Server error, coba lagi!',
                toast: true,
                position: 'top-end'
            });
        }
    });

});
</script>
@endpush
