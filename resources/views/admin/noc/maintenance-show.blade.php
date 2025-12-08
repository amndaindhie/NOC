<x-layouts.admin title="Detail Maintenance">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold">Detail Maintenance</h2>
                <p class="text-gray-600 dark:text-gray-400">Informasi lengkap permintaan maintenance</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.noc.maintenance.edit', $maintenance->id) }}"
                    class="btn-primary flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.noc.maintenance') }}" class="btn-secondary flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informasi Umum -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Informasi Umum</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor
                                Tracking</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $maintenance->nomor_tracking }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor
                                Tenant</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $maintenance->nomor_tenant }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                Tenant</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $maintenance->nama_tenant }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $maintenance->email ?? 'Tidak ada email' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis
                                Maintenance</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">
                                {{ $maintenance->jenis_maintenance ?? 'Tidak ditentukan' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Detail Maintenance -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Detail Maintenance</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                                Permintaan</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">
                                {{ $maintenance->tanggal_permintaan ? $maintenance->tanggal_permintaan->format('d/m/Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                                Mulai</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">
                                {{ $maintenance->tanggal_mulai ? $maintenance->tanggal_mulai->format('d/m/Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal
                                Selesai</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">
                                {{ $maintenance->tanggal_selesai ? $maintenance->tanggal_selesai->format('d/m/Y') : 'Belum selesai' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <span
                                class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $maintenance->status == 'Diterima' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $maintenance->status == 'Proses' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $maintenance->status == 'Selesai' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $maintenance->status == 'Ditolak' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $maintenance->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deskripsi Masalah -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Deskripsi Masalah</h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <p class="text-gray-700 dark:text-gray-300">
                        {{ $maintenance->deskripsi_masalah ?? 'Tidak ada deskripsi' }}</p>
                </div>
            </div>

            <!-- Informasi Tambahan -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Informasi Tambahan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi
                            Perangkat</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">
                            {{ $maintenance->lokasi_perangkat ?? 'Tidak ditentukan' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tingkat
                            Urgensi</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">
                            {{ $maintenance->tingkat_urgensi ?? 'Tidak ditentukan' }}</p>
                    </div>
                </div>
            </div>


            <!-- Dokumen Pendukung -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Dokumen Pendukung</h3>
                @if ($maintenance->dokumen_path)
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <a href="{{ Storage::url($maintenance->dokumen_path) }}" target="_blank"
                            class="text-sm text-blue-600 hover:text-blue-800">
                            Lihat Dokumen
                        </a>
                    </div>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada dokumen</p>
                @endif
            </div>

            <!-- Bukti Selesai (Completion Evidence) -->
            @if ($maintenance->bukti_selesai_path)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block mr-2 text-green-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Bukti Selesai Maintenance
                    </h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <div class="flex flex-col items-center">
                            <img src="{{ asset('storage/' . $maintenance->bukti_selesai_path) }}" 
                                 alt="Bukti Selesai Maintenance" 
                                 class="max-w-full md:max-w-2xl rounded-lg shadow-md border border-gray-300 dark:border-gray-600">
                            <p class="mt-3 text-sm text-gray-600 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 inline-block mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Foto bukti penyelesaian maintenance
                            </p>
                            <a href="{{ asset('storage/' . $maintenance->bukti_selesai_path) }}" 
                               target="_blank"
                               class="mt-2 text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 text-sm flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                                Lihat gambar ukuran penuh
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Informasi Waktu -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Informasi Waktu</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dibuat pada</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">
                            {{ $maintenance->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Diperbarui
                            pada</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">
                            {{ $maintenance->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
