@extends('layouts.commonMaster')

@section('title', 'Daftar Klien')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">

    <!-- Table Card -->
    <div class="card">
        <div class="card-body">
            <!-- Page Header + Search -->
            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
                <h5 class="fw-bold py-3 mb-0">Daftar Klien</h5>

                <div class="d-flex flex-wrap gap-2">
                    <!-- Search Form -->
                    <form method="GET" action="{{ route('klien.index') }}" class="d-flex">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2" placeholder="Cari klien...">
                        <button type="submit" class="btn btn-outline-primary"><i class="mdi mdi-magnify"></i></button>
                    </form>

                    <!-- Tambah Klien -->
                    <a href="{{ route('klien.create') }}" class="btn btn-primary">
                        <i class="mdi mdi-plus me-1"></i> Tambah Klien
                    </a>
                </div>
            </div>

            <!-- Filter -->
            <form method="GET" action="{{ route('klien.index') }}" class="row g-2 mb-3">
                <div class="col-md-2">
                    <select name="tipe" class="form-select">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="pribadi" {{ request('tipe')=='pribadi'?'selected':'' }}>Pribadi</option>
                        <option value="bank_leasing" {{ request('tipe')=='bank_leasing'?'selected':'' }}>Bank / Leasing</option>
                        <option value="perusahaan" {{ request('tipe')=='perusahaan'?'selected':'' }}>Perusahaan</option>
                    </select>
                </div>

                {{-- <div class="col-md-2">
                    <select name="provinsi" class="form-select" onchange="this.form.submit()">
                        <option value="">-- Pilih Provinsi --</option>
                        @foreach($provinsiList as $prov)
                            <option value="{{ $prov->id }}" {{ request('provinsi')==$prov->id?'selected':'' }}>{{ $prov->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <select name="kabupaten" class="form-select">
                        <option value="">-- Pilih Kabupaten --</option>
                        @foreach($kabupatenList as $kab)
                            <option value="{{ $kab->id }}" {{ request('kabupaten')==$kab->id?'selected':'' }}>{{ $kab->nama }}</option>
                        @endforeach
                    </select>
                </div> --}}

                <div class="col-md-2">
                    <input type="date" name="tanggal_dari" value="{{ request('tanggal_dari') }}" class="form-control" placeholder="Dari Tanggal">
                </div>
                <div class="col-md-2">
                    <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" class="form-control" placeholder="Sampai Tanggal">
                </div>
                <div class="col-md-2 d-flex gap-2">
                  <button type="submit" class="btn btn-outline-primary" title="Filter">
    <i class="mdi mdi-filter-variant"></i>
</button>
                    <a href="{{ route('klien.index') }}" class="btn btn-outline-secondary" title="Reset"><i class="mdi mdi-refresh"></i></a>
                </div>
            </form>

            <!-- Alert -->
                       <!-- Table -->
           <div class="table-responsive text-nowrap">
      <table class="table table-bordered">
      <thead class="table-primary">
        <tr class="text-nowrap">
                            <th>#</th>
                            <th>Nama</th>
                            <th>Tipe</th>
                            <th>No Telepon</th>
                            <th>Email</th>
                            <th>Provinsi</th>
                            <th>Kabupaten/Kota</th>
                            <th>Tanggal Dibuat</th>
                            <th>Tanggal Update</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse($klien as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                          <td>
    <a href="{{ route('klien.edit', $item->id) }}" class="text-decoration-none">
        {{ $item->nama }}
    </a>
</td>

                            <td>{{ ucfirst(str_replace('_',' ',$item->tipe)) }}</td>

                          {{-- No Telepon + WA --}}
<td>
    {{ $item->no_telepon }}
    @if($item->no_telepon)
        <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/','',$item->no_telepon)) }}" 
           target="_blank" 
           class="ms-1 text-success whatsapp-icon"
           data-bs-toggle="tooltip" 
           data-bs-placement="top" 
           title="Hubungi via WhatsApp">
            <i class="mdi mdi-whatsapp mdi-18px"></i>
        </a>
    @endif
</td>

{{-- Email + Gmail --}}
<td>
    {{ $item->email }}
    @if($item->email)
        <a href="https://mail.google.com/mail/?view=cm&to={{ $item->email }}" 
           target="_blank"
           class="ms-1 text-danger gmail-icon"
           data-bs-toggle="tooltip" 
           data-bs-placement="top" 
           title="Kirim Email via Gmail">
            <i class="mdi mdi-gmail mdi-18px"></i>
        </a>
    @endif
</td>

                            <td>{{ $item->provinsi->nama ?? '-' }}</td>
                            <td>{{ $item->kabupaten->nama ?? '-' }}</td>
                            <td>{{ $item->created_at->format('d-m-Y') }}</td>
                            <td>{{ $item->updated_at->format('d-m-Y') }}</td>
                            <td class="text-center">
                                {{-- <a href="{{ route('klien.show', $item->id) }}" class="btn btn-info btn-icon btn-sm" title="Detail">
                                    <i class="mdi mdi-eye-outline"></i>
                                </a>
                                <a href="{{ route('klien.edit', $item->id) }}" class="btn btn-warning btn-icon btn-sm" title="Edit">
                                    <i class="mdi mdi-pencil-outline"></i>
                                </a> --}}
                                <form id="deleteForm{{ $item->id }}" action="{{ route('klien.destroy', $item->id) }}" method="POST" style="display:inline;">
    @csrf
    @method('DELETE')
    <button type="button" class="btn btn-danger btn-icon btn-sm" 
            onclick="confirmDelete(event, 'deleteForm{{ $item->id }}','{{ $item->nama}}')" 
            title="Hapus">
        <i class="mdi mdi-trash-can-outline"></i>
    </button>
</form>

                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">Belum ada data klien.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
             <div class="d-flex justify-content-end">
                {{ $klien->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
    // Inisialisasi Bootstrap tooltip
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
      return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Hover efek WA & Gmail (opsional)
    document.querySelectorAll('.whatsapp-icon').forEach(el => {
        el.addEventListener('mouseenter', () => el.style.color = '#25D366');
        el.addEventListener('mouseleave', () => el.style.color = '#28a745');
    });
    document.querySelectorAll('.gmail-icon').forEach(el => {
        el.addEventListener('mouseenter', () => el.style.color = '#D44638');
        el.addEventListener('mouseleave', () => el.style.color = '#dc3545');
    });
</script>
@endpush

@push('styles')
<style>
    .whatsapp-icon:hover, .gmail-icon:hover {
        transform: scale(1.2);
        transition: transform 0.2s;
    }
</style>
@endpush
