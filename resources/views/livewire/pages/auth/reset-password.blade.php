<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $isLoading = false;

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;
        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->isLoading = true;

        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));
            $this->isLoading = false;
            return;
        }

        Session::flash('status', 'Your password has been successfully reset. Please log in with your new password.');

        $this->redirectRoute('home', navigate: true);
    }

    /**
     * Check if password meets requirements
     */
    public function getPasswordStrength(): string
    {
        if (empty($this->password)) return '';

        $length = strlen($this->password);
        $hasUpper = preg_match('/[A-Z]/', $this->password);
        $hasLower = preg_match('/[a-z]/', $this->password);
        $hasNumber = preg_match('/[0-9]/', $this->password);
        $hasSpecial = preg_match('/[^A-Za-z0-9]/', $this->password);

        $score = 0;
        if ($length >= 8) $score++;
        if ($hasUpper) $score++;
        if ($hasLower) $score++;
        if ($hasNumber) $score++;
        if ($hasSpecial) $score++;

        if ($score <= 2) return 'weak';
        if ($score <= 3) return 'medium';
        return 'strong';
    }
}; ?>

<div>
    @section('content')
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-xl-5 col-lg-6 col-md-7 col-sm-8">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-gradient-success text-white text-center py-4">
                        <div class="mb-3">
                            <i class="bi bi-shield-lock-fill" style="font-size: 3rem;"></i>
                        </div>
                        <h3 class="mb-0 fw-bold">{{ __('Reset Password') }}</h3>
                        <p class="mb-0 opacity-75">Create a new password for your account</p>
                    </div>

                    <div class="card-body p-4">
                        <!-- Success Message -->
                        @if (session('status'))
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <div>{{ session('status') }}</div>
                            </div>
                        @endif

                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div>
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}<br>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <form wire:submit="resetPassword" class="user">
                            <!-- Email Address (Read-only) -->
                            <div class="form-group mb-4">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope-at me-2"></i>{{ __('Alamat Email') }}
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-envelope text-muted"></i>
                                    </span>
                                    <input
                                        wire:model="email"
                                        type="email"
                                        class="form-control form-control-lg border-start-0"
                                        id="email"
                                        name="email"
                                        readonly
                                        style="background-color: #f8f9fa;"
                                    >
                                </div>
                            </div>

                            <!-- New Password -->
                            <div class="form-group mb-4">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="bi bi-key me-2"></i>{{ __('Password Baru') }}
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input
                                        wire:model="password"
                                        type="password"
                                        class="form-control form-control-lg border-start-0 @error('password') is-invalid @enderror"
                                        id="password"
                                        name="password"
                                        placeholder="Masukkan password baru"
                                        required
                                        autocomplete="new-password"
                                    >
                                    <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword('password')">
                                        <i class="bi bi-eye" id="password-icon"></i>
                                    </button>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password Strength Indicator -->
                                @if (!empty($password))
                                    <div class="mt-2">
                                        <small class="text-muted">Kekuatan password: </small>
                                        <small class="
                                            @if($this->getPasswordStrength() === 'weak') text-danger
                                            @elseif($this->getPasswordStrength() === 'medium') text-warning
                                            @else text-success
                                            @endif
                                            fw-semibold
                                        ">
                                            @if($this->getPasswordStrength() === 'weak') Lemah
                                            @elseif($this->getPasswordStrength() === 'medium') Sedang
                                            @else Kuat
                                            @endif
                                        </small>
                                        <div class="progress mt-1" style="height: 4px;">
                                            <div class="progress-bar
                                                @if($this->getPasswordStrength() === 'weak') bg-danger
                                                @elseif($this->getPasswordStrength() === 'medium') bg-warning
                                                @else bg-success
                                                @endif
                                            " role="progressbar"
                                            style="width:
                                                @if($this->getPasswordStrength() === 'weak') 33%
                                                @elseif($this->getPasswordStrength() === 'medium') 66%
                                                @else 100%
                                                @endif
                                            "></div>
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Confirm Password -->
                            <div class="form-group mb-4">
                                <label for="password_confirmation" class="form-label fw-semibold">
                                    <i class="bi bi-key me-2"></i>{{ __('Konfirmasi Password') }}
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0">
                                        <i class="bi bi-lock text-muted"></i>
                                    </span>
                                    <input
                                        wire:model="password_confirmation"
                                        type="password"
                                        class="form-control form-control-lg border-start-0 @error('password_confirmation') is-invalid @enderror"
                                        id="password_confirmation"
                                        name="password_confirmation"
                                        placeholder="Konfirmasi password baru"
                                        required
                                        autocomplete="new-password"
                                    >
                                    <button class="btn btn-outline-secondary border-start-0" type="button" onclick="togglePassword('password_confirmation')">
                                        <i class="bi bi-eye" id="password_confirmation-icon"></i>
                                    </button>
                                    @error('password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="d-grid mb-4">
                                <button
                                    type="submit"
                                    class="btn btn-success btn-lg"
                                    wire:loading.attr="disabled"
                                    wire:loading.class="btn-secondary"
                                >
                                    <span wire:loading.remove wire:target="resetPassword">
                                        <i class="bi bi-check-circle me-2"></i>{{ __('Reset Password') }}
                                    </span>
                                    <span wire:loading wire:target="resetPassword">
                                        <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                                        Mereset Password...
                                    </span>
                                </button>
                            </div>
                        </form>

                        <div class="text-center">
                            <p class="mb-0">
                                <i class="bi bi-arrow-left me-1"></i>
                                <a href="{{ route('home') }}" class="text-decoration-none">
                                    Kembali ke Beranda
                                </a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Password Requirements -->
                <div class="card mt-3 border-0 bg-light">
                    <div class="card-body py-3">
                        <small class="text-muted">
                            <i class="bi bi-info-circle me-1"></i>
                            <strong>Persyaratan Password:</strong><br>
                            • Minimal 8 karakter<br>
                            • Mengandung huruf besar dan kecil<br>
                            • Mengandung angka<br>
                            • Mengandung simbol
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
</div>

<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');

    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>
