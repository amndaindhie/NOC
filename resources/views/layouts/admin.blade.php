<!DOCTYPE html>
<html lang="en" class="h-full antialiased {{ session('theme', 'light') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin NOC' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans antialiased min-h-screen">

    {{-- Mobile Sidebar Toggle --}}
    <div class="lg:hidden fixed top-4 left-4 z-50">
        <button id="sidebarToggle" class="p-2 bg-gray-800 text-white rounded-md" title="Toggle Sidebar">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    {{-- Sidebar --}}
    <aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-gray-800 dark:bg-gray-950 text-white z-40 transform -translate-x-full lg:translate-x-0 transition-transform duration-300">
        @include('layouts.partials.sidebar')
    </aside>

    {{-- Overlay for mobile --}}
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden lg:hidden"></div>

    {{-- Konten utama --}}
    <div class="lg:ml-64 flex flex-col min-h-screen">
        
        {{-- Navbar --}}
        <header class="bg-white dark:bg-gray-800 shadow z-30 flex items-center h-16 lg:fixed lg:top-0 lg:left-64 lg:right-0">
            @include('layouts.partials.topbar')
        </header>

        {{-- Page Content --}}
        <main class="p-2 sm:p-4 md:p-6 lg:p-6 lg:mt-16 flex-1 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
    
    <script>
        // Mobile sidebar toggle functionality
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            sidebarOverlay.classList.toggle('hidden');
        }

        // Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            if (!sidebar.contains(event.target) && !sidebarToggle.contains(event.target)) {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('hidden');
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            
            sidebarToggle?.addEventListener('click', toggleSidebar);
            sidebarOverlay?.addEventListener('click', toggleSidebar);
            
            // Close sidebar when clicking outside on mobile
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 1024 && 
                    !sidebar.contains(event.target) && 
                    !sidebarToggle.contains(event.target) &&
                    !sidebar.classList.contains('-translate-x-full')) {
                    toggleSidebar();
                }
            });
        });
    </script>
</body>
</html>
