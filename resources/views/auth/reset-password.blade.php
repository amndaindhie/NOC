@extends('frontend.layout', ['hide_navbar' => true, 'hide_footer' => true])

@section('content')
<section class="bg-light py-5 min-vh-100 d-flex align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-12 col-md-6 col-lg-5">
        <div class="card shadow-sm border-0 rounded-3">
          <div class="card-body p-4">
            
            <!-- Header -->
            <div class="text-center mb-3">
              <i class="bi bi-shield-lock text-primary" style="font-size: 2rem;"></i>
              <h5 class="fw-semibold mt-2">Reset Password</h5>
              <p class="text-muted small">Enter your email and new password</p>
            </div>

            <!-- Session Message -->
            @if (Session::has('message'))
              <div class="alert alert-success small text-center" role="alert">
                {{ Session::get('message') }}
              </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('reset.password.post') }}">
              @csrf
              <input type="hidden" name="token" value="{{ $token }}">

              <div class="mb-3">
                <label for="email" class="form-label small fw-semibold">Email</label>
                <input
                    type="email"
                    class="form-control"
                    name="email"
                    id="email"
                    value="{{ old('email', $email) }}"
                    readonly
                >
              </div>

              <div class="mb-3">
                <label for="password" class="form-label small fw-semibold">New Password</label>
                <input
                  type="password"
                  class="form-control @error('password') is-invalid @enderror"
                  name="password"
                  id="password"
                  placeholder="••••••"
                  required
                >
                @error('password')
                  <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
              </div>

              <div class="mb-3">
                <label for="password_confirmation" class="form-label small fw-semibold">Confirm Password</label>
                <input
                  type="password"
                  class="form-control @error('password_confirmation') is-invalid @enderror"
                  name="password_confirmation"
                  id="password_confirmation"
                  placeholder="••••••"
                  required
                >
                @error('password_confirmation')
                  <div class="invalid-feedback small">{{ $message }}</div>
                @enderror
              </div>

              <div class="d-grid">
                <button class="btn btn-primary btn-sm fw-semibold" type="submit">
                  Reset Password
                </button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

<style>
body {
  background: #f8f9fa;
}
.card {
  border-radius: .75rem !important;
}
</style>
