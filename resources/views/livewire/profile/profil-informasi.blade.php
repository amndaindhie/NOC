<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $current_password = '';
    public bool $isEditing = false;
    public bool $showPasswordFields = false;

    // Store original values for view mode
    public string $originalName = '';
    public string $originalEmail = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();

        if ($user) {
            $this->name = $user->name ?? '';
            $this->email = $user->email ?? '';
            $this->originalName = $this->name;
            $this->originalEmail = $this->email;
        } else {
            // Fallback if user is not authenticated
            $this->name = '';
            $this->email = '';
            $this->originalName = '';
            $this->originalEmail = '';
        }
    }

    /**
     * Get password asterisks based on stored password length.
     */
    public function getPasswordAsterisks(): string
    {
        $user = Auth::user();
        $length = $user->password_length ?? 8; // Default to 8 if not set
        return str_repeat('*', $length);
    }

    /**
     * Toggle edit mode.
     */
    public function toggleEdit(): void
    {
        if ($this->isEditing) {
            // Switching from edit to view mode - reset to original values
            $this->name = $this->originalName;
            $this->email = $this->originalEmail;
            $this->password = '';
            $this->password_confirmation = '';
            $this->showPasswordFields = false;
        }

        $this->isEditing = !$this->isEditing;
    }

    /**
     * Cancel editing and reset form.
     */
    public function cancelEdit(): void
    {
        $this->isEditing = false;
        $this->showPasswordFields = false;
        $this->password = '';
        $this->password_confirmation = '';
        $this->current_password = '';
        // Reset to original values
        $this->name = $this->originalName;
        $this->email = $this->originalEmail;
    }

    /**
     * Toggle password fields visibility.
     */
    public function togglePasswordFields(): void
    {
        $this->showPasswordFields = !$this->showPasswordFields;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        try {
            $this->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            ]);

            if ($this->showPasswordFields) {
                $this->validate([
                    'password' => ['required', 'string', 'min:8', 'confirmed'],
                ]);
            }

            $user = Auth::user();

            // Check if email has changed
            $emailChanged = $user->email !== $this->email;

            $user->update([
                'name' => $this->name,
                'email' => $this->email,
            ]);

            if ($this->showPasswordFields && $this->password) {
                // Verify current password before updating
                if (!Hash::check($this->current_password ?? '', $user->password)) {
                    throw ValidationException::withMessages([
                        'current_password' => ['The current password is incorrect.'],
                    ]);
                }

                $user->update([
                    'password' => Hash::make($this->password),
                    'password_length' => strlen($this->password),
                ]);
            }

            $this->isEditing = false;
            $this->showPasswordFields = false;
            $this->password = '';
            $this->password_confirmation = '';

            // Update original values after successful save
            $this->originalName = $this->name;
            $this->originalEmail = $this->email;

            // If email changed, mark as unverified
            if ($emailChanged && $user->hasVerifiedEmail()) {
                $user->update(['email_verified_at' => null]);
                $user->sendEmailVerificationNotification();
                session()->flash('status', 'Profile updated successfully. Please check your email to verify your new email address.');
            } else {
                session()->flash('status', 'Profile updated successfully.');
            }

            $this->dispatch('profile-updated');

        } catch (ValidationException $e) {
            // Re-throw validation exceptions to show errors
            throw $e;
        } catch (\Exception $e) {
            // Handle other exceptions
            session()->flash('error', 'An error occurred while updating your profile. Please try again.');
            $this->addError('general', 'An error occurred while updating your profile. Please try again.');
        }
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
            {{ __("View your account's profile information and email address.") }}
        </p>
    </header>

    <div style="margin-top: 24px;">
        @if($isEditing)
            <form wire:submit.prevent="updateProfileInformation">
                <div style="margin-bottom: 24px;">
                    <label for="name" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('Name') }}</label>
                    <input type="text" wire:model="name" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;" required>
                    @error('name') <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span> @enderror
                </div>

                <div style="margin-bottom: 24px;">
                    <label for="email" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('Email') }}</label>
                    <input type="email" wire:model="email" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;" required>
                    @error('email') <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span> @enderror

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

                <div style="margin-bottom: 24px;">
                    <label for="password" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">
                        {{ __('Password') }}
                        <button type="button" wire:click="togglePasswordFields" style="background: none; border: none; color: #007bff; cursor: pointer; font-size: 12px; text-decoration: underline;">
                            {{ $showPasswordFields ? __('Hide') : __('Change Password') }}
                        </button>
                    </label>
                    <div style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif; background-color: #f8f9fa; color: #333;">
                        {{ $this->getPasswordAsterisks() }}
                    </div>
                    <small style="color: #666; font-size: 12px;">{{ __('Password is hidden for security') }}</small>
                </div>

                @if($showPasswordFields)
                    <div style="margin-bottom: 24px;">
                        <label for="current_password" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('Current Password') }}</label>
                        <input type="password" wire:model="current_password" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;" autocomplete="current-password">
                        @error('current_password') <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span> @enderror
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label for="password" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('New Password') }}</label>
                        <input type="password" wire:model="password" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;" minlength="8">
                        @error('password') <span style="color: #e74c3c; font-size: 12px;">{{ $message }}</span> @enderror
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label for="password_confirmation" style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('Confirm New Password') }}</label>
                        <input type="password" wire:model="password_confirmation" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif;" minlength="8">
                    </div>
                @endif

                <div style="display: flex; align-items: center; gap: 16px;">
                    <button type="submit" style="background: #27ae60; color: #fff; padding: 10px 20px; border: none; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; font-family: 'Poppins', sans-serif;">{{ __('Save Changes') }}</button>
                    <button type="button" wire:click="cancelEdit" style="background: #95a5a6; color: #fff; padding: 10px 20px; border: none; border-radius: 8px; font-size: 14px; font-weight: 500; cursor: pointer; font-family: 'Poppins', sans-serif;">{{ __('Cancel') }}</button>
                </div>
            </form>
        @else
            <!-- VIEW MODE - Read Only -->
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('Name') }}</label>
                <div style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif; background-color: #f8f9fa; color: #333;">
                    {{ $name }}
                </div>
            </div>

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('Email') }}</label>
                <div style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif; background-color: #f8f9fa; color: #333;">
                    {{ $email }}
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

            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 14px; font-weight: 500; color: #333; margin-bottom: 8px;">{{ __('Password') }}</label>
                <div style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 14px; font-family: 'Poppins', sans-serif; background-color: #f8f9fa; color: #333;">
                    {{ $this->getPasswordAsterisks() }}
                </div>
                <small style="color: #666; font-size: 12px;">{{ __('Password is hidden for security') }}</small>
            </div>

        @endif

        @if (session()->has('status'))
            <div style="margin-top: 16px; padding: 12px; background-color: #d4edda; border: 1px solid #c3e6cb; border-radius: 8px; color: #155724;">
                {{ session('status') }}
            </div>
        @endif
    </div>
</section>
