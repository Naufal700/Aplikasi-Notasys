@extends('layouts.commonMaster')

@section('title', 'Tambah Klien')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card mb-4 shadow-sm">
        <div class="card-body">

            <h4 class="fw-bold py-3 mb-4">Klien Baru</h4>

            {{-- Nav Tabs --}}
            <ul class="nav nav-tabs mb-4" id="klienTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="tab-klien" data-bs-toggle="tab" data-bs-target="#klien" type="button" role="tab">Klien</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-lembar-kerja" data-bs-toggle="tab" data-bs-target="#lembarKerja" type="button" role="tab">Lembar Kerja</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="tab-keuangan" data-bs-toggle="tab" data-bs-target="#keuangan" type="button" role="tab">Keuangan</button>
                </li>
            </ul>

            <form action="{{ route('klien.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="tab-content" id="klienTabContent">

                    {{-- Tab Klien --}}
                    <div class="tab-pane fade show active" id="klien" role="tabpanel">
                        <h6 class="fw-semibold mb-3">Informasi Klien</h6>

                        {{-- Radio Tipe Klien --}}
                        <div class="mb-4">
                            <label class="form-label d-block fw-semibold">Tipe Klien</label>
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="tipe" id="pribadi" value="pribadi" autocomplete="off" {{ old('tipe','pribadi')=='pribadi'?'checked':'' }}>
                                <label class="btn btn-outline-primary" for="pribadi">Pribadi</label>

                                <input type="radio" class="btn-check" name="tipe" id="bank_leasing" value="bank_leasing" autocomplete="off" {{ old('tipe')=='bank_leasing'?'checked':'' }}>
                                <label class="btn btn-outline-primary" for="bank_leasing">Bank/Leasing</label>

                                <input type="radio" class="btn-check" name="tipe" id="perusahaan" value="perusahaan" autocomplete="off" {{ old('tipe')=='perusahaan'?'checked':'' }}>
                                <label class="btn btn-outline-primary" for="perusahaan">Perusahaan</label>
                            </div>
                        </div>

                        {{-- Bank/Leasing --}}
                        <div class="mb-3 row border rounded p-3 align-items-center" id="bankLeasingWrapper" style="display: none;">
                            <label class="form-label col-md-2 fw-semibold">Bank/Leasing</label>
                            <div class="col-md-4 d-flex gap-2 align-items-center">
                                <select name="bank_leasing_id" id="bank_leasing_id" class="form-select select2" data-placeholder="Cari Bank/Leasing">
    <option value=""></option>
    @foreach($bankLeasing as $bl)
        <option value="{{ $bl->id }}" {{ old('bank_leasing_id')==$bl->id ? 'selected' : '' }}>{{ $bl->nama_lembaga }}</option>
    @endforeach
</select>
                                <a href="#" id="editBankBtn" class="btn btn-outline-secondary btn-sm disabled">
                                    <i class="mdi mdi-pencil-outline"></i>
                                </a>
                            </div>
                        </div>

                        {{-- Perusahaan --}}
                        <div class="mb-3 row border rounded p-3 align-items-center" id="perusahaanWrapper" style="display: none;">
                            <label class="form-label col-md-2 fw-semibold">Perusahaan</label>
                            <div class="col-md-4 d-flex gap-2 align-items-center">
                                <select name="perusahaan_id" id="perusahaan_id" class="form-select select2" data-placeholder="Cari Perusahaan">
    <option value=""></option>
    @foreach($perusahaan as $p)
        <option value="{{ $p->id }}" {{ old('perusahaan_id')==$p->id ? 'selected' : '' }}>{{ $p->nama_lembaga }}</option>
    @endforeach
