@extends('layouts.commonMaster')

@section('title', 'Daftar Kabupaten')

@section('layoutContent')
<div class="container">
    <div class="card shadow-sm border-0">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Daftar Kabupaten</h5>
            <a href="{{ route('kabupaten.create') }}" class="btn btn-primary btn-sm">Tambah Kabupaten</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Nama Kabupaten</th>
                            <th>Provinsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kabupaten as $index => $k)
                        <tr>
                            <td>{{ $kabupaten->firstItem() + $index }}</td>
                            <td>{{ $k->nama }}</td>
                            <td>{{ $k->provinsi->nama ?? '-' }}</td>
                            <td>
                                <a href="{{ route('kabupaten.edit', $k->id) }}" class="btn btn-warning btn-sm"><i class="mdi mdi-pencil-outline"></i></a>
                                <form action="{{ route('kabupaten.destroy', $k->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kabupaten ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="mdi mdi-trash-can-outline"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada data kabupaten</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="d-flex justify-content-end">
            {{ $kabupaten->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
