<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Password;
use Livewire\Component;

class ForgotPasswordModal extends Component
{
    public string $email = '';
    public bool $isLoading = false;

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->isLoading = true;

        $this->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));
            $this->isLoading = false;
            return;
        }

        $this->reset('email');

        // Check if we're using log driver for development
        $mailDriver = config('mail.default');
        if ($mailDriver === 'log') {
            session()->flash('status', 'Link reset password telah dicatat dalam log sistem (Development Mode). Dalam production, email akan dikirim ke: ' . $this->email);
        } else {
            session()->flash('status', 'A password reset link has been sent to your email. Please check your inbox.');
        }

        $this->isLoading = false;

        // Close modal after successful submission
        $this->dispatch('close-forgot-password-modal');
    }

    /**
     * Reset form and close modal
     */
    public function closeModal(): void
    {
        $this->reset('email');
        $this->resetErrorBag();
        $this->dispatch('close-forgot-password-modal');
    }

    public function render()
    {
        return view('livewire.forgot-password-modal');
    }
}
