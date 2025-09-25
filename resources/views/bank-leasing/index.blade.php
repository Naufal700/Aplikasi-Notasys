@extends('layouts.commonMaster')

@section('title', 'Daftar Bank/Leasing')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold">Daftar Bank / Leasing</h5>
            <a href="{{ route('bank-leasing.create') }}" class="btn btn-primary">Tambah Bank/Leasing</a>
        </div>
        <div class="card-body">

            {{-- Filter --}}
            <form method="GET" class="mb-4 row g-2 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">Cabang</label>
                    <input type="text" name="cabang" class="form-control" placeholder="Cari Cabang" value="{{ request('cabang') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Buat Dari</label>
                    <input type="date" name="tanggal_dari" class="form-control" value="{{ request('tanggal_dari') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Tanggal Buat Sampai</label>
                    <input type="date" name="tanggal_sampai" class="form-control" value="{{ request('tanggal_sampai') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary"><i class="mdi mdi-filter-variant" title="Filter"></i></button>
                 <a href="{{ route('bank-leasing.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="mdi mdi-refresh"></i></a>
                </div>
            </form>
             <div class="table-responsive text-nowrap">
      <table class="table table-bordered">
      <thead class="table-primary">
        <tr class="text-nowrap">
                                 <th>#</th>
                            <th>Nama Lembaga</th>
                            <th>Cabang</th>
                            <th>No PKS</th>
                            <th>Tanggal Berakhir PKS</th>
                            <th>Nama Marketing</th>
                            <th>No HP Marketing</th>
                            <th>Nama ADK</th>
                            <th>No HP ADK</th>
                            <th>Nama Legal</th>
                            <th>No HP Legal</th>
                            <th>Tanggal Buat</th>
                            <th>Tanggal Update</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bankLeasings as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_lembaga }}</td>
                            <td>{{ $item->cabang }}</td>
                            <td>{{ $item->no_pks }}</td>
                            <td>{{ $item->tanggal_berakhir_pks ? \Carbon\Carbon::parse($item->tanggal_berakhir_pks)->format('d-m-Y') : '-' }}</td>
                            <td>{{ $item->nama_marketing }}</td>
                            <td>{{ $item->no_hp_marketing }}</td>
                            <td>{{ $item->nama_adk }}</td>
                            <td>{{ $item->no_hp_adk }}</td>
                            <td>{{ $item->nama_legal }}</td>
                            <td>{{ $item->no_hp_legal }}</td>
                            <td>{{ $item->created_at ? \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') : '-' }}</td>
                            <td>{{ $item->updated_at ? \Carbon\Carbon::parse($item->updated_at)->format('d-m-Y') : '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('bank-leasing.edit', $item->id) }}"  class="btn btn-warning btn-icon btn-sm" title="Edit">
<i class="mdi mdi-pencil-outline"></i>
                                </a>
                                <form action="{{ route('bank-leasing.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin hapus?')">
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
                            <td colspan="14" class="text-center">Data kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $bankLeasings->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