</select>
                                <a href="#" id="editPerusahaanBtn" class="btn btn-outline-secondary btn-sm disabled">
                                    <i class="mdi mdi-pencil-outline"></i>
                                </a>
                            </div>
                        </div>

                        {{-- Nama & Email --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="nama" class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                            </div>
                        </div>

                        {{-- NPWP & Status Perkawinan --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="npwp" class="form-label fw-semibold">No NPWP</label>
                                <input type="text" class="form-control" id="npwp" name="npwp" value="{{ old('npwp') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="status_perkawinan" class="form-label fw-semibold">Status Perkawinan</label>
                                <select name="status_perkawinan" id="status_perkawinan" class="form-select">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="belum_menikah" {{ old('status_perkawinan')=='belum_menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                    <option value="menikah" {{ old('status_perkawinan')=='menikah' ? 'selected' : '' }}>Menikah</option>
                                    <option value="cerai" {{ old('status_perkawinan')=='cerai' ? 'selected' : '' }}>Cerai</option>
                                </select>
                            </div>
                        </div>

                        {{-- Telepon & KTP --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="no_telepon" class="form-label fw-semibold">No Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="no_ktp" class="form-label fw-semibold">No KTP</label>
                                <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="{{ old('no_ktp') }}">
                            </div>
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="tgl_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}">
                            </div>
                        </div>

                        {{-- Alamat KTP --}}
                        <div class="mb-3 p-3 border rounded">
                            <h6 class="fw-semibold mb-3">Alamat KTP</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Provinsi</label>
                                    <select name="provinsi_id" id="provinsi_id" class="form-select select2" data-placeholder="Cari Provinsi">
                                        <option value=""></option>
                                        @foreach($provinsi as $p)
                                            <option value="{{ $p->id }}" {{ old('provinsi_id')==$p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Kabupaten</label>
                                    <select name="kabupaten_id" id="kabupaten_id" class="form-select select2" data-placeholder="Cari Kabupaten">
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <textarea name="alamat_ktp" class="form-control mt-2" placeholder="Alamat lengkap" rows="3">{{ old('alamat_ktp') }}</textarea>
                        </div>

                        {{-- Dokumen --}}
                        <h6 class="fw-semibold mb-3">Dokumen</h6>
                        <div id="dokumenWrapper"></div>
                        <button type="button" class="btn btn-outline-primary btn-sm mb-3" id="addDokumenBtn">
                            <i class="mdi mdi-plus me-1"></i> Tambah File
                        </button>

                        {{-- Catatan --}}
                        <h6 class="fw-semibold mb-3 mt-4">Catatan Tambahan</h6>
                        <textarea name="catatan" class="form-control mb-4" placeholder="Tambahan catatan" rows="3">{{ old('catatan') }}</textarea>
                    </div>

                    {{-- Tab Lembar Kerja --}}
                    <div class="tab-pane fade" id="lembarKerja" role="tabpanel">
                        <h6 class="fw-semibold mb-3">Lembar Kerja</h6>
                        <div id="lembarKerjaWrapper">
                            <div class="lembarKerjaRow mb-3 border rounded p-3">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Judul Pekerjaan</label>
                                        <input type="text" name="lembar_kerja[0][judul]" class="form-control">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold">Deadline</label>
                                        <input type="date" name="lembar_kerja[0][deadline]" class="form-control">
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <label class="form-label fw-semibold">Deskripsi</label>
                                    <textarea name="lembar_kerja[0][deskripsi]" class="form-control" rows="2"></textarea>
                                </div>
                                <button type="button" class="btn btn-danger btn-sm mt-2 removeLembarKerja">Hapus</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="addLembarKerja">
                            <i class="mdi mdi-plus me-1"></i> Tambah Lembar Kerja
                        </button>
                    </div>

                    {{-- Tab Keuangan --}}
                    <div class="tab-pane fade" id="keuangan" role="tabpanel">
                        <h6 class="fw-semibold mb-3">Keuangan</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Saldo Awal</label>
                                <input type="number" name="saldo_awal" class="form-control" placeholder="0" value="{{ old('saldo_awal') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Keterangan Keuangan</label>
                                <textarea name="keterangan_keuangan" class="form-control" rows="2">{{ old('keterangan_keuangan') }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Submit --}}
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-success"><i class="mdi mdi-content-save-outline me-1"></i> Simpan</button>
                    <a href="{{ route('klien.index') }}" class="btn btn-secondary">Batal</a>
                </div>

            </form>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function(){

    // ====== Select2 Alamat KTP ======
       // ====== Select2 & Load Kabupaten ======
   function initSelect2Scrollable(selector, placeholder){
    $(selector).select2({
        theme: 'bootstrap-5',
        placeholder: placeholder,
        width: '100%',
        dropdownParent: $(selector).closest('.card-body'),
        dropdownCssClass: 'select2-dropdown-custom'
    });
}

initSelect2Scrollable('#provinsi_id', 'Cari Provinsi');
initSelect2Scrollable('#kabupaten_id', 'Cari Kabupaten');

    // Load kabupaten berdasarkan provinsi
    function loadKabupaten(provinsiId = null, selectedId = null){
        $('#kabupaten_id').empty().append('<option value=""></option>');
        if(!provinsiId) return;
        $.get('{{ route("klien.getKabupaten") }}', {provinsi_id: provinsiId}, function(response){
            if(response.data){
                $.each(response.data, function(_, val){
                    let isSelected = (selectedId && selectedId == val.id);
                    let newOption = new Option(val.nama, val.id, false, isSelected);
                    $('#kabupaten_id').append(newOption);
                });
            }
            $('#kabupaten_id').trigger('change.select2');
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
        let html = `
        <div class="dokumenItem mb-2 border rounded p-2 d-flex gap-2 align-items-center">
            <input type="file" name="dokumen[${dokIndex}][file]" class="form-control" required>
            <input type="text" name="dokumen[${dokIndex}][jenis]" placeholder="Jenis Dokumen" class="form-control" required>
            <input type="text" name="dokumen[${dokIndex}][nama]" placeholder="Nama Dokumen" class="form-control" required>
            <input type="text" name="dokumen[${dokIndex}][catatan]" placeholder="Catatan" class="form-control">
            <button type="button" class="btn btn-danger btn-sm removeDokumen">Hapus</button>
        </div>`;
        $('#dokumenWrapper').append(html);
        dokIndex++;
    });
    $(document).on('click', '.removeDokumen', function(){
        $(this).closest('.dokumenItem').remove();
    });

    // ====== Lembar Kerja Dinamis ======
    let lwIndex = 1;
    $('#addLembarKerja').click(function(){
        let html = `<div class="lembarKerjaRow mb-3 border rounded p-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Judul Pekerjaan</label>
                    <input type="text" name="lembar_kerja[${lwIndex}][judul]" class="form-control">
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Deadline</label>
                    <input type="date" name="lembar_kerja[${lwIndex}][deadline]" class="form-control">
                </div>
            </div>
            <div class="mt-2">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="lembar_kerja[${lwIndex}][deskripsi]" class="form-control" rows="2"></textarea>
            </div>
            <button type="button" class="btn btn-danger btn-sm mt-2 removeLembarKerja">Hapus</button>
        </div>`;
        $('#lembarKerjaWrapper').append(html);
        lwIndex++;
    });
    $(document).on('click', '.removeLembarKerja', function(){
        $(this).closest('.lembarKerjaRow').remove();
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

    // ====== Tombol Edit Bank & Perusahaan (tab sama) ======
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
    // ====== Select2 Bank/Leasing & Perusahaan ======
function initSelect2WithScroll(selector, placeholder){
    $(selector).select2({
        theme: 'bootstrap-5',
        placeholder: placeholder,
        width: '100%',
        dropdownParent: $(selector).closest('.card-body'),
        // limit visible options, scrollable
        dropdownCssClass: "select2-dropdown-custom",
    });
}

initSelect2WithScroll('#bank_leasing_id', 'Cari Bank/Leasing');
initSelect2WithScroll('#perusahaan_id', 'Cari Perusahaan');


});
</script>
@endpush
