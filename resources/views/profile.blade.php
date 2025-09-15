<!DOCTYPE html>
<html lang="en" class="h-full antialiased {{ session('theme', 'light') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Profile' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100 font-sans antialiased min-h-screen">

    {{-- Sidebar --}}
    <aside id="sidebar" class="fixed top-0 left-0 h-full w-64 bg-gray-800 dark:bg-gray-950 text-white z-40">
        @include('layouts.partials.sidebar')
    </aside>

    {{-- Konten utama --}}
    <div class="lg:ml-64 flex flex-col min-h-screen">
        
        {{-- Navbar --}}
        <header class="bg-white dark:bg-gray-800 shadow z-30 flex items-center h-16 lg:fixed lg:top-0 lg:left-64 lg:right-0">
            @include('layouts.partials.topbar')
        </header>

        {{-- Page Content --}}
        <main class="p-4 sm:p-6 lg:p-6 lg:mt-16 flex-1 overflow-y-auto">
            <x-slot name="header">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Profile') }}
                </h2>
            </x-slot>

            <div class="py-12">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            <livewire:profile.update-profile-information-form />
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            <livewire:profile.update-password-form />
                        </div>
                    </div>

                    <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                        <div class="max-w-xl">
                            <livewire:profile.delete-user-form />
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    @livewireScripts
</body>
</html>
