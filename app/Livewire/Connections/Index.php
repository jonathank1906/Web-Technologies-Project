<?php

namespace App\Livewire\Connections;

use App\Models\Block;
use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['refreshNotifications' => '$refresh'];

    public $search = '';

    public function render()
    {   
        if (auth()->user()) {
            // Get IDs of users who blocked the current user
            $usersWhoBlockedMe = Block::where('blocked_id', auth()->id())
                ->pluck('blocker_id')
                ->toArray();

            $users = User::query()
                ->where('id', '<>', auth()->id())
                ->whereNotIn('id', $usersWhoBlockedMe)
                ->when($this->search, function ($q) {
                    $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%']);
                 })
                ->get();
            
            $notifications = auth()->user()
                ->getNotifications()
                ->with('sender')
                ->latest()
                ->get();
        }
        else {
            $users = User::query()
                ->when($this->search, function ($q) {
                    $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%']);
                })
                ->get();

            $notifications = collect();
        }
        


        return view('livewire.connections.index', [
            'users' => $users,
            'notifications' => $notifications,
        ]);
    }
}
