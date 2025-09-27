@extends('layouts.commonMaster')

@section('title', 'Tambah Kabupaten')

@section('layoutContent')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <h5 class="mb-0">Tambah Kabupaten</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('kabupaten.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="provinsi_id" class="form-label">Provinsi</label>
                        <select name="provinsi_id" id="provinsi_id" class="form-select select2" required>
                            <option value="">-- Pilih Provinsi --</option>
                            @foreach($provinsi as $p)
                                <option value="{{ $p->id }}">{{ $p->nama }}</option>
                            @endforeach
                        </select>
                        @error('provinsi_id')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>

                    <div class="col-md-6">
                        <label for="nama" class="form-label">Nama Kabupaten</label>
                        <input type="text" name="nama" class="form-control" required>
                        @error('nama')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('kabupaten.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#provinsi_id').select2({
            placeholder: "-- Pilih Provinsi --",
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endpush
