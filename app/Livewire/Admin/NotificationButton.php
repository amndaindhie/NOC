<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\NocNotification;

class NotificationButton extends Component
{
    public $unreadCount = 0;

    protected $listeners = [
        'notificationUpdated' => 'updateUnreadCount',
    ];

    public function mount()
    {
        $this->updateUnreadCount();
    }

    public function updateUnreadCount()
    {
        $this->unreadCount = NocNotification::where('is_read', false)->count();
    }

    public function render()
    {
        return view('livewire.admin.notification-button');
    }
}
