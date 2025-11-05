<?php

namespace App\Livewire\Connections;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class RequestItem extends Component
{
    protected $listeners = ['openProfile'];

    public $user;

    public $name;

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

    public function acceptRequest()
    {
        $connection = \App\Models\Connection::where('sender_id', $this->user)
            ->where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if ($connection) {
            $connection->update(['status' => 'accepted']);
            $this->dispatch('connection-updated');
        }
    }

    public function declineRequest()
    {
        $connection = \App\Models\Connection::where('sender_id', $this->user->id)
            ->where('receiver_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if ($connection) {
            $connection->update(['status' => 'declined']);
            $this->dispatch('connection-updated');
        }
    }

    public function render()
    {
        return view('livewire.connections.request-item');
    }
}
