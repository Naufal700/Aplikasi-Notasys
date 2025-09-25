@extends('layouts.commonMaster')

@section('title', 'Daftar Lembar Kerja')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0 fw-bold">Daftar Lembar Kerja</h5>
                <div class="d-flex gap-2">
                    {{-- Search Form --}}
                    <form action="{{ route('lembar-kerja.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" value="{{ request('search') }}" placeholder="Search...">
                        <button type="submit" class="btn btn-outline-primary"><i class="mdi mdi-magnify"></i></button>
                    </form>

                    {{-- Tombol Tambah --}}
                    <a href="{{ route('lembar-kerja.create') }}" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i> + Lembar Kerja
                    </a>
                </div>
            </div>

            {{-- Filter & Search --}}
            <form action="{{ route('lembar-kerja.index') }}" method="GET" class="row g-2 mb-3">
                <div class="col-md-2">
                    <input type="date" name="tgl_awal" class="form-control" value="{{ request('tgl_awal') }}" placeholder="Tanggal Awal">
                </div>
                <div class="col-md-2">
                    <input type="date" name="tgl_akhir" class="form-control" value="{{ request('tgl_akhir') }}" placeholder="Tanggal Akhir">
                </div>
                <div class="col-md-2">
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        @foreach(['draft','proses','persetujuan','dibatalkan','selesai'] as $status)
                            <option value="{{ $status }}" {{ request('status') == $status ? 'selected' : '' }}>
                                {{ ucfirst($status) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="layanan_id" class="form-select">
                        <option value="">Semua Layanan</option>
                        @foreach($layanan as $l)
                            <option value="{{ $l->id }}" {{ request('layanan_id') == $l->id ? 'selected' : '' }}>
                                {{ $l->nama_layanan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <select name="tipe_pelanggan" class="form-select">
                        <option value="">Semua Tipe</option>
                        @foreach(['perorangan','perusahaan'] as $tipe)
                            <option value="{{ $tipe }}" {{ request('tipe_pelanggan') == $tipe ? 'selected' : '' }}>
                                {{ ucfirst($tipe) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-outline-primary">
                        <i class="mdi mdi-filter-variant" title="Filter"></i>
                    </button>
                    <a href="{{ route('lembar-kerja.index') }}" class="btn btn-outline-secondary" title="Reset">
                        <i class="mdi mdi-refresh"></i>
                    </a>
                </div>
            </form>

            {{-- Table --}}
            <div class="table-responsive text-nowrap">
                <table class="table table-bordered">
                    <thead class="table-primary">
                        <tr class="text-nowrap">
                            <th>#</th>
                            <th>Tanggal Pesanan</th>
                            <th>No Pesanan</th>
                            <th>Nama Klien</th>
                            <th>Tipe Pelanggan</th>
                            <th>Nama Lembar Kerja</th>
                            <th>Status</th>
                            <th>Layanan</th>
                            <th>Tanggal Target</th>
                            <th>Dibuat</th>
                            <th>Diupdate</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lembarKerja as $lk)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $lk->tgl_pesanan ? \Carbon\Carbon::parse($lk->tgl_pesanan)->format('d-m-Y') : '-' }}</td>
                            <td>{{ $lk->no_pesanan }}</td>
                            <td>
                                <a href="{{ route('lembar-kerja.edit', $lk->id) }}" 
                                   class="text-decoration-none fw-semibold text-primary">
                                    {{ $lk->klien->nama }}
                                </a>
                            </td>
                            <td>{{ ucfirst($lk->tipe_pelanggan) }}</td>
                            <td>
                                <a href="{{ route('lembar-kerja.edit', $lk->id) }}" 
                                   class="text-decoration-none fw-semibold text-dark">
                                    {{ $lk->nama_lembar }}
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-{{ match($lk->status) {
                                    'draft' => 'secondary',
                                    'proses' => 'info',
                                    'persetujuan' => 'warning',
                                    'dibatalkan' => 'danger',
                                    'selesai' => 'success',
                                    default => 'light'
                                } }}">
                                    {{ ucfirst($lk->status) }}
                                </span>
                            </td>
                            <td>{{ $lk->layanan->nama_layanan }}</td>
                            <td>{{ $lk->tgl_target ? \Carbon\Carbon::parse($lk->tgl_target)->format('d-m-Y') : '-' }}</td>
                            <td>{{ $lk->created_at ? \Carbon\Carbon::parse($lk->created_at)->format('d-m-Y') : '-' }}</td>
                            <td>{{ $lk->updated_at ? \Carbon\Carbon::parse($lk->updated_at)->format('d-m-Y') : '-' }}</td>
                            <td class="text-center">
                                <a href="{{ route('lembar-kerja.edit', $lk->id) }}" 
                                   class="btn btn-warning btn-icon btn-sm" title="Edit">
                                    <i class="mdi mdi-pencil-outline"></i>
                                </a>
                                <form action="{{ route('lembar-kerja.destroy', $lk->id) }}" method="POST" 
                                      class="d-inline" onsubmit="return confirm('Hapus Lembar Kerja ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-icon btn-sm" title="Hapus">
                                        <i class="mdi mdi-trash-can-outline"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted">Belum ada data lembar kerja.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $lembarKerja->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
