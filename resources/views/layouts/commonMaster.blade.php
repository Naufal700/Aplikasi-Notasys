<!DOCTYPE html>
<html lang="id" class="light-style layout-menu-fixed"
      data-theme="theme-default"
      data-assets-path="{{ asset('/assets/') }}/"
      data-base-url="{{ url('/') }}"
      data-framework="laravel"
      data-template="vertical-menu-laravel-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <title>@yield('title') | Notasys</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />

    {{-- Materio Styles --}}
    @include('layouts.sections.styles')

    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- SweetAlert2 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <link href="https://cdn.materialdesignicons.com/7.1.96/css/materialdesignicons.min.css" rel="stylesheet">

    <style>
        /* CSS Variables untuk Konsistensi */
        :root {
            --primary-color: #6366f1;
            --danger-color: #ef4444;
            --secondary-color: #6b7280;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --light-bg: #f4f6f9;
            --card-radius: 8px;
            --border-radius: 6px;
            --shadow-light: 0 1px 3px rgba(0,0,0,0.08);
            --font-family: 'Inter', sans-serif;
        }

        /* Reset dan Base Styles */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--light-bg);
            color: #333;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
            margin-top: 0;
            line-height: 1.3;
        }

        /* Layout Utama */
        .layout-wrapper {
            min-height: 100vh;
        }

        .layout-container {
            display: flex;
            min-height: 100vh;
        }

        .layout-page {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Content Wrapper dan Container */
        .content-wrapper {
            flex: 1;
            padding: 0.5rem 0 !important;
        }

        .container-xxl {
            max-width: 100%;
            padding: 0 1.5rem;
            margin: 0 auto;
        }

        /* Card Styles yang Statis */
        .card {
            margin-bottom: 0.75rem;
            border-radius: var(--card-radius);
            border: 1px solid #e0e0e0;
            box-shadow: var(--shadow-light);
            overflow: hidden;
            background-color: #fff;
        }

        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 1rem 1.25rem;
        }

        .card-body {
            padding: 1.25rem;
        }

        .card-title {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
            color: #2d3748;
        }

        /* Form Controls */
        .form-control, .form-select {
            border-radius: var(--border-radius);
            border: 1px solid #d1d5db;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            outline: none;
        }

        /* Select2 Styling */
        .select2-container .select2-selection--single {
            height: 38px !important;
            border-radius: var(--border-radius);
            border: 1px solid #d1d5db !important;
            padding: 5px 10px;
            font-size: 14px;
            background-color: #fff;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px;
            color: #374151;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 6px;
            right: 8px;
        }

        /* Button Styles */
        .btn {
            border-radius: var(--border-radius);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border: 1px solid transparent;
            font-size: 0.875rem;
            cursor: pointer;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #fff;
        }

        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
            color: #fff;
        }

        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
            color: #fff;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.8125rem;
        }

        /* Table Styles */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background-color: #f8f9fa;
            font-weight: 600;
            color: #374151;
            border-top: 1px solid #e9ecef;
            padding: 0.75rem;
            text-align: left;
        }

        .table td {
            padding: 0.75rem;
            border-top: 1px solid #e9ecef;
            vertical-align: middle;
        }

        /* Alert dan Notification */
        .alert {
            border-radius: var(--border-radius);
            border: 1px solid transparent;
            padding: 0.75rem 1rem;
            margin-bottom: 1rem;
        }

        .alert-success {
            background-color: #d1fae5;
            border-color: #a7f3d0;
            color: #065f46;
        }

        .alert-danger {
            background-color: #fee2e2;
            border-color: #fecaca;
            color: #991b1b;
        }

        .alert-warning {
            background-color: #fef3c7;
            border-color: #fde68a;
            color: #92400e;
        }

        .alert-info {
            background-color: #dbeafe;
            border-color: #bfdbfe;
            color: #1e40af;
        }

        /* SweetAlert2 Customization */
        .swal2-container {
            position: fixed !important;
            z-index: 110000 !important;
        }

        .swal2-toast-custom {
            z-index: 110001 !important;
            border-radius: var(--border-radius) !important;
            padding: 10px 14px !important;
            font-size: 14px;
        }

        /* Utilities */
        .text-primary { color: var(--primary-color) !important; }
        .text-danger { color: var(--danger-color) !important; }
        .text-success { color: var(--success-color) !important; }
        .text-warning { color: var(--warning-color) !important; }
        .text-secondary { color: var(--secondary-color) !important; }

        .bg-primary { background-color: var(--primary-color) !important; }
        .bg-danger { background-color: var(--danger-color) !important; }
        .bg-success { background-color: var(--success-color) !important; }
        .bg-warning { background-color: var(--warning-color) !important; }
        .bg-light { background-color: var(--light-bg) !important; }

        /* Spacing Utilities */
        .mb-0 { margin-bottom: 0 !important; }
        .mb-1 { margin-bottom: 0.5rem !important; }
        .mb-2 { margin-bottom: 1rem !important; }
        .mb-3 { margin-bottom: 1.5rem !important; }

        .mt-0 { margin-top: 0 !important; }
        .mt-1 { margin-top: 0.5rem !important; }
        .mt-2 { margin-top: 1rem !important; }
        .mt-3 { margin-top: 1.5rem !important; }

        .p-0 { padding: 0 !important; }
        .p-1 { padding: 0.5rem !important; }
        .p-2 { padding: 1rem !important; }
        .p-3 { padding: 1.5rem !important; }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .container-xxl {
                padding: 0 1rem;
            }
            
            .card-body {
                padding: 1rem;
            }
            
            .content-wrapper {
                padding: 0.25rem 0 !important;
            }
        }

        @media (max-width: 576px) {
            .container-xxl {
                padding: 0 0.75rem;
            }
            
            .card-body {
                padding: 0.75rem;
            }
        }

        /* Layout khusus untuk konten */
        .page-header {
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid #e9ecef;
        }

        .page-title {
            font-size: 1.5rem;
            color: #2d3748;
            margin-bottom: 0.25rem;
        }

        .page-subtitle {
            color: #6b7280;
            font-size: 0.9rem;
        }

        /* Grid system sederhana */
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -0.75rem;
        }

        .col {
            flex: 1;
            padding: 0 0.75rem;
        }

        .col-6 {
            flex: 0 0 50%;
            padding: 0 0.75rem;
        }

        .col-4 {
            flex: 0 0 33.333%;
            padding: 0 0.75rem;
        }

        .col-3 {
            flex: 0 0 25%;
            padding: 0 0.75rem;
        }

        /* Form groups */
        .form-group {
            margin-bottom: 1rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #374151;
        }

        /* Badge */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
        }

        .badge-primary {
            background-color: var(--primary-color);
            color: white;
        }

        .badge-success {
            background-color: var(--success-color);
            color: white;
        }

        .badge-danger {
            background-color: var(--danger-color);
            color: white;
        }

        .badge-warning {
            background-color: var(--warning-color);
            color: white;
        }

        /* Text utilities */
        .text-center { text-align: center !important; }
        .text-left { text-align: left !important; }
        .text-right { text-align: right !important; }

        .font-weight-bold { font-weight: 600 !important; }
        .font-weight-normal { font-weight: 400 !important; }

        /* Display utilities */
        .d-block { display: block !important; }
        .d-inline { display: inline !important; }
        .d-inline-block { display: inline-block !important; }
        .d-flex { display: flex !important; }
        .d-none { display: none !important; }

        /* Flex utilities */
        .justify-content-between { justify-content: space-between !important; }
        .align-items-center { align-items: center !important; }

        /* Clearfix */
        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
   .select2-dropdown-custom .select2-results__options {
    max-height: 200px; /* tinggi maksimal dropdown */
    overflow-y: auto;
}

    </style>
