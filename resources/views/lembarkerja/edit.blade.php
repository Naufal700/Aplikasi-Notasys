@extends('layouts.commonMaster')

@section('title', 'Detail Lembar Kerja')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Header Card --}}
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold mb-0 text-white">
                    <i class="bx bx-edit me-2"></i>
                    Detail Lembar Kerja
                </h4>
                <span class="badge bg-light text-primary fs-6">No. Pesanan: {{ $lembarKerja->no_pesanan ?? '-' }}</span>
            </div>
        </div>
        <div class="card-body">
            {{-- Financial Summary --}}
        <div class="row g-3 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="card financial-card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-2 fw-semibold">Total Tagihan</p>
                        <h3 class="fw-bold mb-0" id="badgeTotalTagihan">Rp {{ number_format($totalTagihan ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="bg-success bg-opacity-10 p-3 rounded-circle">
                        <i class="bx bx-receipt fs-4 text-success"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-success bg-opacity-10 text-white">Total Tagihan</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card financial-card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-2 fw-semibold">Total Dibayar</p>
                        <h3 class="fw-bold mb-0" id="badgeTotalDibayar">Rp {{ number_format($totalDibayar ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="bg-info bg-opacity-10 p-3 rounded-circle">
                        <i class="bx bx-check-circle fs-4 text-info"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-info bg-opacity-10 text-info">Terbayar</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card financial-card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-2 fw-semibold">Sisa Tagihan</p>
                        <h3 class="fw-bold mb-0" id="badgeSisaTagihan">Rp {{ number_format($sisaTagihan ?? 0, 0, ',', '.') }}</h3>
                    </div>
                    <div class="bg-warning bg-opacity-10 p-3 rounded-circle">
                        <i class="bx bx-time fs-4 text-warning"></i>
                    </div>
                </div>
                <div class="mt-3">
                    <span class="badge bg-warning bg-opacity-10 text-white">Tertunggak</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-md-6">
        <div class="card financial-card border-0 shadow-sm h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted mb-2 fw-semibold">Status</p>
                        <h4 class="fw-bold mb-0 text-capitalize">{{ $lembarKerja->status ?? '-' }}</h4>
                    </div>
                    <div class="bg-secondary bg-opacity-10 p-3 rounded-circle">
                        <i class="bx bx-calendar fs-4 text-secondary"></i>
                    </div>
                </div>
                <div class="mt-3">
                    @php
                        $statusClass = 'bg-secondary';
                        if(($lembarKerja->status ?? '') === 'draft') $statusClass = 'bg-light text-dark';
                        elseif(($lembarKerja->status ?? '') === 'persetujuan') $statusClass = 'bg-primary';
                    @endphp
                    <span class="badge {{ $statusClass }}">Status Saat Ini</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Action Buttons --}}
<div class="d-flex gap-3 flex-wrap justify-content-end mt-4">
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
            $btnLabel = 'Tambah Tagihan';
            $btnClass = 'btn-primary';
            $btnDataStatus = 'tambahTagihan';
            $btnIcon = 'plus-circle';
        }
    @endphp

    @if($showBtn)
    <button type="button" class="btn {{ $btnClass }} px-4 py-2 d-flex align-items-center" id="btnAjukanAktivasi" data-status="{{ $btnDataStatus }}">
        <i class="bx bx-{{ $btnIcon }} me-2"></i> {{ $btnLabel }}
    </button>
    @endif

    <button type="button" class="btn btn-outline-danger px-4 py-2 d-flex align-items-center" id="btnBatalkan">
        <i class="bx bx-x-circle me-2"></i> Batalkan
    </button>
    <a href="{{ route('lembar-kerja.print', $lembarKerja->id) }}" target="_blank" class="btn btn-outline-primary px-4 py-2 d-flex align-items-center">
        <i class="bx bx-printer me-2"></i> Print PDF
    </a>
    <a href="{{ route('lembar-kerja.index') }}" class="btn btn-outline-secondary px-4 py-2 d-flex align-items-center">
        <i class="bx bx-arrow-back me-2"></i> Kembali
    </a>
</div>


    {{-- Main Form Card --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('lembar-kerja.update', $lembarKerja->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Enhanced Tabs --}}
                <ul class="nav nav-pills custom-nav-pills mb-4" id="lembarKerjaTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-lembarKerja" type="button">
                            <i class="bx bx-file me-1"></i> Lembar Kerja
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-proses" type="button">
                            <i class="bx bx-cog me-1"></i> Proses
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-keuangan" type="button">
                            <i class="bx bx-money me-1"></i> Keuangan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-dokumen" type="button">
                            <i class="bx bx-folder me-1"></i> Dokumen
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-catatan" type="button">
                            <i class="bx bx-note me-1"></i> Catatan
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-userLog" type="button">
                            <i class="bx bx-history me-1"></i> User Log
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-setting" type="button">
                            <i class="bx bx-slider-alt me-1"></i> Setting
                        </button>
                    </li>
                </ul>

                {{-- Tab Content --}}
                <div class="tab-content mt-2">
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

                {{-- Form Actions --}}
                <div class="mt-4 pt-3 border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="form-text">
                            <i class="bx bx-info-circle me-1"></i>
                            Terakhir diupdate: {{ $lembarKerja->updated_at->format('d M Y H:i') }}
                        </div>
                        <div>
                            <a href="{{ route('lembar-kerja.index') }}" class="btn btn-secondary me-2">
                                <i class="bx bx-x me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-success">
                                <i class="bx bx-save me-1"></i> Update Lembar Kerja
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Ajukan Aktivasi --}}
<div class="modal fade" id="modalAjukanAktivasi" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bx bx-send me-2"></i>Ajukan Aktivasi
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="bx bx-info-circle me-2"></i>
                    Lembar kerja akan diajukan untuk persetujuan dan tidak dapat diubah setelahnya.
                </div>
                <label for="keterangan" class="form-label">Keterangan (opsional)</label>
                <textarea class="form-control" id="keterangan" rows="3" placeholder="Tambahkan keterangan jika perlu..."></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="btnSubmitAktivasi">
                    <i class="bx bx-check me-1"></i> Ajukan Aktivasi
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Tambah Tagihan --}}
<div class="modal fade" id="modalTambahTagihan" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <form id="formTambahTagihan">
                @csrf
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="bx bx-plus-circle me-2"></i>Tambah Tagihan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tanggal <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="tanggal" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kategori <span class="text-danger">*</span></label>
                            <select class="form-select" disabled>
                                @foreach($kategoriKeuangan as $kategori)
                                    <option value="{{ $kategori->id }}"
                                        {{ $kategori->nama_kategori === 'Tagihan' ? 'selected' : '' }}>
                                        {{ $kategori->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            @foreach($kategoriKeuangan as $kategori)
                                @if($kategori->nama_kategori === 'Tagihan')
                                    <input type="hidden" name="kategori_id" value="{{ $kategori->id }}">
                                @endif
                            @endforeach
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Total Tagihan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control" name="total_tagihan" required placeholder="Masukkan total tagihan">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jatuh Tempo <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="jatuh_tempo" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Metode Pembayaran <span class="text-danger">*</span></label>
                            <select class="form-select" name="metode_pembayaran" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="Transfer">Transfer</option>
                                <option value="Tunai">Tunai</option>
                                <option value="EDC">EDC</option>
                            </select>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control" name="keterangan" rows="3" placeholder="Masukkan keterangan tagihan..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i> Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bx bx-save me-1"></i> Simpan Tagihan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.custom-nav-pills .nav-link {
    border-radius: 0.5rem;
    padding: 0.75rem 1.25rem;
    font-weight: 500;
    color: #6c757d;
    transition: all 0.2s ease;
}

.custom-nav-pills .nav-link:hover {
    background-color: #f8f9fa;
    color: #495057;
}

.custom-nav-pills .nav-link.active {
    background-color: #0d6efd;
    color: white;
    box-shadow: 0 0.125rem 0.25rem rgba(13, 110, 253, 0.3);
}

.financial-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    border-radius: 12px;
}

