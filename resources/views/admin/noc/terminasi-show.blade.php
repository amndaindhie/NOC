<x-layouts.admin title="Detail Terminasi">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold">Detail Terminasi</h2>
                <p class="text-gray-600 dark:text-gray-400">Informasi lengkap permintaan terminasi layanan</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.noc.terminasi.edit', $terminasi->id) }}"
                    class="btn-primary flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.noc.terminasi') }}" class="btn-secondary flex items-center">
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
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Tiket</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $terminasi->nomor_tiket }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Tenant</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $terminasi->nomor_tenant }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Tenant</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $terminasi->nama_tenant }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $terminasi->email ?? 'Tidak ada email' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $terminasi->lokasi ?? 'Tidak ditentukan' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Detail Terminasi -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Detail Terminasi</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alasan Terminasi</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $terminasi->alasan_terminasi ?? 'Tidak ditentukan' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Efektif</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">
                                {{ $terminasi->tanggal_efektif ? \Carbon\Carbon::parse($terminasi->tanggal_efektif)->format('d/m/Y') : '-' }}
                            </p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <span
                                class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $terminasi->status == 'Disetujui' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $terminasi->status == 'Ditolak' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $terminasi->status == 'Diproses' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $terminasi->status == 'Diajukan' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $terminasi->status == 'Selesai' ? 'bg-green-100 text-green-800' : '' }}">
                                {{ $terminasi->status }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Urgensi</label>
                            <span
                                class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                {{ $terminasi->prioritas_terminasi == 'Critical' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $terminasi->prioritas_terminasi == 'High' ? 'bg-orange-100 text-orange-800' : '' }}
                                {{ $terminasi->prioritas_terminasi == 'Medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $terminasi->prioritas_terminasi == 'Low' ? 'bg-green-100 text-green-800' : '' }}">
                                {{ $terminasi->prioritas_terminasi ?? '-' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alasan Terminasi -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Alasan Terminasi</h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <p class="text-gray-700 dark:text-gray-300">
                        {{ $terminasi->alasan_terminasi ?? 'Tidak ada alasan' }}</p>
                </div>
            </div>

            <!-- Keterangan Tambahan -->
            @if($terminasi->keterangan_tambahan)
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Keterangan Tambahan</h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <p class="text-gray-700 dark:text-gray-300">{{ $terminasi->keterangan_tambahan }}</p>
                </div>
            </div>
            @endif

            <!-- Dokumen Pendukung -->
            @if($terminasi->dokumen_path)
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Dokumen Pendukung</h3>
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <a href="{{ Storage::url($terminasi->dokumen_path) }}" target="_blank"
                        class="text-sm text-blue-600 hover:text-blue-800">
                        Lihat Dokumen
                    </a>
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
                            {{ $terminasi->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Diperbarui
                            pada</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">
                            {{ $terminasi->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
