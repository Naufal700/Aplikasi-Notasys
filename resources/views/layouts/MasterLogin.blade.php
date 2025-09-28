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
        :root {
            --primary-color: #6C5DD3;
            --secondary-color: #8E44AD;
            --accent-color: #FF6B8B;
            --light-bg: #F8F9FA;
            --dark-text: #2D3748;
            --light-text: #718096;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
               background: linear-gradient(135deg, #667eea 0%, #667eea 100%) !important;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow-x: hidden;
        }
        
        /* Animated Background Elements */
        .bg-elements {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 0;
            overflow: hidden;
        }
        
        .bg-element {
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            animation: float 20s infinite linear;
        }
        
        .bg-element:nth-child(1) {
            width: 300px;
            height: 300px;
            top: -150px;
            left: -150px;
            animation-delay: 0s;
        }
        
        .bg-element:nth-child(2) {
            width: 200px;
            height: 200px;
            top: 20%;
            right: -100px;
            animation-delay: 5s;
        }
        
        .bg-element:nth-child(3) {
            width: 150px;
            height: 150px;
            bottom: 10%;
            left: 10%;
            animation-delay: 10s;
        }
        
        .bg-element:nth-child(4) {
            width: 100px;
            height: 100px;
            bottom: -50px;
            right: 20%;
            animation-delay: 15s;
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
            animation: fadeInUp 0.8s ease-out;
            position: relative;
            z-index: 10;
        }
        
        .login-card {
            border-radius: 1.5rem;
            padding: 2.5rem;
            box-shadow: 
                0 25px 50px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        
        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 
                0 35px 60px rgba(0, 0, 0, 0.2),
                0 0 0 1px rgba(255, 255, 255, 0.15),
                inset 0 1px 0 rgba(255, 255, 255, 0.3);
        }
        
        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
            z-index: 2;
        }
        
        .login-card::after {
            content: '';
            position: absolute;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(108, 93, 211, 0.05) 0%, rgba(142, 68, 173, 0.05) 100%);
            transform: rotate(45deg);
            top: -50%;
            left: -50%;
            z-index: 0;
            animation: rotateBackground 30s infinite linear;
        }
        
        .login-card .card-body {
            position: relative;
            z-index: 1;
        }
        
        .form-control {
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            border: 1px solid #E2E8F0;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.8);
            font-size: 0.9rem;
        }
        
        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(108, 93, 211, 0.15);
            background: rgba(255, 255, 255, 0.95);
            transform: translateY(-1px);
        }
        
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(108, 93, 211, 0.3);
            position: relative;
            overflow: hidden;
        }
        
        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(108, 93, 211, 0.4);
        }
        
        .btn-primary:hover::before {
            left: 100%;
        }
        
        .btn-primary:active {
            transform: translateY(0);
        }
        
        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            33% {
                transform: translate(30px, -30px) rotate(120deg);
            }
            66% {
                transform: translate(-20px, 20px) rotate(240deg);
            }
        }
        
        @keyframes rotateBackground {
            from {
                transform: rotate(0deg);
            }
            to {
                transform: rotate(360deg);
            }
        }
        
        /* Responsive Design */
        @media (max-width: 480px) {
            .login-card {
                padding: 2rem 1.5rem;
                margin: 0 0.5rem;
            }
            
            body {
                padding: 0.5rem;
            }
        }
        
        @media (max-width: 360px) {
            .login-card {
                padding: 1.5rem 1rem;
            }
        }
        
        /* Loading State */
        .loading {
            position: relative;
            pointer-events: none;
        }
        
        .loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid transparent;
            border-top: 2px solid currentColor;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        
        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
        
        /* Utility Classes */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        .shadow-soft {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>
<body>
    <!-- Animated Background Elements -->
    <div class="bg-elements">
        <div class="bg-element"></div>
        <div class="bg-element"></div>
        <div class="bg-element"></div>
        <div class="bg-element"></div>
    </div>
    
    <div class="login-container">
        @yield('layoutContent')
    </div>

    {{-- Materio Scripts --}}
    @include('layouts.sections.scripts')
    
    <script>
        // Add smooth interactions
        document.addEventListener('DOMContentLoaded', function() {
            // Add focus effects to form controls
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                
                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });
            
            // Add loading state to forms
            const forms = document.querySelectorAll('form');
            forms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.classList.add('loading');
                        submitBtn.disabled = true;
                        
                        // Re-enable after 5 seconds (fallback)
                        setTimeout(() => {
                            submitBtn.classList.remove('loading');
                            submitBtn.disabled = false;
                        }, 5000);
                    }
                });
            });
            
            // Parallax effect for background elements
            document.addEventListener('mousemove', function(e) {
                const bgElements = document.querySelectorAll('.bg-element');
                const mouseX = e.clientX / window.innerWidth;
                const mouseY = e.clientY / window.innerHeight;
                
                bgElements.forEach((element, index) => {
                    const speed = (index + 1) * 0.5;
                    const x = (mouseX - 0.5) * speed * 50;
                    const y = (mouseY - 0.5) * speed * 50;
                    
                    element.style.transform = `translate(${x}px, ${y}px) rotate(${index * 45}deg)`;
                });
            });
        });
    </script>
    
    @stack('page-script')
</body>
</html>