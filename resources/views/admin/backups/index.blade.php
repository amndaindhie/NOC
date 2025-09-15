<x-layouts.admin title="Daftar Backup Database">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold">Daftar Backup Database</h2>
        <p class="text-gray-700 dark:text-gray-400">
            Kelola semua backup database sistem. Backup otomatis dibuat setiap hari pukul 02:00.
        </p>
    </div>

    <!-- Header dengan List di Kiri dan Button di Kanan -->
    <div class="bg-white dark:bg-gray-900 rounded-lg shadow mb-4">
        <div class="px-6 py-4 flex justify-between items-center">
            <!-- Info Backup (kiri) -->
            <div class="text-left">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">List Backup</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    @php
                        $todayBackups = $backups->filter(fn($backup) => $backup->created_at->isToday());
                    @endphp
                    Total: {{ $backups->count() }} backup | Hari ini: {{ $todayBackups->count() }} backup
                </p>
            </div>

            <!-- Tombol Backup (kanan) -->
            <form action="{{ route('admin.backups.store') }}" method="POST">
                @csrf
                <button type="submit"
                        class="btn-primary flex items-center px-4 py-2 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5 mr-2" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Buat Backup
                </button>
            </form>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-4 p-4">
        <div class="flex flex-wrap gap-4 items-center">
            <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Filter:</span>
            <a href="{{ request()->fullUrlWithQuery(['filter' => 'today']) }}"
               class="px-3 py-1 text-sm rounded {{ request('filter') == 'today' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }} hover:bg-blue-100 dark:hover:bg-blue-900">
                Hari Ini
            </a>
            <a href="{{ request()->fullUrlWithQuery(['filter' => 'all']) }}"
               class="px-3 py-1 text-sm rounded {{ !request('filter') || request('filter') == 'all' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200' : 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }} hover:bg-blue-100 dark:hover:bg-blue-900">
                Semua
            </a>
        </div>
    </div>

    <!-- Grid Backup -->
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @php
            $filteredBackups = $backups;
            if (request('filter') == 'today') {
                $filteredBackups = $backups->filter(fn($backup) => $backup->created_at->isToday());
            }
        @endphp

        @if($filteredBackups->isEmpty())
        @else
            @foreach($filteredBackups as $backup)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow hover:shadow-md transition-shadow duration-300 {{ $backup->created_at->isToday() ? 'ring-2 ring-blue-500' : '' }}">
                    <div class="p-4">
                        <!-- Header Card -->
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-white truncate max-w-xs">
                                        {{ $backup->file_name }}
                                    </h3>
                                </div>
                            </div>
                        </div>

                        <!-- Backup Details -->
                        <div class="space-y-3 mb-4">
                            <div class="flex items-center text-sm text-gray-800 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4"/>
                                </svg>
                                <span class="font-medium">Ukuran:</span>
                                <span class="ml-1">{{ $backup->file_size }}</span>
                            </div>

                            <div class="flex items-center text-sm text-gray-800 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="font-medium">Dibuat:</span>
                                <span class="ml-1">{{ $backup->created_at->format('d M Y, H:i') }}</span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex space-x-2">
                            <!-- Download -->
                            <a href="{{ route('admin.backups.download', $backup->id) }}"
                               class="flex-1 px-3 py-2 bg-blue-500 text-gray-50 dark:text-white text-sm font-medium rounded hover:bg-blue-600 transition-colors duration-200 flex items-center justify-center">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download
                            </a>

                            <!-- Restore -->
                            <form action="{{ route('admin.backups.restore', $backup->id) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit"
                                        class="w-full px-3 py-2 bg-yellow-500 text-gray-50 dark:text-white text-sm font-medium rounded hover:bg-yellow-600 transition-colors duration-200 flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                    </svg>
                                    Restore
                                </button>
                            </form>

                            <!-- Delete -->
                            <form action="{{ route('admin.backups.destroy', $backup->id) }}" method="POST" class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('Yakin ingin menghapus backup ini?')"
                                        class="w-full px-3 py-2 bg-red-500 text-gray-50 dark:text-white text-sm font-medium rounded hover:bg-red-600 transition-colors duration-200 flex items-center justify-center">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <!-- Jika sama sekali belum ada backup -->
    @if($backups->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center mt-6">
            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
            <p class="text-gray-600 dark:text-gray-400">Belum ada backup database.</p>
        </div>
    @endif
</x-layouts.admin>
