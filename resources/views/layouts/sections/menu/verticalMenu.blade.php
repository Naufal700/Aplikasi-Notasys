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

<div class="card shadow-sm border-0 h-100">
  <aside id="layout-menu" class="layout-menu menu-vertical bg-white shadow-sm border-0 h-100">
  <!-- App Brand -->
  <div class="app-brand demo p-3 d-flex align-items-center justify-content-between">
    <a href="{{ url('/') }}" class="app-brand-link">
      <span class="logo-text" style="
        font-size: 22px;
        font-weight: 700;
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(90deg, #9055FD, #4CAF50);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
      ">
        NotaSys
      </span>
    </a>

    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
      <i class="mdi menu-toggle-icon d-xl-block align-middle mdi-20px"></i>
    </a>
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
    document.querySelectorAll('#layout-menu .menu-toggle').forEach(toggle => {
      toggle.addEventListener('click', function(e) {
        e.preventDefault();
        const parent = this.closest('.menu-item');
        parent.classList.toggle('open');
      });
    });
  });
</script>

<style>
  #layout-menu .menu-sub {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.35s ease;
  }
  #layout-menu .menu-item.open > .menu-sub {
    max-height: 1000px; /* expand untuk submenu panjang */
  }

  #layout-menu .menu-link {
    color: #6c757d !important;
    font-weight: 500;
  }
  #layout-menu .menu-link:hover {
    color: #495057 !important;
  }
  #layout-menu .menu-item.active > .menu-link {
    font-weight: 600;
    color: #212529 !important;
  }
</style>
