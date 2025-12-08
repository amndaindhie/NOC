<x-layouts.admin title="Update Status Maintenance">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold">Update Status Permintaan Maintenance</h2>
        <p class="text-gray-600 dark:text-gray-400">Hanya status yang dapat diubah pada permintaan maintenance ini</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            <!-- Display Read-only Information -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Permintaan Maintenance</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Tenant</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $maintenance->nomor_tenant }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Tracking</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $maintenance->nomor_tracking }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Tenant</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $maintenance->nama_tenant }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Maintenance</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $maintenance->jenis_maintenance }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Permintaan</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $maintenance->tanggal_permintaan ? $maintenance->tanggal_permintaan->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Mulai</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $maintenance->tanggal_mulai ? $maintenance->tanggal_mulai->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Selesai</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $maintenance->tanggal_selesai ? $maintenance->tanggal_selesai->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tingkat Urgensi</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $maintenance->tingkat_urgensi }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi Perangkat</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $maintenance->lokasi_perangkat ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Saat Ini</label>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            {{ $maintenance->status == 'Diterima' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $maintenance->status == 'Proses' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $maintenance->status == 'Selesai' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $maintenance->status == 'Ditolak' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ $maintenance->status }}
                        </span>
                    </div>
                </div>

                @if($maintenance->deskripsi_masalah)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Deskripsi Masalah</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 p-3 rounded">{{ $maintenance->deskripsi_masalah }}</p>
                    </div>
                @endif

                @if($maintenance->dokumen_path)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dokumen</label>
                        <div class="mt-1 flex items-center space-x-2">
                            <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <a href="{{ asset('storage/' . $maintenance->dokumen_path) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">
                                {{ $maintenance->dokumen_filename }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Status Update Form -->
            <form action="{{ route('admin.noc.maintenance.update', $maintenance->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Update Status</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Status Baru *
                            </label>
                            <select name="status" id="status" required
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="Diterima" {{ $maintenance->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="Proses" {{ $maintenance->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Selesai" {{ $maintenance->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Ditolak" {{ $maintenance->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                        </div>

                        <!-- Comment -->
                        <div id="comment-container" class="hidden">
                            <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Komentar *
                            </label>
                            <textarea name="comment" id="comment" rows="3" maxlength="500"
                                      class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Tambahkan komentar terkait update status...">{{ old('comment') }}</textarea>
                        </div>

                        <!-- Bukti Selesai (only shown when status is Selesai) -->
                        <div id="bukti-container" class="hidden md:col-span-2">
                            <label for="bukti_selesai" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Upload Bukti Selesai (Foto) *
                            </label>
                            <input type="file" name="bukti_selesai" id="bukti_selesai" accept="image/*"
                                   class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            <p class="mt-1 text-sm text-gray-500">Format: JPG, JPEG, PNG (Max: 2MB)</p>

                            @if($maintenance->bukti_selesai_path)
                                <div class="mt-2">
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-1">Bukti selesai saat ini:</p>
                                    <img src="{{ asset('storage/' . $maintenance->bukti_selesai_path) }}"
                                         alt="Bukti Selesai"
                                         class="max-w-xs rounded border border-gray-300">
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-6 flex space-x-3">
                        <a href="{{ route('admin.noc.maintenance') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                            Update Status
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusSelect = document.getElementById('status');
            const commentContainer = document.getElementById('comment-container');
            const commentTextarea = document.getElementById('comment');
            const buktiContainer = document.getElementById('bukti-container');
            const buktiInput = document.getElementById('bukti_selesai');

            function toggleFields() {
                // Toggle comment field for Ditolak
                if (statusSelect.value === 'Ditolak') {
                    commentContainer.classList.remove('hidden');
                    commentTextarea.setAttribute('required', 'required');
                } else {
                    commentContainer.classList.add('hidden');
                    commentTextarea.removeAttribute('required');
                    commentTextarea.value = '';
                }

                // Toggle bukti selesai field for Selesai
                if (statusSelect.value === 'Selesai') {
                    buktiContainer.classList.remove('hidden');
                    buktiInput.setAttribute('required', 'required');
                } else {
                    buktiContainer.classList.add('hidden');
                    buktiInput.removeAttribute('required');
                    buktiInput.value = '';
                }
            }

            // Initial check
            toggleFields();

            // Add event listener
            statusSelect.addEventListener('change', toggleFields);
        });
    </script>

</x-layouts.admin>
