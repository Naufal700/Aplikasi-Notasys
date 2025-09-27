@extends('layouts.commonMaster')

@section('title', 'Master Jenis Akta')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    {{-- Card Master Jenis Akta --}}
    <div class="card shadow-sm">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
            <div>
                <h4 class="fw-bold mb-0">Master Jenis Akta</h4>
                <small class="text-muted">Kelola data tipe dan nama akta</small>
            </div>
            <a href="{{ route('jenis.akta.create') }}" class="btn btn-primary mt-2 mt-md-0">
                <i data-feather="plus" class="me-1"></i> Tambah Data
            </a>
        </div>

        <div class="card-body">
                       <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr class="text-nowrap">
                            <th class="text-center" style="width: 5%">No</th>
                            <th style="width: 25%">Tipe Akta</th>
                            <th style="width: 40%">Nama Akta</th>
                            <th class="text-center" style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $row)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $row->tipe->nama_tipe ?? '-' }}</td>
<td>{{ $row->nama_akta }}</td>

                            <td class="text-center">
                                <a href="{{ route('jenis.akta.edit', $row->id) }}" 
                                class="btn btn-warning btn-icon btn-sm" title="Edit">
                                   <i class="mdi mdi-pencil-outline"></i>
                                </a>
                                <form id="deleteForm{{ $row->id }}" 
      action="{{ route('jenis.akta.destroy', $row->id) }}" 
      method="POST" class="d-inline">
    @csrf @method('DELETE')
    <button type="button" class="btn btn-danger btn-icon btn-sm" 
        onclick="confirmDelete(event, 'deleteForm{{ $row->id }}')" 
        title="Hapus">
        <i class="mdi mdi-trash-can-outline"></i>
    </button>
</form>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Belum ada data</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
               <div class="d-flex justify-content-end">
    {{ $data->withQueryString()->links('pagination::bootstrap-5') }}
</div>

            </div>
        </div>
    </div>

</div>
@endsection
