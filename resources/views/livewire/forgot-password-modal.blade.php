<div>
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

    <div class="mb-4">
        <p class="text-muted mb-3">
            {{ __('Enter your email address and we will send you a password reset link.') }}
        </p>
    </div>

    <form wire:submit="sendPasswordResetLink" class="user">
        <div class="form-group mb-4">

            <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                    <i class="bi bi-envelope text-muted"></i>
                </span>
                <input
                    wire:model="email"
                    type="email"
                    class="form-control form-control-lg border-start-0 @error('email') is-invalid @enderror"
                    id="email"
                    name="email"
                    placeholder="Enter your email"
                    style="font-size: 1rem;"
                    required
                    autofocus
                    autocomplete="email"
                >
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

        </div>

        <div class="d-grid">
            <button
                type="submit"
                class="btn btn-primary btn-sm w-auto"
                wire:loading.attr="disabled"
                wire:loading.class="btn-secondary"
            >
            <span wire:loading.remove wire:target="sendPasswordResetLink" class="small" style="font-size: 1rem;">
                <i class="bi bi-send me-1"></i>{{ __('Send Reset Link') }}
            </span>

                <span wire:loading wire:target="sendPasswordResetLink">
                    <span class="spinner-border spinner-border-sm me-2" role="status"></span>
                    Sending...
                </span>
            </button>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize forgot password modal functionality
    initializeForgotPasswordModal();

    // Re-initialize when Livewire updates the DOM
    document.addEventListener('livewire:updated', function() {
        initializeForgotPasswordModal();
    });
});

function initializeForgotPasswordModal() {
    // Check if Bootstrap is loaded
    if (typeof bootstrap === 'undefined') {
        console.warn('Bootstrap is not loaded yet. Retrying in 500ms...');
        setTimeout(initializeForgotPasswordModal, 500);
        return;
    }

    // Check if modal element exists
    const modalElement = document.getElementById('forgotPasswordModal');
    if (!modalElement) {
        console.warn('Forgot password modal element not found');
        return;
    }

    // Initialize modal if not already done
    let modal = bootstrap.Modal.getInstance(modalElement);
    if (!modal) {
        modal = new bootstrap.Modal(modalElement, {
            backdrop: 'static',
            keyboard: false
        });
        console.log('Forgot password modal initialized');
    }

    // Listen for close modal event from Livewire
    Livewire.on('close-forgot-password-modal', () => {
        if (modal) {
            modal.hide();
            console.log('Forgot password modal closed via Livewire event');
        }
    });

    // Add click handler for forgot password button as backup
    const forgotPasswordButtons = document.querySelectorAll('[data-bs-target="#forgotPasswordModal"]');
    forgotPasswordButtons.forEach(button => {
        // Remove existing event listeners to prevent duplicates
        button.removeEventListener('click', handleForgotPasswordClick);
        button.addEventListener('click', handleForgotPasswordClick);
    });

    function handleForgotPasswordClick(e) {
        e.preventDefault();
        e.stopPropagation();

        if (modal) {
            modal.show();
            console.log('Forgot password modal opened via button click');
        } else {
            console.error('Modal instance not available');
            // Try to create modal instance if it doesn't exist
            const modalElement = document.getElementById('forgotPasswordModal');
            if (modalElement && typeof bootstrap !== 'undefined') {
                modal = new bootstrap.Modal(modalElement, {
                    backdrop: 'static',
                    keyboard: false
                });
                modal.show();
                console.log('Modal instance created and opened');
            }
        }
    }

    console.log('Forgot password modal initialization completed');
}
</script>
