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
  /* ===== VARIABLES ===== */
  :root {
    --primary-color: #667eea;
    --sidebar-bg: #ffffff;
    --menu-item-hover: #f8f9ff;
    --menu-item-active: rgba(102, 126, 234, 0.1);
    --text-primary: #2d3748;
    --text-secondary: #718096;
    --border-color: #e2e8f0;
    --border-radius: 8px;
  }

  /* ===== SCROLLBAR ===== */
  #layout-menu .menu-inner {
    overflow-y: auto;
    max-height: calc(100vh - 140px);
  }
  
  #layout-menu .menu-inner::-webkit-scrollbar {
    width: 4px;
  }
  
  #layout-menu .menu-inner::-webkit-scrollbar-thumb {
    background: var(--border-color);
    border-radius: 10px;
  }

  /* ===== LAYOUT MENU ===== */
  #layout-menu {
    background: var(--sidebar-bg);
    border-right: 1px solid var(--border-color);
  }

  /* ===== APP BRAND ===== */
  #layout-menu .app-brand {
    background: transparent;
    padding: 1.5rem 1.25rem;
    margin: 0;
    border-bottom: 1px solid var(--border-color);
  }

  .logo-container {
    display: flex;
    align-items: center;
  }

  .logo-icon {
    background: var(--primary-color);
    width: 40px;
    height: 40px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
  }

  .logo-icon i {
    color: white;
    font-size: 20px;
  }

  .logo-text {
    font-size: 22px;
    font-weight: 700;
    color: var(--primary-color);
  }

  /* ===== MENU HEADER ===== */
  #layout-menu .menu-header {
    padding: 1.25rem 1.25rem 0.5rem;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--text-secondary);
    font-weight: 600;
    margin-top: 0.5rem;
  }

  /* ===== MENU ITEM ===== */
  #layout-menu .menu-item {
    margin: 2px 12px;
    border-radius: var(--border-radius);
    position: relative;
  }

  #layout-menu .menu-item:hover {
    background: var(--menu-item-hover);
  }

  #layout-menu .menu-item.active {
    background: var(--menu-item-active);
  }

  #layout-menu .menu-item.open {
    background: var(--menu-item-hover);
  }

  /* ===== MENU LINK ===== */
  #layout-menu .menu-link {
    padding: 0.875rem 1rem;
    border-radius: var(--border-radius);
    display: flex;
    align-items: center;
    color: var(--text-primary);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  #layout-menu .menu-link:hover {
    color: var(--primary-color);
  }

  #layout-menu .menu-item.active > .menu-link {
    color: var(--primary-color);
    font-weight: 600;
  }

  #layout-menu .menu-link i {
    margin-right: 0.875rem;
    font-size: 1.2rem;
    width: 24px;
    text-align: center;
  }

  /* ===== BADGE ===== */
  #layout-menu .menu-link .badge {
    font-size: 0.7rem;
    padding: 0.3rem 0.6rem;
    background: var(--primary-color);
    color: white;
    border-radius: 12px;
    margin-left: auto;
    font-weight: 600;
  }

  /* ===== SUBMENU - FIXED ===== */
  #layout-menu .menu-sub {
    display: none;
    background: rgba(248, 249, 255, 0.8);
    border-radius: 0 0 var(--border-radius) var(--border-radius);
    margin: 0 8px;
  }

  /* Tampilkan submenu ketika parent punya class 'open' */
  #layout-menu .menu-item.open > .menu-sub {
    display: block;
  }

  #layout-menu .menu-sub .menu-item {
    margin: 0;
  }

  #layout-menu .menu-sub .menu-link {
    padding: 0.75rem 1rem 0.75rem 2.5rem;
    font-size: 0.9rem;
    border-radius: 6px;
  }

  #layout-menu .menu-sub .menu-link:hover {
    background: rgba(102, 126, 234, 0.08);
  }

  /* ===== SUB-SUBMENU (Nested) ===== */
  #layout-menu .menu-sub .menu-sub {
    margin: 0;
    background: rgba(248, 249, 255, 0.6);
  }

  #layout-menu .menu-sub .menu-sub .menu-link {
    padding-left: 3.5rem;
    font-size: 0.85rem;
  }

  /* ===== MENU TOGGLE INDICATOR ===== */
  #layout-menu .menu-toggle::after {
    content: '\f107';
    font-family: 'Font Awesome 6 Free';
    font-weight: 900;
    margin-left: auto;
    transition: transform 0.2s ease;
    font-size: 0.85rem;
    color: var(--text-secondary);
  }

  #layout-menu .menu-item.open > .menu-link.menu-toggle::after {
    transform: rotate(180deg);
    color: var(--primary-color);
  }

  /* ===== CARD STYLING ===== */
  .card {
    border-radius: var(--border-radius);
    overflow: hidden;
    border: 1px solid var(--border-color);
    background: var(--sidebar-bg);
  }
