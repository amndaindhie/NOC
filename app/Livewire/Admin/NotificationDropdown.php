<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\NocNotification;
use Illuminate\Support\Facades\Auth;

class NotificationDropdown extends Component
{
    public $showDropdown = false;
    public $notifications = [];
    public $unreadCount = 0;

    public function mount()
    {
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $this->notifications = NocNotification::orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $this->unreadCount = NocNotification::where('is_read', false)->count();
    }

    public function markAsRead($notificationId)
    {
        $notification = NocNotification::find($notificationId);
        if ($notification) {
            $notification->update([
                'is_read' => true,
                'read_at' => now()
            ]);

            $this->loadNotifications();
        }
    }

    public function markAllAsRead()
    {
        NocNotification::where('is_read', false)->update([
            'is_read' => true,
            'read_at' => now()
        ]);

        $this->loadNotifications();
    }

    public function render()
    {
        return view('livewire.admin.notification-dropdown');
    }
}
