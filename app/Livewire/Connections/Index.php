<?php

namespace App\Livewire\Connections;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public $search = '';
    public function render()
    {
        $users = User::query()
            ->where('id', '<>', auth()->id())
            ->when($this->search, function ($q) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($this->search).'%']);
            })
            ->get();

        $notifications = collect();

        return view('livewire.connections.index', [
            'users' => $users,
            'notifications' => $notifications,
        ]);
    }
}
