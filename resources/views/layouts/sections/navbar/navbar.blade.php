@php
$containerNav = $containerNav ?? 'container-fluid';
$navbarDetached = ($navbarDetached ?? '');
@endphp

<!-- Navbar -->
<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="{{$containerNav}}">
        
       
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
                
                <!-- Notification Bell -->
                <li class="nav-item dropdown notification-dropdown">
                    <a class="nav-link notification-icon" href="#" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-bell-outline mdi-24px"></i>
                        <span class="notification-badge">3</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end notification-menu">
                        <div class="notification-header">
                            <h6>Notifikasi</h6>
                            <span class="badge bg-primary">3 Baru</span>
                        </div>
                        <div class="notification-list">
                            <a href="#" class="notification-item">
                                <div class="notification-icon bg-success">
                                    <i class="mdi mdi-check"></i>
                                </div>
                                <div class="notification-content">
                                    <p>Pesanan baru diterima</p>
                                    <small>2 menit lalu</small>
                                </div>
                            </a>
                            <a href="#" class="notification-item">
                                <div class="notification-icon bg-warning">
                                    <i class="mdi mdi-alert"></i>
                                </div>
                                <div class="notification-content">
                                    <p>Stok hampir habis</p>
                                    <small>1 jam lalu</small>
                                </div>
                            </a>
                            <a href="#" class="notification-item">
                                <div class="notification-icon bg-info">
                                    <i class="mdi mdi-information"></i>
                                </div>
                                <div class="notification-content">
                                    <p>Laporan bulanan siap</p>
                                    <small>5 jam lalu</small>
                                </div>
                            </a>
                        </div>
                        <div class="notification-footer">
                            <a href="#" class="text-primary">Lihat Semua</a>
                        </div>
                    </div>
                </li>

                <!-- Quick Settings -->
                <li class="nav-item dropdown quick-settings">
                    <a class="nav-link settings-icon" href="#" role="button" 
                       data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="mdi mdi-cog-outline mdi-24px"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end settings-menu">
                        <div class="settings-header">
                            <h6>Pengaturan Cepat</h6>
                        </div>
                        <div class="settings-content">
                            <div class="setting-item">
                                <label class="form-check-label">Mode Gelap</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" id="darkModeSwitch">
                                </div>
                            </div>
                            <div class="setting-item">
                                <label class="form-check-label">Notifikasi</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" checked id="notificationSwitch">
                                </div>
                            </div>
                        </div>
                    </div>
                </li>

                <!-- User Profile dengan gradient -->
                <li class="nav-item dropdown user-dropdown">
                    <a class="nav-link dropdown-toggle user-profile" 
                       href="#" role="button" data-bs-toggle="dropdown" 
                       aria-expanded="false">
                        <div class="user-avatar-container">
                            <div class="avatar avatar-online me-2">
                                <img src="{{ asset('assets/img/avatars/1.png') }}" 
                                     alt="User Avatar" class="w-px-40 h-auto rounded-circle shadow">
                            </div>
                            <div class="user-info d-none d-xl-block">
                                <span class="fw-semibold user-name">{{ Auth::user()->name }}</span>
                                <small class="user-role">Administrator</small>
                            </div>
                            {{-- <i class="mdi mdi-chevron-down dropdown-arrow"></i> --}}
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end user-menu">
                        <li class="user-header">
                            <div class="avatar-container">
                                <img src="{{ asset('assets/img/avatars/1.png') }}" 
                                     alt="User Avatar" class="avatar-large">
                            </div>
                            <div class="user-details">
                                <h6>{{ Auth::user()->name }}</h6>
                                <small>Administrator System</small>
                            </div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i class="mdi mdi-account-outline me-2"></i>
                                <span>Profil Saya</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i class="mdi mdi-email-outline me-2"></i>
                                <span>Pesan</span>
                                <span class="badge bg-primary ms-2">5</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i class="mdi mdi-cog-outline me-2"></i>
                                <span>Pengaturan</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="javascript:void(0);">
                                <i class="mdi mdi-lifebuoy me-2"></i>
                                <span>Bantuan & Support</span>
                            </a>
                        </li>
                        <li class="logout-section">
                            <a class="dropdown-item logout-btn" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-power me-2"></i>
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
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    padding: 0.5rem 0;
    border: none;
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
    transition: all 0.3s ease;
    background: linear-gradient(45deg, #ffffff, #f8f9fa) !important;
}

.logo-container:hover .logo-icon {
    transform: rotate(15deg);
    box-shadow: 0 4px 15px rgba(255,255,255,0.3);
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
}

.btn-search-clear:hover {
    background: #f8f9fa;
    color: #495057;
}

/* Notification Dropdown */
.notification-icon {
    position: relative;
    margin-right: 1rem;
    color: white;
    transition: all 0.3s ease;
}

.notification-badge {
    position: absolute;
    top: -5px;
    right: -5px;
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
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); }
}

.notification-menu {
    width: 350px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    border-radius: 15px;
    overflow: hidden;
}

.notification-header {
    padding: 1rem;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.notification-item {
    display: flex;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid #f1f3f4;
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
    margin-right: 1rem;
    color: white;
}

/* User Dropdown Modern */
.user-profile {
    padding: 0.5rem;
    border-radius: 20px;
    transition: all 0.3s ease;
    background: rgba(255,255,255,0.1);
    backdrop-filter: blur(10px);
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
}

.user-info .user-role {
    color: rgba(255,255,255,0.8);
    font-size: 0.8rem;
}

.dropdown-arrow {
    color: white;
    transition: transform 0.3s ease;
}

.user-dropdown.show .dropdown-arrow {
    transform: rotate(180deg);
}

.user-menu {
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    border-radius: 15px;
    overflow: hidden;
    width: 280px;
}

.user-header {
    padding: 2rem 1rem 1rem;
    text-align: center;
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    margin-bottom: 0.5rem;
}

.avatar-large {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 3px solid white;
    margin-bottom: 1rem;
}

.user-details h6 {
    margin: 0;
    font-weight: 600;
}

.user-details small {
    opacity: 0.8;
}

.user-menu .dropdown-item {
    padding: 0.75rem 1rem;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
}

.user-menu .dropdown-item:hover {
    background: #f8f9fa;
    padding-left: 1.5rem;
}

.logout-section {
    margin-top: 0.5rem;
}

.logout-btn {
    color: #dc3545 !important;
    font-weight: 600;
}

.logout-btn:hover {
    background: #ffe6e6 !important;
}

/* Settings Menu */
.settings-menu {
    width: 250px;
    border: none;
    box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    border-radius: 15px;
}

.settings-header {
    padding: 1rem;
    background: #f8f9fa;
    border-bottom: 1px solid #e9ecef;
}

.setting-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1rem;
    border-bottom: 1px solid #f1f3f4;
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

@media (max-width: 768px) {
    .search-container {
        margin-left: 0;
        margin-bottom: 1rem;
    }
    
    .search-input {
        width: 100%;
    }
    
    .search-input:focus {
        width: 100%;
    }
    
    .notification-menu {
        width: 300px;
        right: -50px !important;
    }
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
});
</script>