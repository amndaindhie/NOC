<div>
    @if($showPanel)
        <div class="fixed inset-0 bg-transparent z-40" wire:click="togglePanel"></div>
        <div class="fixed right-0 top-0 h-full w-96 bg-white dark:bg-gray-800 shadow-lg z-50 flex flex-col">
            <div class="flex items-center justify-between px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Notifications</h3>
                <button wire:click="togglePanel" class="text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                <nav class="flex space-x-4" aria-label="Tabs">
                    <button wire:click="setFilter('all')" class="px-3 py-1 rounded-md text-sm font-medium focus:outline-none
                        {{ $filterType === 'all' ? 'bg-blue-500 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        All
                    </button>
                    <button wire:click="setFilter('maintenance')" class="px-3 py-1 rounded-md text-sm font-medium focus:outline-none
                        {{ $filterType === 'maintenance' ? 'bg-green-500 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        Maintenance
                    </button>
                    <button wire:click="setFilter('instalasi')" class="px-3 py-1 rounded-md text-sm font-medium focus:outline-none
                        {{ $filterType === 'instalasi' ? 'bg-blue-500 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        Instalasi
                    </button>
                    <button wire:click="setFilter('keluhan')" class="px-3 py-1 rounded-md text-sm font-medium focus:outline-none
                        {{ $filterType === 'keluhan' ? 'bg-yellow-500 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        Keluhan
                    </button>
                    <button wire:click="setFilter('terminasi')" class="px-3 py-1 rounded-md text-sm font-medium focus:outline-none
                        {{ $filterType === 'terminasi' ? 'bg-red-500 text-white' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700' }}">
                        Terminasi
                    </button>
                </nav>
            </div>

            <div class="flex-1 overflow-y-auto p-4 space-y-3">
                @if($notifications->count() > 0)
                    @foreach($notifications as $notification)
                        <a href="{{ $notification->request_id ? route('admin.noc.' . $notification->type . '.show', $notification->request_id) : route('admin.noc.' . $notification->type) }}" class="block">
                            <div class="cursor-pointer p-3 rounded-md border {{ !$notification->is_read ? 'border-blue-300 bg-blue-50 dark:border-blue-600 dark:bg-blue-900/20' : 'border-white dark:border-gray-800' }} hover:bg-gray-100 dark:hover:bg-gray-700 flex items-start space-x-3">
<div class="flex-shrink-0 mt-1">
    <div class="w-3 h-3 rounded-full {{ !$notification->is_read ? 'bg-green-500' : 'bg-gray-300' }}"></div>
</div>
                            <div class="flex-1">
                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $notification->title }}</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-0.5">{{ $notification->message }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                            <div class="flex-shrink-0 self-start">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    @if($notification->type === 'instalasi') status-lainnya
                                    @elseif($notification->type === 'maintenance') status-selesai
                                    @elseif($notification->type === 'keluhan') status-proses
                                    @elseif($notification->type === 'terminasi') status-ditolak
                                    @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                    @endif">
                                    {{ ucfirst($notification->type) }}
                                </span>
                            </div>
                        </div>
                        </a>
                    @endforeach
                @else
                    <div class="text-center text-gray-500 dark:text-gray-400 mt-10">
                        No notifications found.
                    </div>
                @endif
            </div>

            @if($notifications->count() > 0)
                <div class="px-4 py-3 border-t border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700 flex items-center justify-between">
                    <button wire:click="markAllAsRead" class="text-sm font-medium text-blue-600 hover:text-blue-500 dark:text-blue-400 dark:hover:text-blue-300">
                        Mark all as read
                    </button>
                    <span class="text-xs text-gray-500 dark:text-gray-400">
                        {{ $notifications->count() }} notifications
                    </span>
                </div>
            @endif
        </div>
    @endif
</div>
