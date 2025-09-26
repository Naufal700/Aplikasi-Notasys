@extends('layouts/blankLayout')

@section('title', 'Masuk | ')

@section('content')
<div class="login-card mx-auto shadow-sm">
    <div class="card-body">
        <h4 class="text-center mb-2 fw-semibold">Selamat Datang! 👋</h4>
        <p class="text-center mb-4 text-muted">Masuk untuk melanjutkan ke dashboard Anda</p>

        {{-- Error Message --}}
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form id="formAuthentication" action="{{ route('login.perform') }}" method="POST">
            @csrf
            <div class="form-floating form-floating-outline mb-3">
                <input type="text" class="form-control" id="login" name="login" placeholder="Masukkan email atau username" autofocus>
<label for="login">Email atau Username</label>
            </div>

            <div class="form-floating form-floating-outline mb-3 position-relative">
                <input type="password" id="password" class="form-control" name="password" placeholder="••••••••" />
                <label for="password">Kata Sandi</label>
                <span class="position-absolute top-50 end-0 translate-middle-y pe-3 cursor-pointer" onclick="togglePassword()">
                    <i class="mdi mdi-eye-off-outline" id="toggleIcon"></i>
                </span>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember">
                    <label class="form-check-label" for="remember-me">Ingat Saya</label>
                </div>
                <a href="{{ route('password.request') }}">Lupa Kata Sandi?</a>
            </div>

            <button class="btn btn-primary w-100 mb-3" type="submit">Masuk</button>
        </form>

        <p class="text-center text-muted">
            Baru di platform kami? <a href="{{ route('register') }}">Buat akun</a>
        </p>
    </div>
</div>

{{-- Optional Minimal Illustrations --}}
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
