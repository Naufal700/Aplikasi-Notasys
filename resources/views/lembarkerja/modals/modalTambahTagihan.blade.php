<div class="modal fade" id="modalTambahTagihan" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formTambahTagihan">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title">Tambah Tagihan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label>Tanggal <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="tanggal" required>
            </div>
            <input type="hidden" name="jenis" value="Tagihan">
            <div class="mb-3">
                <label>Total Tagihan <span class="text-danger">*</span></label>
                <input type="number" class="form-control" name="total_tagihan" required>
            </div>
            <div class="mb-3">
                <label>Jatuh Tempo <span class="text-danger">*</span></label>
                <input type="date" class="form-control" name="jatuh_tempo" required>
            </div>
            <div class="mb-3">
                <label>Metode Pembayaran <span class="text-danger">*</span></label>
                <select class="form-select" name="metode_pembayaran" required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="Transfer">Transfer</option>
                    <option value="Tunai">Tunai</option>
                    <option value="EDC">EDC</option>
                </select>
            </div>
            <div class="mb-3">
                <label>Keterangan</label>
                <textarea class="form-control" name="keterangan" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-primary">Simpan Tagihan</button>
        </div>
      </form>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const modalTagihanEl = document.getElementById('modalTambahTagihan');
    const modalTagihan = new bootstrap.Modal(modalTagihanEl);
    const formTambahTagihan = document.getElementById('formTambahTagihan');

    formTambahTagihan.addEventListener('submit', async function(e){
        e.preventDefault();

        const formData = new FormData(formTambahTagihan);

        try {
            const res = await fetch("{{ route('lembar-kerja.tagihan.store', $lembarKerja->id) }}", {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: formData
            });

            const data = await res.json();

            if(res.status === 422){
                const messages = Object.values(data.errors).map(e => e.join(', ')).join('\n');
                showToast('error', 'Validasi gagal', messages);
                return;
            }

            if(data.status === 'success'){
                // Tutup modal
                modalTagihan.hide();

                // Reset form
                formTambahTagihan.reset();

                // Update badge total tagihan & sisa tagihan secara live
                const totalTagihanEl = document.getElementById('badgeTotalTagihan');
                const totalDibayarEl = document.getElementById('badgeTotalDibayar');
                const sisaTagihanEl = document.getElementById('badgeSisaTagihan');

                // Ambil nilai badge saat ini
                let currentTotal = parseInt(totalTagihanEl.dataset.total || 0);
                let totalDibayar = parseInt(totalDibayarEl.dataset.total || 0);
                let added = parseInt(formData.get('total_tagihan')) || 0;

                let newTotal = currentTotal + added;
                let newSisa = newTotal - totalDibayar;

                // Update data-total
                totalTagihanEl.dataset.total = newTotal;
                sisaTagihanEl.dataset.total = newSisa;

                // Update innerHTML
                totalTagihanEl.innerHTML = `<i data-feather="dollar-sign" class="me-1"></i> Total Tagihan: Rp ${newTotal.toLocaleString('id-ID')}`;
                sisaTagihanEl.innerHTML = `<i data-feather="alert-circle" class="me-1"></i> Sisa Tagihan: Rp ${newSisa.toLocaleString('id-ID')}`;

                if(window.feather) feather.replace();

                showToast('success', 'Berhasil', data.message);
            } else {
                showToast('error', 'Gagal', data.message || 'Gagal menyimpan tagihan!');
            }
        } catch(err){
            console.error(err);
            showToast('error', 'Kesalahan Server', 'Terjadi kesalahan server!');
        }
    });

    // ================= TOASTER =================
    function showToast(type, title, message){
        let toastContainer = document.getElementById('toastContainer');
        if(!toastContainer){
            toastContainer = document.createElement('div');
            toastContainer.id = 'toastContainer';
            toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
            document.body.appendChild(toastContainer);
        }

        const toastEl = document.createElement('div');
        toastEl.className = `toast align-items-center text-bg-${type === 'success' ? 'success' : 'danger'} border-0`;
        toastEl.role = 'alert';
        toastEl.ariaLive = 'assertive';
        toastEl.ariaAtomic = 'true';
        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <strong>${title}:</strong> ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        `;
        toastContainer.appendChild(toastEl);
        const bsToast = new bootstrap.Toast(toastEl, { delay: 3000 });
        bsToast.show();
    }
});
</script>
@endpush
