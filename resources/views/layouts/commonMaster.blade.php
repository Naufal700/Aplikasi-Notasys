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

    {{-- Google Fonts (Modern) --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />

    {{-- Materio Styles --}}
    @include('layouts.sections.styles')

    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- SweetAlert2 CSS --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }

       .content-wrapper {
  padding-top: 0 !important;
}
.container-xxl {
  margin-top: 0 !important;
  padding-top: 0.2rem !important;
}
.container-xxl h4.fw-bold {
  padding-top: 0 !important;
  margin-top: 0 !important;
}

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .swal2-container {
            z-index: 99999 !important;
        }

        .swal2-toast-custom {
            z-index: 99999 !important;
            border-radius: 12px !important;
            padding: 12px 16px !important;
        }

        /* Card Modern */
        .card {
            margin-bottom: 0.75rem;
            border-radius: 12px;
            border: 1px solid #e5e7eb;
            box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        }

        /* Select2 Modern */
        .select2-container .select2-selection--single {
            height: 42px !important;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            padding: 6px 12px;
            font-size: 14px;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .select2-container--default .select2-selection--single:hover {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15);
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 28px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 8px;
            right: 8px;
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

    {{-- Materio Scripts --}}
    @include('layouts.sections.scripts')

    {{-- jQuery (Pastikan sebelum Select2) --}}
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    {{-- Select2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    {{-- SweetAlert2 JS --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        $(document).ready(function() {
            // Inisialisasi Select2
            $('.select2').select2({ width: '100%' });

            // --- Global Laravel Toaster ---
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
                        timer: 2500,
                        showConfirmButton: false,
                        showCloseButton: true,
                        customClass: {
                            popup: 'swal2-toast-custom'
                        }
                    });
                }
            });
        });

        // --- Konfirmasi hapus ---
        function confirmDelete(event, formId) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data akan dihapus permanen!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
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
