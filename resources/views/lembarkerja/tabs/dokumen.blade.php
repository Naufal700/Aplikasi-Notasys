<div class="mb-3">
    <label>Upload Dokumen</label>
    <input type="file" name="dokumen[]" class="form-control" multiple>
</div>

@if(!empty($lembarKerja->dokumen))
    <div class="mt-3">
        <h6>Dokumen yang sudah diupload:</h6>
        <ul>
            @foreach($lembarKerja->dokumen as $doc)
                <li>
                    <a href="{{ asset('storage/dokumen/'.$doc->file) }}" target="_blank">{{ $doc->nama }}</a>
                </li>
            @endforeach
        </ul>
    </div>
@endif