.financial-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1) !important;
}

.card-header.bg-primary {
    border-radius: 0.5rem 0.5rem 0 0 !important;
}

.input-group-text {
    background-color: #f8f9fa;
    border-color: #ced4da;
}

@media (max-width: 768px) {
    .financial-card .card-body {
    position: relative;
}
    
   .financial-card h3 {
    font-size: 1.4rem;
}
.financial-card .rounded-circle {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
}
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .d-flex.justify-content-between > div {
        width: 100%;
        text-align: center;
    }
    .btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.btn:hover {
    transform: translateY(-2px);
}
}
</style>
@endsection
@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // --- Set default dates for tagihan form ---
    const today = new Date().toISOString().split('T')[0];
    const nextWeek = new Date();
    nextWeek.setDate(nextWeek.getDate() + 7);
    const nextWeekFormatted = nextWeek.toISOString().split('T')[0];

    const formTambahTagihan = document.getElementById('formTambahTagihan');
    if(formTambahTagihan){
        formTambahTagihan.querySelector('input[name="tanggal"]').value = today;
        formTambahTagihan.querySelector('input[name="jatuh_tempo"]').value = nextWeekFormatted;
    }

    // --- Modals ---
    const modalAktivasiEl = document.getElementById('modalAjukanAktivasi');
    const modalAktivasi = new bootstrap.Modal(modalAktivasiEl);
    const modalTagihanEl = document.getElementById('modalTambahTagihan');
    const modalTagihan = new bootstrap.Modal(modalTagihanEl);

    // Reset form saat modal tagihan ditutup
    modalTagihanEl.addEventListener('hidden.bs.modal', () => {
        formTambahTagihan.reset();
        formTambahTagihan.querySelector('input[name="tanggal"]').value = today;
        formTambahTagihan.querySelector('input[name="jatuh_tempo"]').value = nextWeekFormatted;
    });

    // --- Bootstrap Tabs with Last Active Memory ---
    const tabButtons = document.querySelectorAll('#lembarKerjaTab button[data-bs-toggle="tab"]');
    
    // Restore last active tab
    const lastTab = localStorage.getItem('activeLembarTab');
    if(lastTab){
        const tabToShow = document.querySelector(`#lembarKerjaTab button[data-bs-target="${lastTab}"]`);
        if(tabToShow){
            const tabInstance = new bootstrap.Tab(tabToShow);
            tabInstance.show();
        }
    }

    // Save active tab on click
    tabButtons.forEach(btn => {
        btn.addEventListener('shown.bs.tab', function(event){
            const target = event.target.getAttribute('data-bs-target'); // #tab-lembarKerja, #tab-proses, ...
            localStorage.setItem('activeLembarTab', target);
        });
    });

    // --- Button Ajukan ---
    const btnAjukan = document.getElementById('btnAjukanAktivasi');
    const btnSubmitAktivasi = document.getElementById('btnSubmitAktivasi');

    if(btnAjukan){
        btnAjukan.addEventListener('click', function(){
            if(btnAjukan.dataset.status === "tambahTagihan"){
                modalTagihan.show();
            } else {
                modalAktivasi.show();
            }
        });

        // --- Submit Ajukan Aktivasi ---
        btnSubmitAktivasi?.addEventListener('click', async function(){
            const keterangan = document.getElementById('keterangan').value;
            btnSubmitAktivasi.disabled = true;

            try {
                const res = await fetch("{{ route('lembar-kerja.update-status', $lembarKerja->id) }}", {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ status: 'persetujuan', keterangan })
                });
                const data = await res.json();

                if(!res.ok){
                    Swal.fire({ icon: 'error', title: 'Gagal!', text: data.message || 'Server error' });
                    btnSubmitAktivasi.disabled = false;
                    return;
                }

                modalAktivasi.hide();

                // Update UI
                document.querySelector('.financial-card.bg-secondary h6:last-child').textContent = 'persetujuan';

                // Update button
                btnAjukan.innerHTML = '<i class="bx bx-plus-circle me-1"></i> Tambah Tagihan';
                btnAjukan.classList.replace("btn-success", "btn-primary");
                btnAjukan.dataset.status = "tambahTagihan";

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: 'Lembar kerja berhasil diajukan untuk persetujuan',
                    toast: true,
                    position: 'top-end',
                    timer: 3000,
                    showConfirmButton: false
                });

            } catch(err){
                console.error(err);
                Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan!' });
            } finally {
                btnSubmitAktivasi.disabled = false;
            }

        });
    }

    // --- Tambah Tagihan ---
    if(formTambahTagihan){
        formTambahTagihan.addEventListener('submit', async function(e){
            e.preventDefault();

            const btnSubmit = formTambahTagihan.querySelector('button[type="submit"]');
            btnSubmit.disabled = true;

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
                    btnSubmit.disabled = false;
                    return;
                }

                if(res.ok){
                    formTambahTagihan.reset();
                    modalTagihan.hide();
                    updateFinancialCards(data.financial_data || {});

                    if(btnAjukan){
                        btnAjukan.innerHTML = '<i class="bx bx-dollar-sign me-1"></i> Penerimaan Pembayaran';
                        btnAjukan.classList.replace("btn-primary", "btn-success");
                        btnAjukan.dataset.status = "pembayaran";
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: data.message || 'Server error' });
                }

            } catch(err){
                console.error(err);
                Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan!' });
            } finally {
                btnSubmit.disabled = false;
            }

        });
    }

    // --- Batalkan Lembar Kerja ---
    const btnBatalkan = document.getElementById('btnBatalkan');
    if(btnBatalkan){
        btnBatalkan.addEventListener('click', function(){
            Swal.fire({
                title: 'Batalkan Lembar Kerja?',
                text: "Anda tidak dapat mengembalikan tindakan ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Batalkan!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if(result.isConfirmed){
                    Swal.fire('Dibatalkan!', 'Lembar kerja telah dibatalkan.', 'success');
                }
            });
        });
    }

    // --- Helper Function ---
    function updateFinancialCards(data){
        if(data.total_tagihan !== undefined) document.getElementById('badgeTotalTagihan').textContent = 'Rp ' + formatNumber(data.total_tagihan);
        if(data.total_dibayar !== undefined) document.getElementById('badgeTotalDibayar').textContent = 'Rp ' + formatNumber(data.total_dibayar);
        if(data.sisa_tagihan !== undefined) document.getElementById('badgeSisaTagihan').textContent = 'Rp ' + formatNumber(data.sisa_tagihan);
    }

    function formatNumber(number){
        return new Intl.NumberFormat('id-ID').format(number);
    }

});

</script>
@endpush
