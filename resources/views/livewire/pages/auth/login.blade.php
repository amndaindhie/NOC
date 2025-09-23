<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;
    public ?string $errorMessage = null;

    public function login(): void
    {
        $this->errorMessage = null;

        $this->validate([
            'form.email' => 'required|string|email',
            'form.password' => 'required|string',
        ]);

        try {
            $this->form->authenticate();
            Session::regenerate();

            if (auth()->user()->hasRole('admin')) {
                $this->redirect(route('admin.dashboard'), navigate: true);
            } else {
                $this->redirect(route('home'), navigate: true);
            }
        } catch (\Exception $e) {
            $this->errorMessage = 'Invalid email or password. Please try again.';
        }
    }

    public function clearErrorMessage(): void
    {
        $this->errorMessage = null;
    }

    public function handleModalShow(): void
    {
        $this->clearErrorMessage();
        $this->form->reset();
    }
}; 
?>

<div class="p-3">
    {{-- Error Message --}}
    @if ($errorMessage)
        <div class="alert alert-danger text-center mb-3 rounded-3 shadow-sm">
            {{ $errorMessage }}
        </div>
    @endif

    {{-- Login Form --}}
    <form wire:submit="login" class="needs-validation" novalidate>
        <!-- Email -->
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input
                wire:model="form.email"
                type="email"
                id="email"
                name="email"
                class="form-control @error('form.email') is-invalid @enderror"
                placeholder="Enter your email"
                required
                autofocus
                autocomplete="username"
            />
            @error('form.email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input
                wire:model="form.password"
                type="password"
                id="password"
                name="password"
                class="form-control @error('form.password') is-invalid @enderror"
                placeholder="Enter your password"
                required
                autocomplete="current-password"
            />
            @error('form.password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Remember + Forgot Password -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="form-check">
                <input
                    wire:model="form.remember"
                    type="checkbox"
                    class="form-check-input"
                    id="rememberMe"
                />
                <label class="form-check-label" for="rememberMe">Remember me</label>
            </div>

            <a href="#"
               class="small text-decoration-none"
               data-bs-toggle="modal"
               data-bs-target="#forgotPasswordModal"
               data-bs-dismiss="modal">
                Forgot password?
            </a>
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="btn btn-noc w-100 rounded-pill py-2 fw-semibold shadow-sm"
            wire:loading.attr="disabled"
            wire:loading.class="opacity-50"
        >
            <span wire:loading.remove>Login</span>
            <span wire:loading>
                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                Processing...
            </span>
        </button>
    </form>
</div>

<script>
document.addEventListener('livewire:init', () => {
    const loginModal = document.getElementById('loginModal');
    if (loginModal) {
        loginModal.addEventListener('show.bs.modal', () => {
            @this.handleModalShow();
        });
    }
});
</script>
