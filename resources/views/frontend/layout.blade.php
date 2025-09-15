<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>@yield('title', 'Network Operation Center - KITB')</title>
  <meta name="description" content="@yield('description', '')" />
  <meta name="keywords" content="@yield('keywords', '')" />
  <meta name="csrf-token" content="{{ csrf_token() }}" />

  <!-- Favicons -->
  <link href="{{ asset('assets/img/logo-KITB-1.png') }}" rel="icon" />
  <link href="{{ asset('assets/img/logo-KITB-1.png') }}" rel="apple-touch-icon" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect" />
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&family=Poppins:wght@400;600;700&display=swap"
    rel="stylesheet"
  />

  <!-- Vendor CSS Files -->
  <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet" />
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet" />

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" />
</head>

<body class="@yield('body_class', 'index-page')">
  @if(!isset($hide_navbar) || !$hide_navbar)
    @include('frontend.navbar')
  @endif

  <main class="main">
    @yield('content')
  </main>

  @if(!isset($hide_footer) || !$hide_footer)
    @include('frontend.footer')
  @endif

  {{-- Modals --}}
  @include('frontend.login_modal')
  @include('frontend.register_modal')
  @include('frontend.otp_verification_modal')

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Preloader -->
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/php-email-form/validate.js') }}"></script>
  <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
  <script src="{{ asset('assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
  <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
  <script src="{{ asset('assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
  <script src="{{ asset('assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>

  <!-- Main JS File -->
  <script src="{{ asset('assets/js/main.js') }}"></script>

  <!-- Custom Scripts -->
  <script>
    // OTP Modal
    function showOtpModal(email) {
        const emailInput = document.getElementById('otp-email');
        if (emailInput) emailInput.value = email;
        const otpModal = new bootstrap.Modal(document.getElementById('otpVerificationModal'));
        otpModal.show();
    }

    document.addEventListener('livewire:initialized', () => {
        Livewire.on('otpModalRequested', (data) => showOtpModal(data.email));
        Livewire.on('closeRegisterModal', () => {
            const registerModalEl = document.getElementById('registerModal');
            const registerModal = bootstrap.Modal.getInstance(registerModalEl);
            if (registerModal) registerModal.hide();
        });
    });

    // Modal handling
    document.addEventListener('DOMContentLoaded', function() {
        const loginModalEl = document.getElementById('loginModal');
        const registerModalEl = document.getElementById('registerModal');

        if (loginModalEl) {
            loginModalEl.addEventListener('shown.bs.modal', () => {
                loginModalEl.querySelector('input, select, textarea, button')?.focus();
            });
        }
        if (registerModalEl) {
            registerModalEl.addEventListener('shown.bs.modal', () => {
                registerModalEl.querySelector('input, select, textarea, button')?.focus();
            });
        }

        // Handle switch between login & register
        document.querySelectorAll('[data-switch-to-register]').forEach(el => {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                const loginModal = bootstrap.Modal.getInstance(loginModalEl);
                if (loginModal) loginModal.hide();
                const regModal = new bootstrap.Modal(registerModalEl);
                regModal.show();
            });
        });

        document.querySelectorAll('[data-switch-to-login]').forEach(el => {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                const registerModal = bootstrap.Modal.getInstance(registerModalEl);
                if (registerModal) registerModal.hide();
                const logModal = new bootstrap.Modal(loginModalEl);
                logModal.show();
            });
        });
    });

    // Check auth for service forms
    function checkAuth() {
        const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
        if (!isAuthenticated) {
            const registerModal = new bootstrap.Modal(document.getElementById('registerModal'));
            registerModal.show();
            return false;
        }
        return true;
    }
  </script>
</body>
</html>
