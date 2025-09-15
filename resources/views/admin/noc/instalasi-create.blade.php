<x-layouts.admin title="Tambah Instalasi NOC">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold">Tambah Permintaan Instalasi</h2>
        <p class="text-gray-600 dark:text-gray-400">Form untuk menambahkan permintaan instalasi jaringan baru</p>
    </div>

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

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            <form action="{{ route('admin.noc.instalasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nomor Tiket -->
                    <div>
                        <label for="nomor_tiket" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Nomor Tiket
                        </label>
                        <input type="text"
                               name="nomor_tiket"
                               id="nomor_tiket"
                               value="{{ old('nomor_tiket', \App\Helpers\TicketNumberGenerator::generateForType('instalasi')) }}"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('nomor_tiket') border-red-500 @enderror"
                               readonly>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Nomor tiket akan diisi otomatis</p>
                        @error('nomor_tiket')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Tenant -->
                    <div>
                        <label for="nomor_tenant" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tenant ID / Contract Number <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="nomor_tenant"
                               id="nomor_tenant"
                               value="{{ old('nomor_tenant') }}"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('nomor_tenant') border-red-500 @enderror"
                               required>
                        @error('nomor_tenant')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nama Perusahaan -->
                    <div>
                        <label for="nama_perusahaan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tenant Company Name <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="nama_perusahaan"
                               id="nama_perusahaan"
                               value="{{ old('nama_perusahaan') }}"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('nama_perusahaan') border-red-500 @enderror"
                               required>
                        @error('nama_perusahaan')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kontak Person -->
                    <div>
                        <label for="kontak_person" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Contact Person <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="kontak_person"
                               id="kontak_person"
                               value="{{ old('kontak_person') }}"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('kontak_person') border-red-500 @enderror"
                               required>
                        @error('kontak_person')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Email <span class="text-danger">*</span>
                        </label>
                        <input type="email"
                               name="email"
                               id="email"
                               value="{{ old('email') }}"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('email') border-red-500 @enderror"
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ISP Name -->
                    <div>
                        <label for="nama_isp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            ISP Name
                        </label>
                        <select name="nama_isp" id="nama_isp"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('nama_isp') border-red-500 @enderror">
                            <option value="">Select ISP Name</option>
                            <option value="iForte" {{ old('nama_isp') == 'iForte' ? 'selected' : '' }}>iForte</option>
                            <option value="Telkom" {{ old('nama_isp') == 'Telkom' ? 'selected' : '' }}>Telkom</option>
                            <option value="Tower Bersama" {{ old('nama_isp') == 'Tower Bersama' ? 'selected' : '' }}>Tower Bersama</option>
                            <option value="Icon+" {{ old('nama_isp') == 'Icon+' ? 'selected' : '' }}>Icon+</option>
                            <option value="SIMS" {{ old('nama_isp') == 'SIMS' ? 'selected' : '' }}>SIMS</option>
                        </select>
                        @error('nama_isp')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NPWP -->
                    <div>
                        <label for="nomor_npwp" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tax Identification Number (NPWP)
                        </label>
                        <input type="text"
                               name="nomor_npwp"
                               id="nomor_npwp"
                               value="{{ old('nomor_npwp') }}"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('nomor_npwp') border-red-500 @enderror"
                               placeholder="00.000.000.0-000.000">
                        @error('nomor_npwp')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lokasi Instalasi -->
                    <div>
                        <label for="lokasi_instalasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Installation Location <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="lokasi_instalasi"
                               id="lokasi_instalasi"
                               value="{{ old('lokasi_instalasi') }}"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('lokasi_instalasi') border-red-500 @enderror"
                               required>
                        @error('lokasi_instalasi')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Lokasi Pemasangan -->
                    <div>
                        <label for="lokasi_pemasangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Placement Location
                        </label>
                        <select name="lokasi_pemasangan" id="lokasi_pemasangan"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('lokasi_pemasangan') border-red-500 @enderror">
                            <option value="">Select Placement Location</option>
                            <option value="BPSP / FSP" {{ old('lokasi_pemasangan') == 'BPSP / FSP' ? 'selected' : '' }}>BPSP / FSP</option>
                            <option value="Kavling" {{ old('lokasi_pemasangan') == 'Kavling' ? 'selected' : '' }}>Kavling</option>
                            <option value="Gedung Pengelola / Office Management" {{ old('lokasi_pemasangan') == 'Gedung Pengelola / Office Management' ? 'selected' : '' }}>Office Management Building</option>
                            <option value="Tower Rusun" {{ old('lokasi_pemasangan') == 'Tower Rusun' ? 'selected' : '' }}>Apartment Tower</option>
                        </select>
                        @error('lokasi_pemasangan')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nomor Telepon -->
                    <div>
                        <label for="nomor_telepon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Phone Number <span class="text-danger">*</span>
                        </label>
                        <input type="text"
                               name="nomor_telepon"
                               id="nomor_telepon"
                               value="{{ old('nomor_telepon') }}"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('nomor_telepon') border-red-500 @enderror"
                               required>
                        @error('nomor_telepon')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Layanan -->
                    <div>
                        <label for="jenis_layanan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Service Type <span class="text-danger">*</span>
                        </label>
                        <select name="jenis_layanan" id="jenis_layanan" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('jenis_layanan') border-red-500 @enderror">
                            <option value="">Select Service Type</option>
                            <option value="Dedicated" {{ old('jenis_layanan') == 'Dedicated' ? 'selected' : '' }}>Dedicated</option>
                            <option value="Broadband" {{ old('jenis_layanan') == 'Broadband' ? 'selected' : '' }}>Broadband</option>
                        </select>
                        @error('jenis_layanan')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Kecepatan Bandwidth -->
                    <div>
                        <label for="kecepatan_bandwidth" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Bandwidth Speed
                        </label>
                        <input type="text"
                               name="kecepatan_bandwidth"
                               id="kecepatan_bandwidth"
                               value="{{ old('kecepatan_bandwidth') }}"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('kecepatan_bandwidth') border-red-500 @enderror">
                        @error('kecepatan_bandwidth')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Skema Topologi -->
                    <div>
                        <label for="skema_topologi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Topology Scheme
                        </label>
                        <select name="skema_topologi" id="skema_topologi"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('skema_topologi') border-red-500 @enderror">
                            <option value="">Select Topology Scheme</option>
                            <option value="FTTx (BPSP, Rusunawa dan Gedung Pengelola)" {{ old('skema_topologi') == 'FTTx (BPSP, Rusunawa dan Gedung Pengelola)' ? 'selected' : '' }}>FTTx (BPSP, Apartment, Office Management)</option>
                            <option value="Direct Core / Konvensional (Pabrik / Manufaktur)" {{ old('skema_topologi') == 'Direct Core / Konvensional (Pabrik / Manufaktur)' ? 'selected' : '' }}>Direct Core / Conventional (Factory / Manufacturing)</option>
                        </select>
                        @error('skema_topologi')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tingkat Urgensi -->
                    <div>
                        <label for="tingkat_urgensi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Urgency Level <span class="text-danger">*</span>
                        </label>
                        <select name="tingkat_urgensi" id="tingkat_urgensi" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('tingkat_urgensi') border-red-500 @enderror">
                            <option value="">Select Urgency Level</option>
                            <option value="Low" {{ old('tingkat_urgensi') == 'Low' ? 'selected' : '' }}>Low</option>
                            <option value="Medium" {{ old('tingkat_urgensi') == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="High" {{ old('tingkat_urgensi') == 'High' ? 'selected' : '' }}>High</option>
                            <option value="Critical" {{ old('tingkat_urgensi') == 'Critical' ? 'selected' : '' }}>Critical</option>
                        </select>
                        @error('tingkat_urgensi')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Permintaan (Auto-filled like maintenance) -->
                    <div>
                        <label for="tanggal_permintaan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Tanggal Permintaan
                        </label>
                        <input type="date"
                               name="tanggal_permintaan"
                               id="tanggal_permintaan"
                               value="{{ old('tanggal_permintaan', now()->toDateString()) }}"
                               class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('tanggal_permintaan') border-red-500 @enderror"
                               required>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tanggal permintaan akan diisi otomatis seperti di maintenance</p>
                        @error('tanggal_permintaan')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Status
                        </label>
                        <select name="status" id="status" required
                                class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('status') border-red-500 @enderror">
                            <option value="Diterima" {{ old('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                            <option value="Proses" {{ old('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                            <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Ditolak" {{ old('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Catatan Tambahan -->
                <div class="mt-6">
                    <label for="catatan_tambahan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Additional Notes
                    </label>
                    <textarea name="catatan_tambahan"
                              id="catatan_tambahan"
                              rows="3"
                              class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500 @error('catatan_tambahan') border-red-500 @enderror"
                              placeholder="Catatan tambahan...">{{ old('catatan_tambahan') }}</textarea>
                    @error('catatan_tambahan')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dokumen -->
                <div class="mt-6">
                    <label for="dokumen" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Upload Document (optional)
                    </label>
                    <input type="file"
                           name="dokumen"
                           id="dokumen"
                           accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                           class="w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300 @error('dokumen') border-red-500 @enderror">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: PDF, DOC, DOCX, JPG, PNG. Maksimal 2MB</p>
                    @error('dokumen')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mt-6 flex space-x-3">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Submit Request
                    </button>
                    <a href="{{ route('admin.noc.instalasi') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
