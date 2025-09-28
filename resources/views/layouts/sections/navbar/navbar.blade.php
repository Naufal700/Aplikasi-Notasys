@php
$containerNav = $containerNav ?? 'container-fluid';
$navbarDetached = ($navbarDetached ?? '');
@endphp

<!-- Navbar -->
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="{{$containerNav}}">
        
        <!-- Brand Logo -->
             
        <!-- Toggle button modern -->
        <button class="navbar-toggler custom-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarContent" aria-controls="navbarContent" 
                aria-expanded="false" aria-label="Toggle navigation">
            <span class="toggler-icon"></span>
            <span class="toggler-icon"></span>
            <span class="toggler-icon"></span>
        </button>

        <!-- Navbar content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            
            <!-- Search Bar Modern -->
            <div class="navbar-nav align-items-center me-auto">
                <div class="nav-item search-container position-relative">
                    <div class="search-icon">
                        <i class="mdi mdi-magnify mdi-24px"></i>
                    </div>
                    <input type="text" class="search-input" 
                           placeholder="Cari sesuatu..." aria-label="Search">
                    <div class="search-actions">
                        <button class="btn-search-clear">
                            <i class="mdi mdi-close"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Notification & Quick Actions -->
            <ul class="navbar-nav flex-row align-items-center ms-auto">
                
                <!-- Quick Actions -->
                <li class="nav-item quick-actions me-2 d-none d-lg-flex">
                    <div class="btn-group" role="group">
                        <button type="button" class="btn btn-light btn-sm rounded-pill px-3">
                            <i class="mdi mdi-plus me-1"></i> Baru
                        </button>
                        <button type="button" class="btn btn-light btn-sm rounded-pill px-3">
                            <i class="mdi mdi-refresh me-1"></i> Refresh
                        </button>
                    </div>
                </li>

                <!-- Notification Bell -->
                <li class="nav-item dropdown notification-dropdown me-2">
                    <a class="nav-link notification-icon" href="#" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-bell-outline mdi-24px"></i>
                        <span class="notification-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end notification-menu">
                        <div class="notification-header d-flex justify-content-between align-items-center p-3">
                            <h6 class="mb-0">Notifikasi</h6>
                            <span class="badge bg-primary rounded-pill">3 Baru</span>
                        </div>
                        <div class="notification-list" style="max-height: 300px; overflow-y: auto;">
                            <a href="#" class="notification-item d-flex align-items-start p-3 border-bottom">
                                <div class="notification-icon bg-success rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="mdi mdi-check text-white"></i>
                                </div>
                                <div class="notification-content flex-grow-1">
                                    <p class="mb-1 fw-medium">Pesanan baru diterima</p>
                                    <small class="text-muted">2 menit lalu</small>
                                </div>
                            </a>
                            <a href="#" class="notification-item d-flex align-items-start p-3 border-bottom">
                                <div class="notification-icon bg-warning rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="mdi mdi-alert text-white"></i>
                                </div>
                                <div class="notification-content flex-grow-1">
                                    <p class="mb-1 fw-medium">Stok hampir habis</p>
                                    <small class="text-muted">1 jam lalu</small>
                                </div>
                            </a>
                            <a href="#" class="notification-item d-flex align-items-start p-3 border-bottom">
                                <div class="notification-icon bg-info rounded-circle d-flex align-items-center justify-content-center me-3">
                                    <i class="mdi mdi-information text-white"></i>
                                </div>
                                <div class="notification-content flex-grow-1">
                                    <p class="mb-1 fw-medium">Laporan bulanan siap</p>
                                    <small class="text-muted">5 jam lalu</small>
                                </div>
                            </a>
                        </div>
                        <div class="notification-footer p-3 text-center border-top">
                            <a href="#" class="text-primary text-decoration-none fw-medium">Lihat Semua Notifikasi</a>
                        </div>
                    </div>
                </li>

                <!-- Quick Settings -->
                {{-- <li class="nav-item dropdown quick-settings me-2">
                    <a class="nav-link settings-icon" href="#" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-cog-outline mdi-24px"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end settings-menu p-0">
                        <div class="settings-header p-3 border-bottom">
                            <h6 class="mb-0">Pengaturan Cepat</h6>
                        </div>
                        <div class="settings-content p-3">
                            <div class="setting-item d-flex justify-content-between align-items-center mb-3">
                                <label class="form-check-label fw-medium">Mode Gelap</label>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" id="darkModeSwitch">
                                </div>
                            </div>
                            <div class="setting-item d-flex justify-content-between align-items-center mb-3">
                                <label class="form-check-label fw-medium">Notifikasi</label>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" checked id="notificationSwitch">
                                </div>
                            </div>
                            <div class="setting-item d-flex justify-content-between align-items-center">
                                <label class="form-check-label fw-medium">Suara</label>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" checked id="soundSwitch">
                                </div>
                            </div>
                        </div>
                    </div>
                </li> --}}

                <!-- User Profile dengan gradient -->
                <li class="nav-item dropdown user-dropdown">
                    <a class="nav-link user-profile d-flex align-items-center" 
                       href="#" role="button" data-bs-toggle="dropdown" 
                       aria-expanded="false">
                        <div class="user-avatar-container d-flex align-items-center">
                            <div class="avatar avatar-online me-2">
                                <img src="{{ asset('assets/img/avatars/1.png') }}" 
                                     alt="User Avatar" class="w-px-40 h-auto rounded-circle shadow">
                            </div>
                            <div class="user-info d-none d-xl-block text-start">
                                <span class="fw-semibold user-name d-block">{{ Auth::user()->name }}</span>
                                <small class="user-role text-white-50">Administrator</small>
                            </div>
                            <i class="mdi mdi-chevron-down dropdown-arrow ms-1 text-white"></i>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end user-menu p-0">
                        <li class="user-header p-4 text-center bg-gradient">
                            <div class="avatar-container mb-3">
                                <img src="{{ asset('assets/img/avatars/1.png') }}" 
                                     alt="User Avatar" class="avatar-large rounded-circle shadow">
                            </div>
                            <div class="user-details text-dark">
                                <h6 class="mb-1">{{ Auth::user()->name }}</h6>
                                <small class="opacity-75">Administrator System</small>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center py-2 px-3" href="javascript:void(0);">
                                <i class="mdi mdi-account-outline me-2 text-primary"></i>
                                <span>Profil Saya</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center py-2 px-3" href="javascript:void(0);">
                                <i class="mdi mdi-email-outline me-2 text-primary"></i>
                                <span class="flex-grow-1">Pesan</span>
                                <span class="badge bg-primary rounded-pill">5</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center py-2 px-3" href="javascript:void(0);">
                                <i class="mdi mdi-cog-outline me-2 text-primary"></i>
                                <span>Pengaturan</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider my-2"></li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center py-2 px-3" href="javascript:void(0);">
                                <i class="mdi mdi-lifebuoy me-2 text-primary"></i>
                                <span>Bantuan & Support</span>
                            </a>
                        </li>
                        <li class="logout-section">
                            <a class="dropdown-item d-flex align-items-center py-2 px-3 logout-btn" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-power me-2 text-danger"></i>
                                <span>Keluar</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>

