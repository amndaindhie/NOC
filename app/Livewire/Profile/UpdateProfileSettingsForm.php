<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

class UpdateProfileSettingsForm extends Component
{
    public string $name = '';
    public string $email = '';
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();

        if ($user) {
            $this->name = $user->name ?? '';
            $this->email = $user->email ?? '';
        }
    }

    /**
     * Update the profile settings for the currently authenticated user.
     */
    public function updateProfileSettings(): void
    {
        $user = Auth::user();

        try {
            // Validate profile information
            $profileValidated = $this->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            ], [
                'name.required' => 'Name is required.',
                'email.required' => 'Email is required.',
                'email.email' => 'Please enter a valid email address.',
                'email.unique' => 'This email is already taken.',
            ]);

            // Validate password if provided
            $passwordValidated = [];
            if (!empty($this->current_password) || !empty($this->password) || !empty($this->password_confirmation)) {
                $passwordValidated = $this->validate([
                    'current_password' => ['required', 'string'],
                    'password' => ['required', 'string', Rules\Password::defaults(), 'confirmed'],
                ], [
                    'current_password.required' => 'Current password is required.',
                    'password.required' => 'New password is required.',
                    'password.confirmed' => 'Password confirmation does not match.',
                ]);

                // Verify current password
                if (!Hash::check($passwordValidated['current_password'], $user->password)) {
                    throw ValidationException::withMessages([
                        'current_password' => ['The current password is incorrect.'],
                    ]);
                }
            }

            // Check if email has changed
            $emailChanged = $user->email !== $this->email;

            // Update profile information
            $user->update([
                'name' => $profileValidated['name'],
                'email' => $profileValidated['email'],
            ]);

            // Update password if provided
            if (!empty($passwordValidated)) {
                $user->update([
                    'password' => Hash::make($passwordValidated['password']),
                    'password_length' => strlen($passwordValidated['password']),
                ]);
            }

            // Handle email verification
            if ($emailChanged && $user->hasVerifiedEmail()) {
                $user->update(['email_verified_at' => null]);
                $user->sendEmailVerificationNotification();

                session()->flash('status', 'Profile updated successfully. Please check your email to verify your new email address.');
            } else {
                session()->flash('status', 'Profile updated successfully.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.profile.update-profile-settings-form');
    }
}
