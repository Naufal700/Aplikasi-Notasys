@extends('layouts.commonMaster')

@section('title', 'Edit Bank/Leasing')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Edit Bank / Leasing</h5>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('bank-leasing.update', $bankLeasing->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Lembaga <span class="text-danger">*</span></label>
                        <input type="text" name="nama_lembaga" class="form-control"
                               value="{{ old('nama_lembaga', $bankLeasing->nama_lembaga) }}" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Cabang <span class="text-danger">*</span></label>
                        <input type="text" name="cabang" class="form-control"
                               value="{{ old('cabang', $bankLeasing->cabang) }}" required>
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">No PKS</label>
                        <input type="text" name="no_pks" class="form-control"
                               value="{{ old('no_pks', $bankLeasing->no_pks) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Tanggal Berakhir PKS</label>
                        <input type="date" name="tanggal_berakhir_pks" class="form-control"
                               value="{{ old('tanggal_berakhir_pks', $bankLeasing->tanggal_berakhir_pks ? \Carbon\Carbon::parse($bankLeasing->tanggal_berakhir_pks)->format('Y-m-d') : '') }}">
                    </div>
                </div>

                <h6 class="mt-4">Marketing</h6>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Marketing</label>
                        <input type="text" name="nama_marketing" class="form-control"
                               value="{{ old('nama_marketing', $bankLeasing->nama_marketing) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No HP Marketing</label>
                        <input type="text" name="no_hp_marketing" class="form-control"
                               value="{{ old('no_hp_marketing', $bankLeasing->no_hp_marketing) }}">
                    </div>
                </div>

                <h6 class="mt-4">ADK</h6>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama ADK</label>
                        <input type="text" name="nama_adk" class="form-control"
                               value="{{ old('nama_adk', $bankLeasing->nama_adk) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No HP ADK</label>
                        <input type="text" name="no_hp_adk" class="form-control"
                               value="{{ old('no_hp_adk', $bankLeasing->no_hp_adk) }}">
                    </div>
                </div>

                <h6 class="mt-4">Legal</h6>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nama Legal</label>
                        <input type="text" name="nama_legal" class="form-control"
                               value="{{ old('nama_legal', $bankLeasing->nama_legal) }}">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">No HP Legal</label>
                        <input type="text" name="no_hp_legal" class="form-control"
                               value="{{ old('no_hp_legal', $bankLeasing->no_hp_legal) }}">
                    </div>
                </div>

                <div class="mt-4 d-flex gap-2">
                    <button type="submit" class="btn btn-success">Update</button>
                    <a href="{{ route('bank-leasing.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
