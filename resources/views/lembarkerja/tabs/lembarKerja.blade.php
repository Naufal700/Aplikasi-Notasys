{{-- Header Utama --}}
<h6 class="fw-bold mb-3 d-flex align-items-center">
    Utama
    <span class="flex-grow-1 ms-2 border-bottom" style="height: 1px;"></span>
</h6>

<div class="row">
    <div class="col-md-4 mb-3">
        <label>No Pesanan <span class="text-danger">*</span></label>
        <input type="text" name="no_pesanan" class="form-control" value="{{ $lembarKerja->no_pesanan }}" readonly>
    </div>
    <div class="col-md-4 mb-3">
        <label>Tanggal Pesanan <span class="text-danger">*</span></label>
        <input type="date" name="tgl_pesanan" class="form-control" value="{{ old('tgl_pesanan', $lembarKerja->tgl_pesanan) }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label>Nama Pelanggan <span class="text-danger">*</span></label>
        <select name="klien_id" class="form-control" id="klienSelect" required>
            <option value="">-- Pilih Klien --</option>
            @foreach($klien as $k)
                <option value="{{ $k->id }}" data-tipe="{{ $k->tipe }}"
                    {{ old('klien_id', $lembarKerja->klien_id) == $k->id ? 'selected' : '' }}>
                    {{ $k->nama }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label>Tipe Pelanggan</label>
        <input type="text" name="tipe_pelanggan" id="tipePelanggan" class="form-control"
            value="{{ old('tipe_pelanggan', $lembarKerja->klien->tipe ?? '') }}" readonly>
    </div>
    <div class="col-md-4 mb-3">
        <label>Nama Lembar Kerja <span class="text-danger">*</span></label>
        <input type="text" name="nama_lembar" class="form-control" value="{{ old('nama_lembar', $lembarKerja->nama_lembar) }}" required>
    </div>
    <div class="col-md-4 mb-3">
        <label>Layanan <span class="text-danger">*</span></label>
        <select name="layanan_id" class="form-control" required>
            <option value="">-- Pilih Layanan --</option>
            @foreach($layanan as $l)
                <option value="{{ $l->id }}"
                    {{ old('layanan_id', $lembarKerja->layanan_id) == $l->id ? 'selected' : '' }}>
                    {{ $l->nama_layanan }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-4 mb-3">
        <label>Target Selesai</label>
        <input type="date" name="tgl_target" class="form-control" value="{{ old('tgl_target', $lembarKerja->tgl_target) }}">
    </div>
    <div class="col-md-4 mb-3">
        <label>Akta</label>
        <select name="akta_id" class="form-control">
            <option value="">-- Pilih Akta --</option>
            @foreach($aktaList as $akta)
                <option value="{{ $akta }}" {{ old('akta_id', $lembarKerja->akta) == $akta ? 'selected' : '' }}>
                    {{ $akta }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="col-md-12 mb-3">
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control" placeholder="Masukkan keterangan">{{ old('keterangan', $lembarKerja->keterangan) }}</textarea>
    </div>
</div>

{{-- Para Penghadap --}}
<h6 class="fw-bold mb-3 d-flex align-items-center">
   Para Penghadap
    <span class="flex-grow-1 ms-2 border-bottom" style="height: 1px;"></span>
</h6>

<div class="mb-3" style="max-width: 400px;">
    <label>Nama Penghadap <span class="text-danger">*</span></label>
    <select name="penghadap[]" class="form-control select2" multiple="multiple" required>
        @foreach($klien as $k)
            <option value="{{ $k->id }}"
                {{ in_array($k->id, old('penghadap', $lembarKerja->penghadap->pluck('id')->toArray() ?? [])) ? 'selected' : '' }}>
                {{ $k->nama }}
            </option>
        @endforeach
    </select>
</div>


{{-- Form Order --}}
<h6 class="fw-bold mb-3 d-flex align-items-center">
   Form Order
    <span class="flex-grow-1 ms-2 border-bottom" style="height: 1px;"></span>
</h6>
<h7 class="fw-bold mb-3 ms-4">Akta Notaris</h7>

<div class="border p-3 rounded mb-3"> {{-- Bungkus tabel dengan garis kotak --}}
    <button type="button" class="btn btn-primary btn-sm mb-2" data-bs-toggle="modal" data-bs-target="#modalFormOrder">+ Notaris</button>
    <div class="table-responsive">
        <table class="table table-bordered" id="reviewFormOrderTable">
             <thead class="table-primary">
                        <tr class="text-nowrap">
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
            <tbody>
                @forelse($lembarKerja->formOrders ?? [] as $index => $fo)
                    <tr data-idx="{{ $index }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $fo->jenis_akta }}<input type="hidden" name="form_order[{{ $index }}][jenis_akta]" value="{{ $fo->jenis_akta }}"></td>
                        <td>{{ $fo->no_akta }}<input type="hidden" name="form_order[{{ $index }}][no_akta]" value="{{ $fo->no_akta }}"></td>
                        <td>{{ $fo->tgl_akta }}<input type="hidden" name="form_order[{{ $index }}][tgl_akta]" value="{{ $fo->tgl_akta }}"></td>
                        <td>{{ $fo->biaya }}<input type="hidden" name="form_order[{{ $index }}][biaya]" value="{{ $fo->biaya }}"></td>
                        <td>{{ $fo->tgl_akad }}<input type="hidden" name="form_order[{{ $index }}][tgl_akad]" value="{{ $fo->tgl_akad }}"></td>
                        <td>{{ $fo->pihak_yang_mengalihkan }}<input type="hidden" name="form_order[{{ $index }}][pihak_yang_mengalihkan]" value="{{ $fo->pihak_yang_mengalihkan }}"></td>
                        <td>{{ $fo->pihak_menerima }}<input type="hidden" name="form_order[{{ $index }}][pihak_menerima]" value="{{ $fo->pihak_menerima }}"></td>
                        <td>
                            @if($fo->file)
                                <a href="{{ asset('storage/'.$fo->file) }}" target="_blank">Lihat</a>
                            @endif
                            <input type="hidden" name="form_order[{{ $index }}][file]" value="{{ $fo->file }}">
                        </td>
                        <td><button type="button" class="btn btn-danger btn-sm btn-remove-formOrder">Hapus</button></td>
                    </tr>
                @empty
                    <tr><td colspan="10" class="text-center">Belum ada Form Order</td></tr>
                @endforelse
            </tbody>
        </table>
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
{{-- Header Proses Lainnya --}}
<div class="mb-3 mt-4">
    <h7 class="fw-bold mb-3 ms-4">Proses Lainnya</h7>
    <div class="mb-3">
    <div class="border p-3 rounded"> {{-- Bungkus tombol + tabel --}}
        <button type="button" class="btn btn-sm btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalProsesLainnya">+ Proses Lainnya</button>
        <div class="table-responsive">
            <table class="table table-bordered" id="prosesLainnyaTable">
                <thead class="table-primary">
                        <tr class="text-nowrap">
                        <th>No</th>
                        <th>Jenis Proses</th>
                        <th>Biaya</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- baris akan ditambahkan JS --}}
                </tbody>
            </table>
        </div>
    </div>
</div>

</div>

{{-- Modal Proses Lainnya --}}
<div class="modal fade" id="modalProsesLainnya" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formProsesLainnya">
                <div class="modal-header">
                    <h5 class="modal-title">Proses Lainnya</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Jenis Proses</label>
                        <select name="jenis_proses" class="form-control" required>
                            <option value="">-- Pilih Jenis Proses --</option>
                            <option value="Proses A">Proses A</option>
                            <option value="Proses B">Proses B</option>
                            <option value="Proses C">Proses C</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>Biaya</label>
                        <input type="number" name="biaya" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>File</label>
                        <input type="file" name="file" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnAddProsesLainnya" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Header Surat Keluar --}}
<div class="mb-5 mt-4">
    <h7 class="fw-bold mb-3 ms-4">Surat Keluar</h7>
    <div class="mb-5">
    <div class="border p-3 rounded"> {{-- Bungkus tombol + tabel --}}
        <button type="button" class="btn btn-sm btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalSuratKeluar">+ Surat Keluar</button>
        <div class="table-responsive">
            <table class="table table-bordered" id="suratKeluarTable">
                 <thead class="table-primary">
                        <tr class="text-nowrap">
                        <th>No</th>
                        <th>Jenis Surat</th>
                        <th>Nama Surat</th>
                        <th>Tanggal Surat</th>
                        <th>Tanggal Kadaluarsa</th>
                        <th>File</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- baris akan ditambahkan JS --}}
                </tbody>
            </table>
        </div>
    </div>
