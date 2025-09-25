@extends('layouts.commonMaster')

@section('title', 'Daftar Perusahaan')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Daftar Perusahaan</h5>
            <a href="{{ route('perusahaan.create') }}" class="btn btn-primary">Tambah Perusahaan</a>
        </div>
        <div class="card-body">

            {{-- Filter --}}
            <form method="GET" class="mb-4 row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Jenis Lembaga</label>
                    <select name="jenis_lembaga" class="form-select">
                        <option value="">-- Semua --</option>
                        @foreach(['PT','CV','Koperasi','Yayasan'] as $jenis)
                            <option value="{{ $jenis }}" {{ request('jenis_lembaga') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Buat Dari</label>
                    <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Buat Sampai</label>
                    <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-outline-primary"><i class="mdi mdi-filter-variant" title="Filter"></i></button>
                    <a href="{{ route('perusahaan.index') }}"  class="btn btn-outline-secondary" title="Reset"><i class="mdi mdi-refresh"></i></a>
                </div>
            </form>

                       <div class="table-responsive text-nowrap">
      <table class="table table-bordered">
      <thead class="table-primary">
        <tr class="text-nowrap">
                                                    <th>#</th>
                            <th>Jenis Lembaga</th>
                            <th>Nama Lembaga</th>
                            <th>Email</th>
                            <th>Telp Kantor</th>
                            <th>Nama PIC</th>
                            <th>No Telp PIC</th>
                            <th>Tanggal Buat</th>
                            <th>Tanggal Update</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($perusahaans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->jenis_lembaga }}</td>
                            <td>{{ $item->nama_lembaga }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->telp_kantor }}</td>
                            <td>{{ $item->nama_pic }}</td>
                            <td>{{ $item->no_telp_pic }}</td>
                            <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') : '-' }}</td>
                            <td>{{ $item->updated_at ? \Carbon\Carbon::parse($item->updated_at)->format('d-m-Y') : '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('perusahaan.edit', $item->id) }}" class="btn btn-warning btn-icon btn-sm" title="Edit">
                                    <i class="mdi mdi-pencil-outline"></i>
                                </a>
                                <form action="{{ route('perusahaan.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus?')">
                                    @csrf
                                    @method('DELETE')
                                  <button type="button" class="btn btn-danger btn-icon btn-sm" 
            onclick="confirmDelete(event, 'deleteForm{{ $item->id }}')" 
            title="Hapus">
        <i class="mdi mdi-trash-can-outline"></i>
    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Data kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $perusahaans->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
