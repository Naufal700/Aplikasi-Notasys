<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">
            <i class="bx bx-cog me-2"></i>Daftar Proses
        </h5>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalProses">
            <i class="bx bx-plus me-1"></i> Tambah Proses
        </button>
    </div>

    <!-- Toast Notification -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
        <div id="prosesToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bx bx-check-circle me-2"></i>
                    Proses berhasil disimpan!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    {{-- Tabel Proses --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="prosesTable">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th width="25%">Nama Proses</th>
                            <th width="15%">Target Selesai</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="10%" class="text-center">Urutan</th>
                            <th width="25%">Catatan</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- Baris akan di-load dari DB --}}
                        <tr id="emptyProsesMessage">
                            <td colspan="7" class="text-center py-4 text-muted">
                                <i class="bx bx-inbox fs-1 d-block mb-2"></i>
                                Belum ada proses yang ditambahkan
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal New Proses --}}
<div class="modal fade" id="modalProses" tabindex="-1" aria-labelledby="modalProsesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="modalProsesLabel">
                    <i class="bx bx-plus-circle me-2"></i>Tambah Proses
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formProses">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Nama Proses <span class="text-danger">*</span></label>
                            <input type="text" name="nama_proses" class="form-control" placeholder="Masukkan nama proses" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Target Selesai</label>
                            <input type="date" name="target_selesai" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Urutan</label>
                            <input type="number" name="urutan" class="form-control" placeholder="Masukkan urutan">
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-check mt-4">
                                <input type="checkbox" name="selesai" class="form-check-input" id="selesaiCheckbox">
                                <label class="form-check-label fw-semibold" for="selesaiCheckbox">
                                    <i class="bx bx-check-circle me-1"></i>Proses Selesai
                                </label>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-semibold">Catatan</label>
                            <textarea name="catatan" class="form-control" rows="3" placeholder="Masukkan catatan proses..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x me-1"></i> Batal
                    </button>
                    <button type="button" class="btn btn-primary" id="btnAddProses">
                        <span id="spinnerAdd" class="spinner-border spinner-border-sm d-none me-1" role="status" aria-hidden="true"></span>
                        <span id="textAdd">
                            <i class="bx bx-plus me-1"></i> Tambah Proses
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.proses-table tbody tr {
    transition: all 0.2s ease;
}

.proses-table tbody tr:hover {
    background-color: #f8f9fa;
}

.status-badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}

