@extends('frontend.layout')

@section('title', 'Network Complaints Form - Network Operation Center - KITB')

@section('content')

  <!-- Page Title -->
  <div class="page-title dark-background">
    <div class="container position-relative">
      <h1>Network Complaints</h1>
      <p>
        Please fill out the form below to report network issues.
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
      <form method="POST" action="{{ route('noc.keluhan.store') }}" enctype="multipart/form-data" onsubmit="return checkAuth()" novalidate>
        @csrf

        <div class="mb-3">
          <label class="form-label">Tenant ID Number / Contract Number <span class="text-danger">*</span></label>
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
          <label class="form-label">Contact Person <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('kontak_person') is-invalid @enderror" name="kontak_person" value="{{ old('kontak_person') }}" required />
          @error('kontak_person')
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
          <label class="form-label">Issue Type <span class="text-danger">*</span></label>
          <select class="form-select @error('jenis_gangguan') is-invalid @enderror" name="jenis_gangguan" required>
            <option value="">Select Issue Type</option>
            <option value="Internet Tidak Terhubung" {{ old('jenis_gangguan') == 'Internet Tidak Terhubung' ? 'selected' : '' }}>Internet Not Connected</option>
            <option value="Kecepatan Lambat" {{ old('jenis_gangguan') == 'Kecepatan Lambat' ? 'selected' : '' }}>Slow Connection</option>
            <option value="Koneksi Terputus" {{ old('jenis_gangguan') == 'Koneksi Terputus' ? 'selected' : '' }}>Intermittent Connection</option>
            <option value="CCTV Tidak Berfungsi" {{ old('jenis_gangguan') == 'CCTV Tidak Berfungsi' ? 'selected' : '' }}>CCTV Not Working</option>
            <option value="IoT Tidak Merespon" {{ old('jenis_gangguan') == 'IoT Tidak Merespon' ? 'selected' : '' }}>IoT Not Responding</option>
            <option value="VPN Tidak Terhubung" {{ old('jenis_gangguan') == 'VPN Tidak Terhubung' ? 'selected' : '' }}>VPN Not Connected</option>
            <option value="Lainnya" {{ old('jenis_gangguan') == 'Lainnya' ? 'selected' : '' }}>Others</option>
          </select>
          @error('jenis_gangguan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Issue Start Time <span class="text-danger">*</span></label>
          <input type="datetime-local" class="form-control @error('waktu_mulai_gangguan') is-invalid @enderror" name="waktu_mulai_gangguan" value="{{ old('waktu_mulai_gangguan') }}" required />
          @error('waktu_mulai_gangguan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>

        <div class="mb-3">
          <label class="form-label">Issue Description <span class="text-danger">*</span></label>
          <textarea class="form-control @error('deskripsi_gangguan') is-invalid @enderror" name="deskripsi_gangguan" rows="4" required placeholder="Describe the issue in detail">{{ old('deskripsi_gangguan') }}</textarea>
          @error('deskripsi_gangguan')
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
          <label class="form-label">Upload Evidence (Optional)</label>
          <input type="file" class="form-control @error('bukti') is-invalid @enderror" name="bukti" accept=".jpg,.jpeg,.png,.pdf" />
          @error('bukti')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
          <div class="form-text">Format: JPG, JPEG, PNG, PDF. Max 2MB</div>
        </div>

        <div class="text-center">
          <button type="submit" class="btn btn-noc">Submit Complaint</button>
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
