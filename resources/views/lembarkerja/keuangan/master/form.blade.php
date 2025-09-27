@extends('layouts.commonMaster')
@section('title', isset($item) ? 'Edit Kas & Bank' : 'Tambah Kas & Bank')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold mb-4">{{ isset($item) ? 'Edit' : 'Tambah' }} Kas & Bank</h4>

    <div class="card">
        <div class="card-body">
            <form action="{{ isset($item) ? route('master.kasbank.update', $item->id) : route('master.kasbank.store') }}" method="POST">
                @csrf
                @if(isset($item)) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-md-6">
                        <label>Jenis</label>
                        <select name="jenis" id="jenis" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            <option value="Kas" {{ (isset($item) && $item->jenis=='Kas') ? 'selected' : '' }}>Kas</option>
                            <option value="Bank" {{ (isset($item) && $item->jenis=='Bank') ? 'selected' : '' }}>Bank</option>
                        </select>
                    </div>

                    <!-- Kas -->
                    <div class="col-md-6">
                        <label>Nama Kas</label>
                        <input type="text" name="nama_akun" id="nama_akun" class="form-control" value="{{ $item->nama_akun ?? '' }}">
                    </div>

                    <!-- Bank -->
                    <div class="col-md-4">
                        <label>Nama Bank</label>
                        <input type="text" name="nama_bank" id="nama_bank" class="form-control" value="{{ $item->nama_bank ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label>Atas Nama</label>
                        <input type="text" name="atas_nama" id="atas_nama" class="form-control" value="{{ $item->atas_nama ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label>No Rekening</label>
                        <input type="text" name="nomor_rekening" id="nomor_rekening" class="form-control" value="{{ $item->nomor_rekening ?? '' }}">
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-primary">{{ isset($item) ? 'Update' : 'Simpan' }}</button>
                    <a href="{{ route('master.kasbank.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const jenis = document.getElementById('jenis');
    const namaKas = document.getElementById('nama_akun');
    const namaBank = document.getElementById('nama_bank');
    const atasNama = document.getElementById('atas_nama');
    const noRek = document.getElementById('nomor_rekening');

    function toggleFields() {
        if(jenis.value === 'Kas') {
            namaKas.disabled = false;
            namaBank.disabled = true;
            atasNama.disabled = true;
            noRek.disabled = true;
        } else if(jenis.value === 'Bank') {
            namaKas.disabled = true;
            namaBank.disabled = false;
            atasNama.disabled = false;
            noRek.disabled = false;
        } else {
            namaKas.disabled = true;
            namaBank.disabled = true;
            atasNama.disabled = true;
            noRek.disabled = true;
        }
    }

    jenis.addEventListener('change', toggleFields);
    toggleFields();
});
</script>
@endpush
