@extends('layouts.commonMaster')

@section('title', 'Data Klien')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card mb-4 shadow-sm">
        <div class="card-body">

            <h4 class="fw-bold py-3 mb-4">Data Klien</h4>

            {{-- Tombol trigger ubah data --}}
            <div class="mb-3">
                <button type="button" id="editTrigger" class="btn btn-outline-warning">
                    <i class="mdi mdi-pencil me-1"></i> Ubah Data
                </button>
            </div>

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

            <form action="{{ route('klien.update', $klien->id) }}" method="POST" enctype="multipart/form-data" id="klienForm">
                @csrf
                @method('PUT')
                <div class="tab-content" id="klienTabContent">

                    {{-- Tab Klien --}}
                    <div class="tab-pane fade show active" id="klien" role="tabpanel">
                        <h6 class="fw-semibold mb-3">Informasi Klien</h6>

                        {{-- Radio Tipe Klien --}}
                        <div class="mb-4">
                            <label class="form-label d-block fw-semibold">Tipe Klien</label>
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check editableField" name="tipe" id="pribadi" value="pribadi" autocomplete="off" {{ old('tipe', $klien->tipe)=='pribadi'?'checked':'' }} disabled>
                                <label class="btn btn-outline-primary" for="pribadi">Pribadi</label>

                                <input type="radio" class="btn-check editableField" name="tipe" id="bank_leasing" value="bank_leasing" autocomplete="off" {{ old('tipe', $klien->tipe)=='bank_leasing'?'checked':'' }} disabled>
                                <label class="btn btn-outline-primary" for="bank_leasing">Bank/Leasing</label>

                                <input type="radio" class="btn-check editableField" name="tipe" id="perusahaan" value="perusahaan" autocomplete="off" {{ old('tipe', $klien->tipe)=='perusahaan'?'checked':'' }} disabled>
                                <label class="btn btn-outline-primary" for="perusahaan">Perusahaan</label>
                            </div>
                        </div>

                        {{-- Bank/Leasing --}}
                        <div class="mb-3 row border rounded p-3" id="bankLeasingWrapper" style="display: none;">
                            <label class="form-label col-md-2 fw-semibold">Bank/Leasing</label>
                            <div class="col-md-4">
                                <select name="bank_leasing_id" id="bank_leasing_id" class="form-select editableField" disabled>
                                    <option value="">-- Pilih Bank/Leasing --</option>
                                    @foreach($bankLeasing as $bl)
                                        <option value="{{ $bl->id }}" {{ old('bank_leasing_id', $klien->bank_leasing_id)==$bl->id ? 'selected' : '' }}>{{ $bl->nama_lembaga }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Perusahaan --}}
                        <div class="mb-3 row border rounded p-3" id="perusahaanWrapper" style="display: none;">
                            <label class="form-label col-md-2 fw-semibold">Perusahaan</label>
                            <div class="col-md-4">
                                <select name="perusahaan_id" id="perusahaan_id" class="form-select editableField" disabled>
                                    <option value="">-- Pilih Perusahaan --</option>
                                    @foreach($perusahaan as $p)
                                        <option value="{{ $p->id }}" {{ old('perusahaan_id', $klien->perusahaan_id)==$p->id ? 'selected' : '' }}>{{ $p->nama_lembaga }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Nama & Email --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="nama" class="form-label fw-semibold">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control editableField" id="nama" name="nama" value="{{ old('nama', $klien->nama) }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email</label>
                                <input type="email" class="form-control editableField" id="email" name="email" value="{{ old('email', $klien->email) }}" readonly>
                            </div>
                        </div>

                        {{-- NPWP & Status Perkawinan --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="npwp" class="form-label fw-semibold">No NPWP</label>
                                <input type="text" class="form-control editableField" id="npwp" name="npwp" value="{{ old('npwp', $klien->npwp) }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="status_perkawinan" class="form-label fw-semibold">Status Perkawinan</label>
                                <select name="status_perkawinan" id="status_perkawinan" class="form-select editableField" disabled>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="belum_menikah" {{ old('status_perkawinan', $klien->status_perkawinan)=='belum_menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                    <option value="menikah" {{ old('status_perkawinan', $klien->status_perkawinan)=='menikah' ? 'selected' : '' }}>Menikah</option>
                                    <option value="cerai" {{ old('status_perkawinan', $klien->status_perkawinan)=='cerai' ? 'selected' : '' }}>Cerai</option>
                                </select>
                            </div>
                        </div>

                        {{-- Telepon & KTP --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="no_telepon" class="form-label fw-semibold">No Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control editableField" id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $klien->no_telepon) }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label for="no_ktp" class="form-label fw-semibold">No KTP</label>
                                <input type="text" class="form-control editableField" id="no_ktp" name="no_ktp" value="{{ old('no_ktp', $klien->no_ktp) }}" readonly>
                            </div>
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="tgl_lahir" class="form-label fw-semibold">Tanggal Lahir</label>
                                <input type="date" class="form-control editableField" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir', $klien->tgl_lahir?->format('Y-m-d')) }}" readonly>
                            </div>
                        </div>

                        {{-- Alamat KTP --}}
                        <div class="mb-3 p-3 border rounded">
                            <h6 class="fw-semibold mb-3">Alamat KTP</h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Provinsi</label>
                                    <select name="provinsi_id" id="provinsi_id" class="form-select select2 editableField" data-placeholder="Cari Provinsi" disabled>
                                        <option value=""></option>
                                        @foreach($provinsi as $p)
                                            <option value="{{ $p->id }}" {{ old('provinsi_id', $klien->provinsi_id)==$p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Kabupaten</label>
                                    <select name="kabupaten_id" id="kabupaten_id" class="form-select select2 editableField" data-placeholder="Cari Kabupaten" disabled>
                                        <option value=""></option>
                                    </select>
                                </div>
                            </div>
                            <textarea name="alamat_ktp" class="form-control editableField mt-2" placeholder="Alamat lengkap" rows="3" readonly>{{ old('alamat_ktp', $klien->alamat_ktp) }}</textarea>
                        </div>

                        {{-- Dokumen --}}
                        <h6 class="fw-semibold mb-3">Dokumen</h6>
                        <div id="dokumenWrapper">
                            @if($klien->dokumen)
                                @foreach($klien->dokumen as $i => $dok)
                                <div class="dokumenItem mb-2 border rounded p-2 d-flex gap-2 align-items-center">
                                    <input type="file" name="dokumen[{{ $i }}][file]" class="form-control editableField" disabled>
                                    <input type="text" name="dokumen[{{ $i }}][jenis]" value="{{ $dok->jenis }}" class="form-control editableField" required readonly>
                                    <input type="text" name="dokumen[{{ $i }}][nama]" value="{{ $dok->nama }}" class="form-control editableField" required readonly>
                                    <input type="text" name="dokumen[{{ $i }}][catatan]" value="{{ $dok->catatan }}" class="form-control editableField" readonly>
                                    <button type="button" class="btn btn-danger btn-sm removeDokumen editableField" disabled>Hapus</button>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm editableField" id="addDokumenBtn" disabled>
                            <i class="mdi mdi-plus me-1"></i> Tambah File
                        </button>

                        {{-- Catatan --}}
                        <h6 class="fw-semibold mb-3 mt-4">Catatan Tambahan</h6>
                        <textarea name="catatan" class="form-control editableField mb-4" placeholder="Tambahan catatan" rows="3" readonly>{{ old('catatan', $klien->catatan) }}</textarea>
                    </div>

                    {{-- Tab Lembar Kerja --}}
                    <div class="tab-pane fade" id="lembarKerja" role="tabpanel">
                        <h6 class="fw-semibold mb-3">Lembar Kerja</h6>
                        <div id="lembarKerjaWrapper">
                            @if($klien->lembarKerja)
                                @foreach($klien->lembarKerja as $i => $lw)
                                <div class="lembarKerjaRow mb-3 border rounded p-3">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Judul Pekerjaan</label>
                                            <input type="text" name="lembar_kerja[{{ $i }}][judul]" class="form-control editableField" value="{{ $lw->judul }}" readonly>
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold">Deadline</label>
                                            <input type="date" name="lembar_kerja[{{ $i }}][deadline]" class="form-control editableField" value="{{ $lw->deadline?->format('Y-m-d') }}" readonly>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <label class="form-label fw-semibold">Deskripsi</label>
                                        <textarea name="lembar_kerja[{{ $i }}][deskripsi]" class="form-control editableField" rows="2" readonly>{{ $lw->deskripsi }}</textarea>
                                    </div>
                                    <button type="button" class="btn btn-danger btn-sm mt-2 removeLembarKerja editableField" disabled>Hapus</button>
                                </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm editableField" id="addLembarKerja" disabled>
                            <i class="mdi mdi-plus me-1"></i> Tambah Lembar Kerja
                        </button>
                    </div>

                    {{-- Tab Keuangan --}}
                    <div class="tab-pane fade" id="keuangan" role="tabpanel">
                        <h6 class="fw-semibold mb-3">Keuangan</h6>
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Saldo Awal</label>
                                <input type="number" name="saldo_awal" class="form-control editableField" placeholder="0" value="{{ old('saldo_awal', $klien->saldo_awal) }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Keterangan Keuangan</label>
                                <textarea name="keterangan_keuangan" class="form-control editableField" rows="2" readonly>{{ old('keterangan_keuangan', $klien->keterangan_keuangan) }}</textarea>
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Submit --}}
                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-success editableField" disabled><i class="mdi mdi-content-save-outline me-1"></i> Simpan</button>
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

    // ====== Select2 & Load Kabupaten ======
    function initSelect2(selector, placeholder){
        $(selector).select2({
            theme: 'bootstrap-5',
            placeholder: placeholder,
            width: '100%',
            dropdownParent: $(selector).closest('.form-group, .card-body')
        });
    }

    initSelect2('#provinsi_id', 'Cari Provinsi');
    initSelect2('#kabupaten_id', 'Cari Kabupaten');

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

    @if(old('provinsi_id', $klien->provinsi_id))
        loadKabupaten({{ old('provinsi_id', $klien->provinsi_id) }}, {{ old('kabupaten_id', $klien->kabupaten_id) ?? 'null' }});
    @endif

    // ====== Dokumen Dinamis ======
    let dokIndex = {{ $klien->dokumen ? count($klien->dokumen) : 0 }};
    $('#addDokumenBtn').click(function(){
        let html = `
        <div class="dokumenItem mb-2 border rounded p-2 d-flex gap-2 align-items-center">
            <input type="file" name="dokumen[${dokIndex}][file]" class="form-control editableField" required>
            <input type="text" name="dokumen[${dokIndex}][jenis]" placeholder="Jenis Dokumen" class="form-control editableField" required>
            <input type="text" name="dokumen[${dokIndex}][nama]" placeholder="Nama Dokumen" class="form-control editableField" required>
            <input type="text" name="dokumen[${dokIndex}][catatan]" placeholder="Catatan" class="form-control editableField">
            <button type="button" class="btn btn-danger btn-sm removeDokumen editableField">Hapus</button>
        </div>`;
        $('#dokumenWrapper').append(html);
        dokIndex++;
    });

    $(document).on('click', '.removeDokumen', function(){
        $(this).closest('.dokumenItem').remove();
    });

    // ====== Lembar Kerja Dinamis ======
    let lwIndex = {{ $klien->lembarKerja ? count($klien->lembarKerja) : 0 }};
    $('#addLembarKerja').click(function(){
        let html = `
        <div class="lembarKerjaRow mb-3 border rounded p-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Judul Pekerjaan</label>
                    <input type="text" name="lembar_kerja[${lwIndex}][judul]" class="form-control editableField" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Deadline</label>
                    <input type="date" name="lembar_kerja[${lwIndex}][deadline]" class="form-control editableField" required>
                </div>
            </div>
            <div class="mt-2">
                <label class="form-label fw-semibold">Deskripsi</label>
                <textarea name="lembar_kerja[${lwIndex}][deskripsi]" class="form-control editableField" rows="2" required></textarea>
            </div>
            <button type="button" class="btn btn-danger btn-sm mt-2 removeLembarKerja editableField">Hapus</button>
        </div>`;
        $('#lembarKerjaWrapper').append(html);
        lwIndex++;
    });

    $(document).on('click', '.removeLembarKerja', function(){
        $(this).closest('.lembarKerjaRow').remove();
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
        $(this).prop('disabled', true);
    });

});
</script>
@endpush
