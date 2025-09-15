<!-- OTP Verification Modal -->
<div class="modal fade" id="otpVerificationModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <div class="modal-header border-0">
        <h5 class="modal-title">Verifikasi Email</h5>
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
          <input type="hidden" name="email" id="otp-email" value="">

          <!-- OTP Input -->
          <div class="mb-3">
            <label class="form-label">Kode OTP</label>
            <input
              type="text"
              class="form-control @error('otp') is-invalid @enderror"
              name="otp"
              id="otp-code"
              placeholder="Masukkan 6 digit kode OTP"
              maxlength="6"
              pattern="\d{6}"
              required
              autofocus
            />
            @error('otp')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
            <div class="form-text">
              Kode OTP telah dikirim ke email Anda. Kode berlaku selama 60 menit.
            </div>
          </div>

          <!-- Verify Button -->
          <button type="submit" class="btn btn-noc w-100 rounded-pill" id="verify-btn">
            Verifikasi Email
          </button>
        </form>

        <!-- Resend OTP -->
        <div class="text-center mt-3">
          <form id="resend-form" method="POST" action="{{ route('verification.otp.resend') }}">
            @csrf
            <input type="hidden" name="email" id="resend-email" value="">
            <button type="submit" class="btn btn-link text-decoration-none" id="resend-btn">
              Kirim Ulang OTP
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
    otpForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(otpForm);
        verifyBtn.disabled = true;
        verifyBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Memverifikasi...';

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
                otpMessage.innerHTML = '<div class="alert alert-success">Verifikasi berhasil! Mengalihkan ke dashboard...</div>';
                setTimeout(() => {
                    window.location.href = data.redirect || '{{ route("dashboard") }}';
                }, 2000);
            } else {
                otpMessage.innerHTML = '<div class="alert alert-danger">' + (data.message || 'Verifikasi gagal') + '</div>';
            }
        })
        .catch(error => {
            otpMessage.innerHTML = '<div class="alert alert-danger">Terjadi kesalahan. Silakan coba lagi.</div>';
        })
        .finally(() => {
            verifyBtn.disabled = false;
            verifyBtn.innerHTML = 'Verifikasi Email';
        });
    });

    // Handle resend OTP
    resendForm.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(resendForm);
        resendBtn.disabled = true;
        resendBtn.innerHTML = 'Mengirim...';

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
                otpMessage.innerHTML = '<div class="alert alert-success">OTP baru telah dikirim ke email Anda.</div>';
            } else {
                otpMessage.innerHTML = '<div class="alert alert-danger">' + (data.message || 'Gagal mengirim OTP') + '</div>';
            }
        })
        .catch(error => {
            otpMessage.innerHTML = '<div class="alert alert-danger">Terjadi kesalahan. Silakan coba lagi.</div>';
        })
        .finally(() => {
            resendBtn.disabled = false;
            resendBtn.innerHTML = 'Kirim Ulang OTP';
        });
    });
});

// Function to show OTP modal with email
function showOtpModal(email) {
    document.getElementById('otp-email').value = email;
    document.getElementById('resend-email').value = email;
    document.getElementById('otp-code').value = '';
    document.getElementById('otp-message').innerHTML = '<div class="alert alert-info">Kode OTP telah dikirim ke email: <strong>' + email + '</strong></div>';

    const otpModal = new bootstrap.Modal(document.getElementById('otpVerificationModal'));
    otpModal.show();
}
</script>
