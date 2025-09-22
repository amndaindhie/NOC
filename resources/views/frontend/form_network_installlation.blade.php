@extends('frontend.layout')

@section('body_class', 'bg-light')

@section('title', 'Network Installation Request')

@section('content')

  <!-- Page Title -->
  <div class="page-title dark-background">
    <div class="container position-relative">
      <h1>Network Installation Request</h1>
      <p>
        Please fill out the form below to request a new service installation.
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

    {{--@if($errors->any())
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        <strong>An error occurred:</strong>
        <ul class="mb-0 mt-2">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
    @endif--}}

    <div class="form-section">
      <form method="POST" action="{{ route('noc.instalasi.store') }}" enctype="multipart/form-data" onsubmit="return checkAuth()" novalidate @if($errors->any()) class="was-validated" @endif>
        @csrf
        <div class="mb-3">
          <label class="form-label">Tenant Company Name <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('nama_perusahaan') is-invalid @enderror" name="nama_perusahaan" value="{{ old('nama_perusahaan') }}" required />
          @error('nama_perusahaan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Tenant ID / Contract Number <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('nomor_tenant') is-invalid @enderror" name="nomor_tenant" value="{{ old('nomor_tenant') }}" required />
          @error('nomor_tenant')
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
          <small class="form-text text-muted">The email will be automatically filled from your account</small>
        </div>
        <div class="mb-3">
          <label class="form-label">ISP Name <span class="text-danger">*</span></label>
          <select class="form-select @error('nama_isp') is-invalid @enderror" name="nama_isp" required>
            <option value="">Select ISP Name</option>
            <option value="iForte" {{ old('nama_isp') == 'iForte' ? 'selected' : '' }}>iForte</option>
            <option value="Telkom" {{ old('nama_isp') == 'Telkom' ? 'selected' : '' }}>Telkom</option>
            <option value="Tower Bersama" {{ old('nama_isp') == 'Tower Bersama' ? 'selected' : '' }}>Tower Bersama</option>
            <option value="Icon+" {{ old('nama_isp') == 'Icon+' ? 'selected' : '' }}>Icon+</option>
            <option value="SIMS" {{ old('nama_isp') == 'SIMS' ? 'selected' : '' }}>SIMS</option>
          </select>
          @error('nama_isp')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Tax Identification Number (NPWP) <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('nomor_npwp') is-invalid @enderror" name="nomor_npwp" value="{{ old('nomor_npwp') }}" placeholder="00.000.000.0-000.000" required />
          @error('nomor_npwp')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Installation Location <span class="text-danger">*</span></label>
          <textarea class="form-control @error('lokasi_instalasi') is-invalid @enderror" name="lokasi_instalasi" rows="2" required>{{ old('lokasi_instalasi') }}</textarea>
          @error('lokasi_instalasi')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Placement Location <span class="text-danger">*</span></label>
          <select class="form-select @error('lokasi_pemasangan') is-invalid @enderror" name="lokasi_pemasangan" required>
            <option value="">Select Placement Location</option>
            <option value="BPSP / FSP" {{ old('lokasi_pemasangan') == 'BPSP / FSP' ? 'selected' : '' }}>BPSP / FSP</option>
            <option value="Kavling" {{ old('lokasi_pemasangan') == 'Kavling' ? 'selected' : '' }}>Kavling</option>
            <option value="Gedung Pengelola / Office Management" {{ old('lokasi_pemasangan') == 'Gedung Pengelola / Office Management' ? 'selected' : '' }}>Office Management Building</option>
            <option value="Tower Rusun" {{ old('lokasi_pemasangan') == 'Tower Rusun' ? 'selected' : '' }}>Apartment Tower</option>
          </select>
          @error('lokasi_pemasangan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Phone Number <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('nomor_telepon') is-invalid @enderror" name="nomor_telepon" value="{{ old('nomor_telepon') }}" required />
          @error('nomor_telepon')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Service Type <span class="text-danger">*</span></label>
          <select class="form-select @error('jenis_layanan') is-invalid @enderror" name="jenis_layanan" required>
            <option value="">Select Service Type</option>
            <option value="Dedicated" {{ old('jenis_layanan') == 'Dedicated' ? 'selected' : '' }}>Dedicated</option>
            <option value="Broadband" {{ old('jenis_layanan') == 'Broadband' ? 'selected' : '' }}>Broadband</option>
          </select>
          @error('jenis_layanan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Bandwidth Speed <span class="text-danger">*</span></label>
          <input type="text" class="form-control @error('kecepatan_bandwidth') is-invalid @enderror" name="kecepatan_bandwidth" value="{{ old('kecepatan_bandwidth') }}" required />
          @error('kecepatan_bandwidth')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Topology Scheme <span class="text-danger">*</span></label>
          <select class="form-select @error('skema_topologi') is-invalid @enderror" name="skema_topologi" required>
            <option value="">Select Topology Scheme</option>
            <option value="FTTx (BPSP, Rusunawa dan Gedung Pengelola)" {{ old('skema_topologi') == 'FTTx (BPSP, Rusunawa dan Gedung Pengelola)' ? 'selected' : '' }}>FTTx (BPSP, Apartment, Office Management)</option>
            <option value="Direct Core / Konvensional (Pabrik / Manufaktur)" {{ old('skema_topologi') == 'Direct Core / Konvensional (Pabrik / Manufaktur)' ? 'selected' : '' }}>Direct Core / Conventional (Factory / Manufacturing)</option>
          </select>
          @error('skema_topologi')
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
          <label class="form-label">Additional Notes</label>
          <textarea class="form-control @error('catatan_tambahan') is-invalid @enderror" name="catatan_tambahan" rows="3">{{ old('catatan_tambahan') }}</textarea>
          @error('catatan_tambahan')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="mb-3">
          <label class="form-label">Upload Document (optional)</label>
          <input type="file" class="form-control @error('dokumen') is-invalid @enderror" name="dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" />
          @error('dokumen')
            <div class="invalid-feedback">{{ $message }}</div>
          @enderror
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary btn-noc">
            Submit Request
          </button>
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
