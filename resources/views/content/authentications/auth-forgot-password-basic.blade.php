@extends('layouts/blankLayout')

@section('title', 'Lupa Kata Sandi | ')

@section('content')
<div class="login-card mx-auto shadow-sm">
    <div class="card-body">
        {{-- Header Section --}}
        <div class="text-center mb-4">
            {{-- <div class="brand-logo mb-3">
                <i class="mdi mdi-lock-reset text-white" style="font-size: 2.5rem;"></i>
            </div> --}}
            <h4 class="fw-semibold mb-2">Lupa Kata Sandi? 🔒</h4>
            <p class="text-muted">
                Masukkan email Anda dan kami akan mengirim instruksi untuk mereset kata sandi.
            </p>
        </div>

        {{-- Error Message --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Success Message --}}
        @if(session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <span>{{ session('status') }}</span>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form id="formForgotPassword" action="{{ route('password.email') }}" method="POST">
            @csrf
            
            {{-- Email Field --}}
            <div class="mb-4">
                <label for="email" class="form-label fw-medium">Email</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="mdi mdi-email-outline"></i>
                    </span>
                    <input type="email" class="form-control" id="email" name="email" 
                           placeholder="Masukkan email Anda" 
                           value="{{ old('email') }}" 
                           autofocus required>
                </div>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
                <div class="form-text">
                    Pastikan email yang Anda masukkan sudah terdaftar
                </div>
            </div>

            {{-- Submit Button --}}
            <button class="btn btn-primary w-100 mb-3" type="submit">
                <span class="d-flex align-items-center justify-content-center">
                    <i class="mdi mdi-send-outline me-2"></i>
                    Kirim Link Reset
                </span>
            </button>
        </form>

        {{-- Back to Login --}}
        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="text-decoration-none d-inline-flex align-items-center">
                <i class="mdi mdi-chevron-left me-1"></i>
                Kembali ke Login
            </a>
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
// Form validation
document.getElementById('formForgotPassword').addEventListener('submit', function(e) {
    const email = document.getElementById('email').value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    // Validate email format
    if (!emailRegex.test(email)) {
        e.preventDefault();
        document.getElementById('email').classList.add('is-invalid');
        return;
    }
    
    // Show loading state
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = `
        <span class="d-flex align-items-center justify-content-center">
            <div class="spinner-border spinner-border-sm me-2" role="status"></div>
            Mengirim link...
        </span>
    `;
    submitBtn.disabled = true;
    
    // Re-enable button after 5 seconds (fallback)
    setTimeout(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    }, 5000);
});

// Real-time email validation
document.getElementById('email').addEventListener('input', function() {
    const email = this.value;
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (email === '') {
        this.classList.remove('is-valid', 'is-invalid');
    } else if (emailRegex.test(email)) {
        this.classList.remove('is-invalid');
        this.classList.add('is-valid');
    } else {
        this.classList.remove('is-valid');
        this.classList.add('is-invalid');
    }
});

// Check if there's a success message and auto-dismiss after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const successAlert = document.querySelector('.alert-success');
    if (successAlert) {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(successAlert);
            bsAlert.close();
        }, 5000);
    }
    
    // Add focus effect to input group
    const inputGroups = document.querySelectorAll('.input-group');
    inputGroups.forEach(group => {
        const input = group.querySelector('input');
        input.addEventListener('focus', function() {
            group.classList.add('focused');
        });
        input.addEventListener('blur', function() {
            group.classList.remove('focused');
        });
    });
});
</script>

<style>
/* Additional custom styles for the forgot password form */
.brand-logo {
    width: 80px;
    height: 80px;
    margin: 0 auto 1rem;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 10px 20px rgba(108, 93, 211, 0.3);
}

.form-label {
    color: var(--dark-text);
    margin-bottom: 0.5rem;
}

.input-group {
    transition: all 0.3s ease;
}

.input-group.focused {
    transform: translateY(-2px);
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

/* Animation for the lock icon */
.brand-logo i {
    animation: gentleBounce 2s ease-in-out infinite;
}

@keyframes gentleBounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-5px);
    }
}

/* Success state styling */
.alert-success {
    border-left: 4px solid #198754;
}

.alert-danger {
    border-left: 4px solid #dc3545;
}
</style>
@endpush
@endsection