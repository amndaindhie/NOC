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
    href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Raleway:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet"
  />

  <!-- Vendor CSS Files -->
  <link
    href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}"
    rel="stylesheet"
  />
  <link
    href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}"
    rel="stylesheet"
  />
  <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet" />
  <link
    href="{{ asset('assets/vendor/glightbox/css/glightbox.min.css') }}"
    rel="stylesheet"
  />
  <link href="{{ asset('assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet" />

  <!-- Main CSS File -->
  <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" />

  <!-- =======================================================
* Template Name: Moderna
* Template URL: https://bootstrapmade.com/free-bootstrap-template-corporate-moderna/
* Updated: Aug 07 2024 with Bootstrap v5.3.3
* Author: BootstrapMade.com
* License: https://bootstrapmade.com/license/
======================================================= -->
</head>

<body class="index-page">
  @include('frontend.navbar')

  <main class="main">
    @yield('content')
  </main>

  @include('frontend.footer')

  @include('frontend.login_modal')

  @include('frontend.register_modal')

  {{-- @include('frontend.otp_verification_modal') --}}

  <!-- Scroll Top -->
  <a
    href="#"
    id="scroll-top"
    class="scroll-top d-flex align-items-center justify-content-center"
    ><i class="bi bi-arrow-up-short"></i
  ></a>

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

  <!-- Custom Registration Scripts -->
  <script type="module">
    import modalTargets from '/resources/js/modal-targets.js';

    function closeRegisterModal(callback) {
        const registerModalEl = document.querySelector(modalTargets.register);
        if (!registerModalEl) {
            if (callback) callback();
            return;
        }
        const bsRegisterModal = bootstrap.Modal.getInstance(registerModalEl);
        if (bsRegisterModal) {
            registerModalEl.addEventListener('hidden.bs.modal', () => {
                // Remove backdrop and modal-open class after modal hidden
                const backdrop = document.querySelector('.modal-backdrop');
                if (backdrop) backdrop.remove();
                document.body.classList.remove('modal-open');
                if (callback) callback();
            }, { once: true });
            bsRegisterModal.hide();
        } else {
            // If no bootstrap instance, forcibly hide modal
            registerModalEl.classList.remove('show');
            registerModalEl.style.display = 'none';
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) backdrop.remove();
            document.body.classList.remove('modal-open');
            if (callback) callback();
        }
    }

    function showOtpModal(email) {
        // Close register modal first, then show OTP modal
        closeRegisterModal(() => {
            // Set the email in the OTP modal
            const emailInput = document.getElementById('otp-email');
            if (emailInput) {
                emailInput.value = email;
            }

            // Also set in resend form
            const resendEmailInput = document.getElementById('resend-email');
            if (resendEmailInput) {
                resendEmailInput.value = email;
            }

            // Clear any previous OTP code
            const otpCodeInput = document.getElementById('otp-code');
            if (otpCodeInput) {
                otpCodeInput.value = '';
            }

            // Clear any previous messages
            const otpMessage = document.getElementById('otp-message');
            if (otpMessage) {
                otpMessage.innerHTML = '<div class="alert alert-info">Kode OTP telah dikirim ke email: <strong>' + email + '</strong></div>';
            }

            // Show the OTP modal using modalTargets
            const otpModalEl = document.querySelector(modalTargets.otp);
            if (otpModalEl) {
                const otpModal = new bootstrap.Modal(otpModalEl, {
                    backdrop: 'static', // Prevent closing by clicking backdrop
                    keyboard: false // Prevent closing by pressing escape
                });
                otpModal.show();
            }
        });
    }

    // Listen for Livewire events
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('otpModalRequested', (data) => {
            showOtpModal(data.email);
        });
    });
  </script>
</body>
</html>
