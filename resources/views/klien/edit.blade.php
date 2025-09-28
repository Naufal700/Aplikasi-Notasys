@extends('layouts.commonMaster')

@section('title', 'Data Klien')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Data Klien - {{ $klien->nama }}</h4>
                
            </div>
        </div>
        
        <div class="card-body">

            {{-- Tombol trigger ubah data --}}
            <div class="mb-4 text-end">
                <button type="button" id="editTrigger" class="btn btn-warning">
                    <i class="mdi mdi-pencil me-1"></i> Ubah Data
                </button>
            </div>

            {{-- Nav Tabs --}}
            <ul class="nav nav-tabs mb-4" id="klienTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab-klien" data-bs-toggle="tab" data-bs-target="#klien" type="button" role="tab">
                        <i class="mdi mdi-account-outline me-1"></i> Informasi Klien
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-lembar-kerja" data-bs-toggle="tab" data-bs-target="#lembarKerja" type="button" role="tab">
                        <i class="mdi mdi-clipboard-text-outline me-1"></i> Lembar Kerja
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-keuangan" data-bs-toggle="tab" data-bs-target="#keuangan" type="button" role="tab">
                        <i class="mdi mdi-cash-multiple me-1"></i> Keuangan
                    </button>
                </li>
            </ul>

            <form action="{{ route('klien.update', $klien->id) }}" method="POST" enctype="multipart/form-data" id="klienForm">
                @csrf
                @method('PUT')
                <div class="tab-content" id="klienTabContent">

                    {{-- Tab Klien --}}
                    <div class="tab-pane fade show active" id="klien" role="tabpanel">
                        
                        {{-- Tipe Klien --}}
                        <div class="card mb-4">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0 fw-semibold">Tipe Klien</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <div class="btn-group w-100" role="group">
                                        <input type="radio" class="btn-check editableField" name="tipe" id="pribadi" value="pribadi" autocomplete="off" {{ old('tipe', $klien->tipe)=='pribadi'?'checked':'' }} disabled>
                                        <label class="btn btn-outline-primary" for="pribadi">
                                            <i class="mdi mdi-account-outline me-1"></i> Pribadi
                                        </label>

                                        <input type="radio" class="btn-check editableField" name="tipe" id="bank_leasing" value="bank_leasing" autocomplete="off" {{ old('tipe', $klien->tipe)=='bank_leasing'?'checked':'' }} disabled>
                                        <label class="btn btn-outline-primary" for="bank_leasing">
                                            <i class="mdi mdi-bank me-1"></i> Bank/Leasing
                                        </label>

                                        <input type="radio" class="btn-check editableField" name="tipe" id="perusahaan" value="perusahaan" autocomplete="off" {{ old('tipe', $klien->tipe)=='perusahaan'?'checked':'' }} disabled>
                                        <label class="btn btn-outline-primary" for="perusahaan">
                                            <i class="mdi mdi-office-building me-1"></i> Perusahaan
                                        </label>
                                    </div>
                                </div>
                                
                                {{-- Bank/Leasing --}}
                                <div class="mb-3" id="bankLeasingWrapper" style="display: none;">
                                    <label class="form-label fw-semibold">Bank/Leasing</label>
                                    <div class="d-flex gap-2 align-items-center">
                                        <select name="bank_leasing_id" id="bank_leasing_id" class="form-select select2-bank editableField" style="width: 300px;" data-placeholder="Pilih Bank/Leasing" disabled>
                                            <option value=""></option>
                                            @foreach($bankLeasing as $bl)
                                                <option value="{{ $bl->id }}" {{ old('bank_leasing_id', $klien->bank_leasing_id)==$bl->id ? 'selected' : '' }}>{{ $bl->nama_lembaga }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                {{-- Perusahaan --}}
                                <div class="mb-3" id="perusahaanWrapper" style="display: none;">
                                    <label class="form-label fw-semibold">Perusahaan</label>
                                    <div class="d-flex gap-2 align-items-center">
                                        <select name="perusahaan_id" id="perusahaan_id" class="form-select select2-perusahaan editableField" style="width: 300px;" data-placeholder="Pilih Perusahaan" disabled>
                                            <option value=""></option>
                                            @foreach($perusahaan as $p)
                                                <option value="{{ $p->id }}" {{ old('perusahaan_id', $klien->perusahaan_id)==$p->id ? 'selected' : '' }}>{{ $p->nama_lembaga }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Informasi Pribadi --}}
                        <div class="card mb-4">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0 fw-semibold">Informasi Pribadi</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="nama" class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control editableField" id="nama" name="nama" value="{{ old('nama', $klien->nama) }}" readonly style="max-width: 600px;">
                                            <div class="form-text">Nama lengkap klien</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label fw-semibold">Email</label>
                                            <input type="email" class="form-control editableField" id="email" name="email" value="{{ old('email', $klien->email) }}" readonly style="max-width: 600px;">
                                            <div class="form-text">Contoh: nama@example.com</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_telepon" class="form-label fw-semibold">No Telepon <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control editableField" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $klien->no_telepon) }}" readonly style="max-width: 600px;">
                                            <div class="form-text">Contoh: 081234567890</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_ktp" class="form-label fw-semibold">No KTP</label>
                                            <input type="text" class="form-control editableField" id="no_ktp" name="no_ktp" value="{{ old('no_ktp', $klien->no_ktp) }}" readonly style="max-width: 600px;">
                                            <div class="form-text">16 digit nomor KTP</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="npwp" class="form-label fw-semibold">No NPWP</label>
                                            <input type="text" class="form-control editableField" id="npwp" name="npwp" value="{{ old('npwp', $klien->npwp) }}" readonly style="max-width: 600px;">
                                            <div class="form-text">15 digit nomor NPWP</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status_perkawinan" class="form-label fw-semibold">Status Perkawinan</label>
                                            <select name="status_perkawinan" id="status_perkawinan" class="form-select editableField" style="max-width: 600px;" disabled>
                                                <option value="">-- Pilih Status --</option>
                                                <option value="belum_menikah" {{ old('status_perkawinan', $klien->status_perkawinan)=='belum_menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                                <option value="menikah" {{ old('status_perkawinan', $klien->status_perkawinan)=='menikah' ? 'selected' : '' }}>Menikah</option>
                                                <option value="cerai" {{ old('status_perkawinan', $klien->status_perkawinan)=='cerai' ? 'selected' : '' }}>Cerai</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tgl_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                                            <input type="date" class="form-control editableField" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir', $klien->tgl_lahir?->format('Y-m-d')) }}" readonly style="max-width: 250px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Alamat KTP --}}
                        <div class="card mb-4">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0 fw-semibold">Alamat KTP</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label fw-semibold">Provinsi</label>
                                            <select name="provinsi_id" id="provinsi_id" class="form-select select2-provinsi editableField" style="width: 300px;" data-placeholder="Pilih Provinsi" disabled>
                                                <option value=""></option>
                                                @foreach($provinsi as $p)
                                                    <option value="{{ $p->id }}" {{ old('provinsi_id', $klien->provinsi_id)==$p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label fw-semibold">Kabupaten/Kota</label>
                                            <select name="kabupaten_id" id="kabupaten_id" class="form-select select2-kabupaten editableField" style="width: 300px;" data-placeholder="Pilih Kabupaten/Kota" disabled>
                                                <option value=""></option>
                                            @if($klien->kabupaten)
                                                <option value="{{ $klien->kabupaten_id }}" selected>{{ $klien->kabupaten->nama }}</option>
                                            @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">Alamat Lengkap</label>
                                        <textarea name="alamat_ktp" class="form-control editableField" placeholder="Masukkan alamat lengkap sesuai KTP" rows="3" readonly style="max-width: 1200px;">{{ old('alamat_ktp', $klien->alamat_ktp) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Dokumen --}}
                        <div class="card mb-4">
                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-semibold">Dokumen</h6>
                                <button type="button" class="btn btn-outline-primary btn-sm editableField" id="addDokumenBtn" disabled>
                                    <i class="mdi mdi-plus me-1"></i> Tambah File
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="dokumenWrapper">
                                    @if($klien->dokumen && count($klien->dokumen) > 0)
                                        @foreach($klien->dokumen as $i => $dok)
                                        <div class="dokumenItem mb-3 border rounded p-3">
                                            <div class="row g-3">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label fw-semibold">File Dokumen</label>
                                                        <input type="file" name="dokumen[{{ $i }}][file]" class="form-control editableField" disabled style="max-width: 300px;">
                                                        <div class="form-text">File saat ini: {{ $dok->nama }}</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label fw-semibold">Jenis Dokumen</label>
                                                        <input type="text" name="dokumen[{{ $i }}][jenis]" value="{{ $dok->jenis }}" class="form-control editableField" required readonly style="max-width: 200px;">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label fw-semibold">Nama Dokumen</label>
                                                        <input type="text" name="dokumen[{{ $i }}][nama]" value="{{ $dok->nama }}" class="form-control editableField" required readonly style="max-width: 200px;">
                                                    </div>
                                                </div>
                                                <div class="col-md-2 d-flex align-items-end">
                                                    <button type="button" class="btn btn-danger btn-sm w-100 removeDokumen editableField" disabled>
                                                        <i class="mdi mdi-delete-outline me-1"></i> Hapus
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold">Catatan</label>
                                                    <input type="text" name="dokumen[{{ $i }}][catatan]" value="{{ $dok->catatan }}" class="form-control editableField" readonly style="max-width: 600px;">
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-info">
                                            <small><i class="mdi mdi-information-outline me-1"></i> Belum ada dokumen yang diupload</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Catatan --}}
                        <div class="card mb-4">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0 fw-semibold">Catatan Tambahan</h6>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <textarea name="catatan" class="form-control editableField" placeholder="Tambahkan catatan khusus tentang klien ini" rows="3" readonly style="max-width: 1200px;">{{ old('catatan', $klien->catatan) }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tab Lembar Kerja --}}
                    <div class="tab-pane fade" id="lembarKerja" role="tabpanel">
                        <div class="card">
                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-semibold">Lembar Kerja</h6>
                                <button type="button" class="btn btn-outline-primary btn-sm editableField" id="addLembarKerja" disabled>
                                    <i class="mdi mdi-plus me-1"></i> Tambah Lembar Kerja
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="lembarKerjaWrapper">
                                    @if($klien->lembarKerja && count($klien->lembarKerja) > 0)
                                        @foreach($klien->lembarKerja as $i => $lw)
                                        <div class="lembarKerjaRow mb-3 border rounded p-3 bg-light">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label fw-semibold">Judul Pekerjaan</label>
                                                        <input type="text" name="lembar_kerja[{{ $i }}][judul]" class="form-control editableField" value="{{ $lw->judul }}" readonly style="max-width: 600px;">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label fw-semibold">Deadline</label>
                                                        <input type="date" name="lembar_kerja[{{ $i }}][deadline]" class="form-control editableField" value="{{ $lw->deadline?->format('Y-m-d') }}" readonly style="max-width: 250px;">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold">Deskripsi</label>
                                                    <textarea name="lembar_kerja[{{ $i }}][deskripsi]" class="form-control editableField" rows="2" readonly style="max-width: 600px;">{{ $lw->deskripsi }}</textarea>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-danger btn-sm mt-2 removeLembarKerja editableField" disabled>
                                                <i class="mdi mdi-delete-outline me-1"></i> Hapus
                                            </button>
                                        </div>
                                        @endforeach
                                    @else
                                        <div class="alert alert-info">
                                            <small><i class="mdi mdi-information-outline me-1"></i> Belum ada lembar kerja</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tab Keuangan --}}
                    <div class="tab-pane fade" id="keuangan" role="tabpanel">
                        <div class="card">
                            <div class="card-header bg-light py-2">
                                <h6 class="mb-0 fw-semibold">Informasi Keuangan</h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label fw-semibold">Saldo Awal</label>
                                            <div class="input-group" style="max-width: 300px;">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" name="saldo_awal" class="form-control editableField" placeholder="0" value="{{ old('saldo_awal', $klien->saldo_awal) }}" readonly>
                                            </div>
                                            <div class="form-text">Saldo awal klien dalam Rupiah</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label fw-semibold">Keterangan Keuangan</label>
                                            <textarea name="keterangan_keuangan" class="form-control editableField" placeholder="Catatan khusus terkait keuangan klien" rows="3" readonly style="max-width: 600px;">{{ old('keterangan_keuangan', $klien->keterangan_keuangan) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Submit --}}
                <div class="mt-4 d-flex gap-2 border-top pt-3">
                    <a href="{{ route('klien.index') }}" class="btn btn-outline-secondary">
                        <i class="mdi mdi-arrow-left me-1"></i> Kembali ke Daftar Klien
                    </a>
                    <button type="submit" class="btn btn-success editableField" disabled>
                        <i class="mdi mdi-content-save-outline me-1"></i> Simpan Perubahan
                    </button>
                    {{-- <a href="{{ route('klien.index') }}" class="btn btn-outline-secondary">Batal</a> --}}
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

