@php
    $isEdit = isset($partner);
@endphp

<form action="{{ $isEdit ? route('partners.update', $partner->id) : route('partners.store') }}" method="POST">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    {{-- Row 1: Nama, Provinsi, Kabupaten --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="nama" class="form-label">Nama Partner</label>
            <input type="text" name="nama" class="form-control" value="{{ old('nama', $partner->nama ?? '') }}" required>
            @error('nama')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="col-md-4">
            <label for="provinsi_id" class="form-label">Provinsi</label>
            <select name="provinsi_id" id="provinsi_id" class="form-select" required>
                <option value="">-- Pilih Provinsi --</option>
                @foreach($provinsi as $p)
                    <option value="{{ $p->id }}" {{ (old('provinsi_id', $partner->provinsi_id ?? '') == $p->id) ? 'selected' : '' }}>
                        {{ $p->nama }}
                    </option>
                @endforeach
            </select>
            @error('provinsi_id')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="col-md-4">
            <label for="kabupaten_id" class="form-label">Kabupaten</label>
            <select name="kabupaten_id" id="kabupaten_id" class="form-select" required>
                <option value="">-- Pilih Kabupaten --</option>
                @if($isEdit)
                    @foreach($kabupaten as $k)
                        <option value="{{ $k->id }}" {{ $partner->kabupaten_id == $k->id ? 'selected' : '' }}>{{ $k->nama }}</option>
                    @endforeach
                @endif
            </select>
            @error('kabupaten_id')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
    </div>

    {{-- Row 2: Email & Alamat --}}
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $partner->email ?? '') }}">
            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="col-md-6">
            <label for="alamat_lengkap" class="form-label">Alamat Lengkap</label>
            <textarea name="alamat_lengkap" class="form-control" rows="1">{{ old('alamat_lengkap', $partner->alamat_lengkap ?? '') }}</textarea>
            @error('alamat_lengkap')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
    </div>

    <hr>
    <h5>PIC Notaris</h5>

    {{-- Row 3: PIC --}}
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="pic_nama" class="form-label">Nama PIC</label>
            <input type="text" name="pic_nama" class="form-control" value="{{ old('pic_nama', $partner->pic_nama ?? '') }}">
            @error('pic_nama')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="col-md-4">
            <label for="pic_jabatan" class="form-label">Jabatan PIC</label>
            <input type="text" name="pic_jabatan" class="form-control" value="{{ old('pic_jabatan', $partner->pic_jabatan ?? '') }}">
            @error('pic_jabatan')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
        <div class="col-md-4">
            <label for="pic_keterangan" class="form-label">Keterangan PIC</label>
            <textarea name="pic_keterangan" class="form-control" rows="1">{{ old('pic_keterangan', $partner->pic_keterangan ?? '') }}</textarea>
            @error('pic_keterangan')<small class="text-danger">{{ $message }}</small>@enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update' : 'Simpan' }}</button>
    <a href="{{ route('partners.index') }}" class="btn btn-secondary">Batal</a>
</form>

@push('scripts')
<script>
    $(document).ready(function() {
        $('#provinsi_id').select2({ placeholder: "Pilih Provinsi" });
        $('#kabupaten_id').select2({ placeholder: "Pilih Kabupaten" });

        $('#provinsi_id').change(function() {
            let provinsiId = $(this).val();
            $('#kabupaten_id').html('<option value="">Loading...</option>');

            if(provinsiId){
                $.get("{{ url('partners/kabupaten') }}/"+provinsiId, function(data){
                    let options = '<option value="">-- Pilih Kabupaten --</option>';
                    data.forEach(function(k){
                        options += `<option value="${k.id}">${k.nama}</option>`;
                    });
                    $('#kabupaten_id').html(options);
                });
            } else {
                $('#kabupaten_id').html('<option value="">-- Pilih Kabupaten --</option>');
            }
        });
    });
</script>
@endpush
