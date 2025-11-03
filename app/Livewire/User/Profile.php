<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Models\Connection;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Profile extends Component
{
    public User $user;
    public $connectionStatus = null;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->loadConnectionStatus();
    }

    public function loadConnectionStatus()
    {
        $connection = Connection::where(function ($query) {
            $query->where('sender_id', Auth::id())
                  ->where('receiver_id', $this->user->id);
        })->orWhere(function ($query) {
            $query->where('sender_id', $this->user->id)
                  ->where('receiver_id', Auth::id());
        })->first();

        $this->connectionStatus = $connection ? $connection->status : null;
    }

    public function follow()
    {
        if (Auth::id() === $this->user->id) return;

        Connection::updateOrCreate([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->user->id,
        ], [
            'status' => 'pending'
        ]);

        $this->loadConnectionStatus();
        $this->dispatch('connection-updated');
    }

    public function message()
    {
        return redirect()->route('messages', ['user' => $this->user->id]);
    }

    public function render()
    {
        // Eager load relationships for counts
        $this->user->loadCount(['posts', 'followers', 'following']);
        
        return view('livewire.user.profile', [
            'isFollowing' => $this->connectionStatus === 'accepted',
            'isPending' => $this->connectionStatus === 'pending',
        ]);
    }
}