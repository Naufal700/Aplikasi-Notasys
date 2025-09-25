@php
  if (!function_exists('isSubmenuActive')) {
      function isSubmenuActive($submenu, $currentRouteName) {
          // Exact match
          if (!empty($submenu->slug) && $currentRouteName === $submenu->slug) {
              return true;
          }

          // Slug bisa array
          if (is_array($submenu->slug)) {
              foreach ($submenu->slug as $slug) {
                  if (str_starts_with($currentRouteName, $slug)) {
                      return true;
                  }
              }
          } elseif (!empty($submenu->slug) && str_starts_with($currentRouteName, $submenu->slug)) {
              return true;
          }

          // Recursive cek anak-anak
          if (isset($submenu->submenu)) {
              foreach ($submenu->submenu as $child) {
                  if (isSubmenuActive($child, $currentRouteName)) {
                      return true;
                  }
              }
          }

          return false;
      }
  }

  $currentRouteName = Route::currentRouteName();
@endphp

<ul class="menu-sub">
  @if (isset($menu))
    @foreach ($menu as $submenu)
      @php
        $activeClass = isSubmenuActive($submenu, $currentRouteName) ? 'active open' : '';
      @endphp

      <li class="menu-item {{ $activeClass }}">
        <a href="{{ isset($submenu->url) ? url($submenu->url) : 'javascript:void(0);' }}" 
           class="{{ isset($submenu->submenu) ? 'menu-link menu-toggle text-gray' : 'menu-link text-gray' }}" 
           @if (!empty($submenu->target)) target="_blank" @endif>
          @isset($submenu->icon)
            <i class="{{ $submenu->icon }}"></i>
          @endisset
          <div>{{ $submenu->name ?? '' }}</div>

          @isset($submenu->badge)
            <div class="badge bg-{{ $submenu->badge[0] }} rounded-pill ms-auto">{{ $submenu->badge[1] }}</div>
          @endisset
        </a>

        {{-- Recursive call --}}
        @isset($submenu->submenu)
          @include('layouts.sections.menu.submenu',['menu' => $submenu->submenu])
        @endisset
      </li>
    @endforeach
  @endif
</ul>
