<x-layouts.frontend>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Form Pengajuan Instalasi Jaringan
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Silakan isi form berikut untuk mengajukan instalasi jaringan baru
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

            <form action="{{ route('noc.instalasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf
                
                <!-- Data Perusahaan -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Data Perusahaan</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="nama_perusahaan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nama Perusahaan Tenant <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nama_perusahaan" id="nama_perusahaan" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label for="nomor_tenant" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nomor Tenant ID / Nomor Kontrak <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nomor_tenant" id="nomor_tenant" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="kontak_person" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Kontak Person <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="kontak_person" id="kontak_person" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label for="nomor_telepon" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Nomor Telepon <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="nomor_telepon" id="nomor_telepon" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <!-- Detail Instalasi -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Detail Instalasi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="lokasi_instalasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Lokasi Instalasi <span class="text-red-500">*</span>
                            </label>
                            <textarea name="lokasi_instalasi" id="lokasi_instalasi" rows="3" required 
                                      class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" 
                                      placeholder="Alamat lengkap lokasi instalasi"></textarea>
                        </div>
                        <div>
                            <label for="jenis_layanan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Jenis Layanan <span class="text-red-500">*</span>
                            </label>
                            <select name="jenis_layanan" id="jenis_layanan" required 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Pilih Jenis Layanan</option>
                                <option value="Internet">Internet</option>
                                <option value="CCTV">CCTV</option>
                                <option value="IoT">IoT</option>
                                <option value="VPN">VPN</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div id="bandwidth-container" style="display: none;">
                            <label for="kecepatan_bandwidth" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Kecepatan Bandwidth <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="kecepatan_bandwidth" id="kecepatan_bandwidth"
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                        <div>
                            <label for="tingkat_urgensi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tingkat Urgensi <span class="text-red-500">*</span>
                            </label>
                            <select name="tingkat_urgensi" id="tingkat_urgensi" required
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Pilih Tingkat Urgensi</option>
                                <option value="Low">Low</option>
                                <option value="Medium" selected>Medium</option>
                                <option value="High">High</option>
                                <option value="Critical">Critical</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label for="tanggal_permintaan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tanggal Permintaan <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_permintaan" id="tanggal_permintaan" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>
                </div>

                <!-- Catatan Tambahan -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Catatan Tambahan</h3>
                    <div>
                        <label for="catatan_tambahan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Catatan Tambahan
                        </label>
                        <textarea name="catatan_tambahan" id="catatan_tambahan" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" 
                                  placeholder="Informasi tambahan terkait permintaan instalasi"></textarea>
                    </div>
                </div>

                <!-- Upload Dokumen -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Upload Dokumen</h3>
                    <div>
                        <label for="dokumen" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Upload Dokumen (Opsional)
                        </label>
                        <input type="file" name="dokumen" id="dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" 
                               class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: PDF, DOC, DOCX, JPG, PNG. Maksimal 2MB</p>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Kirim Permintaan Instalasi
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const jenisLayananSelect = document.getElementById('jenis_layanan');
            const bandwidthContainer = document.getElementById('bandwidth-container');
            const bandwidthInput = document.getElementById('kecepatan_bandwidth');

            function toggleBandwidth() {
                if (jenisLayananSelect.value === 'Internet') {
                    bandwidthContainer.style.display = 'block';
                    bandwidthInput.setAttribute('required', 'required');
                } else {
                    bandwidthContainer.style.display = 'none';
                    bandwidthInput.removeAttribute('required');
                    bandwidthInput.value = '';
                }
            }

            jenisLayananSelect.addEventListener('change', toggleBandwidth);

            // Initialize on page load
            toggleBandwidth();
        });
    </script>
</x-layouts.frontend>
