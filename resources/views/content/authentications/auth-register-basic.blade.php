@extends('layouts/blankLayout')

@section('title', 'Daftar | ')

@section('content')
<div class="login-card mx-auto shadow-sm">
    {{-- <!-- Logo -->
    <div class="app-brand text-center mb-4">
        <a href="{{ url('/') }}" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">
                @include('_partials.macros',["height"=>30,"withbg"=>'fill: #6C5DD3;'])
            </span>
            <span class="app-brand-text fw-bold">Materio</span>
        </a>
    </div> --}}

    <div class="card-body">
        <h4 class="text-center mb-2 fw-semibold">Mulai Petualangan Anda 🚀</h4>
        <p class="text-center mb-4 text-muted">Kelola aplikasi Anda dengan mudah dan menyenangkan!</p>

        {{-- Error Message --}}
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form id="formRegister" action="{{ route('register.perform') }}" method="POST">
            @csrf
            <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan username" autofocus required>
                <label for="username">Username</label>
            </div>

            <div class="form-floating form-floating-outline mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" required>
                <label for="email">Email</label>
            </div>

            <div class="form-floating form-floating-outline mb-3 position-relative">
                <input type="password" id="password" class="form-control" name="password" placeholder="••••••••" required />
                <label for="password">Kata Sandi</label>
                <span class="position-absolute top-50 end-0 translate-middle-y pe-3 cursor-pointer" onclick="togglePassword()">
                    <i class="mdi mdi-eye-off-outline" id="toggleIcon"></i>
                </span>
            </div>

            {{-- Konfirmasi Password --}}
            <div class="form-floating form-floating-outline mb-3 position-relative">
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="••••••••" required />
                <label for="password_confirmation">Konfirmasi Kata Sandi</label>
            </div>

            <div class="mb-3 form-check">
                <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required>
                <label class="form-check-label" for="terms-conditions">
                    Saya setuju dengan <a href="javascript:void(0);">kebijakan privasi & syarat</a>
                </label>
            </div>

            <button class="btn btn-primary w-100 mb-3" type="submit">Daftar</button>
        </form>

        <p class="text-center text-muted">
            Sudah punya akun? <a href="{{ url('auth/login-basic') }}">Masuk di sini</a>
        </p>
    </div>
</div>

{{-- Optional Illustrations --}}
<img src="{{ asset('assets/img/illustrations/tree-3.png') }}" alt="tree-left" class="position-absolute d-none d-lg-block" style="left:0; bottom:0; height:120px; opacity:0.4;">
<img src="{{ asset('assets/img/illustrations/tree.png') }}" alt="tree-right" class="position-absolute d-none d-lg-block" style="right:0; bottom:0; height:120px; opacity:0.4;">

@push('page-script')
<script>
    function togglePassword() {
        const input = document.getElementById('password');
        const icon = document.getElementById('toggleIcon');
        if(input.type === "password"){
            input.type = "text";
            icon.classList.remove('mdi-eye-off-outline');
            icon.classList.add('mdi-eye-outline');
        } else {
            input.type = "password";
            icon.classList.remove('mdi-eye-outline');
            icon.classList.add('mdi-eye-off-outline');
        }
    }
</script>
@endpush
@endsection
