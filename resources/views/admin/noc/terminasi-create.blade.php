<x-layouts.admin title="Form Terminasi Layanan">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold">Form Terminasi Layanan</h2>
        <p class="text-gray-600 dark:text-gray-400">Form untuk mengajukan terminasi layanan tenant</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            <form action="{{ route('admin.noc.terminasi.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <!-- Error Display -->
                @if ($errors->any())
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative">
                        <strong class="font-bold">Terjadi kesalahan!</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded relative">
                        <strong class="font-bold">Error:</strong> {{ session('error') }}
                    </div>
                @endif
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="nomor_tiket" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Tiket</label>
                        <input type="text" name="nomor_tiket" id="nomor_tiket" required
                               value="{{ \App\Helpers\TicketNumberGenerator::generateForType('terminasi') }}"
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm bg-gray-100 dark:bg-gray-600 cursor-not-allowed"
                               readonly>
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Nomor tiket otomatis untuk identifikasi permintaan</p>
                    </div>

                    <div>
                        <label for="nomor_tenant_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Tenant *</label>
                        <input type="text" name="nomor_tenant_id" id="nomor_tenant_id" required
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Contoh: TN-001">
                    </div>

                    <div>
                        <label for="nama_tenant" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Tenant *</label>
                        <input type="text" name="nama_tenant" id="nama_tenant" required
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Nama lengkap tenant">
                    </div>

                    <div>
                        <label for="lokasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi *</label>
                        <input type="text" name="lokasi" id="lokasi" required
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="Contoh: Gedung A, Lantai 3, Ruang Server">
                    </div>

                    <div>
                        <label for="tanggal_efektif" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Efektif Terminasi *</label>
                        <input type="date" name="tanggal_efektif" id="tanggal_efektif" required
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Tanggal mulai berlakunya terminasi layanan</p>
                    </div>

                    <div>
                        <label for="prioritas_terminasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Urgensi</label>
                        <select name="prioritas_terminasi" id="prioritas_terminasi"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                                onchange="updatePriorityIndicator(this.value)">
                            <option value="">Pilih Urgensi</option>
                            <option value="Low" class="text-green-600">Low - Tidak Mendesak</option>
                            <option value="Medium" class="text-yellow-600">Medium - Normal</option>
                            <option value="High" class="text-orange-600">High - Mendesak</option>
                            <option value="Critical" class="text-red-600">Critical - Sangat Mendesak</option>
                        </select>
                        <div id="priorityIndicator" class="mt-2 text-sm hidden">
                            <span class="px-2 py-1 rounded-full text-xs font-medium"></span>
                        </div>
                    </div>

                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                        <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="Diajukan">Diajukan</option>
                            <option value="Diproses">Diproses</option>
                            <option value="Disetujui">Disetujui</option>
                            <option value="Ditolak">Ditolak</option>
                            <option value="Selesai">Selesai</option>
                        </select>
                    </div>
                </div>

                <div class="mt-6">
                    <label for="alasan_terminasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alasan Terminasi *</label>
                    <select name="alasan_terminasi" id="alasan_terminasi" required
                            class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                            onchange="toggleAlasanLainnya()">
                        <option value="">Pilih Alasan</option>
                        <option value="Pindah Lokasi">Pindah Lokasi</option>
                        <option value="Tidak Membutuhkan Layanan">Tidak Membutuhkan Layanan Lagi</option>
                        <option value="Pindah Provider">Pindah Provider</option>
                        <option value="Masalah Teknis">Masalah Teknis</option>
                        <option value="Lainnya">Lainnya</option>
                    </select>
                </div>

                <div class="mt-6" id="alasan_lainnya_container" style="display: none;">
                    <label for="alasan_lainnya" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alasan Lainnya *</label>
                    <textarea name="alasan_lainnya" id="alasan_lainnya" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                              placeholder="Jelaskan alasan terminasi secara detail..."></textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        <span id="alasanCharCount">0</span>/300 karakter
                    </p>
                </div>

                <div class="mt-6">
                    <label for="keterangan_tambahan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan Tambahan</label>
                    <textarea name="keterangan_tambahan" id="keterangan_tambahan" rows="3"
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                              placeholder="Informasi tambahan yang perlu diketahui..."></textarea>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                        <span id="keteranganCharCount">0</span>/500 karakter
                    </p>
                </div>

                <div class="mt-6">
                    <label for="dokumen_terminasi" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Upload Dokumen Terminasi Resmi *</label>
                    <input type="file" name="dokumen_terminasi" id="dokumen_terminasi" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required
                           class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100 dark:file:bg-red-900 dark:file:text-red-300">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Format: PDF, DOC, DOCX, JPG, PNG. Maksimal 5MB</p>
                </div>

                <div class="mt-6">
                    <div class="form-check">
                        <input type="checkbox" name="konfirmasi" id="konfirmasi" required
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <label for="konfirmasi" class="ml-2 block text-sm text-gray-900 dark:text-gray-300">
                            Saya setuju untuk penghentian layanan dan memahami bahwa proses ini tidak dapat dibatalkan setelah disubmit.
                        </label>
                    </div>
                </div>

                <div class="mt-6 flex space-x-3">
                    <button type="submit" id="submitBtn" disabled
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-stop-circle mr-2"></i>Submit Terminasi
                    </button>
                    <a href="{{ route('admin.noc.terminasi') }}"
                       class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md">
                        <i class="fas fa-times mr-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Character counter for alasan lainnya
        document.getElementById('alasan_lainnya')?.addEventListener('input', function(e) {
            const charCount = e.target.value.length;
            document.getElementById('alasanCharCount').textContent = charCount;
            if (charCount > 300) {
                document.getElementById('alasanCharCount').parentElement.classList.add('text-red-500');
            } else {
                document.getElementById('alasanCharCount').parentElement.classList.remove('text-red-500');
            }
        });

        // Character counter for keterangan tambahan
        document.getElementById('keterangan_tambahan').addEventListener('input', function(e) {
            const charCount = e.target.value.length;
            document.getElementById('keteranganCharCount').textContent = charCount;
            if (charCount > 500) {
                document.getElementById('keteranganCharCount').parentElement.classList.add('text-red-500');
            } else {
                document.getElementById('keteranganCharCount').parentElement.classList.remove('text-red-500');
            }
        });

        // Priority indicator
        function updatePriorityIndicator(value) {
            const indicator = document.getElementById('priorityIndicator');
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
                    'Low': 'Prioritas Rendah - Proses standar',
                    'Medium': 'Prioritas Sedang - Ditangani dalam 3-5 hari',
                    'High': 'Prioritas Tinggi - Ditangani dalam 1-2 hari',
                    'Critical': 'Prioritas Kritis - Ditangani segera'
                };
                
                span.className = `px-2 py-1 rounded-full text-xs font-medium ${colors[value]}`;
                span.textContent = texts[value];
            } else {
                indicator.classList.add('hidden');
            }
        }

        // Toggle alasan lainnya
        function toggleAlasanLainnya() {
            const alasanTerminasi = document.getElementById('alasan_terminasi');
            const alasanLainnyaContainer = document.getElementById('alasan_lainnya_container');
            const alasanLainnya = document.getElementById('alasan_lainnya');
            
            if (alasanTerminasi.value === 'lainnya') {
                alasanLainnyaContainer.style.display = 'block';
                alasanLainnya.setAttribute('required', 'required');
            } else {
                alasanLainnyaContainer.style.display = 'none';
                alasanLainnya.removeAttribute('required');
                alasanLainnya.value = '';
            }
        }

        // Enable/disable submit button based on checkbox
        document.getElementById('konfirmasi').addEventListener('change', function() {
            document.getElementById('submitBtn').disabled = !this.checked;
        });

        // Date validation
        document.getElementById('tanggal_efektif').addEventListener('change', function(e) {
            const selectedDate = new Date(e.target.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            
            if (selectedDate < today) {
                alert('Tanggal efektif terminasi tidak boleh sebelum hari ini!');
                e.target.value = today.toISOString().split('T')[0];
            }
        });

        // Auto-save draft functionality
        function saveDraft() {
            const formData = new FormData(document.querySelector('form'));
            const draftData = {};
            
            for (let [key, value] of formData.entries()) {
                draftData[key] = value;
            }
            
            localStorage.setItem('terminasiDraft', JSON.stringify(draftData));
            
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
            // Set default date for tanggal efektif terminasi

        // Clear draft on successful submission
        document.querySelector('form').addEventListener('submit', function() {
            localStorage.removeItem('terminasiDraft');
        });
    </script>
</x-layouts.admin>
