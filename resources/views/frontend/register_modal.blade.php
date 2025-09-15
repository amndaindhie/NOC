<!-- Register Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <div class="modal-header border-0">
        <h5 class="modal-title">Register</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        @livewire('pages.auth.register')
      </div>
      <div class="modal-footer border-0 text-center">
        <p class="w-100">
          Already have an account?
          <a
            href="#"
            data-bs-toggle="modal"
            data-bs-target="#loginModal"
            data-bs-dismiss="modal"
            >Login</a
          >
        </p>
    </div>
  </div>
</div>
