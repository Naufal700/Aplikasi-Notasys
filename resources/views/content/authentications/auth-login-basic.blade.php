@extends('layouts/blankLayout')

@section('title', 'Masuk ')

@section('content')
<div class="login-card mx-auto shadow-sm">
    <div class="card-body">
        {{-- Header Section --}}
        <div class="text-center mb-4">
            <h4 class="fw-semibold mb-2">Selamat Datang! 👋</h4>
            <p class="text-muted">Masuk untuk melanjutkan ke dashboard Anda</p>
        </div>

        {{-- Error Message --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Success Message --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form id="formAuthentication" action="{{ route('login.perform') }}" method="POST">
            @csrf
            
            {{-- Email/Username Field --}}
            <div class="mb-3">
                <label for="login" class="form-label fw-medium">Email atau Username</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="mdi mdi-account-outline"></i>
                    </span>
                    <input type="text" class="form-control" id="login" name="login" 
                           placeholder="Masukkan email atau username" 
                           value="{{ old('login') }}" 
                           autofocus required>
                </div>
                @error('login')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password Field --}}
            <div class="mb-3">
                <label for="password" class="form-label fw-medium">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="mdi mdi-lock-outline"></i>
                    </span>
                    <input type="password" id="password" class="form-control" 
                           name="password" placeholder="••••••••" required>
                    <span class="input-group-text cursor-pointer" onclick="togglePassword()">
                        <i class="mdi mdi-eye-off-outline" id="toggleIcon"></i>
                    </span>
                </div>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Remember Me & Forgot Password --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember-me" name="remember">
                    <label class="form-check-label" for="remember-me">Ingat Saya</label>
                </div>
                <a href="{{ route('password.request') }}" class="text-decoration-none">
                    Lupa Kata Sandi?
                </a>
            </div>

            {{-- Submit Button --}}
            <button class="btn btn-primary w-100 mb-3" type="submit">
                <span class="d-flex align-items-center justify-content-center">
                    <i class="mdi mdi-login me-2"></i>
                    Masuk
                </span>
            </button>
        </form>

        {{-- Register Link --}}
        <div class="text-center mt-4">
            <p class="text-muted mb-0">
                Baru di platform kami? 
                <a href="{{ route('register') }}" class="text-decoration-none fw-medium">
                    Buat akun
                </a>
            </p>
        </div>
    </div>
</div>

{{-- Background Decorations --}}
<div class="position-fixed d-none d-lg-block" style="left:0; bottom:0; z-index: -1;">
    <img src="{{ asset('assets/img/illustrations/tree-3.png') }}" alt="tree-left" style="height:120px; opacity:0.4;">
</div>
<div class="position-fixed d-none d-lg-block" style="right:0; bottom:0; z-index: -1;">
    <img src="{{ asset('assets/img/illustrations/tree.png') }}" alt="tree-right" style="height:120px; opacity:0.4;">
</div>

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

// Add loading state to form submission
document.getElementById('formAuthentication').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = `
        <span class="d-flex align-items-center justify-content-center">
            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
            Memproses...
        </span>
    `;
    submitBtn.disabled = true;
    
    // Re-enable button after 3 seconds (fallback)
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 3000);
});

// Add input validation styling
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            if (this.value.trim() === '') {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
        
        input.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }
        });
    });
});
</script>

<style>
/* Additional custom styles for the login form */
.form-label {
    color: var(--dark-text);
    margin-bottom: 0.5rem;
}

.input-group-text {
    background-color: var(--light-bg);
    border: 1px solid #E2E8F0;
    transition: all 0.3s ease;
}

.input-group:focus-within .input-group-text {
    border-color: var(--primary-color);
    background-color: rgba(108, 93, 211, 0.05);
}

.cursor-pointer {
    cursor: pointer;
}

.alert {
    border-radius: 0.75rem;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.alert-danger {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.alert-success {
    background: rgba(25, 135, 84, 0.1);
    color: #198754;
}

.btn-close:focus {
    box-shadow: none;
}

.text-decoration-none:hover {
    text-decoration: underline !important;
}

.is-valid {
    border-color: #198754 !important;
}

.is-invalid {
    border-color: #dc3545 !important;
}

.spinner-border-sm {
    width: 1rem;
    height: 1rem;
}

.position-fixed {
    z-index: -1;
}
</style>
@endpush
@endsection