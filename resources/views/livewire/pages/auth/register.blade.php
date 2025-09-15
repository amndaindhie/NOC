<?php

use App\Models\User;
use App\Models\EmailVerification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Mail\EmailVerificationOtp;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public ?string $successMessage = null;

    /**
     * Handle the showOtpModal event
     */
    public function showOtpModal($email): void
    {
        // This will be handled by JavaScript
        $this->dispatch('otpModalRequested', email: $email);
    }

    /**
     * Clear success message
     */
    public function clearSuccessMessage(): void
    {
        $this->successMessage = null;
    }

    /**
     * Handle registration success event
     */
    public function registrationSuccess($message): void
    {
        $this->successMessage = $message;
    }

    /**
     * Handle an incoming registration request with OTP verification.
     */
    public function register(): void
    {
        Log::info('Livewire registration process started for email: ' . $this->email);

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        try {
            // Generate registration ID
            $registrationId = Str::uuid()->toString();
            
            // Store registration data in cache for 60 minutes (don't create user yet)
            Cache::put('registration_' . $registrationId, [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ], 3600);

            // Generate OTP
            $otp = EmailVerification::generateOtp();
            
            // Store OTP in email_verifications table
            EmailVerification::create([
                'email' => $validated['email'],
                'otp' => $otp,
                'expires_at' => now()->addMinutes(60),
                'is_used' => false,
                'registration_id' => $registrationId,
            ]);

            Log::info('OTP generated and stored for email: ' . $validated['email'] . ', OTP: ' . $otp);

            // Send OTP email with error handling
            try {
                Mail::to($validated['email'])->send(new EmailVerificationOtp($otp));
                Log::info('OTP email sent successfully to: ' . $validated['email']);
            } catch (\Exception $e) {
                Log::error('Failed to send OTP email to: ' . $validated['email'] . ', Error: ' . $e->getMessage());
                // Continue anyway and show success message to user
            }

            // Dispatch event to show OTP modal
            $this->dispatch('otpModalRequested', email: $validated['email']);

            // Reset form
            $this->reset(['name', 'email', 'password', 'password_confirmation']);

            // Show success message
            $this->registrationSuccess('Kode OTP telah dikirim ke email Anda. Silakan verifikasi untuk menyelesaikan registrasi.');

        } catch (\Exception $e) {
            Log::error('Registration failed for email: ' . $validated['email'] . ', Error: ' . $e->getMessage());
            
            $this->addError('email', 'Terjadi kesalahan saat proses registrasi. Silakan coba lagi.');
        }
    }
}; ?>

<div>
    @if($successMessage)
        <div class="alert alert-success mb-4" wire:poll.5s="clearSuccessMessage">
            {{ $successMessage }}
        </div>
    @endif

    <form wire:submit="register">
        <!-- Name -->
        <div class="mb-3">
            <label class="form-label">Name</label>
            <input wire:model="name" type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="name" name="name" placeholder="Enter your name" required autofocus autocomplete="name" />
            @if($errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            @endif
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input wire:model="email" type="email" class="form-control @if($errors->has('email')) is-invalid @endif" id="email" name="email" placeholder="Enter your email" required autocomplete="username" />
            @if($errors->has('email'))
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            @endif
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input wire:model="password" type="password" class="form-control @if($errors->has('password')) is-invalid @endif" id="password" name="password" placeholder="Enter your password" required autocomplete="new-password" />
            @if($errors->has('password'))
                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
            @endif
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label class="form-label">Confirm Password</label>
            <input wire:model="password_confirmation" type="password" class="form-control @if($errors->has('password_confirmation')) is-invalid @endif" id="password_confirmation" name="password_confirmation" placeholder="Confirm your password" required autocomplete="new-password" />
            @if($errors->has('password_confirmation'))
                <div class="invalid-feedback">{{ $errors->first('password_confirmation') }}</div>
            @endif
        </div>

        <!-- Register Button -->
        <button type="submit" class="btn btn-noc w-100 rounded-pill">
            Register
        </button>
    </form>
</div>
