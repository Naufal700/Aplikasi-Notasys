@extends('layouts.commonMaster')
@section('title','Setting Aplikasi')
@section('layoutContent')

<div class="container-xxl flex-grow-1 container-p-y">
   

    <!-- Main Card -->
    <div class="card">
        <div class="card-header bg-transparent border-bottom-0 pt-4">
             <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div>
                    <h4 class="fw-bold mb-1">Setting Aplikasi</h4>
                    <p class="text-muted mb-0">Kelola konfigurasi sistem dan profil notaris</p>
                </div>
                {{-- <div class="d-flex align-items-center">
                    <span class="badge bg-label-primary">
                        <i class="bi bi-shield-check me-1"></i>
                        Admin Only
                    </span>
                </div> --}}
            </div>
        </div>
    </div>
            <!-- Modern Tabs -->
            <div class="d-flex border-bottom">
                <button class="tab-button active px-4 py-3" data-target="profil-notaris">
                    <i class="bi bi-person-badge me-2"></i>
                    Profil Notaris
                </button>
                <button class="tab-button px-4 py-3" data-target="general-setting">
                    <i class="bi bi-sliders me-2"></i>
                    Pengaturan Sistem
                </button>
                <button class="tab-button px-4 py-3" data-target="backup-restore">
                    <i class="bi bi-database me-2"></i>
                    Data Management
                </button>
            </div>
        </div>

        <div class="card-body">
            <!-- Tab Content -->
            <div id="profil-notaris" class="tab-content active">
                @include('setting.tabs.profil_notaris')
            </div>
            
            <div id="general-setting" class="tab-content">
                <div class="text-center py-5">
                    <div class="avatar avatar-lg bg-label-info mb-3">
                        <i class="bi bi-sliders fs-4"></i>
                    </div>
                    <h5 class="text-muted">Pengaturan Sistem</h5>
                    <p class="text-muted mb-4">Konfigurasi pengaturan sistem akan segera tersedia</p>
                    <button class="btn btn-outline-primary" disabled>
                        <i class="bi bi-clock me-1"></i>
                        Coming Soon
                    </button>
                </div>
            </div>
            
            <div id="backup-restore" class="tab-content">
                <div class="text-center py-5">
                    <div class="avatar avatar-lg bg-label-success mb-3">
                        <i class="bi bi-database fs-4"></i>
                    </div>
                    <h5 class="text-muted">Manajemen Data</h5>
                    <p class="text-muted mb-4">Fitur backup dan restore data akan segera tersedia</p>
                    <button class="btn btn-outline-success" disabled>
                        <i class="bi bi-clock me-1"></i>
                        Coming Soon
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom Styles dan JavaScript -->
<style>
.tab-button {
    border: none;
    background: transparent;
    color: #6c757d;
    font-weight: 500;
    border-bottom: 3px solid transparent;
    transition: all 0.3s ease;
    position: relative;
}

.tab-button:hover {
    color: #495057;
    border-bottom-color: #dee2e6;
}

.tab-button.active {
    color: #696cff;
    border-bottom-color: #696cff;
}

.tab-content {
    display: none;
}

.tab-content.active {
    display: block;
    animation: fadeIn 0.3s ease;
}

.avatar {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    width: 4rem;
    height: 4rem;
}

.bg-label-info {
    background-color: rgba(13, 202, 240, 0.1);
    color: #0dcaf0;
}

.bg-label-success {
    background-color: rgba(25, 135, 84, 0.1);
    color: #198754;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const target = this.getAttribute('data-target');
            
            // Remove active class from all buttons and contents
            tabButtons.forEach(btn => btn.classList.remove('active'));
            tabContents.forEach(content => content.classList.remove('active'));
            
            // Add active class to current button and target content
            this.classList.add('active');
            document.getElementById(target).classList.add('active');
        });
    });
});
</script>

@endsection