const modalTargets = {
  login: '#loginModal',
  register: '#registerModal',
  // Removed OTP modal target since OTP is now a separate page
};

// Export for use in other modules
export default modalTargets;

// Also make it available globally if needed
window.modalTargets = modalTargets;

// Modal state management
document.addEventListener('DOMContentLoaded', function() {
  // Clear error states when switching between modals
  const loginModal = document.getElementById('loginModal');
  const registerModal = document.getElementById('registerModal');

  // Function to clear all error messages and form states
  function clearModalStates() {
    // Clear Bootstrap validation states
    const invalidElements = document.querySelectorAll('.is-invalid');
    invalidElements.forEach(el => {
      el.classList.remove('is-invalid');
    });

    // Clear error messages
    const errorMessages = document.querySelectorAll('.invalid-feedback');
    errorMessages.forEach(el => {
      if (!el.hasAttribute('data-persistent')) {
        el.style.display = 'none';
      }
    });

    // Clear alert messages
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
      if (!alert.hasAttribute('data-persistent')) {
        alert.remove();
      }
    });

    // Reset form fields
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
      if (!form.hasAttribute('data-keep-values')) {
        form.reset();
      }
    });
  }

  // Handle modal hide events
  if (loginModal) {
    loginModal.addEventListener('hide.bs.modal', function() {
      // Clear states when login modal is hidden
      setTimeout(clearModalStates, 150);
    });
  }

  if (registerModal) {
    registerModal.addEventListener('hide.bs.modal', function() {
      // Clear states when register modal is hidden
      setTimeout(clearModalStates, 150);
    });
  }

  // Handle modal show events to clear previous states
  if (loginModal) {
    loginModal.addEventListener('show.bs.modal', function() {
      clearModalStates();
    });
  }

  if (registerModal) {
    registerModal.addEventListener('show.bs.modal', function() {
      clearModalStates();
    });
  }

  // Handle clicks on modal switch links
  const modalSwitchLinks = document.querySelectorAll('[data-bs-toggle="modal"][data-bs-target="#loginModal"], [data-bs-toggle="modal"][data-bs-target="#registerModal"]');
  modalSwitchLinks.forEach(link => {
    link.addEventListener('click', function() {
      // Clear states when switching modals
      clearModalStates();
    });
  });
});
