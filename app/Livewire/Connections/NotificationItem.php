<?php

namespace App\Livewire\Connections;

use App\Models\Notification;
use Livewire\Component;

class NotificationItem extends Component
{
    protected $listeners = ['openProfile', 'removeNotification', 'updateStatus'];

    public $notification;
    public $user;
    public $status = 'Offline';

    public function mount($notification = null)
    {
        $this->notification = $notification;
        $this->user = $notification->sender;
    }

    public function openProfile()
    {
        return redirect()->route('profile.show', ['user' => $this->user]);
    }

    public function removeNotification() {
        Notification::where('sender_id', $this->user->id)
        ->where('receiver_id', auth()->id())
        ->delete();

        $this->dispatch('refreshNotifications');
    }

    public function updateStatus($data)
    {
        $this->status = $data[$this->user->id] ?? 'Offline';
    }

    public function render()
    {
        return view('livewire.connections.notification-item');
    }
}
