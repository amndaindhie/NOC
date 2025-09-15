<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section style="background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1); font-family: 'Poppins', sans-serif;">
    <header>
        <h2 style="color: #333; font-size: 18px; font-weight: 600;">
            {{ __('Profile Information') }}
        </h2>

        <p style="margin-top: 4px; font-size: 14px; color: #666;">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form wire:submit="updateProfileInformation" style="margin-top: 24px;">
        <div style="margin-bottom: 24px;">
            <label for="name" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('Name') }}</label>
            <input wire:model="name" id="name" name="name" type="text" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;" required autofocus autocomplete="name" />
            <div style="margin-top: 8px; color: #e74c3c; font-size: 12px;">
                @error('name') {{ $message }} @enderror
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <label for="email" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('Email') }}</label>
            <input wire:model="email" id="email" name="email" type="email" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;" required autocomplete="username" />
            <div style="margin-top: 8px; color: #e74c3c; font-size: 12px;">
                @error('email') {{ $message }} @enderror
            </div>

            @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
                <div style="margin-top: 12px;">
                    <p style="font-size: 14px; color: #333;">
                        {{ __('Your email address is unverified.') }}

                        <button wire:click.prevent="sendVerification" style="text-decoration: underline; color: #666; background: none; border: none; cursor: pointer; font-size: 14px;">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p style="margin-top: 8px; font-weight: 500; font-size: 14px; color: #27ae60;">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div style="display: flex; align-items: center; gap: 16px;">
            <button type="submit" style="background: #3498db; color: #fff; padding: 10px 20px; border: none; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; font-family: 'Poppins', sans-serif;">{{ __('Save') }}</button>

            <div wire:loading.delay style="color: #27ae60; font-size: 14px;">{{ __('Saved.') }}</div>
        </div>
    </form>
</section>