@push('styles')
<style>
/* Fix untuk dropdown Select2 */
.select2-container {
    z-index: 9999 !important;
}

.select2-dropdown {
    z-index: 9999 !important;
}

/* Pastikan parent container tidak menghalangi */
.card-body {
    position: relative;
    overflow: visible !important;
}

/* Style untuk form groups */
.form-group {
    margin-bottom: 1rem;
}

/* Lebar input yang lebih optimal */
.form-control, .form-select {
    max-width: 100%;
}

/* Style khusus untuk Select2 dengan width tetap */
.select2-bank, .select2-perusahaan, .select2-provinsi, .select2-kabupaten {
    min-width: 250px;
}

/* Responsive design */
@media (max-width: 768px) {
    .select2-bank, .select2-perusahaan, .select2-provinsi, .select2-kabupaten {
        width: 100% !important;
        max-width: 100% !important;
    }
    
    .form-control, .form-select {
        max-width: 100% !important;
    }
}

.card-header.bg-light {
    background-color: #f8f9fa !important;
}

.lembarKerjaRow, .dokumenItem {
    transition: all 0.3s ease;
}

.lembarKerjaRow:hover, .dokumenItem:hover {
    background-color: #f8f9fa;
}

.form-text {
    font-size: 0.8rem;
    color: #6c757d;
}

