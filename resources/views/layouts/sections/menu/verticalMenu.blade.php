@php
  if (!function_exists('isMenuActive')) {
      function isMenuActive($item, $currentRouteName) {
          // Match exact slug
          if (!empty($item->slug) && $currentRouteName === $item->slug) {
              return true;
          }

          // Slug bisa array
          if (is_array($item->slug)) {
              foreach ($item->slug as $slug) {
                  if (str_starts_with($currentRouteName, $slug)) {
                      return true;
                  }
              }
          } elseif (!empty($item->slug) && str_starts_with($currentRouteName, $item->slug)) {
              return true;
          }

          // Recursive cek anak-anak
          if (isset($item->submenu)) {
              foreach ($item->submenu as $child) {
                  if (isMenuActive($child, $currentRouteName)) {
                      return true;
                  }
              }
          }

          return false;
      }
  }

  $currentRouteName = Route::currentRouteName();
@endphp

<style>
  /* Scrollbar untuk menu */
  #layout-menu .menu-inner {
    overflow-y: auto;
    max-height: calc(100vh - 120px);
    scrollbar-width: thin;
    scrollbar-color: #c1c1c1 transparent;
  }
  
  #layout-menu .menu-inner::-webkit-scrollbar {
    width: 6px;
  }
  
  #layout-menu .menu-inner::-webkit-scrollbar-track {
    background: transparent;
    border-radius: 10px;
  }
  
  #layout-menu .menu-inner::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
  }
  
  #layout-menu .menu-inner::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
  }
  
  /* Header brand yang lebih menarik - tanpa background */
  #layout-menu .app-brand {
    background: transparent;
    border-radius: 12px 12px 0 0;
    margin: 8px 8px 0 8px;
    padding: 1.25rem 1rem;
  }
  
  /* Logo text dengan gradien dan animasi yang lebih menarik */
#layout-menu .logo-text {
    font-size: 24px;
    font-weight: 800;
    background: linear-gradient(135deg, #6B21A8 0%, #8B5CF6 50%, #C4B5FD 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    display: inline-block;
    letter-spacing: 0.5px;
    animation: textShimmer 4s ease-in-out infinite alternate;
    background-size: 200% 200%;
}

