<x-layouts.admin title="Update Status Instalasi">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold">Update Status Permintaan Instalasi</h2>
        <p class="text-gray-600 dark:text-gray-400">Hanya status yang dapat diubah pada permintaan instalasi ini</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            <!-- Display Read-only Information -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Permintaan Instalasi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Tiket</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->nomor_tiket }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nomor Tenant</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->nomor_tenant }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nama Perusahaan</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->nama_perusahaan }}</p>
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
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi Instalasi</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->lokasi_instalasi }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi Pemasangan</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->lokasi_pemasangan ?? 'Tidak ditentukan' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Jenis Layanan</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->jenis_layanan }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Kecepatan Bandwidth</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->kecepatan_bandwidth }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Skema Topologi</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->skema_topologi ?? 'Tidak ditentukan' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Permintaan</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $instalasi->tanggal_permintaan ? $instalasi->tanggal_permintaan->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Saat Ini</label>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            {{ $instalasi->status == 'Diterima' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $instalasi->status == 'Proses' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $instalasi->status == 'Selesai' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $instalasi->status == 'Ditolak' ? 'bg-red-100 text-red-800' : '' }}">
                            {{ $instalasi->status }}
                        </span>
                    </div>
                </div>

                @if($instalasi->catatan_tambahan)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Catatan Tambahan</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 p-3 rounded">{{ $instalasi->catatan_tambahan }}</p>
                    </div>
                @endif
            </div>

            <!-- Status and Date Update Form -->
            <form action="{{ route('admin.noc.instalasi.update', $instalasi->id) }}" method="POST">
                @csrf
             

                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Update Status</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Status Baru *
                            </label>
                            <select name="status"
                                    id="status"
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500"
                                    required>
                                <option value="Diterima" {{ $instalasi->status == 'Diterima' ? 'selected' : '' }}>Diterima</option>
                                <option value="Proses" {{ $instalasi->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                <option value="Selesai" {{ $instalasi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Ditolak" {{ $instalasi->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
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
                    </div>

                    <div class="mt-6 flex space-x-3">
                        <a href="{{ route('admin.noc.instalasi') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
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

            function toggleCommentField() {
                if (statusSelect.value === 'Ditolak') {
                    commentContainer.classList.remove('hidden');
                    commentTextarea.setAttribute('required', 'required');
                } else {
                    commentContainer.classList.add('hidden');
                    commentTextarea.removeAttribute('required');
                    commentTextarea.value = '';
                }
            }

            // Initial check
            toggleCommentField();

            // Add event listener
            statusSelect.addEventListener('change', toggleCommentField);
        });
    </script>

</x-layouts.admin>
