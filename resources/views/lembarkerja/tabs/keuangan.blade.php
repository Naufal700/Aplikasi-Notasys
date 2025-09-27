{{-- resources/views/lembarkerja/tabs/keuangan.blade.php --}}

<div class="d-flex justify-content-between mb-3">
    <h5 class="mb-0">Daftar Tagihan</h5>
    <button class="btn btn-sm btn-secondary" id="btnRefreshKeuangan">
        <i data-feather="refresh-cw" class="me-1"></i> Refresh
    </button>
</div>

<div class="table-responsive">
    <table class="table table-bordered table-striped" id="keuanganTable">
        <thead class="table-primary">
            <tr class="text-nowrap">
                <th>No</th>
                <th>Tanggal</th>
                <th>Jenis</th>
                <th>Total Tagihan</th>
                <th>Jatuh Tempo</th>
                <th>Metode Pembayaran</th>
                <th>Keterangan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($lembarKerja->tagihan as $index => $tagihan)
            <tr id="tagihanRow{{ $tagihan->id }}">
                <td>{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($tagihan->tanggal)->format('d-m-Y') }}</td>
<td>{{ $tagihan->kategori->nama_kategori ?? '-' }}</td>
                <td>Rp {{ number_format($tagihan->total_tagihan, 0, ',', '.') }}</td>
                <td>{{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d-m-Y') }}</td>
                <td>{{ $tagihan->metode_pembayaran }}</td>
                <td>{{ $tagihan->keterangan ?? '-' }}</td>
                <td>
                    {{-- Tombol Edit --}}
                    <button class="btn btn-sm btn-warning btnEditTagihan" 
                            data-id="{{ $tagihan->id }}" 
                            data-tanggal="{{ $tagihan->tanggal }}"
                            data-total="{{ $tagihan->total_tagihan }}"
                            data-jatuh_tempo="{{ $tagihan->jatuh_tempo }}"
                            data-metode="{{ $tagihan->metode_pembayaran }}"
                            data-keterangan="{{ $tagihan->keterangan }}">
                        <i data-feather="edit"></i>
                    </button>

                    {{-- Tombol Hapus --}}
                    <button class="btn btn-sm btn-danger btnHapusTagihan" data-id="{{ $tagihan->id }}">
                        <i data-feather="trash-2"></i>
                    </button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" class="text-center text-muted">Belum ada tagihan</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    let keuanganTable;
    if(window.jQuery && $.fn.DataTable){
        keuanganTable = $('#keuanganTable').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            info: true,
            responsive: true
        });
    }

    // REFRESH TABLE
    document.getElementById('btnRefreshKeuangan').addEventListener('click', function(){
        location.reload();
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
            form.dataset.editId = id;
            form.querySelector('button[type="submit"]').innerText = 'Update Tagihan';

            modal.show();
        });
    });

    // SUBMIT FORM TAGIHAN
    const formTagihan = document.getElementById('formTambahTagihan');
    formTagihan.addEventListener('submit', async function(e){
        e.preventDefault();

        const editId = this.dataset.editId;
        const formData = new FormData(this);

        if(editId){
            // UPDATE via AJAX
            try {
                const res = await fetch(`{{ url('lembar-kerja/'.$lembarKerja->id.'/tagihan') }}/${editId}`, {
                    method: 'PUT', // atau PATCH sesuai route
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                const data = await res.json();

                if(res.ok && data.status === 'success'){
                    // Update row tabel
                    const row = document.getElementById('tagihanRow' + editId);
                    row.querySelector('td:nth-child(2)').innerText = data.tagihan.tanggal_formatted;
                    row.querySelector('td:nth-child(3)').innerText = data.tagihan.jenis;
                    row.querySelector('td:nth-child(4)').innerText = `Rp ${data.tagihan.total_tagihan_formatted}`;
                    row.querySelector('td:nth-child(5)').innerText = data.tagihan.jatuh_tempo_formatted;
                    row.querySelector('td:nth-child(6)').innerText = data.tagihan.metode_pembayaran;
                    row.querySelector('td:nth-child(7)').innerText = data.tagihan.keterangan || '-';

                    toastr.success('Tagihan berhasil diperbarui');
                    bootstrap.Modal.getInstance(document.getElementById('modalTambahTagihan')).hide();
                } else {
                    toastr.error(data.message || 'Gagal mengupdate tagihan!');
                }
            } catch(err){
                console.error(err);
                toastr.error('Terjadi kesalahan server!');
            }
        }
    });

    // HAPUS TAGIHAN
    document.querySelectorAll('.btnHapusTagihan').forEach(btn => {
        btn.addEventListener('click', function() {
            const tagihanId = this.dataset.id;
            Swal.fire({
                title: 'Hapus Tagihan?',
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
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
                            document.getElementById('tagihanRow' + tagihanId).remove();
                            toastr.success(data.message);
                        } else {
                            toastr.error(data.message || 'Gagal menghapus tagihan!');
                        }
                    } catch(err){
                        console.error(err);
                        toastr.error('Terjadi kesalahan server!');
                    }
                }
            });
        });
    });

    // TOASTR OPTIONS
    toastr.options = {
        "positionClass": "toast-top-right",
        "timeOut": "3000",
        "closeButton": true,
        "progressBar": true
    };
});
</script>

@endpush
