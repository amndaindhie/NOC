<!-- OTP Verification Modal -->
<div class="modal fade" id="otpVerificationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <div class="modal-header border-0">
        <h5 class="modal-title">Email Verification</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <div id="otp-message" class="mb-3"></div>

        <form id="otp-form" method="POST" action="{{ route('verification.otp.verify') }}">
          @csrf
          <input type="hidden" name="email" id="otp-email" value="{{ old('email', request('email')) }}">

          <!-- OTP Input -->
          <div class="mb-3">
            <label class="form-label">OTP Code</label>
            <input
              type="text"
              class="form-control @error('otp') is-invalid @enderror"
              name="otp"
              id="otp-code"
              placeholder="Enter 6-digit OTP code"
              maxlength="6"
              pattern="\d{6}"
              required
              autofocus
            />
            @error('otp')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">
              The OTP has been sent to your email. The code is valid for 60 minutes.
            </div>
          </div>

          <!-- Verify Button -->
          <button type="submit" class="btn btn-noc w-100 rounded-pill" id="verify-btn">
            Verify Email
          </button>
        </form>

        <!-- Resend OTP -->
        <div class="text-center mt-3">
          <form id="resend-form" method="POST" action="{{ route('verification.otp.resend') }}">
            @csrf
            <input type="hidden" name="email" id="resend-email" value="{{ old('email', request('email')) }}">
            <button type="submit" class="btn btn-link text-decoration-none" id="resend-btn">
              Resend OTP
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  const otpForm = document.getElementById('otp-form');
  const resendForm = document.getElementById('resend-form');
  const verifyBtn = document.getElementById('verify-btn');
  const resendBtn = document.getElementById('resend-btn');
  const otpMessage = document.getElementById('otp-message');

  // Handle OTP verification
  if (otpForm) {
    otpForm.addEventListener('submit', function(e) {
      e.preventDefault();

      const formData = new FormData(otpForm);
      verifyBtn.disabled = true;
      verifyBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Verifying...';

      fetch(otpForm.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          otpMessage.innerHTML = '<div class="alert alert-success">Verification successful! Redirecting to dashboard...</div>';
          setTimeout(() => {
            window.location.href = data.redirect || '{{ route("dashboard") }}';
          }, 2000);
        } else {
          otpMessage.innerHTML = '<div class="alert alert-danger">' + (data.message || 'Verification failed') + '</div>';
        }
      })
      .catch(error => {
        otpMessage.innerHTML = '<div class="alert alert-danger">An error occurred. Please try again.</div>';
      })
      .finally(() => {
        verifyBtn.disabled = false;
        verifyBtn.innerHTML = 'Verify Email';
      });
    });
  }

  // Handle resend OTP
  if (resendForm) {
    resendForm.addEventListener('submit', function(e) {
      e.preventDefault();

      const formData = new FormData(resendForm);
      resendBtn.disabled = true;
      resendBtn.innerHTML = 'Sending...';

      fetch(resendForm.action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          otpMessage.innerHTML = '<div class="alert alert-success">A new OTP has been sent to your email.</div>';
        } else {
          otpMessage.innerHTML = '<div class="alert alert-danger">' + (data.message || 'Failed to send OTP') + '</div>';
        }
      })
      .catch(error => {
        otpMessage.innerHTML = '<div class="alert alert-danger">An error occurred. Please try again.</div>';
      })
      .finally(() => {
        resendBtn.disabled = false;
        resendBtn.innerHTML = 'Resend OTP';
      });
    });
  }
});
</script>