</div>
</div>

{{-- Modal Surat Keluar --}}
<div class="modal fade" id="modalSuratKeluar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formSuratKeluar">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Surat Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Jenis Surat</label>
                        <select name="jenis_surat" class="form-control" required>
                            <option value="">-- Pilih Jenis Surat --</option>
                            <option value="Surat A">Surat A</option>
                            <option value="Surat B">Surat B</option>
                            <option value="Surat C">Surat C</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>Nama Surat</label>
                        <input type="text" name="nama_surat" class="form-control" required placeholder="Masukkan Nama Surat">
                    </div>
                    <div class="mb-2">
                        <label>Tanggal Surat</label>
                        <input type="date" name="tgl_surat" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Tanggal Kadaluarsa</label>
                        <input type="date" name="tgl_kadaluarsa" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Upload File</label>
                        <input type="file" name="file" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnAddSuratKeluar" class="btn btn-primary">Tambah</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- Header Lainnya --}}
<h6 class="fw-bold mb-3 d-flex align-items-center">
  Lainnya
    <span class="flex-grow-1 ms-2 border-bottom" style="height: 1px;"></span>
</h6>
<div class="row mb-3">
    <div class="col-md-6 mb-2">
        <label class="form-label">Tanggal Buat</label>
        <input type="text" class="form-control" value="{{ $lembarKerja->created_at ? $lembarKerja->created_at->format('d-m-Y') : '-' }}" readonly>
    </div>
    <div class="col-md-6 mb-2">
        <label class="form-label">Tanggal Update</label>
        <input type="text" class="form-control" value="{{ $lembarKerja->updated_at ? $lembarKerja->updated_at->format('d-m-Y') : '-' }}" readonly>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // ================= FORM ORDER =================
    let formOrderTable = document.querySelector('#reviewFormOrderTable tbody');
    let modalFormOrder = document.querySelector('#modalFormOrder');
    let btnAddFormOrder = document.querySelector('#btnAddFormOrder');
    let indexFormOrder = formOrderTable.querySelectorAll('tr').length;

    formOrderTable.addEventListener('click', function(e) {
        if(e.target && e.target.classList.contains('btn-remove-formOrder')) {
            e.target.closest('tr').remove();
            formOrderTable.querySelectorAll('tr').forEach((row, idx) => {
                row.querySelector('td:first-child').innerText = idx + 1;
                row.dataset.idx = idx;
            });
            indexFormOrder = formOrderTable.querySelectorAll('tr').length;
        }

        if(e.target && e.target.closest('td') && e.target.closest('tr')) {
            let td = e.target.closest('td');
            let tr = e.target.closest('tr');
            if(td.cellIndex === 1){
                let rowData = {
                    jenis_akta: tr.querySelector('input[name^="form_order"][name$="[jenis_akta]"]').value,
                    no_akta: tr.querySelector('input[name^="form_order"][name$="[no_akta]"]').value,
                    tgl_akta: tr.querySelector('input[name^="form_order"][name$="[tgl_akta]"]').value,
                    biaya: tr.querySelector('input[name^="form_order"][name$="[biaya]"]').value,
                    tgl_akad: tr.querySelector('input[name^="form_order"][name$="[tgl_akad]"]').value,
                    pihak_yang_mengalihkan: tr.querySelector('input[name^="form_order"][name$="[pihak_yang_mengalihkan]"]').value,
                    pihak_menerima: tr.querySelector('input[name^="form_order"][name$="[pihak_menerima]"]').value,
                    file: tr.querySelector('input[name^="form_order"][name$="[file]"]').value
                };

                modalFormOrder.querySelector('[name="jenis_akta"]').value = rowData.jenis_akta;
                modalFormOrder.querySelector('[name="no_akta"]').value = rowData.no_akta;
                modalFormOrder.querySelector('[name="tgl_akta"]').value = rowData.tgl_akta;
                modalFormOrder.querySelector('[name="biaya"]').value = rowData.biaya;
                modalFormOrder.querySelector('[name="tgl_akad"]').value = rowData.tgl_akad;
                modalFormOrder.querySelector('[name="pihak_yang_mengalihkan"]').value = rowData.pihak_yang_mengalihkan;
                modalFormOrder.querySelector('[name="pihak_menerima"]').value = rowData.pihak_menerima;
                modalFormOrder.querySelector('[name="file"]').value = '';

                modalFormOrder.dataset.editIdx = tr.dataset.idx;
                btnAddFormOrder.innerText = 'Update';
                new bootstrap.Modal(modalFormOrder).show();
            }
        }
    });

    document.querySelector('[data-bs-target="#modalFormOrder"]').addEventListener('click', function() {
        modalFormOrder.querySelector('form').reset();
        delete modalFormOrder.dataset.editIdx;
        btnAddFormOrder.innerText = 'Tambah';
    });

    btnAddFormOrder.addEventListener('click', function() {
        let jenis_akta = modalFormOrder.querySelector('[name="jenis_akta"]').value;
        let no_akta = modalFormOrder.querySelector('[name="no_akta"]').value;
        let tgl_akta = modalFormOrder.querySelector('[name="tgl_akta"]').value;
        let biaya = modalFormOrder.querySelector('[name="biaya"]').value;
        let tgl_akad = modalFormOrder.querySelector('[name="tgl_akad"]').value;
        let pihak_yang_mengalihkan = modalFormOrder.querySelector('[name="pihak_yang_mengalihkan"]').value;
        let pihak_menerima = modalFormOrder.querySelector('[name="pihak_menerima"]').value;
        let fileInput = modalFormOrder.querySelector('[name="file"]');
        let fileValue = fileInput.files.length ? fileInput.files[0].name : '';

        if(!jenis_akta || !no_akta || !tgl_akta || !biaya){
            alert("Jenis Akta, No Akta, Tanggal Akta dan Biaya wajib diisi");
            return;
        }

        let editIdx = modalFormOrder.dataset.editIdx;

        if(editIdx !== undefined){
            let row = formOrderTable.querySelector(`tr[data-idx="${editIdx}"]`);
            row.innerHTML = `
                <td>${parseInt(editIdx)+1}</td>
                <td>${jenis_akta}<input type="hidden" name="form_order[${editIdx}][jenis_akta]" value="${jenis_akta}"></td>
                <td>${no_akta}<input type="hidden" name="form_order[${editIdx}][no_akta]" value="${no_akta}"></td>
                <td>${tgl_akta}<input type="hidden" name="form_order[${editIdx}][tgl_akta]" value="${tgl_akta}"></td>
                <td>${biaya}<input type="hidden" name="form_order[${editIdx}][biaya]" value="${biaya}"></td>
                <td>${tgl_akad}<input type="hidden" name="form_order[${editIdx}][tgl_akad]" value="${tgl_akad}"></td>
                <td>${pihak_yang_mengalihkan}<input type="hidden" name="form_order[${editIdx}][pihak_yang_mengalihkan]" value="${pihak_yang_mengalihkan}"></td>
                <td>${pihak_menerima}<input type="hidden" name="form_order[${editIdx}][pihak_menerima]" value="${pihak_menerima}"></td>
                <td>${fileValue}<input type="hidden" name="form_order[${editIdx}][file]" value="${fileValue}"></td>
                <td><button type="button" class="btn btn-danger btn-sm btn-remove-formOrder">Hapus</button></td>
            `;
            delete modalFormOrder.dataset.editIdx;
        } else {
            let row = document.createElement('tr');
            row.dataset.idx = indexFormOrder;
            row.innerHTML = `
                <td>${indexFormOrder + 1}</td>
                <td>${jenis_akta}<input type="hidden" name="form_order[${indexFormOrder}][jenis_akta]" value="${jenis_akta}"></td>
                <td>${no_akta}<input type="hidden" name="form_order[${indexFormOrder}][no_akta]" value="${no_akta}"></td>
                <td>${tgl_akta}<input type="hidden" name="form_order[${indexFormOrder}][tgl_akta]" value="${tgl_akta}"></td>
                <td>${biaya}<input type="hidden" name="form_order[${indexFormOrder}][biaya]" value="${biaya}"></td>
                <td>${tgl_akad}<input type="hidden" name="form_order[${indexFormOrder}][tgl_akad]" value="${tgl_akad}"></td>
                <td>${pihak_yang_mengalihkan}<input type="hidden" name="form_order[${indexFormOrder}][pihak_yang_mengalihkan]" value="${pihak_yang_mengalihkan}"></td>
                <td>${pihak_menerima}<input type="hidden" name="form_order[${indexFormOrder}][pihak_menerima]" value="${pihak_menerima}"></td>
                <td>${fileValue}<input type="hidden" name="form_order[${indexFormOrder}][file]" value="${fileValue}"></td>
                <td><button type="button" class="btn btn-danger btn-sm btn-remove-formOrder">Hapus</button></td>
            `;
            formOrderTable.appendChild(row);
            indexFormOrder++;
        }

        modalFormOrder.querySelector('form').reset();
        bootstrap.Modal.getInstance(modalFormOrder).hide();
        btnAddFormOrder.innerText = 'Tambah';
    });

    // ================= PROSES LAINNYA =================
    let prosesTable = document.querySelector('#prosesLainnyaTable tbody');
    let modalProses = document.querySelector('#modalProsesLainnya');
    let btnAddProses = document.querySelector('#btnAddProsesLainnya');
    let indexProses = 0;

    prosesTable.addEventListener('click', function(e){
        let tr = e.target.closest('tr');
        if(e.target && e.target.classList.contains('btn-remove-proses')){
            tr.remove();
            prosesTable.querySelectorAll('tr').forEach((row, idx) => {
                row.querySelector('td:first-child').innerText = idx + 1;
                row.dataset.idx = idx;
            });
            indexProses = prosesTable.querySelectorAll('tr').length;
        } else if(e.target && e.target.closest('td') && e.target.closest('tr')){
            let td = e.target.closest('td');
            if(td.cellIndex === 1){
                modalProses.querySelector('[name="jenis_proses"]').value = tr.querySelector('input[name^="proses"][name$="[jenis_proses]"]').value;
                modalProses.querySelector('[name="biaya"]').value = tr.querySelector('input[name^="proses"][name$="[biaya]"]').value;
                modalProses.querySelector('[name="file"]').value = '';
                modalProses.dataset.editIdx = tr.dataset.idx;
                btnAddProses.innerText = 'Update';
                new bootstrap.Modal(modalProses).show();
            }
        }
    });

    document.querySelector('[data-bs-target="#modalProsesLainnya"]').addEventListener('click', function(){
        modalProses.querySelector('form').reset();
        delete modalProses.dataset.editIdx;
        btnAddProses.innerText = 'Tambah';
    });

    btnAddProses.addEventListener('click', function(){
        let jenis_proses = modalProses.querySelector('[name="jenis_proses"]').value;
        let biaya = modalProses.querySelector('[name="biaya"]').value;
        let fileInput = modalProses.querySelector('[name="file"]');
        let fileValue = fileInput.files.length ? fileInput.files[0].name : '';

        if(!jenis_proses || !biaya){
            alert("Jenis Proses dan Biaya wajib diisi");
            return;
        }

        let editIdx = modalProses.dataset.editIdx;

        if(editIdx !== undefined){
            let row = prosesTable.querySelector(`tr[data-idx="${editIdx}"]`);
            row.innerHTML = `
                <td>${parseInt(editIdx)+1}</td>
                <td>${jenis_proses}<input type="hidden" name="proses[${editIdx}][jenis_proses]" value="${jenis_proses}"></td>
                <td>${biaya}<input type="hidden" name="proses[${editIdx}][biaya]" value="${biaya}"></td>
                <td>${fileValue}<input type="hidden" name="proses[${editIdx}][file]" value="${fileValue}"></td>
                <td><button type="button" class="btn btn-danger btn-sm btn-remove-proses">Hapus</button></td>
            `;
            delete modalProses.dataset.editIdx;
        } else {
            let row = document.createElement('tr');
            row.dataset.idx = indexProses;
            row.innerHTML = `
                <td>${indexProses+1}</td>
                <td>${jenis_proses}<input type="hidden" name="proses[${indexProses}][jenis_proses]" value="${jenis_proses}"></td>
                <td>${biaya}<input type="hidden" name="proses[${indexProses}][biaya]" value="${biaya}"></td>
                <td>${fileValue}<input type="hidden" name="proses[${indexProses}][file]" value="${fileValue}"></td>
                <td><button type="button" class="btn btn-danger btn-sm btn-remove-proses">Hapus</button></td>
            `;
            prosesTable.appendChild(row);
            indexProses++;
        }

        modalProses.querySelector('form').reset();
        bootstrap.Modal.getInstance(modalProses).hide();
        btnAddProses.innerText = 'Tambah';
    });

    // ================= SURAT KELUAR =================
    let suratTable = document.querySelector('#suratKeluarTable tbody');
    let modalSurat = document.querySelector('#modalSuratKeluar');
    let btnAddSurat = document.querySelector('#btnAddSuratKeluar');
    let indexSurat = 0;

    suratTable.addEventListener('click', function(e){
        let tr = e.target.closest('tr');
        if(e.target && e.target.classList.contains('btn-remove-surat')){
            tr.remove();
            suratTable.querySelectorAll('tr').forEach((row, idx) => {
                row.querySelector('td:first-child').innerText = idx + 1;
                row.dataset.idx = idx;
            });
            indexSurat = suratTable.querySelectorAll('tr').length;
        } else if(e.target && e.target.closest('td') && e.target.closest('tr')){
            let td = e.target.closest('td');
            if(td.cellIndex === 1){
                let rowData = {
                    jenis_surat: tr.querySelector('input[name^="surat"][name$="[jenis_surat]"]').value,
                    nama_surat: tr.querySelector('input[name^="surat"][name$="[nama_surat]"]').value,
                    tgl_surat: tr.querySelector('input[name^="surat"][name$="[tgl_surat]"]').value,
                    tgl_kadaluarsa: tr.querySelector('input[name^="surat"][name$="[tgl_kadaluarsa]"]').value,
                    file: tr.querySelector('input[name^="surat"][name$="[file]"]').value
                };

                modalSurat.querySelector('[name="jenis_surat"]').value = rowData.jenis_surat;
                modalSurat.querySelector('[name="nama_surat"]').value = rowData.nama_surat;
                modalSurat.querySelector('[name="tgl_surat"]').value = rowData.tgl_surat;
                modalSurat.querySelector('[name="tgl_kadaluarsa"]').value = rowData.tgl_kadaluarsa;
                modalSurat.querySelector('[name="file"]').value = '';

                modalSurat.dataset.editIdx = tr.dataset.idx;
                btnAddSurat.innerText = 'Update';
                new bootstrap.Modal(modalSurat).show();
            }
        }
    });

    document.querySelector('[data-bs-target="#modalSuratKeluar"]').addEventListener('click', function(){
        modalSurat.querySelector('form').reset();
        delete modalSurat.dataset.editIdx;
        btnAddSurat.innerText = 'Tambah';
    });

    btnAddSurat.addEventListener('click', function(){
        let jenis_surat = modalSurat.querySelector('[name="jenis_surat"]').value;
        let nama_surat = modalSurat.querySelector('[name="nama_surat"]').value;
        let tgl_surat = modalSurat.querySelector('[name="tgl_surat"]').value;
        let tgl_kadaluarsa = modalSurat.querySelector('[name="tgl_kadaluarsa"]').value;
        let fileInput = modalSurat.querySelector('[name="file"]');
        let fileValue = fileInput.files.length ? fileInput.files[0].name : '';

        if(!jenis_surat || !nama_surat || !tgl_surat){
            alert("Jenis Surat, Nama Surat, dan Tanggal Surat wajib diisi");
            return;
        }

        let editIdx = modalSurat.dataset.editIdx;

        if(editIdx !== undefined){
            let row = suratTable.querySelector(`tr[data-idx="${editIdx}"]`);
            row.innerHTML = `
                <td>${parseInt(editIdx)+1}</td>
                <td>${jenis_surat}<input type="hidden" name="surat[${editIdx}][jenis_surat]" value="${jenis_surat}"></td>
                <td>${nama_surat}<input type="hidden" name="surat[${editIdx}][nama_surat]" value="${nama_surat}"></td>
                <td>${tgl_surat}<input type="hidden" name="surat[${editIdx}][tgl_surat]" value="${tgl_surat}"></td>
                <td>${tgl_kadaluarsa}<input type="hidden" name="surat[${editIdx}][tgl_kadaluarsa]" value="${tgl_kadaluarsa}"></td>
                <td>${fileValue}<input type="hidden" name="surat[${editIdx}][file]" value="${fileValue}"></td>
                <td><button type="button" class="btn btn-danger btn-sm btn-remove-surat">Hapus</button></td>
            `;
            delete modalSurat.dataset.editIdx;
        } else {
            let row = document.createElement('tr');
            row.dataset.idx = indexSurat;
            row.innerHTML = `
                <td>${indexSurat+1}</td>
                <td>${jenis_surat}<input type="hidden" name="surat[${indexSurat}][jenis_surat]" value="${jenis_surat}"></td>
                <td>${nama_surat}<input type="hidden" name="surat[${indexSurat}][nama_surat]" value="${nama_surat}"></td>
                <td>${tgl_surat}<input type="hidden" name="surat[${indexSurat}][tgl_surat]" value="${tgl_surat}"></td>
                <td>${tgl_kadaluarsa}<input type="hidden" name="surat[${indexSurat}][tgl_kadaluarsa]" value="${tgl_kadaluarsa}"></td>
                <td>${fileValue}<input type="hidden" name="surat[${indexSurat}][file]" value="${fileValue}"></td>
                <td><button type="button" class="btn btn-danger btn-sm btn-remove-surat">Hapus</button></td>
            `;
            suratTable.appendChild(row);
            indexSurat++;
        }

        modalSurat.querySelector('form').reset();
        bootstrap.Modal.getInstance(modalSurat).hide();
        btnAddSurat.innerText = 'Tambah';
    });
});
</script>
@endpush
