<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Tenant Dashboard</h1>
        <p class="text-gray-600 dark:text-gray-400">Kelola dan monitor semua tenant dari berbagai form</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ count($tenantStats) }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Total Tenant</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ collect($tenantStats)->where('status', 'aktif')->count() }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Tenant Aktif</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ collect($tenantStats)->where('status', 'non-aktif')->count() }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Tenant Non-Aktif</div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <svg class="w-8 h-8 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2zm0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <div class="text-2xl font-semibold text-gray-900 dark:text-white">{{ collect($tenantStats)->sum('total_activities') }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Total Aktivitas</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 mb-6">
        <div class="flex items-center justify-between">
            <div class="flex-1">
                <input 
                    type="text" 
                    wire:model.live="search" 
                    placeholder="Cari nomor tenant..." 
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                >
            </div>
        </div>
    </div>

    <!-- Tenant List -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Daftar Tenant</h3>
        </div>

        <div class="table-no-scroll">
            <table class="table-compact table-responsive">
                <thead>
                    <tr>
                        <th class="col-name">Tenant</th>
                        <th class="col-id hidden-mobile">Install</th>
                        <th class="col-id hidden-mobile">Term</th>
                        <th class="col-id hidden-sm">Maint</th>
                        <th class="col-id">Keluhan</th>
                        <th class="col-id hidden-sm">Total</th>
                        <th class="col-status">Status</th>
                        <th class="col-actions">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tenantStats as $tenantNumber => $stats)
                        <tr>
                            <td class="col-name">
                                <div class="font-medium text-gray-900 dark:text-white">{{ Str::limit($tenantNumber, 15) }}</div>
                                <div class="text-xs text-gray-500 dark:text-gray-400 md:hidden">
                                    I:{{ $stats['instalasi'] }} T:{{ $stats['terminasi'] }} M:{{ $stats['maintenance'] }}
                                </div>
                            </td>
                            <td class="col-id hidden-mobile text-center">
                                <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-medium bg-blue-100 text-blue-800 rounded-full dark:bg-blue-900 dark:text-blue-200">
                                    {{ $stats['instalasi'] }}
                                </span>
                            </td>
                            <td class="col-id hidden-mobile text-center">
                                <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-medium bg-red-100 text-red-800 rounded-full dark:bg-red-900 dark:text-red-200">
                                    {{ $stats['terminasi'] }}
                                </span>
                            </td>
                            <td class="col-id hidden-sm text-center">
                                <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-medium bg-yellow-100 text-yellow-800 rounded-full dark:bg-yellow-900 dark:text-yellow-200">
                                    {{ $stats['maintenance'] }}
                                </span>
                            </td>
                            <td class="col-id text-center">
                                <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-medium bg-purple-100 text-purple-800 rounded-full dark:bg-purple-900 dark:text-purple-200">
                                    {{ $stats['keluhan'] }}
                                </span>
                            </td>
                            <td class="col-id hidden-sm text-center font-medium text-gray-900 dark:text-white">
                                {{ $stats['total_activities'] }}
                            </td>
                            <td class="col-status">
                                <span class="px-1.5 py-0.5 text-xs font-medium rounded 
                                    {{ $stats['status'] === 'aktif' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' }}">
                                    {{ $stats['status'] === 'aktif' ? 'Aktif' : 'Non-Aktif' }}
                                </span>
                            </td>
                            <td class="col-actions">
                                <button wire:click="selectTenant('{{ $tenantNumber }}')" 
                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 text-xs"
                                    title="View Details">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-gray-500 dark:text-gray-400 py-8">
                                Tidak ada data tenant yang ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Selected Tenant Details Modal -->
    @if($selectedTenant)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
                <div class="mt-3 text-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">
                        Detail Tenant: {{ $selectedTenant }}
                    </h3>
                    
                    <div class="mt-2 px-7 py-3">
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="bg-blue-50 dark:bg-blue-900 p-4 rounded-lg">
                                <h4 class="font-semibold text-blue-800 dark:text-blue-200">Instalasi</h4>
                                <p class="text-2xl font-bold">{{ $tenantStats[$selectedTenant]['instalasi'] ?? 0 }}</p>
                            </div>
                            <div class="bg-red-50 dark:bg-red-900 p-4 rounded-lg">
                                <h4 class="font-semibold text-red-800 dark:text-red-200">Terminasi</h4>
                                <p class="text-2xl font-bold">{{ $tenantStats[$selectedTenant]['terminasi'] ?? 0 }}</p>
                            </div>
                            <div class="bg-yellow-50 dark:bg-yellow-900 p-4 rounded-lg">
                                <h4 class="font-semibold text-yellow-800 dark:text-yellow-200">Maintenance</h4>
                                <p class="text-2xl font-bold">{{ $tenantStats[$selectedTenant]['maintenance'] ?? 0 }}</p>
                            </div>
                            <div class="bg-purple-50 dark:bg-purple-900 p-4 rounded-lg">
                                <h4 class="font-semibold text-purple-800 dark:text-purple-200">Keluhan</h4>
                                <p class="text-2xl font-bold">{{ $tenantStats[$selectedTenant]['keluhan'] ?? 0 }}</p>
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-4">
                            <button wire:click="$set('selectedTenant', null)" 
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600">
                                Tutup
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