/* Style untuk mode baca */
.editableField[readonly], .editableField:disabled {
    background-color: #f8f9fa;
    border-color: #e9ecef;
    color: #6c757d;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function(){
    // ====== Inisialisasi Select2 dengan Fix untuk Dropdown ======
    function initSelect2Fixed(selector, placeholder, width = '300px') {
        $(selector).select2({
            theme: 'bootstrap-5',
            placeholder: placeholder,
            width: width,
            dropdownParent: $(document.body), // Gunakan body sebagai parent untuk menghindari overflow issues
            dropdownCssClass: 'select2-dropdown-custom',
            containerCssClass: 'select2-container-custom'
        });
    }

    // Inisialisasi semua Select2
    initSelect2Fixed('#bank_leasing_id', 'Pilih Bank/Leasing', '300px');
    initSelect2Fixed('#perusahaan_id', 'Pilih Perusahaan', '300px');
    initSelect2Fixed('#provinsi_id', 'Pilih Provinsi', '300px');
    initSelect2Fixed('#kabupaten_id', 'Pilih Kabupaten/Kota', '300px');

    // Load kabupaten berdasarkan provinsi
    function loadKabupaten(provinsiId = null, selectedId = null){
        $('#kabupaten_id').empty().append('<option value=""></option>');
        if(!provinsiId) return;
        
        // Show loading
        $('#kabupaten_id').prop('disabled', true).html('<option value="">Memuat...</option>');
        
        $.get('{{ route("klien.getKabupaten") }}', {provinsi_id: provinsiId}, function(response){
            if(response.data){
                $('#kabupaten_id').empty().append('<option value=""></option>');
                $.each(response.data, function(_, val){
                    let isSelected = (selectedId && selectedId == val.id);
                    let newOption = new Option(val.nama, val.id, false, isSelected);
                    $('#kabupaten_id').append(newOption);
                });
            }
            $('#kabupaten_id').prop('disabled', false).trigger('change.select2');
        }).fail(function() {
            $('#kabupaten_id').prop('disabled', false).html('<option value="">Error memuat data</option>');
        });
    }
    
    $('#provinsi_id').on('change', function(){ 
        loadKabupaten($(this).val());
    });
    
    @if(old('provinsi_id', $klien->provinsi_id))
        loadKabupaten({{ old('provinsi_id', $klien->provinsi_id) }}, {{ old('kabupaten_id', $klien->kabupaten_id) ?? 'null' }});
    @endif

    // ====== Dokumen Dinamis ======
    let dokIndex = {{ $klien->dokumen ? count($klien->dokumen) : 0 }};
    $('#addDokumenBtn').click(function(){
        // Remove info alert if exists
        $('#dokumenWrapper .alert').remove();
        
        let html = `
        <div class="dokumenItem mb-3 border rounded p-3">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label fw-semibold">File Dokumen</label>
                        <input type="file" name="dokumen[${dokIndex}][file]" class="form-control editableField" required style="max-width: 300px;">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label fw-semibold">Jenis Dokumen</label>
                        <input type="text" name="dokumen[${dokIndex}][jenis]" placeholder="Contoh: KTP, NPWP" class="form-control editableField" required style="max-width: 200px;">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label fw-semibold">Nama Dokumen</label>
                        <input type="text" name="dokumen[${dokIndex}][nama]" placeholder="Nama dokumen" class="form-control editableField" required style="max-width: 200px;">
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm w-100 removeDokumen editableField">
                        <i class="mdi mdi-delete-outline me-1"></i> Hapus
                    </button>
                </div>
            </div>
            <div class="mt-2">
                <div class="form-group">
                    <label class="form-label fw-semibold">Catatan</label>
                    <input type="text" name="dokumen[${dokIndex}][catatan]" placeholder="Catatan tambahan" class="form-control editableField" style="max-width: 600px;">
                </div>
            </div>
        </div>`;
        $('#dokumenWrapper').append(html);
        dokIndex++;
    });
    
    $(document).on('click', '.removeDokumen', function(){
        $(this).closest('.dokumenItem').remove();
        // Show info alert if no dokumen items
        if($('#dokumenWrapper .dokumenItem').length === 0) {
            $('#dokumenWrapper').html('<div class="alert alert-info"><small><i class="mdi mdi-information-outline me-1"></i> Belum ada dokumen yang diupload</small></div>');
        }
    });

    // ====== Lembar Kerja Dinamis ======
    let lwIndex = {{ $klien->lembarKerja ? count($klien->lembarKerja) : 0 }};
    $('#addLembarKerja').click(function(){
        // Remove info alert if exists
        $('#lembarKerjaWrapper .alert').remove();
        
        let html = `<div class="lembarKerjaRow mb-3 border rounded p-3 bg-light">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-semibold">Judul Pekerjaan</label>
                        <input type="text" name="lembar_kerja[${lwIndex}][judul]" class="form-control editableField" placeholder="Masukkan judul pekerjaan" style="max-width: 600px;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-semibold">Deadline</label>
                        <input type="date" name="lembar_kerja[${lwIndex}][deadline]" class="form-control editableField" style="max-width: 250px;">
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <div class="form-group">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="lembar_kerja[${lwIndex}][deskripsi]" class="form-control editableField" placeholder="Deskripsi detail pekerjaan" rows="2" style="max-width: 600px;"></textarea>
                </div>
            </div>
            <button type="button" class="btn btn-danger btn-sm mt-2 removeLembarKerja editableField">
                <i class="mdi mdi-delete-outline me-1"></i> Hapus
            </button>
        </div>`;
        $('#lembarKerjaWrapper').append(html);
        lwIndex++;
    });
    
    $(document).on('click', '.removeLembarKerja', function(){
        $(this).closest('.lembarKerjaRow').remove();
        // Show info alert if no lembar kerja items
        if($('#lembarKerjaWrapper .lembarKerjaRow').length === 0) {
            $('#lembarKerjaWrapper').html('<div class="alert alert-info"><small><i class="mdi mdi-information-outline me-1"></i> Belum ada lembar kerja</small></div>');
        }
    });

    // ====== Toggle Bank/Perusahaan berdasarkan Tipe ======
    function toggleTipe(tipe){
        $('#bankLeasingWrapper, #perusahaanWrapper').hide();
        if(tipe == 'bank_leasing') $('#bankLeasingWrapper').show();
        if(tipe == 'perusahaan') $('#perusahaanWrapper').show();
    }

    $('input[name="tipe"]').on('change', function(){
        toggleTipe($(this).val());
    });

    toggleTipe($('input[name="tipe"]:checked').val());

    // ====== Tombol Ubah Data ======
    $('#editTrigger').on('click', function(){
        $('.editableField').prop('readonly', false);
        $('.editableField').prop('disabled', false);
        
        // Re-inisialisasi Select2 setelah enable
        $('#bank_leasing_id, #perusahaan_id, #provinsi_id, #kabupaten_id').trigger('change.select2');
        
        $(this).prop('disabled', true).html('<i class="mdi mdi-pencil me-1"></i> Mode Edit');
        
        // Focus ke field pertama
        $('#nama').focus();
    });

    // ====== Form Validation ======
    $('#klienForm').on('submit', function(e){
        // Basic validation
        let isValid = true;
        let errorMessage = '';
        
        // Check required fields
        if(!$('#nama').val().trim()) {
            isValid = false;
            errorMessage = 'Nama klien wajib diisi';
        } else if(!$('#no_telepon').val().trim()) {
            isValid = false;
            errorMessage = 'Nomor telepon wajib diisi';
        }
        
        if(!isValid) {
            e.preventDefault();
            alert('Error: ' + errorMessage);
            return false;
        }
        
        // Show loading state
        $('button[type="submit"]').prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin me-1"></i> Menyimpan...');
    });
});
</script>
@endpush