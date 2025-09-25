<div class="mb-3">
    <label>Catatan Tambahan</label>
    <textarea name="catatan" class="form-control" rows="5">{{ $lembarKerja->catatan }}</textarea>
</div>

@if(!empty($lembarKerja->riwayat_catatan))
    <div class="mt-3">
        <h6>Riwayat Catatan:</h6>
        <ul class="list-group">
            @foreach($lembarKerja->riwayat_catatan as $riwayat)
                <li class="list-group-item">
                    <small class="text-muted">{{ $riwayat->created_at }} oleh {{ $riwayat->user->name }}</small>
                    <div>{{ $riwayat->isi }}</div>
                </li>
            @endforeach
        </ul>
    </div>
@endif