</style>

<div class="card h-100">
  <aside id="layout-menu" class="layout-menu menu-vertical h-100">
    <!-- App Brand -->
    <div class="app-brand demo p-0">
      <div class="logo-container p-4">
        <div class="logo-icon">
          <i class="bx bx-notepad"></i>
        </div>
        <div>
          <span class="logo-text">NotaSys</span>
          <div class="text-xs text-muted mt-1">Management System</div>
        </div>
      </div>
    </div>

    <!-- Menu Navigation -->
    <ul class="menu-inner py-4">
      @foreach ($menuData[0]->menu as $menu)
        @if (isset($menu->menuHeader))
          <li class="menu-header">
            <span class="menu-header-text">{{ __($menu->menuHeader) }}</span>
          </li>
        @else
          @php
            $activeClass = isMenuActive($menu, $currentRouteName) ? 'active' : '';
            $openClass = isMenuActive($menu, $currentRouteName) ? 'open' : '';
          @endphp

          <li class="menu-item {{ $activeClass }} {{ $openClass }}">
            <a href="{{ isset($menu->url) ? url($menu->url) : 'javascript:void(0);' }}"
               class="{{ isset($menu->submenu) ? 'menu-link menu-toggle' : 'menu-link' }}"
               @if(isset($menu->target) && !empty($menu->target)) target="_blank" @endif>
              @isset($menu->icon)
                <i class="{{ $menu->icon }}"></i>
              @endisset
              <div>{{ $menu->name ?? '' }}</div>
              @isset($menu->badge)
                <div class="badge">{{ $menu->badge[1] }}</div>
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

<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Simple toggle submenu - FIXED untuk nested menus
    document.querySelectorAll('#layout-menu .menu-toggle').forEach(toggle => {
      toggle.addEventListener('click', function(e) {
        // Jika menu punya submenu, toggle class 'open'
        if (this.classList.contains('menu-toggle')) {
          e.preventDefault();
          e.stopPropagation(); // Penting: stop event bubbling
          
          const parent = this.closest('.menu-item');
          const isOpen = parent.classList.contains('open');
          
          // Hanya close menu di level yang sama (siblings)
          const siblings = Array.from(parent.parentElement.children).filter(child => 
            child !== parent && child.classList.contains('menu-item')
          );
          
          siblings.forEach(sibling => {
            sibling.classList.remove('open');
          });
          
          // Toggle current menu
          parent.classList.toggle('open');
        }
      });
    });

    // Close submenu ketika klik di luar - FIXED untuk nested menus
    document.addEventListener('click', function(e) {
      // Cek jika klik di luar menu utama
      if (!e.target.closest('#layout-menu')) {
        document.querySelectorAll('#layout-menu .menu-item.open').forEach(item => {
          item.classList.remove('open');
        });
      } else {
        // Jika klik di dalam menu, cek apakah klik di element yang bukan menu-toggle
        const clickedElement = e.target;
        const isMenuToggle = clickedElement.closest('.menu-toggle');
        
        if (!isMenuToggle) {
          // Cari semua menu item yang open dan cek apakah mereka mengandung element yang diklik
          document.querySelectorAll('#layout-menu .menu-item.open').forEach(item => {
            if (!item.contains(clickedElement)) {
              item.classList.remove('open');
            }
          });
        }
      }
    });

    // Handle escape key untuk close semua submenus
    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') {
        document.querySelectorAll('#layout-menu .menu-item.open').forEach(item => {
          item.classList.remove('open');
        });
      }
    });
  });
</script>