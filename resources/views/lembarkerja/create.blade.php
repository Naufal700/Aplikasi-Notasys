@extends('layouts.commonMaster')

@section('title', 'Tambah Lembar Kerja')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card shadow-sm">
        <div class="card-body">
            <h4 class="fw-bold mb-4">Tambah Lembar Kerja</h4>

            <form action="{{ route('lembar-kerja.store') }}" method="POST" enctype="multipart/form-data" id="lembarKerjaForm">
                @csrf

                {{-- Tabs --}}
                <ul class="nav nav-tabs" id="lembarKerjaTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-lembarKerja" type="button">Lembar Kerja</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-penghadap" type="button">Penghadap</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-setting" type="button">Setting</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-formOrder" type="button">Form Order</button>
                    </li>
                </ul>

                {{-- Tab Content --}}
                <div class="tab-content mt-4">
                    {{-- Tab 1: Lembar Kerja --}}
                    <div class="tab-pane fade show active" id="tab-lembarKerja">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>No Pesanan <span class="text-danger">*</span></label>
                                <input type="text" name="no_pesanan" class="form-control" value="{{ $noPesanan }}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Pesanan <span class="text-danger">*</span></label>
                                <input type="date" name="tgl_pesanan" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nama Pelanggan <span class="text-danger">*</span></label>
                                <select name="klien_id" class="form-control" id="klienSelect" required>
                                    <option value="">-- Pilih Klien --</option>
                                    @foreach($klien as $k)
                                        <option value="{{ $k->id }}" data-tipe="{{ $k->tipe }}">{{ $k->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tipe Pelanggan</label>
                                <input type="text" name="tipe_pelanggan" id="tipePelanggan" class="form-control" readonly placeholder="Otomatis terisi setelah pilih klien">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Nama Lembar <span class="text-danger">*</span></label>
                                <input type="text" name="nama_lembar" class="form-control" placeholder="Masukkan nama lembar" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Layanan <span class="text-danger">*</span></label>
                                <select name="layanan_id" class="form-control" required>
                                    <option value="">-- Pilih Layanan --</option>
                                    @foreach($layanan as $l)
                                        <option value="{{ $l->id }}">{{ $l->nama_layanan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Tanggal Target</label>
                                <input type="date" name="tgl_target" class="form-control">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Keterangan</label>
                                <textarea name="keterangan" class="form-control" placeholder="Masukkan keterangan"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- Tab 2: Penghadap --}}
                    <div class="tab-pane fade" id="tab-penghadap">
    <div class="mb-3 col-md-6">
        <label>Nama Penghadap <span class="text-danger">*</span></label>
        <select name="penghadap[]" class="form-control select2" multiple="multiple" required>
            @foreach($klien as $k)
                <option value="{{ $k->id }}">{{ $k->nama }}</option>
            @endforeach
        </select>
    </div>
</div>


                    {{-- Tab 3: Setting --}}
                    <div class="tab-pane fade" id="tab-setting">
                        <div class="mb-3">
                            <label>Template Form Order</label>
                            <select name="template_form_order_id" class="form-control">
                                <option value="">-- Pilih Template --</option>
                                @foreach($templates as $t)
                                    <option value="{{ $t->id }}">{{ $t->nama }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Opsi Form Order <span class="text-danger">*</span></label>
                            <div class="row">
                                @php
                                    $opsi = [
                                        'form_order_akta_ppat'=>'Akta PPAT',
                                        'form_order_proses_lainnya'=>'Proses Lainnya',
                                        'form_order_legalisasi'=>'Legalisasi',
                                        'form_order_akta_notaris_lainnya'=>'Akta Notaris Lainnya',
                                        'form_order_akta_notaris'=>'Akta Notaris',
                                        'form_order_pajak_titipan'=>'Pajak Titipan',
                                        'form_order_waarmarking'=>'Waarmerking',
                                        'form_order_akta_ppat_luar_wilayah'=>'Akta PPAT Luar Wilayah'
                                    ];
                                @endphp
                                @foreach($opsi as $field => $label)
                                    <div class="col-md-6 mb-2">
                                        <div class="form-label fw-bold">{{ $label }}</div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="{{ $field }}" id="{{ $field }}_ya" value="1" required>
                                            <label class="form-check-label" for="{{ $field }}_ya">Ya</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="{{ $field }}" id="{{ $field }}_tidak" value="0" required>
                                            <label class="form-check-label" for="{{ $field }}_tidak">Tidak</label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Tab 4: Form Order --}}
                    <div class="tab-pane fade" id="tab-formOrder">
                        <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalFormOrder">New Notaris</button>

                        {{-- Tabel Review --}}
                        <div class="mt-3">
                            <table class="table table-bordered" id="reviewFormOrderTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Jenis Akta <span class="text-danger">*</span></th>
                                        <th>No Akta <span class="text-danger">*</span></th>
                                        <th>Tanggal Akta <span class="text-danger">*</span></th>
                                        <th>Biaya <span class="text-danger">*</span></th>
                                        <th>Tanggal Akad</th>
                                        <th>Pihak Mengalihkan</th>
                                        <th>Pihak Menerima</th>
                                        <th>File</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>

                        <div class="mb-3">
                            <label>Catatan</label>
                            <textarea name="catatan" class="form-control" placeholder="Masukkan catatan tambahan"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="mt-3 text-end">
                    <a href="{{ route('lembar-kerja.index') }}" class="btn btn-secondary me-2">Batal</a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Form Order --}}
