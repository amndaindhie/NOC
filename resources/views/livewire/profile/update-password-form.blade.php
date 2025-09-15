<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section style="background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1); font-family: 'Poppins', sans-serif;">
    <header>
        <h2 style="color: #333; font-size: 18px; font-weight: 600;">
            {{ __('Update Password') }}
        </h2>

        <p style="margin-top: 4px; font-size: 14px; color: #666;">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form wire:submit="updatePassword" style="margin-top: 24px;">
        <div style="margin-bottom: 24px;">
            <label for="update_password_current_password" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('Current Password') }}</label>
            <input wire:model="current_password" id="update_password_current_password" name="current_password" type="password" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;" autocomplete="current-password" />
            <div style="margin-top: 8px; color: #e74c3c; font-size: 12px;">
                @error('current_password') {{ $message }} @enderror
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <label for="update_password_password" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('New Password') }}</label>
            <input wire:model="password" id="update_password_password" name="password" type="password" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;" autocomplete="new-password" />
            <div style="margin-top: 8px; color: #e74c3c; font-size: 12px;">
                @error('password') {{ $message }} @enderror
            </div>
        </div>

        <div style="margin-bottom: 24px;">
            <label for="update_password_password_confirmation" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('Confirm Password') }}</label>
            <input wire:model="password_confirmation" id="update_password_password_confirmation" name="password_confirmation" type="password" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;" autocomplete="new-password" />
            <div style="margin-top: 8px; color: #e74c3c; font-size: 12px;">
                @error('password_confirmation') {{ $message }} @enderror
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 16px;">
            <button type="submit" style="background: #3498db; color: #fff; padding: 10px 20px; border: none; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; font-family: 'Poppins', sans-serif;">{{ __('Save') }}</button>

            <div wire:loading.delay style="color: #27ae60; font-size: 14px;">{{ __('Saved.') }}</div>
        </div>
    </form>
</section>
