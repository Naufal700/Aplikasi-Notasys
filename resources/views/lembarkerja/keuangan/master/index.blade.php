@extends('layouts.commonMaster')
@section('title','Master Kas & Bank')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">

            {{-- Header: Judul + Tombol Tambah --}}
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-2">
                <h5 class="mb-2 mb-md-0 fw-bold">Master Kas & Bank</h5>
                <a href="{{ route('master.kasbank.create') }}" class="btn btn-primary">Tambah Data</a>
            </div>

            {{-- Filter Form --}}
            <form id="filterForm" method="GET" action="{{ route('master.kasbank.index') }}" class="row g-3 align-items-end mb-3">
                <div class="col-md-4">
                    <label for="search" class="form-label">Cari Nama Akun / Bank</label>
                    <input type="text" class="form-control" name="search" id="search" value="{{ request('search') }}" placeholder="Masukkan kata kunci...">
                </div>
                <div class="col-md-3">
                    <label for="jenis" class="form-label">Jenis</label>
                    <select name="jenis" id="jenis" class="form-select">
                        <option value="">Semua</option>
                        <option value="Kas" {{ request('jenis') == 'Kas' ? 'selected' : '' }}>Kas</option>
                        <option value="Bank" {{ request('jenis') == 'Bank' ? 'selected' : '' }}>Bank</option>
                    </select>
                </div>
                <div class="col-md-5 d-flex gap-2">
                    <button type="submit" class="btn btn-primary"><i class="mdi mdi-filter-variant" title="Filter"></i></button>
                    <a href="{{ route('master.kasbank.index') }}" class="btn btn-secondary"><i class="mdi mdi-refresh"></i></a>
                </div>
            </form>

            {{-- Tabel Data --}}
            <div class="table-responsive">
              {{-- Tabel Data --}}
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover">
        <thead class="table-primary">
            <tr>
                <th>No</th>
                <th>Jenis</th>
                <th>Nama Akun / Bank</th>
                <th>Atas Nama</th>
                <th>No Rekening</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $i => $d)
            <tr>
                <td>{{ ($data->currentPage()-1)*$data->perPage() + $i + 1 }}</td>
                <td>{{ $d->jenis }}</td>
                <td>{{ $d->jenis == 'Kas' ? $d->nama_akun : $d->nama_bank }}</td>
                <td>{{ $d->atas_nama ?? '-' }}</td>
                <td>{{ $d->nomor_rekening ?? '-' }}</td>
                <td class="text-nowrap">
                    <a href="{{ route('master.kasbank.edit', $d->id) }}" class="btn btn-sm btn-warning me-1">
                        <i class="mdi mdi-pencil-outline"></i>
                    </a>

                    <form id="deleteForm{{ $d->id }}" action="{{ route('master.kasbank.destroy', $d->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-sm btn-danger"
                            onclick="confirmDelete(event, 'deleteForm{{ $d->id }}', '{{ $d->jenis == 'Kas' ? $d->nama_akun : $d->nama_bank }}')"
                            title="Hapus">
                            <i class="mdi mdi-trash-can-outline"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Data kosong</td>
            </tr>
            @endforelse
        </tbody>
    </table>
    {{-- Pagination --}}
    <div class="d-flex justify-content-end">
        {{ $data->links('pagination::bootstrap-5') }}
    </div>
</div>
            </div>

        </div>
    </div>
</div>
@endsection
