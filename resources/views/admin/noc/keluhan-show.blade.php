<x-layouts.admin title="Detail Keluhan">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold">Detail Keluhan</h2>
                <p class="text-gray-600 dark:text-gray-400">Informasi lengkap keluhan jaringan.</p>
            </div>
            <div>
                <a href="{{ route('admin.noc.keluhan') }}" class="btn-secondary flex items-center">
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
                <!-- Informasi Tenant -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Informasi Tenant</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor
                                Tenant</label>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $keluhan->nomor_tenant }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama
                                Tenant</label>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $keluhan->nama_tenant }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kontak
                                Person</label>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $keluhan->kontak_person }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $keluhan->email ?? 'Tidak ada email' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Detail Keluhan -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Detail Keluhan</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor
                                Tiket</label>
                            <p class="mt-1 text-gray-900 dark:text-white font-mono">{{ $keluhan->nomor_tiket }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis
                                Gangguan</label>
                            <p class="mt-1 text-gray-900 dark:text-white">{{ $keluhan->jenis_gangguan }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tingkat
                                Urgensi</label>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $keluhan->tingkat_urgensi == 'Low' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $keluhan->tingkat_urgensi == 'Medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $keluhan->tingkat_urgensi == 'High' ? 'bg-orange-100 text-orange-800' : '' }}
                                {{ $keluhan->tingkat_urgensi == 'Critical' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $keluhan->tingkat_urgensi }}
                            </span>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu Mulai
                                Gangguan</label>
                            <p class="mt-1 text-gray-900 dark:text-white">
                                {{ \Carbon\Carbon::parse($keluhan->waktu_mulai_gangguan)->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if ($keluhan->status == 'Selesai') status-selesai
                                @elseif($keluhan->status == 'Proses') status-proses
                                @elseif($keluhan->status == 'Ditolak') status-ditolak
                                @else status-lainnya @endif">
                                {{ $keluhan->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
 
            <!-- Catatan Tambahan -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Catatan Tambahan</h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <p class="text-gray-700 dark:text-gray-300">{{ $keluhan->deskripsi_gangguan ?? 'Tidak ada catatan' }}</p>
                </div>
            </div>

            <!-- Bukti Pendukung -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Bukti Keluhan</h3>
                @if ($keluhan->bukti_path)
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <a href="{{ Storage::url($keluhan->bukti_path) }}" target="_blank"
                            class="text-sm text-blue-600 hover:text-blue-800">
                            Lihat Dokumen
                        </a>
                    </div>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada bukti</p>
                @endif
            </div>

            <!-- Informasi Tambahan -->
            <div class="mt-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dibuat pada</label>
                        <p class="mt-1 text-gray-900 dark:text-white">{{ $keluhan->created_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Diperbarui
                            pada</label>
                        <p class="mt-1 text-gray-900 dark:text-white">{{ $keluhan->updated_at->format('d/m/Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="mt-6 flex justify-end space-x-3">
                <a href="{{ route('admin.noc.keluhan.edit', $keluhan->id) }}" class="btn-primary px-4 py-2 rounded-md">
                    Edit
                </a>
                <a href="{{ route('admin.noc.keluhan') }}" class="btn-secondary px-4 py-2 rounded-md">
                    Kembali
                </a>
            </div>
        </div>
    </div>
</x-layouts.admin>
