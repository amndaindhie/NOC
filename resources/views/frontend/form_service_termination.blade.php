@extends('frontend.layout')

@section('title', 'Service Termination Request Form - Network Operation Center - KITB')

@section('content')

  <!-- Page Title -->
  <div class="page-title dark-background">
    <div class="container position-relative">
      <h1>Service Termination Request</h1>
      <p>
        Please fill out the form below to request service termination.
      </p>
    </div>
  </div>

  <div class="container">
    <!-- Success/Error Messages -->
    @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif

    <div class="form-section">
      <form method="POST" action="{{ route('noc.terminasi.store') }}" enctype="multipart/form-data" onsubmit="return checkAuth()" novalidate>
        @csrf

        <div class="mb-3">
          <label class="form-label">Tenant ID Number <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('nomor_tenant') is-invalid @enderror" name="nomor_tenant" value="{{ old('nomor_tenant') }}" required />
          @error('nomor_tenant')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Tenant Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('nama_tenant') is-invalid @enderror" name="nama_tenant" value="{{ old('nama_tenant') }}" required />
          @error('nama_tenant')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Email <span class="text-danger">*</span></label>
          <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email', auth()->check() ? auth()->user()->email : '') }}" readonly />
          @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          <small class="form-text text-muted">Email will be automatically filled from your account</small>
        </div>

        <div class="mb-3">
          <label class="form-label">Location <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('lokasi') is-invalid @enderror" name="lokasi" value="{{ old('lokasi') }}" required />
          @error('lokasi')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Reason for Termination <span class="text-danger">*</span></label>
          <select class="form-select @error('alasan_terminasi') is-invalid @enderror" name="alasan_terminasi" required>
            <option value="">Select Termination Reason</option>
            <option value="Pindah Lokasi" {{ old('alasan_terminasi') == 'Pindah Lokasi' ? 'selected' : '' }}>Relocation</option>
            <option value="Tidak Membutuhkan Layanan" {{ old('alasan_terminasi') == 'Tidak Membutuhkan Layanan' ? 'selected' : '' }}>No Longer Need the Service</option>
            <option value="Pindah Provider" {{ old('alasan_terminasi') == 'Pindah Provider' ? 'selected' : '' }}>Switching Provider</option>
            <option value="Masalah Teknis" {{ old('alasan_terminasi') == 'Masalah Teknis' ? 'selected' : '' }}>Technical Issues</option>
            <option value="Lainnya" {{ old('alasan_terminasi') == 'Lainnya' ? 'selected' : '' }}>Others</option>
          </select>
          @error('alasan_terminasi')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Urgency Level <span class="text-danger">*</span></label>
          <select class="form-select @error('prioritas_terminasi') is-invalid @enderror" name="prioritas_terminasi" required>
            <option value="">Select Urgency Level</option>
            <option value="Low" {{ old('prioritas_terminasi') == 'Low' ? 'selected' : '' }}>Low</option>
            <option value="Medium" {{ old('prioritas_terminasi') == 'Medium' ? 'selected' : '' }}>Medium</option>
            <option value="High" {{ old('prioritas_terminasi') == 'High' ? 'selected' : '' }}>High</option>
            <option value="Critical" {{ old('prioritas_terminasi') == 'Critical' ? 'selected' : '' }}>Critical</option>
          </select>
          @error('prioritas_terminasi')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Additional Notes (Optional)</label>
          <textarea class="form-control @error('keterangan_tambahan') is-invalid @enderror" name="keterangan_tambahan" rows="3">{{ old('keterangan_tambahan') }}</textarea>
          @error('keterangan_tambahan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Effective Date <span class="text-danger">*</span></label>
          <input type="date" class="form-control @error('tanggal_efektif') is-invalid @enderror" name="tanggal_efektif" value="{{ old('tanggal_efektif') }}" required />
          @error('tanggal_efektif')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Upload Document (Optional)</label>
          <input type="file" class="form-control @error('dokumen') is-invalid @enderror" name="dokumen" accept=".pdf,.doc,.docx" />
          @error('dokumen')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          <div class="form-text">Format: PDF, DOC, DOCX. Max 2MB</div>
        </div>

        <div class="form-check mb-3">
          <input
            type="checkbox"
            class="form-check-input @error('konfirmasi_setuju') is-invalid @enderror"
            id="konfirmasi_setuju"
            name="konfirmasi_setuju"
            value="1"
            {{ old('konfirmasi_setuju') ? 'checked' : '' }}
            required
          />
          <label for="konfirmasi_setuju" class="form-check-label">
            I agree to this service termination request <span class="text-danger">*</span>
          </label>
          @error('konfirmasi_setuju')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-noc">Submit Request</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center">
    <i class="bi bi-arrow-up-short"></i>
  </a>

  <!-- Preloader -->
  <div id="preloader"></div>

  @include('frontend.login_modal')
  @include('frontend.register_modal')

@endsection
