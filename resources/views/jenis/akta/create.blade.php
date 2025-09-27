@extends('layouts.commonMaster')

@section('title', 'Tambah Jenis Akta')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Card Tambah Jenis Akta --}}
    <div class="card shadow-sm">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div>
                <h4 class="fw-bold mb-0">Tambah Jenis Akta</h4>
                <small class="text-muted">Isi data untuk menambahkan jenis akta baru</small>
            </div>
                   </div>

        <div class="card-body">
          <form action="{{ route('jenis.akta.store') }}" method="POST">
    @csrf

    <div class="row">
        {{-- Tipe Akta --}}
<div class="col-md-6 mb-3">
    <label for="tipe_akta_id" class="form-label">Tipe Akta</label>
    <select name="tipe_akta_id" id="tipe_akta_id" 
        class="form-select @error('tipe_akta_id') is-invalid @enderror" required>
        <option value="">-- Pilih Tipe Akta --</option>
        @foreach($tipe_akta as $tipe)
            <option value="{{ $tipe->id }}" 
                {{ old('tipe_akta_id') == $tipe->id ? 'selected' : '' }}>
                {{ $tipe->nama_tipe }}
            </option>
        @endforeach
    </select>
    @error('tipe_akta_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

        {{-- Nama Akta --}}
        <div class="col-md-6 mb-3">
            <label for="nama_akta" class="form-label">Nama Akta</label>
            <input type="text" name="nama_akta" id="nama_akta" 
                   class="form-control @error('nama_akta') is-invalid @enderror"
                   value="{{ old('nama_akta') }}" placeholder="Masukkan nama akta" required>
            @error('nama_akta')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    {{-- Tombol --}}
   {{-- Tombol --}}
<div class="d-flex justify-content-end gap-2">
    <a href="{{ route('jenis.akta.index') }}" class="btn btn-secondary">
        <i data-feather="arrow-left" class="me-1"></i> Kembali
    </a>
    <button type="submit" class="btn btn-primary">
        <i data-feather="save" class="me-1"></i> Simpan
    </button>
</div>

</form>

        </div>
    </div>

</div>
@endsection
