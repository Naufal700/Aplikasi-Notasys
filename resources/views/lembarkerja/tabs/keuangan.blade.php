{{-- Tabel Keuangan --}}
<div class="mb-3">
    <div class="table-responsive">
        <table class="table table-bordered" id="keuanganTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Jenis Transaksi</th>
                    <th>Tanggal</th>
                    <th>Deskripsi</th>
                    <th>Total Tagihan</th>
                    <th>Jatuh Tempo</th>
                    <th>Metode Pembayaran</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lembarKerja->keuangan ?? [] as $index => $k)
                <tr data-idx="{{ $index }}">
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $k->jenis_transaksi }}<input type="hidden" name="keuangan[{{ $index }}][jenis_transaksi]" value="{{ $k->jenis_transaksi }}"></td>
                    <td>{{ $k->tanggal }}<input type="hidden" name="keuangan[{{ $index }}][tanggal]" value="{{ $k->tanggal }}"></td>
                    <td>{{ $k->deskripsi }}<input type="hidden" name="keuangan[{{ $index }}][deskripsi]" value="{{ $k->deskripsi }}"></td>
                    <td>Rp {{ number_format($k->total_tagihan,0,',','.') }}<input type="hidden" name="keuangan[{{ $index }}][total_tagihan]" value="{{ $k->total_tagihan }}"></td>
                    <td>{{ $k->jatuh_tempo }}<input type="hidden" name="keuangan[{{ $index }}][jatuh_tempo]" value="{{ $k->jatuh_tempo }}"></td>
                    <td>{{ $k->metode_pembayaran }}<input type="hidden" name="keuangan[{{ $index }}][metode_pembayaran]" value="{{ $k->metode_pembayaran }}"></td>
                    <td>{{ $k->keterangan }}<input type="hidden" name="keuangan[{{ $index }}][keterangan]" value="{{ $k->keterangan }}"></td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center">Belum ada transaksi keuangan</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Script untuk menambahkan data dari modal --}}
<script>
document.addEventListener("DOMContentLoaded", function () {

    const formTambah = document.getElementById("formTambahTagihan");
    const keuanganTable = document.getElementById("keuanganTable").querySelector("tbody");
    let rowIndex = keuanganTable.querySelectorAll("tr").length;

    formTambah.addEventListener("submit", function(e) {
        e.preventDefault();

        // Ambil data dari modal
        const formData = new FormData(formTambah);
        const tanggal = formData.get("tanggal");
        const jenis = formData.get("jenis");
        const total_tagihan = formData.get("total_tagihan");
        const jatuh_tempo = formData.get("jatuh_tempo");
        const metode_pembayaran = formData.get("metode_pembayaran");
        const keterangan = formData.get("keterangan");

        // Tambahkan baris baru ke tabel
        const newRow = document.createElement("tr");
        newRow.innerHTML = `
            <td>${rowIndex + 1}</td>
            <td>${jenis}<input type="hidden" name="keuangan[${rowIndex}][jenis_transaksi]" value="${jenis}"></td>
            <td>${tanggal}<input type="hidden" name="keuangan[${rowIndex}][tanggal]" value="${tanggal}"></td>
            <td>${keterangan}<input type="hidden" name="keuangan[${rowIndex}][deskripsi]" value="${keterangan}"></td>
            <td>Rp ${parseInt(total_tagihan).toLocaleString('id-ID')}<input type="hidden" name="keuangan[${rowIndex}][total_tagihan]" value="${total_tagihan}"></td>
            <td>${jatuh_tempo}<input type="hidden" name="keuangan[${rowIndex}][jatuh_tempo]" value="${jatuh_tempo}"></td>
            <td>${metode_pembayaran}<input type="hidden" name="keuangan[${rowIndex}][metode_pembayaran]" value="${metode_pembayaran}"></td>
            <td>${keterangan}<input type="hidden" name="keuangan[${rowIndex}][keterangan]" value="${keterangan}"></td>
        `;
        keuanganTable.appendChild(newRow);
        rowIndex++;

        // Reset form & tutup modal
        formTambah.reset();
        const modalEl = document.getElementById("modalTambahTagihan");
        const modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();
    });
});
</script>
