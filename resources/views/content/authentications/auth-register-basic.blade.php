@extends('layouts/blankLayout')

@section('title', 'Daftar ')

@section('content')
<div class="login-card mx-auto shadow-sm">
    <div class="card-body">
        {{-- Header Section --}}
        <div class="text-center mb-4">
            <h4 class="fw-semibold mb-2">Mulai Petualangan Anda 🚀</h4>
            <p class="text-muted">Kelola aplikasi Anda dengan mudah dan menyenangkan!</p>
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

        <form id="formRegister" action="{{ route('register.perform') }}" method="POST">
            @csrf
            
            {{-- Username Field --}}
            <div class="mb-3">
                <label for="username" class="form-label fw-medium">Username</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="mdi mdi-account-circle-outline"></i>
                    </span>
                    <input type="text" class="form-control" id="username" name="username" 
                           placeholder="Masukkan username" 
                           value="{{ old('username') }}" 
                           autofocus required>
                </div>
                @error('username')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Email Field --}}
            <div class="mb-3">
                <label for="email" class="form-label fw-medium">Email</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="mdi mdi-email-outline"></i>
                    </span>
                    <input type="email" class="form-control" id="email" name="email" 
                           placeholder="Masukkan email" 
                           value="{{ old('email') }}" 
                           required>
                </div>
                @error('email')
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
                    <span class="input-group-text cursor-pointer" onclick="togglePassword('password', 'toggleIcon')">
                        <i class="mdi mdi-eye-off-outline" id="toggleIcon"></i>
                    </span>
                </div>
                {{-- <div class="form-text">
                    Minimal 8 karakter dengan kombinasi huruf dan angka
                </div> --}}
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Confirm Password Field --}}
            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-medium">Konfirmasi Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="mdi mdi-lock-check-outline"></i>
                    </span>
                    <input type="password" id="password_confirmation" class="form-control" 
                           name="password_confirmation" placeholder="••••••••" required>
                    <span class="input-group-text cursor-pointer" onclick="togglePassword('password_confirmation', 'toggleIconConfirm')">
                        <i class="mdi mdi-eye-off-outline" id="toggleIconConfirm"></i>
                    </span>
                </div>
                @error('password_confirmation')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Terms and Conditions --}}
            <div class="mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required>
                    <label class="form-check-label" for="terms-conditions">
                        Saya setuju dengan 
                        <a href="javascript:void(0);" class="text-decoration-none">kebijakan privasi & syarat</a>
                    </label>
                </div>
                @error('terms')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button class="btn btn-primary w-100 mb-3" type="submit">
                <span class="d-flex align-items-center justify-content-center">
                    <i class="mdi mdi-account-plus-outline me-2"></i>
                    Daftar
                </span>
            </button>
        </form>

        {{-- Login Link --}}
        <div class="text-center mt-4">
            <p class="text-muted mb-0">
                Sudah punya akun? 
                <a href="{{ route('login') }}" class="text-decoration-none fw-medium">
                    Masuk di sini
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
function togglePassword(inputId, iconId) {
    const input = document.getElementById(inputId);
    const icon = document.getElementById(iconId);
    
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

// Password strength indicator
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strengthIndicator = document.getElementById('password-strength');
    
    if (!strengthIndicator) {
        // Create strength indicator if it doesn't exist
        const indicator = document.createElement('div');
        indicator.id = 'password-strength';
        indicator.className = 'mt-2';
        this.parentNode.parentNode.appendChild(indicator);
    }
    
    updatePasswordStrength(password);
});

function updatePasswordStrength(password) {
    const indicator = document.getElementById('password-strength');
    let strength = 0;
    let feedback = '';
    
    // Check password strength
    if (password.length >= 8) strength++;
    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
    if (password.match(/\d/)) strength++;
    if (password.match(/[^a-zA-Z\d]/)) strength++;
    
    switch(strength) {
        case 0:
        case 1:
            feedback = '<span class="text-danger">Kata sandi lemah</span>';
            break;
        case 2:
            feedback = '<span class="text-warning">Kata sandi cukup</span>';
            break;
        case 3:
            feedback = '<span class="text-info">Kata sandi kuat</span>';
            break;
        case 4:
            feedback = '<span class="text-success">Kata sandi sangat kuat</span>';
            break;
    }
    
    indicator.innerHTML = feedback;
}

// Form validation
document.getElementById('formRegister').addEventListener('submit', function(e) {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    const terms = document.getElementById('terms-conditions').checked;
    
    // Check if passwords match
    if (password !== confirmPassword) {
        e.preventDefault();
        alert('Kata sandi dan konfirmasi kata sandi tidak cocok');
        return;
    }
    
    // Check if terms are accepted
    if (!terms) {
        e.preventDefault();
        alert('Anda harus menyetujui kebijakan privasi & syarat');
        return;
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = `
        <span class="d-flex align-items-center justify-content-center">
            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
            Membuat akun...
        </span>
    `;
    submitBtn.disabled = true;
    
    // Re-enable button after 3 seconds (fallback)
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 3000);
});

// Real-time validation
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
    
    // Email validation
    const emailInput = document.getElementById('email');
    emailInput.addEventListener('blur', function() {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(this.value)) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        }
    });
});
</script>

<style>
/* Additional custom styles for the register form */
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

.form-text {
    font-size: 0.8rem;
    color: var(--light-text);
    margin-top: 0.25rem;
}

#password-strength {
    font-size: 0.85rem;
    font-weight: 500;
}
</style>
@endpush
@endsection