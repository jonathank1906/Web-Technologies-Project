<?php

namespace App\Livewire\Connections;

use Livewire\Component;

class NotificationItem extends Component
{
    protected $listeners = ['openProfile'];

    public $user;

    public $language1;

    public $language2;

    public $status;

    public function mount($user = null)
    {
        $this->user = $user;
        $this->language1 = $user->language1 ?? '??';
        $this->language2 = $user->language2 ?? '??';
        $this->status = $user->status ?? 'No status';
    }

    public function openProfile()
    {
        return redirect()->route('profile.show', ['user' => $this->user]);
    }

    public function render()
    {
        return view('livewire.connections.notification-item');
    }
}
