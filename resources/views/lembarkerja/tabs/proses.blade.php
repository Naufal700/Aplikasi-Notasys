<div class="mb-3">
    <button type="button" class="btn btn-sm btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#modalProses">
        + New Proses
    </button>

    <!-- Toast Notification -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="prosesToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    Proses berhasil disimpan!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    {{-- Tabel Proses --}}
    <div class="table-responsive">
        <table class="table table-bordered" id="prosesTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Proses <span class="text-danger">*</span></th>
                    <th>Target Selesai</th>
                    <th>Selesai</th>
                    <th>Urutan</th>
                    <th>Catatan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- Baris akan di-load dari DB --}}
            </tbody>
        </table>
    </div>
</div>

{{-- Modal New Proses --}}
<div class="modal fade" id="modalProses" tabindex="-1" aria-labelledby="modalProsesLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="formProses">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalProsesLabel">Tambah Proses</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Nama Proses <span class="text-danger">*</span></label>
                        <input type="text" name="nama_proses" class="form-control" required>
                    </div>
                    <div class="mb-2">
                        <label>Target Selesai</label>
                        <input type="date" name="target_selesai" class="form-control">
                    </div>
                    <div class="mb-2 form-check">
                        <input type="checkbox" name="selesai" class="form-check-input" id="selesaiCheckbox">
                        <label class="form-check-label" for="selesaiCheckbox">Selesai</label>
                    </div>
                    <div class="mb-2">
                        <label>Urutan</label>
                        <input type="number" name="urutan" class="form-control">
                    </div>
                    <div class="mb-2">
                        <label>Catatan</label>
                        <textarea name="catatan" class="form-control" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-primary" id="btnAddProses">
                        <span id="spinnerAdd" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                        <span id="textAdd">Tambah</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const prosesTable = document.querySelector('#prosesTable tbody');
    const modalProses = document.querySelector('#modalProses');
    const btnAddProses = document.querySelector('#btnAddProses');
    const lembarKerjaId = "{{ $lembarKerja->id }}";

    const toastEl = document.getElementById('prosesToast');
    const toast = new bootstrap.Toast(toastEl);

    let editProsesId = null; // untuk menampung ID proses yang sedang diedit

    function formatDate(dateStr) {
        if (!dateStr) return '';
        const date = new Date(dateStr);
        const day = String(date.getDate()).padStart(2,'0');
        const month = String(date.getMonth()+1).padStart(2,'0');
        const year = date.getFullYear();
        return `${day}-${month}-${year}`;
    }

    function loadProses() {
        fetch(`/lembar-kerja/${lembarKerjaId}/proses`)
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    prosesTable.innerHTML = '';
                    res.proses.forEach((p, idx) => {
                        let row = document.createElement('tr');
                        row.dataset.idx = p.id;
                        row.innerHTML = `
                            <td>${idx + 1}</td>
                            <td class="nama-proses text-primary" style="cursor:pointer;" data-id="${p.id}">${p.nama_proses}</td>
                            <td>${formatDate(p.target_selesai)}</td>
                            <td>${p.selesai ? 'Ya' : 'Tidak'}</td>
                            <td>${p.urutan || ''}</td>
                            <td>${p.catatan || ''}</td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm btn-remove-proses" data-id="${p.id}">Hapus</button>
                            </td>
                        `;
                        prosesTable.appendChild(row);
                    });
                }
            });
    }

    loadProses();

    // klik nama proses untuk edit
    prosesTable.addEventListener('click', function(e) {
        if(e.target.classList.contains('nama-proses')){
            const prosesId = e.target.dataset.id;
            fetch(`/lembar-kerja/proses/${prosesId}`)
                .then(res => res.json())
                .then(res => {
                    if(res.status === 'success'){
                        const form = document.querySelector('#formProses');
                        form.nama_proses.value = res.data.nama_proses;
                        form.target_selesai.value = res.data.target_selesai ? res.data.target_selesai.split('T')[0] : '';
                        form.selesai.checked = res.data.selesai ? true : false;
                        form.urutan.value = res.data.urutan || '';
                        form.catatan.value = res.data.catatan || '';
                        editProsesId = prosesId;
                        document.querySelector('#modalProsesLabel').innerText = 'Edit Proses';
                        bootstrap.Modal.getOrCreateInstance(modalProses).show();
                    } else {
                        alert('Gagal load data proses');
                    }
                }).catch(err=>{
                    alert('Terjadi kesalahan');
                });
        }
    });

    // tambah / edit proses
    btnAddProses.addEventListener('click', function () {
        const form = document.querySelector('#formProses');
        const spinner = document.getElementById('spinnerAdd');
        const text = document.getElementById('textAdd');

        const data = {
            nama_proses: form.nama_proses.value.trim(),
            target_selesai: form.target_selesai.value,
            selesai: form.selesai.checked ? 1 : 0,
            urutan: form.urutan.value,
            catatan: form.catatan.value,
        };

        if (!data.nama_proses) {
            alert("Nama Proses wajib diisi!");
            return;
        }

        spinner.classList.remove('d-none');
        text.classList.add('d-none');

        const url = editProsesId ? `/lembar-kerja/proses/${editProsesId}` : `/lembar-kerja/${lembarKerjaId}/proses`;
        const method = editProsesId ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(res => {
            spinner.classList.add('d-none');
            text.classList.remove('d-none');

            if (res.status === 'success') {
                form.reset();
                editProsesId = null;
                document.querySelector('#modalProsesLabel').innerText = 'Tambah Proses';
                bootstrap.Modal.getOrCreateInstance(modalProses).hide();
                toast.show();
                loadProses();
            } else {
                alert('Gagal menyimpan proses');
            }
        })
        .catch(err => {
            spinner.classList.add('d-none');
            text.classList.remove('d-none');
            alert('Terjadi kesalahan. Silakan coba lagi.');
        });
    });

    // Hapus proses
    prosesTable.addEventListener('click', function (e) {
        if (e.target.closest('.btn-remove-proses')) {
            const btn = e.target.closest('.btn-remove-proses');
            const prosesId = btn.dataset.id;
            if(!confirm('Yakin ingin menghapus proses ini?')) return;

            btn.disabled = true;
            fetch(`/lembar-kerja/proses/${prosesId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(res => res.json())
                .then(res => {
                    btn.disabled = false;
                    if (res.status === 'success') {
                        toastEl.querySelector('.toast-body').innerText = 'Proses berhasil dihapus!';
                        toast.show();
                        loadProses();
                    } else {
                        alert('Gagal menghapus proses');
                    }
                })
                .catch(err => {
                    btn.disabled = false;
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
        }
    });
});
</script>
@endpush
