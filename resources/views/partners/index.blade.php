@extends('layouts.commonMaster')

@section('title', 'Daftar Partner Notaris PPAT')

@section('layoutContent')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Partner</h5>
            <a href="{{ route('partners.create') }}" class="btn btn-primary btn-sm">Tambah Partner</a>
        </div>
        <div class="card-body">
            {{-- Filter & Search --}}
           <form method="GET" class="row g-3 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama partner atau email">
    </div>
    <div class="col-md-3">
        <select name="provinsi_id" id="filter_provinsi" class="form-select">
            <option value="">-- Semua Provinsi --</option>
            @foreach($provinsiList as $p)
                <option value="{{ $p->id }}" {{ request('provinsi_id') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="kabupaten_id" id="filter_kabupaten" class="form-select">
            <option value="">-- Semua Kabupaten --</option>
            @foreach($kabupatenList as $k)
                <option value="{{ $k->id }}" {{ request('kabupaten_id') == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2 d-flex gap-1">
        <button type="submit" class="btn btn-outline-primary" title="Filter">
    <i class="mdi mdi-filter-variant"></i>
</button>
        <a href="{{ route('partners.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="mdi mdi-refresh"></i></a>
    </div>
</form>
            {{-- Table --}}
            <div class="table-responsive text-nowrap">
      <table class="table table-bordered">
      <thead class="table-primary">
        <tr class="text-nowrap">
                        <tr>
                            <th>#</th>
                            <th>Nama Partner</th>
                            <th>Provinsi</th>
                            <th>Kabupaten</th>
                            <th>Email</th>
                            <th>Alamat</th>
                            <th>PIC</th>
                            <th>Jabatan</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($partners as $index => $partner)
                        <tr>
                            <td>{{ $partners->firstItem() + $index }}</td>
                            <td>{{ $partner->nama }}</td>
                            <td>{{ $partner->provinsi->nama ?? '-' }}</td>
                            <td>{{ $partner->kabupaten->nama ?? '-' }}</td>
                            <td>{{ $partner->email ?? '-' }}</td>
                            <td>{{ $partner->alamat_lengkap ?? '-' }}</td>
                            <td>{{ $partner->pic_nama ?? '-' }}</td>
                            <td>{{ $partner->pic_jabatan ?? '-' }}</td>
                            <td>{{ $partner->pic_keterangan ?? '-' }}</td>
                            <td>
    <a href="{{ route('partners.edit', $partner->id) }}" class="btn btn-sm btn-warning">
        <i class="mdi mdi-pencil-outline"></i>
    </a>

    <form id="deleteForm{{ $partner->id }}" action="{{ route('partners.destroy', $partner->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="button" class="btn btn-danger btn-icon btn-sm" 
            onclick="confirmDelete(event, 'deleteForm{{ $partner->id }}', '{{ $partner->nama }}')" 
            title="Hapus">
            <i class="mdi mdi-trash-can-outline"></i>
        </button>
    </form>
</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Belum ada data partner</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-end">
                {{  $partners->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Select2 untuk filter provinsi/kabupaten
    $('#filter_provinsi').select2({ placeholder: "Pilih Provinsi" });
    $('#filter_kabupaten').select2({ placeholder: "Pilih Kabupaten" });

    // Load kabupaten berdasarkan provinsi saat filter berubah
    $('#filter_provinsi').change(function() {
        let provinsiId = $(this).val();
        $('#filter_kabupaten').html('<option value="">Loading...</option>');

        if(provinsiId){
            $.get("{{ url('partners/kabupaten') }}/"+provinsiId, function(data){
                let options = '<option value="">-- Semua Kabupaten --</option>';
                data.forEach(function(k){
                    options += `<option value="${k.id}">${k.nama}</option>`;
                });
                $('#filter_kabupaten').html(options);
            });
        } else {
            $('#filter_kabupaten').html('<option value="">-- Semua Kabupaten --</option>');
        }
    });
});
</script>
@endpush
