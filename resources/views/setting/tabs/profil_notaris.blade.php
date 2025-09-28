<div class="tab-pane fade show active" id="profil-notaris" role="tabpanel">

    <!-- Alert sukses -->
    
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white text-white d-flex justify-content-between align-items-center py-3">
            <h5 class="mb-0"><i class="bi bi-person-badge me-2"></i>Profil Notaris</h5>
            <button type="button" id="btnEdit" class="btn btn-light btn-sm d-flex align-items-center">
                <i class="bi bi-pencil-square me-1"></i> Edit
            </button>
        </div>

        <div class="card-body p-4">

            <!-- View Mode -->
            <div id="viewMode">
                <div class="row">
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 border-0 bg-light">
                            <div class="card-header bg-transparent border-bottom-0">
                                <h6 class="mb-0 text-primary"><i class="bi bi-person-vcard me-2"></i>Informasi Notaris</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-person-circle text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0"><strong>Nama Notaris</strong></p>
                                        <p class="mb-0">{{ $profil->nama_notaris ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-person-gear text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0"><strong>Nama Pejabat</strong></p>
                                        <p class="mb-0">{{ $profil->nama_pejabat ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-telephone text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0"><strong>No Telepon</strong></p>
                                        <p class="mb-0">{{ $profil->no_telepon ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-printer text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0"><strong>No Fax</strong></p>
                                        <p class="mb-0">{{ $profil->no_fax ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-envelope text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0"><strong>Email</strong></p>
                                        <p class="mb-0">{{ $profil->email ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="d-flex">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0"><strong>Logo</strong></p>
                                        @if(isset($profil->logo))
                                            <img src="{{ asset('storage/uploads/'.$profil->logo) }}" width="120" class="mt-2 rounded border">
                                        @else
                                            <p class="mb-0">-</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6 mb-4">
                        <div class="card h-100 border-0 bg-light">
                            <div class="card-header bg-transparent border-bottom-0">
                                <h6 class="mb-0 text-primary"><i class="bi bi-file-earmark-text me-2"></i>Dokumen & Area Kerja</h6>
                            </div>
                            <div class="card-body">
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-file-text text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0"><strong>SK Notaris</strong></p>
                                        <p class="mb-0">{{ $profil->sk_notaris ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-calendar-event text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0"><strong>Tanggal SK Notaris</strong></p>
                                        <p class="mb-0">{{ $profil->tgl_sk_notaris ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-file-text text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0"><strong>SK PPAT</strong></p>
                                        <p class="mb-0">{{ $profil->sk_ppat ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-calendar-event text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0"><strong>Tanggal SK PPAT</strong></p>
                                        <p class="mb-0">{{ $profil->tgl_sk_ppat ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-geo-alt text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0"><strong>Area Kerja Notaris</strong></p>
                                        <p class="mb-0">{{ $profil->area_kerja_notaris ?? '-' }}</p>
                                    </div>
                                </div>
                                <div class="d-flex mb-3">
                                    <div class="flex-shrink-0">
                                        <i class="bi bi-geo-alt text-muted"></i>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <p class="mb-0"><strong>Area Kerja PPAT</strong></p>
                                        <p class="mb-0">{{ $profil->area_kerja_ppat ?? '-' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-12">
                        <div class="card border-0 bg-light">
                            <div class="card-header bg-transparent border-bottom-0">
                                <h6 class="mb-0 text-primary"><i class="bi bi-geo-alt-fill me-2"></i>Alamat Notaris</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="d-flex mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="bi bi-map text-muted"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="mb-0"><strong>Provinsi</strong></p>
                                                <p class="mb-0">{{ $profil->provinsi->nama ?? '-' }}</p>
                                            </div>
                                        </div>
                                        <div class="d-flex mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="bi bi-geo text-muted"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="mb-0"><strong>Kabupaten</strong></p>
                                                <p class="mb-0">{{ $profil->kabupaten->nama ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="d-flex mb-3">
                                            <div class="flex-shrink-0">
                                                <i class="bi bi-house text-muted"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="mb-0"><strong>Alamat</strong></p>
                                                <p class="mb-0">{{ $profil->alamat ?? '-' }}</p>
                                            </div>
                                        </div>
                                        <div class="d-flex">
                                            <div class="flex-shrink-0">
                                                <i class="bi bi-clock text-muted"></i>
                                            </div>
                                            <div class="flex-grow-1 ms-3">
                                                <p class="mb-0"><strong>Zona Waktu</strong></p>
                                                <p class="mb-0">{{ $profil->zona_waktu ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Edit Mode -->
            <div id="editMode" style="display:none;">
                <form action="{{ route('setting.profil_notaris.save') }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf

                    <!-- Profil Notaris -->
                    <div class="card border-0 mb-4">
                        <div class="card-header bg-light border-bottom-0">
                            <h6 class="mb-0 text-primary"><i class="bi bi-person-vcard me-2"></i>Profil Notaris</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="nama_notaris" class="form-control" id="nama_notaris" value="{{ $profil->nama_notaris ?? '' }}" required>
                                        <label for="nama_notaris">Nama Notaris</label>
                                        <div class="invalid-feedback">Harap isi nama notaris</div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" name="nama_pejabat" class="form-control" id="nama_pejabat" value="{{ $profil->nama_pejabat ?? '' }}" required>
                                        <label for="nama_pejabat">Nama Pejabat</label>
                                        <div class="invalid-feedback">Harap isi nama pejabat</div>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" name="no_telepon" class="form-control" id="no_telepon" value="{{ $profil->no_telepon ?? '' }}">
                                        <label for="no_telepon">No Telepon</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" name="no_fax" class="form-control" id="no_fax" value="{{ $profil->no_fax ?? '' }}">
                                        <label for="no_fax">No Fax</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" name="email" class="form-control" id="email" value="{{ $profil->email ?? '' }}">
                                        <label for="email">Email</label>
                                        <div class="invalid-feedback">Format email tidak valid</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="logo" class="form-label">Logo</label>
                                        <input type="file" name="logo" class="form-control" id="logo" accept="image/*">
                                        @if(isset($profil->logo))
                                            <div class="mt-2">
                                                <p class="mb-1">Logo saat ini:</p>
                                                <img src="{{ asset('storage/uploads/'.$profil->logo) }}" width="120" class="rounded border">
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="sk_notaris" class="form-control" id="sk_notaris" value="{{ $profil->sk_notaris ?? '' }}">
                                        <label for="sk_notaris">SK Notaris</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" name="tgl_sk_notaris" class="form-control" id="tgl_sk_notaris" value="{{ $profil->tgl_sk_notaris ?? '' }}">
                                        <label for="tgl_sk_notaris">Tanggal SK Notaris</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" name="sk_ppat" class="form-control" id="sk_ppat" value="{{ $profil->sk_ppat ?? '' }}">
                                        <label for="sk_ppat">SK PPAT</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="date" name="tgl_sk_ppat" class="form-control" id="tgl_sk_ppat" value="{{ $profil->tgl_sk_ppat ?? '' }}">
                                        <label for="tgl_sk_ppat">Tanggal SK PPAT</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" name="area_kerja_notaris" class="form-control" id="area_kerja_notaris" value="{{ $profil->area_kerja_notaris ?? '' }}">
                                        <label for="area_kerja_notaris">Area Kerja Notaris</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" name="area_kerja_ppat" class="form-control" id="area_kerja_ppat" value="{{ $profil->area_kerja_ppat ?? '' }}">
                                        <label for="area_kerja_ppat">Area Kerja PPAT</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Alamat Notaris -->
                    <div class="card border-0">
                        <div class="card-header bg-light border-bottom-0">
                            <h6 class="mb-0 text-primary"><i class="bi bi-geo-alt-fill me-2"></i>Alamat Notaris</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Provinsi</label>
                                        <select name="provinsi_id" id="provinsi" class="form-select select2" required>
                                            <option value="">-- Pilih Provinsi --</option>
                                            @foreach($provinsi as $p)
                                                <option value="{{ $p->id }}" {{ ($profil->provinsi_id ?? '') == $p->id ? 'selected' : '' }}>{{ $p->nama }}</option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">Harap pilih provinsi</div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kabupaten</label>
                                        <select name="kabupaten_id" id="kabupaten" class="form-select select2" required>
                                            @if(isset($profil->kabupaten))
                                                <option value="{{ $profil->kabupaten_id }}" selected>{{ $profil->kabupaten->nama }}</option>
                                            @else
                                                <option value="">-- Pilih Kabupaten --</option>
                                            @endif
                                        </select>
                                        <div class="invalid-feedback">Harap pilih kabupaten</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-3">
                                        <textarea name="alamat" class="form-control" id="alamat" rows="3" style="height: 100px;">{{ $profil->alamat ?? '' }}</textarea>
                                        <label for="alamat">Alamat</label>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Zona Waktu</label>
                                        <select name="zona_waktu" class="form-select" required>
                                            <option value="">-- Pilih Zona Waktu --</option>
                                            <option value="WIB" {{ ($profil->zona_waktu ?? '') == 'WIB' ? 'selected' : '' }}>WIB (Waktu Indonesia Barat)</option>
                                            <option value="WITA" {{ ($profil->zona_waktu ?? '') == 'WITA' ? 'selected' : '' }}>WITA (Waktu Indonesia Tengah)</option>
                                            <option value="WIT" {{ ($profil->zona_waktu ?? '') == 'WIT' ? 'selected' : '' }}>WIT (Waktu Indonesia Timur)</option>
                                        </select>
                                        <div class="invalid-feedback">Harap pilih zona waktu</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 d-flex justify-content-end">
                        <button type="submit" class="btn btn-success px-4 me-2">
                            <i class="bi bi-check-lg me-1"></i> Simpan
                        </button>
                        <button type="button" class="btn btn-secondary px-4" id="btnCancel">
                            <i class="bi bi-x-lg me-1"></i> Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- JS Dependencies -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {

    // Toggle edit/view dengan animasi
    $('#btnEdit').click(function(){
        $('#viewMode').slideUp(300, function(){
            $('#editMode').slideDown(300);
        });
        $(this).prop('disabled', true);
    });
    
    $('#btnCancel').click(function(){
        $('#editMode').slideUp(300, function(){
            $('#viewMode').slideDown(300);
        });
        $('#btnEdit').prop('disabled', false);
    });

    // Init Select2
    $('.select2').select2({
        width: '100%',
        theme: 'bootstrap-5',
        placeholder: 'Pilih salah satu'
    });

    // AJAX load kabupaten
    $('#provinsi').on('change',function(){
        let provinsi_id = $(this).val();
        if(provinsi_id){
            $.ajax({
                url:'{{ route("setting.get_kabupaten") }}',
                type:'GET',
                data:{provinsi_id:provinsi_id},
                beforeSend: function() {
                    $('#kabupaten').html('<option value="">Memuat...</option>');
                },
                success:function(res){
                    $('#kabupaten').empty().append('<option value="">-- Pilih Kabupaten --</option>');
                    $.each(res,function(k,v){
                        $('#kabupaten').append('<option value="'+v.id+'">'+v.nama+'</option>');
                    });
                    $('#kabupaten').trigger('change'); // refresh select2
                },
                error: function() {
                    $('#kabupaten').html('<option value="">Terjadi kesalahan</option>');
                }
            });
        }else{
            $('#kabupaten').empty().append('<option value="">-- Pilih Kabupaten --</option>');
            $('#kabupaten').trigger('change');
        }
    });
    
    // Form validation
    (function() {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms)
            .forEach(function(form) {
                form.addEventListener('submit', function(event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
    })()
});
</script>