<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4">
      <div class="modal-header border-0">
        <h5 class="modal-title">Login</h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Close"
        ></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{ route('login') }}">
          @csrf

          <!-- Email -->
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input
              type="email"
              class="form-control @error('email') is-invalid @enderror"
              name="email"
              value="{{ old('email') }}"
              placeholder="Enter your email"
              required
              autofocus
            />
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Password -->
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input
              type="password"
              class="form-control @error('password') is-invalid @enderror"
              name="password"
              placeholder="Enter your password"
              required
            />
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <!-- Remember Me -->
          <div class="mb-3 form-check">
            <input
              type="checkbox"
              class="form-check-input"
              name="remember"
              id="rememberMe"
              {{ old('remember') ? 'checked' : '' }}
            />
            <label class="form-check-label" for="rememberMe"
              >Remember me</label
            >
          </div>

          <!-- Login Button -->
          <button type="submit" class="btn btn-noc w-100 rounded-pill">
            Login
          </button>
        </form>
      </div>
      <div class="modal-footer border-0 text-center">
        <p class="w-100">
          Don't have an account?
          <a
            href="#"
            data-bs-toggle="modal"
            data-bs-target="#registerModal"
            data-bs-dismiss="modal"
            >Register</a
          >
        </p>
      </div>
    </div>
  </div>
</div>
