<x-layouts.admin title="Update Status Terminasi">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold">Update Status Permintaan Terminasi</h2>
        <p class="text-gray-600 dark:text-gray-400">Hanya status yang dapat diubah pada permintaan terminasi ini</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6">
            <!-- Display Read-only Information -->
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Informasi Permintaan Terminasi</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 dark:bg-gray-700 p-4 rounded-lg">
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
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Lokasi</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $terminasi->lokasi }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tanggal Efektif</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $terminasi->tanggal_efektif ? \Carbon\Carbon::parse($terminasi->tanggal_efektif)->format('d/m/Y') : '-' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alasan Terminasi</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100">{{ $terminasi->alasan_terminasi }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Urgensi</label>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            {{ $terminasi->prioritas_terminasi == 'Critical' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $terminasi->prioritas_terminasi == 'High' ? 'bg-orange-100 text-orange-800' : '' }}
                            {{ $terminasi->prioritas_terminasi == 'Medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $terminasi->prioritas_terminasi == 'Low' ? 'bg-green-100 text-green-800' : '' }}">
                            {{ $terminasi->prioritas_terminasi ?? '-' }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Status Saat Ini</label>
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            {{ $terminasi->status == 'Diajukan' ? 'bg-blue-100 text-blue-800' : '' }}
                            {{ $terminasi->status == 'Diproses' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $terminasi->status == 'Disetujui' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $terminasi->status == 'Ditolak' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $terminasi->status == 'Selesai' ? 'bg-green-100 text-green-800' : '' }}">
                            {{ $terminasi->status }}
                        </span>
                    </div>
                </div>

                @if($terminasi->alasan_lainnya)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Alasan Lainnya</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 p-3 rounded">{{ $terminasi->alasan_lainnya }}</p>
                    </div>
                @endif

                @if($terminasi->keterangan_tambahan)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan Tambahan</label>
                        <p class="mt-1 text-gray-900 dark:text-gray-100 bg-gray-50 dark:bg-gray-700 p-3 rounded">{{ $terminasi->keterangan_tambahan }}</p>
                    </div>
                @endif

                @if($terminasi->dokumen)
                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dokumen</label>
                        <div class="mt-1 flex items-center space-x-2">
                            <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <a href="{{ Storage::url($terminasi->dokumen) }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-800">
                                Lihat Dokumen
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Status Update Form -->
            <form action="{{ route('admin.noc.terminasi.update', $terminasi->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="border-t pt-6">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Update Status</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Status Baru *
                            </label>
                            <select name="status" id="status" required
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                <option value="Diajukan" {{ $terminasi->status == 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
                                <option value="Diproses" {{ $terminasi->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="Disetujui" {{ $terminasi->status == 'Disetujui' ? 'selected' : '' }}>Disetujui</option>
                                <option value="Ditolak" {{ $terminasi->status == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                                <option value="Selesai" {{ $terminasi->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
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
                        <a href="{{ route('admin.noc.terminasi') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md">
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
