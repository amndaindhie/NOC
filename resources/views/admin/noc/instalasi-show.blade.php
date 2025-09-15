<x-layouts.admin title="Detail Instalasi">
    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-semibold">Detail Instalasi</h2>
                <p class="text-gray-600 dark:text-gray-400">Informasi lengkap permintaan instalasi jaringan</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('admin.noc.instalasi.edit', $instalasi->id) }}" 
                   class="btn-primary flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
                <a href="{{ route('admin.noc.instalasi') }}" 
                   class="btn-secondary flex items-center">
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
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informasi Pelanggan -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Informasi Pelanggan</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Perusahaan</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->nama_perusahaan }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Tenant</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->nomor_tenant }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kontak Person</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->kontak_person }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Telepon</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->nomor_telepon }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama ISP</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->nama_isp ?? 'Tidak ditentukan' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor NPWP</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->nomor_npwp ?? 'Tidak ditentukan' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->email ?? 'Tidak ada email' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Detail Instalasi -->
                <div>
                    <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Detail Instalasi</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Tiket</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->nomor_tiket }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Permintaan</label>
                            <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status</label>
                            <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                {{ $instalasi->status == 'Diterima' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $instalasi->status == 'Proses' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                {{ $instalasi->status == 'Selesai' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $instalasi->status == 'Ditolak' ? 'bg-red-100 text-red-800' : '' }}">
                                {{ $instalasi->status }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alamat Instalasi -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Lokasi Instalasi</h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <p class="text-gray-700 dark:text-gray-300">{{ $instalasi->lokasi_instalasi ?? 'Tidak ada alamat' }}</p>
                </div>
            </div>

            <!-- Detail Layanan -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Detail Layanan</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Layanan</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->jenis_layanan ?? 'Tidak ditentukan' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kecepatan Bandwidth</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->kecepatan_bandwidth ?? 'Tidak ditentukan' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi Pemasangan</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->lokasi_pemasangan ?? 'Tidak ditentukan' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Skema Topologi</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->skema_topologi ?? 'Tidak ditentukan' }}</p>
                    </div>
                </div>
            </div>

            <!-- Catatan Tambahan -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Catatan Tambahan</h3>
                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                    <p class="text-gray-700 dark:text-gray-300">{{ $instalasi->catatan_tambahan ?? 'Tidak ada catatan' }}</p>
                </div>
            </div>

            <!-- Dokumen Pendukung -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Dokumen Pendukung</h3>
                @if($instalasi->dokumen_path)
                    <div class="flex items-center space-x-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <a href="{{ Storage::url($instalasi->dokumen_path) }}" 
                           target="_blank" 
                           class="text-sm text-blue-600 hover:text-blue-800">
                            Lihat Dokumen
                        </a>
                    </div>
                @else
                    <p class="text-sm text-gray-500 dark:text-gray-400">Tidak ada dokumen</p>
                @endif
            </div>

            <!-- Informasi Waktu -->
            <div class="mt-6">
                <h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-white">Informasi Waktu</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dibuat pada</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Diperbarui pada</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
