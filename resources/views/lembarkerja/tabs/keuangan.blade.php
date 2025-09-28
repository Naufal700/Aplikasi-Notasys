{{-- resources/views/lembarkerja/tabs/keuangan.blade.php --}}
<div class="mb-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h5 class="mb-0">
            <i class="bx bx-money me-2"></i>Daftar Tagihan
        </h5>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-secondary" id="btnRefreshKeuangan">
                <i class="bx bx-refresh me-1"></i> Refresh
            </button>
            {{-- <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahTagihan">
                <i class="bx bx-plus me-1"></i> Tambah Tagihan
            </button> --}}
        </div>
    </div>

    {{-- Summary Cards --}}
    {{-- <div class="row mb-4">
        <div class="col-md-3 col-6 mb-3">
            <div class="card bg-primary text-white">
                <div class="card-body p-3 text-center">
                    <i class="bx bx-receipt fs-2 mb-2"></i>
                    <h6 class="mb-1">Total Tagihan</h6>
                    <h5 class="mb-0">Rp {{ number_format($totalTagihan ?? 0, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card bg-success text-white">
                <div class="card-body p-3 text-center">
                    <i class="bx bx-check-circle fs-2 mb-2"></i>
                    <h6 class="mb-1">Total Dibayar</h6>
                    <h5 class="mb-0">Rp {{ number_format($totalDibayar ?? 0, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card bg-warning text-dark">
                <div class="card-body p-3 text-center">
                    <i class="bx bx-time fs-2 mb-2"></i>
                    <h6 class="mb-1">Sisa Tagihan</h6>
                    <h5 class="mb-0">Rp {{ number_format($sisaTagihan ?? 0, 0, ',', '.') }}</h5>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-6 mb-3">
            <div class="card bg-info text-white">
                <div class="card-body p-3 text-center">
                    <i class="bx bx-calendar fs-2 mb-2"></i>
                    <h6 class="mb-1">Jumlah Tagihan</h6>
                    <h5 class="mb-0">{{ $lembarKerja->tagihan->count() }}</h5>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="keuanganTable">
                    <thead class="table-light">
                        <tr>
                            <th width="5%" class="text-center">#</th>
                            <th width="12%">Tanggal</th>
                            <th width="15%">Jenis</th>
                            <th width="15%">Total Tagihan</th>
                            <th width="12%">Jatuh Tempo</th>
                            <th width="15%">Metode Pembayaran</th>
                            <th width="20%">Keterangan</th>
                            <th width="10%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lembarKerja->tagihan as $index => $tagihan)
                        <tr id="tagihanRow{{ $tagihan->id }}">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>
                                <span class="fw-medium">{{ \Carbon\Carbon::parse($tagihan->tanggal)->format('d/m/Y') }}</span>
                            </td>
                            <td>
                                <span class="badge bg-primary">{{ $tagihan->kategori->nama_kategori ?? '-' }}</span>
                            </td>
                            <td>
                                <span class="fw-bold text-success">Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</span>
                            </td>
                            <td>
                                @php
                                    $isOverdue = \Carbon\Carbon::parse($tagihan->jatuh_tempo)->isPast() && !$tagihan->selesai;
                                @endphp
                                <span class="{{ $isOverdue ? 'text-danger fw-medium' : '' }}">
                                    {{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d/m/Y') }}
                                    @if($isOverdue)
                                    <i class="bx bx-error text-danger" title="Jatuh Tempo"></i>
                                    @endif
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-secondary">{{ $tagihan->metode_pembayaran }}</span>
                            </td>
                            <td>
                                @if($tagihan->keterangan)
                                <span class="text-truncate" title="{{ $tagihan->keterangan }}">
                                    <i class="bx bx-note me-1"></i>
                                    {{ Str::limit($tagihan->keterangan, 50) }}
                                </span>
                                @else
                                <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button class="btn btn-outline-primary btnEditTagihan" 
                                            data-id="{{ $tagihan->id }}" 
                                            data-tanggal="{{ $tagihan->tanggal }}"
                                            data-total="{{ $tagihan->total_tagihan }}"
                                            data-jatuh_tempo="{{ $tagihan->jatuh_tempo }}"
                                            data-metode="{{ $tagihan->metode_pembayaran }}"
                                            data-keterangan="{{ $tagihan->keterangan }}"
                                            title="Edit Tagihan">
                                        <i class="bx bx-edit"></i>
                                    </button>
                                    <button class="btn btn-outline-danger btnHapusTagihan" 
                                            data-id="{{ $tagihan->id }}"
                                            title="Hapus Tagihan">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr id="emptyTagihanMessage">
                            <td colspan="8" class="text-center py-4 text-muted">
                                <i class="bx bx-inbox fs-1 d-block mb-2"></i>
                                Belum ada tagihan yang ditambahkan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
.keuangan-table tbody tr {
    transition: all 0.2s ease;
}

.keuangan-table tbody tr:hover {
    background-color: #f8f9fa;
}

.card {
    border: none;
    border-radius: 0.5rem;
}

.table th {
    font-weight: 600;
    font-size: 0.875rem;
    border-bottom: 2px solid #e9ecef;
}

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}

.badge {
    font-size: 0.75rem;
    padding: 0.25rem 0.5rem;
}
</style>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    // Feather Icons Replace
    if(window.feather) feather.replace();

    let keuanganTable;
    if(window.jQuery && $.fn.DataTable){
        keuanganTable = $('#keuanganTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            responsive: true,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                paginate: {
                    first: "Pertama",
                    last: "Terakhir",
                    next: "Selanjutnya",
                    previous: "Sebelumnya"
                }
            }
        });
    }

    // REFRESH TABLE
    document.getElementById('btnRefreshKeuangan').addEventListener('click', function(){
        const btn = this;
        const originalHtml = btn.innerHTML;
        
        btn.innerHTML = '<i class="bx bx-loader bx-spin me-1"></i> Loading...';
        btn.disabled = true;
        
        setTimeout(() => {
            location.reload();
        }, 500);
    });

    // EDIT TAGIHAN
    document.querySelectorAll('.btnEditTagihan').forEach(btn => {
        btn.addEventListener('click', function() {
            const id = this.dataset.id;
            const modal = new bootstrap.Modal(document.getElementById('modalTambahTagihan'));
            const form = document.getElementById('formTambahTagihan');

            // Set values ke modal
            form.querySelector('input[name="tanggal"]').value = this.dataset.tanggal;
            form.querySelector('input[name="total_tagihan"]').value = this.dataset.total;
            form.querySelector('input[name="jatuh_tempo"]').value = this.dataset.jatuh_tempo;
            form.querySelector('select[name="metode_pembayaran"]').value = this.dataset.metode;
            form.querySelector('textarea[name="keterangan"]').value = this.dataset.keterangan || '';
            
            // Set edit mode
            form.dataset.editId = id;
            form.querySelector('button[type="submit"]').innerHTML = '<i class="bx bx-save me-1"></i> Update Tagihan';
            
            // Update modal title
            document.querySelector('#modalTambahTagihan .modal-title').innerHTML = '<i class="bx bx-edit me-2"></i>Edit Tagihan';

            modal.show();
        });
    });

    // SUBMIT FORM TAGIHAN
    const formTagihan = document.getElementById('formTambahTagihan');
    if(formTagihan) {
        formTagihan.addEventListener('submit', async function(e){
            e.preventDefault();

            const editId = this.dataset.editId;
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;

            // Show loading
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Loading...';
            submitBtn.disabled = true;

            const formData = new FormData(this);

            try {
                let url, method;
                if(editId) {
                    // UPDATE
                    url = `{{ url('lembar-kerja/'.$lembarKerja->id.'/tagihan') }}/${editId}`;
                    method = 'PUT';
                } else {
                    // CREATE
                    url = `{{ route('lembar-kerja.tagihan.store', $lembarKerja->id) }}`;
                    method = 'POST';
                }

                const res = await fetch(url, {
                    method: method,
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const data = await res.json();

                if(res.ok && data.status === 'success'){
                    // Reset button
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;

                    // Show success message
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: editId ? 'Tagihan berhasil diperbarui' : 'Tagihan berhasil ditambahkan',
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                        showConfirmButton: false
                    });

                    // Close modal and reload
                    bootstrap.Modal.getInstance(document.getElementById('modalTambahTagihan')).hide();
                    setTimeout(() => {
                        location.reload();
                    }, 1000);

                } else {
                    throw new Error(data.message || 'Gagal menyimpan tagihan');
                }
            } catch(err){
                console.error(err);
                
                // Reset button
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: err.message || 'Terjadi kesalahan server!'
                });
            }
        });
    }

    // HAPUS TAGIHAN
    document.querySelectorAll('.btnHapusTagihan').forEach(btn => {
        btn.addEventListener('click', function() {
            const tagihanId = this.dataset.id;
            const tagihanAmount = this.closest('tr').querySelector('td:nth-child(4)').textContent;
            
            Swal.fire({
                title: 'Hapus Tagihan?',
                html: `<div class="text-start">
                         <p>Anda akan menghapus tagihan:</p>
                         <div class="alert alert-danger py-2">
                             <strong>${tagihanAmount}</strong>
                         </div>
                         <p class="text-danger mb-0">Data yang dihapus tidak bisa dikembalikan!</p>
                       </div>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: '<i class="bx bx-trash me-1"></i> Ya, Hapus!',
                cancelButtonText: '<i class="bx bx-x me-1"></i> Batal',
                reverseButtons: true
            }).then(async (result) => {
                if(result.isConfirmed){
                    try {
                        const res = await fetch(`{{ url('lembar-kerja/'.$lembarKerja->id.'/tagihan') }}/${tagihanId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                                'Accept': 'application/json'
                            }
                        });
                        
                        const data = await res.json();
                        
                        if(res.ok && data.status === 'success'){
                            // Remove row from table
                            const row = document.getElementById('tagihanRow' + tagihanId);
                            if(row) row.remove();
                            
                            // Show empty message if no rows left
                            const tbody = document.querySelector('#keuanganTable tbody');
                            if(tbody.children.length === 1 && tbody.querySelector('#emptyTagihanMessage')) {
                                tbody.querySelector('#emptyTagihanMessage').classList.remove('d-none');
                            }
                            
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: 'Tagihan berhasil dihapus',
                                toast: true,
                                position: 'top-end',
                                timer: 3000,
                                showConfirmButton: false
                            });
                            
                            // Reload to update summary cards
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                            
                        } else {
                            throw new Error(data.message || 'Gagal menghapus tagihan');
                        }
                    } catch(err){
                        console.error(err);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: err.message || 'Terjadi kesalahan server!'
                        });
                    }
                }
            });
        });
    });

    // Reset modal when closed
    const modalTambahTagihan = document.getElementById('modalTambahTagihan');
    if(modalTambahTagihan) {
        modalTambahTagihan.addEventListener('hidden.bs.modal', function () {
            const form = document.getElementById('formTambahTagihan');
            if(form) {
                form.reset();
                delete form.dataset.editId;
                form.querySelector('button[type="submit"]').innerHTML = '<i class="bx bx-save me-1"></i> Simpan Tagihan';
                document.querySelector('#modalTambahTagihan .modal-title').innerHTML = '<i class="bx bx-plus-circle me-2"></i>Tambah Tagihan';
                
                // Set default dates
                const today = new Date().toISOString().split('T')[0];
                const nextWeek = new Date();
                nextWeek.setDate(nextWeek.getDate() + 7);
                const nextWeekFormatted = nextWeek.toISOString().split('T')[0];
                
                form.querySelector('input[name="tanggal"]').value = today;
                form.querySelector('input[name="jatuh_tempo"]').value = nextWeekFormatted;
            }
        });
    }
});
</script>
@endpush