/* Shimmer animasi lembut */
@keyframes textShimmer {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
  
  @keyframes textShimmer {
    0% {
      background-position: 0% 50%;
      text-shadow: 0 0 5px rgba(144, 85, 253, 0.3);
    }
    50% {
      background-position: 100% 50%;
      text-shadow: 0 0 15px rgba(76, 175, 80, 0.4);
    }
    100% {
      background-position: 0% 50%;
      text-shadow: 0 0 10px rgba(255, 107, 107, 0.3);
    }
  }
  
  /* Efek hover pada logo text */
  #layout-menu .logo-text:hover {
    animation: textShimmerHover 1.5s ease-in-out infinite alternate;
  }
  
  @keyframes textShimmerHover {
    0% {
      background-position: 0% 50%;
      transform: scale(1.02);
    }
    100% {
      background-position: 100% 50%;
      transform: scale(1.05);
    }
  }
  
  #layout-menu .layout-menu-toggle {
    color: #6c757d;
    font-size: 1.2rem;
    transition: transform 0.3s ease;
  }
  
  #layout-menu .layout-menu-toggle:hover {
    transform: scale(1.1);
    color: #9055FD;
  }
  
  /* Menu item yang lebih menarik */
  #layout-menu .menu-item {
    margin: 0 8px 4px 8px;
    border-radius: 8px;
    transition: all 0.3s ease;
    overflow: hidden;
  }
  
  #layout-menu .menu-item:hover {
    background-color: #f8f9fa;
  }
  
  #layout-menu .menu-item.active {
    background-color: #eef9ff;
    border-left: 4px solid #9055FD;
  }
  
  #layout-menu .menu-item.open {
    background-color: #f8f9fa;
  }
  
  #layout-menu .menu-link {
    padding: 0.75rem 1rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    display: flex;
    align-items: center;
    position: relative;
  }
  
  #layout-menu .menu-link:hover {
    color: #9055FD !important;
    transform: translateX(4px);
  }
  
  #layout-menu .menu-item.active > .menu-link {
    color: #9055FD !important;
    font-weight: 600;
    background-color: rgba(144, 85, 253, 0.05);
  }
  
  #layout-menu .menu-link i {
    margin-right: 0.75rem;
    font-size: 1.1rem;
    width: 20px;
    text-align: center;
    transition: transform 0.3s ease;
  }
  
  #layout-menu .menu-link:hover i {
    transform: scale(1.1);
  }
  
  #layout-menu .menu-link .badge {
    font-size: 0.7rem;
    padding: 0.25rem 0.5rem;
    animation: pulse 2s infinite;
  }
  
  @keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
  }
  
  /* Submenu yang lebih baik */
  #layout-menu .menu-sub {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    background-color: #f8f9fa;
    border-radius: 0 0 8px 8px;
    margin-top: -4px;
  }
  
  #layout-menu .menu-item.open > .menu-sub {
    max-height: 500px;
  }
  
  #layout-menu .menu-sub .menu-item {
    margin: 0;
    border-radius: 0;
    border-left: 3px solid transparent;
  }
  
  #layout-menu .menu-sub .menu-link {
    padding-left: 2.5rem;
    font-size: 0.9rem;
    border-radius: 0;
  }
  
  #layout-menu .menu-sub .menu-link:hover {
    border-left-color: #9055FD;
    background-color: rgba(144, 85, 253, 0.05);
  }
  
  /* Menu header yang lebih baik */
  #layout-menu .menu-header {
    padding: 1rem 1rem 0.5rem;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d;
    font-weight: 600;
    margin-top: 1rem;
  }
  
  /* Indikator menu toggle - menggunakan icon Font Awesome */
  #layout-menu .menu-toggle::after {
    content: '\f107';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    margin-left: auto;
    transition: transform 0.3s ease;
    font-size: 0.9rem;
    color: #6c757d;
  }
  
  #layout-menu .menu-item.open > .menu-link.menu-toggle::after {
    transform: rotate(180deg);
    color: #9055FD;
  }
  
  /* Shadow divider */
  #layout-menu .menu-inner-shadow {
    height: 1px;
    background: linear-gradient(90deg, transparent, rgba(0,0,0,0.1), transparent);
    margin: 0.5rem 8px;
  }
  
  /* Animasi untuk menu item */
  @keyframes fadeIn {
    from { opacity: 0; transform: translateX(-10px); }
    to { opacity: 1; transform: translateX(0); }
  }
  
  #layout-menu .menu-item {
    animation: fadeIn 0.3s ease forwards;
  }
  
  /* Card styling */
  #layout-menu .card {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  }
  
  /* Styling untuk logo container */
  .logo-container {
    display: flex;
    align-items: center;
    transition: transform 0.3s ease;
  }
  
  .logo-container:hover {
    transform: translateY(-2px);
  }
  
  .logo-icon {
    background: linear-gradient(135deg, #9055FD 0%, #244dd3 100%);
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
    box-shadow: 0 4px 10px rgba(85, 45, 159, 0.3);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  
  .logo-icon:hover {
    transform: rotate(15deg);
    box-shadow: 0 6px 15px rgba(104, 29, 243, 0.4);
  }
  
  .logo-icon i {
    color: white;
    font-size: 20px;
  }
  
  /* Efek border gradient untuk app brand */
  .app-brand::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 8px;
    right: 8px;
    height: 1px;
    background: linear-gradient(90deg, transparent, #9055FD, #003cff, #0a48e5, transparent);
    opacity: 0.5;
  }
</style>

<div class="card shadow-sm border-0 h-100">
  <aside id="layout-menu" class="layout-menu menu-vertical bg-white shadow-sm border-0 h-100">
    <!-- App Brand -->
    <div class="app-brand demo p-2 d-flex align-items-center justify-content-between position-relative">
      {{-- <a href="{{ url('/') }}" class="app-brand-link text-decoration-none"> --}}
        <div class="logo-container">
          
          <span class="logo-text">NotaSys</span>
        </div>
      {{-- </a> --}}

         </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
      @foreach ($menuData[0]->menu as $menu)
        @if (isset($menu->menuHeader))
          <li class="menu-header fw-medium mt-4">
            <span class="menu-header-text text">{{ __($menu->menuHeader) }}</span>
          </li>
        @else
          @php
            $activeClass = isMenuActive($menu, $currentRouteName) ? 'active open' : '';
          @endphp

          <li class="menu-item {{ $activeClass }}">
            <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
               class="{{ isset($menu->submenu) ? 'menu-link menu-toggle text-gray' : 'menu-link text-gray' }}"
               @if(isset($menu->target) && !empty($menu->target)) target="_blank" @endif>
              @isset($menu->icon)
                <i class="{{ $menu->icon }}"></i>
              @endisset
              <div>{{ $menu->name ?? '' }}</div>
              @isset($menu->badge)
                <div class="badge bg-{{ $menu->badge[0] }} rounded-pill ms-auto">{{ $menu->badge[1] }}</div>
              @endisset
            </a>

            @isset($menu->submenu)
              @include('layouts.sections.menu.submenu',['menu' => $menu->submenu])
            @endisset
          </li>
        @endif
      @endforeach
    </ul>
  </aside>
</div>

{{-- JS toggle submenu (multi-open allowed) --}}
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Toggle submenu
    document.querySelectorAll('#layout-menu .menu-toggle').forEach(toggle => {
      toggle.addEventListener('click', function(e) {
        e.preventDefault();
        const parent = this.closest('.menu-item');
        parent.classList.toggle('open');
      });
    });
    
    // Animasi untuk menu item
    setTimeout(() => {
      document.querySelectorAll('#layout-menu .menu-item').forEach((item, index) => {
        item.style.animationDelay = `${index * 0.05}s`;
      });
    }, 100);
    
    // Efek hover khusus untuk logo text
    const logoText = document.querySelector('.logo-text');
    if (logoText) {
      logoText.addEventListener('mouseenter', function() {
        this.style.animation = 'textShimmerHover 1.5s ease-in-out infinite alternate';
      });
      
      logoText.addEventListener('mouseleave', function() {
        this.style.animation = 'textShimmer 3s ease-in-out infinite alternate';
      });
    }
  });
</script>