<x-layouts.admin title="Tambah Maintenance">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold">Tambah Permintaan Maintenance</h2>
        <p class="text-gray-600 dark:text-gray-400">Form untuk menambahkan permintaan maintenance baru</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            <form action="{{ route('admin.noc.maintenance.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nomor_tracking" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Tracking</label>
                        <input type="text" name="nomor_tracking" id="nomor_tracking" required
                               value="{{ \App\Helpers\TicketNumberGenerator::generateForType('maintenance') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100 dark:bg-gray-600 cursor-not-allowed"
                               readonly>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Nomor tracking akan diisi otomatis</p>
                    </div>

                    <div>
                        <label for="nomor_tenant" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Tenant</label>
                        <input type="text" name="nomor_tenant" id="nomor_tenant" required
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Contoh: TN-001">
                    </div>

                    <div>
                        <label for="nama_tenant" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Tenant</label>
                        <input type="text" name="nama_tenant" id="nama_tenant" required
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Nama lengkap tenant">
                    </div>

                    <div>
                        <label for="jenis_maintenance" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Maintenance</label>
                        <select name="jenis_maintenance" id="jenis_maintenance" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Pilih Jenis Maintenance</option>
                            <option value="Internet">Koneksi Internet</option>
                            <option value="CCTV">Perangkat CCTV</option>
                            <option value="IoT">Perangkat IoT</option>
                            <option value="VPN">VPN</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div>
                        <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" id="tanggal_mulai" required
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="tanggal_selesai" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" id="tanggal_selesai"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="tingkat_urgensi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tingkat Urgensi</label>
                        <select name="tingkat_urgensi" id="tingkat_urgensi" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                onchange="updateUrgencyIndicator(this.value)">
                            <option value="">Pilih Tingkat Urgensi</option>
                            <option value="Low" class="text-green-600">Low - Tidak Mendesak</option>
                            <option value="Medium" class="text-yellow-600">Medium - Normal</option>
                            <option value="High" class="text-orange-600">High - Mendesak</option>
                            <option value="Critical" class="text-red-600">Critical - Sangat Mendesak</option>
                        </select>
                        <div id="urgencyIndicator" class="mt-2 text-sm hidden">
                            <span class="px-2 py-1 rounded-full text-xs font-medium"></span>
                        </div>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select name="status" id="status" required
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="Diterima">Diterima</option>
                            <option value="Proses">Proses</option>
                            <option value="Selesai">Selesai</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="lokasi_perangkat" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi Perangkat</label>
                    <input type="text" name="lokasi_perangkat" id="lokasi_perangkat"
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                           placeholder="Contoh: Gedung A, Lantai 3, Ruang Server">
                </div>

                <div class="mt-6">
                    <label for="deskripsi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Maintenance</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4"
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                              placeholder="Jelaskan secara detail masalah yang perlu diperbaiki..."></textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        <span id="charCount">0</span>/500 karakter
                    </p>
                </div>

                <div class="mt-6">
                    <label for="dokumen" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload Dokumen (Opsional)</label>
                    <input type="file" name="dokumen" id="dokumen" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                           class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 dark:file:bg-blue-900 dark:file:text-blue-300">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: PDF, DOC, DOCX, JPG, PNG. Maksimal 2MB</p>
                </div>

                <div class="mt-6 flex space-x-3">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                        Submit
                    </button>
                    <button type="button" onclick="saveDraft()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                        Simpan Draft
                    </button>
                    <a href="{{ route('admin.noc.maintenance') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Character counter for description
        document.getElementById('deskripsi').addEventListener('input', function(e) {
            const charCount = e.target.value.length;
            document.getElementById('charCount').textContent = charCount;
            if (charCount > 500) {
                document.getElementById('charCount').parentElement.classList.add('text-red-500');
            } else {
                document.getElementById('charCount').parentElement.classList.remove('text-red-500');
            }
        });

        // Urgency indicator
        function updateUrgencyIndicator(value) {
            const indicator = document.getElementById('urgencyIndicator');
            const span = indicator.querySelector('span');
            
            if (value) {
                indicator.classList.remove('hidden');
                const colors = {
                    'Low': 'bg-green-100 text-green-800',
                    'Medium': 'bg-yellow-100 text-yellow-800',
                    'High': 'bg-orange-100 text-orange-800',
                    'Critical': 'bg-red-100 text-red-800'
                };
                const texts = {
                    'Low': 'Prioritas Rendah - Dapat ditangani sesuai jadwal',
                    'Medium': 'Prioritas Sedang - Ditangani dalam 1-2 hari',
                    'High': 'Prioritas Tinggi - Ditangani dalam 24 jam',
                    'Critical': 'Prioritas Kritis - Ditangani segera'
                };
                
                span.className = `px-2 py-1 rounded-full text-xs font-medium ${colors[value]}`;
                span.textContent = texts[value];
            } else {
                indicator.classList.add('hidden');
            }
        }

        // Auto-save draft functionality
        function saveDraft() {
            const formData = new FormData(document.querySelector('form'));
            const draftData = {};
            
            for (let [key, value] of formData.entries()) {
                draftData[key] = value;
            }
            
            localStorage.setItem('maintenanceDraft', JSON.stringify(draftData));
            
            // Show success message
            const alert = document.createElement('div');
            alert.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg';
            alert.textContent = 'Draft berhasil disimpan!';
            document.body.appendChild(alert);
            
            setTimeout(() => {
                alert.remove();
            }, 3000);
        }

        // Load draft on page load
        window.addEventListener('load', function() {
            const draft = localStorage.getItem('maintenanceDraft');
            if (draft) {
                const draftData = JSON.parse(draft);
                
                Object.keys(draftData).forEach(key => {
                    const element = document.getElementById(key);
                    if (element) {
                        element.value = draftData[key];
                    }
                });
                
                if (draftData.tingkat_urgensi) {
                    updateUrgencyIndicator(draftData.tingkat_urgensi);
                }
            }
        });

        // Clear draft on successful submission
        document.querySelector('form').addEventListener('submit', function() {
            localStorage.removeItem('maintenanceDraft');
        });

        // Date validation
        document.getElementById('tanggal_mulai').addEventListener('change', function(e) {
            const tanggalMulai = new Date(e.target.value);
            const tanggalSelesai = document.getElementById('tanggal_selesai');
            
            if (tanggalSelesai.value) {
                const selesai = new Date(tanggalSelesai.value);
                if (selesai < tanggalMulai) {
                    tanggalSelesai.value = e.target.value;
                }
            }
            
            // Set min date for tanggal_selesai
            tanggalSelesai.min = e.target.value;
        });
    </script>
</x-layouts.admin>
