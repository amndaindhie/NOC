<aside class="bg-gray-800 dark:bg-gray-950 text-white w-64 min-h-screen p-4">
    <!-- Logo and Close Button for Mobile -->
    <div class="mb-8 flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="flex items-center">
            <span class="text-xl font-bold">Admin NOC</span>
        </a>
        <button class="lg:hidden text-gray-400 hover:text-white" onclick="toggleSidebar()" title="Close Sidebar">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Navigation -->
    <nav class="space-y-1">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="flex items-center py-2.5 px-4 rounded transition duration-200 
           {{ request()->routeIs('dashboard') ? 'bg-blue-600 hover:bg-blue-700' : 'hover:bg-gray-700' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 
                         001 1h3m10-11l2 2m-2-2v10a1 1 0 
                         01-1 1h-3m-6 0a1 1 0 
                         001-1v-4a1 1 0 
                         011-1h2a1 1 0 
                         011 1v4a1 1 0 
                         001 1m-6 0h6" />
            </svg>
            <span>Dashboard</span>
        </a>


        <!-- NOC Management (Accordion style) -->
        <div x-data="{ open: {{ request()->routeIs('admin.noc.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="flex items-center justify-between w-full py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700" title="Toggle NOC Management Menu">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    <span>NOC Management</span>
                </div>
                <svg :class="{'rotate-90': open}" class="h-4 w-4 transform transition-transform" 
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>

            <div x-show="open" x-transition class="ml-8 mt-1 space-y-1">
                <a href="{{ route('admin.noc.instalasi') }}" 
                   class="block py-2 px-4 rounded text-sm transition duration-200 
                   {{ request()->routeIs('admin.noc.instalasi') ? 'bg-blue-600 hover:bg-blue-700' : 'hover:bg-gray-700' }}">
                    Instalasi
                </a>
                <a href="{{ route('admin.noc.maintenance') }}" 
                   class="block py-2 px-4 rounded text-sm transition duration-200 
                   {{ request()->routeIs('admin.noc.maintenance') ? 'bg-blue-600 hover:bg-blue-700' : 'hover:bg-gray-700' }}">
                    Maintenance
                </a>
                <a href="{{ route('admin.noc.keluhan') }}" 
                   class="block py-2 px-4 rounded text-sm transition duration-200 
                   {{ request()->routeIs('admin.noc.keluhan') ? 'bg-blue-600 hover:bg-blue-700' : 'hover:bg-gray-700' }}">
                    Keluhan
                </a>
                <a href="{{ route('admin.noc.terminasi') }}" 
                   class="block py-2 px-4 rounded text-sm transition duration-200 
                   {{ request()->routeIs('admin.noc.terminasi') ? 'bg-blue-600 hover:bg-blue-700' : 'hover:bg-gray-700' }}">
                    Terminasi
                </a>
            </div>
        </div>

        <!-- Users -->
        <a href="{{ route('admin.users') }}" 
           class="flex items-center py-2.5 px-4 rounded transition duration-200 
           {{ request()->routeIs('admin.users') ? 'bg-blue-600 hover:bg-blue-700' : 'hover:bg-gray-700' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M12 4.354a4 4 0 110 5.292M15 
                         21H3v-1a6 6 0 
                         0112 0v1zm0 0h6v-1a6 6 
                         0 00-9-5.197M13 7a4 4 
                         0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span>Users</span>
        </a>



        <!-- Backup Data -->
        <a href="{{ route('admin.backups.index') }}" 
           class="flex items-center py-2.5 px-4 rounded transition duration-200 
           {{ request()->routeIs('admin.backups.index') ? 'bg-blue-600 hover:bg-blue-700' : 'hover:bg-gray-700' }}">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
            </svg>
            <span>Daftar Backup</span>
        </a>
    </nav>
</aside>
