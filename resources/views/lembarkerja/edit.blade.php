@extends('layouts.commonMaster')

@section('title', 'Detail Lembar Kerja')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Header Card --}}
    <div class="card shadow-sm mb-3">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div class="mb-2 mb-md-0">
                <h5 class="fw-bold mb-1">
                    <i data-feather="edit-3" class="me-1"></i>
                    Detail Lembar Kerja — {{ $lembarKerja->nama_lembar ?? '-' }}
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
    @php
        $showBtn = false;
        $btnLabel = '';
        $btnClass = '';
        $btnDataStatus = '';
        $btnIcon = '';

        if($lembarKerja->status === 'draft') {
            $showBtn = true;
            $btnLabel = 'Ajukan Aktivasi';
            $btnClass = 'btn-success';
            $btnDataStatus = 'aktivasi';
            $btnIcon = 'send';
        } elseif($lembarKerja->status === 'persetujuan' && ($totalTagihan ?? 0) > 0) {
            $showBtn = true;
            $btnLabel = 'Penerimaan Pembayaran';
            $btnClass = 'btn-success';
            $btnDataStatus = 'pembayaran';
            $btnIcon = 'dollar-sign';
        } elseif($lembarKerja->status === 'persetujuan') {
            $showBtn = true;
            $btnLabel = 'Tagihan';
            $btnClass = 'btn-primary';
            $btnDataStatus = 'tambahTagihan';
            $btnIcon = 'plus-circle';
        }
    @endphp

    @if($showBtn)
    <button type="button" class="btn btn-sm {{ $btnClass }}" id="btnAjukanAktivasi" data-status="{{ $btnDataStatus }}">
        <i data-feather="{{ $btnIcon }}" class="me-1"></i> {{ $btnLabel }}
    </button>
    @endif

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
    <label>Kategori <span class="text-danger">*</span></label>
    {{-- Select hanya tampil, tidak bisa diubah --}}
    <select class="form-select" disabled>
        @foreach($kategoriKeuangan as $kategori)
            <option value="{{ $kategori->id }}"
                {{ $kategori->nama_kategori === 'Tagihan' ? 'selected' : '' }}>
                {{ $kategori->nama_kategori }}
            </option>
        @endforeach
    </select>

    {{-- Hidden input agar value tetap dikirim ke server --}}
    @foreach($kategoriKeuangan as $kategori)
        @if($kategori->nama_kategori === 'Tagihan')
            <input type="hidden" name="kategori_id" value="{{ $kategori->id }}">
        @endif
    @endforeach
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

    const btnAjukan = document.getElementById('btnAjukanAktivasi');
    const modalAktivasiEl = document.getElementById('modalAjukanAktivasi');
    const modalAktivasi = new bootstrap.Modal(modalAktivasiEl);
    const btnSubmitAktivasi = document.getElementById('btnSubmitAktivasi');

    const modalTagihanEl = document.getElementById('modalTambahTagihan');
    const modalTagihan = new bootstrap.Modal(modalTagihanEl);
    const formTambahTagihan = document.getElementById('formTambahTagihan');

    if(btnAjukan){
        btnAjukan.addEventListener('click', function() {
            if(btnAjukan.dataset.status === "tambahTagihan"){
                modalTagihan.show();
            } else {
                modalAktivasi.show();
            }
        });

        btnSubmitAktivasi.addEventListener('click', async function() {
            // Kirim request update status ke server (AJAX)
            try {
                const res = await fetch("{{ route('lembar-kerja.update-status', $lembarKerja->id) }}", {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ status: 'persetujuan' })
                });
                const data = await res.json();

                if(!res.ok){
                    Swal.fire({ icon: 'error', title: 'Gagal!', text: data.message || 'Server error' });
                    return;
                }

                // Tutup modal
                modalAktivasi.hide();

                // Update badge status di UI
                const badgeStatus = document.querySelector('.badge.bg-info');
                if(badgeStatus) badgeStatus.textContent = "Status: persetujuan";

                // Ubah button jadi tambah tagihan
                btnAjukan.innerHTML = '<i data-feather="plus-circle" class="me-1"></i> Tagihan';
                btnAjukan.classList.remove("btn-success");
                btnAjukan.classList.add("btn-primary");
                btnAjukan.dataset.status = "tambahTagihan";

                if(window.feather) feather.replace();

            } catch(err){
                console.error(err);
                Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan!' });
            }
        });
    }

    // ================= TAMBAH TAGIHAN =================
    formTambahTagihan.addEventListener('submit', async function(e){
        e.preventDefault();

        const formData = new FormData(formTambahTagihan);

        try {
            const res = await fetch("{{ route('lembar-kerja.tagihan.store', $lembarKerja->id) }}", {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: formData
            });
            const data = await res.json();

            if(res.status === 422){
                const messages = Object.values(data.errors).map(e => e.join(', ')).join('<br>');
                Swal.fire({ icon: 'error', title: 'Validasi Gagal', html: messages });
                return;
            }
            if(!res.ok){
                Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Server error' });
                return;
            }

            // Reset form & tutup modal
            formTambahTagihan.reset();
            modalTagihan.hide();

            // Ubah button jadi Penerimaan Pembayaran
            btnAjukan.innerHTML = '<i data-feather="dollar-sign" class="me-1"></i> Penerimaan Pembayaran';
            btnAjukan.classList.remove("btn-primary");
            btnAjukan.classList.add("btn-success");
            btnAjukan.dataset.status = "pembayaran";

            if(window.feather) feather.replace();

            // Event update tab keuangan
            const event = new CustomEvent('tagihanAdded', { detail: data.tagihan });
            document.getElementById('tab-keuangan').dispatchEvent(event);

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
            Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan!' });
        }
    });
});

</script>
@endpush
