<x-layouts.admin title="Tambah Keluhan Baru">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold">Tambah Keluhan Baru</h2>
                <p class="text-gray-600 dark:text-gray-400">Form untuk menambahkan keluhan jaringan dari tenant.</p>
            </div>
            <div>
                <a href="{{ route('admin.noc.keluhan') }}" class="btn-secondary flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            <form action="{{ route('admin.noc.keluhan.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Informasi Tenant -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Informasi Tenant</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="nomor_tenant" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nomor Tenant <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nomor_tenant" id="nomor_tenant" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    value="{{ old('nomor_tenant') }}" required>
                                @error('nomor_tenant')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="nama_tenant" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nama Tenant <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_tenant" id="nama_tenant" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    value="{{ old('nama_tenant') }}" required>
                                @error('nama_tenant')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="kontak_person" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Kontak Person <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="kontak_person" id="kontak_person" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    value="{{ old('kontak_person') }}" required>
                                @error('kontak_person')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Detail Keluhan -->
                    <div>
                        <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Detail Keluhan</h3>
                        
                        <div class="space-y-4">
                            <div>
                                <label for="nomor_tiket" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Nomor Tiket <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nomor_tiket" id="nomor_tiket" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white bg-gray-100 dark:bg-gray-600 cursor-not-allowed"
                                    value="{{ old('nomor_tiket', \App\Helpers\TicketNumberGenerator::generateForType('keluhan')) }}" required readonly>
                                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Nomor tiket akan diisi otomatis</p>
                                @error('nomor_tiket')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="jenis_gangguan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Jenis Gangguan <span class="text-red-500">*</span>
                                </label>
                                <select name="jenis_gangguan" id="jenis_gangguan" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                                    <option value="">Pilih Jenis Gangguan</option>
                                    <option value="Internet Tidak Terhubung" {{ old('jenis_gangguan') == 'Internet Tidak Terhubung' ? 'selected' : '' }}>Internet Tidak Terhubung</option>
                                    <option value="Kecepatan Lambat" {{ old('jenis_gangguan') == 'Kecepatan Lambat' ? 'selected' : '' }}>Kecepatan Lambat</option>
                                    <option value="Koneksi Terputus" {{ old('jenis_gangguan') == 'Koneksi Terputus' ? 'selected' : '' }}>Koneksi Terputus</option>
                                    <option value="CCTV Tidak Berfungsi" {{ old('jenis_gangguan') == 'CCTV Tidak Berfungsi' ? 'selected' : '' }}>CCTV Tidak Berfungsi</option>
                                    <option value="Lainnya" {{ old('jenis_gangguan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('jenis_gangguan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="waktu_mulai_gangguan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Waktu Mulai Gangguan <span class="text-red-500">*</span>
                                </label>
                                <input type="datetime-local" name="waktu_mulai_gangguan" id="waktu_mulai_gangguan" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    value="{{ old('waktu_mulai_gangguan') }}" required>
                                @error('waktu_mulai_gangguan')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    Status <span class="text-red-500">*</span>
                                </label>
                                <select name="status" id="status" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                                    required>
                                    <option value="Diterima" {{ old('status') == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                    <option value="Proses" {{ old('status') == 'Proses' ? 'selected' : '' }}>Proses</option>
                                    <option value="Selesai" {{ old('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                    <option value="Ditolak" {{ old('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Deskripsi Gangguan -->
                <div class="mt-6">
                    <label for="deskripsi_gangguan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Deskripsi Gangguan <span class="text-red-500">*</span>
                    </label>
                    <textarea name="deskripsi_gangguan" id="deskripsi_gangguan" rows="4" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                        required>{{ old('deskripsi_gangguan') }}</textarea>
                    @error('deskripsi_gangguan')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Upload Dokumen -->
                <div class="mt-6">
                    <label for="bukti_path" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        Upload Bukti (Opsional)
                    </label>
                    <input type="file" name="bukti_path" id="bukti_path" 
                        class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        accept="image/*,.pdf,.doc,.docx">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: JPG, PNG, PDF, DOC (Max 2MB)</p>
                    @error('bukti_path')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="{{ route('admin.noc.keluhan') }}" 
                        class="btn-secondary px-4 py-2 rounded-md">
                        Batal
                    </a>
                    <button type="submit" 
                        class="btn-primary px-4 py-2 rounded-md">
                        Simpan Keluhan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>
