<!DOCTYPE html>
<html lang="id" class="light-style">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Login') | Notasys</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    {{-- Materio Styles --}}
    @include('layouts.sections.styles')

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}" />

    @stack('page-style')
    <style>
        body {
            background: linear-gradient(135deg, #6C5DD3 0%, #8E44AD 100%);
        }
        .login-card {
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 0 0 30px rgba(0,0,0,0.15);
            background-color: #fff;
            position: relative;
            overflow: hidden;
        }
        .login-card::before {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: rgba(108, 93, 211, 0.1);
            transform: rotate(45deg);
            top: -50%;
            left: -50%;
            z-index: 0;
        }
        .login-card .card-body {
            position: relative;
            z-index: 1;
        }
        .form-control:focus {
            border-color: #6C5DD3;
            box-shadow: 0 0 0 0.2rem rgba(108, 93, 211, 0.25);
        }
        .btn-primary {
            background: #6C5DD3;
            border: none;
            transition: 0.3s;
        }
        .btn-primary:hover {
            background: #8E44AD;
        }
    </style>
</head>
<body>
    <div class="d-flex justify-content-center align-items-center min-vh-100">
        <div class="w-100" style="max-width: 420px;">
            @yield('layoutContent')
        </div>
    </div>

    {{-- Materio Scripts --}}
    @include('layouts.sections.scripts')
    @stack('page-script')
</body>
</html>
