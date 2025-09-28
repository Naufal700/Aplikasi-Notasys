@extends('layouts.commonMaster')

@section('title', 'Tambah Klien')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-light">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Tambah Klien Baru</h4>
                           </div>
        </div>
        
        <div class="card-body">

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

            <form action="{{ route('klien.store') }}" method="POST" enctype="multipart/form-data" id="formKlien">
                @csrf
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
                                        <input type="radio" class="btn-check" name="tipe" id="pribadi" value="pribadi" autocomplete="off" {{ old('tipe','pribadi')=='pribadi'?'checked':'' }}>
                                        <label class="btn btn-outline-primary" for="pribadi">
                                            <i class="mdi mdi-account-outline me-1"></i> Pribadi
                                        </label>

                                        <input type="radio" class="btn-check" name="tipe" id="bank_leasing" value="bank_leasing" autocomplete="off" {{ old('tipe')=='bank_leasing'?'checked':'' }}>
                                        <label class="btn btn-outline-primary" for="bank_leasing">
                                            <i class="mdi mdi-bank me-1"></i> Bank/Leasing
                                        </label>

                                        <input type="radio" class="btn-check" name="tipe" id="perusahaan" value="perusahaan" autocomplete="off" {{ old('tipe')=='perusahaan'?'checked':'' }}>
                                        <label class="btn btn-outline-primary" for="perusahaan">
                                            <i class="mdi mdi-office-building me-1"></i> Perusahaan
                                        </label>
                                    </div>
                                </div>
                                
                                {{-- Bank/Leasing --}}
                                <div class="mb-3" id="bankLeasingWrapper" style="display: none;">
                                    <label class="form-label fw-semibold">Bank/Leasing</label>
                                    <div class="d-flex gap-2 align-items-center">
                                        <select name="bank_leasing_id" id="bank_leasing_id" class="form-select select2-bank" style="width: 300px;" data-placeholder="Pilih Bank/Leasing">
                                            <option value=""></option>
                                            @foreach($bankLeasing as $bl)
                                                <option value="{{ $bl->id }}" {{ old('bank_leasing_id')==$bl->id ? 'selected' : '' }}>{{ $bl->nama_lembaga }}</option>
                                            @endforeach
                                        </select>
                                        <a href="#" id="editBankBtn" class="btn btn-outline-secondary disabled">
                                            <i class="mdi mdi-pencil-outline"></i>
                                        </a>
                                    </div>
                                </div>

                                {{-- Perusahaan --}}
                                <div class="mb-3" id="perusahaanWrapper" style="display: none;">
                                    <label class="form-label fw-semibold">Perusahaan</label>
                                    <div class="d-flex gap-2 align-items-center">
                                        <select name="perusahaan_id" id="perusahaan_id" class="form-select select2-perusahaan" style="width: 300px;" data-placeholder="Pilih Perusahaan">
                                            <option value=""></option>
                                            @foreach($perusahaan as $p)
                                                <option value="{{ $p->id }}" {{ old('perusahaan_id')==$p->id ? 'selected' : '' }}>{{ $p->nama_lembaga }}</option>
                                            @endforeach
                                        </select>
                                        <a href="#" id="editPerusahaanBtn" class="btn btn-outline-secondary disabled">
                                            <i class="mdi mdi-pencil-outline"></i>
                                        </a>
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
                                            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required style="max-width: 600px;">
                                            <div class="form-text">Masukkan nama lengkap klien</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label fw-semibold">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" style="max-width: 600px;">
                                            <div class="form-text">Contoh: nama@example.com</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_telepon" class="form-label fw-semibold">No Telepon <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required style="max-width: 600px;">
                                            <div class="form-text">Contoh: 081234567890</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="no_ktp" class="form-label fw-semibold">No KTP</label>
                                            <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="{{ old('no_ktp') }}" style="max-width: 600px;">
                                            <div class="form-text">16 digit nomor KTP</div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="npwp" class="form-label fw-semibold">No NPWP</label>
                                            <input type="text" class="form-control" id="npwp" name="npwp" value="{{ old('npwp') }}" style="max-width: 600px;">
                                            <div class="form-text">15 digit nomor NPWP</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="status_perkawinan" class="form-label fw-semibold">Status Perkawinan</label>
                                            <select name="status_perkawinan" id="status_perkawinan" class="form-select" style="max-width: 600px;">
                                                <option value="">-- Pilih Status --</option>
                                                <option value="belum_menikah" {{ old('status_perkawinan')=='belum_menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                                <option value="menikah" {{ old('status_perkawinan')=='menikah' ? 'selected' : '' }}>Menikah</option>
                                                <option value="cerai" {{ old('status_perkawinan')=='cerai' ? 'selected' : '' }}>Cerai</option>
                                            </select>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="tgl_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}" style="max-width: 250px;">
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
                                            <select name="provinsi_id" id="provinsi_id" class="form-select select2-provinsi" style="width: 300px;" data-placeholder="Pilih Provinsi">
                                                <option value=""></option>
                                                @foreach($provinsi as $p)
                                                    <option value="{{ $p->id }}" {{ old('provinsi_id')==$p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label fw-semibold">Kabupaten/Kota</label>
                                            <select name="kabupaten_id" id="kabupaten_id" class="form-select select2-kabupaten" style="width: 300px;" data-placeholder="Pilih Kabupaten/Kota">
                                                <option value=""></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <div class="form-group">
                                        <label class="form-label fw-semibold">Alamat Lengkap</label>
                                        <textarea name="alamat_ktp" class="form-control" placeholder="Masukkan alamat lengkap sesuai KTP" rows="3" style="max-width: 1200px;">{{ old('alamat_ktp') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Dokumen --}}
                        <div class="card mb-4">
                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-semibold">Dokumen</h6>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="addDokumenBtn">
                                    <i class="mdi mdi-plus me-1"></i> Tambah File
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="dokumenWrapper">
                                    <div class="alert alert-info">
                                        <small><i class="mdi mdi-information-outline me-1"></i> Tambahkan dokumen pendukung seperti KTP, NPWP, atau dokumen lainnya</small>
                                    </div>
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
                                    <textarea name="catatan" class="form-control" placeholder="Tambahkan catatan khusus tentang klien ini" rows="3" style="max-width: 1200px;">{{ old('catatan') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tab Lembar Kerja --}}
                    <div class="tab-pane fade" id="lembarKerja" role="tabpanel">
                        <div class="card">
                            <div class="card-header bg-light py-2 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0 fw-semibold">Lembar Kerja</h6>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="addLembarKerja">
                                    <i class="mdi mdi-plus me-1"></i> Tambah Lembar Kerja
                                </button>
                            </div>
                            <div class="card-body">
                                <div id="lembarKerjaWrapper">
                                    <div class="alert alert-info mb-3">
                                        <small><i class="mdi mdi-information-outline me-1"></i> Tambahkan tugas atau pekerjaan yang perlu diselesaikan untuk klien ini</small>
                                    </div>
                                    <div class="lembarKerjaRow mb-3 border rounded p-3 bg-light">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold">Judul Pekerjaan</label>
                                                    <input type="text" name="lembar_kerja[0][judul]" class="form-control" placeholder="Masukkan judul pekerjaan" style="max-width: 600px;">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label fw-semibold">Deadline</label>
                                                    <input type="date" name="lembar_kerja[0][deadline]" class="form-control" style="max-width: 250px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <div class="form-group">
                                                <label class="form-label fw-semibold">Deskripsi</label>
                                                <textarea name="lembar_kerja[0][deskripsi]" class="form-control" placeholder="Deskripsi detail pekerjaan" rows="2" style="max-width: 600px;"></textarea>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-danger btn-sm mt-2 removeLembarKerja">
                                            <i class="mdi mdi-delete-outline me-1"></i> Hapus
                                        </button>
                                    </div>
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
                                                <input type="number" name="saldo_awal" class="form-control" placeholder="0" value="{{ old('saldo_awal') }}">
                                            </div>
                                            <div class="form-text">Saldo awal klien dalam Rupiah</div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="form-label fw-semibold">Keterangan Keuangan</label>
                                            <textarea name="keterangan_keuangan" class="form-control" placeholder="Catatan khusus terkait keuangan klien" rows="3" style="max-width: 600px;">{{ old('keterangan_keuangan') }}</textarea>
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
                    <button type="submit" class="btn btn-success" id="submitBtn">
                        <i class="mdi mdi-content-save-outline me-1"></i> Simpan Klien
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
    
    @if(old('provinsi_id'))
        loadKabupaten({{ old('provinsi_id') }}, {{ old('kabupaten_id') ?? 'null' }});
    @endif

    // ====== Dokumen Dinamis ======
    let dokIndex = 0;
    $('#addDokumenBtn').click(function(){
        // Remove info alert if exists
        $('#dokumenWrapper .alert').remove();
        
        let html = `
        <div class="dokumenItem mb-3 border rounded p-3">
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="form-label fw-semibold">File Dokumen</label>
                        <input type="file" name="dokumen[${dokIndex}][file]" class="form-control" required style="max-width: 300px;">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label fw-semibold">Jenis Dokumen</label>
                        <input type="text" name="dokumen[${dokIndex}][jenis]" placeholder="Contoh: KTP, NPWP" class="form-control" required style="max-width: 200px;">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="form-label fw-semibold">Nama Dokumen</label>
                        <input type="text" name="dokumen[${dokIndex}][nama]" placeholder="Nama dokumen" class="form-control" required style="max-width: 200px;">
                    </div>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm w-100 removeDokumen">
                        <i class="mdi mdi-delete-outline me-1"></i> Hapus
                    </button>
                </div>
            </div>
            <div class="mt-2">
                <div class="form-group">
                    <label class="form-label fw-semibold">Catatan</label>
                    <input type="text" name="dokumen[${dokIndex}][catatan]" placeholder="Catatan tambahan" class="form-control" style="max-width: 600px;">
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
            $('#dokumenWrapper').html('<div class="alert alert-info"><small><i class="mdi mdi-information-outline me-1"></i> Tambahkan dokumen pendukung seperti KTP, NPWP, atau dokumen lainnya</small></div>');
        }
    });

    // ====== Lembar Kerja Dinamis ======
    let lwIndex = 1;
    $('#addLembarKerja').click(function(){
        // Remove info alert if exists
        $('#lembarKerjaWrapper .alert').remove();
        
        let html = `<div class="lembarKerjaRow mb-3 border rounded p-3 bg-light">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-semibold">Judul Pekerjaan</label>
                        <input type="text" name="lembar_kerja[${lwIndex}][judul]" class="form-control" placeholder="Masukkan judul pekerjaan" style="max-width: 600px;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label fw-semibold">Deadline</label>
                        <input type="date" name="lembar_kerja[${lwIndex}][deadline]" class="form-control" style="max-width: 250px;">
                    </div>
                </div>
            </div>
            <div class="mt-2">
                <div class="form-group">
                    <label class="form-label fw-semibold">Deskripsi</label>
                    <textarea name="lembar_kerja[${lwIndex}][deskripsi]" class="form-control" placeholder="Deskripsi detail pekerjaan" rows="2" style="max-width: 600px;"></textarea>
                </div>
            </div>
            <button type="button" class="btn btn-danger btn-sm mt-2 removeLembarKerja">
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
            $('#lembarKerjaWrapper').html('<div class="alert alert-info mb-3"><small><i class="mdi mdi-information-outline me-1"></i> Tambahkan tugas atau pekerjaan yang perlu diselesaikan untuk klien ini</small></div>');
        }
    });

    // ====== Toggle input Bank/Leasing & Perusahaan ======
    function toggleTipeKlien(tipe){
        if(tipe === 'bank_leasing'){
            $('#bankLeasingWrapper').slideDown();
            $('#perusahaanWrapper').slideUp();
            $('#bank_leasing_id').attr('required', true);
            $('#perusahaan_id').attr('required', false).val('');
        } else if(tipe === 'perusahaan'){
            $('#perusahaanWrapper').slideDown();
            $('#bankLeasingWrapper').slideUp();
            $('#perusahaan_id').attr('required', true);
            $('#bank_leasing_id').attr('required', false).val('');
        } else {
            $('#bankLeasingWrapper').slideUp();
            $('#perusahaanWrapper').slideUp();
            $('#bank_leasing_id, #perusahaan_id').attr('required', false).val('');
        }
    }
    
    toggleTipeKlien($('input[name="tipe"]:checked').val());
    $('input[name="tipe"]').on('change', function(){
        toggleTipeKlien($(this).val());
    });

    // ====== Tombol Edit Bank & Perusahaan ======
    function updateEditLink(selectId, editBtnId, routePrefix){
        $(selectId).on('change', function(){
            let id = $(this).val();
            if(id){
                $(editBtnId).attr('href', '/' + routePrefix + '/' + id + '/edit').removeClass('disabled');
            } else {
                $(editBtnId).attr('href', '#').addClass('disabled');
            }
        }).trigger('change');
    }
    
    updateEditLink('#bank_leasing_id', '#editBankBtn', 'bank-leasing');
    updateEditLink('#perusahaan_id', '#editPerusahaanBtn', 'perusahaan');

    // ====== Form Validation & Submission ======
    $('#formKlien').on('submit', function(e){
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
            $('#submitBtn').prop('disabled', false).html('<i class="mdi mdi-content-save-outline me-1"></i> Simpan Klien');
            return false;
        }
        
        // Show loading state
        $('#submitBtn').prop('disabled', true).html('<i class="mdi mdi-loading mdi-spin me-1"></i> Menyimpan...');
    });
});
</script>
@endpush