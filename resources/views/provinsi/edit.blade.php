@extends('layouts.commonMaster')

@section('title', 'Edit Provinsi')

@section('layoutContent')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="mb-0">Edit Provinsi</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('provinsi.update', $provinsi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nama" class="form-label">Nama Provinsi</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama', $provinsi->nama) }}" required>
                    @error('nama')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Update</button>
                <a href="{{ route('provinsi.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
