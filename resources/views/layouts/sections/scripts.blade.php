<!-- jQuery -->
<script src="{{ asset(mix('assets/vendor/libs/jquery/jquery.js')) }}"></script>

<!-- Bootstrap Bundle (sudah termasuk Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Waves & Perfect Scrollbar -->
<script src="{{ asset(mix('assets/vendor/libs/node-waves/node-waves.js')) }}"></script>
<script src="{{ asset(mix('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')) }}"></script>

<!-- Menu -->
<script src="{{ asset(mix('assets/vendor/js/menu.js')) }}"></script>

@yield('vendor-script')

<!-- Theme -->
<script src="{{ asset(mix('assets/js/main.js')) }}"></script>
