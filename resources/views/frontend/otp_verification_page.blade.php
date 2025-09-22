@php
    $hide_navbar = true;
    $hide_footer = true;
@endphp

@extends('frontend.layout')

@section('title', 'Verifikasi Email')

@section('content')


    <div class="container py-5 d-flex justify-content-center align-items-center min-vh-100">
        <div>
            <!-- Alert Message di atas card -->
            <div id="otp-message" class="mb-3"></div>

            <!-- OTP Form -->
            <form class="otp-Form" id="otp-form" method="POST" action="{{ route('verification.otp.verify') }}">
                @csrf
                <input type="hidden" name="email" id="otp-email" value="{{ old('email', request('email')) }}">
                <input type="hidden" name="otp" id="otp-code">

                <span class="mainHeading">Masukkan OTP</span>
                <p class="otpSubheading">Kode OTP telah dikirim ke email Anda</p>

                <div class="inputContainer">
                    <input maxlength="1" type="text" class="otp-input" id="otp-input1" autofocus required>
                    <input maxlength="1" type="text" class="otp-input" id="otp-input2" required>
                    <input maxlength="1" type="text" class="otp-input" id="otp-input3" required>
                    <input maxlength="1" type="text" class="otp-input" id="otp-input4" required>
                    <input maxlength="1" type="text" class="otp-input" id="otp-input5" required>
                    <input maxlength="1" type="text" class="otp-input" id="otp-input6" required>
                </div>

                <button class="verifyButton" type="submit" id="verify-btn">Verifikasi</button>
                <button class="exitBtn" type="button" onclick="window.location.href='{{ route('home') }}'">×</button>

                <p class="resendNote">
                    Tidak menerima kode?
                    <button class="resendBtn" type="button" id="resend-btn">Kirim Ulang</button>
                </p>
            </form>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const otpForm = document.getElementById('otp-form');
            const resendForm = document.getElementById('resend-form');
            const verifyBtn = document.getElementById('verify-btn');
            const resendBtn = document.getElementById('resend-btn');
            const otpMessage = document.getElementById('otp-message');
            const otpInputs = document.querySelectorAll('.otp-input');

            // OTP input handling
            otpInputs.forEach((input, index) => {
                input.addEventListener('input', (e) => {
                    if (e.target.value && index < otpInputs.length - 1) {
                        otpInputs[index + 1].focus();
                    }
                });
                input.addEventListener('keydown', (e) => {
                    if (e.key === 'Backspace' && !e.target.value && index > 0) {
                        otpInputs[index - 1].focus();
                    }
                });
            });

            // Handle OTP verification
            otpForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Gabung OTP
                let otpValue = '';
                otpInputs.forEach(input => otpValue += input.value);
                document.getElementById('otp-code').value = otpValue;

                const formData = new FormData(otpForm);
                verifyBtn.disabled = true;
                verifyBtn.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status"></span> Memverifikasi...';

                fetch(otpForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            otpMessage.innerHTML =
                                '<div class="alert alert-success">Verifikasi berhasil! Mengalihkan ke home...</div>';
                            setTimeout(() => window.location.href = data.redirect ||
                                '{{ route('dashboard') }}', 2000);
                        } else {
                            otpMessage.innerHTML = '<div class="alert alert-danger">' + (data.message ||
                                'Verifikasi gagal') + '</div>';
                        }
                    })
                    .catch(() => {
                        otpMessage.innerHTML =
                            '<div class="alert alert-danger">Terjadi kesalahan. Silakan coba lagi.</div>';
                    })
                    .finally(() => {
                        verifyBtn.disabled = false;
                        verifyBtn.innerHTML = 'Verifikasi';
                    });
            });

            // Handle resend OTP
            resendBtn.addEventListener('click', () => {
                const formData = new FormData(resendForm);
                resendBtn.disabled = true;
                resendBtn.innerHTML = 'Mengirim...';

                fetch(resendForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        otpMessage.innerHTML = data.success ?
                            '<div class="alert alert-success">OTP baru telah dikirim ke email Anda.</div>' :
                            '<div class="alert alert-danger">' + (data.message ||
                            'Gagal mengirim OTP') + '</div>';
                    })
                    .catch(() => {
                        otpMessage.innerHTML =
                            '<div class="alert alert-danger">Terjadi kesalahan. Silakan coba lagi.</div>';
                    })
                    .finally(() => {
                        resendBtn.disabled = false;
                        resendBtn.innerHTML = 'Kirim Ulang';
                    });
            });
        });
    </script>
@endsection
