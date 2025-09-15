<x-layouts.frontend>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-12">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">
                    Form Pengajuan Terminasi Layanan
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400">
                    Silakan isi form berikut untuk mengajukan terminasi layanan jaringan
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

            <form action="{{ route('noc.terminasi.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                        <label for="lokasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Lokasi Layanan <span class="text-red-500">*</span>
                        </label>
                        <textarea name="lokasi" id="lokasi" rows="3" required 
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" 
                                  placeholder="Alamat lengkap lokasi layanan yang akan dihentikan">{{ old('lokasi') }}</textarea>
                    </div>
                </div>

                <!-- Detail Terminasi -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Detail Terminasi</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="alasan_terminasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Alasan Terminasi <span class="text-red-500">*</span>
                            </label>
                            <select name="alasan_terminasi" id="alasan_terminasi" required 
                                    class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                <option value="">Pilih Alasan Terminasi</option>
                                <option value="Pindah Lokasi" {{ old('alasan_terminasi') == 'Pindah Lokasi' ? 'selected' : '' }}>Pindah Lokasi</option>
                                <option value="Tidak Membutuhkan Layanan" {{ old('alasan_terminasi') == 'Tidak Membutuhkan Layanan' ? 'selected' : '' }}>Tidak Membutuhkan Layanan</option>
                                <option value="Pindah Provider" {{ old('alasan_terminasi') == 'Pindah Provider' ? 'selected' : '' }}>Pindah Provider</option>
                                <option value="Masalah Teknis" {{ old('alasan_terminasi') == 'Masalah Teknis' ? 'selected' : '' }}>Masalah Teknis</option>
                                <option value="Lainnya" {{ old('alasan_terminasi') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label for="tanggal_efektif" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Tanggal Efektif Terminasi <span class="text-red-500">*</span>
                            </label>
                            <input type="date" name="tanggal_efektif" id="tanggal_efektif" required 
                                   class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                   value="{{ old('tanggal_efektif') }}">
                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tanggal mulai berlakunya terminasi layanan</p>
                        </div>
                    </div>

                    <div class="mt-4" id="alasan_lainnya_container" style="display: none;">
                        <label for="alasan_lainnya" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Jelaskan Alasan Lainnya <span class="text-red-500">*</span>
                        </label>
                        <textarea name="alasan_lainnya" id="alasan_lainnya" rows="3" 
                                  class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white" 
                                  placeholder="Jelaskan alasan terminasi secara detail...">{{ old('alasan_lainnya') }}</textarea>
                    </div>
                </div>

                <!-- Upload Dokumen -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Upload Dokumen</h3>
                    <div>
                        <label for="dokumen" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Upload Dokumen Pendukung (Opsional)
                        </label>
                        <input type="file" name="dokumen" id="dokumen" accept=".pdf,.doc,.docx" 
                               class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: PDF, DOC, DOCX. Maksimal 2MB</p>
                    </div>
                </div>

                <!-- Konfirmasi -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Konfirmasi</h3>
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input type="checkbox" name="konfirmasi_setuju" id="konfirmasi_setuju" value="1" required 
                                   class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                   {{ old('konfirmasi_setuju') ? 'checked' : '' }}>
                        </div>
                        <div class="ml-3 text-sm">
                            <label for="konfirmasi_setuju" class="font-medium text-gray-700 dark:text-gray-300">
                                Saya menyetujui bahwa pengajuan terminasi ini akan mempengaruhi layanan jaringan dan mungkin dikenakan biaya sesuai ketentuan yang berlaku.
                            </label>
                            <p class="mt-1 text-gray-500 dark:text-gray-400">
                                Dengan mencentang kotak ini, saya mengkonfirmasi bahwa semua informasi yang diberikan adalah benar dan sah.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                        Kirim Pengajuan Terminasi
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Toggle alasan lainnya jika dipilih
        document.getElementById('alasan_terminasi').addEventListener('change', function() {
            const alasanLainnyaContainer = document.getElementById('alasan_lainnya_container');
            const alasanLainnyaInput = document.getElementById('alasan_lainnya');
            
            if (this.value === 'Lainnya') {
                alasanLainnyaContainer.style.display = 'block';
                alasanLainnyaInput.setAttribute('required', 'required');
            } else {
                alasanLainnyaContainer.style.display = 'none';
                alasanLainnyaInput.removeAttribute('required');
                alasanLainnyaInput.value = '';
            }
        });

        // Set default date untuk tanggal efektif (minimal hari ini)
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('tanggal_efektif').setAttribute('min', today);
            
            // Handle alasan lainnya jika sudah dipilih sebelumnya
            const alasanTerminasi = document.getElementById('alasan_terminasi');
            const alasanLainnyaContainer = document.getElementById('alasan_lainnya_container');
            const alasanLainnyaInput = document.getElementById('alasan_lainnya');
            
            if (alasanTerminasi.value === 'Lainnya') {
                alasanLainnyaContainer.style.display = 'block';
                alasanLainnyaInput.setAttribute('required', 'required');
            }
        });
    </script>
</x-layouts.frontend>
