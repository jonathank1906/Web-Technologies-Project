<?php

namespace App\Livewire\Connections;

use App\Models\User;
use Livewire\Component;
use App\Models\Connection;
use Illuminate\Support\Facades\Auth;

class Index extends Component
{
    public $query = '';
    public $search = '';  // Add this for the search functionality
    public function render()
    {
        $users = User::query()
            ->where('id', '<>', auth()->id())
            ->when($this->search, function ($q) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($this->search).'%']);
            })
            ->get();

        $requests = collect();

        return view('livewire.connections.index', [
            'users' => $users,
            'requests' => $requests,
        ]);
    }
}
