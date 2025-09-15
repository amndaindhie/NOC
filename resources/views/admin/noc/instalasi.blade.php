<x-layouts.admin title="NOC - Instalasi">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold">NOC - Instalasi</h2>
        <p class="text-gray-600 dark:text-gray-400">Kelola semua permintaan instalasi jaringan.</p>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow mb-4">
        <div class="px-6 py-4 flex justify-between items-center">
            <h3 class="text-lg font-semibold">Daftar Permintaan Instalasi</h3>
            <div class="flex space-x-2">
                <div class="relative">
                    <input type="text" wire:model.live.debounce.300ms="searchTerm" placeholder="Search instalasi..."
                        class="w-full pl-10 pr-4 py-2 rounded-lg border border-gray-300 dark:border-gray-700 
                        focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-gray-200">
                    <div class="absolute left-3 top-2.5 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                </div>

                <a href="{{ route('admin.noc.instalasi.export.excel') }}" class="btn-secondary flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 
                            5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    Excel
                </a>
                <a href="{{ route('admin.noc.instalasi.export.csv') }}" class="btn-secondary flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 
                            5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    CSV
                </a>
                <a href="{{ route('admin.noc.instalasi.create') }}" class="btn-primary flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    Add Instalasi
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-1 gap-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table
                            class="min-w-full text-sm md:text-base border border-gray-200 dark:border-gray-700 rounded-lg">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr
                                    class="text-center text-xs md:text-sm font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">
                                    <th class="px-3 py-3">ID</th>
                                    <th class="px-3 py-3">Nomor Tiket</th>
                                    <th class="px-3 py-3 text-left">Nama Perusahaan</th>
                                    <th class="px-3 py-3">Urgensi</th>
                                    <th class="px-3 py-3 text-left">PIC</th>
                                    <th class="px-3 py-3 text-left">Email</th>
                                    <th class="px-3 py-3 text-left">Lokasi</th>
                                    <th class="px-3 py-3">Tanggal Permintaan</th>
                                    <th class="px-3 py-3">Status</th>
                                    <th class="px-3 py-3">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($instalasi as $request)
                                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-750 transition">
                                        <td class="px-3 py-2 text-center">{{ $request->id }}</td>
                                        <td class="px-3 py-2 text-center">
                                            {{ $request->nomor_tiket }}
                                        </td>
                                        <td class="px-3 py-2 text-left">{{ $request->nama_perusahaan }}</td>
                                        <td class="px-3 py-2 text-center">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $request->tingkat_urgensi == 'Critical' ? 'bg-red-100 text-red-800' : '' }}
                                                {{ $request->tingkat_urgensi == 'High' ? 'bg-orange-100 text-orange-800' : '' }}
                                                {{ $request->tingkat_urgensi == 'Medium' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $request->tingkat_urgensi == 'Low' ? 'bg-green-100 text-green-800' : '' }}">
                                                {{ $request->tingkat_urgensi ?? 'Medium' }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 text-left">{{ $request->kontak_person }}</td>
                                        <td class="px-3 py-2 text-left">{{ $request->email ?? '-' }}</td>
                                        <td class="px-3 py-2 text-left">{{ $request->lokasi_instalasi }}</td>
                                        <td class="px-3 py-2 text-center whitespace-nowrap">
                                            {{ $request->created_at->format('d/m/Y') }}
                                        </td>
                                        <td class="px-3 py-2 text-center">
                                            <span
                                                class="px-2 py-1 text-xs font-semibold rounded-full
                                                {{ $request->status == 'Diterima' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ $request->status == 'Proses' ? 'bg-yellow-100 text-yellow-800' : '' }}
                                                {{ $request->status == 'Selesai' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $request->status == 'Ditolak' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ $request->status }}
                                            </span>
                                        </td>
                                        <td class="px-3 py-2 text-center whitespace-nowrap">
                                            <x-noc-crud-buttons
                                                :viewRoute="route('admin.noc.instalasi.show', $request->id)"
                                                :editRoute="route('admin.noc.instalasi.edit', $request->id)"
                                                :deleteRoute="route('admin.noc.instalasi.destroy', $request->id)" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10"
                                            class="px-3 py-4 text-center text-gray-500 dark:text-gray-400">
                                            Tidak ada data instalasi
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-6 flex flex-col md:flex-row justify-between items-center space-y-2 md:space-y-0">
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Showing <span class="font-medium">1</span> to
                            <span class="font-medium">{{ $instalasi->count() }}</span> of
                            <span class="font-medium">{{ $instalasi->total() }}</span> results
                        </div>
                        <div class="flex space-x-1">
                            {{ $instalasi->links() }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-layouts.admin>
