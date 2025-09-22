const modalTargets = {
  login: '#loginModal',
  register: '#registerModal',
  // Removed OTP modal target since OTP is now a separate page
};

// Export for use in other modules
export default modalTargets;

// Also make it available globally if needed
window.modalTargets = modalTargets;
