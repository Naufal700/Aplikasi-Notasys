@extends('layouts/blankLayout')

@section('title', 'Lupa Kata Sandi - Materio')

@section('content')
<div class="login-card mx-auto shadow-sm">
    <!-- Logo -->
    <div class="app-brand text-center mb-4">
        <a href="{{ url('/') }}" class="app-brand-link gap-2">
            <span class="app-brand-logo demo">
                @include('_partials.macros',["height"=>30,"withbg"=>'fill: #6C5DD3;'])
            </span>
            <span class="app-brand-text fw-bold">Materio</span>
        </a>
    </div>

    <div class="card-body">
        <h4 class="text-center mb-2 fw-semibold">Lupa Kata Sandi? 🔒</h4>
        <p class="text-center mb-4 text-muted">
            Masukkan email Anda dan kami akan mengirim instruksi untuk mereset kata sandi.
        </p>

        {{-- Error Message --}}
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <form id="formForgotPassword" action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="form-floating form-floating-outline mb-3">
                <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" autofocus>
                <label for="email">Email</label>
            </div>

            <button class="btn btn-primary w-100 mb-3" type="submit">
                Kirim Link Reset
            </button>
        </form>

        <div class="text-center">
            <a href="{{ url('auth/login-basic') }}" class="d-flex align-items-center justify-content-center">
                <i class="mdi mdi-chevron-left scaleX-n1-rtl mdi-24px me-1"></i>
                Kembali ke Login
            </a>
        </div>
    </div>
</div>

{{-- Optional Illustrations --}}
<img src="{{ asset('assets/img/illustrations/tree-3.png') }}" alt="tree-left" class="position-absolute d-none d-lg-block" style="left:0; bottom:0; height:120px; opacity:0.4;">
<img src="{{ asset('assets/img/illustrations/tree.png') }}" alt="tree-right" class="position-absolute d-none d-lg-block" style="right:0; bottom:0; height:120px; opacity:0.4;">
<img src="{{ asset('assets/img/illustrations/auth-basic-mask-light.png') }}" class="position-absolute d-none d-lg-block" alt="triangle-bg" style="left:50%; transform:translateX(-50%); bottom:0; opacity:0.2;">
@endsection