</head>

<body>
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">

            {{-- Sidebar --}}
            @include('layouts.sections.menu.verticalMenu')

            {{-- Layout Page --}}
            <div class="layout-page">

                {{-- Navbar --}}
                @include('layouts.sections.navbar.navbar')

                {{-- Main Content --}}
                <div class="content-wrapper">
                    <div class="container-xxl">
                        @yield('layoutContent')
                    </div>
                </div>

                {{-- Footer --}}
                @include('layouts.sections.footer.footer')

            </div>
        </div>

        <div class="layout-overlay layout-menu-toggle"></div>
    </div>

    {{-- Scripts --}}
    @include('layouts.sections.scripts')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        $(document).ready(function() {
            // Select2 dengan konfigurasi sederhana
            $('.select2').select2({ 
                width: '100%',
                placeholder: "Pilih opsi",
                allowClear: true
            });

            // Laravel Toast Alerts
            const alerts = {!! json_encode([
                'success' => session('success'),
                'error'   => session('error'),
                'warning' => session('warning'),
                'info'    => session('info')
            ]) !!};

            Object.entries(alerts).forEach(([type, message]) => {
                if(message){
                    Swal.fire({
                        icon: type,
                        title: type.charAt(0).toUpperCase() + type.slice(1),
                        text: message,
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                        showConfirmButton: false,
                        showCloseButton: true,
                        customClass: {
                            popup: 'swal2-toast-custom'
                        }
                    });
                }
            });
        });

        // Konfirmasi Hapus sederhana
        function confirmDelete(event, formId, itemName = 'Data') {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                html: `<strong>${itemName}</strong> akan dihapus permanen!`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>

    @stack('scripts')
</body>
</html>