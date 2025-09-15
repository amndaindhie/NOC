<x-layouts.frontend>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Form Pengajuan Keluhan Jaringan
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Silakan isi form berikut untuk melaporkan keluhan jaringan
                </p>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">Sukses!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">Error!</strong>
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                    <strong class="font-bold">Terdapat kesalahan:</strong>
                    <ul class="mt-1 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('noc.keluhan.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Data Tenant -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Data Tenant</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nama_tenant" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nama Tenant <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_tenant" id="nama_tenant" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   value="{{ old('nama_tenant') }}">
                        </div>
                        <div>
                            <label for="nomor_tenant" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nomor Tenant ID / Nomor Kontrak <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nomor_tenant" id="nomor_tenant" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   value="{{ old('nomor_tenant') }}">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="kontak_person" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Kontak Person <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="kontak_person" id="kontak_person" required 
                               class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                               value="{{ old('kontak_person') }}">
                    </div>
                </div>

                <!-- Detail Keluhan -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Detail Keluhan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="jenis_gangguan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Jenis Gangguan <span class="text-red-500">*</span>
                            </label>
                            <select name="jenis_gangguan" id="jenis_gangguan" required 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Pilih Jenis Gangguan</option>
                                <option value="Internet Tidak Terhubung" {{ old('jenis_gangguan') == 'Internet Tidak Terhubung' ? 'selected' : '' }}>Internet Tidak Terhubung</option>
                                <option value="Kecepatan Lambat" {{ old('jenis_gangguan') == 'Kecepatan Lambat' ? 'selected' : '' }}>Kecepatan Lambat</option>
                                <option value="Koneksi Terputus" {{ old('jenis_gangguan') == 'Koneksi Terputus' ? 'selected' : '' }}>Koneksi Terputus</option>
                                <option value="CCTV Tidak Berfungsi" {{ old('jenis_gangguan') == 'CCTV Tidak Berfungsi' ? 'selected' : '' }}>CCTV Tidak Berfungsi</option>
                                <option value="IoT Tidak Merespon" {{ old('jenis_gangguan') == 'IoT Tidak Merespon' ? 'selected' : '' }}>IoT Tidak Merespon</option>
                                <option value="VPN Tidak Terhubung" {{ old('jenis_gangguan') == 'VPN Tidak Terhubung' ? 'selected' : '' }}>VPN Tidak Terhubung</option>
                                <option value="Lainnya" {{ old('jenis_gangguan') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label for="waktu_mulai_gangguan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Waktu Mulai Gangguan <span class="text-red-500">*</span>
                            </label>
                            <input type="datetime-local" name="waktu_mulai_gangguan" id="waktu_mulai_gangguan" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   value="{{ old('waktu_mulai_gangguan') }}">
                        </div>
                    </div>

                    <div class="mt-4">
                        <label for="deskripsi_gangguan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Deskripsi Gangguan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="deskripsi_gangguan" id="deskripsi_gangguan" rows="4" required 
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                  placeholder="Jelaskan secara detail gangguan yang terjadi">{{ old('deskripsi_gangguan') }}</textarea>
                    </div>
                </div>

                <!-- Upload Bukti -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Upload Bukti</h3>
                    <div>
                        <label for="bukti" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Upload Bukti Gangguan (Opsional)
                        </label>
                        <input type="file" name="bukti" id="bukti" accept=".jpg,.jpeg,.png,.pdf" 
                               class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: JPG, JPEG, PNG, PDF. Maksimal 2MB</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Kirim Keluhan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.frontend>
