@extends('layouts.commonMaster')

@section('title', 'Daftar Provinsi')

@section('layoutContent')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Provinsi</h5>
            <a href="{{ route('provinsi.create') }}" class="btn btn-primary btn-sm">Tambah Provinsi</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Provinsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($provinsi as $index => $p)
                        <tr>
                            <td>{{ $provinsi->firstItem() + $index }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>
                                <a href="{{ route('provinsi.edit', $p->id) }}" class="btn btn-warning btn-sm"><i class="mdi mdi-pencil-outline"></i></a>
                                <form action="{{ route('provinsi.destroy', $p->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus provinsi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="mdi mdi-trash-can-outline"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada data provinsi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-end">
              {{ $provinsi->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
