@extends('frontend.layout')

@section('body_class', 'bg-light')

@section('title', 'Maintenance')

@section('content')


  <!-- Page Title -->
  <div class="page-title dark-background">
    <div class="container position-relative">
      <h1>Maintenance</h1>
      <p>
        Please fill out the form below to request maintenance services.
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
      <form method="POST" action="{{ route('noc.maintenance.store') }}" enctype="multipart/form-data" onsubmit="return checkAuth()" novalidate>
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
          <label class="form-label">Device Location <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('lokasi_perangkat') is-invalid @enderror" name="lokasi_perangkat" value="{{ old('lokasi_perangkat') }}" required />
          @error('lokasi_perangkat')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Maintenance Type <span class="text-danger">*</span></label>
          <select class="form-select @error('jenis_maintenance') is-invalid @enderror" name="jenis_maintenance" required>
            <option value="">Select Maintenance Type</option>
            <option value="Internet" {{ old('jenis_maintenance') == 'Internet' ? 'selected' : '' }}>Internet</option>
            <option value="CCTV" {{ old('jenis_maintenance') == 'CCTV' ? 'selected' : '' }}>CCTV</option>
            <option value="IoT" {{ old('jenis_maintenance') == 'IoT' ? 'selected' : '' }}>IoT</option>
            <option value="VPN" {{ old('jenis_maintenance') == 'VPN' ? 'selected' : '' }}>VPN</option>
            <option value="Other" {{ old('jenis_maintenance') == 'Lainnya' ? 'selected' : '' }}>Other</option>
          </select>
          @error('jenis_maintenance')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Problem Description <span class="text-danger">*</span></label>
          <textarea class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" rows="3" required placeholder="Describe the issue in detail">{{ old('deskripsi') }}</textarea>
          @error('deskripsi')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Urgency Level <span class="text-danger">*</span></label>
          <select class="form-select @error('tingkat_urgensi') is-invalid @enderror" name="tingkat_urgensi" required>
            <option value="">Select Urgency Level</option>
            <option value="Low" {{ old('tingkat_urgensi') == 'Low' ? 'selected' : '' }}>Low</option>
            <option value="Medium" {{ old('tingkat_urgensi') == 'Medium' ? 'selected' : '' }}>Medium</option>
            <option value="High" {{ old('tingkat_urgensi') == 'High' ? 'selected' : '' }}>High</option>
            <option value="Critical" {{ old('tingkat_urgensi') == 'Critical' ? 'selected' : '' }}>Critical</option>
          </select>
          @error('tingkat_urgensi')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Request Date <span class="text-danger">*</span></label>
          <input type="date" class="form-control @error('tanggal_permintaan') is-invalid @enderror" name="tanggal_permintaan" value="{{ old('tanggal_permintaan') }}" required />
          @error('tanggal_permintaan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Upload Document (Optional)</label>
          <input type="file" class="form-control @error('dokumen') is-invalid @enderror" name="dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" />
          @error('dokumen')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          <div class="form-text">Accepted formats: PDF, DOC, DOCX, JPG, JPEG, PNG. Max 2MB</div>
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
