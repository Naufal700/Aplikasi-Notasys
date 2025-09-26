<div class="mb-3">
    <label>Opsi Form Order</label>
    <div class="row">
        @php
            $opsi = [
                'form_order_akta_ppat'=>'Akta PPAT',
                'form_order_proses_lainnya'=>'Proses Lainnya',
                'form_order_legalisasi'=>'Legalisasi',
                'form_order_akta_notaris_lainnya'=>'Akta Notaris Lainnya',
                'form_order_akta_notaris'=>'Akta Notaris',
                'form_order_pajak_titipan'=>'Pajak Titipan',
                'form_order_waarmarking'=>'Waarmerking',
                'form_order_akta_ppat_luar_wilayah'=>'Akta PPAT Luar Wilayah'
            ];
        @endphp

        @foreach($opsi as $field => $label)
            @php
                // Ambil value dari relasi setting, default 0 (Tidak)
                $value = $lembarKerja->setting->$field ?? 0;

                // Casting value agar aman
                $isCheckedYa = in_array($value, [1, '1', true, 't'], true);
                $isCheckedTidak = !$isCheckedYa;
            @endphp

            <div class="col-md-6 mb-2">
                <div class="form-label fw-bold">{{ $label }}</div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" 
                           name="{{ $field }}" id="{{ $field }}_ya" 
                           value="1" {{ $isCheckedYa ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $field }}_ya">Ya</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" 
                           name="{{ $field }}" id="{{ $field }}_tidak" 
                           value="0" {{ $isCheckedTidak ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $field }}_tidak">Tidak</label>
                </div>
            </div>
        @endforeach
    </div>
</div>