<style>
/* Navbar Modern Styles */
.layout-navbar {
    background: linear-gradient(135deg, #667eea 0%, #667eea 100%) !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    padding: 0.5rem 0;
    border: none;
    backdrop-filter: blur(10px);
}

/* Brand Logo */
.logo-container {
    display: flex;
    align-items: center;
    transition: transform 0.3s ease;
}

.logo-container:hover {
    transform: scale(1.05);
}

.logo-icon {
    width: 40px;
    height: 40px;
    background: rgba(255,255,255,0.2);
    transition: all 0.3s ease;
}

.logo-container:hover .logo-icon {
    transform: rotate(15deg);
    box-shadow: 0 4px 15px rgba(255,255,255,0.3);
}

.brand-text {
    font-size: 1.25rem;
    letter-spacing: 0.5px;
}

/* Toggle Button Modern */
.custom-toggler {
    border: none;
    background: transparent;
    padding: 8px;
    width: 40px;
    height: 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    gap: 4px;
}

.toggler-icon {
    width: 25px;
    height: 3px;
    background: white;
    border-radius: 2px;
    transition: all 0.3s ease;
}

.custom-toggler[aria-expanded="true"] .toggler-icon:nth-child(1) {
    transform: rotate(45deg) translate(6px, 6px);
}

.custom-toggler[aria-expanded="true"] .toggler-icon:nth-child(2) {
    opacity: 0;
}

.custom-toggler[aria-expanded="true"] .toggler-icon:nth-child(3) {
    transform: rotate(-45deg) translate(6px, -6px);
}

/* Search Bar Modern */
.search-container {
    position: relative;
    margin-left: 2rem;
}

.search-icon {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #6c757d;
    z-index: 2;
}

.search-input {
    width: 300px;
    padding: 10px 40px 10px 40px;
    border: none;
    border-radius: 25px;
    background: rgba(255,255,255,0.9);
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    font-size: 0.9rem;
}

.search-input:focus {
    width: 350px;
    background: white;
    box-shadow: 0 4px 15px rgba(0,0,0,0.15);
    outline: none;
}

.search-actions {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
}

.btn-search-clear {
    background: none;
    border: none;
    color: #6c757d;
    padding: 4px;
    border-radius: 50%;
    transition: all 0.3s ease;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.btn-search-clear:hover {
    background: #f8f9fa;
    color: #495057;
}

/* Quick Actions */
.quick-actions .btn {
    font-size: 0.85rem;
    font-weight: 500;
    transition: all 0.3s ease;
}

.quick-actions .btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

/* Notification Dropdown */
.notification-icon {
    position: relative;
    color: white;
    transition: all 0.3s ease;
    padding: 8px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.notification-icon:hover {
    background: rgba(255,255,255,0.1);
}

.notification-badge {
    position: absolute;
    top: 0;
    right: 0;
    background: #ff4757;
    color: white;
    border-radius: 50%;
    width: 18px;
    height: 18px;
    font-size: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: pulse 2s infinite;
    border: 2px solid #667eea;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.notification-menu {
    width: 380px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    border-radius: 12px;
    overflow: hidden;
}

.notification-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
}

.notification-item {
    transition: background 0.3s ease;
    text-decoration: none;
    color: inherit;
}

.notification-item:hover {
    background: #f8f9fa;
}

.notification-icon.bg-success,
.notification-icon.bg-warning,
.notification-icon.bg-info {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

/* Settings Menu */
.settings-icon {
    padding: 8px;
    border-radius: 50%;
    transition: all 0.3s ease;
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
}

.settings-icon:hover {
    background: rgba(255,255,255,0.1);
}

.settings-menu {
    width: 280px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    border-radius: 12px;
}

.settings-header {
    background: #f8f9fa;
}

.setting-item {
    transition: background 0.3s ease;
}

/* User Dropdown Modern */
.user-profile {
    padding: 4px 8px;
    border-radius: 25px;
    transition: all 0.3s ease;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
    margin-left: 0.5rem;
}

.user-profile:hover {
    background: rgba(255,255,255,0.2);
}

.user-avatar-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.user-info .user-name {
    color: white;
    font-weight: 600;
    font-size: 0.9rem;
}

.user-info .user-role {
    color: rgba(255,255,255,0.8);
    font-size: 0.75rem;
}

.dropdown-arrow {
    color: white;
    transition: transform 0.3s ease;
    font-size: 1.2rem;
}

.user-dropdown.show .dropdown-arrow {
    transform: rotate(180deg);
}

.user-menu {
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    border-radius: 12px;
    overflow: hidden;
    width: 280px;
}

.user-header {
    background: linear-gradient(135deg, #667eea, #764ba2);
    margin-bottom: 0;
}

.avatar-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid white;
}

.user-details h6 {
    margin: 0;
    font-weight: 600;
}

.user-details small {
    opacity: 0.8;
}

.user-menu .dropdown-item {
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
}

.user-menu .dropdown-item:hover {
    background: #f8f9fa;
    padding-left: 1.25rem;
}

.logout-section {
    margin-top: 0.5rem;
}

.logout-btn {
    color: #dc3545 !important;
    font-weight: 500;
}

.logout-btn:hover {
    background: #ffe6e6 !important;
}

/* Animation for dropdowns */
.dropdown-menu {
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 1200px) {
    .search-input {
        width: 250px;
    }
    
    .search-input:focus {
        width: 280px;
    }
}

@media (max-width: 992px) {
    .quick-actions {
        display: none !important;
    }
    
    .search-container {
        margin-left: 0;
        margin-bottom: 1rem;
        width: 100%;
    }
    
    .search-input {
        width: 100%;
    }
    
    .search-input:focus {
        width: 100%;
    }
}

@media (max-width: 768px) {
    .notification-menu {
        width: 320px;
        right: -50px !important;
    }
    
    .settings-menu {
        width: 260px;
        right: -30px !important;
    }
    
    .user-menu {
        width: 260px;
        right: -10px !important;
    }
    
    .navbar-nav.ms-auto {
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid rgba(255,255,255,0.1);
    }
}

/* Dark mode styles */
body.dark-mode {
    background-color: #1a1a1a;
    color: #f8f9fa;
}

body.dark-mode .search-input {
    background: rgba(50, 50, 50, 0.9);
    color: #f8f9fa;
}

body.dark-mode .search-input:focus {
    background: #2d2d2d;
}

body.dark-mode .notification-menu,
body.dark-mode .settings-menu,
body.dark-mode .user-menu {
    background: #2d2d2d;
    color: #f8f9fa;
}

body.dark-mode .notification-item:hover,
body.dark-mode .user-menu .dropdown-item:hover {
    background: #3d3d3d;
}

body.dark-mode .settings-header {
    background: #3d3d3d;
    color: #f8f9fa;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Search functionality
    const searchInput = document.querySelector('.search-input');
    const searchClear = document.querySelector('.btn-search-clear');
    
    if (searchClear) {
        searchClear.addEventListener('click', function() {
            searchInput.value = '';
            searchInput.focus();
        });
    }
    
    // Dark mode toggle
    const darkModeSwitch = document.getElementById('darkModeSwitch');
    if (darkModeSwitch) {
        darkModeSwitch.addEventListener('change', function() {
            document.body.classList.toggle('dark-mode');
            // Save preference to localStorage
            localStorage.setItem('darkMode', this.checked);
        });
        
        // Load dark mode preference
        if (localStorage.getItem('darkMode') === 'true') {
            darkModeSwitch.checked = true;
            document.body.classList.add('dark-mode');
        }
    }
    
    // Notification mark as read
    const notificationItems = document.querySelectorAll('.notification-item');
    notificationItems.forEach(item => {
        item.addEventListener('click', function() {
            const badge = document.querySelector('.notification-badge');
            if (badge) {
                let count = parseInt(badge.textContent);
                if (count > 1) {
                    badge.textContent = count - 1;
                } else {
                    badge.style.display = 'none';
                }
            }
        });
    });
    
    // Smooth animations for dropdowns
    const dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('show.bs.dropdown', function() {
            const menu = this.querySelector('.dropdown-menu');
            menu.style.opacity = '0';
            menu.style.transform = 'translateY(-10px)';
            
            setTimeout(() => {
                menu.style.opacity = '1';
                menu.style.transform = 'translateY(0)';
                menu.style.transition = 'all 0.3s ease';
            }, 10);
        });
    });
    
    // Add keyboard navigation for search
    if (searchInput) {
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                this.value = '';
                this.blur();
            }
        });
    }
});
</script>