.btn-action {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.nama-proses {
    font-weight: 500;
    cursor: pointer;
    transition: color 0.2s ease;
}

.nama-proses:hover {
    color: #0d6efd !important;
}

.table th {
    font-weight: 600;
    font-size: 0.875rem;
    border-bottom: 2px solid #e9ecef;
}

.card {
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
}
</style>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const prosesTable = document.querySelector('#prosesTable tbody');
    const modalProses = document.querySelector('#modalProses');
    const btnAddProses = document.querySelector('#btnAddProses');
    const emptyProsesMessage = document.querySelector('#emptyProsesMessage');
    const lembarKerjaId = "{{ $lembarKerja->id }}";

    const toastEl = document.getElementById('prosesToast');
    const toast = new bootstrap.Toast(toastEl);

    let editProsesId = null;

    function formatDate(dateStr) {
        if (!dateStr) return '-';
        const date = new Date(dateStr);
        const day = String(date.getDate()).padStart(2,'0');
        const month = String(date.getMonth()+1).padStart(2,'0');
        const year = date.getFullYear();
        return `${day}/${month}/${year}`;
    }

    function getStatusBadge(selesai) {
        if (selesai) {
            return '<span class="badge bg-success status-badge"><i class="bx bx-check-circle me-1"></i>Selesai</span>';
        } else {
            return '<span class="badge bg-warning text-dark status-badge"><i class="bx bx-time me-1"></i>Proses</span>';
        }
    }

    function loadProses() {
        fetch(`/lembar-kerja/${lembarKerjaId}/proses`)
            .then(res => res.json())
            .then(res => {
                if (res.status === 'success') {
                    prosesTable.innerHTML = '';
                    
                    if (res.proses.length === 0) {
                        emptyProsesMessage.classList.remove('d-none');
                        prosesTable.appendChild(emptyProsesMessage);
                        return;
                    }
                    
                    emptyProsesMessage.classList.add('d-none');
                    
                    res.proses.forEach((p, idx) => {
                        let row = document.createElement('tr');
                        row.dataset.idx = p.id;
                        row.innerHTML = `
                            <td class="text-center">${idx + 1}</td>
                            <td>
                                <span class="nama-proses text-primary" data-id="${p.id}" title="Klik untuk edit">
                                    <i class="bx bx-task me-1"></i>${p.nama_proses}
                                </span>
                            </td>
                            <td>${formatDate(p.target_selesai)}</td>
                            <td class="text-center">${getStatusBadge(p.selesai)}</td>
                            <td class="text-center">${p.urutan || '-'}</td>
                            <td>
                                ${p.catatan ? `
                                    <span class="text-truncate" title="${p.catatan}">
                                        <i class="bx bx-note me-1"></i>${p.catatan.length > 50 ? p.catatan.substring(0, 50) + '...' : p.catatan}
                                    </span>
                                ` : '-'}
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-action" data-id="${p.id}" title="Edit">
                                       <i class="mdi mdi-pencil-outline"></i>
                                    </button>
                                    <button type="button" class="btn btn-outline-danger btn-action btn-remove-proses" data-id="${p.id}" title="Hapus">
                                         <i class="mdi mdi-trash-can-outline"></i>
                                    </button>
                                </div>
                            </td>
                        `;
                        prosesTable.appendChild(row);
                    });
                }
            })
            .catch(err => {
                console.error('Error loading proses:', err);
            });
    }

    // Load initial data
    loadProses();

    // Edit proses - klik nama atau edit button
    prosesTable.addEventListener('click', function(e) {
        const prosesId = e.target.closest('.nama-proses')?.dataset.id || 
                         e.target.closest('.btn-outline-primary')?.dataset.id;
        
        if(prosesId){
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
                        document.querySelector('#modalProsesLabel').innerHTML = '<i class="bx bx-edit me-2"></i>Edit Proses';
                        document.querySelector('#textAdd').innerHTML = '<i class="bx bx-save me-1"></i> Update Proses';
                        
                        bootstrap.Modal.getOrCreateInstance(modalProses).show();
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal memuat data proses' });
                    }
                }).catch(err => {
                    console.error('Error loading proses data:', err);
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan saat memuat data' });
                });
        }
    });

    // Tambah / edit proses
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
            Swal.fire({ icon: 'warning', title: 'Peringatan', text: 'Nama Proses wajib diisi!' });
            return;
        }

        spinner.classList.remove('d-none');
        text.classList.add('d-none');
        btnAddProses.disabled = true;

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
            btnAddProses.disabled = false;

            if (res.status === 'success') {
                form.reset();
                editProsesId = null;
                document.querySelector('#modalProsesLabel').innerHTML = '<i class="bx bx-plus-circle me-2"></i>Tambah Proses';
                document.querySelector('#textAdd').innerHTML = '<i class="bx bx-plus me-1"></i> Tambah Proses';
                
                bootstrap.Modal.getOrCreateInstance(modalProses).hide();
                
                // Update toast message
                const toastBody = toastEl.querySelector('.toast-body');
                toastBody.innerHTML = `<i class="bx bx-check-circle me-2"></i>${editProsesId ? 'Proses berhasil diupdate!' : 'Proses berhasil ditambahkan!'}`;
                toast.show();
                
                loadProses();
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: res.message || 'Gagal menyimpan proses' });
            }
        })
        .catch(err => {
            spinner.classList.add('d-none');
            text.classList.remove('d-none');
            btnAddProses.disabled = false;
            console.error('Error saving proses:', err);
            Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan. Silakan coba lagi.' });
        });
    });

    // Hapus proses
    prosesTable.addEventListener('click', function (e) {
        if (e.target.closest('.btn-remove-proses')) {
            const btn = e.target.closest('.btn-remove-proses');
            const prosesId = btn.dataset.id;
            
            Swal.fire({
                title: 'Hapus Proses?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
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
                            toastEl.querySelector('.toast-body').innerHTML = '<i class="bx bx-check-circle me-2"></i>Proses berhasil dihapus!';
                            toast.show();
                            loadProses();
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: 'Gagal menghapus proses' });
                        }
                    })
                    .catch(err => {
                        btn.disabled = false;
                        console.error('Error deleting proses:', err);
                        Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan. Silakan coba lagi.' });
                    });
                }
            });
        }
    });

    // Reset form ketika modal ditutup
    modalProses.addEventListener('hidden.bs.modal', function () {
        const form = document.querySelector('#formProses');
        form.reset();
        editProsesId = null;
        document.querySelector('#modalProsesLabel').innerHTML = '<i class="bx bx-plus-circle me-2"></i>Tambah Proses';
        document.querySelector('#textAdd').innerHTML = '<i class="bx bx-plus me-1"></i> Tambah Proses';
    });
});
</script>
@endpush