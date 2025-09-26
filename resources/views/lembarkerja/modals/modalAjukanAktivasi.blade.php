<div class="modal fade" id="modalAjukanAktivasi" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Keterangan Aktivasi</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <label for="keterangan">Keterangan (opsional)</label>
        <textarea class="form-control" id="keterangan" rows="3" placeholder="Tambahkan keterangan jika perlu..."></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" class="btn btn-primary" id="btnSubmitAktivasi">OK</button>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const btnAjukan = document.getElementById('btnAjukanAktivasi');

    const modalAktivasiEl = document.getElementById('modalAjukanAktivasi');
    const modalAktivasi = new bootstrap.Modal(modalAktivasiEl);
    const btnSubmitAktivasi = document.getElementById('btnSubmitAktivasi');

    const modalTagihanEl = document.getElementById('modalTambahTagihan');
    const modalTagihan = new bootstrap.Modal(modalTagihanEl);

    btnAjukan.addEventListener('click', function() {
        if(btnAjukan.dataset.status !== "tambahTagihan"){
            // Tampilkan modal Aktivasi
            modalAktivasi.show();
        } else {
            // Tampilkan modal Tambah Tagihan
            modalTagihan.show();
        }
    });

    btnSubmitAktivasi.addEventListener('click', function() {
        modalAktivasi.hide();

        btnAjukan.innerHTML = '<i data-feather="plus-circle" class="me-1"></i> Tagihan';
        btnAjukan.classList.remove("btn-success");
        btnAjukan.classList.add("btn-primary");
        btnAjukan.dataset.status = "tambahTagihan";

        if(window.feather) feather.replace();
    });
});

</script>
@endpush
