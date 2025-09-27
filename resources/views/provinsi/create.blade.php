@extends('layouts.commonMaster')

@section('title', 'Tambah Provinsi')

@section('layoutContent')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="mb-0">Tambah Provinsi</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('provinsi.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Provinsi</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="{{ route('provinsi.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
