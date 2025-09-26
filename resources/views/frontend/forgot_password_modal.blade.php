<!-- Forgot Password Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-gradient-primary text-white">
        <h5 class="modal-title" id="forgotPasswordModalLabel">
          <i class="bi bi-key-fill me-2"></i>{{ __('Forgot Password') }}
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>

      <div class="modal-body p-4">
        @livewire('forgot-password-modal')
      </div>

      <div class="modal-footer border-0 justify-content-center">
        <small class="text-muted">
            <i class="bi bi-info-circle me-1"></i>
            Didn't receive the email? Check your spam folder or try again in a few minutes.
        </small>
      </div>
    </div>
  </div>
</div>

<script>
// Clean and simple forgot password modal initialization
document.addEventListener('DOMContentLoaded', function() {
    // Function to initialize forgot password buttons
    function initializeForgotPasswordButtons() {
        const buttons = document.querySelectorAll('[data-bs-target="#forgotPasswordModal"]');
        const modalElement = document.getElementById('forgotPasswordModal');

        if (!modalElement) {
            console.warn('Forgot password modal not found in DOM');
            return;
        }

        buttons.forEach(button => {
            // Remove existing event listeners to prevent duplicates
            button.removeEventListener('click', handleForgotPasswordClick);
            button.addEventListener('click', handleForgotPasswordClick);
        });

        console.log(`Initialized ${buttons.length} forgot password button(s)`);
    }

    // Handle forgot password button click
    function handleForgotPasswordClick(e) {
        e.preventDefault();
        e.stopPropagation();

        const modalElement = document.getElementById('forgotPasswordModal');
        if (!modalElement) {
            console.error('Forgot password modal element not found');
            return;
        }

        // Close any other open modals first
        const openModals = document.querySelectorAll('.modal.show');
        openModals.forEach(modal => {
            if (modal.id !== 'forgotPasswordModal') {
                const bsModal = bootstrap.Modal.getInstance(modal);
                if (bsModal) bsModal.hide();
            }
        });

        // Use Bootstrap modal API if available
        if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
            const modal = bootstrap.Modal.getInstance(modalElement) || new bootstrap.Modal(modalElement);
            modal.show();
        } else {
            // Fallback: manually show modal
            modalElement.style.display = 'block';
            modalElement.classList.add('show');
            document.body.classList.add('modal-open');

            // Add backdrop
            if (!document.querySelector('.modal-backdrop')) {
                const backdrop = document.createElement('div');
                backdrop.className = 'modal-backdrop fade show';
                document.body.appendChild(backdrop);
            }
        }
    }

    // Initialize immediately
    initializeForgotPasswordButtons();

    // Re-initialize after Livewire updates
    document.addEventListener('livewire:updated', function() {
        setTimeout(initializeForgotPasswordButtons, 100);
    });

    // Also listen for dynamic content changes
    const observer = new MutationObserver(function(mutations) {
        let shouldReinitialize = false;
        mutations.forEach(function(mutation) {
            if (mutation.type === 'childList' && mutation.addedNodes.length > 0) {
                shouldReinitialize = true;
            }
        });
        if (shouldReinitialize) {
            setTimeout(initializeForgotPasswordButtons, 100);
        }
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true
    });
});
</script>
