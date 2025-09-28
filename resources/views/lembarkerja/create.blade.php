@extends('layouts.commonMaster')

@section('title', 'Tambah Lembar Kerja')

@section('layoutContent')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="fw-bold mb-0">Tambah Lembar Kerja Baru</h4>
                <span class="badge bg-light text-primary fs-6">No. Pesanan: {{ $noPesanan }}</span>
            </div>
        </div>
        <div class="card-body">
            <div class="alert alert-info d-flex align-items-center mb-4">
                <i class="bx bx-info-circle me-2 fs-5"></i>
                <span>Isi semua informasi yang diperlukan untuk membuat lembar kerja baru</span>
            </div>

            <form action="{{ route('lembar-kerja.store') }}" method="POST" enctype="multipart/form-data" id="lembarKerjaForm">
                @csrf

                {{-- Progress Indicator --}}
                <div class="progress-steps mb-4">
                    <div class="step active" data-step="1">
                        <div class="step-icon">1</div>
                        <span class="step-label">Lembar Kerja</span>
                    </div>
                    <div class="step" data-step="2">
                        <div class="step-icon">2</div>
                        <span class="step-label">Penghadap</span>
                    </div>
                    <div class="step" data-step="3">
                        <div class="step-icon">3</div>
                        <span class="step-label">Setting</span>
                    </div>
                    <div class="step" data-step="4">
                        <div class="step-icon">4</div>
                        <span class="step-label">Form Order</span>
                    </div>
                </div>

                {{-- Tabs --}}
                <ul class="nav nav-pills custom-nav-pills mb-4" id="lembarKerjaTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#tab-lembarKerja" type="button">
                            <i class="bx bx-file me-1"></i> Lembar Kerja
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-penghadap" type="button">
                            <i class="bx bx-user me-1"></i> Penghadap
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-setting" type="button">
                            <i class="bx bx-cog me-1"></i> Setting
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-formOrder" type="button">
                            <i class="bx bx-list-check me-1"></i> Form Order
                        </button>
                    </li>
                </ul>

                {{-- Tab Content --}}
                <div class="tab-content mt-2">
                    {{-- Tab 1: Lembar Kerja --}}
                    <div class="tab-pane fade show active" id="tab-lembarKerja">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">No Pesanan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bx bx-barcode"></i></span>
                                    <input type="text" name="no_pesanan" class="form-control" value="{{ $noPesanan }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tanggal Pesanan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bx bx-calendar"></i></span>
                                    <input type="date" name="tgl_pesanan" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Pelanggan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bx bx-user-circle"></i></span>
                                    <select name="klien_id" class="form-control select2" id="klienSelect" required>
                                        <option value="">-- Pilih Klien --</option>
                                        @foreach($klien as $k)
                                            <option value="{{ $k->id }}" data-tipe="{{ $k->tipe }}">{{ $k->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Tipe Pelanggan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bx bx-category"></i></span>
                                    <input type="text" name="tipe_pelanggan" id="tipePelanggan" class="form-control" readonly placeholder="Otomatis terisi setelah pilih klien">
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Nama Lembar <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bx bx-rename"></i></span>
                                    <input type="text" name="nama_lembar" class="form-control" placeholder="Masukkan nama lembar" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Layanan <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bx bx-cube"></i></span>
                                    <select name="layanan_id" id="layananSelect" class="form-control" required>
                                        <option value="">-- Pilih Layanan --</option>
                                        @foreach($layanan as $l)
                                            <option value="{{ $l->id }}">{{ $l->nama_layanan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Target Selesai</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bx bx-calendar-check"></i></span>
                                    <input type="date" name="tgl_target" id="tglTarget" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-semibold">Keterangan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light align-items-start pt-2"><i class="bx bx-message-detail"></i></span>
                                    <textarea name="keterangan" class="form-control" placeholder="Masukkan keterangan" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Tab 2: Penghadap --}}
                    <div class="tab-pane fade" id="tab-penghadap">
                        <div class="alert alert-light mb-4">
                            <i class="bx bx-info-circle me-2"></i>
                            Pilih satu atau lebih penghadap untuk lembar kerja ini
                        </div>
                        <div class="mb-3 col-md-8">
                            <label class="form-label fw-semibold">Nama Penghadap <span class="text-danger">*</span></label>
                            <select name="penghadap[]" class="form-control select2" multiple="multiple" required>
                                @foreach($klien as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    {{-- Tab 3: Setting --}}
                    <div class="tab-pane fade" id="tab-setting">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-semibold">Template Form Order</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light"><i class="bx bx-layer"></i></span>
                                    <select name="template_form_order_id" class="form-control">
                                        <option value="">-- Pilih Template --</option>
                                        @foreach($templates as $t)
                                            <option value="{{ $t->id }}">{{ $t->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold">Opsi Form Order <span class="text-danger">*</span></label>
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
                                    <div class="col-md-6 mb-3">
                                        <div class="card option-card">
                                            <div class="card-body p-3">
                                                <div class="form-label fw-semibold mb-2">{{ $label }}</div>
                                                <div class="d-flex gap-3">
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="{{ $field }}" id="{{ $field }}_ya" value="1" required>
                                                        <label class="form-check-label text-success fw-medium" for="{{ $field }}_ya">
                                                            <i class="bx bx-check-circle me-1"></i> Ya
                                                        </label>
                                                    </div>
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input" type="radio" name="{{ $field }}" id="{{ $field }}_tidak" value="0" required>
                                                        <label class="form-check-label text-danger fw-medium" for="{{ $field }}_tidak">
                                                            <i class="bx bx-x-circle me-1"></i> Tidak
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- Tab 4: Form Order --}}
                    <div class="tab-pane fade" id="tab-formOrder">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="mb-0">Daftar Form Order</h5>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalFormOrder">
                                <i class="bx bx-plus me-1"></i> Tambah Form Order
                            </button>
                        </div>

                        {{-- Tabel Review --}}
                        <div class="table-responsive">
                            <table class="table table-hover" id="reviewFormOrderTable">
                                <thead class="table-light">
                                    <tr>
                                        <th width="5%">#</th>
                                        <th width="15%">Jenis Akta <span class="text-danger">*</span></th>
                                        <th width="12%">No Akta <span class="text-danger">*</span></th>
                                        <th width="12%">Tanggal Akta <span class="text-danger">*</span></th>
                                        <th width="10%">Biaya <span class="text-danger">*</span></th>
                                        <th width="12%">Tanggal Akad</th>
                                        <th width="12%">Pihak Mengalihkan</th>
                                        <th width="12%">Pihak Menerima</th>
                                        <th width="10%">File</th>
                                        <th width="5%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="emptyFormOrderMessage" class="d-none">
                                        <td colspan="10" class="text-center py-4 text-muted">
                                            <i class="bx bx-inbox fs-1 d-block mb-2"></i>
                                            Belum ada form order yang ditambahkan
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4">
                            <label class="form-label fw-semibold">Catatan</label>
                            <textarea name="catatan" class="form-control" placeholder="Masukkan catatan tambahan" rows="3"></textarea>
                        </div>
                    </div>
                </div>

                {{-- Navigation & Submit --}}
                <div class="d-flex justify-content-end align-items-center mt-5 pt-3 border-top gap-2">
                    <a href="{{ route('lembar-kerja.index') }}" class="btn btn-light">
                        <i class="bx bx-x me-1"></i> Batal
                    </a>
    <button type="button" class="btn btn-outline-secondary" id="btnPrevTab" disabled>
        <i class="bx bx-chevron-left me-1"></i> Sebelumnya
    </button>


    {{-- <button type="submit" class="btn btn-success">
        <i class="bx bx-save me-1"></i> Simpan Lembar Kerja
    </button> --}}

    <button type="button" class="btn btn-primary" id="btnNextTab">
        Selanjutnya <i class="bx bx-chevron-right ms-1"></i>
    </button>
</div>

            </form>
        </div>
    </div>
</div>

{{-- Modal Form Order --}}
<div class="modal fade" id="modalFormOrder" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title"><i class="bx bx-plus-circle me-2"></i>Tambah Form Order</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="formOrderModal">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Jenis Akta <span class="text-danger">*</span></label>
                            <select name="jenis_akta" class="form-control" required>
                                <option value="">-- Pilih Jenis --</option>
                                <option value="Akta PPAT">Akta PPAT</option>
                                <option value="Akta Notaris">Akta Notaris</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">No Akta <span class="text-danger">*</span></label>
                            <input type="text" name="no_akta" class="form-control" required placeholder="Masukkan No Akta">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal Akta <span class="text-danger">*</span></label>
                            <input type="date" name="tgl_akta" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Biaya <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="biaya" class="form-control" required placeholder="Masukkan biaya">
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Tanggal Akad</label>
                            <input type="date" name="tgl_akad" class="form-control">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Pihak Yang Mengalihkan</label>
                            <input type="text" name="pihak_yang_mengalihkan" class="form-control" placeholder="Nama pihak yang mengalihkan">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Pihak Menerima</label>
                            <input type="text" name="pihak_menerima" class="form-control" placeholder="Nama pihak yang menerima">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-semibold">Upload File</label>
                            <input type="file" name="file" class="form-control">
                            <div class="form-text">Format: PDF, DOC, DOCX (Maks. 5MB)</div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    <i class="bx bx-x me-1"></i> Batal
                </button>
                <button type="button" class="btn btn-primary" id="btnAddFormOrder">
                    <i class="bx bx-plus me-1"></i> Tambah ke Daftar
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.progress-steps {
    display: flex;
    justify-content: space-between;
    position: relative;
    margin-bottom: 2rem;
}

.progress-steps::before {
    content: '';
    position: absolute;
    top: 15px;
    left: 0;
    right: 0;
    height: 3px;
    background-color: #e9ecef;
    z-index: 1;
}

.progress-steps .step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 2;
}

.progress-steps .step.active .step-icon {
    background-color: #0d6efd;
    color: white;
    border-color: #0d6efd;
}

.progress-steps .step-icon {
    width: 35px;
    height: 35px;
    border-radius: 50%;
    background-color: #e9ecef;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    margin-bottom: 0.5rem;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}

.progress-steps .step-label {
    font-size: 0.875rem;
    font-weight: 500;
    color: #6c757d;
}

.progress-steps .step.active .step-label {
    color: #0d6efd;
}

.custom-nav-pills .nav-link {
    border-radius: 0.5rem;
    padding: 0.75rem 1.25rem;
    font-weight: 500;
    color: #6c757d;
    transition: all 0.2s ease;
}

.custom-nav-pills .nav-link:hover {
    background-color: #f8f9fa;
    color: #495057;
}

.custom-nav-pills .nav-link.active {
    background-color: #0d6efd;
    color: white;
    box-shadow: 0 0.125rem 0.25rem rgba(13, 110, 253, 0.3);
}

.option-card {
    border: 1px solid #e9ecef;
    border-radius: 0.5rem;
    transition: all 0.2s ease;
}

.option-card:hover {
    border-color: #0d6efd;
    box-shadow: 0 0.125rem 0.25rem rgba(13, 110, 253, 0.1);
}

.select2-enhanced + .select2-container .select2-selection--multiple {
    min-height: 42px;
    border: 1px solid #ced4da;
    border-radius: 0.375rem;
}

.select2-enhanced + .select2-container .select2-selection--multiple .select2-selection__choice {
    background-color: #0d6efd;
    color: white;
    border: none;
    border-radius: 0.25rem;
    padding: 0.25rem 0.5rem;
}

.table th {
    font-weight: 600;
    font-size: 0.875rem;
}

.input-group-text {
    transition: background-color 0.2s ease;
}

.form-control:focus + .input-group-text,
.form-select:focus + .input-group-text {
    background-color: #e7f1ff;
    border-color: #86b7fe;
}

@media (max-width: 768px) {
    .progress-steps {
        flex-wrap: wrap;
        gap: 1rem;
    }
    
    .progress-steps::before {
        display: none;
    }
    
    .d-flex.justify-content-between {
        flex-direction: column;
        gap: 1rem;
    }
    
    .d-flex.justify-content-between > div {
        order: 2;
    }
    
    #btnPrevTab, #btnNextTab {
        order: 1;
        width: 100%;
    }
}
</style>

@push('scripts')
{{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

<script>
document.addEventListener('DOMContentLoaded', function(){
    // Tab Navigation
    const tabs = document.querySelectorAll('#lembarKerjaTab .nav-link');
    const tabPanes = document.querySelectorAll('.tab-pane');
    const btnPrev = document.getElementById('btnPrevTab');
    const btnNext = document.getElementById('btnNextTab');
    const steps = document.querySelectorAll('.progress-steps .step');
    
    let currentTab = 0;
    
    function updateNavigation() {
        // Update button states
        btnPrev.disabled = currentTab === 0;
        btnNext.textContent = currentTab === tabs.length - 1 ? 'Simpan' : 'Selanjutnya';
        btnNext.innerHTML = currentTab === tabs.length - 1 ? 
            '<i class="bx bx-save me-1"></i> Simpan Lembar Kerja' : 
            'Selanjutnya <i class="bx bx-chevron-right ms-1"></i>';
            
        // Update progress steps
        steps.forEach((step, index) => {
            if (index <= currentTab) {
                step.classList.add('active');
            } else {
                step.classList.remove('active');
            }
        });
    }
    
    function switchTab(index) {
        // Hide all tabs
        tabs.forEach(tab => tab.classList.remove('active'));
        tabPanes.forEach(pane => pane.classList.remove('show', 'active'));
        
        // Show selected tab
        tabs[index].classList.add('active');
        tabPanes[index].classList.add('show', 'active');
        
        currentTab = index;
        updateNavigation();
    }
    
    btnNext.addEventListener('click', function() {
        if (currentTab < tabs.length - 1) {
            // Validate current tab before proceeding
            if (validateTab(currentTab)) {
                switchTab(currentTab + 1);
            }
        } else {
            // Submit form on last tab
            document.getElementById('lembarKerjaForm').submit();
        }
    });
    
    btnPrev.addEventListener('click', function() {
        if (currentTab > 0) {
            switchTab(currentTab - 1);
        }
    });
    
    // Tab validation function
    function validateTab(tabIndex) {
        let isValid = true;
        const currentPane = tabPanes[tabIndex];
        
        // Check required fields in current tab
        const requiredFields = currentPane.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value) {
                isValid = false;
                field.classList.add('is-invalid');
                
                // Add error message if not exists
                if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('invalid-feedback')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = 'Field ini wajib diisi';
                    field.parentNode.appendChild(errorDiv);
                }
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        if (!isValid) {
            // Scroll to first error
            const firstError = currentPane.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
        
        return isValid;
    }
    
    // Select2 Enhanced
   $('.select2').select2({
        placeholder: "Pilih opsi",
        allowClear: true,
        width: '100%',
        theme: 'bootstrap-5'
    });

    // Otomatis isi tipe pelanggan saat klien dipilih
    $('#klienSelect').on('change', function(){
        const tipe = $(this).find(':selected').data('tipe') || '';
        $('#tipePelanggan').val(tipe);
    });
    
    // Tanggal Otomatis
    const layananSelect = document.getElementById('layananSelect');
    const tglTarget = document.getElementById('tglTarget');
    
    layananSelect.addEventListener('change', function() {
        if (this.value) {
            // Set target date to today + 7 days
            let today = new Date();
            today.setDate(today.getDate() + 7);
            let yyyy = today.getFullYear();
            let mm = String(today.getMonth() + 1).padStart(2, '0');
            let dd = String(today.getDate()).padStart(2, '0');
            tglTarget.value = `${yyyy}-${mm}-${dd}`;
        } else {
            tglTarget.value = '';
        }
    });
    
    // Form Order Modal ke Tabel Review
    const formOrderModal = document.getElementById('formOrderModal');
    const reviewTableBody = document.querySelector('#reviewFormOrderTable tbody');
    const emptyFormOrderMessage = document.getElementById('emptyFormOrderMessage');
    let formOrderIndex = 0;
    
    document.getElementById('btnAddFormOrder').addEventListener('click', function(){
        const formData = new FormData(formOrderModal);
        
        // Validasi required
        const requiredFields = formOrderModal.querySelectorAll('[required]');
        for(const field of requiredFields){
            if(!formData.get(field.name)){
                field.classList.add('is-invalid');
                
                // Add error message if not exists
                if (!field.nextElementSibling || !field.nextElementSibling.classList.contains('invalid-feedback')) {
                    const errorDiv = document.createElement('div');
                    errorDiv.className = 'invalid-feedback';
                    errorDiv.textContent = 'Field ini wajib diisi';
                    field.parentNode.appendChild(errorDiv);
                }
                
                field.focus();
                return;
            } else {
                field.classList.remove('is-invalid');
            }
        }
        
        // Hide empty message
        emptyFormOrderMessage.classList.add('d-none');
        
        const row = document.createElement('tr');
        row.dataset.idx = formOrderIndex;
        row.innerHTML = `
            <td>${formOrderIndex+1}</td>
            <td>${formData.get('jenis_akta')}<input type="hidden" name="form_order[${formOrderIndex}][jenis_akta]" value="${formData.get('jenis_akta')}"></td>
            <td>${formData.get('no_akta')}<input type="hidden" name="form_order[${formOrderIndex}][no_akta]" value="${formData.get('no_akta')}"></td>
            <td>${formData.get('tgl_akta')}<input type="hidden" name="form_order[${formOrderIndex}][tgl_akta]" value="${formData.get('tgl_akta')}"></td>
            <td>Rp ${parseInt(formData.get('biaya')).toLocaleString('id-ID')}<input type="hidden" name="form_order[${formOrderIndex}][biaya]" value="${formData.get('biaya')}"></td>
            <td>${formData.get('tgl_akad') || '-'}<input type="hidden" name="form_order[${formOrderIndex}][tgl_akad]" value="${formData.get('tgl_akad')}"></td>
            <td>${formData.get('pihak_yang_mengalihkan') || '-'}<input type="hidden" name="form_order[${formOrderIndex}][pihak_yang_mengalihkan]" value="${formData.get('pihak_yang_mengalihkan')}"></td>
            <td>${formData.get('pihak_menerima') || '-'}<input type="hidden" name="form_order[${formOrderIndex}][pihak_menerima]" value="${formData.get('pihak_menerima')}"></td>
            <td>${formData.get('file') ? '<i class="bx bx-file text-primary"></i>' : '-'}<input type="hidden" name="form_order[${formOrderIndex}][file]" value=""></td>
            <td><button type="button" class="btn btn-outline-danger btn-sm btnRemoveRow"><i class="bx bx-trash"></i></button></td>
        `;
        reviewTableBody.appendChild(row);
        formOrderIndex++;
        
        // Reset dan tutup modal
        formOrderModal.reset();
        bootstrap.Modal.getInstance(document.getElementById('modalFormOrder')).hide();
    });
    
    // Hapus row dari tabel
    reviewTableBody.addEventListener('click', function(e){
        if(e.target.closest('.btnRemoveRow')){
            e.target.closest('tr').remove();
            
            // Show empty message if no rows left
            if (reviewTableBody.children.length === 1 && reviewTableBody.querySelector('#emptyFormOrderMessage')) {
                emptyFormOrderMessage.classList.remove('d-none');
            }
        }
    });
    
    // Initialize empty message
    emptyFormOrderMessage.classList.remove('d-none');
    
    // Validasi radio button di tab Setting sebelum submit
    const form = document.getElementById('lembarKerjaForm');
    form.addEventListener('submit', function(e){
        const requiredRadios = form.querySelectorAll('input[type="radio"][required]');
        let allChecked = true;
        
        requiredRadios.forEach(radio => {
            const name = radio.name;
            if(!form.querySelector(`input[name="${name}"]:checked`)){
                allChecked = false;
                const tab = new bootstrap.Tab(document.querySelector('#tab-setting'));
                tab.show();
                switchTab(2); // Switch to settings tab
                
                // Highlight the problematic option
                const optionCard = radio.closest('.option-card');
                if (optionCard) {
                    optionCard.style.borderColor = '#dc3545';
                    optionCard.style.boxShadow = '0 0 0 0.2rem rgba(220, 53, 69, 0.25)';
                    
                    // Remove highlight after 3 seconds
                    setTimeout(() => {
                        optionCard.style.borderColor = '';
                        optionCard.style.boxShadow = '';
                    }, 3000);
                }
            }
        });
        
        if(!allChecked){
            e.preventDefault();
            const alertDiv = document.createElement('div');
            alertDiv.className = 'alert alert-danger alert-dismissible fade show';
            alertDiv.innerHTML = `
                <i class="bx bx-error-circle me-2"></i>
                <strong>Perhatian!</strong> Harap pilih semua opsi Form Order di tab Setting!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            document.querySelector('.card-body').insertBefore(alertDiv, document.querySelector('.alert-info'));
        }
    });
    
    // Initialize
    updateNavigation();
});
</script>
@endpush
@endsection