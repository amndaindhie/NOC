<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\NocNotification;

class NotificationSidePanel extends Component
{
    public $showPanel = false;
    public $notifications = [];
    public $unreadCount = 0;
    public $filterType = 'all';

    protected $listeners = [
        'toggleNotificationPanel' => 'togglePanel',
    ];

    public function mount()
    {
        $this->loadNotifications();
    }

    public function togglePanel()
    {
        $this->showPanel = !$this->showPanel;
        if ($this->showPanel) {
            $this->loadNotifications();
        }
    }

    public function setFilter($type)
    {
        $this->filterType = $type;
        $this->loadNotifications();
    }

    public function loadNotifications()
    {
        $query = NocNotification::orderBy('created_at', 'desc');

        if ($this->filterType !== 'all') {
            $query->where('type', $this->filterType);
        }

        $this->notifications = $query->take(20)->get();

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
            $this->dispatch('notificationUpdated');
        }
    }

    public function markAllAsRead()
    {
        NocNotification::where('is_read', false)->update([
            'is_read' => true,
            'read_at' => now()
        ]);
        $this->loadNotifications();
        $this->dispatch('notificationUpdated');
    }

    public function markAsReadAndRedirect($notificationId, $type)
    {
        $notification = NocNotification::find($notificationId);
        if ($notification) {
            $notification->update([
                'is_read' => true,
                'read_at' => now()
            ]);
            $this->loadNotifications();
            $this->dispatch('notificationUpdated');

            // Redirect to the specific show page if request_id exists, otherwise to the general table
            if ($notification->request_id) {
                return redirect()->route('admin.noc.' . $type . '.show', $notification->request_id);
            } else {
                // For types without request_id, redirect to general table
                return redirect()->route('admin.noc.' . $type);
            }
        }

        // Fallback to general table if notification not found
        return redirect()->route('admin.noc.' . $type);
    }

    public function render()
    {
        return view('livewire.admin.notification-side-panel');
    }
}
