<?php

namespace App\Livewire\Connections;

use App\Models\User;
use Livewire\Component;

class Index extends Component
{
    public $usersCache;

    public $localUser;

    public $search = '';

    public function mount()
    {
        $this->usersCache = User::all();
        $this->localUser = User::find(auth()->id());
    }

    public function render()
    {
        $users = User::query()
            ->where('id', '<>', auth()->id())
            ->when($this->search, function ($q) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($this->search).'%']);
            })
            ->get();

        $requests = $this->localUser->getPendingRequests();

        return view('livewire.connections.index', [
            'users' => $users,
            'requests' => $requests,
        ]);
    }
}
