@extends('layouts.commonMaster')

@section('title', 'Edit Perusahaan')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Edit Perusahaan</h5>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('perusahaan.update', $perusahaan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Jenis Lembaga <span class="text-danger">*</span></label>
                        <select name="jenis_lembaga" class="form-select" required>
                            <option value="">-- Pilih Jenis --</option>
                            @foreach($jenisLembaga as $jenis)
                                <option value="{{ $jenis }}" {{ $perusahaan->jenis_lembaga == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Nama Lembaga <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lembaga" class="form-control" value="{{ $perusahaan->nama_lembaga }}" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Email Perusahaan</label>
                        <input type="email" name="email" class="form-control" value="{{ $perusahaan->email }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Telp Kantor</label>
                        <input type="text" name="telp_kantor" class="form-control" value="{{ $perusahaan->telp_kantor }}">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama PIC</label>
                        <input type="text" name="nama_pic" class="form-control" value="{{ $perusahaan->nama_pic }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No Telp PIC</label>
                        <input type="text" name="no_telp_pic" class="form-control" value="{{ $perusahaan->no_telp_pic }}">
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('perusahaan.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
