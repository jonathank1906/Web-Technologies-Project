<?php

namespace App\Livewire\Connections;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    protected $listeners = ['refreshNotifications' => '$refresh'];

    public $search = '';

    public function render()
    {
        // ✅ Get users (everyone except the current user if logged in)
        $users = User::query()
            ->when(auth()->check(), fn($q) => $q->where('id', '<>', auth()->id()))
            ->when($this->search, function ($q) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($this->search) . '%']);
            })
            ->get();

        // ✅ Handle notifications safely for guests
        $notifications = collect(); // empty collection by default

        if (auth()->check()) {
            $notifications = auth()->user()
                ->getNotifications()
                ->with('sender')
                ->latest()
                ->get();
        }

        return view('livewire.connections.index', [
            'users' => $users,
            'notifications' => $notifications,
        ]);
    }
}
