<?php

namespace App\Livewire\Connections;

use Livewire\Component;

class UserItem extends Component
{
    protected $listeners = ['openProfile'];

    public $user;

    public $name;

    public $description;

    public $l1;

    public $l2;

    public $country;

    public $avatar_url;

    public $status;

    public function mount($user)
    {
        $this->user = $user ?? '??';
        $this->name = $this->user->name ?? '??';
        $this->description = $this->user->description ?? '??';
        $this->l1 = $this->user->l1 ?? '??';
        $this->l2 = $this->user->l2 ?? '??';
        $this->country = $this->user->country ?? null;
        $this->avatar_url = $this->user->avatar_url ?? null;
        $this->status = $this->user->status ?? '??';
    }

    public function openProfile()
    {
        return redirect()->route('profile.show');
    }

    public function render()
    {
        return view('livewire.connections.user-item');
    }
}
