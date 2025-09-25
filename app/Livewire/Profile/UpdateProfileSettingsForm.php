<?php

namespace App\Livewire\Profile;

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

    public ?string $message = null; // Pesan sukses / info
    public ?string $errorMessage = null; // Pesan error

    public function mount(): void
    {
        $user = Auth::user();

        if ($user) {
            $this->name = $user->name ?? '';
            $this->email = $user->email ?? '';
        }
    }

    public function updateProfileSettings(): void
    {
        $this->message = null;
        $this->errorMessage = null;

        $user = Auth::user();

        try {
            // Validasi profil
            $profileValidated = $this->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            ]);

            $changes = [];

            // Cek perubahan name/email
            if ($user->name !== $profileValidated['name']) {
                $changes['name'] = $profileValidated['name'];
            }
            if ($user->email !== $profileValidated['email']) {
                $changes['email'] = $profileValidated['email'];
            }

            // Validasi password jika diisi
            if ($this->current_password || $this->password || $this->password_confirmation) {
                $passwordValidated = $this->validate([
                    'current_password' => ['required', 'string'],
                    'password' => ['required', 'string', Rules\Password::defaults(), 'confirmed'],
                ]);

                // Verifikasi current password
                if (!Hash::check($passwordValidated['current_password'], $user->password)) {
                    throw ValidationException::withMessages([
                        'current_password' => ['The current password is incorrect.'],
                    ]);
                }

                $changes['password'] = Hash::make($passwordValidated['password']);
            }

            // Jika tidak ada perubahan
            if (empty($changes)) {
                $this->message = 'No changes were made.';
                return;
            }

            // Simpan perubahan
            $emailChanged = isset($changes['email']) && $user->email !== $changes['email'];

            $user->update($changes);

            // Handle verifikasi email jika email berubah
            if ($emailChanged && $user->hasVerifiedEmail()) {
                $user->email_verified_at = null;
                $user->save();
                $user->sendEmailVerificationNotification();
                $this->message = 'Profile updated successfully. Please check your email to verify your new email address.';
            } else {
                $this->message = 'Profile updated successfully.';
            }

            // Kosongkan password fields
            $this->current_password = '';
            $this->password = '';
            $this->password_confirmation = '';

        } catch (\Exception $e) {
            $this->errorMessage = $e->getMessage();
        }
    }

    public function render()
    {
        return view('livewire.profile.update-profile-settings-form');
    }
}
