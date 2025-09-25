@extends('layouts.commonMaster')

@section('title', 'Tambah Klien')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card mb-4 shadow-sm">
        <div class="card-body">

            <h4 class="fw-bold py-3 mb-4">Tambah Klien</h4>

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
                        <div class="mb-3">
                            <label class="form-label d-block">Tipe Klien</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipe" id="pribadi" value="pribadi" checked>
                                <label class="form-check-label" for="pribadi">Pribadi</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipe" id="bank-leasing" value="bank-leasing">
                                <label class="form-check-label" for="bank-leasing">Bank/Leasing</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="tipe" id="perusahaan" value="perusahaan">
                                <label class="form-check-label" for="perusahaan">Perusahaan</label>
                            </div>
                        </div>

                        {{-- Nama dan Email --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="nama" class="form-label">Nama <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                            </div>
                        </div>

                        {{-- NPWP, Status, Telepon --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-4">
                                <label for="npwp" class="form-label">No NPWP</label>
                                <input type="text" class="form-control" id="npwp" name="npwp" value="{{ old('npwp') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                                <select name="status_perkawinan" id="status_perkawinan" class="form-select">
                                    <option value="">-- Pilih Status --</option>
                                    <option value="belum_menikah" {{ old('status_perkawinan')=='belum_menikah' ? 'selected' : '' }}>Belum Menikah</option>
                                    <option value="menikah" {{ old('status_perkawinan')=='menikah' ? 'selected' : '' }}>Menikah</option>
                                    <option value="cerai" {{ old('status_perkawinan')=='cerai' ? 'selected' : '' }}>Cerai</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="no_telepon" class="form-label">No Telepon <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" required>
                            </div>
                        </div>

                        {{-- KTP, Tgl Lahir --}}
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label for="no_ktp" class="form-label">No KTP</label>
                                <input type="text" class="form-control" id="no_ktp" name="no_ktp" value="{{ old('no_ktp') }}">
                            </div>
                            <div class="col-md-6">
                                <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}">
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <h6 class="fw-semibold mb-3 mt-4">Alamat KTP</h6>
                        <div class="row g-3 mb-2">
                            <div class="col-md-4">
                                <select name="provinsi_id" id="provinsi_id" class="form-select select2">
                                    <option value="">-- Pilih Provinsi --</option>
                                    @foreach($provinsi as $p)
                                    <option value="{{ $p->id }}" {{ old('provinsi_id')==$p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="kabupaten_id" id="kabupaten_id" class="form-select select2">
                                    <option value="">-- Pilih Kabupaten --</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <select name="kota_id" id="kota_id" class="form-select select2">
                                    <option value="">-- Pilih Kota --</option>
                                </select>
                            </div>
                        </div>
                        <textarea name="alamat_ktp" class="form-control mb-3" placeholder="Alamat lengkap">{{ old('alamat_ktp') }}</textarea>

                        {{-- Dokumen --}}
                        <h6 class="fw-semibold mb-3">Dokumen</h6>
                        <div id="dokumenWrapper" class="mb-3">
                            <button type="button" class="btn btn-outline-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#dokumenModal">
                                <i class="mdi mdi-plus me-1"></i> Tambah File
                            </button>
                        </div>

                        {{-- Catatan --}}
                        <h6 class="fw-semibold mb-3 mt-4">Catatan Tambahan</h6>
                        <textarea name="catatan" class="form-control mb-4" placeholder="Tambahan catatan">{{ old('catatan') }}</textarea>
                    </div>

                    {{-- Tab Lembar Kerja --}}
                    <div class="tab-pane fade" id="lembarKerja" role="tabpanel">
                        <h6 class="fw-semibold mb-3">Lembar Kerja</h6>
                        <div id="lembarKerjaWrapper">
                            <div class="lembarKerjaRow mb-3 border rounded p-3">
                                <div class="mb-2">
                                    <label class="form-label">Judul Pekerjaan</label>
                                    <input type="text" name="lembar_kerja[0][judul]" class="form-control">
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Deskripsi</label>
                                    <textarea name="lembar_kerja[0][deskripsi]" class="form-control"></textarea>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Deadline</label>
                                    <input type="date" name="lembar_kerja[0][deadline]" class="form-control">
                                </div>
                                <button type="button" class="btn btn-danger btn-sm removeLembarKerja">Hapus</button>
                            </div>
                        </div>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="addLembarKerja"><i class="mdi mdi-plus me-1"></i> Tambah Lembar Kerja</button>
                    </div>

                    {{-- Tab Keuangan --}}
                    <div class="tab-pane fade" id="keuangan" role="tabpanel">
                        <h6 class="fw-semibold mb-3">Keuangan</h6>
                        <div class="mb-3">
                            <label class="form-label">Saldo Awal</label>
                            <input type="number" name="saldo_awal" class="form-control" placeholder="0" value="{{ old('saldo_awal') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keterangan Keuangan</label>
                            <textarea name="keterangan_keuangan" class="form-control">{{ old('keterangan_keuangan') }}</textarea>
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

{{-- Modal Dokumen --}}
<div class="modal fade" id="dokumenModal" tabindex="-1" aria-labelledby="dokumenModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <form id="formDokumen">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="dokumenModalLabel"><i class="mdi mdi-file-plus-outline me-1"></i> Tambah Dokumen</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Jenis Dokumen</label>
                        <input type="text" name="jenis_dokumen" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Dokumen</label>
                        <input type="text" name="nama_dokumen" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">File</label>
                        <input type="file" name="file_dokumen" class="form-control">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Catatan</label>
                        <textarea name="catatan_dokumen" class="form-control"></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" id="saveDokumenBtn" class="btn btn-primary"><i class="mdi mdi-check me-1"></i> Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            </div>
        </div>
    </form>
  </div>
</div>

@endsection

@push('scripts')
<script>
$(document).ready(function(){

    // Init select2
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%',
        placeholder: 'Pilih salah satu',
        allowClear: true
    });

    // Load kabupaten
    function loadKabupaten(provinsiId, selectedKab = null){
        $('#kabupaten_id').html('<option value="">-- Pilih Kabupaten --</option>').trigger('change.select2');
        $('#kota_id').html('<option value="">-- Pilih Kota --</option>').trigger('change.select2');

        $.get('{{ route("klien.kabupaten") }}', {provinsi_id: provinsiId}, function(response){
            console.log("Response kabupaten:", response);
            if(response.data){
                $.each(response.data, function(key, val){
                    let isSelected = selectedKab == val.id ? true : false;
                    let newOption = new Option(val.nama, val.id, isSelected, isSelected);
                    $('#kabupaten_id').append(newOption);
                });
            }
            $('#kabupaten_id').trigger('change.select2');
        });
    }

    // Load kota
    function loadKota(kabupatenId, selectedKota = null){
        $('#kota_id').html('<option value="">-- Pilih Kota --</option>').trigger('change.select2');

        $.get('{{ route("klien.kota") }}', {kabupaten_id: kabupatenId}, function(response){
            console.log("Response kota:", response);
            if(response.data){
                $.each(response.data, function(key, val){
                    let isSelected = selectedKota == val.id ? true : false;
                    let newOption = new Option(val.nama, val.id, isSelected, isSelected);
                    $('#kota_id').append(newOption);
                });
            }
            $('#kota_id').trigger('change.select2');
        });
    }

    // Event change
    $('#provinsi_id').on('change', function() {
        let provinsiId = $(this).val();
        loadKabupaten(provinsiId);
    });

    $('#kabupaten_id').on('change', function() {
        let kabupatenId = $(this).val();
        loadKota(kabupatenId);
    });

    // Init old value
    let oldProv = '{{ old("provinsi_id") ?? "" }}';
    let oldKab = '{{ old("kabupaten_id") ?? "" }}';
    let oldKota = '{{ old("kota_id") ?? "" }}';

    if(oldProv){
        loadKabupaten(oldProv, oldKab);
        if(oldKab){
            loadKota(oldKab, oldKota);
        }
    }

    // ====== Dokumen ======
    $('#saveDokumenBtn').click(function(){
        let jenis = $('input[name="jenis_dokumen"]').val();
        let nama = $('input[name="nama_dokumen"]').val();
        let fileInput = $('input[name="file_dokumen"]')[0];
        let catatan = $('textarea[name="catatan_dokumen"]').val();

        if(jenis && nama){
            let count = $('#dokumenWrapper .dokumenItem').length;
            let fileName = fileInput.files.length > 0 ? fileInput.files[0].name : 'Tidak ada file';

            let html = `<div class="alert alert-secondary d-flex justify-content-between align-items-center mb-1 dokumenItem">
                            <div>
                                <strong>${nama}</strong> (${jenis})<br>
                                <small>File: ${fileName}</small>
                            </div>
                            <button type="button" class="btn-close btn-close-white btn-sm" onclick="this.parentElement.remove()"></button>
                            <input type="hidden" name="dokumen[${count}][jenis]" value="${jenis}">
                            <input type="hidden" name="dokumen[${count}][nama]" value="${nama}">
                            <input type="hidden" name="dokumen[${count}][catatan]" value="${catatan}">
                            <input type="hidden" name="dokumen[${count}][file]" value="${fileName}">
                        </div>`;
            $('#dokumenWrapper').append(html);
            $('#dokumenModal').modal('hide');
            $('#formDokumen')[0].reset();
        }else{
            alert('Jenis dan Nama dokumen wajib diisi.');
        }
    });

    // ====== Lembar Kerja ======
    let lkIndex = 1;
    $('#addLembarKerja').click(function(){
        let html = `<div class="lembarKerjaRow mb-3 border rounded p-3">
            <div class="mb-2">
                <label class="form-label">Judul Pekerjaan</label>
                <input type="text" name="lembar_kerja[${lkIndex}][judul]" class="form-control">
            </div>
            <div class="mb-2">
                <label class="form-label">Deskripsi</label>
                <textarea name="lembar_kerja[${lkIndex}][deskripsi]" class="form-control"></textarea>
            </div>
            <div class="mb-2">
                <label class="form-label">Deadline</label>
                <input type="date" name="lembar_kerja[${lkIndex}][deadline]" class="form-control">
            </div>
            <button type="button" class="btn btn-danger btn-sm removeLembarKerja">Hapus</button>
        </div>`;
        $('#lembarKerjaWrapper').append(html);
        lkIndex++;
    });

    $(document).on('click', '.removeLembarKerja', function(){
        $(this).closest('.lembarKerjaRow').remove();
    });

});
</script>
@endpush