<div class="modal fade" id="modalFormOrder" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Form Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formOrderModal">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <label>Jenis Akta <span class="text-danger">*</span></label>
                            <select name="jenis_akta" class="form-control" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Akta PPAT">Akta PPAT</option>
                                <option value="Akta Notaris">Akta Notaris</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>No Akta <span class="text-danger">*</span></label>
                            <input type="text" name="no_akta" class="form-control" required placeholder="Masukkan No Akta">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Tanggal Akta <span class="text-danger">*</span></label>
                            <input type="date" name="tgl_akta" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Biaya <span class="text-danger">*</span></label>
                            <input type="number" name="biaya" class="form-control" required placeholder="Masukkan biaya">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Tanggal Akad</label>
                            <input type="date" name="tgl_akad" class="form-control">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Pihak Yang Mengalihkan</label>
                            <input type="text" name="pihak_yang_mengalihkan" class="form-control">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Pihak Menerima</label>
                            <input type="text" name="pihak_menerima" class="form-control">
                        </div>
                        <div class="col-md-6 mb-2">
                            <label>Upload File</label>
                            <input type="file" name="file" class="form-control">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnAddFormOrder">Tambah</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function(){

    // Select2
    $('.select2').select2({
        placeholder: "Pilih penghadap",
        allowClear: true,
        width: '100%'
    });

    // Tipe Pelanggan otomatis
    const klienSelect = document.getElementById('klienSelect');
    const tipePelanggan = document.getElementById('tipePelanggan');
    klienSelect.addEventListener('change', function(){
        tipePelanggan.value = this.options[this.selectedIndex].dataset.tipe || '';
    });

    // Form Order Modal ke Tabel Review
    const formOrderModal = document.getElementById('formOrderModal');
    const reviewTableBody = document.querySelector('#reviewFormOrderTable tbody');
    let formOrderIndex = 0;

    document.getElementById('btnAddFormOrder').addEventListener('click', function(){
        const formData = new FormData(formOrderModal);

        // Validasi required
        const requiredFields = formOrderModal.querySelectorAll('[required]');
        for(const field of requiredFields){
            if(!formData.get(field.name)){
                alert(`Field ${field.previousElementSibling.textContent} wajib diisi!`);
                field.focus();
                return;
            }
        }

        const row = document.createElement('tr');
        row.dataset.idx = formOrderIndex;
        row.innerHTML = `
            <td>${formOrderIndex+1}</td>
            <td>${formData.get('jenis_akta')}<input type="hidden" name="form_order[${formOrderIndex}][jenis_akta]" value="${formData.get('jenis_akta')}"></td>
            <td>${formData.get('no_akta')}<input type="hidden" name="form_order[${formOrderIndex}][no_akta]" value="${formData.get('no_akta')}"></td>
            <td>${formData.get('tgl_akta')}<input type="hidden" name="form_order[${formOrderIndex}][tgl_akta]" value="${formData.get('tgl_akta')}"></td>
            <td>${formData.get('biaya')}<input type="hidden" name="form_order[${formOrderIndex}][biaya]" value="${formData.get('biaya')}"></td>
            <td>${formData.get('tgl_akad')}<input type="hidden" name="form_order[${formOrderIndex}][tgl_akad]" value="${formData.get('tgl_akad')}"></td>
            <td>${formData.get('pihak_yang_mengalihkan')}<input type="hidden" name="form_order[${formOrderIndex}][pihak_yang_mengalihkan]" value="${formData.get('pihak_yang_mengalihkan')}"></td>
            <td>${formData.get('pihak_menerima')}<input type="hidden" name="form_order[${formOrderIndex}][pihak_menerima]" value="${formData.get('pihak_menerima')}"></td>
            <td>${formData.get('file') ? formData.get('file').name : ''}<input type="hidden" name="form_order[${formOrderIndex}][file]" value=""></td>
            <td><button type="button" class="btn btn-danger btn-sm btnRemoveRow">Hapus</button></td>
        `;
        reviewTableBody.appendChild(row);
        formOrderIndex++;

        // Reset dan tutup modal
        formOrderModal.reset();
        bootstrap.Modal.getInstance(document.getElementById('modalFormOrder')).hide();
    });

    // Hapus row dari tabel
    reviewTableBody.addEventListener('click', function(e){
        if(e.target.classList.contains('btnRemoveRow')){
            e.target.closest('tr').remove();
        }
    });

    // Validasi radio button di tab Setting sebelum submit
    const form = document.getElementById('lembarKerjaForm');
    form.addEventListener('submit', function(e){
        const requiredRadios = form.querySelectorAll('input[type="radio"][required]');
        let allChecked = true;

        requiredRadios.forEach(radio => {
            const name = radio.name;
            if(!form.querySelector(`input[name="${name}"]:checked`)){
                allChecked = false;
                const tab = new bootstrap.Tab(document.querySelector('#tab-setting'));
                tab.show();
                radio.scrollIntoView({behavior: 'smooth', block: 'center'});
            }
        });

        if(!allChecked){
            e.preventDefault();
            alert('Harap pilih semua opsi Form Order di tab Setting!');
        }
    });

});
</script>
@endpush
@endsection
