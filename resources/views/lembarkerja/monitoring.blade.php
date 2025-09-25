@extends('layouts.commonMaster')

@section('title', 'Monitoring Lembar Kerja')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0 fw-bold">Monitoring Lembar Kerja</h5>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-3" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $tab === 'lembar_kerja' ? 'active' : '' }}" href="{{ route('lembar-kerja.monitoring', ['tab' => 'lembar_kerja']) }}">Monitoring Lembar Kerja</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $tab === 'proses' ? 'active' : '' }}" href="{{ route('lembar-kerja.monitoring', ['tab' => 'proses']) }}">Monitoring Proses</a>
                </li>
            </ul>

            <!-- Filter + Search sejajar -->
            <div class="d-flex flex-wrap align-items-center mb-3 gap-2">
                <div class="btn-group" role="group" aria-label="Filter Date">
                    <a href="{{ route('lembar-kerja.monitoring', array_merge(request()->all(), ['filter_date'=>'today'])) }}" class="btn btn-outline-primary btn-sm {{ $filterDate === 'today' ? 'active' : '' }}">Hari Ini</a>
                    <a href="{{ route('lembar-kerja.monitoring', array_merge(request()->all(), ['filter_date'=>'3days'])) }}" class="btn btn-outline-primary btn-sm {{ $filterDate === '3days' ? 'active' : '' }}">3 Hari</a>
                    <a href="{{ route('lembar-kerja.monitoring', array_merge(request()->all(), ['filter_date'=>'7days'])) }}" class="btn btn-outline-primary btn-sm {{ $filterDate === '7days' ? 'active' : '' }}">7 Hari</a>
                    <a href="{{ route('lembar-kerja.monitoring', array_merge(request()->except('filter_date'))) }}" class="btn btn-outline-primary btn-sm {{ $filterDate === 'all' ? 'active' : '' }}">Semua</a>
                </div>

                <form action="{{ route('lembar-kerja.monitoring') }}" method="GET" class="d-flex ms-auto">
                    <input type="hidden" name="tab" value="{{ $tab }}">
                    <input type="text" name="search" class="form-control me-1" placeholder="Search..." value="{{ $search }}">
                   <button type="submit" class="btn btn-outline-primary"><i class="mdi mdi-magnify"></i></button>
</form>
            </div>

            <!-- Table -->
           <div class="table-responsive text-nowrap">
      <table class="table table-bordered">
      <thead class="table-primary">
        <tr class="text-nowrap">
                            @if($tab === 'lembar_kerja')
                                <th>Tanggal Selesai</th>
                                <th>Tanggal Pesanan</th>
                                <th>No Pesanan</th>
                                <th>Nama Lembar Kerja</th>
                                <th>Status</th>
                                <th>Nama Klien</th>
                            @else
                                <th>Tanggal Selesai</th>
                                <th>Tanggal Pesanan</th>
                                <th>Nama Proses</th>
                                <th>Selesai</th>
                                <th>No Pesanan</th>
                                <th>Nama Lembar Kerja</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lembarKerja as $lk)
                            <tr>
                                @if($tab === 'lembar_kerja')
                                    <td>{{ $lk->tgl_target ? \Carbon\Carbon::parse($lk->tgl_target)->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $lk->tgl_pesanan ? \Carbon\Carbon::parse($lk->tgl_pesanan)->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $lk->no_pesanan }}</td>
                                    <td>{{ $lk->nama_lembar }}</td>
                                    <td>{{ ucfirst($lk->status) }}</td>
                                    <td>{{ $lk->klien->nama }}</td>
                                @else
                                    <td>{{ $lk->tgl_target ? \Carbon\Carbon::parse($lk->tgl_target)->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $lk->tgl_pesanan ? \Carbon\Carbon::parse($lk->tgl_pesanan)->format('d-m-Y') : '-' }}</td>
                                    <td>{{ $lk->nama_lembar }}</td>
                                    <td>{{ $lk->status === 'selesai' ? 'Ya' : 'Belum' }}</td>
                                    <td>{{ $lk->no_pesanan }}</td>
                                    <td>{{ $lk->nama_lembar }}</td>
                                @endif
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Belum ada data.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $lembarKerja->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
